<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDentalDeviceGuideDeviceSettingTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('dental_device_guide_device_setting', function(Blueprint $table)
		{
			$table->increments('id');

			$table->integer('device_id')->nullable();
			$table->integer('setting_id')->nullable();
			$table->integer('value')->nullable();
			$table->string('ip_address', 50)->nullable();

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
		Schema::drop('dental_device_guide_device_setting');
	}

}
