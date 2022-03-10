<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Status;

class StatusFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    protected $model = Status::class;
    protected $statuses = ['First Contact', 'Interview', 'Tech Assignment', 'Rejected', 'Hired'];

    public function definition()
    {
        foreach($this->statuses as $status) {
            return [
                'name' => $status,
            ];
        }
    }
}
