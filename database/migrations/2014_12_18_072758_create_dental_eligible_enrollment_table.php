<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDentalEligibleEnrollmentTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('dental_eligible_enrollment', function(Blueprint $table)
		{
			$table->increments('id');

			$table->integer('user_id')->nullable();
			$table->string('payer_id', 20)->nullable();
			$table->integer('reference_id')->nullable();
			$table->text('response')->nullable();
			$table->tinyInteger('status')->nullable();
			$table->string('ip_address', 50)->nullable();
			$table->text('payer_name')->nullable();
			$table->integer('transaction_type_id')->nullable();
			$table->integer('enrollment_invoice_id')->nullable();
			$table->string('npi', 30)->nullable();
			$table->string('facility_name', 200)->nullable();
			$table->string('provider_name', 200)->nullable();
			$table->string('tax_id', 200)->nullable();
			$table->string('address', 200)->nullable();
			$table->string('city', 200)->nullable();
			$table->string('state', 200)->nullable();
			$table->string('zip', 200)->nullable();
			$table->string('first_name', 200)->nullable();
			$table->string('last_name', 200)->nullable();
			$table->string('contact_number', 200)->nullable();
			$table->string('email', 200)->nullable();

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
		Schema::drop('dental_eligible_enrollment');
	}

}
