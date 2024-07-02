<?php

namespace App\DatatablePresenters;

use App\Datatables\DatatableInterface;
use App\Enums\RefundStatusEnum;
use App\Enums\StatusEnum;

class RefundDatatablePresenter extends LeadDatatablePresenter
{
    public function decorate(DatatableInterface $datatable, array $records): array
    {
        foreach ($records as $i => $record) {
            foreach ($datatable::columns() as $column) {
                $records[$i][$column] = match ($column) {
                    'status' => $this->refundStatus($record['id'], koshish($record, 'status')),
                    'lead_status' => $this->status($record['id'], koshish($record, 'lead_status')),
                    'price' => $this->price($record['price']),
                    'created_at', 'updated_at' => $this->date($record[$column]),
                    default => $record[$column],
                };
            }

            if ($datatable::includeActionButtons())
                $records[$i]['actions'] = $this->actions($record);
        }

        return presence($records) ?? [];
    }

    public function refundStatus($id, $status): string
    {
        $statuses = RefundStatusEnum::toArray();
        $options = '<option></option>';

        foreach ($statuses as $value => $label) {
            $options .= "<option value='$label' " . ($status?->value === $value ? 'selected' : '') . ">$value</option>";
        }

        return <<<HTML
            <select type='text' class='p-1 selectable refund-status-select' id='status' data-id='$id' name='status'
                    data-row-color="{$this->rowColor($status)}" style='width: 200px;'>
                $options
            </select>
        HTML;
    }

    public function rowColor(RefundStatusEnum|null $status): string
    {
        switch ($status) {
            case RefundStatusEnum::Refunded():
                return 'bg-success text-white';
            case RefundStatusEnum::RefundCancelled():
                return 'bg-danger text-white';
            default:
                return '';
        }
    }

    public function actions($record): string
    {
        $refundEditRoute = route('refunds.edit', $record['id']);

        return <<<HTML
            <div class="btn-list">
                <a href="$refundEditRoute" data-title="Edit Refund" class="btn btn-sm btn-primary">
                   <span class="fe fe-edit"> </span>
                </a>
            </div>
        HTML;
    }
}
