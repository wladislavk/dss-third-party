<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminDentalsummfuTssTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('dentalsummfu_tss', function(Blueprint $table)
		{
			$table->increments('id');

			$table->integer('followupid')->nullable();
			$table->integer('thorntonid')->nullable();
			$table->tinyInteger('answer')->nullable();
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
		Schema::drop('dentalsummfu_tss');
	}

}
