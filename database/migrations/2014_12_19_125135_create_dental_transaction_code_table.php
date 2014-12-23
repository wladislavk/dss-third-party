<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDentalTransactionCodeTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('dental_transaction_code', function(Blueprint $table)
		{
			$table->increments('transaction_codeid');

			$table->string('transaction_code')->nullable();
			$table->text('description')->nullable();
			$table->string('type');
			$table->integer('sortby')->default(999);
			$table->integer('status')->default(1);
			$table->string('ip_address', 50);
			$table->integer('default_code')->nullable();
			$table->integer('docid')->nullable();
			$table->decimal('amount', 11, 2)->nullable();
			$table->integer('place')->nullable();
			$table->string('modifier_code_1')->nullable();
			$table->string('modifier_code_2')->nullable();
			$table->integer('days_units')->nullable();
			$table->tinyInteger('amount_adjust')->default(0);

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
		Schema::drop('dental_transaction_code');
	}

}
