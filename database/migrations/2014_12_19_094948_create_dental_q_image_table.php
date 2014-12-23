<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDentalQImageTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('dental_q_image', function(Blueprint $table)
		{
			$table->increments('imageid');

			$table->integer('formid')->default(0);
			$table->integer('patientid')->default(0);
			$table->string('title')->nullable();
			$table->string('image_file')->nullable();
			$table->integer('imagetypeid')->default(0);
			$table->integer('userid')->default(0);
			$table->integer('docid')->default(0);
			$table->integer('status')->default(1);
			$table->string('ip_address', 50)->nullable();
			$table->integer('adminid')->nullable();

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
		Schema::drop('dental_q_image');
	}

}
