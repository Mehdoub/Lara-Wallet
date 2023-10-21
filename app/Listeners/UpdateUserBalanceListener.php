<?php

namespace App\Listeners;

use App\Events\UpdateTransactionEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UpdateUserBalanceListener
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
    public function handle(UpdateTransactionEvent $event): void
    {
        $userBalance = (array) json_decode($event->transaction->user->balance);
        $userBalance[$event->transaction->currency_id] = $event->transaction->balance;

        $event->transaction->user()->update([
            'balance' => json_encode($userBalance)
        ]);
    }
}
