<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\VacationPlan>
 */
class VacationPlanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title'=>$this->faker->sentence(),
            'description'=>$this->faker->paragraph(),
            'date'=>$this->faker->date('Y_m_d'),
            'location'=>$this->faker->city(),
            'participants'=>$this->faker->boolean() ? $this->faker->numberBetween(1, 10) : null
        ];
    }
}
