<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TableFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'display_name' => 'required|string|max:50',
            'description' => 'string|nullable|max:1000',
            'fixedColumnsStart' => 'required|integer',
            'fixedColumnsEnd' => 'required|integer',
            'scrollX' => 'nullable',
            ...$this->columnRules(),
        ];
    }

    public function columnRules(): array
    {
        return [
            'columns.*.visible' => 'required|boolean',
            'columns.*.position' => 'required|integer',
            'columns.*.id' => 'required|integer',
        ];
    }
}
