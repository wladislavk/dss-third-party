<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDentalLoginTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dental_login', function(Blueprint $table)
        {
            $table->increments('loginid');

            $table->integer('docid')->default(0);
            $table->integer('userid')->default(0);
            $table->dateTime('login_date')->nullable();
            $table->dateTime('logout_date')->nullable();
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
        Schema::drop('dental_login');
    }
}
