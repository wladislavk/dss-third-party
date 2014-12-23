<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDentalLocationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('dental_locations', function(Blueprint $table)
		{
			$table->increments('id');

			$table->string('location', 100)->nullable();
			$table->integer('docid')->nullable();
			$table->string('ip_address', 50)->nullable();
			$table->string('name', 100)->nullable();
			$table->string('address', 100)->nullable();
			$table->string('city', 100)->nullable();
			$table->string('state', 20)->nullable();
			$table->string('zip', 10)->nullable();
			$table->string('phone', 20)->nullable();
			$table->string('fax', 20)->nullable();
			$table->tinyInteger('default_location')->default(0);
			$table->string('email', 100)->nullable();

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
		Schema::drop('dental_locations');
	}

}
