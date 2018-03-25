<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDentalLedgerHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dental_ledger_history', function(Blueprint $table)
        {
            $table->increments('id');

            $table->integer('ledgerid')->default(0);
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
            $table->integer('status')->default(0);
            $table->string('adddate')->nullable();
            $table->string('ip_address', 50)->nullable();
            $table->string('transaction_code')->nullable();
            $table->string('placeofservice');
            $table->string('emg');
            $table->string('diagnosispointer');
            $table->string('daysorunits');
            $table->string('epsdt');
            $table->string('idqual');
            $table->string('modcode');
            $table->integer('producerid')->nullable();
            $table->integer('primary_claim_id')->nullable();
            $table->string('primary_paper_claim_id')->nullable();
            $table->string('modcode2')->nullable();
            $table->string('modcode3')->nullable();
            $table->string('modcode4')->nullable();
            $table->dateTime('percase_date')->nullable();
            $table->string('percase_name', 100)->nullable();
            $table->decimal('percase_amount', 11, 2)->nullable();
            $table->tinyInteger('percase_status')->default(0);
            $table->integer('percase_invoice')->nullable();
            $table->tinyInteger('percase_free')->nullable();
            $table->integer('updated_by_user')->nullable();
            $table->integer('updated_by_admin')->nullable();
            $table->integer('primary_claim_history_id')->nullable();

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
        Schema::drop('dental_ledger_history');
    }
}
