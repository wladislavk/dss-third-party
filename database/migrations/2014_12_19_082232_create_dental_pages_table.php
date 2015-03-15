<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDentalPagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dental_pages', function(Blueprint $table)
        {
            $table->increments('pageid');

            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->integer('status')->default(1);
            $table->string('ip_address', 50)->nullable();
            $table->text('keywords')->nullable();

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
        Schema::drop('dental_pages');
    }
}
