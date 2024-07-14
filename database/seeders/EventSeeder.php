<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EventsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 50; $i++) {
            DB::table('events')->insert([
                'name' => 'Event ' . $i,
                'start_date' => now()->addDays($i),
                'end_date' => now()->addDays($i + 2),
                'user_id' => 1, // Assuming user_id 1 is a specific user or admin
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
