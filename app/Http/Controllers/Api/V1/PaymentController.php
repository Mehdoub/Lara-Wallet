<?php

namespace App\Http\Controllers\Api\V1;

use App\Enums\Payment\Status;
use App\Events\PaymentRejectEvent;
use App\Events\PaymentVerifyEvent;
use App\Exceptions\BadRequestException;
use App\Exceptions\NotFoundException;
use App\Facades\Response;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\CreatePaymentRequest;
use App\Http\Resources\PaymentCollection;
use App\Http\Resources\PaymentResource;
use App\Models\Payment;
use App\Models\Transaction;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $payments = Payment::query()->paginate();

        return Response::message('Payment Found')->data(new PaymentCollection($payments))->send();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreatePaymentRequest $request)
    {
        $newPayment = Payment::create([
            'user_id' => 1,
            'amount' => $request->amount,
            'currency' => $request->currency,
            'type' => $request->type,
            'unique_id' => uniqid()
        ]);

        return Response::message('Payment Successfully Created')->data($newPayment)->send();
    }

    /**
     * Reject Created Pending Payment
     *
     * @param  Payment $payment
     * @return void
     */
    public function reject(Payment $payment)
    {
        if ($payment->status !== Status::PENDING) {
            throw new BadRequestException('Payment Status Already Has Been Changed');
        }

        if ($payment->status == Status::PENDING) {
            $payment->update([
                'status' => Status::REJECTED
            ]);

            PaymentRejectEvent::dispatch($payment);
        }

        return Response::message('Payment Successfully Rejected')->data($payment)->send();
    }

    /**
     * Verify Created Pending Payment
     *
     * @param  Payment $payment
     * @return void
     */
    public function verify(Payment $payment)
    {
        if ($payment->status !== Status::PENDING) {
            throw new BadRequestException('Payment Status Already Has Been Changed');
        }

        if ($payment->transaction) {
            throw new BadRequestException('This Payment Already Has a Transaction!');
        }

        $payment->update([
            'status' => Status::VERIFIED
        ]);

        $balance = Transaction::where('user_id', $payment->user_id)
            ->where('currency', $payment->currency)
            ->sum('amount');
        $balance += $payment->amount;

        Transaction::create([
            'user_id' => $payment->user_id,
            'payment_id' => $payment->id,
            'currency' => $payment->currency,
            'amount' => $payment->amount,
            'balance' => $balance
        ]);

        PaymentVerifyEvent::dispatch($payment);

        return Response::message('Payment Successfully Verified')->data($payment)->send();
    }

    /**
     * Return Payment with specifice ID.
     */
    public function find(Payment $payment)
    {
        if (!$payment) {
            throw new NotFoundException('Payment with this ID does not exist');
        }

        return Response::message('Payment Found')->data(new PaymentResource($payment))->send();
    }
}
