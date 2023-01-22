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
            $table->increments('id');
            $table->string('name',255);
            $table->string('email',150)->unique();
            $table->string('password',255);
            $table->enum('roles', ['SUB_ADMIN','ADMIN', 'DEV', 'QA','CLIENT']);
            $table->tinyInteger('gender')->nullable();
            $table->tinyInteger('active')->default('0');
            $table->rememberToken();
            $table->softDeletes(); // <-- This will add a deleted_at field
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
