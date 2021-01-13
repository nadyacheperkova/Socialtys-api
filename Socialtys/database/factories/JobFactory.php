<?php

namespace Database\Factories;

use App\Models\Job;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class JobFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Job::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->name,
            'id' => $this->faker->numberBetween(1,2),
            'company' => $this->faker->name,
            'description' => $this->faker->name,
            'url' => $this->faker->name,
            'type' => $this->faker->name,
            'user_id' => $this->faker->numberBetween(1,2)
        ];
    }
}
