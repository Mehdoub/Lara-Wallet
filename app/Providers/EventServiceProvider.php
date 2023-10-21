<?php

namespace App\Providers;

use App\Events\PaymentRejectEvent;
use App\Events\PaymentVerifyEvent;
use App\Events\UpdateTransactionEvent;
use App\Listeners\SendPaymentRejectedEmailListener;
use App\Listeners\SendPaymentVerifiedEmailListener;
use App\Listeners\UpdateUserBalanceListener;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        PaymentRejectEvent::class => [
            SendPaymentRejectedEmailListener::class
        ],
        PaymentVerifyEvent::class => [
            SendPaymentVerifiedEmailListener::class
        ],
        UpdateTransactionEvent::class => [
            UpdateUserBalanceListener::class,
        ]
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
