<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFlowsheetStepRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('flowsheet_step_records', function(Blueprint $table)
        {
            $table->increments('id');

            $table->integer('patientid');
            $table->integer('stepid');
            $table->string('completed');
            $table->string('scheduled');
            $table->string('generated');
            $table->string('approved');
            $table->string('via');

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
        Schema::drop('flowsheet_step_records');
    }
}
