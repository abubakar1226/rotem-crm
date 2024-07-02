<?php

namespace App\Rules;

use App\Models\Lead;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class LeadStatusNotEqual implements ValidationRule
{
    protected $lead;

    public function __construct($lead)
    {
        $this->lead = $lead;
    }

    /**
     * The attribute value must not be equal to lead status.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if ($value === $this->lead->status?->label) {
            $fail('The :attribute must not be equal to the status of the lead.');
        }
    }
}
