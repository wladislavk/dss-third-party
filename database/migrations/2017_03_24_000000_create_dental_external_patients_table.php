<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDentalExternalPatientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
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
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('dental_external_patients');
    }
}
