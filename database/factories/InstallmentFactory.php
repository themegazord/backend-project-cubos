<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class InstallmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'users_id' => fake()->numberBetween(1, 7),
            'id_billing' => fake()->unique()->randomNumber(5, true),
            'debtor' => fake()->name(),
            'emission_date' => fake()->dateTimeBetween('-1 month', 'now'),
            'due_date' => fake()->dateTimeBetween('now', '1 month'),
            'amount' => fake()->randomFloat(2, 20, 100),
            'paid_amount' => fake()->randomFloat(2, 20, 100),
        ];
    }
}
