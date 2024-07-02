<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AppointmentFormRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'POST' => [
                'date' => 'required|date',
                'start_time' => 'required|date_format:H:i',
                'end_time' => 'required|date_format:H:i|after:start_time',
                'address' => 'required|string|max:255',
                'city' => 'required|string|max:255',
                'state' => 'required|string|max:255',
                'post_code' => 'required|string|max:10',
                'technician_id' => $this->technicianIdRule(),
                'job_description' => 'string',
            ],
            'PATCH' => [
                'technician_id' => $this->technicianIdRule(),
            ]
        ][$this->method()];
    }

    public function technicianIdRule(): string
    {
        return 'required|exists:technicians,id';
    }
}
