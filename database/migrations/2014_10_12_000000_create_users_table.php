<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->id();

            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('first_name');
            $table->string('last_name');
            $table->boolean('gender')->nullable();
            $table->date('dob')->nullable();
            $table->string('password')->nullable();
            $table->char('phone', 25)->nullable();
            $table->string('avatar')->nullable();
            $table->smallInteger('role_id')->default(1);
            $table->unsignedBigInteger('google_id')->nullable();
            $table->string("google_token")->nullable();
            $table->string("google_refresh_token")->nullable();
            $table->rememberToken();

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
        Schema::dropIfExists('users');
    }
}
