<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        // news table
        DB::table('news')->insert([
            'title' => 'Another Test',
            'body' => $faker->text(200),
            'description' => 'hanya sebuah test',
            'photo_url' => 'https://via.placeholder.com/200?text=News+1',
            'created_by' => 1,
            'status' => 'A',
            'created_at' => \Carbon\Carbon::now(),
        ]);
        DB::table('news')->insert([
            'title' => 'Another Test 2',
            'body' => $faker->text(200),
            'description' => 'hanya duabuah test',
            'photo_url' => 'https://via.placeholder.com/200?text=News+2',
            'created_by' => 1,
            'status' => 'A',
            'created_at' => \Carbon\Carbon::now(),
        ]);

        // events table
        DB::table('events')->insert([
            'body' => $faker->text(500),
            'description' => 'test 1',
            'held_at' => \Carbon\Carbon::now(),
            'photo_url' => 'https://via.placeholder.com/200?text=Event+1',
            'location_desc' => 'AEON MALL BSD',
            'location_latitude' => -6.304715,
            'location_longitude' => 106.643997,
            'created_by' => 1,
            'created_at' => \Carbon\Carbon::now(),
        ]);
        DB::table('events')->insert([
            'body' => $faker->text(500),
            'description' => 'test 2',
            'held_at' => \Carbon\Carbon::now(),
            'photo_url' => 'https://via.placeholder.com/200?text=Event+2',
            'location_desc' => 'BRANZ BSD',
            'location_latitude' => -6.3017287,
            'location_longitude' => 106.642002,
            'created_by' => 1,
            'created_at' => \Carbon\Carbon::now(),
        ]);
    }
}
