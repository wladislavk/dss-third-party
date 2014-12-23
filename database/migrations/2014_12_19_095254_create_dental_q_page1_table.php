<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDentalQPage1Table extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('dental_q_page1', function(Blueprint $table)
		{
			$table->increments('q_page1id');

			$table->integer('formid')->default(0);
			$table->integer('patientid')->default(0);
			$table->string('member_no')->nullable();
			$table->string('group_no')->nullable();
			$table->string('plan_no')->nullable();
			$table->string('primary_care_physician')->nullable();
			$table->string('feet')->nullable();
			$table->string('inches')->nullable();
			$table->string('weight')->nullable();
			$table->string('bmi')->nullable();
			$table->string('sleep_qual', 3);
			$table->text('complaintid')->nullable();
			$table->text('other_complaint')->nullable();
			$table->text('additional_paragraph')->nullable();
			$table->string('energy_level')->nullable();
			$table->string('snoring_sound')->nullable();
			$table->string('wake_night')->nullable();
			$table->string('breathing_night')->nullable();
			$table->string('morning_headaches')->nullable();
			$table->string('hours_sleep')->nullable();
			$table->integer('userid')->default(0);
			$table->integer('docid')->default(0);
			$table->integer('status')->default(1);
			$table->string('ip_address', 50)->nullable();
			$table->string('quit_breathing')->nullable();
			$table->string('bed_time_partner')->default('N/A');
			$table->string('sleep_same_room')->nullable();
			$table->string('told_you_snore')->nullable();
			$table->text('main_reason')->nullable();
			$table->string('main_reason_other')->nullable();
			$table->date('exam_date')->nullable();
			$table->text('chief_complaint_text')->nullable();
			$table->string('tss', 20)->nullable();
			$table->string('ess', 20)->nullable();
			$table->integer('parent_patientid')->nullable();

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
		Schema::drop('dental_q_page1');
	}

}
