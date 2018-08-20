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

        DB::table('news')->insert([
            'title' => 'Another Test',
            'body' => $faker->text(200),
            'description' => 'hanya sebuah test',
            'created_by' => 1,
            'status' => 'A',
            'created_at' => \Carbon\Carbon::now(),
        ]);
    }
}
