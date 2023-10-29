<?php

namespace App\Models;

use App\Enums\Payment\PaymentStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = ['id'];
    protected $casts = [
        'status' => PaymentStatus::class,
    ];

    public function getRouteKeyName()
    {
        return 'unique_id';
    }

    protected static function booted()
    {
        static::creating(function($payment) {
            $payment->unique_id = uniqid();
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function transaction()
    {
        return $this->hasOne(Transaction::class, 'payment_id');
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class, 'currency_key', 'key');
    }
}
