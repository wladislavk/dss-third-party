<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDentalPatientsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('dental_patients', function(Blueprint $table)
		{
			$table->increments('patientid');

			$table->string('lastname')->nullable();
			$table->string('firstname')->nullable();
			$table->string('middlename', 2)->nullable();
			$table->string('salutation')->nullable();
			$table->string('member_no');
			$table->string('group_no');
			$table->string('plan_no');
			$table->string('dob')->nullable();
			$table->string('add1')->nullable();
			$table->string('add2')->nullable();
			$table->string('city')->nullable();
			$table->string('state')->nullable();
			$table->string('zip')->nullable();
			$table->string('gender')->nullable();
			$table->string('marital_status')->nullable();
			$table->string('ssn')->nullable();
			$table->string('internal_patient')->nullable();
			$table->string('home_phone')->nullable();
			$table->string('work_phone')->nullable();
			$table->string('cell_phone')->nullable();
			$table->string('email')->nullable();
			$table->text('patient_notes')->nullable();
			$table->integer('userid')->default(0);
			$table->integer('docid')->default(0);
			$table->integer('status')->default(1);
			$table->string('ip_address', 50)->nullable();
			$table->text('p_d_party')->nullable();
			$table->text('p_d_relation')->nullable();
			$table->text('p_d_other')->nullable();
			$table->text('p_d_employer')->nullable();
			$table->text('p_d_ins_co')->nullable();
			$table->text('p_d_ins_id')->nullable();
			$table->text('s_d_party')->nullable();
			$table->text('s_d_relation')->nullable();
			$table->text('s_d_other')->nullable();
			$table->text('s_d_employer')->nullable();
			$table->text('s_d_ins_co')->nullable();
			$table->text('s_d_ins_id')->nullable();
			$table->text('p_m_partyfname')->nullable();
			$table->string('p_m_partymname');
			$table->string('p_m_partylname');
			$table->string('p_m_relation')->nullable();
			$table->string('p_m_other')->nullable();
			$table->string('p_m_employer')->nullable();
			$table->string('p_m_ins_co')->nullable();
			$table->string('p_m_ins_id')->nullable();
			$table->text('s_m_partyfname')->nullable();
			$table->text('s_m_partymname');
			$table->text('s_m_partylname');
			$table->text('s_m_relation')->nullable();
			$table->text('s_m_other')->nullable();
			$table->text('s_m_employer')->nullable();
			$table->string('s_m_ins_co')->nullable();
			$table->string('s_m_ins_id')->nullable();
			$table->string('p_m_ins_grp');
			$table->string('s_m_ins_grp');
			$table->string('p_m_ins_plan');
			$table->string('s_m_ins_plan');
			$table->string('p_m_dss_file');
			$table->string('s_m_dss_file');
			$table->string('p_m_ins_type');
			$table->string('s_m_ins_type');
			$table->string('p_m_ins_ass');
			$table->string('s_m_ins_ass');
			$table->string('ins_dob');
			$table->string('ins2_dob');
			$table->string('employer')->nullable();
			$table->string('emp_add1')->nullable();
			$table->string('emp_add2')->nullable();
			$table->string('emp_city')->nullable();
			$table->string('emp_state')->nullable();
			$table->string('emp_zip')->nullable();
			$table->text('emp_phone')->nullable();
			$table->text('emp_fax')->nullable();
			$table->text('plan_name')->nullable();
			$table->text('group_number')->nullable();
			$table->text('ins_type')->nullable();
			$table->text('accept_assignment')->nullable();
			$table->text('print_signature')->nullable();
			$table->text('medical_insurance')->nullable();
			$table->text('mark_yes')->nullable();
			$table->text('inactive')->nullable();
			$table->string('partner_name')->nullable();
			$table->string('emergency_name')->nullable();
			$table->string('emergency_number')->nullable();
			$table->string('referred_source')->nullable();
			$table->string('referred_by')->nullable();
			$table->tinyInteger('premedcheck')->default(0);
			$table->text('premed');
			$table->string('docsleep');
			$table->string('docpcp');
			$table->string('docdentist');
			$table->string('docent');
			$table->string('docmdother');
			$table->string('preferredcontact')->nullable();
			$table->string('copyreqdate')->nullable();
			$table->string('best_time', 10)->nullable();
			$table->string('best_number', 10)->nullable();
			$table->string('emergency_relationship')->nullable();
			$table->string('has_s_m_ins', 5)->nullable();
			$table->string('referred_notes')->nullable();
			$table->string('login', 100)->nullable();
			$table->string('password')->nullable();
			$table->string('salt', 100)->nullable();
			$table->string('recover_hash', 100)->nullable();
			$table->dateTime('recover_time')->nullable();
			$table->tinyInteger('registered')->nullable();
			$table->string('access_code', 100)->nullable();
			$table->integer('parent_patientid')->nullable();
			$table->string('has_p_m_ins', 5)->nullable();
			$table->integer('registration_status')->default(0);
			$table->dateTime('text_date')->nullable();
			$table->integer('text_num')->default(0);
			$table->integer('use_patient_portal')->default(1);
			$table->dateTime('registration_senton')->nullable();
			$table->string('preferred_name', 100)->nullable();
			$table->string('feet')->nullable();
			$table->string('inches')->nullable();
			$table->string('weight')->nullable();
			$table->string('bmi')->nullable();
			$table->tinyInteger('symptoms_status')->default(0);
			$table->tinyInteger('sleep_status')->default(0);
			$table->tinyInteger('treatments_status')->default(0);
			$table->tinyInteger('history_status')->default(0);
			$table->dateTime('access_code_date')->nullable();
			$table->tinyInteger('email_bounce')->default(0);
			$table->string('docmdother2');
			$table->string('docmdother3');
			$table->integer('last_reg_sect')->default(0);
			$table->integer('access_type')->default(1);
			$table->string('p_m_eligible_id', 20)->nullable();
			$table->string('p_m_eligible_payer_id', 20)->nullable();
			$table->string('p_m_eligible_payer_name', 200)->nullable();
			$table->string('p_m_gender', 20)->nullable();
			$table->string('s_m_gender', 20)->nullable();
			$table->tinyInteger('p_m_same_address')->default(1);
			$table->string('p_m_address', 100)->nullable();
			$table->string('p_m_state', 100)->nullable();
			$table->string('p_m_city', 100)->nullable();
			$table->string('p_m_zip', 20)->nullable();
			$table->tinyInteger('s_m_same_address')->default(1);
			$table->string('s_m_address', 100)->nullable();
			$table->string('s_m_city', 100)->nullable();
			$table->string('s_m_state', 100)->nullable();
			$table->string('s_m_zip', 20)->nullable();
			$table->date('new_fee_date')->nullable();
			$table->decimal('new_fee_amount', 11, 2)->nullable();
			$table->string('new_fee_desc')->nullable();
			$table->integer('new_fee_invoice_id')->nullable();
			$table->string('s_m_eligible_payer_id', 20)->nullable();
			$table->string('s_m_eligible_payer_name', 200)->nullable();

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
		Schema::drop('dental_patients');
	}

}
