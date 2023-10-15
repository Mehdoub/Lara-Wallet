<?php

namespace App\Listeners;

use App\Events\PaymentRejectEvent;
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
    public function handle(PaymentRejectEvent $event): void
    {
        SendPaymentRejectedEmailJob::dispatch($event->payment->user, 'Payment ' . $event->payment->id . ' Rejected');
    }
}
