<?php

namespace App\Http\Controllers\Api\V1;

use App\Contracts\Interfaces\Controllers\Api\V1\CreditTransferControllerInterface;
use App\Events\TransactionUpdated;
use App\Exceptions\BadRequestException;
use App\Facades\Response;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\CreditTransferRequest;
use App\Models\CreditTransferLog;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;

class CreditTransferController extends Controller implements CreditTransferControllerInterface
{
    public function transfer(CreditTransferRequest $request)
    {
        DB::beginTransaction();

        $creditTransferLog = CreditTransferLog::create([
            'from_user_id' => $request->from_user_id,
            'to_user_id' => $request->to_user_id,
            'amount' => $request->amount,
            'currency_key' => $request->currency_key,
        ]);

        $creditTransferLog->fromUser->transactions()->lockForUpdate();
        $creditTransferLog->toUser->transactions()->lockForUpdate();

        $fromUserBalance = Transaction::calcBalance($request->from_user_id, $request->currency_key);
        if (
            !$fromUserBalance
            or $fromUserBalance < $request->amount
        ) {
            throw new BadRequestException(__('payment.errors.not_enough_balance'));
        }

        $withdrawTransaction = Transaction::create([
            'user_id' => $request->from_user_id,
            'currency_key' => $request->currency_key,
            'amount' => $request->amount * -1
        ]);
        TransactionUpdated::dispatch($withdrawTransaction);

        $depositTransaction = Transaction::create([
            'user_id' => $request->to_user_id,
            'currency_key' => $request->currency_key,
            'amount' => $request->amount
        ]);
        TransactionUpdated::dispatch($depositTransaction);

        $creditTransferLog->update([
            'withdraw_transaction_id' => $withdrawTransaction->id,
            'deposit_transaction_id' => $depositTransaction->id,
        ]);

        DB::commit();

        return Response::message(__('payment.messages.balance_transferred'))->send();
    }
}
