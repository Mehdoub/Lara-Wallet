<?php

namespace App\Http\Controllers\Api\V1;

use App\Contracts\Interfaces\Controllers\Api\V1\PaymentControllerInterface;
use App\Enums\Payment\PaymentStatus;
use App\Events\PaymentRejected;
use App\Events\PaymentVerified;
use App\Events\TransactionUpdated;
use App\Exceptions\BadRequestException;
use App\Facades\Response;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\CreatePaymentRequest;
use App\Http\Resources\PaymentCollection;
use App\Http\Resources\PaymentResource;
use App\Models\Payment;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller implements PaymentControllerInterface
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $payments = Payment::query()->paginate(config('settings.global.pagination'));

        return Response::message(__('payment.messages.payment_list_found_successfully'))
            ->data(new PaymentCollection($payments))
            ->send();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreatePaymentRequest $request)
    {
        $recentDuplicatePaymentExists = Payment::query()->where([
            ['amount', $request->amount],
            ['currency_key', $request->currency_key],
            ['created_at', '>', Carbon::now()->subMinutes(5)]
        ])->first();

        if ($recentDuplicatePaymentExists) {
            throw new BadRequestException(__('payment.messages.duplicate_payment_exists', [
                'amount' => $recentDuplicatePaymentExists->amount,
                'currency' => $recentDuplicatePaymentExists->currency->name,
            ]));
        }

        $newPayment = Payment::create([
            'user_id' => auth()->user()->id,
            'amount' => $request->amount,
            'currency_key' => $request->currency_key,
        ]);

        return Response::message(__('payment.messages.payment_successfully_created'))
            ->data(new PaymentResource($newPayment))
            ->status(201)
            ->send();
    }

    /**
     * Reject Created Pending Payment
     *
     * @param  Payment $payment
     * @return void
     */
    public function reject(Payment $payment)
    {
        if ($payment->status !== PaymentStatus::PENDING) {
            throw new BadRequestException(__('payment.errors.you_can_only_decline_pending_payments'));
        }

        $payment->update([
            'status' => PaymentStatus::REJECTED,
            'status_updated_at' => Carbon::now(),
            'status_updated_by' => auth()->user()->id,
        ]);

        PaymentRejected::dispatch($payment);

        return Response::message(__('payment.messages.the_payment_was_successfully_rejected'))
            ->data(new PaymentResource($payment))
            ->send();
    }

    /**
     * Verify Created Pending Payment
     *
     * @param  Payment $payment
     * @return void
     */
    public function verify(Payment $payment)
    {
        if ($payment->status !== PaymentStatus::PENDING) {
            throw new BadRequestException(__('payment.errors.you_can_only_verify_pending_payments'));
        }

        if ($payment->transaction) {
            throw new BadRequestException(__('payment.errors.payment_has_transaction'));
        }

        if (!$payment->currency->is_active) {
            throw new BadRequestException(__('currency.errors.currency_is_not_active'));
        }

        DB::beginTransaction();
        $payment->update([
            'status' => PaymentStatus::VERIFIED,
            'status_updated_at' => Carbon::now(),
            'status_updated_by' => auth()->user()->id,
        ]);

        $transaction = Transaction::create([
            'user_id' => $payment->user_id,
            'payment_id' => $payment->id,
            'currency_key' => $payment->currency_key,
            'amount' => $payment->amount
        ]);

        TransactionUpdated::dispatch($transaction);
        PaymentVerified::dispatch($payment);
        DB::commit();

        return Response::message(__('payment.messages.payment_successfully_verified'))
            ->data(new PaymentResource($payment))
            ->send();
    }

    /**
     * Return Payment with specifice ID.
     */
    public function show(Payment $payment)
    {
        return Response::message(__('payment.messages.payment_successfuly_found'))
            ->data(new PaymentResource($payment))
            ->send();
    }

    /**
     * Soft Delete Given Pending Payment
     *
     * @param  Payment $payment
     * @return void
     */
    public function destroy(Payment $payment)
    {
        if ($payment->status !== PaymentStatus::PENDING) {
            throw new BadRequestException(__('payment.errors.cant_destroy_pending'));
        }

        $payment->delete();

        return Response::message(__('payment.messages.successfully_removed'))->send();
    }
}
