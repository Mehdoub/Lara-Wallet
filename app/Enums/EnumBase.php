<?php

namespace App\Enums;

trait EnumBase
{
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
