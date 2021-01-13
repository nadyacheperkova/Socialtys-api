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
            $table->increments('id')->unique();
            $table->string('firstName');
            $table->string('lastName');
            $table->string('image')->nullable();
            $table->string('occupationField');
            $table->string('linked_in_url')->nullable();
            $table->string('email')->unique();
            $table->enum('type', ['student', 'teacher', 'admin','alumni']);
            $table->integer('strikes')->nullable();
            $table->boolean('first_login');
            $table->string('password');
            $table->string('email_verified_at')->nullable();
            $table->string('skills')->nullable();
            $table->string('interests')->nullable();
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
