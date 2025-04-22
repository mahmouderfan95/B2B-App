<?php

namespace App\Notifications\Admin;

use App\Models\Order;
use App\Models\SpecialOrder;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class UpdateSpecialOrderStatusNotifications extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public SpecialOrder $order)
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable){
        return [
            'title' => trans('admin.order-notifications.update.title'),
            'body' => trans('admin.order-notifications.update.body') . $this->order->status,
        ];
    }
}
