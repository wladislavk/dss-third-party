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

        // Indexes
        Schema::table('dental_external_companies', function (Blueprint $table) {
            $table->unique('software');
            $table->index('api_key');
            $table->index('created_by');
            $table->index('updated_by');
        });

        /**
         * User details when they are allowed to use external software
         */
        Schema::create('dental_external_users', function (Blueprint $table) {
            $table->increments('id');

            // Fields equivalent to username/password
            $table->integer('user_id');
            $table->string('api_key');
            $table->timestamp('valid_from');
            $table->timestamp('valid_to');
            $table->tinyInteger('enabled');

            $table->integer('created_by');
            $table->integer('updated_by');

            $table->timestamps();
        });

        // Indexes
        Schema::table('dental_external_users', function (Blueprint $table) {
            $table->unique('user_id');
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

            // Flag to determine if the data was updated via the API
            $table->boolean('dirty')->default(0);

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

            // Fields duplicated from patient table
            $table->string('lastname');
            $table->string('middlename');
            $table->string('firstname');
            $table->string('salutation');
            $table->string('dob');
            $table->string('ssn');
            $table->string('gender');
            $table->string('marital_status');
            $table->string('feet');
            $table->string('inches');
            $table->string('weight');
            $table->string('add1');
            $table->string('add2');
            $table->string('city');
            $table->string('state');
            $table->string('zip');
            $table->string('home_phone');
            $table->string('work_phone');
            $table->string('cell_phone');
            $table->string('email');
            $table->string('p_m_relation');
            $table->string('p_m_ins_id');
            $table->string('p_m_partyfname');
            $table->string('p_m_partylname');
            $table->string('p_m_partymname');
            $table->string('p_m_address');
            $table->string('p_m_city');
            $table->string('p_m_state');
            $table->string('p_m_zip');
            $table->string('ins_dob');
            $table->string('p_m_gender');
            $table->string('p_m_ins_grp');
            $table->string('s_m_ins_id');
            $table->string('s_m_partyfname');
            $table->string('s_m_partylname');
            $table->string('s_m_partymname');
            $table->string('s_m_address');
            $table->string('s_m_city');
            $table->string('s_m_state');
            $table->string('s_m_zip');
            $table->string('ins2_dob');
            $table->string('s_m_gender');

            $table->timestamps();
        });

        // Indexes
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

        // Indexes
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
