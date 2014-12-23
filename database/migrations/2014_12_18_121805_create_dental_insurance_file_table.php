<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDentalInsuranceFileTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('dental_insurance_file', function(Blueprint $table)
		{
			$table->increments('id');

			$table->integer('claimid');
			$table->enum('claimtype', array('primary', 'secondary'))->nullable();
			$table->string('filename', 200)->nullable();
			$table->string('ip_address', 50)->nullable();
			$table->text('description')->nullable();
			$table->integer('status')->nullable();

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
		Schema::drop('dental_insurance_file');
	}

}
