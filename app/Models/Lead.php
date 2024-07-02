<?php

namespace App\Models;

use App\Enums\PlatformEnum;
use App\Enums\StatusEnum;
use App\Services\SubReportCalculator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Lead extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone_number',
        'address',
        'city',
        'state',
        'post_code',
        'country',
        'status',
        'follow_up_at',
        'platform',
        'job_description',
    ];

    protected $casts = [
        'platform' => PlatformEnum::class
    ];

    public function getStatusAttribute($value): StatusEnum|null
    {
        return present($value) ? StatusEnum::from($value) : null;
    }

    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }

    public function refund(): HasOne
    {
        return $this->hasOne(Refund::class);
    }

    protected static function booted()
    {
        static::saved(function (Lead $lead) {
            if (in_array(
                $lead->status, [StatusEnum::appointmentSet(), StatusEnum::noResponse(), StatusEnum::noResponseTwice()])
            ) {
                $lead->refund?->delete();
            }
        });
    }
}
