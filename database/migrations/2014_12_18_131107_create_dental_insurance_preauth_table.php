<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDentalInsurancePreauthTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('dental_insurance_preauth', function(Blueprint $table)
		{
			$table->increments('id');

			$table->integer('doc_id');
			$table->integer('patient_id');
			$table->string('ins_co')->nullable();
			$table->string('ins_rank')->default('primary');
			$table->string('ins_phone')->nullable();
			$table->string('patient_ins_group_ids')->nullable();
			$table->string('patient_ins_id')->nullable();
			$table->string('patient_firstname')->nullable();
			$table->string('patient_lastname')->nullable();
			$table->string('patient_add1')->nullable();
			$table->string('patient_add2')->nullable();
			$table->string('patient_city')->nullable();
			$table->string('patient_state')->nullable();
			$table->string('patient_zip')->nullable();
			$table->string('patient_dob')->nullable();
			$table->string('insured_first_name')->nullable();
			$table->string('insured_last_name')->nullable();
			$table->string('insured_dob')->nullable();
			$table->string('doc_npi')->nullable();
			$table->string('referring_doc_npi')->nullable();
			$table->decimal('trxn_code_amount', 11, 2)->nullable();
			$table->string('diagnosis_code')->nullable();
			$table->string('date_of_call')->nullable();
			$table->string('insurance_rep')->nullable();
			$table->string('call_reference_num')->nullable();
			$table->string('doc_medicare_npi')->nullable();
			$table->string('doc_tax_id_or_ssn')->nullable();
			$table->string('ins_effective_date')->nullable();
			$table->string('ins_cal_year_start')->nullable();
			$table->string('ins_cal_year_end')->nullable();
			$table->integer('trxn_code_covered')->default(0);
			$table->text('code_covered_notes')->nullable();
			$table->integer('has_out_of_network_benefits')->default(0);
			$table->integer('out_of_network_percentage')->nullable();
			$table->integer('is_hmo')->default(0);
			$table->string('hmo_date_called')->nullable();
			$table->string('hmo_date_received')->nullable();
			$table->integer('hmo_needs_auth')->default(0);
			$table->string('hmo_auth_date_requested')->nullable();
			$table->string('hmo_auth_date_received')->nullable();
			$table->text('hmo_auth_notes')->nullable();
			$table->integer('in_network_percentage')->nullable();
			$table->string('in_network_appeal_date_sent')->nullable();
			$table->string('in_network_appeal_date_received')->nullable();
			$table->integer('is_pre_auth_required')->default(0);
			$table->string('verbal_pre_auth_name')->nullable();
			$table->string('verbal_pre_auth_ref_num')->nullable();
			$table->text('verbal_pre_auth_notes')->nullable();
			$table->text('written_pre_auth_notes')->nullable();
			$table->string('written_pre_auth_date_received')->nullable();
			$table->date('front_office_request_date')->nullable();
			$table->integer('status')->default(0);
			$table->decimal('patient_deductible', 11, 2)->nullable();
			$table->decimal('patient_amount_met', 11, 2)->nullable();
			$table->decimal('family_deductible', 11, 2)->nullable();
			$table->decimal('family_amount_met', 11, 2)->nullable();
			$table->string('deductible_reset_date')->nullable();
			$table->integer('out_of_pocket_met')->default(0);
			$table->decimal('patient_amount_left_to_meet', 11, 2)->nullable();
			$table->decimal('expected_insurance_payment', 11, 2)->nullable();
			$table->decimal('expected_patient_payment', 11, 2)->nullable();
			$table->integer('network_benefits')->default(0);
			$table->integer('viewed')->nullable();
			$table->dateTime('date_completed')->nullable();
			$table->integer('userid')->nullable();
			$table->string('how_often')->nullable();
			$table->string('patient_phone')->nullable();
			$table->string('pre_auth_num')->nullable();
			$table->decimal('family_amount_left_to_meet', 11, 2)->nullable();
			$table->integer('deductible_from')->default(0);
			$table->text('reject_reason')->nullable();
			$table->dateTime('invoice_date')->nullable();
			$table->decimal('invoice_amount', 11, 2)->nullable();
			$table->tinyInteger('invoice_status')->default(0);
			$table->integer('invoice_id')->nullable();
			$table->integer('updated_by')->nullable();
			$table->string('doc_name', 200)->nullable();
			$table->string('doc_practice', 200)->nullable();
			$table->string('doc_address', 200)->nullable();
			$table->string('doc_phone', 200)->nullable();
			$table->integer('in_deductible_from')->nullable();
			$table->decimal('in_patient_deductible', 11, 2)->nullable();
			$table->decimal('in_patient_amount_met', 11, 2)->nullable();
			$table->decimal('in_patient_amount_left_to_meet', 11, 2)->nullable();
			$table->decimal('in_family_deductible', 11, 2)->nullable();
			$table->decimal('in_family_amount_met', 11, 2)->nullable();
			$table->decimal('in_family_amount_left_to_meet', 11, 2)->nullable();
			$table->string('in_deductible_reset_date')->nullable();
			$table->integer('in_out_of_pocket_met')->default(0);
			$table->decimal('in_expected_insurance_payment', 11, 2)->nullable();
			$table->decimal('in_expected_patient_payment', 11, 2)->nullable();
			$table->string('in_call_reference_num')->nullable();
			$table->integer('has_in_network_benefits')->nullable();
			$table->integer('in_is_pre_auth_required')->nullable();
			$table->string('in_verbal_pre_auth_name')->nullable();
			$table->string('in_verbal_pre_auth_ref_num')->nullable();
			$table->text('in_verbal_pre_auth_notes')->nullable();
			$table->string('in_written_pre_auth_date_received')->nullable();
			$table->string('in_pre_auth_num')->nullable();
			$table->text('in_written_pre_auth_notes')->nullable();

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
		Schema::drop('dental_insurance_preauth');
	}

}
