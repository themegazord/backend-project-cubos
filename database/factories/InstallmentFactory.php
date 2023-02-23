<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class InstallmentFactory extends Factory
{
    public function definition(): array
    {
        $amount = $this->faker->randomFloat(2, 20, 100);
        return [
            'users_id' => $this->faker->numberBetween(1, 7),
            'id_billing' => $this->faker->uuid(),
            'description' => $this->faker->realText(50),
            'debtor_id' => $this->faker->numberBetween(1, 5),
            'emission_date' => $this->faker->dateTimeBetween('-1 month'),
            'due_date' => $this->faker->dateTimeBetween('now', '1 month'),
            'amount' => $amount,
        ];
    }
}
