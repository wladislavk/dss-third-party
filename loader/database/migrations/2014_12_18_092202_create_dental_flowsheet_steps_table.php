<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDentalFlowsheetStepsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dental_flowsheet_steps', function(Blueprint $table)
        {
            $table->increments('id');

            $table->string('name')->nullable();
            $table->integer('sort_by')->nullable();
            $table->integer('section')->nullable();
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
        Schema::drop('dental_flowsheet_steps');
    }
}
