<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDentalLetterTemplatesCustomTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dental_letter_templates_custom', function(Blueprint $table)
        {
            $table->increments('id');

            $table->string('name')->nullable();
            $table->text('body')->nullable();
            $table->integer('docid')->nullable();
            $table->string('ip_address', 50)->nullable();
            $table->tinyInteger('status')->default(1);

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
        Schema::drop('dental_letter_templates_custom');
    }
}
