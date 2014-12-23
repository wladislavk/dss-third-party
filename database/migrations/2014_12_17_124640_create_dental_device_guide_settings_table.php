<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDentalDeviceGuideSettingsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('dental_device_guide_settings', function(Blueprint $table)
		{
			$table->increments('id');

			$table->string('name')->nullable();
			$table->tinyInteger('setting_type')->nullable();
			$table->integer('range_start')->nullable();
			$table->integer('range_end')->nullable();
			$table->string('ip_address', 50)->nullable();
			$table->integer('rank')->nullable();
			$table->integer('options')->nullable();
			$table->string('range_start_label', 100)->nullable();
			$table->string('range_end_label', 100)->nullable();

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
		Schema::drop('dental_device_guide_settings');
	}

}
