<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDentalPercaseInvoiceExtraTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dental_percase_invoice_extra', function(Blueprint $table)
        {
            $table->increments('id');

            $table->date('percase_date')->nullable();
            $table->string('percase_name')->nullable();
            $table->decimal('percase_amount', 11, 2)->nullable();
            $table->tinyInteger('percase_status')->default(0);
            $table->integer('percase_invoice')->nullable();
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
        Schema::drop('dental_percase_invoice_extra');
    }
}
