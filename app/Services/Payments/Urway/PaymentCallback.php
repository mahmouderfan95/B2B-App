<?php
namespace App\Services\Payments\Urway;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use URWay\Client as UrwayClient;

class PaymentCallback extends UrwayClient {
    public function __construct(
        private Request $request,
        private Transaction $transaction
    ) {
        parent::__construct();
    }

    public function __invoke() : mixed {
        $this->setTrackId($this->request->TrackId)
            ->setAmount($this->request->amount)
            ->setCurrency($this->transaction->addresses->country->currencyCountry->currency->getTranslation("code", "en") ?? Constants::currency);

        Log::channel("urway")->info("Urway callback request", ['request_data' => $this->request->toArray()]);
        return $this->find($this->request->TranId);
    }
}
