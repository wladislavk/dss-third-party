<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDentalSupportResponsesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dental_support_responses', function(Blueprint $table)
        {
            $table->increments('id');

            $table->integer('ticket_id')->nullable();
            $table->integer('responder_id')->nullable();
            $table->text('body')->nullable();
            $table->tinyInteger('response_type')->nullable();
            $table->string('ip_address', 50)->nullable();
            $table->tinyInteger('viewed')->default(0);
            $table->string('attachment')->nullable();

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
        Schema::drop('dental_support_responses');
    }
}
