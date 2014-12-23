<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDentalAccessCodesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('dental_access_codes', function(Blueprint $table)
		{
			$table->increments('id');

			$table->string('access_code', 50)->nullable();
			$table->text('notes')->nullable();
			$table->tinyInteger('status')->default(1);
			$table->string('ip_address', 50)->nullable();
			$table->integer('plan_id')->nullable();

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
		Schema::drop('dental_access_codes');
	}

}
