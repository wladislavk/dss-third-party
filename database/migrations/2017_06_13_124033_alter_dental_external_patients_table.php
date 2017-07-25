<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterDentalExternalPatientsTable extends Migration
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
        Schema::table('dental_external_patients', function (Blueprint $table) {
            $table->string('p_m_ins_plan');

            $table->dropColumn('s_m_ins_id');
            $table->dropColumn('s_m_partyfname');
            $table->dropColumn('s_m_partylname');
            $table->dropColumn('s_m_partymname');
            $table->dropColumn('s_m_address');
            $table->dropColumn('s_m_city');
            $table->dropColumn('s_m_state');
            $table->dropColumn('s_m_zip');
            $table->dropColumn('ins2_dob');
            $table->dropColumn('s_m_gender');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('dental_external_patients', function (Blueprint $table) {
            $table->dropColumn('p_m_ins_plan');

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
        });
    }
}
