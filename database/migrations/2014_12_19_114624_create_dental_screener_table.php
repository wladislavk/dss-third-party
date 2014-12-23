<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDentalScreenerTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('dental_screener', function(Blueprint $table)
		{
			$table->increments('id');

			$table->integer('docid')->nullable();
			$table->integer('userid')->nullable();
			$table->string('first_name', 50)->nullable();
			$table->string('last_name', 50)->nullable();
			$table->string('email', 70)->nullable();
			$table->tinyInteger('epworth_reading')->default(0);
			$table->tinyInteger('epworth_public')->default(0);
			$table->tinyInteger('epworth_passenger')->default(0);
			$table->tinyInteger('epworth_lying')->default(0);
			$table->tinyInteger('epworth_talking')->default(0);
			$table->tinyInteger('epworth_lunch')->default(0);
			$table->tinyInteger('epworth_traffic')->default(0);
			$table->tinyInteger('snore_1')->default(0);
			$table->tinyInteger('snore_2')->default(0);
			$table->tinyInteger('snore_3')->default(0);
			$table->tinyInteger('snore_4')->default(0);
			$table->tinyInteger('snore_5')->default(0);
			$table->tinyInteger('breathing')->default(0);
			$table->tinyInteger('driving')->default(0);
			$table->tinyInteger('gasping')->default(0);
			$table->tinyInteger('sleepy')->default(0);
			$table->tinyInteger('snore')->default(0);
			$table->tinyInteger('weight_gain')->default(0);
			$table->tinyInteger('blood_pressure')->default(0);
			$table->tinyInteger('jerk')->default(0);
			$table->tinyInteger('burning')->default(0);
			$table->tinyInteger('headaches')->default(0);
			$table->tinyInteger('falling_asleep')->default(0);
			$table->tinyInteger('staying_asleep')->default(0);
			$table->tinyInteger('rx_blood_pressure')->default(0);
			$table->tinyInteger('rx_hypertension')->default(0);
			$table->tinyInteger('rx_heart_disease')->default(0);
			$table->tinyInteger('rx_stroke')->default(0);
			$table->tinyInteger('rx_apnea')->default(0);
			$table->tinyInteger('rx_diabetes')->default(0);
			$table->tinyInteger('rx_lung_disease')->default(0);
			$table->tinyInteger('rx_insomnia')->default(0);
			$table->tinyInteger('rx_depression')->default(0);
			$table->tinyInteger('rx_narcolepsy')->default(0);
			$table->tinyInteger('rx_medication')->default(0);
			$table->tinyInteger('rx_restless_leg')->default(0);
			$table->tinyInteger('rx_headaches')->default(0);
			$table->tinyInteger('rx_heartburn')->default(0);
			$table->string('ip_address', 50)->nullable();
			$table->tinyInteger('rx_cpap')->default(0);
			$table->string('phone', 30)->nullable();
			$table->tinyInteger('contacted')->default(0);
			$table->integer('patient_id')->nullable();

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
		Schema::drop('dental_screener');
	}

}
