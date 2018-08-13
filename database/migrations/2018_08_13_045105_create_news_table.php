<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('news', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 50);
            $table->longText('body');
            $table->string('description', 100);
            $table->string('photo_url', 150);
            $table->double('location_latitude', 10, 8)->nullable();
            $table->double('location_longitude', 11, 8)->nullable();
            $table->unsignedInteger('created_by'); // user id
            $table->string('status', 20); // A (active) / I (inactive)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('news');
    }
}
