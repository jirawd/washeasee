<?php

namespace Database\Factories;

use App\Models\Machines;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class MachinesFactory extends Factory
{
    protected $model = Machines::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'machine_type' => 'Washing Machine',
            'machine_name' => $this->faker->text,
            'machine_status' => $this->faker->randomElement(['Available', 'Not Available']),
        ];
    }
}
