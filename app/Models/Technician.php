<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Helpers\PhoneNumberHelper;

class Technician extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'phone_number',
        'email',
    ];

    public function getPhoneNumberAttribute($value)
    {
        return PhoneNumberHelper::formatPhoneNumber($value);
    }
}
