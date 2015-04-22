<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDentalFlowPg2InfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dental_flow_pg2_info', function(Blueprint $table)
        {
            $table->increments('id');

            $table->integer('patientid')->nullable();
            $table->integer('stepid')->nullable();
            $table->integer('segmentid')->nullable();
            $table->date('date_scheduled')->nullable();
            $table->date('date_completed')->nullable();
            $table->string('delay_reason', 32)->nullable();
            $table->string('study_type', 16)->nullable();
            $table->string('letterid')->nullable();
            $table->string('description')->nullable();
            $table->string('noncomp_reason')->nullable();
            $table->date('device_date')->nullable();
            $table->tinyInteger('appointment_type')->default(1);
            $table->integer('device_id')->nullable();

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
        Schema::drop('dental_flow_pg2_info');
    }
}
