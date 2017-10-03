<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterDentalInsurancePreauthTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /**
         * Patient data received by the endpoint, links to internal patients
         */
        Schema::table('dental_insurance_preauth', function (Blueprint $table) {
            $table->string('patient_work_phone', 20);
            $table->string('patient_cell_phone', 20);
            $table->string('patient_email');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('dental_insurance_preauth', function (Blueprint $table) {
            $table->dropColumn('patient_work_phone');
            $table->dropColumn('patient_cell_phone');
            $table->dropColumn('patient_email');
        });
    }
}
