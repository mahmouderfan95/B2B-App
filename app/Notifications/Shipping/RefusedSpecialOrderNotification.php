<?php

namespace App\Notifications\Shipping;

use App\Models\ShippingQuotation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RefusedSpecialOrderNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public ShippingQuotation $shippingQuotation)
    {
        //
    }


    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toDatabase($notifiable){
        return [
            'title' => trans('shipping.notifications.refused.title'),
            'body' => trans('shipping.notifications.refused.body') . $this->shippingQuotation?->client?->name .
                trans('shipping.notifications.refused.body2') . $this->shippingQuotation->specialOrder->code,
        ];
    }


}
