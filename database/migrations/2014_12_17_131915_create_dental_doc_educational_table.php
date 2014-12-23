<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDentalDocEducationalTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('dental_doc_educational', function(Blueprint $table)
		{
			$table->increments('doc_educationalid');

			$table->string('title')->nullable();
			$table->text('description')->nullable();
			$table->string('video_file')->nullable();
			$table->string('doc_file')->nullable();
			$table->integer('sortby')->default(999);
			$table->integer('status')->default(1);
			$table->string('ip_address')->nullable();
			$table->text('docid')->nullable();

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
		Schema::drop('dental_doc_educational');
	}

}
