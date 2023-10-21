<?php

namespace App\Enums\TransferPayment;

use App\Enums\EnumBase;

enum Status: string
{
    use EnumBase;

    case PENDING = 'pending';
    case TRANSFERRED = 'transferred';
    case FAILED = 'failed';
}
