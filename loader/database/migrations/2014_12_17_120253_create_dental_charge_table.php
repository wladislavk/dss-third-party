<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDentalChargeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dental_charge', function(Blueprint $table)
        {
            $table->increments('id');

            $table->decimal('amount', 11, 2)->nullable();
            $table->integer('userid')->nullable();
            $table->integer('adminid')->nullable();
            $table->dateTime('charge_date')->nullable();
            $table->string('stripe_customer')->nullable();
            $table->string('stripe_charge')->nullable();
            $table->string('stripe_card_fingerprint')->nullable();
            $table->string('ip_address', 50)->nullable();
            $table->integer('invoice_id')->nullable();
            $table->integer('status')->default(1);

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
        Schema::drop('dental_charge');
    }
}
