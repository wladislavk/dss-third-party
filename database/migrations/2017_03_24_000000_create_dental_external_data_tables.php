<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDentalExternalDataTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /**
         * Software companies that send data to the External Patient endpoint
         */
        Schema::create('dental_external_companies', function (Blueprint $table) {
            $table->increments('id');

            // Fields equivalent to username/password
            $table->string('software');
            $table->string('api_key');
            $table->timestamp('valid_from');
            $table->timestamp('valid_to');

            $table->string('name');
            $table->string('short_name');
            $table->string('url');
            $table->text('description');

            $table->smallInteger('status')->default(1);
            $table->text('reason');

            $table->integer('created_by');
            $table->integer('updated_by');

            $table->timestamps();
        });

        Schema::table('dental_external_companies', function (Blueprint $table) {
            $table->unique('software');
            $table->index('api_key');
            $table->index('created_by');
            $table->index('updated_by');
        });

        /**
         * Patient data received by the endpoint, links to internal patients
         */
        Schema::create('dental_external_patients', function (Blueprint $table) {
            $table->increments('id');
            $table->string('software');
            $table->string('external_id');

            // Foreign key
            $table->integer('patient_id');

            // Payer fields not present in patient table
            $table->string('payer_name');
            $table->string('payer_address1');
            $table->string('payer_address2');
            $table->string('payer_city');
            $table->string('payer_state');
            $table->string('payer_zip');
            $table->string('payer_phone');
            $table->string('payer_fax');

            // Extra fields not present in patient table
            $table->string('subscriber_phone');
            $table->string('dependent_phone');

            $table->timestamps();
        });

        Schema::table('dental_external_patients', function (Blueprint $table) {
            $table->index('software');
            $table->index('external_id');
            $table->index('patient_id');
        });

        /**
         * Pivot between external companies and users
         */
        Schema::create('dental_external_company_user', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('user_id');
            $table->integer('company_id');

            $table->integer('created_by');
            $table->timestamp('created_at');
        });

        Schema::table('dental_external_company_user', function (Blueprint $table) {
            $table->unique(['user_id', 'company_id']);
            $table->index('created_by');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dental_external_patients');
        Schema::dropIfExists('dental_external_companies');
        Schema::dropIfExists('dental_external_company_user');
    }
}
