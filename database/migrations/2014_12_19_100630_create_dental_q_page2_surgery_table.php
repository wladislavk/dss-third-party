<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDentalQPage2SurgeryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dental_q_page2_surgery', function(Blueprint $table)
        {
            $table->increments('id');

            $table->integer('patientid')->nullable();
            $table->string('surgery_date')->nullable();
            $table->string('surgery')->nullable();
            $table->string('surgeon')->nullable();

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
        Schema::drop('dental_q_page2_surgery');
    }
}
