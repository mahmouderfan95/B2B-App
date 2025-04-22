<?php

namespace App\Providers;

use App\Events\Orders\Created;
use App\Events\Orders\UpdateStatus;
use App\Events\Quotation\SendUserNewQuotation;
use App\Events\Quotation\VendorSendQuotationToUser;
use App\Listeners\Orders\Created\AdminListener;
use App\Listeners\Orders\UpdateStatus\AdminListener as UpdateStatusAdminListener;
use App\Listeners\Orders\UpdateStatus\ClientListener;
use App\Listeners\Quotation\SendUserNewQuotationListner;
use App\Listeners\Quotation\VendorSendQuotationListner;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        Created::class => [
            AdminListener::class,
        ],
        UpdateStatus::class => [
            ClientListener::class,
        ],
        \App\Events\SpecialOrders\Created::class => [
            \App\Listeners\SpecialOrders\Created\AdminListener::class,
        ],
        \App\Events\SpecialOrders\UpdateStatus::class => [
            \App\Listeners\SpecialOrders\UpdateStatus\ClientListener::class,
        ],
        SendUserNewQuotation::class => [
            SendUserNewQuotationListner::class
        ],
        VendorSendQuotationToUser::class => [
            VendorSendQuotationListner::class
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
