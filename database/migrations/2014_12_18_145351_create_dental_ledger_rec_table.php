<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDentalLedgerRecTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dental_ledger_rec', function(Blueprint $table)
        {
            $table->increments('ledgerid');

            $table->integer('formid')->default(0);
            $table->integer('patientid')->default(0);
            $table->string('service_date')->nullable();
            $table->string('entry_date')->nullable();
            $table->string('description')->nullable();
            $table->string('producer')->nullable();
            $table->float('amount')->nullable();
            $table->string('transaction_type')->nullable();
            $table->float('paid_amount')->nullable();
            $table->integer('userid')->default(0);
            $table->integer('docid')->default(0);
            $table->integer('status')->default(1);
            $table->string('ip_address', 50)->nullable();
            $table->string('transaction_code')->nullable();

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
        Schema::drop('dental_ledger_rec');
    }
}
