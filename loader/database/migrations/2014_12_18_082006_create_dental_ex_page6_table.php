<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDentalExPage6Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dental_ex_page6', function(Blueprint $table)
        {
            $table->increments('ex_page6id');

            $table->integer('formid')->default(0);
            $table->integer('patientid')->default(0);
            $table->text('completed')->nullable();
            $table->text('recommended')->nullable();
            $table->text('other_diagnostic')->nullable();
            $table->text('additional_paragraph')->nullable();
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
        Schema::drop('dental_ex_page6');
    }
}
