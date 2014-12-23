<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDentalInsuranceStatusHistoryTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('dental_insurance_status_history', function(Blueprint $table)
		{
			$table->increments('id');

			$table->integer('insuranceid')->nullable();
			$table->integer('status')->nullable();
			$table->integer('userid')->nullable();
			$table->string('ip_address', 50)->nullable();
			$table->integer('adminid')->nullable();

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
		Schema::drop('dental_insurance_status_history');
	}

}
