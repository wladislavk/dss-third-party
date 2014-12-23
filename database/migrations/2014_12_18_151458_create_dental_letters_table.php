<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDentalLettersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('dental_letters', function(Blueprint $table)
		{
			$table->increments('letterid');

			$table->integer('patientid')->nullable();
			$table->integer('stepid')->nullable();
			$table->dateTime('generated_date')->nullable();
			$table->dateTime('delivery_date')->nullable();
			$table->string('send_method')->nullable();
			$table->text('template')->nullable();
			$table->string('pdf_path')->nullable();
			$table->tinyInteger('status')->nullable();
			$table->tinyInteger('delivered')->nullable();
			$table->tinyInteger('deleted')->nullable();
			$table->integer('templateid')->nullable();
			$table->integer('parentid')->nullable();
			$table->tinyInteger('topatient')->nullable();
			$table->string('md_list')->nullable();
			$table->string('md_referral_list')->nullable();
			$table->integer('docid')->nullable();
			$table->integer('userid')->nullable();
			$table->dateTime('date_sent')->nullable();
			$table->integer('info_id')->nullable();
			$table->integer('edit_userid')->nullable();
			$table->dateTime('edit_date')->nullable();
			$table->dateTime('mailed_date')->nullable();
			$table->tinyInteger('mailed_once')->default(0);
			$table->tinyInteger('template_type')->default(0);
			$table->tinyInteger('cc_topatient')->nullable();
			$table->string('cc_md_list')->nullable();
			$table->string('cc_md_referral_list')->nullable();
			$table->string('font_family', 50)->default('dejavusans');
			$table->integer('font_size')->default(10);
			$table->string('pat_referral_list')->nullable();
			$table->string('cc_pat_referral_list')->nullable();
			$table->integer('deleted_by')->nullable();
			$table->dateTime('deleted_on')->nullable();

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
		Schema::drop('dental_letters');
	}

}
