<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompaniesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('companies', function(Blueprint $table)
		{
			$table->increments('id');

			$table->string('name')->nullable();
			$table->string('add1', 100)->nullable();
			$table->string('add2', 100)->nullable();
			$table->string('city', 100)->nullable();
			$table->string('state', 100)->nullable();
			$table->string('zip', 15)->nullable();
			$table->tinyInteger('status')->default(0);
			$table->string('ip_address', 50)->nullable();
			$table->string('eligible_api_key')->nullable();
			$table->string('stripe_secret_key')->nullable();
			$table->string('stripe_publishable_key')->nullable();
			$table->string('logo', 100)->nullable();
			$table->decimal('monthly_fee', 11, 2)->default(0.00);
			$table->tinyInteger('default_new')->default(0);
			$table->string('sfax_security_context')->nullable();
			$table->string('sfax_app_id')->nullable();
			$table->string('sfax_app_key')->nullable();
			$table->string('sfax_init_vector')->nullable();
			$table->decimal('fax_fee', 11, 2)->default(0.00);
			$table->integer('free_fax')->default(0);
			$table->tinyInteger('company_type')->default(1);
			$table->string('phone', 30)->nullable();
			$table->string('fax', 30)->nullable();
			$table->string('email', 70)->nullable();
			$table->integer('plan_id')->nullable();
			$table->string('sfax_encryption_key')->nullable();
			$table->tinyInteger('use_support')->default(1);
			$table->tinyInteger('exclusive')->default(0);
			$table->tinyInteger('vob_require_test')->default(1);
			
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
		Schema::drop('companies');
	}

}
