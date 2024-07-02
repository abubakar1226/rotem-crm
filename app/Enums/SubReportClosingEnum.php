<?php

namespace App\Enums;

/**
 * @method static self done()
 * @method static self estimate()
 * @method static self noAnswer()
 * @method static self customerCancelled()
 * @method static self priceDeclined()
 * @method static self twoXLead()
 * @method static self other()
 */
class SubReportClosingEnum extends Enum
{
    protected static function values(): array
    {
        return [
            'done' => 'Done',
            'estimate' => 'Estimate',
            'noAnswer' => 'No Answer',
            'customerCancelled' => 'Customer Cancelled',
            'priceDeclined' => 'Price Declined',
            'twoXLead' => '2x Lead',
            'other' => 'Other',
        ];
    }
}
