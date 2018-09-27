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
            $table->string('photo_url', 150)->nullable();
            $table->string('location_desc', 50);
            $table->double('location_latitude', 10, 8)->nullable();
            $table->double('location_longitude', 11, 8)->nullable();
            $table->unsignedInteger('created_by'); // user id
            $table->string('status', 20)->default('NH'); // S : SOLVED / OP : ON PROGRESS / NH : NEED HELP / FR : False Report
            // $table->string('feedback', 20)->default('NEED HELP'); // SOLVED / ON PROGRESS / NEED HELP
            $table->string('news_type', 20)->default('N'); // N (News) / R (Report)
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
