<?php

namespace App\Models;

use App\Enums\TransferPayment\Status;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransferPayment extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $casts = [
        'status' => Status::class,
    ];

    public function fromUser()
    {
        return $this->belongsTo(User::class, 'from_user_id');
    }

    public function toUser()
    {
        return $this->belongsTo(User::class, 'to_user_id');
    }
}
