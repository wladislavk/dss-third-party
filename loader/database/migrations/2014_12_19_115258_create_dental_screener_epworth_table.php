<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDentalScreenerEpworthTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dental_screener_epworth', function(Blueprint $table)
        {
            $table->increments('id');

            $table->integer('screener_id')->nullable();
            $table->integer('epworth_id')->nullable();
            $table->tinyInteger('response')->nullable();
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
        Schema::drop('dental_screener_epworth');
    }
}
