<?php

namespace Database\Factories;

use App\Models\Agency;
use Illuminate\Database\Eloquent\Factories\Factory;

class AgencyFactory extends Factory
{
    protected $model = Agency::class;

    public function definition(): array
    {
        return [
            'name' => fake()->company(),
            'code' => strtoupper(fake()->unique()->bothify('AGENCY-###')),
            'description' => fake()->sentence(),
            'contact_email' => fake()->companyEmail(),
            'contact_phone' => fake()->phoneNumber(),
            'address' => fake()->address(),
            'is_active' => true,
        ];
    }
}
