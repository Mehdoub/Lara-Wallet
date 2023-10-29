<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected static function booted()
    {
        static::created(function ($transaction) {
            $transaction->balance = Transaction::where('user_id', $transaction->user->id)
                ->where('currency_key', $transaction->currency->key)
                ->sum('amount');
            $transaction->save();
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function payment()
    {
        return $this->belongsTo(Payment::class, 'payment_id');
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class, 'currency_key', 'key');
    }

    public static function calcBalance($userId, $currencyKey)
    {
        return Transaction::where('user_id', $userId)
            ->where('currency_key', $currencyKey)
            ->sum('amount');
    }
}
