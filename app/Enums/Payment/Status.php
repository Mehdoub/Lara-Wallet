<?php

namespace App\Enums\Payment;

use App\Enums\EnumBase;

enum Status : string
{
    use EnumBase;

    case REJECTED = 'rejected';
    case PENDING = 'pending';
    case VERIFIED = 'verified';
}
