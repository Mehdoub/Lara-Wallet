<?php

namespace App\Http\Controllers\Api\V1;

use App\Enums\Payment\Status;
use App\Events\PaymentRejected;
use App\Events\PaymentVerified;
use App\Events\TransactionUpdated;
use App\Exceptions\BadRequestException;
use App\Exceptions\NotFoundException;
use App\Facades\Response;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\CreatePaymentRequest;
use App\Http\Resources\PaymentCollection;
use App\Http\Resources\PaymentResource;
use App\Models\Payment;
use App\Models\Transaction;
use Carbon\Carbon;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $payments = Payment::query()->paginate();

        return Response::message(__('payment.messages.payment_list_found_successfully'))->data(new PaymentCollection($payments))->send();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreatePaymentRequest $request)
    {
        $recentDuplicatePaymentExists = Payment::query()->where([
            ['amount', $request->amount],
            ['currency_id', $request->currency_id],
            ['created_at', '>', Carbon::now()->subMinutes(5)]
        ])->first();

        if ($recentDuplicatePaymentExists) throw new BadRequestException(__('payment.messages.duplicate_payment_exists', [
            'amount' => $recentDuplicatePaymentExists->amount,
            'currency' => $recentDuplicatePaymentExists->currency->name,
        ]));

        $newPayment = Payment::create([
            'user_id' => auth()->user()->id,
            'amount' => $request->amount,
            'currency_id' => $request->currency_id,
            'type' => $request->type,
            'unique_id' => uniqid()
        ]);

        return Response::message(__('payment.messages.payment_successfuly_created'))->data($newPayment)->send();
    }

    /**
     * Reject Created Pending Payment
     *
     * @param  Payment $payment
     * @return void
     */
    public function reject($id)
    {
        $payment = Payment::find($id);

        if (!$payment) {
            throw new NotFoundException(__('payment.errors.payment_notfound'));
        }

        if ($payment->status !== Status::PENDING) {
            throw new BadRequestException(__('payment.errors.you_can_only_decline_pending_payments'));
        }

        if ($payment->status == Status::PENDING) {
            $payment->update([
                'status' => Status::REJECTED,
                'status_updated_at' => Carbon::now(),
                'status_updated_by' => auth()->user()->id,
            ]);

            PaymentRejected::dispatch($payment);
        }

        return Response::message(__('payment.messages.the_payment_was_successfully_rejected'))->data($payment)->send();
    }

    /**
     * Verify Created Pending Payment
     *
     * @param  Payment $payment
     * @return void
     */
    public function verify($id)
    {
        $payment = Payment::find($id);

        if (!$payment) {
            throw new NotFoundException(__('payment.errors.payment_notfound'));
        }

        if ($payment->status !== Status::PENDING) {
            throw new BadRequestException('Payment Status Already Has Been Changed');
        }

        if ($payment->transaction) {
            throw new BadRequestException('This Payment Already Has a Transaction!');
        }

        if (!$payment->currency->is_active) {
            throw new BadRequestException(__('currency.errors.currency_is_not_active'));
        }

        $payment->update([
            'status' => Status::VERIFIED,
            'status_updated_at' => Carbon::now(),
            'status_updated_by' => auth()->user()->id,
        ]);

        $balance = Transaction::calcBalance($payment->user_id, $payment->currency_id);
        $balance += $payment->amount;

        $transaction = Transaction::create([
            'user_id' => $payment->user_id,
            'payment_id' => $payment->id,
            'currency_id' => $payment->currency_id,
            'amount' => $payment->amount,
            'balance' => $balance
        ]);

        TransactionUpdated::dispatch($transaction);

        PaymentVerified::dispatch($payment);

        return Response::message('Payment Successfully Verified')->data($payment)->send();
    }

    /**
     * Return Payment with specifice ID.
     */
    public function find($id)
    {
        $payment = Payment::find($id);

        if (!$payment) {
            throw new NotFoundException(__('payment.errors.payment_notfound'));
        }

        return Response::message(__('payment.messages.payment_successfuly_found'))
            ->data(new PaymentResource($payment))
            ->send();
    }
}
