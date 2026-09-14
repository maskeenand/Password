<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Credential>
 */
class CredentialFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => fake()->company(),
            'username' => fake()->userName(),
            'password' => fake()->password(10, 20),
            'url' => fake()->optional()->url(),
            'notes' => fake()->optional()->sentence(),
        ];
    }
}
