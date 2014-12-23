<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDentalFlowsheetTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('dental_flowsheet', function(Blueprint $table)
		{
			$table->increments('flowsheetid');

			$table->integer('formid')->default(0);
			$table->integer('patientid')->default(0);
			$table->string('inquiry_call_apt')->nullable();
			$table->string('inquiry_call_comp')->nullable();
			$table->string('send_np')->nullable();
			$table->string('send_np_comp')->nullable();
			$table->string('acquire_ss_apt')->nullable();
			$table->string('acquire_ss_comp')->nullable();
			$table->string('referral_dss_apt')->nullable();
			$table->string('referral_dss_comp')->nullable();
			$table->string('ss_requested_apt')->nullable();
			$table->string('ss_requested_comp')->nullable();
			$table->string('ss_received_apt')->nullable();
			$table->string('ss_received_comp')->nullable();
			$table->string('consultation_apt')->nullable();
			$table->string('consultation_comp')->nullable();
			$table->string('m_insurance_apt')->nullable();
			$table->string('m_insurance_comp')->nullable();
			$table->string('select_type')->nullable();
			$table->string('exam_impressions_apt')->nullable();
			$table->string('exam_impressions_comp')->nullable();
			$table->string('ltr_physicians_apt')->nullable();
			$table->string('ltr_physicians_comp')->nullable();
			$table->string('ltr_marketing_apt')->nullable();
			$table->string('ltr_marketing_comp')->nullable();
			$table->string('delivery_device_apt')->nullable();
			$table->string('delivery_device_comp')->nullable();
			$table->string('ltr_marketing_pt_apt')->nullable();
			$table->string('ltr_marketing_pt_comp')->nullable();
			$table->string('ltr_corr_phy_apt')->nullable();
			$table->string('ltr_corr_phy_comp')->nullable();
			$table->string('first_check_apt')->nullable();
			$table->string('first_check_comp')->nullable();
			$table->string('add_check_apt')->nullable();
			$table->string('add_check_comp')->nullable();
			$table->string('home_sleep_apt')->nullable();
			$table->string('home_sleep_comp')->nullable();
			$table->string('further_checks_apt')->nullable();
			$table->string('further_checks_comp')->nullable();
			$table->string('comp_treatment_apt')->nullable();
			$table->string('comp_treatment_comp')->nullable();
			$table->string('ltr_copy_ss_apt')->nullable();
			$table->string('ltr_copy_ss_comp')->nullable();
			$table->string('annual_exam_apt')->nullable();
			$table->string('annual_exam_comp')->nullable();
			$table->string('pos_home_sleep_apt')->nullable();
			$table->string('pos_home_sleep_comp')->nullable();
			$table->string('ltr_corr_phy1_apt')->nullable();
			$table->string('ltr_corr_phy1_comp')->nullable();
			$table->string('ambulatory_ss_apt')->nullable();
			$table->string('ambulatory_ss_comp')->nullable();
			$table->string('diag_s_md_apt')->nullable();
			$table->string('diag_s_md_comp')->nullable();
			$table->string('psg_apt')->nullable();
			$table->string('psg_comp')->nullable();
			$table->string('pt_not_ds_apt')->nullable();
			$table->string('pt_not_ds_comp')->nullable();
			$table->string('not_candidate_apt')->nullable();
			$table->string('not_candidate_comp')->nullable();
			$table->string('fin_restraints_apt')->nullable();
			$table->string('fin_restraints_comp')->nullable();
			$table->string('pt_needing_apt')->nullable();
			$table->string('pt_needing_comp')->nullable();
			$table->string('inadequate_apt')->nullable();
			$table->string('inadequate_comp')->nullable();
			$table->integer('userid')->default(0);
			$table->integer('docid')->default(0);
			$table->integer('status')->default(1);
			$table->integer('step')->default(0);
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
		Schema::drop('dental_flowsheet');
	}

}
