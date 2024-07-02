<?php

namespace App\Http\Requests;

use App\Enums\PlatformEnum;
use App\Enums\StatusEnum;
use Illuminate\Foundation\Http\FormRequest;

class LeadFormRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'phone_number' => 'string|max:20',
            'address' => 'string|max:255',
            'country' => 'required_with:address|string|max:255',
            'state' => 'required_with:address|string|max:255',
            'post_code' => 'required_with:address|string|max:20',
            'price' => 'required|numeric|min:0',
            'status' => ['nullable', StatusEnum::toRule()],
            'platform' => ['required', 'string', PlatformEnum::toRule()],
        ];
    }
}
