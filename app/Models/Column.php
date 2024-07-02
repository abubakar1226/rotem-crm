<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Column extends Model
{
    use HasFactory;

    protected $fillable = [
        'table_id',
        'name',
        'title',
        'visible',
        'orderable',
        'searchable',
        'width',
        'position',
    ];


    protected $casts = [
        'visible' => 'boolean',
        'orderable' => 'boolean',
        'searchable' => 'boolean',
    ];

    protected array $configColumns = [
        'table_id',
        'name',
        'name AS data',
        'title',
        'visible',
        'orderable',
        'searchable',
        'width',
        'position',
    ];

    public function scopeAsConfigs($query)
    {
        return $query->addSelect($this->configColumns)->orderBy('position', 'asc');
    }

    public function table(): HasOne
    {
        return $this->hasOne(Column::class);
    }

    public static function boot()
    {
        parent::boot();

        static::addGlobalScope('default_order_by', function (Builder $builder) {
            $builder->orderBy('position', 'asc');
        });
    }
}
