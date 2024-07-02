<?php

namespace App\Enums;

/**
 * @method static self appointmentSet()
 * @method static self noResponse()
 * @method static self noResponseTwice()
 * @method static self incorrectDetails()
 * @method static self notRelevant()
 * @method static self notClosed()
 */
class StatusEnum extends Enum
{
    protected static function values(): array
    {
        return [
            'appointmentSet' => 'Appointment Set',
            'noResponse' => 'No Response',
            'noResponseTwice' => 'No Response Twice',
            'incorrectDetails' => 'Incorrect Details',
            'notRelevant' => 'Not Relevant',
            'notClosed' => 'Not Closed',
        ];
    }
}
