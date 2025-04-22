<?php

namespace App\Listeners\Orders\Created;

use App\Events\Orders\Created;
use App\Models\User;
use App\Models\Vendor;
use App\Notifications\Admin\CreateSampleOrderNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

class AdminListener
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
    public function handle(Created $event): void
    {
        try{
            $order = $event->getOrder();
            $vendor = Vendor::find($order->vendor_id);
            $admin = User::first();
            Notification::send([$admin,$vendor],new CreateSampleOrderNotification($order));
        }catch(\Exception $ex){
            Log::channel("order-events-errors")->error("Exception in AdminListener: ". $ex->getMessage());
        }
    }
}
