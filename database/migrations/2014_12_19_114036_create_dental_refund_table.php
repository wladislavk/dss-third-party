<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDentalRefundTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('dental_refund', function(Blueprint $table)
		{
			$table->increments('id');

			$table->decimal('amount', 11, 2)->nullable();
			$table->integer('userid')->nullable();
			$table->integer('adminid')->nullable();
			$table->dateTime('refund_date')->nullable();
			$table->integer('charge_id')->nullable();
			$table->string('ip_address', 5)->nullable();

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
		Schema::drop('dental_refund');
	}

}
