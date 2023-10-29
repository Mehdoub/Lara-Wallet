<?php

namespace App\Enums\Payment;

use App\Enums\EnumBase;

enum PaymentStatus : string
{
    use EnumBase;

    case REJECTED = 'rejected';
    case PENDING = 'pending';
    case VERIFIED = 'verified';
}
