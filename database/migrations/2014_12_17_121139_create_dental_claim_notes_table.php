<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDentalClaimNotesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('dental_claim_notes', function(Blueprint $table)
		{
			$table->increments('id');

			$table->integer('claim_id')->nullable();
			$table->integer('create_type')->nullable();
			$table->integer('creator_id')->nullable();
			$table->text('note')->nullable();
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
		Schema::drop('dental_claim_notes');
	}

}
