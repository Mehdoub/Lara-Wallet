<?php

namespace App\Listeners;

use App\Events\TransactionUpdated;
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
    public function handle(TransactionUpdated $event): void
    {
        $userBalance = $event->transaction->user->balance;
        $userBalance[$event->transaction->currency_key] = $event->transaction->balance;

        $event->transaction->user()->update([
            'balance' => $userBalance
        ]);
    }
}
