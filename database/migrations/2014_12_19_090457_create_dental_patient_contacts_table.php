<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDentalPatientContactsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('dental_patient_contacts', function(Blueprint $table)
		{
			$table->increments('id');

			$table->integer('contacttype')->nullable();
			$table->integer('patientid')->nullable();
			$table->string('firstname', 100)->nullable();
			$table->string('lastname', 100)->nullable();
			$table->string('address1', 100)->nullable();
			$table->string('address2', 100)->nullable();
			$table->string('city', 100)->nullable();
			$table->string('state', 15)->nullable();
			$table->string('zip', 15)->nullable();
			$table->string('phone', 20)->nullable();
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
		Schema::drop('dental_patient_contacts');
	}

}
