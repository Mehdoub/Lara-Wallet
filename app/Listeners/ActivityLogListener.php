<?php

namespace App\Listeners;

use App\Events\CurrencyActivated;
use App\Events\CurrencyDeactivated;
use App\Events\PaymentRejected;
use App\Events\PaymentVerified;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ActivityLogListener
{
    public $eventsLogs = [
        PaymentVerified::class => [
            'entity' => 'payment',
            'log_message' => 'Payment Verified'
        ],
        PaymentRejected::class => [
            'entity' => 'payment',
            'log_message' => 'Payment Rejected'
        ],
        CurrencyActivated::class => [
            'entity' => 'currency',
            'log_message' => 'Currency Activated'
        ],
        CurrencyDeactivated::class => [
            'entity' => 'currency',
            'log_message' => 'Currency Deactivated'
        ],
    ];

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
        $eventClass = get_class($event);
        if (in_array($eventClass, array_keys($this->eventsLogs))) {
            activity()
                ->on($event->{$this->eventsLogs[$eventClass]['entity']})
                ->by(auth()->user())
                ->event($eventClass)
                ->log($this->eventsLogs[$eventClass]['log_message']);
        }
    }
}
