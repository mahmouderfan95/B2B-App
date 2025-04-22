<?php

namespace App\Listeners\Orders\UpdateStatus;

use App\Events\Orders\UpdateStatus;
use App\Models\Client;
use App\Notifications\Admin\UpdateSampleOrderStatusNotifications;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

class ClientListener
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
    public function handle(UpdateStatus $event): void
    {
        try{
            $order = $event->getOrder();
            $client = Client::find($order->client_id);
            Notification::send($client,new UpdateSampleOrderStatusNotifications($order));
        }catch(\Exception $exception){
            Log::channel("order-events-errors")->error("Exception in AdminListener: ". $exception->getMessage());
        }
    }
}
