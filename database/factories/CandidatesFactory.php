<?php

namespace Database\Factories;

use App\Models\Candidates;
use App\Models\Status;
use Illuminate\Database\Eloquent\Factories\Factory;

class CandidatesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    protected $model = Candidates::class;

    public function definition()
    {
        return [
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'position' => $this->faker->company(),
            'min_salary' => $this->faker->numberBetween(500, 1000),
            'max_salary' => $this->faker->numberBetween(1000, 10000),
            'linkedin_url' => $this->faker->url(),
            'status_id' => Status::first()->id
        ];
    }
}
