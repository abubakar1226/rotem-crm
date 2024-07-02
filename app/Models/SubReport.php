<?php

namespace App\Models;

use App\Casts\AmountInCents;
use App\Enums\SubReportClosingEnum;
use App\Enums\PaymentMethods;
use App\Services\SubReportCalculator;
use Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SubReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'job_total',
        'payment_method',
        'closing',
        'technician_materials_cost',
        'company_materials_cost',
        'technician_profit',
        'technician_balance',
        'company_balance',
        'technician_share_percentage',
        'company_share_percentage',
        'appointment_id',
    ];

    protected $casts = [
        'job_total' => AmountInCents::class,
        'technician_materials_cost' => AmountInCents::class,
        'company_materials_cost' => AmountInCents::class,
        'technician_profit' => 'integer',
        'technician_balance' => 'integer',
        'company_balance' => 'integer',
    ];

    public function getPaymentMethodAttribute($value): PaymentMethods|null
    {
        return present($value) ? PaymentMethods::from($value) : null;
    }

    protected function getClosingAttribute($value): SubReportClosingEnum|null
    {
        return present($value) ? SubReportClosingEnum::from($value) : null;
    }

    protected static function booted()
    {
        static::saving(function (SubReport $appointmentReport) {
            $appointmentReport = SubReportCalculator::calculate($appointmentReport);
        });
    }

    public function appointment(): BelongsTo
    {
        return $this->belongsTo(Appointment::class);
    }
}
