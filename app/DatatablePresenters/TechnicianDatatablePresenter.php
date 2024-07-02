<?php

namespace App\DatatablePresenters;

use App\Datatables\DatatableInterface;
use App\Helpers\PhoneNumberHelper;
use Carbon\Carbon;

class TechnicianDatatablePresenter implements DatatablePresenterInterface
{
    public function decorate(DatatableInterface $datatable, array $records): array
    {
        foreach ($records as $i => $record) {
            foreach ($datatable::columns() as $column)
            {
                $records[$i][$column] = match ($column) {
                    'phone_number' => PhoneNumberHelper::formatPhoneNumber($record[$column]),
                    'created_at', 'updated_at' => $this->date($record[$column]),
                    
                    default => $record[$column],
                };
            }

            $records[$i]['actions'] = $this->actions($record);
        }

        return presence($records, []);
    }

    public function date($date): string
    {
        return Carbon::createFromDate($date)->format('Y-m-d H:i:s');
    }

    public function actions($record)
    {
        $technicianEditRoute = route('technicians.edit', $record['id']);
        $technicianDestroyRoute = route('technicians.destroy', $record['id']);

        return <<<HTML
            <div class="btn-list">
                <a href="$technicianEditRoute" data-title="Edit Technician" class="btn btn-sm btn-primary">
                   <span class="fe fe-edit"> </span>
                </a>
                <button type="button" class="btn btn-sm btn-danger delete" data-method="delete"
                        data-url="$technicianDestroyRoute" data-table="#technicians_datatable">
                    <span class="fe fe-trash-2"> </span>
                </button>
            </div>
        HTML;
    }
}
