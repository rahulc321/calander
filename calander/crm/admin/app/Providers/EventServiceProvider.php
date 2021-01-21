<?php

namespace App\Providers;


use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\SomeEvent' => [
            'App\Listeners\EventListener',
        ],
        'js.transform' => [
            'App\Listeners\JsTransformer'
        ],
        'user.saved' => [
            'App\Listeners\Users\SendConfirmationEmail',

        ],
        'product.saved' => [
            \App\Listeners\Products\UpdateVariants::class,
        ],
        'order.placed' => [
            'App\Listeners\Orders\SendConfirmationEmail',
            \App\Listeners\Orders\DecreaseStock::class
        ],
        'order.shipped' => [
            \App\Listeners\Orders\UpdateStockAfterShipping::class,
            \App\Listeners\Orders\CreateInvoice::class,
            \App\Listeners\Orders\AttachRefund::class,
            \App\Listeners\Orders\ShippedEmail::class,
        ],
        'withdraw.saved' => [
            'App\Listeners\Withdraws\SendConfirmationEmail',
        ],
        'withdraw.status-changed' => [
            'App\Listeners\Withdraws\StatusChanged',
        ],
        'workpaper.softwaredata.saved' => [
            'App\Listeners\Workpapers\SoftwareDataSaved',
        ],
        'creditnote.approved' => [
            \App\Listeners\CreditNotes\SendApprovedEmail::class
        ],
        'creditnote.declined' => [
            \App\Listeners\CreditNotes\SendDeclinedEmail::class
        ]
    ];

    /**
     * Register any other events for your application.
     *
     * @param  \Illuminate\Contracts\Events\Dispatcher  $events
     * @return void
     */
    public function boot(DispatcherContract $events)
    {
        parent::boot($events);

        //
    }
}
