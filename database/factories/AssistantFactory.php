<?php

namespace Database\Factories;

use App\Class\Assistant\Enum\AssistantType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Assistant>
 */
class AssistantFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'img_url' => fake()->imageUrl(),
            'name' => fake()->sentence(1),
            'short_name' => 'Assistant',
            'prompt' => 'Example prompt',
            'sort' => fake()->numberBetween(0, 1),
            'type' => AssistantType::BASIC->value,
            'public' => true,
        ];
    }
}
