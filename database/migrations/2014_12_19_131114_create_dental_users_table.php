<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDentalUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('dental_users', function(Blueprint $table)
		{
			$table->increments('userid');

			$table->integer('user_access')->default(1);
			$table->integer('docid')->default(0);
			$table->string('username')->nullable();
			$table->string('npi');
			$table->string('password')->nullable();
			$table->string('name')->nullable();
			$table->string('email')->nullable();
			$table->text('address')->nullable();
			$table->string('city');
			$table->string('state');
			$table->string('zip');
			$table->string('phone')->nullable();
			$table->integer('status')->default(1);
			$table->string('ip_address', 50)->nullable();
			$table->string('medicare_npi')->nullable();
			$table->string('tax_id_or_ssn')->nullable();
			$table->integer('producer')->nullable();
			$table->string('practice')->nullable();
			$table->string('email_header')->nullable();
			$table->string('email_footer')->nullable();
			$table->string('fax_header')->nullable();
			$table->string('fax_footer')->nullable();
			$table->string('salt', 100)->nullable();
			$table->string('recover_hash', 100)->nullable();
			$table->dateTime('recover_time')->nullable();
			$table->tinyInteger('ssn')->nullable();
			$table->tinyInteger('ein')->nullable();
			$table->tinyInteger('use_patient_portal')->default(0);
			$table->string('mailing_practice')->nullable();
			$table->string('mailing_name')->nullable();
			$table->text('mailing_address')->nullable();
			$table->string('mailing_city')->nullable();
			$table->string('mailing_state')->nullable();
			$table->string('mailing_zip')->nullable();
			$table->string('mailing_phone')->nullable();
			$table->dateTime('last_accessed_date')->nullable();
			$table->tinyInteger('use_digital_fax')->default(0);
			$table->string('fax');
			$table->tinyInteger('use_letters')->default(1);
			$table->tinyInteger('sign_notes')->default(0);
			$table->tinyInteger('use_eligible_api')->default(0);
			$table->string('access_code', 100)->nullable();
			$table->dateTime('text_date')->nullable();
			$table->integer('text_num')->default(0);
			$table->dateTime('access_code_date')->nullable();
			$table->dateTime('registration_email_date')->nullable();
			$table->tinyInteger('producer_files')->default(0);
			$table->string('medicare_ptan')->nullable();
			$table->tinyInteger('use_course')->default(0);
			$table->tinyInteger('use_course_staff')->default(0);
			$table->tinyInteger('manage_staff')->default(0);
			$table->string('cc_id', 150)->nullable();
			$table->tinyInteger('user_type')->default(1);
			$table->integer('letter_margin_header')->default(48);
			$table->integer('letter_margin_footer')->default(26);
			$table->integer('letter_margin_top')->default(14);
			$table->integer('letter_margin_bottom')->default(40);
			$table->integer('letter_margin_left')->default(18);
			$table->integer('letter_margin_right')->default(18);
			$table->integer('claim_margin_top')->default(0);
			$table->integer('claim_margin_left')->default(0);
			$table->string('logo', 100)->nullable();
			$table->tinyInteger('homepage')->default(0);
			$table->tinyInteger('use_letter_header')->default(1);
			$table->integer('access_code_id')->nullable();
			$table->string('first_name', 50)->nullable();
			$table->string('last_name', 50)->nullable();
			$table->tinyInteger('indent_address')->default(1);
			$table->dateTime('registration_date')->nullable();
			$table->tinyInteger('header_space')->nullable();
			$table->integer('billing_company_id')->nullable();
			$table->integer('edx_id')->nullable();
			$table->integer('help_id')->nullable();
			$table->tinyInteger('tracker_letters')->default(1);
			$table->tinyInteger('intro_letters')->default(1);
			$table->integer('plan_id')->nullable();
			$table->text('suspended_reason')->nullable();
			$table->dateTime('suspended_date')->nullable();
			$table->string('signature_file', 100)->nullable();
			$table->text('signature_json')->nullable();
			$table->tinyInteger('use_service_npi')->default(0);
			$table->string('service_name', 100)->nullable();
			$table->string('service_address', 100)->nullable();
			$table->string('service_city', 100)->nullable();
			$table->string('service_state', 100)->nullable();
			$table->string('service_zip', 100)->nullable();
			$table->string('service_phone', 100)->nullable();
			$table->string('service_fax', 100)->nullable();
			$table->string('service_npi', 100)->nullable();
			$table->string('service_medicare_npi', 100)->nullable();
			$table->string('service_medicare_ptan', 100)->nullable();
			$table->string('service_tax_id_or_ssn', 100)->nullable();
			$table->tinyInteger('service_ssn')->nullable();
			$table->tinyInteger('service_ein')->nullable();
			$table->tinyInteger('eligible_test')->default(0);
			$table->integer('billing_plan_id')->nullable();
			$table->tinyInteger('post_ledger_adjustments')->default(0);
			$table->tinyInteger('edit_ledger_entries')->default(0);

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
		Schema::drop('dental_users');
	}

}
