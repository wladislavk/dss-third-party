<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDentalFlowsheetNewTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('dental_flowsheet_new', function(Blueprint $table)
		{
			$table->increments('flowsheetid');

			$table->integer('formid')->default(0);
			$table->integer('patientid')->default(0);
			$table->string('inquiry_call_comp')->nullable();
			$table->string('send_np')->nullable();
			$table->string('send_np_comp')->nullable();
			$table->string('acquire_ss_apt')->nullable();
			$table->string('acquire_ss_comp')->nullable();
			$table->string('pt_not_ss')->nullable();
			$table->string('ss_date_requested')->nullable();
			$table->string('ss_date_received')->nullable();
			$table->string('date_referred')->nullable();
			$table->string('dss_dentists')->nullable();
			$table->string('ss_requested_apt')->nullable();
			$table->string('ss_requested_comp')->nullable();
			$table->string('ss_received_apt')->nullable();
			$table->string('ss_received_comp')->nullable();
			$table->string('consultation_apt')->nullable();
			$table->string('consultation_comp')->nullable();
			$table->string('m_insurance_date')->nullable();
			$table->string('select_type')->nullable();
			$table->string('exam_impressions_apt')->nullable();
			$table->string('exam_impressions_comp')->nullable();
			$table->string('dsr_prepared')->nullable();
			$table->string('dsr_sent')->nullable();
			$table->string('delivery_device_apt')->nullable();
			$table->string('delivery_device_comp')->nullable();
			$table->string('dsr_date_delivered')->nullable();
			$table->string('ltr_phy_prepared')->nullable();
			$table->string('ltr_phy_sent')->nullable();
			$table->string('first_check_apt')->nullable();
			$table->string('first_check_comp')->nullable();
			$table->string('add_check_apt')->nullable();
			$table->string('add_check_comp')->nullable();
			$table->string('home_sleep_apt')->nullable();
			$table->string('home_sleep_comp')->nullable();
			$table->string('further_checks_apt')->nullable();
			$table->string('further_checks_comp')->nullable();
			$table->string('comp_treatment_date')->nullable();
			$table->string('portable_date_comp')->nullable();
			$table->string('treatment_success')->nullable();
			$table->string('ltr_doc_ss_date_prepared')->nullable();
			$table->string('ltr_doc_ss_date_sent')->nullable();
			$table->string('annual_exam_apt')->nullable();
			$table->string('annual_exam_comp')->nullable();
			$table->string('ltr_doc_pt_date_prepared')->nullable();
			$table->string('ltr_doc_pt_date_sent')->nullable();
			$table->string('ambulatory_ss_apt')->nullable();
			$table->string('ambulatory_ss_comp')->nullable();
			$table->string('diag_s_md_sent')->nullable();
			$table->string('diag_s_md_received')->nullable();
			$table->string('psg_apt')->nullable();
			$table->string('psg_comp')->nullable();
			$table->string('sleep_lab')->nullable();
			$table->string('lomn')->nullable();
			$table->string('rxfrommd')->nullable();
			$table->string('not_candidate')->nullable();
			$table->string('financial_restraints')->nullable();
			$table->string('pt_needing_dental_work')->nullable();
			$table->string('inadequate_dentition')->nullable();
			$table->string('pt_not_ds_other')->nullable();
			$table->string('ltr_pp_date_prepared')->nullable();
			$table->string('ltr_pp_date_sent')->nullable();
			$table->integer('userid')->default(0);
			$table->integer('docid')->default(0);
			$table->integer('status')->default(1);
			$table->string('ip_address', 50)->nullable();
			$table->integer('step')->default(0);
			$table->integer('sstep')->default(0);

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
		Schema::drop('dental_flowsheet_new');
	}

}
