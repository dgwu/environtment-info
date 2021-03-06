<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('first_name', 100);
            $table->string('last_name', 100)->nullable();
            $table->string('email', 150)->unique();
            $table->string('password', 100);
            $table->double('last_location_latitude', 10, 8)->nullable();
            $table->double('last_location_longitude', 11, 8)->nullable();
            $table->string('status', 20)->default('A'); // A (active) / I (inactive)
            $table->rememberToken();
            $table->timestamps();
            $table->string('api_token', 100)->nullable();
            $table->dateTime('api_token_issue_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
