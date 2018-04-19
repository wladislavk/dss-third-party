<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

// cannot be done using Blueprint, as Eloquent does not support tables without a PK
class PatientSummariesPrimaryKey extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared("ALTER TABLE `dental_patient_summary` ADD PRIMARY KEY (`pid`);");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared("ALTER TABLE `dental_patient_summary` DROP PRIMARY KEY;");
    }
}
