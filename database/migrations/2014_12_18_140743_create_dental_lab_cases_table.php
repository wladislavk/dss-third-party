<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDentalLabCasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dental_lab_cases', function(Blueprint $table)
        {
            $table->increments('id');

            $table->integer('patient_id')->nullable();
            $table->integer('lab_id')->nullable();
            $table->integer('device_id')->nullable();
            $table->tinyInteger('status')->nullable();
            $table->text('notes')->nullable();
            $table->dateTime('sent_date')->nullable();
            $table->date('received_date')->nullable();
            $table->integer('received_user')->nullable();
            $table->integer('authorized_user')->nullable();
            $table->dateTime('authorized_date')->nullable();
            $table->string('filename', 100)->nullable();
            $table->string('ip_address', 50)->nullable();

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
        Schema::drop('dental_lab_cases');
    }
}
