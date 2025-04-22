<?php
namespace App\Services\Payments\Urway\SpecialOrder;

use App\Enums\OrderStatus;
use App\Models\SpecialOrder;
use App\Models\Transaction;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use URWay\Client;
class UrwayServices{
    /**
     * @param SpecialOrder $order
     * @return mixed
     */
    public static function generatePaymentUrl(
        $order
    ) : mixed {
        $data = [
            'trackid' => $order->id,
            'customer_email' => $order?->client?->email ?? "{$order->client_id }@saudidates.sa",
            "customer_ip" => request()->ip(),
            "currency" => 'SAR',
            "country" => 'SA',
            "amount" => $order->status == OrderStatus::READY_FOR30 ? ($order->total * 30 /100) : ($order->total * 70 /100),
            "redirect_url" => route('special-order-payment-callback'),
            "udf1" => $order->client_address_id ,
            "udf3" => 0,
            "udf4" => Config::get('app.locale'),
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
        SpecialOrder $order
    ) : mixed {
        $client = new Client();
        $client->setTrackId($request->TrackId)
            ->setAmount($request->amount)
            ->setCurrency('SAR');
        Log::channel("urway")->info("Urway callback request", ['request_data' => $request->toArray()]);
        return $client->find($request->TrakId);
    }
}
