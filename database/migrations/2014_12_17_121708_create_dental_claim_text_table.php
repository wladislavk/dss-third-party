<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDentalClaimTextTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('dental_claim_text', function(Blueprint $table)
		{
			$table->increments('id');

			$table->string('title', 100)->nullable();
			$table->text('description')->nullable();
			$table->string('ip_address', 50)->nullable();
			$table->tinyInteger('default_text')->nullable();
			$table->integer('companyid')->nullable();

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
		Schema::drop('dental_claim_text');
	}

}
