<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateDentalNotesInsuranceHistoryEligibilityIndexes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dental_notes', function (Blueprint $table) {
            $table->index('adddate', 'adddate');
            $table->index('signed_on', 'signed_on');
        });

        Schema::table('dental_insurance_history', function (Blueprint $table) {
            $table->index('insuranceid', 'insuranceid');
        });

        Schema::table('dental_eligibility', function (Blueprint $table) {
            $table->index('patientid', 'patientid');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('dental_notes', function (Blueprint $table) {
            $table->dropIndex('adddate');
            $table->dropIndex('signed_on');
        });

        Schema::table('dental_insurance_history', function (Blueprint $table) {
            $table->dropIndex('insuranceid');
        });

        Schema::table('dental_eligibility', function (Blueprint $table) {
            $table->dropIndex('patientid');
        });
    }
}
