<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;


class DebtorFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => $this->faker->numberBetween(1, 7),
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'cpf' => $this->faker->numerify('###########'),
            'phone'=> preg_replace( '/[^0-9]/is', '', $this->faker->phoneNumber()),
            'address' => $this->faker->streetAddress(),
            'complement' => implode(' ', $this->faker->words()),
            'cep' => $this->faker->randomNumber(8, true),
            'neighborhood' => implode(' ', $this->faker->words()),
            'city' => $this->faker->city(),
            'state' => $this->faker->randomLetter() . $this->faker->randomLetter(),
        ];
    }
}
