<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDentalEligibleResponseTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('dental_eligible_response', function(Blueprint $table)
		{
			$table->increments('id');

			$table->string('claimid')->nullable();
			$table->text('response')->nullable();
			$table->string('event_type', 50)->nullable();
			$table->string('ip_address', 50)->nullable();
			$table->string('reference_id', 50)->nullable();

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
		Schema::drop('dental_eligible_response');
	}

}
