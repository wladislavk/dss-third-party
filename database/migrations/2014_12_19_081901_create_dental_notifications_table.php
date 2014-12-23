<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDentalNotificationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('dental_notifications', function(Blueprint $table)
		{
			$table->increments('id');

			$table->integer('patientid')->nullable();
			$table->integer('docid')->nullable();
			$table->string('notification')->nullable();
			$table->string('notification_type', 100)->nullable();
			$table->integer('status')->nullable();
			$table->dateTime('notification_date')->nullable();

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
		Schema::drop('dental_notifications');
	}

}
