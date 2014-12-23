<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDentalProcedureTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('dental_procedure', function(Blueprint $table)
		{
			$table->increments('procedureid');

			$table->integer('patientid')->default(0);
			$table->integer('insuranceid')->default(0);
			$table->string('service_date_from')->nullable();
			$table->string('service_date_to')->nullable();
			$table->string('place_service')->nullable();
			$table->string('type_service')->nullable();
			$table->string('cpt_code')->nullable();
			$table->string('units')->nullable();
			$table->string('charge')->nullable();
			$table->string('total_charge')->nullable();
			$table->string('applies_icd')->nullable();
			$table->string('npi')->nullable();
			$table->string('other_id')->nullable();
			$table->string('other_id_qualifier')->nullable();
			$table->string('modifier_code_1')->nullable();
			$table->string('modifier_code_2')->nullable();
			$table->string('modifier_code_3')->nullable();
			$table->string('modifier_code_4')->nullable();
			$table->string('epsdt')->nullable();
			$table->string('emg')->nullable();
			$table->string('supplemental_info')->nullable();
			$table->integer('docid')->default(0);
			$table->integer('status')->default(1);
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
		Schema::drop('dental_procedure');
	}

}
