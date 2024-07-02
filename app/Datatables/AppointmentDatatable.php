<?php

namespace App\Datatables;

use App\Models\Lead;
use App\Enums\StatusEnum;
use App\Models\Technician;
use Illuminate\Http\Request;

class AppointmentDatatable extends LeadDatatable
{
    protected static string $tableName = 'appointments';
    protected ?Technician $technician;

    public function __construct(Request $request, StatusEnum|null $status, ?Technician $technician)
    {
        parent::__construct($request, $status);
        $this->technician = $technician;
    }

    public function query(): self
    {
        $this->query = Lead::select($this->select())
            ->join('appointments', 'leads.id', 'appointments.lead_id')
            ->join('technicians', 'technicians.id', 'appointments.technician_id')
            ->where('status', StatusEnum::appointmentSet());

        if (isset($this->technician->id))
            $this->query->where('appointments.technician_id', $this->technician->id);

        return parent::query();
    }

    public function select()
    {
        return [
            'appointments.id', 'appointments.address', 'appointments.city', 'appointments.state',
            'appointments.post_code', 'appointments.date', 'appointments.start_time', 'appointments.end_time',
            'appointments.updated_at', 'appointments.created_at', 'appointments.job_description',

            'leads.name AS name', 'leads.phone_number', 'leads.status', 'leads.price', 'leads.platform',
            'leads.id AS lead_id',

            'technicians.id AS technician_id', 'technicians.name AS technician'
        ];
    }

    public function queryColumnMapping(string $column): string
    {
        return match ($column) {
            'name' => 'leads.name',
            'technician' => 'technicians.name',
            'phone_number' => 'leads.phone_number',
            'address' => 'appointments.address',
            'appointment_date' => 'appointments.date',
            'appointment_window' => 'appointments.start_time',
            default => $column,
        };
    }
}
