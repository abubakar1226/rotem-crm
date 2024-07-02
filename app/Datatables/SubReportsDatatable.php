<?php

namespace App\Datatables;

use App\Models\SubReport;

class SubReportsDatatable extends Datatable
{
    protected static string $tableName = 'sub_reports';
    public function query(): self
    {
        $this->query = SubReport::select($this->select())
            ->join('appointments', 'sub_reports.appointment_id', 'appointments.id')
            ->join('technicians', 'appointments.technician_id', 'technicians.id')
            ->join('leads', 'appointments.lead_id', 'leads.id')
            ->orderBy('sub_reports.created_at', 'desc')
            ->limit(1);

        return parent::query();
    }

    public function select()
    {
        return [
            'sub_reports.id', 'sub_reports.job_total','sub_reports.closing',
            'sub_reports.payment_method', 'sub_reports.technician_materials_cost',
            'sub_reports.company_materials_cost', 'sub_reports.technician_profit',
            'sub_reports.technician_balance', 'sub_reports.company_balance', 'leads.name AS name',
            'appointments.address', 'appointments.city', 'appointments.state', 'appointments.post_code',
            'appointments.date', 'technicians.name AS technician'
        ];
    }

    public function queryColumnMapping(string $column): string
    {
        return match ($column) {
            'name' => 'leads.name',
            'technician' => 'technicians.name',
            'address' => 'appointments.address',
            default => $column,
        };
    }
}
