<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDentalExPage1Table extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('dental_ex_page1', function(Blueprint $table)
		{
			$table->increments('ex_page1id');

			$table->integer('formid')->default(0);
			$table->integer('patientid')->default(0);
			$table->string('blood_pressure')->nullable();
			$table->string('pulse')->nullable();
			$table->string('neck_measurement')->nullable();
			$table->string('bmi')->nullable();
			$table->text('additional_paragraph')->nullable();
			$table->text('tongue')->nullable();
			$table->integer('userid')->default(0);
			$table->integer('docid')->default(0);
			$table->integer('status')->status(1);
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
		Schema::drop('dental_ex_page1');
	}

}
