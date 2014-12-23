<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDentalDeviceGuideSettingOptionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('dental_device_guide_setting_options', function(Blueprint $table)
		{
			$table->increments('id');

			$table->integer('option_id')->nullable();
			$table->integer('setting_id')->nullable();
			$table->string('label', 100)->nullable();
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
		Schema::drop('dental_device_guide_setting_options');
	}

}
