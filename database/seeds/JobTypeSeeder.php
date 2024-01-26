<?php

use Illuminate\Database\Seeder;

class JobTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('job_types')->insert([
            [
                'job_type' => 'Full Time',
            ],
            [
                'job_type' => 'Part Time',
            ]
        ]);
    }
}
