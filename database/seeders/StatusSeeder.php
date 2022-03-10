<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    protected $model = Status::class;
    protected $statuses = ['Initial','First Contact', 'Interview', 'Tech Assignment', 'Rejected', 'Hired'];

    public function run()
    {
        foreach($this->statuses as $status) {
            Status::create(['name' => $status]);
        }
    }
}
