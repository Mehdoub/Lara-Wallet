<?php

namespace App\Http\Controllers\Api\V1;

use App\Enums\Payment\Status;
use App\Events\PaymentRejectEvent;
use App\Events\PaymentVerifyEvent;
use App\Facades\Response;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\CreatePaymentRequest;
use App\Jobs\SendEmailJob;
use App\Models\Payment;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $payments = Payment::query()->paginate();

        return response()->json([
            'message' => 'Payments Found',
            'data' => $payments,
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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

        return response()->json([
            'message' => 'Payment Successfully Created',
            'data' => $newPayment,
        ], 200);
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
     * Display the specified resource.
     */
    public function show(Payment $payment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Payment $payment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Payment $payment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Payment $payment)
    {
        //
    }
}
