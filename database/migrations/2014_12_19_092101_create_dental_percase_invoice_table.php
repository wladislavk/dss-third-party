<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDentalPercaseInvoiceTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('dental_percase_invoice', function(Blueprint $table)
		{
			$table->increments('id');

			$table->integer('adminid')->nullable();
			$table->integer('docid')->nullable();
			$table->string('ip_address', 50)->nullable();
			$table->date('monthly_fee_date')->nullable();
			$table->decimal('monthly_fee_amount', 11, 2)->nullable();
			$table->tinyInteger('status')->default(0);
			$table->date('due_date')->nullable();
			$table->integer('companyid')->nullable();
			$table->date('user_fee_date')->nullable();
			$table->decimal('user_fee_amount', 11, 2)->nullable();
			$table->date('producer_fee_date')->nullable();
			$table->decimal('producer_fee_amount', 11, 2)->nullable();
			$table->string('user_fee_desc')->nullable();
			$table->string('producer_fee_desc')->nullable();
			$table->tinyInteger('invoice_type')->default(1);

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
		Schema::drop('dental_percase_invoice');
	}

}
