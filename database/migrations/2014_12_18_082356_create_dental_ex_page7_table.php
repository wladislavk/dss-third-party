<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDentalExPage7Table extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('dental_ex_page7', function(Blueprint $table)
		{
			$table->increments('ex_page7id');

			$table->integer('formid')->default(0);
			$table->integer('patientid')->default(0);
			$table->string('sleep_study_on')->nullable();
			$table->string('sleep_study_by')->nullable();
			$table->string('assessment_chk', 50)->default(0);
			$table->string('assessment_chkyes', 50);
			$table->text('assessment')->nullable();
			$table->text('assess_addition')->nullable();
			$table->text('consultation')->nullable();
			$table->text('evaluation_new')->nullable();
			$table->text('evaluation_est')->nullable();
			$table->integer('userid')->default(0);
			$table->integer('docid')->default(0);
			$table->integer('status')->default(1);
			$table->string('ip_address', 50)->nullable();
			$table->text('additional_paragraph_candidate')->nullable();
			$table->text('additional_paragraph_suffers')->nullable();

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
		Schema::drop('dental_ex_page7');
	}

}
