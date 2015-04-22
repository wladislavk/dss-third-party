<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFlowsheetSegmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('flowsheet_segments', function(Blueprint $table)
        {
            $table->increments('id');

            $table->string('section');
            $table->longText('content');
            $table->integer('sortby');

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
        Schema::drop('flowsheet_segments');
    }
}
