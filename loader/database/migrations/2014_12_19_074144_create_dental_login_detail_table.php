<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDentalLoginDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dental_login_detail', function(Blueprint $table)
        {
            $table->increments('l_detailid');

            $table->integer('loginid')->default(0);
            $table->integer('userid')->default(0);
            $table->text('cur_page')->nullable();
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
        Schema::drop('dental_login_detail');
    }
}
