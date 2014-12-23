<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('admin', function(Blueprint $table)
		{
			$table->increments('adminid');

			$table->string('name', 250)->nullable();
			$table->string('username', 250)->nullable();
			$table->string('password', 250)->nullable();
			$table->integer('status')->default(1);
			$table->string('ip_address', 50)->nullable();
			$table->string('salt', 100)->nullable();
			$table->string('recover_hash', 100)->nullable();
			$table->dateTime('recover_time')->nullable();
			$table->integer('admin_access');
			$table->dateTime('last_accessed_date')->nullable();
			$table->integer('claim_margin_top');
			$table->integer('claim_margin_left');
			$table->string('email', 100)->nullable();
			$table->string('first_name', 50)->nullable();
			$table->string('last_name', 50)->nullable();
			
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
		Schema::drop('admin');
	}

}
