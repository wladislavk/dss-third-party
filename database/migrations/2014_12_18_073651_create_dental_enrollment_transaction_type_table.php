<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDentalEnrollmentTransactionTypeTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('dental_enrollment_transaction_type', function(Blueprint $table)
		{
			$table->increments('id');

			$table->string('transaction_type', 10)->nullable();
			$table->string('description', 200)->nullable();
			$table->string('ip_address', 50)->nullable();
			$table->tinyInteger('status')->default(1);
			$table->string('endpoint_type')->nullable();

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
		Schema::drop('dental_enrollment_transaction_type');
	}

}
