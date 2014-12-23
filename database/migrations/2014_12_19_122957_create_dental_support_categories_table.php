<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDentalSupportCategoriesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('dental_support_categories', function(Blueprint $table)
		{
			$table->increments('id');

			$table->string('title')->nullable();
			$table->tinyInteger('status')->default(0);
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
		Schema::drop('dental_support_categories');
	}

}
