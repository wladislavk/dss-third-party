<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDentalHstTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('dental_hst', function(Blueprint $table)
		{
			$table->increments('id');

			$table->integer('doc_id')->nullable();
			$table->integer('user_id')->nullable();
			$table->integer('company_id')->nullable();
			$table->integer('patient_id')->nullable();
			$table->integer('screener_id')->nullable();
			$table->integer('ins_co_id')->nullable();
			$table->string('ins_phone', 30)->nullable();
			$table->string('patient_ins_group_id')->nullable();
			$table->string('patient_ins_id')->nullable();
			$table->string('patient_firstname')->nullable();
			$table->string('patient_lastname')->nullable();
			$table->string('patient_add1')->nullable();
			$table->string('patient_add2')->nullable();
			$table->string('patient_city')->nullable();
			$table->string('patient_state')->nullable();
			$table->string('patient_zip')->nullable();
			$table->date('patient_dob')->nullable();
			$table->string('patient_cell_phone', 30)->nullable();
			$table->string('patient_home_phone', 30)->nullable();
			$table->string('patient_email', 100)->nullable();
			$table->integer('diagnosis_id')->nullable();
			$table->integer('hst_type')->nullable();
			$table->string('provider_firstname')->nullable();
			$table->string('provider_lastname')->nullable();
			$table->string('provider_address')->nullable();
			$table->string('provider_city')->nullable();
			$table->string('provider_state')->nullable();
			$table->string('provider_zip')->nullable();
			$table->string('provider_signature', 100)->nullable();
			$table->date('provider_date')->nullable();
			$table->tinyInteger('snore_1')->nullable();
			$table->tinyInteger('snore_2')->nullable();
			$table->tinyInteger('snore_3')->nullable();
			$table->tinyInteger('snore_4')->nullable();
			$table->tinyInteger('snore_5')->nullable();
			$table->tinyInteger('viewed')->default(0);
			$table->integer('status')->nullable();
			$table->string('ip_address', 50)->nullable();
			$table->text('office_notes')->nullable();
			$table->integer('sleep_study_id')->nullable();
			$table->integer('authorized_id')->nullable();
			$table->dateTime('authorizeddate')->nullable();
			$table->dateTime('updatedate')->nullable();
			$table->text('rejected_reason')->nullable();
			$table->dateTime('rejecteddate')->nullable();

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
		Schema::drop('dental_hst');
	}

}
