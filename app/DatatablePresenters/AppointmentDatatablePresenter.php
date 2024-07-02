<?php

namespace App\DatatablePresenters;

use App\Datatables\DatatableInterface;
use App\Models\Appointment;
use App\Models\Technician;
use Carbon\Carbon;

class AppointmentDatatablePresenter implements DatatablePresenterInterface
{
    protected array $technicianOptions = [];

    public function __construct()
    {
        $this->setTechnicians();
    }

    protected function setTechnicians()
    {
        $this->technicianOptions = Technician::select(['id', 'name'])->get()->toArray();
    }

    public function decorate(DatatableInterface $datatable, array $records): array
    {
        foreach ($records as $i => $record) {
            foreach ($datatable::columns() as $column) {
                $records[$i][$column] = match ($column) {
                    'technician' => $this->technician($record['id'], $record['technician_id'], $record['technician']),
                    'appointment_date' => $this->appointmentDate($record['date']),
                    'appointment_window' => $this->appointmentWindow($record['start_time'], $record['end_time']),
                    'updated_at', 'created_at' => $this->date($record[$column]),
                    default => koshish($record, $column),
                };
            }
        }

        return presence($records) ?? [];
    }

    public function technician($appointmentId, $technicianId, $technicianName): string
    {
        $options = '';

        foreach ($this->technicianOptions as $technician) {
            $selected = $technician['id'] === $technicianId ? 'selected' : '';

            $options .= <<<HTML
                <option value="{$technician['id']}" $selected>{$technician['name']}</option>
            HTML;
        }

        return <<<HTML
            <select type='text' class='p-1 selectable technician-select' id='status' data-technician-id='$technicianId'
                    data-appointment-id="$appointmentId" name='status' style='width: 200px;'>
                <option></option>
                $options
            </select>
        HTML;
    }

    public function appointmentDate($date): string
    {
        return Carbon::createFromDate($date)->toFormattedDayDateString();
    }

    public function appointmentWindow($start_time, $end_time): string
    {
        return Carbon::createFromDate($start_time)->format('g:i A') . ' - '
            . Carbon::createFromDate($end_time)->format('g:i A');
    }

    public function date($date): string
    {
        return Carbon::createFromDate($date)->format('Y-m-d H:m:s');
    }
}
