<?php

namespace App\Notifications\Vendor;

use App\Models\OrderQuotation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendQuotationFromVendor extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public OrderQuotation $orderQuotation)
    {
        //
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable){
        return [
            'title' => trans('admin.quotations.title'),
            'body' => trans('admin.quotations.vendor_body') . $this->orderQuotation?->vendor?->name,
        ];
    }
}
