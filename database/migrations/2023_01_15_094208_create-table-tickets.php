<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableTickets extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ticket_no',255);
            $table->integer('dev_user_id');
            $table->integer('qa_user_id');            
            $table->foreign('dev_user_id')->references('id')->on('users');
            $table->foreign('qa_user_id')->references('id')->on('users');
            $table->string('summery',255);
            $table->date('due_date');
            $table->text('comment');
            $table->enum('status',['DEV','QA','UAT','PRD','NA','PRIORITY'])->default('NA');
            $table->tinyInteger('active')->default('0');
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
        //
    }
}
