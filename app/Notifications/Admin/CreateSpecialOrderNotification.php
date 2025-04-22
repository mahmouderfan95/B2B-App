<?php

namespace App\Notifications\Admin;

use App\Models\Order;
use App\Models\SpecialOrder;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CreateSpecialOrderNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public $order;
    public function __construct(SpecialOrder $order)
    {
        $this->order = $order;
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
            'title' => trans('admin.order-notifications.title'),
            'body' => trans('admin.order-notifications.body') . $this->order->code,
        ];
    }
}
