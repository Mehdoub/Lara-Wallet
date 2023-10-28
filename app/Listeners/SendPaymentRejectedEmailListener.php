<?php

namespace App\Listeners;

use App\Events\PaymentRejected;
use App\Jobs\SendPaymentRejectedEmailJob;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendPaymentRejectedEmailListener
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
    public function handle(PaymentRejected $event): void
    {
        SendPaymentRejectedEmailJob::dispatch($event->payment->user, 'Payment ' . $event->payment->id . ' Rejected');
    }
}
