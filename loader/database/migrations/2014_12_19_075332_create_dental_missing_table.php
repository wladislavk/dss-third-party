<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDentalMissingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dental_missing', function(Blueprint $table)
        {
            $table->increments('missingid');

            $table->integer('formid')->default(0);
            $table->integer('patientid')->default(0);
            $table->text('pck')->nullable();
            $table->text('rec')->nullable();
            $table->text('mob')->nullable();
            $table->text('rec1')->nullable();
            $table->text('pck1')->nullable();
            $table->string('s1', 50)->nullable();
            $table->string('s2', 50)->nullable();
            $table->string('s3', 50)->nullable();
            $table->string('s4', 50)->nullable();
            $table->string('s5', 50)->nullable();
            $table->string('s6', 50)->nullable();
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
        Schema::drop('dental_missing');
    }
}
