<?php

namespace App\Listeners;

use App\Events\PaymentVerified;
use App\Jobs\SendPaymentVerifiedEmailJob;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendPaymentVerifiedEmailListener
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
    public function handle(PaymentVerified $event): void
    {
        SendPaymentVerifiedEmailJob::dispatch($event->payment->user, 'Payment ' . $event->payment->id . ' Verified');
    }
}
