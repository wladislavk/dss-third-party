<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDentalContactTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('dental_contact', function(Blueprint $table)
		{
			$table->increments('contactid');

			$table->integer('docid')->default(0);
			$table->string('salutation')->nullable();
			$table->string('lastname')->nullable();
			$table->string('firstname')->nullable();
			$table->string('middlename')->nullable();
			$table->string('company')->nullable();
			$table->string('add1')->nullable();
			$table->string('add2')->nullable();
			$table->string('city')->nullable();
			$table->string('state')->nullable();
			$table->string('zip')->nullable();
			$table->string('phone1')->nullable();
			$table->string('phone2')->nullable();
			$table->string('fax')->nullable();
			$table->string('email')->nullable();
			$table->string('national_provider_id')->nullable();
			$table->string('qualifier')->nullable();
			$table->string('qualifierid')->nullable();
			$table->string('greeting')->nullable();
			$table->string('sincerely')->nullable();
			$table->integer('contacttypeid')->default(0);
			$table->text('notes')->nullable();
			$table->string('preferredcontact');
			$table->integer('status')->default(1);
			$table->string('ip_address', 50)->nullable();
			$table->integer('referredby_info')->nullable();
			$table->text('referredby_notes')->nullable();
			$table->integer('merge_id')->nullable();
			$table->dateTime('merge_date')->nullable();
			$table->tinyInteger('corporate')->default(0);
			$table->string('dea_number', 100)->nullable();

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
		Schema::drop('dental_contact');
	}

}
