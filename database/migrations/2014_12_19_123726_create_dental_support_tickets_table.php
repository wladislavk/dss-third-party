<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDentalSupportTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dental_support_tickets', function(Blueprint $table)
        {
            $table->increments('id');

            $table->string('title')->nullable();
            $table->integer('userid')->nullable();
            $table->integer('docid')->nullable();
            $table->text('body')->nullable();
            $table->integer('category_id')->nullable();
            $table->tinyInteger('status')->default(0);
            $table->string('ip_address', 50)->nullable();
            $table->string('attachment')->nullable();
            $table->tinyInteger('viewed')->default(0);
            $table->integer('creator_id')->nullable();
            $table->tinyInteger('create_type')->nullable();
            $table->integer('company_id')->default(0);

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
        Schema::drop('dental_support_tickets');
    }
}
