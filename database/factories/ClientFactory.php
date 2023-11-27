<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Client>
 */
class ClientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'company_name' => $this->faker->company,
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'email' => $this->faker->email,
            'phone_number' => $this->faker->phoneNumber,
            'is_active' => true,
            'address' => $this->faker->address,
            'city' => $this->faker->city,
            'postal_code' => $this->faker->postcode,
            'country' => $this->faker->country,
            'nip' => $this->faker->numberBetween(1000000000, 9999999999),
            'regon' => $this->faker->numberBetween(1000000000, 9999999999),
            'krs' => $this->faker->numberBetween(1000000000, 9999999999),
            'bank_account_number' => $this->faker->iban,
            'bank_name' => $this->faker->company,
        ];
    }
}
