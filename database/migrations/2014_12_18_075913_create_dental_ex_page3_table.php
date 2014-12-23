<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDentalExPage3Table extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('dental_ex_page3', function(Blueprint $table)
		{
			$table->increments('ex_page3id');

			$table->integer('formid')->default(0);
			$table->integer('patientid')->default(0);
			$table->text('maxilla')->nullable();
			$table->text('other_maxilla')->nullable();
			$table->text('mandible')->nullable();
			$table->text('other_mandible')->nullable();
			$table->text('soft_palate')->nullable();
			$table->text('other_soft_palate')->nullable();
			$table->text('uvula')->nullable();
			$table->text('other_uvula')->nullable();
			$table->text('gag_reflex')->nullable();
			$table->text('other_gag_reflex')->nullable();
			$table->text('nasal_passages')->nullable();
			$table->text('other_nasal_passages')->nullable();
			$table->integer('userid')->default(0);
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
		Schema::drop('dental_ex_page3');
	}

}
