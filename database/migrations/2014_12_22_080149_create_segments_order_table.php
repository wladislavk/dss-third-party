<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSegmentsOrderTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('segments_order', function(Blueprint $table)
		{
			$table->increments('id');

			$table->string('patientid');
			$table->integer('consultrow');
			$table->integer('sleepstudyrow');
			$table->integer('delayingtreatmentrow');
			$table->integer('refusedtreatmentrow');
			$table->integer('devicedeliveryrow');
			$table->integer('checkuprow');
			$table->integer('patientnoncomprow');
			$table->integer('homesleeptestrow');
			$table->integer('starttreatmentrow');
			$table->integer('annualrecallrow');
			$table->integer('impressionrow');
			$table->integer('terminationrow');

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
		Schema::drop('segments_order');
	}

}
