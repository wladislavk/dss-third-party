<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDentalEligibilityTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('dental_eligibility', function(Blueprint $table)
		{
			$table->increments('id');

			$table->integer('patientid')->nullable();
			$table->integer('userid')->nullable();
			$table->dateTime('request_date')->nullable();
			$table->string('eligible_id')->nullable();
			$table->string('pi_name')->nullable();
			$table->integer('pi_id')->nullable();
			$table->string('pi_group_name')->nullable();
			$table->date('pi_plan_begins')->nullable();
			$table->date('pi_plan_ends')->nullable();
			$table->text('pi_comments')->nullable();
			$table->decimal('pi_deductible_in_individual_base_period', 11, 2)->nullable();
			$table->decimal('pi_deductible_in_individual_remaining', 11, 2)->nullable();
			$table->text('pi_deductible_in_individual_comments')->nullable();
			$table->decimal('pi_deductible_in_family_base_period', 11, 2)->nullable();
			$table->decimal('pi_deductible_in_family_remaining', 11, 2)->nullable();
			$table->text('pi_deductible_in_family_comments')->nullable();
			$table->decimal('pi_deductible_out_individual_base_period', 11, 2)->nullable();
			$table->decimal('pi_deductible_out_individual_remaining', 11, 2)->nullable();
			$table->text('pi_deductible_out_individual_comments')->nullable();
			$table->decimal('pi_deductible_out_family_base_period', 11, 2)->nullable();
			$table->decimal('pi_deductible_out_family_remaining', 11, 2)->nullable();
			$table->text('pi_deductible_out_family_comments')->nullable();
			$table->decimal('pi_stop_loss_in_individual_base_period', 11, 2)->nullable();
			$table->decimal('pi_stop_loss_in_individual_remaining', 11, 2)->nullable();
			$table->text('pi_stop_loss_in_individual_comments')->nullable();
			$table->decimal('pi_stop_loss_in_family_base_period', 11, 2)->nullable();
			$table->decimal('pi_stop_loss_in_family_remaining', 11, 2)->nullable();
			$table->text('pi_stop_loss_in_family_comments')->nullable();
			$table->decimal('pi_stop_loss_out_individual_base_period', 11, 2)->nullable();
			$table->decimal('pi_stop_loss_out_individual_remaining', 11, 2)->nullable();
			$table->text('pi_stop_loss_out_individual_comments')->nullable();
			$table->decimal('pi_stop_loss_out_family_base_period', 11, 2)->nullable();
			$table->decimal('pi_stop_loss_out_family_remaining', 11, 2)->nullable();
			$table->text('pi_stop_loss_out_family_comments')->nullable();
			$table->decimal('pi_balance', 11, 2)->nullable();
			$table->integer('medical_care_coverage_status')->nullable();
			$table->integer('medical_care_coinsurance_in_individual_percent')->nullable();
			$table->text('medical_care_coinsurance_in_individual_comments')->nullable();
			$table->integer('medical_care_coinsurance_in_family_percent')->nullable();
			$table->text('medical_care_coinsurance_in_family_comments')->nullable();
			$table->integer('medical_care_coinsurance_out_individual_percent')->nullable();
			$table->text('medical_care_coinsurance_out_individual_comments')->nullable();
			$table->integer('medical_care_coinsurance_out_family_percent')->nullable();
			$table->text('medical_care_coinsurance_out_family_comments')->nullable();
			$table->decimal('medical_care_copayment_in_individual_amount', 11, 2)->nullable();
			$table->text('medical_care_copayment_in_individual_comments')->nullable();
			$table->decimal('medical_care_copayment_in_family_amount', 11, 2)->nullable();
			$table->text('medical_care_copayment_in_family_comments')->nullable();
			$table->decimal('medical_care_copayment_out_individual_amount', 11, 2)->nullable();
			$table->text('medical_care_copayment_out_individual_comments')->nullable();
			$table->decimal('medical_care_copayment_out_family_amount', 11, 2)->nullable();
			$table->text('medical_care_copayment_out_family_comments')->nullable();
			$table->decimal('medical_care_deductible_in_individual_base_period', 11, 2)->nullable();
			$table->decimal('medical_care_deductible_in_individual_remaining', 11, 2)->nullable();
			$table->text('medical_care_deductible_in_individual_comments')->nullable();
			$table->decimal('medical_care_deductible_in_family_base_period', 11, 2)->nullable();
			$table->decimal('medical_care_deductible_in_family_remaining', 11, 2)->nullable();
			$table->text('medical_care_deductible_in_family_comments')->nullable();
			$table->decimal('medical_care_deductible_out_individual_base_period', 11, 2)->nullable();
			$table->decimal('medical_care_deductible_out_individual_remaining', 11, 2)->nullable();
			$table->text('medical_care_deductible_out_individual_comments')->nullable();
			$table->decimal('medical_care_deductible_out_family_base_period', 11, 2)->nullable();
			$table->decimal('medical_care_deductible_out_family_remaining', 11, 2)->nullable();
			$table->text('medical_care_deductible_out_family_comments')->nullable();
			$table->string('medical_care_precertification_needed', 100)->nullable();
			$table->integer('medical_care_visits_in_individual_total')->nullable();
			$table->integer('medical_care_visits_in_individual_remaining')->nullable();
			$table->text('medical_care_visits_in_individual_comments')->nullable();
			$table->integer('medical_care_visits_in_family_total')->nullable();
			$table->integer('medical_care_visits_in_family_remaining')->nullable();
			$table->text('medical_care_visits_in_family_comments')->nullable();
			$table->integer('medical_care_visits_out_individual_total')->nullable();
			$table->integer('medical_care_visits_out_individual_remaining')->nullable();
			$table->text('medical_care_visits_out_individual_comments')->nullable();
			$table->integer('medical_care_visits_out_family_total')->nullable();
			$table->integer('medical_care_visits_out_family_remaining')->nullable();
			$table->text('medical_care_visits_out_family_comments')->nullable();
			$table->text('medical_care_additional_insurance_comments')->nullable();
			$table->integer('medical_equipment_coverage_status')->nullable();
			$table->integer('medical_equipment_coinsurance_in_individual_percent')->nullable();
			$table->text('medical_equipment_coinsurance_in_individual_comments')->nullable();
			$table->integer('medical_equipment_coinsurance_in_family_percent')->nullable();
			$table->text('medical_equipment_coinsurance_in_family_comments')->nullable();
			$table->integer('medical_equipment_coinsurance_out_individual_percent')->nullable();
			$table->text('medical_equipment_coinsurance_out_individual_comments')->nullable();
			$table->integer('medical_equipment_coinsurance_out_family_percent')->nullable();
			$table->text('medical_equipment_coinsurance_out_family_comments')->nullable();
			$table->decimal('medical_equipment_copayment_in_individual_amount', 11, 2)->nullable();
			$table->text('medical_equipment_copayment_in_individual_comments')->nullable();
			$table->decimal('medical_equipment_copayment_in_family_amount', 11, 2)->nullable();
			$table->text('medical_equipment_copayment_in_family_comments')->nullable();
			$table->decimal('medical_equipment_copayment_out_individual_amount', 11, 2)->nullable();
			$table->text('medical_equipment_copayment_out_individual_comments')->nullable();
			$table->decimal('medical_equipment_copayment_out_family_amount', 11, 2)->nullable();
			$table->text('medical_equipment_copayment_out_family_comments')->nullable();
			$table->decimal('medical_equipment_deductible_in_individual_base_period', 11, 2)->nullable();
			$table->decimal('medical_equipment_deductible_in_individual_remaining', 11, 2)->nullable();
			$table->text('medical_equipment_deductible_in_individual_comments')->nullable();
			$table->decimal('medical_equipment_deductible_in_family_base_period', 11, 2)->nullable();
			$table->decimal('medical_equipment_deductible_in_family_remaining', 11, 2)->nullable();
			$table->text('medical_equipment_deductible_in_family_comments')->nullable();
			$table->decimal('medical_equipment_deductible_out_individual_base_period', 11, 2)->nullable();
			$table->decimal('medical_equipment_deductible_out_individual_remaining', 11, 2)->nullable();
			$table->text('medical_equipment_deductible_out_individual_comments')->nullable();
			$table->decimal('medical_equipment_deductible_out_family_base_period', 11, 2)->nullable();
			$table->decimal('medical_equipment_deductible_out_family_remaining', 11, 2)->nullable();
			$table->text('medical_equipment_deductible_out_family_comments')->nullable();
			$table->string('medical_equipment_precertification_needed', 100)->nullable();
			$table->integer('medical_equipment_visits_in_individual_total')->nullable();
			$table->integer('medical_equipment_visits_in_individual_remaining')->nullable();
			$table->text('medical_equipment_visits_in_individual_comments')->nullable();
			$table->integer('medical_equipment_visits_in_family_total')->nullable();
			$table->integer('medical_equipment_visits_in_family_remaining')->nullable();
			$table->text('medical_equipment_visits_in_family_comments')->nullable();
			$table->integer('medical_equipment_visits_out_individual_total')->nullable();
			$table->integer('medical_equipment_visits_out_individual_remaining')->nullable();
			$table->text('medical_equipment_visits_out_individual_comments')->nullable();
			$table->integer('medical_equipment_visits_out_family_total')->nullable();
			$table->integer('medical_equipment_visits_out_family_remaining')->nullable();
			$table->text('medical_equipment_visits_out_family_comments')->nullable();
			$table->text('medical_equipment_additional_insurance_comments')->nullable();
			$table->integer('plan_coverage_coverage_status')->nullable();
			$table->integer('plan_coverage_coinsurance_in_individual_percent')->nullable();
			$table->text('plan_coverage_coinsurance_in_individual_comments')->nullable();
			$table->integer('plan_coverage_coinsurance_in_family_percent')->nullable();
			$table->text('plan_coverage_coinsurance_in_family_comments')->nullable();
			$table->integer('plan_coverage_coinsurance_out_individual_percent')->nullable();
			$table->text('plan_coverage_coinsurance_out_individual_comments')->nullable();
			$table->integer('plan_coverage_coinsurance_out_family_percent')->nullable();
			$table->text('plan_coverage_coinsurance_out_family_comments')->nullable();
			$table->decimal('plan_coverage_copayment_in_individual_amount', 11, 2)->nullable();
			$table->text('plan_coverage_copayment_in_individual_comments')->nullable();
			$table->decimal('plan_coverage_copayment_in_family_amount', 11, 2)->nullable();
			$table->text('plan_coverage_copayment_in_family_comments')->nullable();
			$table->decimal('plan_coverage_copayment_out_individual_amount', 11, 2)->nullable();
			$table->text('plan_coverage_copayment_out_individual_comments')->nullable();
			$table->decimal('plan_coverage_copayment_out_family_amount', 11, 2)->nullable();
			$table->text('plan_coverage_copayment_out_family_comments')->nullable();
			$table->decimal('plan_coverage_deductible_in_individual_base_period', 11, 2)->nullable();
			$table->decimal('plan_coverage_deductible_in_individual_remaining', 11, 2)->nullable();
			$table->text('plan_coverage_deductible_in_individual_comments')->nullable();
			$table->decimal('plan_coverage_deductible_in_family_base_period', 11, 2)->nullable();
			$table->decimal('plan_coverage_deductible_in_family_remaining', 11, 2)->nullable();
			$table->text('plan_coverage_deductible_in_family_comments')->nullable();
			$table->decimal('plan_coverage_deductible_out_individual_base_period', 11, 2)->nullable();
			$table->decimal('plan_coverage_deductible_out_individual_remaining', 11, 2)->nullable();
			$table->text('plan_coverage_deductible_out_individual_comments')->nullable();
			$table->decimal('plan_coverage_deductible_out_family_base_period', 11, 2)->nullable();
			$table->decimal('plan_coverage_deductible_out_family_remaining', 11, 2)->nullable();
			$table->text('plan_coverage_deductible_out_family_comments')->nullable();
			$table->string('plan_coverage_precertification_needed', 100)->nullable();
			$table->integer('plan_coverage_visits_in_individual_total')->nullable();
			$table->integer('plan_coverage_visits_in_individual_remaining')->nullable();
			$table->text('plan_coverage_visits_in_individual_comments')->nullable();
			$table->integer('plan_coverage_visits_in_family_total')->nullable();
			$table->integer('plan_coverage_visits_in_family_remaining')->nullable();
			$table->text('plan_coverage_visits_in_family_comments')->nullable();
			$table->integer('plan_coverage_visits_out_individual_total')->nullable();
			$table->integer('plan_coverage_visits_out_individual_remaining')->nullable();
			$table->text('plan_coverage_visits_out_individual_comments')->nullable();
			$table->integer('plan_coverage_visits_out_family_total')->nullable();
			$table->integer('plan_coverage_visits_out_family_remaining')->nullable();
			$table->text('plan_coverage_visits_out_family_comments')->nullable();
			$table->text('plan_coverage_additional_insurance_comments')->nullable();
			$table->string('ip_address', 50)->nullable();
			$table->text('response')->nullable();
			$table->integer('eligibility_invoice_id')->nullable();

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
		Schema::drop('dental_eligibility');
	}

}
