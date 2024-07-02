<?php

namespace App\Enums;

use Spatie\Enum\Laravel\Enum as BaseEnum;

class Enum extends BaseEnum
{
    public static function random()
    {
        $values = static::toArray();
        return $values[array_rand($values)];
    }
}
