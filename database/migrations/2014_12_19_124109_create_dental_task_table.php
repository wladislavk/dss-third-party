<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDentalTaskTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('dental_task', function(Blueprint $table)
		{
			$table->increments('id');

			$table->string('task')->nullable();
			$table->text('description')->nullable();
			$table->integer('userid')->nullable();
			$table->integer('responsibleid')->nullable();
			$table->integer('status')->nullable();
			$table->dateTime('due_date')->nullable();
			$table->integer('recurring')->nullable();
			$table->tinyInteger('recurring_unit')->nullable();
			$table->string('ip_address', 50)->nullable();
			$table->integer('patientid')->nullable();

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
		Schema::drop('dental_task');
	}

}
