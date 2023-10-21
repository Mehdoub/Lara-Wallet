<?php

namespace App\Http\Controllers\Api\V1;

use App\Enums\TransferPayment\Status;
use App\Events\UpdateTransactionEvent;
use App\Exceptions\BadRequestException;
use App\Facades\Response;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\StoreTransferPaymentRequest;
use App\Models\Transaction;
use App\Models\TransferPayment;
use Illuminate\Support\Facades\DB;

class TransferPaymentController extends Controller
{
    public function store(StoreTransferPaymentRequest $request)
    {
        $newTransferPayment = TransferPayment::create([
            'from_user_id' => $request->from_user_id,
            'to_user_id' => $request->to_user_id,
            'amount' => $request->amount,
            'currency_id' => $request->currency_id,
        ]);

        DB::beginTransaction();

        $fromUserBalance = Transaction::calcBalance($newTransferPayment->from_user_id, $newTransferPayment->currency_id);
        if (
            !$fromUserBalance
            or $fromUserBalance < $newTransferPayment->amount
        ) {
            $newTransferPayment->update([
                'status' => Status::FAILED,
            ]);
            throw new BadRequestException(__('payment.errors.not_enough_balance'));
        }

        $fromUserBalance += $newTransferPayment->amount * -1;
        $withdrawTransaction = Transaction::create([
            'user_id' => $newTransferPayment->from_user_id,
            'transfer_payment_id' => $newTransferPayment->id,
            'currency_id' => $newTransferPayment->currency_id,
            'amount' => $newTransferPayment->amount * -1,
            'balance' => $fromUserBalance,
        ]);
        UpdateTransactionEvent::dispatch($withdrawTransaction);

        $toUserBalance = Transaction::calcBalance($newTransferPayment->to_user_id, $newTransferPayment->currency_id);
        $toUserBalance += $newTransferPayment->amount;
        $depositTransaction = Transaction::create([
            'user_id' => $newTransferPayment->to_user_id,
            'transfer_payment_id' => $newTransferPayment->id,
            'currency_id' => $newTransferPayment->currency_id,
            'amount' => $newTransferPayment->amount,
            'balance' => $toUserBalance,
        ]);
        UpdateTransactionEvent::dispatch($depositTransaction);

        $newTransferPayment->update([
            'status' => Status::TRANSFERRED,
        ]);

        DB::commit();

        return Response::message(__('payment.messages.balance_transferred'))->send();
    }
}
