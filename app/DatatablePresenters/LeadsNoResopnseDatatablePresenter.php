<?php

namespace App\DatatablePresenters;

use App\Datatables\DatatableInterface;
use App\Helpers\PhoneNumberHelper;
use Carbon\Carbon;

class LeadsNoResopnseDatatablePresenter extends LeadDatatablePresenter
{
    public function decorate(DatatableInterface $datatable, array $records): array
    {
        foreach ($records as $i => $record) {
            foreach ($datatable::columns() as $column)
            {
                $records[$i][$column] = match ($column) {
                    'status' => $this->status($record['id'], koshish($record, 'status')),
                    'price' => $this->price($record['price']),
                    'phone_number' => PhoneNumberHelper::formatPhoneNumber($record[$column]),
                    'follow_up_at' => $this->diffForHumans($record[$column]),
                    'created_at', 'updated_at' => $this->date($record[$column]),
                    default => $record[$column],
                };
            }

            if ($datatable::includeActionButtons())
                $records[$i]['actions'] = $this->actions($record);
        }

        return presence($records) ?? [];
    }

    public function diffForHumans($value): string
    {
        return Carbon::createFromDate($value)->diffForHumans();
    }

    public function actions($record)
    {
        $leadEditRoute = route('leads.edit', $record['id']);
        $leadDestroyRoute = route('leads.destroy', $record['id']);

        return <<<HTML
            <div class="btn-list">
                <a href="$leadEditRoute" data-title="Edit Lead" class="btn btn-sm btn-primary">
                   <span class="fe fe-edit"> </span>
                </a>
                <button type="button" class="btn btn-sm btn-danger delete" data-method="delete"
                        data-url="$leadDestroyRoute" data-table="#leads_datatable">
                    <span class="fe fe-trash-2"> </span>
                </button>
            </div>
        HTML;
    }
}
