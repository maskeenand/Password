<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Server>
 */
class ServerFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->words(2, true).' Server',
            'ip_address' => fake()->ipv4(),
            'port' => fake()->randomElement([22, 2222, 80, 443, 3306]),
            'type' => fake()->randomElement(['VPS', 'Dedicated', 'Cloud', 'Lokal', 'Lainnya']),
            'os' => fake()->randomElement(['Ubuntu', 'Debian', 'CentOS', 'Rocky Linux', 'Windows Server', 'Lainnya']),
            'status' => fake()->randomElement(['Aktif', 'Tidak Aktif', 'Maintenance']),
            'location' => fake()->optional()->city(),
            'notes' => fake()->optional()->sentence(),
        ];
    }
}
