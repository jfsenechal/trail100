<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Role>
 */
class RegistrationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'email' => fake()->email(),
            'payment_date' => $this->faker->boolean ? now() : null,
            'newsletter_accepted' => $this->faker->boolean,
            'completed' => $this->faker->boolean,
        ];
    }
}
