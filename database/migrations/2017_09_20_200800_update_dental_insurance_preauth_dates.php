<?php

use DentalSleepSolutions\Eloquent\Models\Dental\InsurancePreauth;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class UpdateDentalInsurancePreauthDates extends Migration
{
    /**
     * @return void
     */
    public function up()
    {
        /* This change cannot be undone */
        DB::update("UPDATE dental_insurance_preauth
            SET date_completed = updated_at
            WHERE date_completed IS NULL
                AND status = ?", [InsurancePreauth::DSS_PREAUTH_COMPLETE]);
    }

    /**
     * @return void
     */
    public function down()
    {
        /* This update cannot be undone */
    }
}
