<?php

namespace Database\Factories;

use App\Models\Client;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ComboOrder>
 */
class ComboOrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $positionsCount = $this->faker->numberBetween(1, 50);
        $priceFirstProduct = $this->faker->numberBetween(1, 7);
        $tax = 1.23;
        $priceNetTotal = ($priceFirstProduct * $positionsCount);
        $priceGrossTotal = ($priceNetTotal * $tax);
        $taxValueTotal = ($priceGrossTotal - $priceNetTotal);

        $client = Client::get()->random();

        return [
            'company_name' => $client->company_name,
            'company_address' => $this->faker->address,
            'company_city' => $this->faker->city,
            'company_postal_code' => $this->faker->postcode,
            'company_country' => $this->faker->country,
            'company_nip' => $this->faker->numberBetween(1999999, 9999999),
            'company_phone' => $this->faker->phoneNumber,
            'company_email' => $this->faker->email,
            'company_first_name' => $this->faker->firstName,
            'company_last_name' => $this->faker->lastName,
            'order_positions_count' => $positionsCount,
            'order_positions_price_net_total' => $priceNetTotal,
            'order_positions_price_gross_total' => $priceGrossTotal,
            'order_positions_tax_value_total' => $taxValueTotal,
            'invoice_symbol' => 'SPR/FAK/'.$this->faker->numberBetween(1000000000, 9999999999),
        ];
    }
}
