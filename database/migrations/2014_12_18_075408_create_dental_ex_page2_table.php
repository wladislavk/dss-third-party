<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDentalExPage2Table extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('dental_ex_page2', function(Blueprint $table)
		{
			$table->increments('ex_page2id');

			$table->integer('formid')->default(0);
			$table->integer('patientid')->default(0);
			$table->string('mallampati')->nullable();
			$table->text('tonsils')->nullable();
			$table->string('tonsils_grade')->nullable();
			$table->integer('userid')->default(0);
			$table->integer('docid')->default(0);
			$table->integer('status')->default(1);
			$table->string('ip_address', 50)->nullable();
			$table->text('additional_notes')->nullable();

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
		Schema::drop('dental_ex_page2');
	}

}
