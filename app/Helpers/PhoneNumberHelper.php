<?php

namespace App\Helpers;

class PhoneNumberHelper
{
    public static function formatPhoneNumber($phoneNumber)
    {
        $phoneNumber = preg_replace('/\D/', '', $phoneNumber);
        return '+1 ' . substr($phoneNumber, 0, 3) . '-' . substr($phoneNumber, 3, 3) . '-' . substr($phoneNumber, 6);
    }
}
