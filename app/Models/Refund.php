<?php

namespace App\Models;

use App\Enums\RefundStatusEnum;
use App\Enums\StatusEnum;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Refund extends Model
{
    use HasFactory;

    protected $fillable = [
        'lead_status',
        'employee_id',
        'message',
        'description',
        'lead_id',
        'status',
    ];

    protected $casts = [
        'lead_status' => StatusEnum::class,
    ];

    protected $with = [
        'lead'
    ];

    public function getStatusAttribute($value)
    {
        return present($value) ? RefundStatusEnum::from($value) : null;
    }

    public function lead(): BelongsTo
    {
        return $this->belongsTo(Lead::class);
    }
}
