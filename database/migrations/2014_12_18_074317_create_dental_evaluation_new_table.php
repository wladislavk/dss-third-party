<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDentalEvaluationNewTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('dental_evaluation_new', function(Blueprint $table)
		{
			$table->increments('evaluation_newid');

			$table->string('evaluation_new')->nullable();
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
		Schema::drop('dental_evaluation_new');
	}

}
