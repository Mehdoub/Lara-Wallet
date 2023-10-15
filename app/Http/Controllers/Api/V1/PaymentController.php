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
use Illuminate\Http\Request;

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
        $msg = 'Payment Status Already Has Been Changed';

        if ($payment->status == Status::PENDING) {
            $payment->update([
                'status' => Status::REJECTED
            ]);

            $msg = 'Payment Successfully Rejected';

            PaymentRejectEvent::dispatch($payment);
        }

        return Response::message($msg)->data($payment)->send();
    }

    /**
     * Verify Created Pending Payment
     *
     * @param  Payment $payment
     * @return void
     */
    public function verify(Payment $payment)
    {
        $msg = 'Payment Status Already Has Been Changed';
        if ($payment->status == Status::PENDING) {
            $payment->update([
                'status' => Status::VERIFIED
            ]);

            PaymentVerifyEvent::dispatch($payment);

            $msg = 'Payment Successfully Verified';
        }

        return Response::message($msg)->data($payment)->send();
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
