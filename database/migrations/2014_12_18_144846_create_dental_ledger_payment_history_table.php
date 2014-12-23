<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDentalLedgerPaymentHistoryTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('dental_ledger_payment_history', function(Blueprint $table)
		{
			$table->increments('id');

			$table->integer('paymentid')->default(0);
			$table->integer('payer')->nullable();
			$table->decimal('amount', 11, 2)->nullable();
			$table->integer('payment_type')->nullable();
			$table->date('payment_date')->nullable();
			$table->date('entry_date')->nullable();
			$table->integer('ledgerid')->nullable();
			$table->decimal('allowed', 11, 2)->default(0.00);
			$table->decimal('ins_paid', 11, 2)->default(0.00);
			$table->decimal('deductible', 11, 2)->default(0.00);
			$table->decimal('copay', 11, 2)->default(0.00);
			$table->decimal('coins', 11, 2)->default(0.00);
			$table->decimal('overpaid', 11, 2)->default(0.00);
			$table->dateTime('followup')->nullable();
			$table->string('note')->nullable();
			$table->decimal('amount_allowed', 11, 2)->nullable();
			$table->integer('updated_by_user')->nullable();
			$table->integer('updated_by_admin')->nullable();

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
		Schema::drop('dental_ledger_payment_history');
	}

}
