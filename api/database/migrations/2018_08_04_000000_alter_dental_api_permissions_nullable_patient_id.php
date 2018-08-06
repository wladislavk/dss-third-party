<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterDentalApiPermissionsNullablePatientId extends Migration
{
    public function up () {
        Schema::table('dental_api_permissions', function (Blueprint $table) {
            $table->integer('patient_id')->nullable()->change();
        });
        DB::statement(DB::raw("UPDATE dental_api_permissions SET patient_id = NULL WHERE patient_id = 0"));
    }

    public function down () {
        Schema::table('dental_api_permissions', function (Blueprint $table) {
            $table->integer('patient_id')->change();
        });
        DB::statement(DB::raw("UPDATE dental_api_permissions SET patient_id = 0 WHERE patient_id IS NULL"));
    }
}
