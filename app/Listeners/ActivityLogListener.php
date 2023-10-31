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
            'log_message' => 'PaymentVerified'
        ],
        PaymentRejected::class => [
            'entity' => 'payment',
            'log_message' => 'PaymentRejected'
        ],
        CurrencyActivated::class => [
            'entity' => 'currency',
            'log_message' => 'CurrencyActivated'
        ],
        CurrencyDeactivated::class => [
            'entity' => 'currency',
            'log_message' => 'CurrencyDeactivated'
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
                ->log($this->eventsLogs[$eventClass]['log_message']);
        }
    }
}
