<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDentalInsTypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dental_ins_type', function(Blueprint $table)
        {
            $table->increments('ins_typeid');

            $table->string('ins_type')->nullable();
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
        Schema::drop('dental_ins_type');
    }
}
