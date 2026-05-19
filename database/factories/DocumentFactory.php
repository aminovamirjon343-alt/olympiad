<?php

namespace Database\Factories;

use App\Models\Model;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Model>
 */
class DocumentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(3),
            'content' => $this->faker->paragraph(),
            'type' => $this->faker->randomElement(['order', 'contract', 'statement']),
            'status' => 'active',

            // Используем created_by вместо user_id
            'created_by' => \App\Models\User::inRandomOrder()->first()->id,

            // receiver_id можно оставить случайным пользователем или null
            'receiver_id' => \App\Models\User::inRandomOrder()->first()->id,

            'deadline' => now()->addDays(7),
        ];
    }
}
