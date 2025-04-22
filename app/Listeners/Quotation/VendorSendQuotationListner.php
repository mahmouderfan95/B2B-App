<?php

namespace App\Listeners\Quotation;

use App\Models\Client;
use App\Notifications\Vendor\SendQuotationFromVendor;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class VendorSendQuotationListner
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        $orderQuotation = $event->getOrderQuotation();
        $client = Client::find($orderQuotation->client_id);
        Notification::send($client,new SendQuotationFromVendor($orderQuotation));
    }
}
