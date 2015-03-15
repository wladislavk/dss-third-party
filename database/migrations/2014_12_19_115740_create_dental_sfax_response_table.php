<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDentalSfaxResponseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dental_sfax_response', function(Blueprint $table)
        {
            $table->increments('id');

            $table->string('fax_number', 20)->nullable();
            $table->text('response')->nullable();
            $table->integer('userid')->nullable();
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
        Schema::drop('dental_sfax_response');
    }
}
