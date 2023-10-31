<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rate extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function currency()
    {
        return $this->belongsTo(Currency::class, 'currency_key', 'key');
    }

    public function rateCurrency()
    {
        return $this->belongsTo(Currency::class, 'rate_currency_key', 'key');
    }
}
