<?php

namespace App\DatatablePresenters;

use App\Datatables\DatatableInterface;
use App\Helpers\PhoneNumberHelper;
use App\Enums\StatusEnum;
use Carbon\Carbon;

class LeadDatatablePresenter implements DatatablePresenterInterface
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
                    'created_at', 'updated_at' => $this->date($record[$column]),
                    default => $record[$column],
                };
            }

            if ($datatable::includeActionButtons())
                $records[$i]['actions'] = $this->actions($record);
        }

        return presence($records) ?? [];
    }

    public function status($id, $status)
    {
        $statuses = StatusEnum::toArray();
        $options = '<option></option>';

        foreach ($statuses as $value => $label) {
            $options .= "<option value='$label' " . ($status?->value === $value ? 'selected' : '') . ">$value</option>";
        }

        return <<<HTML
            <select type='text' class='p-1 selectable lead-status-select' id='status' data-id='$id' name='status'
                    style='width: 200px;' data-selected="$$status?->value">
                $options
             </select>
        HTML;
    }

    public function address($record): string
    {
        return "{$record['address']}, {$record['city']}, {$record['state']}, {$record['country']}";
    }

    public function date($date): string
    {
        return Carbon::createFromDate($date)->format('Y-m-d H:m:s');
    }

    public function price($price): string
    {
        return '$' . number_format($price, 2);
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
