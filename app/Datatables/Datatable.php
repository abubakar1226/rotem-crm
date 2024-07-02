<?php

namespace App\Datatables;

use App\DatatablePresenters\DatatablePresenterInterface;
use App\Models\Column;
use App\Models\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class Datatable implements DatatableInterface
{
    protected static string $tableName;
    protected Request $request;
    protected array $columns = [];
    protected array $whereClauses = [];
    protected string $search = '';
    protected int $start = 0;
    protected int $length = 10;
    protected string $orderColumn = 'id';
    protected string $orderDirection = 'asc';
    protected Model|Builder $query;

    public function __construct(Request $request, string $model)
    {
        $this->request = $request;
        $this->columns = $this->request->columns;
        $this->search = $this->request->search['value'] ?? '';
        $this->orderColumn = 'id';
        $this->orderDirection = 'asc';
        $this->query = new $model();
    }

    public function data(DatatablePresenterInterface $presenter): array
    {
        return [
            'data' => $presenter->decorate($this, $this->filter()->toArray()),
            'recordsFiltered' => $this->count(),
            'recordsTotal' => $this->totalCount()
        ];
    }

    public function get(): Collection
    {
        return $this->query->get();
    }

    public function filter(): Collection
    {
        return $this->query()->ordering()->paging()->get();
    }

    public function query(): self
    {
        if (present($this->search)) {
            $this->filtering();
        }

        return $this;
    }

    public function count(): int
    {
        return $this->query()->query->count();
    }

    public function totalCount(): int
    {
        return $this->query->count();
    }

    public function filtering(): self
    {
        if (isset($this->request)) {
            foreach ($this->columns as $column) {
                if ($column['searchable'] === 'true' && $column['visible'] === 'true') {
                    $this->whereClauses[] = "{$this->queryColumnMapping($column['name'])} LIKE '%{$this->search}%'";
                }
            }
        }

        $this->query = $this->query->whereRaw(implode(' OR ', $this->whereClauses));

        return $this;
    }

    public function ordering(): self
    {
        if (isset($this->request)) {
            $columnIndex = koshish(koshish($this->request->order, 0), 'column', 0);
            $this->orderColumn = $this->columns[$columnIndex]['name'];
            $this->orderDirection =  koshish(koshish($this->request->order, 0), 'dir', 'asc');
        }

        $this->query = $this->query->orderBy($this->queryColumnMapping($this->orderColumn), $this->orderDirection);

        return $this;
    }

    public function queryColumnMapping(string $column): string
    {
        return $column;
    }

    public function paging(): self
    {
        if (isset($this->request)) {
            $this->query = $this->query->offset($this->request->start)->limit($this->request->length);
        }

        return $this;
    }

    public static function tableName(): string
    {
        return presence(static::$tableName, '');
    }

    public static function configs(string $tableName = null): array
    {
        static::$tableName = $tableName ?? static::$tableName;

        $configs = Table::asConfigs()->with(['columns' => function ($query) {
            $query->asConfigs();
        }])->where('table_name', static::tableName())->first()->toArray();
        $configs['fixedColumns'] = json_decode($configs['fixedColumns']);

        if ($configs['include_action_buttons']) {
            $configs['columns'][] = [
                'name' => 'actions',
                'data' => 'actions',
                'title' => 'Actions',
                'orderable' => false,
                'searchable' => false,
            ];
        }

        return $configs;
    }

    public static function columns(): array
    {
        $configs = static::configs();

        return array_filter(array_map(function ($colConfig) {
            if ($colConfig['name'] !== 'actions')
                return $colConfig['name'];
        }, $configs['columns']));
    }

    public static function includeActionButtons(): bool
    {
        return Table::where('table_name', static::tableName())->first()->include_action_buttons;
    }
}
