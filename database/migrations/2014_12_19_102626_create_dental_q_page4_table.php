<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDentalQPage4Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dental_q_page4', function(Blueprint $table)
        {
            $table->increments('q_page4id');

            $table->integer('formid')->default(0);
            $table->integer('patientid')->default(0);
            $table->string('family_had')->nullable();
            $table->string('family_diagnosed')->nullable();
            $table->text('additional_paragraph')->nullable();
            $table->string('alcohol')->nullable();
            $table->string('sedative')->nullable();
            $table->string('caffeine')->nullable();
            $table->string('smoke')->nullable();
            $table->string('smoke_packs')->nullable();
            $table->string('tobacco')->nullable();
            $table->integer('userid')->default(0);
            $table->integer('docid')->default(0);
            $table->integer('status')->default(1);
            $table->string('ip_address', 50)->nullable();
            $table->integer('parent_patientid')->nullable();

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
        Schema::drop('dental_q_page4');
    }
}
