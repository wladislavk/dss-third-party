<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDentalLedgerNoteTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('dental_ledger_note', function(Blueprint $table)
		{
			$table->increments('id');

			$table->integer('producerid')->nullable();
			$table->text('note')->nullable();
			$table->integer('private')->nullable();
			$table->date('service_date')->nullable();
			$table->date('entry_date')->nullable();
			$table->integer('patientid')->nullable();
			$table->string('ip_address', 50)->nullable();
			$table->integer('docid')->nullable();
			$table->integer('admin_producerid')->nullable();

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
		Schema::drop('dental_ledger_note');
	}

}
