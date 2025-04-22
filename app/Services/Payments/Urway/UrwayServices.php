<?php
namespace App\Services\Payments\Urway;

use App\Enums\OrderStatus;
use App\Models\Order;
use App\Models\Transaction;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use URWay\Client;

class UrwayServices {
    private function calcAmount($order)
    {
        return $order->status == OrderStatus::READY_FOR30 ? ($order->total * 30 / 100) : ($order->total * 70 / 100);
    }
    /**
     * @param Order $order
     * @return mixed
     */
    public function generatePaymentUrl(
        $order
    ) : mixed {
        $data = [
            'trackid' => $order->id,
            'customer_email' => $order?->client?->email ?? "{$order->client_id }@saudidates.sa",
            "customer_ip" => request()->ip(),
            "currency" => 'SAR',
            "country" => 'SA',
            "amount" => $order->type == 'sample' ? $order->total : $this->calcAmount($order),
            "redirect_url" => route('payment-callback'),
            "udf1" => $order->client_address_id,
            "udf4" => 0,
            "udf3" => Config::get('app.locale'),
        ];
        $client = new Client();
        $client->setTrackId($data['trackid'])
            ->setCustomerEmail($data['customer_email'])
            ->setCustomerIp($data['customer_ip'])
            ->setCurrency($data['currency'])
            ->setCountry($data['country'])
            ->setAmount($data['amount'])
            ->setRedirectUrl($data['redirect_url'])
            ->setAttribute('udf1', $data['udf1'])
            ->setAttribute('udf3', $data['udf3'])
            ->setAttribute('udf4', $data['udf4']);
        $client->mergeAttributes(['action' => '1']);
        $data['action'] = "1";
        $response = $client->pay();
        Log::channel("urway")->info("Urway pay request from ourside", ['request_data' => $data, 'response_data' => (array)$response]);
        return $response;
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public static function paymentCallback(
        Request $request,
        Order $order
    ) : mixed {
        $client = new Client();
        $client->setTrackId($request->TrackId)
            ->setAmount($request->amount)
            ->setCurrency('SAR');
        Log::channel("urway")->info("Urway callback request", ['request_data' => $request->toArray()]);
        return $client->find($request->TrackId);
    }

    /**
     * @param Transaction $transaction
     * @return bool
     */
    public static function transactionInquiry(
        Transaction $transaction
    ) : bool {
        return (new PaymentInquiry($transaction))();
    }

    /**
     * @param Transaction $transaction
     * @return bool
     * @throws Exception
     */
    public static function transactionRefund(
        Order $order
    ) : bool {
        return (new PaymentRefund($order))();
    }
}
