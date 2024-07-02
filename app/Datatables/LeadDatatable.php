<?php

namespace App\Datatables;

use App\Enums\StatusEnum;
use Illuminate\Http\Request;

class LeadDatatable extends Datatable
{
    protected static string $tableName = 'leads';
    protected StatusEnum|null $status;

    public function __construct(Request $request, StatusEnum|null $status)
    {
        parent::__construct($request, 'App\Models\Lead');
        $this->status = presence($status);
    }

    public function query(): self
    {
        if (present($this->search)) {
            $this->filtering();
        }

        $this->query = present($this->status) ? $this->query->where('status', $this->status) : $this->query;

        return $this;
    }
}
