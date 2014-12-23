<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDentalSummSleeplabTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('dental_summ_sleeplab', function(Blueprint $table)
		{
			$table->increments('id');

			$table->string('date');
			$table->string('sleeptesttype');
			$table->string('place');
			$table->string('apnea');
			$table->string('hypopnea');
			$table->string('ahi');
			$table->string('ahisupine');
			$table->string('rdi');
			$table->string('rdisupine');
			$table->string('o2nadir');
			$table->string('t9002');
			$table->string('sleepefficiency');
			$table->string('cpaplevel');
			$table->string('dentaldevice');
			$table->string('devicesetting');
			$table->string('diagnosis');
			$table->string('notes');
			$table->string('patiendid');
			$table->string('filename')->nullable();
			$table->string('testnumber')->nullable();
			$table->string('needed')->nullable();
			$table->string('scheddate')->nullable();
			$table->string('completed')->nullable();
			$table->string('interpolation')->nullable();
			$table->string('copyreqdate')->nullable();
			$table->string('sleeplab')->nullable();
			$table->string('diagnosising_doc')->nullable();
			$table->string('diagnosising_npi')->nullable();
			$table->integer('image_id')->nullable();

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
		Schema::drop('dental_summ_sleeplab');
	}

}
