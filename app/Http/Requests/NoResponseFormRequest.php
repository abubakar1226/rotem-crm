<?php

namespace App\Http\Requests;

use App\Enums\RefundStatusEnum;
use App\Enums\StatusEnum;
use App\Rules\LeadStatusNotEqual;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class NoResponseFormRequest extends FormRequest
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
        };
    }

    private function postRules(): array
    {
        return [
            'lead_status' => ['required', StatusEnum::toRule(), new LeadStatusNotEqual($this->route('lead'))],
            'message' => 'string|nullable',
        ];
    }
}
