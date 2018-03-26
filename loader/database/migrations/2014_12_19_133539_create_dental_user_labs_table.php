<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDentalUserLabsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dental_user_labs', function(Blueprint $table)
        {
            $table->increments('id');

            $table->integer('user_id')->nullable();
            $table->integer('lab_id')->nullable();
            $table->tinyInteger('use_lab')->nullable();
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
        Schema::drop('dental_user_labs');
    }
}
