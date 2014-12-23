<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDentalLedgerStatementTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('dental_ledger_statement', function(Blueprint $table)
		{
			$table->increments('id');

			$table->integer('producerid')->nullable();
			$table->string('filename', 100)->nullable();
			$table->date('service_date')->nullable();
			$table->date('entry_date')->nullable();
			$table->integer('patientid')->nullable();
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
		Schema::drop('dental_ledger_statement');
	}

}
