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

        // users table
        DB::table('users')->insert([
            'first_name' => 'Firman',
            'last_name' => 'Sepojok',
            'email' => 'firman@cleanify.com',
            'password' => \Hash::make('abcd'),
        ]);
        DB::table('users')->insert([
            'first_name' => 'Andre',
            'last_name' => 'Sejok',
            'email' => 'andre@cleanify.com',
            'password' => \Hash::make('abcd'),
            'api_token' => 'sejok',
        ]);
        DB::table('users')->insert([
            'first_name' => 'Daniel',
            'last_name' => 'Gunawan',
            'email' => 'daniel@cleanify.com',
            'password' => \Hash::make('abcd'),
        ]);


        // news table for news
        DB::table('news')->insert([
            'title' => 'Asyiknya Plogging di Berbagai Kota',
            'body' => 'Joging adalah salah satu jenis olahraga yang paling banyak disukai oleh banyak orang. Selain efektif membakar lemak, joging juga mudah dilakukan oleh siapa saja tanpa memandang usia dan jenis kelamin. Namun, hanya melakukan joging saja tentu terasa kurang, bukan? Cobalah tambahkan rutinitas baru yaitu plogging. Plogging adalah gabungan dari bahasa Swedia “plocka upp” yang artinya mengambil dan joging. Kegiatan plogging pada dasarnya sama dengan joging, tetapi disertai dengan kegiatan memungut sampah. Bukan hanya badan saja yang menjadi sehat, tetapi lingkungan pun juga menjadi sehat dengan kegiatan ini. Kegiatan plogging ini awalnya dimulai oleh masyarakat di Swedia pada tahun 2016, tetapi tren olahraga ini menyebar ke seluruh dunia dengan cepat melalui media sosial.
            ',
            'description' => 'Olahraga Plus Pungut Sampah Bareng',
            'photo_url' => 'https://cleanify.danielgunawan.com/storage/photos/news/ada_sample_2.jpg',
            'location_desc' => 'Jakarta',
            'location_latitude' => -6.1753871,
            'location_longitude' => 106.8249588,
            'created_by' => 1,
            'status' => 'S',
            'created_at' => \Carbon\Carbon::now(),
        ]);
        DB::table('news')->insert([
            'title' => 'Setiap Hari Jakarta Hasilkan 7.000 Ton Sampah',
            'body' => 'Dinas Kebersihan DKI Jakarta mencatat 7.000 ton sampah dihasilkan setiap hari di ibu kota. Sampah-sampah itu dihasilkan dari permukiman sampai perkantoran. "Sehari bisa 7.000 ton, kan ada sampah di kali, sungai, ada di permukiman, perkantoran, kita juga ada petugas yang bersihin sampah setiap harinya," kata Kadis Kebersihan DKI Isnawa Aji kepada detikcom saat dihubungi, Minggu (21/1/2018). Isnawa melanjutkan, setiap harinya sampah-sampah tersebut diangkut oleh 1.200 truk sampah. Dia berharap ada bank sampah di tiap RW di Jakarta.
            ',
            'description' => 'Tercatat 7.000 ton sampah dihasilkan setiap hari di ibu kota.',
            'photo_url' => 'https://cleanify.danielgunawan.com/storage/photos/news/sampah_sample.jpg',
            'location_desc' => 'AEON MALL BSD',
            'location_latitude' => -6.304715,
            'location_longitude' => 106.643997,
            'created_by' => 1,
            'status' => 'S',
            'created_at' => \Carbon\Carbon::now(),
        ]);

        // news table for user reports
        DB::table('news')->insert([
            'title' => 'Another Test Report',
            'body' => $faker->text(200),
            'description' => 'hanya sebuah test',
            'photo_url' => 'https://via.placeholder.com/190x90?text=Report+1',
            'location_desc' => 'AEON MALL BSD',
            'location_latitude' => -6.304715,
            'location_longitude' => 106.643997,
            'created_by' => 1,
            'status' => 'NH',
            'news_type' => 'R',
            'created_at' => \Carbon\Carbon::now(),
        ]);
        DB::table('news')->insert([
            'title' => 'Another Test Report 2',
            'body' => $faker->text(200),
            'description' => 'hanya duabuah test',
            'photo_url' => 'https://via.placeholder.com/190x90?text=Report+2',
            'location_desc' => 'BRANZ BSD',
            'location_latitude' => -6.3017287,
            'location_longitude' => 106.642002,
            'created_by' => 1,
            'status' => 'NH',
            'news_type' => 'R',
            'created_at' => \Carbon\Carbon::now(),
        ]);

        // events table
        DB::table('events')->insert([
            'title' => 'Membersihkan Apple Academy',
            'body' => $faker->text(1000),
            'description' => 'yuk bersih-bersih playground kita sendiri',
            'held_at' => \Carbon\Carbon::now(),
            'photo_url' => 'https://cleanify.danielgunawan.com/storage/photos/events/ada_sample_1.jpg',
            'location_desc' => 'GOP 9',
            'location_latitude' => -6.3002223,
            'location_longitude' => 106.6498101,
            'created_by' => 1,
            'created_at' => \Carbon\Carbon::now(),
        ]);
        DB::table('events')->insert([
            'title' => 'Another Test',
            'body' => $faker->text(1000),
            'description' => 'test 1',
            'held_at' => \Carbon\Carbon::now(),
            'photo_url' => 'https://via.placeholder.com/160x90?text=Event+1',
            'location_desc' => 'AEON MALL BSD',
            'location_latitude' => -6.304715,
            'location_longitude' => 106.643997,
            'created_by' => 1,
            'created_at' => \Carbon\Carbon::now(),
        ]);
        DB::table('events')->insert([
            'title' => 'Another Test 2',
            'body' => $faker->text(1000),
            'description' => 'test 2',
            'held_at' => \Carbon\Carbon::now(),
            'photo_url' => 'https://via.placeholder.com/160x90?text=Event+2',
            'location_desc' => 'BRANZ BSD',
            'location_latitude' => -6.3017287,
            'location_longitude' => 106.642002,
            'created_by' => 1,
            'created_at' => \Carbon\Carbon::now(),
        ]);
    }
}
