<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDentalApptTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dental_appt_types', function(Blueprint $table)
        {
            $table->increments('id');

            $table->string('name')->nullable();
            $table->string('color')->nullable();
            $table->string('classname')->nullable();
            $table->integer('docid')->nullable();

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
        Schema::drop('dental_appt_types');
    }
}
