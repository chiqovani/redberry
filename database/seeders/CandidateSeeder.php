<?php

namespace Database\Seeders;

use App\Models\Candidates;
use Illuminate\Database\Seeder;

class CandidateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    protected $model = Candidates::class;

    public function run()
    {
        Candidates::factory()->count(2)->create();
    }
}
