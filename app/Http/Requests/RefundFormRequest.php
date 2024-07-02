<?php

namespace App\Http\Requests;

use App\Enums\RefundStatusEnum;
use App\Enums\StatusEnum;
use App\Rules\LeadStatusNotEqual;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RefundFormRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return match ($this->method()) {
            'POST' => $this->postRules(),
            'PUT', 'PATCH' => $this->updateRules(),
        };
    }

    private function postRules(): array
    {
        return [
            'lead_status' => ['required', StatusEnum::toRule(), new LeadStatusNotEqual($this->route('lead'))],
            'employee_id' => 'required',
            'description' => 'required|string',
            'message' => 'string|nullable',
        ];
    }

    private function updateRules(): array
    {
        return [
            'status' => [
                'required',
                RefundStatusEnum::toRule(),
                Rule::notIn([$this->route('refund')->status])],
        ];
    }
}
