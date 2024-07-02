<?php

namespace App\Http\Requests;

use App\Enums\SubReportClosingEnum;
use App\Enums\PaymentMethods;
use Illuminate\Foundation\Http\FormRequest;

class SubReportFormRequest extends FormRequest
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
            'closing' => ['nullable', SubReportClosingEnum::toRule()],
            'payment_method' => ['nullable', PaymentMethods::toRule()],
            'technician_materials_cost' => ['nullable', 'numeric'],
            'company_materials_cost' => ['nullable', 'numeric'],
            'job_total' => ['nullable', 'numeric'],
        ];
    }
}
