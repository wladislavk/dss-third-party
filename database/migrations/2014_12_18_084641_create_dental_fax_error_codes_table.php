<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDentalFaxErrorCodesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('dental_fax_error_codes', function(Blueprint $table)
		{
			$table->increments('id');

			$table->string('error_code', 10)->nullable();
			$table->string('description')->nullable();
			$table->text('resolution')->nullable();
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
		Schema::drop('dental_fax_error_codes');
	}

}
