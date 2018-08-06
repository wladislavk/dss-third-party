<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterDentalApiPermissionsNullablePatientId extends Migration
{
    public function up () {
        DB::statement(DB::raw("ALTER TABLE dental_api_permissions MODIFY patient_id INT(11) DEFAULT NULL"));
        DB::statement(DB::raw("UPDATE dental_api_permissions SET patient_id = NULL WHERE patient_id = 0"));
    }

    public function down () {
        DB::statement(DB::raw("UPDATE dental_api_permissions SET patient_id = 0 WHERE patient_id IS NULL"));
        DB::statement(DB::raw("ALTER TABLE dental_api_permissions MODIFY patient_id INT(11) NOT NULL DEFAULT 0"));
    }
}
