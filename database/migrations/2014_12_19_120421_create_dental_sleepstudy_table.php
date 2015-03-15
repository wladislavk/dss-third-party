<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDentalSleepstudyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dental_sleepstudy', function(Blueprint $table)
        {
            $table->increments('id');

            $table->string('testnumber');
            $table->string('docid');
            $table->string('patientid');
            $table->string('needed');
            $table->string('scheddate');
            $table->string('sleeplabwheresched');
            $table->string('completed');
            $table->string('interpolation');
            $table->string('labtype');
            $table->string('copyreqdate');
            $table->string('sleeplab');
            $table->string('scanext');
            $table->string('date');
            $table->string('filename')->nullable();

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
        Schema::drop('dental_sleepstudy');
    }
}
