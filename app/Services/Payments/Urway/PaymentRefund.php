<?php
namespace App\Services\Payments\Urway;

use App\Enums\OrderStatus;
use App\Enums\PaymentMethods;
use App\Models\Order;
use Exception;
use Illuminate\Support\Facades\Log;
use URWay\Client as UrwayClient;
use URWay\Response;

class PaymentRefund extends UrwayClient {
    public function __construct(
        private Order $order
    ) {
        try {
            if (
                !in_array($this->order->status, [OrderStatus::REGISTERD, OrderStatus::PAID])
            ) throw new Exception("Order status is missed (must be registered or paid to do a payment refund)");
            if (!$this->order->urwayTransaction)
                throw new Exception("Urway Transaction is missed (must exists in our system to do a payment refund)");
            if ($this->order->urwayTransaction->status == Constants::refund)
                throw new Exception("Urway Transaction is already refunded before");
        } catch (Exception $e) {
            Log::channel("urway")->info("Urway refund request exception at ourside: {$e->getMessage()}");
            throw $e;
        }

        parent::__construct();
    }

    /**
     * @return bool
     * @throws Exception
     */
    public function __invoke() : bool {
        $response = $this->refund();

        Log::channel("urway")->info(
            "Urway refund request from ourside",
            ['request_data' => $this->attributes, 'response_data' => (array)$response]
        );

        if ($response->result == Constants::inquirySuccess) {
            $this->order->urwayTransaction->update(['status' => Constants::refund]);
            return true;
        }
        $urwayRefundRefuseMsg = $this->mapCodeToMessage($response->responseCode ?? "");
        Log::channel("urway")->info("Urway refund request unprocessable: $urwayRefundRefuseMsg");
        throw new Exception($urwayRefundRefuseMsg);
    }

    // copied from pay function at package src code
    private function refund() {
        $this->setTrackId($this->order->id)
            ->setAmount($this->order->total)
            ->setCustomerIp(request()->ip())
            ->setCurrency(Constants::currency);

        // According to documentation we have to send the `terminal_id`, and `password` now.
        $this->setAuthAttributes();

        // We have to generate request
        $this->generateRequestHash();

        $this->attributes['action'] = "2";
        $this->attributes['transid'] = $this->order->urwayTransaction->urway_payment_id;

        try {
            $response = $this->guzzleClient->request(
                $this->method,
                $this->getEndPointPath(),
                ['json' => $this->attributes]
            );

            return new Response((string) $response->getBody());
        } catch (\Throwable $e) {
            throw new Exception($e->getMessage());
        }
    }

    private function mapCodeToMessage(string $code) : string {
        return match($code) {
            "319" => "Refund Limit exceeds for Terminal",
            "320" => "Refund Limit exceeds for Merchant",
            "321" => "Refund Limit exceeds for Institution",
            "5N3" => "Maximum online refund reached",
            "5N4" => "Maximum off-line refund reached",
            "5N5" => "Maximum credit per refund",
            "5N6" => "Maximum refund credit reached",
            "5N9" => "Maximum number refund credits",
            "628" => "Transaction has not been Captured/Purchase, Refund not allowed",
            "629" => "Refund Amount exceeds the Captured/Purchase Amount.",
            "633" => "Transaction already Refunded, Duplicate refund not allowed",
            "634" => "Transaction is Void, Refund not allowed.",
            "640" => "Refund transaction in progress, Cannot process duplicate transaction",
            "644" => "Transaction is fully refunded, refund not allowed",
            "645" => "Transaction is chargeback transaction, refund not allowed",
            "646" => "Transaction is chargeback transaction, refund amount exceeds allowed amoun",
            "646" => "Transaction is chargeback transaction, refund amount exceeds allowed amoun",
            "670" => "Transaction has been Refunded, Void Purchase not allowed",
            "671" => "Void Purchase not allowed for PreAuth Transaction",
            "672" => "Transaction is Purchase, Void Refund not allowed",
            "673" => "Transaction is Pre-Auth, Void Refund not allowed",
            "674" => "Transaction is Void Purchase, Void Refund not allowed",
            "675" => "Transaction is Capture, Void Refund not allowed",
            "676" => "Transaction is Void Auth, Void Refund not allowed",
            "678" => "Void Refund not allowed, Mismatch in Void Refund and Original Refund Transaction Amount",
            "932" => "Excessive refund not enabled Terminal level",
            "933" => "Excessive refund amount limit not set Terminal level",
            default => "Unkown message from gateway",
        };
    }
}
