<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDentalExPage5Table extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('dental_ex_page5', function(Blueprint $table)
		{
			$table->increments('ex_page5id');

			$table->integer('formid')->default(0);
			$table->integer('patientid')->default(0);
			$table->text('palpationid')->nullable();
			$table->text('palpationRid')->nullable();
			$table->text('additional_paragraph_pal')->nullable();
			$table->text('joint_exam')->nullable();
			$table->text('jointid')->nullable();
			$table->string('i_opening_from')->nullable();
			$table->string('i_opening_to')->nullable();
			$table->string('i_opening_equal')->nullable();
			$table->string('protrusion_from')->nullable();
			$table->string('protrusion_to')->nullable();
			$table->string('protrusion_equal')->nullable();
			$table->string('l_lateral_from')->nullable();
			$table->string('l_lateral_to')->nullable();
			$table->string('l_lateral_equal')->nullable();
			$table->string('r_lateral_from')->nullable();
			$table->string('r_lateral_to')->nullable();
			$table->string('r_lateral_equal')->nullable();
			$table->string('deviation_from')->nullable();
			$table->string('deviation_to')->nullable();
			$table->string('deviation_equal')->nullable();
			$table->string('deflection_from')->nullable();
			$table->string('deflection_to')->nullable();
			$table->string('deflection_equal')->nullable();
			$table->string('range_normal')->nullable();
			$table->string('normal')->nullable();
			$table->text('other_range_motion')->nullable();
			$table->text('additional_paragraph_rm')->nullable();
			$table->string('screening_aware')->nullable();
			$table->string('screening_normal')->nullable();
			$table->integer('userid')->default(0);
			$table->integer('docid')->default(0);
			$table->integer('status')->default(1);
			$table->string('ip_address', 50)->nullable();
			$table->string('deviation_r_l')->nullable();
			$table->string('deflection_r_l')->nullable();
			$table->integer('dentaldevice')->nullable();
			$table->date('dentaldevice_date')->nullable();

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
		Schema::drop('dental_ex_page5');
	}

}
