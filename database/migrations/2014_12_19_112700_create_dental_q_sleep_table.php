<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDentalQSleepTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dental_q_sleep', function(Blueprint $table)
        {
            $table->increments('q_sleepid');

            $table->integer('formid')->default(0);
            $table->integer('patientid')->default(0);
            $table->text('epworthid')->nullable();
            $table->text('analysis')->nullable();
            $table->integer('userid')->default(0);
            $table->integer('docid')->default(0);
            $table->integer('status')->default(1);
            $table->string('ip_address', 50)->nullable();
            $table->integer('parent_patientid')->nullable();

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
        Schema::drop('dental_q_sleep');
    }
}
