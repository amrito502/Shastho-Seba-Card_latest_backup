<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Organization;

class OrganizationFactory extends Factory
{
    protected $model = Organization::class;

    public function definition()
    {
        return [
            'name' => $this->faker->company,
            'logo' => 'images/organizations/' . $this->faker->unique()->uuid . '.png',
            'address' => $this->faker->address,
            'maxDiscount' => $this->faker->numberBetween(30, 50),
            'minDiscount' => $this->faker->numberBetween(1, 20),
            'district_id' => $this->faker->numberBetween(1, 64), // Adjust as needed
            'sub_district_id' => $this->faker->numberBetween(300, 400), // Adjust as needed
        ];
    }
}
