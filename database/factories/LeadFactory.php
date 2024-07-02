<?php

namespace Database\Factories;

use App\Models\Lead;
use App\Enums\PlatformEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

class LeadFactory extends Factory
{
    protected $model = Lead::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'phone_number' => $this->faker->phoneNumber,
            'address' => $this->faker->address,
            'city' => $this->faker->city,
            'state' => $this->faker->state,
            'post_code' => $this->faker->postcode,
            'country' => $this->faker->country,
            'price' => $this->faker->randomFloat(2, 0, 1000),
            'platform' => PlatformEnum::random(),
        ];
    }
}
