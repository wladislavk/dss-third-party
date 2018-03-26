<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDentalFollowupTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dental_followup', function(Blueprint $table)
        {
            $table->increments('followupid');

            $table->string('followup')->nullable();
            $table->text('description')->nullable();
            $table->integer('sortby')->default(999);
            $table->integer('status')->default(1);
            $table->string('ip_address', 50);

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
        Schema::drop('dental_followup');
    }
}
