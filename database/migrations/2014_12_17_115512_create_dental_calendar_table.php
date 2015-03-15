<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDentalCalendarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dental_calendar', function(Blueprint $table)
        {
            $table->increments('id');

            $table->dateTime('start_date')->nullable();
            $table->dateTime('end_date')->nullable();
            $table->text('description')->nullable();
            $table->bigInteger('event_id')->nullable();
            $table->integer('docid')->nullable();
            $table->string('ip_address', 50)->nullable();
            $table->string('category', 100)->nullable();
            $table->integer('producer_id')->nullable();
            $table->integer('patientid')->nullable();
            $table->string('rec_type', 64)->nullable();
            $table->bigInteger('event_length')->nullable();
            $table->bigInteger('event_pid')->nullable();
            $table->integer('res_id')->nullable();
            $table->string('rec_pattern', 64)->nullable();

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
        Schema::drop('dental_calendar');
    }
}
