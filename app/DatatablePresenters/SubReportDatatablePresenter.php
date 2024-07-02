<?php

namespace App\DatatablePresenters;

use App\Datatables\DatatableInterface;
use App\Enums\SubReportClosingEnum;
use App\Enums\PaymentMethods;

class SubReportDatatablePresenter implements DatatablePresenterInterface
{
    public function decorate(DatatableInterface $datatable, array $records): array
    {
        foreach ($records as $i => $record) {
            foreach ($datatable::columns() as $column) {
                $records[$i][$column] = match ($column) {
                    'job_total',
                    'technician_materials_cost',
                    'company_materials_cost' => $this->editableAmountInput($record['id'], $column, $record[$column]),
                    'technician_profit',
                    'technician_balance',
                    'company_balance' => $this->amountDiv($record[$column]),
                    'closing' => $this->enumToHTMLSelect(
                        SubReportClosingEnum::class, $record['id'], $column, $record[$column]
                    ),
                    'payment_method' => $this->enumToHTMLSelect(
                        PaymentMethods::class, $record['id'], $column, $record[$column]
                    ),
                    default => koshish($record, $column),
                };
            }
        }

        return presence($records) ?? [];
    }

    public function editableAmountInput($id, string $column, int|null $amount): string
    {
        $amountFormatted = currentyFormat($amount ?? 0);
        $amount = amountInDollars($amount ?? 0);

        return <<<HTML
            <div class="editable-amount-div inline-block">
                <span class="editable-amount-amount" data-id="$id" data-column="{$column}">$amountFormatted</span>
                <input type="text" class="p-0 m-0 bg-white border-0 h-6 w-100 d-none editable-amount-input"
                       value="{$amount}" data-column="{$column}" data-value="{$amount}" data-id="$id" disabled
                />
            </div>
        HTML;
    }

    public function amountDiv(int|null $amountInCents): string
    {
        return '<div class="text-center inline-block">' . currentyFormat($amountInCents) . '</div>';
    }

    public function enumToHTMLSelect($enum, $id, $column, $value)
    {
        try {
            $values = $enum::toArray();
            $options = '<option></option>';

            foreach ($values as $val => $label) {
                $options .= "<option value='$label' " . ($value?->value === $val ? 'selected' : '') . ">$val</option>";
            }

            return <<<HTML
            <select type='text' class='p-1 selectable' id='status' data-id='$id' name='status'
                    style='width: 200px;' data-selected="{$value?->value}" data-column="{$column}">
                $options
             </select>
        HTML;
        } catch (\Exception $exception) {
            dd($exception);
        }
    }
}
