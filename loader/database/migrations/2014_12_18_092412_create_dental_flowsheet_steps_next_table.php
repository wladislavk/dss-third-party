<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDentalFlowsheetStepsNextTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dental_flowsheet_steps_next', function(Blueprint $table)
        {
            $table->increments('id');

            $table->integer('parent_id')->nullable();
            $table->integer('child_id')->nullable();
            $table->integer('sort_by')->nullable();
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
        Schema::drop('dental_flowsheet_steps_next');
    }
}
