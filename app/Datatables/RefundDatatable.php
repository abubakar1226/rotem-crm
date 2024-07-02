<?php

namespace App\Datatables;

use App\Models\Refund;
use Illuminate\Http\Request;

class RefundDatatable extends Datatable
{
    protected static string $tableName = 'refunds';

    public function __construct(Request $request)
    {
        parent::__construct($request, 'App\Models\Refund');
    }

    public function query(): self
    {
        $this->query = Refund::select($this->select())
            ->join('leads', 'refunds.lead_id', 'leads.id')
            ->orderBy('refunds.created_at', 'desc')
            ->limit(1);

        return parent::query();
    }

    public function select(): array
    {
        return [
            'refunds.id', 'leads.name', 'leads.phone_number', 'leads.status', 'leads.address', 'leads.updated_at',
            'leads.city', 'leads.state', 'leads.post_code', 'leads.country', 'leads.price', 'leads.platform',
            'refunds.status AS status', 'leads.created_at AS created_at', 'refunds.created_at AS refund_created_at',
            'leads.status AS lead_status',
        ];
    }

    public function queryColumnMapping(string $column): string
    {
        return match ($column) {
            'id' => 'refunds.id',
            'status' => 'refunds.status',
            'created_at' => 'leads.created_at',
            default => $column,
        };
    }
}
