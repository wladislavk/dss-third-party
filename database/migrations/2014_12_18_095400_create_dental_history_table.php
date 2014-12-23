<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDentalHistoryTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('dental_history', function(Blueprint $table)
		{
			$table->increments('historyid');

			$table->string('history')->nullable();
			$table->text('description')->nullable();
			$table->integer('sortby')->default(999);
			$table->integer('status')->default(1);
			$table->string('ip_address', 50);

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
		Schema::drop('dental_history');
	}

}
