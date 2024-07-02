<?php

namespace App\Enums;

/**
 * @method static self card()
 * @method static self cash()
 * @method static self check()
 * @method static self zelle()
 * @method static self other()
 */
class PaymentMethods extends Enum
{
    protected static function values(): array
    {
        return [
             'card' => 'Card',
             'cash' => 'Cash',
             'check' => 'Check',
             'zelle' => 'Zelle',
             'other' => 'Other',
        ];
    }
}
