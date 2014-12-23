<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDentalTransactionCodeDocTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('dental_transaction_code_doc', function(Blueprint $table)
		{
			$table->increments('transaction_codeid');

			$table->string('transaction_code')->nullable();
			$table->text('description')->nullable();
			$table->string('type');
			$table->integer('sortby')->default(999);
			$table->integer('status')->default(1);
			$table->string('ip_address', 50);
			$table->string('doc');

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
		Schema::drop('dental_transaction_code_doc');
	}

}
