<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDentalClaimElectronicTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('dental_claim_electronic', function(Blueprint $table)
		{
			$table->increments('id');

			$table->integer('claimid')->nullable();
			$table->text('response')->nullable();
			$table->string('ip_address', 50)->nullable();
			$table->string('reference_id', 50)->nullable();
			$table->dateTime('percase_date')->nullable();
			$table->string('percase_name', 100)->nullable();
			$table->decimal('percase_amount', 11, 2)->nullable();
			$table->tinyInteger('percase_status')->default(0);
			$table->integer('percase_invoice')->nullable();
			$table->tinyInteger('percase_free')->nullable();

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
		Schema::drop('dental_claim_electronic');
	}

}
