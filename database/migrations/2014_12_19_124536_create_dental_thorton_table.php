<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDentalThortonTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dental_thorton', function(Blueprint $table)
        {
            $table->increments('thortonid');

            $table->integer('formid')->default(0);
            $table->integer('patientid')->default(0);
            $table->string('snore_1')->nullable();
            $table->string('snore_2')->nullable();
            $table->string('snore_3')->nullable();
            $table->string('snore_4')->nullable();
            $table->string('snore_5')->nullable();
            $table->string('tot_score')->nullable();
            $table->integer('userid')->default(0);
            $table->integer('docid')->default(0);
            $table->integer('status')->default(1);
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
        Schema::drop('dental_thorton');
    }
}
