<?php

namespace App\Enums;

/**
 * @method static self Refunded()
 * @method static self RefundCancelled()
 */
class RefundStatusEnum extends Enum
{
    protected static function values(): array
    {
        return [
            'Refunded' => 'Refunded',
            'RefundCancelled' => 'Refund Cancelled',
        ];
    }
}
