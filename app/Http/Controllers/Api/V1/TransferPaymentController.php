<?php

namespace App\Http\Controllers\Api\V1;

use App\Enums\TransferPayment\Status;
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

        $fromUserBalance = (array) json_decode($newTransferPayment->fromUser->balance);

        if (
            !$fromUserBalance
            or !isset($fromUserBalance[$newTransferPayment->currency_id])
            or $fromUserBalance[$newTransferPayment->currency_id] < $newTransferPayment->amount
        ) {
            $newTransferPayment->update([
                'status' => Status::FAILED,
            ]);
            throw new BadRequestException(__('payment.errors.not_enough_balance'));
        }

        DB::beginTransaction();

        $newTransferPayment->fromUser()->lockForUpdate();
        $newTransferPayment->toUser()->lockForUpdate();

        $fromUserUpdatedBalance = Transaction::where('user_id', $newTransferPayment->from_user_id)
            ->where('currency_id', $newTransferPayment->currency_id)
            ->sum('amount');
        $fromUserUpdatedBalance += $newTransferPayment->amount * -1;

        Transaction::create([
            'user_id' => $newTransferPayment->from_user_id,
            'transfer_payment_id' => $newTransferPayment->id,
            'currency_id' => $newTransferPayment->currency_id,
            'amount' => $newTransferPayment->amount * -1,
            'balance' => $fromUserUpdatedBalance,
        ]);

        $fromUserBalance[$newTransferPayment->currency_id] = $fromUserUpdatedBalance;

        $newTransferPayment->fromUser()->update([
            'balance' => json_encode($fromUserBalance)
        ]);

        $toUserUpdatedBalance = Transaction::where('user_id', $newTransferPayment->to_user_id)
            ->where('currency_id', $newTransferPayment->currency_id)
            ->sum('amount');
        $toUserUpdatedBalance += $newTransferPayment->amount;

        $toUserBalance = (array) json_decode($newTransferPayment->toUser->balance);
        if ($toUserBalance) $toUserBalance[$newTransferPayment->currency_id] = $toUserUpdatedBalance;
        else $toUserBalance[$newTransferPayment->currency_id] = $toUserUpdatedBalance;

        Transaction::create([
            'user_id' => $newTransferPayment->to_user_id,
            'transfer_payment_id' => $newTransferPayment->id,
            'currency_id' => $newTransferPayment->currency_id,
            'amount' => $newTransferPayment->amount,
            'balance' => $toUserUpdatedBalance,
            'is_transferpayment' => true,
        ]);

        $newTransferPayment->toUser()->update([
            'balance' => json_encode($toUserBalance)
        ]);

        $newTransferPayment->update([
            'status' => Status::TRANSFERRED,
        ]);

        DB::commit();

        return Response::message(__('payment.messages.balance_transferred'))->send();
    }
}
