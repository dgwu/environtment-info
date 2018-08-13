<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->increments('id');
            $table->longText('body');
            $table->string('description', 100);
            $table->dateTime('held_at');
            $table->string('location_desc', 50);
            $table->double('location_latitude', 10, 8)->nullable();
            $table->double('location_longitude', 11, 8)->nullable();
            $table->unsignedInteger('created_by'); // user id
            $table->string('status', 20);
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
        Schema::dropIfExists('events');
    }
}
