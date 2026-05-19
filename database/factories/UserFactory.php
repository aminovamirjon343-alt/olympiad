<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $names = ['Ali', 'Bakhtiyor', 'Faridun', 'Jamshed', 'Rustam', 'Siyovush', 'Dilshod', 'Umed', 'Parviz', 'Firuz', 'Manucher', 'Shavkat', 'Zafar', 'Komil', 'Firdavs'];
        $name = $this->faker->randomElement($names);

        return [
            'name' => $name,
            'email' => strtolower($name) . $this->faker->unique()->numberBetween(100, 999) . '@email.tj',
            'password' => \Illuminate\Support\Facades\Hash::make('1404trend'),
            'role' => $this->faker->randomElement(['admin', 'employee', 'director', 'user']),
            'company' => 'StartCoding',
            'phone' => '+992' . $this->faker->numerify('9#######'),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
