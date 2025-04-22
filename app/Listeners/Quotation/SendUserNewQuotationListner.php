<?php

namespace App\Listeners\Quotation;

use App\Models\Vendor;
use App\Notifications\Vendor\SendQuotationFromUser;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

class SendUserNewQuotationListner
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
        try{
            $orderQuotation = $event->getOrderQuotation();
            $vendor = Vendor::find($orderQuotation->vendor_id);
            Notification::send($vendor,new SendQuotationFromUser($orderQuotation));
        }catch(\Exception $ex){
            Log::channel("order-events-errors")->error("Exception in AdminListener: ". $ex->getMessage());
        }
    }
}
