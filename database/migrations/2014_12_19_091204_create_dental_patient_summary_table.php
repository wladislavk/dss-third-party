<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDentalPatientSummaryTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('dental_patient_summary', function(Blueprint $table)
		{
			$table->increments('id');

			$table->integer('pid');
			$table->integer('fspage1_complete')->nullable();
			$table->date('next_visit')->nullable();
			$table->date('last_visit')->nullable();
			$table->string('last_treatment')->nullable();
			$table->integer('appliance')->nullable();
			$table->date('delivery_date')->nullable();
			$table->string('vob')->nullable();
			$table->float('ledger')->nullable();
			$table->integer('patient_info')->nullable();

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
		Schema::drop('dental_patient_summary');
	}

}
