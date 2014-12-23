<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMembersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('members', function(Blueprint $table)
		{
			$table->increments('id');

			$table->string('username', 65);
			$table->string('password', 65);
			$table->timestamp('date_subscribe');
			$table->string('name', 65);
			$table->string('img_profil', 65);
			$table->string('key_m', 65);
			$table->string('status', 20)->default('offline');
			$table->string('timer')->default(0);

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
		Schema::drop('members');
	}

}
