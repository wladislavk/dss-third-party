<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDentalAllergensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dental_allergens', function(Blueprint $table)
        {
            $table->increments('id');

            $table->string('allergens')->nullable();
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
        Schema::drop('dental_allergens');
    }
}
