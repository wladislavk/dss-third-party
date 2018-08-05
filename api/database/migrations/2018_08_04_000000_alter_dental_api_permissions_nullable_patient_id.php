<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterDentalApiPermissionsNullablePatientId extends Migration
{
    public function up () {
        Schema::table('dental_api_permissions', function (Blueprint $table) {
            $table->integer('patient_id')->nullable()->change();
        });
    }

    public function down () {
        Schema::table('dental_api_permissions', function (Blueprint $table) {
            $table->integer('patient_id')->change();
        });
    }
}
