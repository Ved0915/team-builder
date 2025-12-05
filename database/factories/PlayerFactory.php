<?php

namespace Database\Factories;

use App\Models\Player;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Player>
 */
class PlayerFactory extends Factory
{
    protected $model = Player::class;

    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'date_of_birth' => fake()->dateTimeBetween('-40 years', '-18 years'),
        ];
    }
}
