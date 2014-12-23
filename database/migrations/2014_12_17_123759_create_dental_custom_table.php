<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDentalCustomTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('dental_custom', function(Blueprint $table)
		{
			$table->increments('customid');

			$table->string('title')->nullable();
			$table->text('description')->nullable();
			$table->integer('docid')->default(0);
			$table->integer('status')->default(1);
			$table->string('ip_address', 50)->nullable();
			$table->integer('default_text')->nullable();

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
		Schema::drop('dental_custom');
	}

}
