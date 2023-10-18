<?php

namespace Database\Factories;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
{
    protected $model = Customer::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'contact_lastname'=> $this->faker->lastName,
            'contact_firstname' => $this->faker->firstName,
            'phone' => $this->faker->phoneNumber,
            'address_line_1' => $this->faker->streetAddress,
            'address_line_2' => $this->faker->secondaryAddress,
            'city' => $this->faker->city,
            'state'=> $this->faker->state,
            'postal_code' => $this->faker->postcode,
            'country' => $this->faker->country,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
