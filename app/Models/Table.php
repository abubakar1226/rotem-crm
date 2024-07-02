<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Query\Builder;

class Table extends Model
{
    use HasFactory;

    protected $fillable = [
        'table_name',
        'display_name',
        'description',
        'scrollX',
        'scrollY',
        'pageLength',
        'fixedColumnsStart',
        'fixedColumnsEnd',
        'paging',
        'ordering',
        'searchable',
        'table_id',
        'include_action_buttons',
    ];

    protected $casts = [
        'scrollX' => 'boolean',
        'paging' => 'boolean',
        'ordering' => 'boolean',
        'searchable' => 'boolean',
        'include_action_buttons' => 'boolean',
    ];

    protected array $configColumns = [
        'id',
        'scrollX',
        'scrollY',
        'paging',
        'ordering',
        'searchable',
        'pageLength',
        "JSON_OBJECT(
            'start', fixedColumnsStart,
            'end', fixedColumnsEnd
        ) AS fixedColumns",
        'include_action_buttons',
    ];

    public function scopeAsConfigs($query)
    {
        return $query->selectRaw(implode(', ', $this->configColumns));
    }

    public function columns(): HasMany
    {
        return $this->hasMany(Column::class);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class);
    }

    public function children(): HasMany
    {
        return $this->hasMany(self::class);
    }
}
