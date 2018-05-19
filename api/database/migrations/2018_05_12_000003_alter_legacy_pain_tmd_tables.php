<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AlterLegacyPainTmdTables extends Migration
{
    public function up () {
        Schema::table('dental_ex_page5', function (Blueprint $table) {
            $table->text('jointid_stages')->after('jointid');
            $table->string('initial_device_titration_1', 255)->nullable();
            $table->string('initial_device_titration_equal_h', 255)->nullable();
            $table->string('initial_device_titration_equal_v', 255)->nullable();
            $table->string('optimum_echovision_ver', 255)->nullable();
            $table->string('optimum_echovision_hor', 255)->nullable();
        });

        Schema::table('dental_ex_page1', function (Blueprint $table) {
            $table->integer('respirations')->default(0)->after('neck_measurement');
            $table->integer('feet')->default(0)->after('respirations');
            $table->integer('inches')->default(0)->after('feet');
            $table->decimal('weight')->default(0)->after('inches');
        });

        DB::statement(DB::raw("UPDATE dental_ex_page1 target
                LEFT JOIN dental_patients source ON source.patientid = target.patientid
            SET target.feet = source.feet, target.inches = source.inches,
                target.weight = source.weight, target.bmi = source.bmi
            WHERE source.patientid IS NOT NULL"));

        Schema::table('dental_q_page3', function (Blueprint $table) {
            $table->tinyInteger('premedcheck')->default(0)->after('drymouth_text');
            $table->text('premed')->after('premedcheck');
        });

        DB::statement(DB::raw("UPDATE dental_q_page3 target
                LEFT JOIN dental_patients source ON source.patientid = target.patientid
            SET target.premedcheck = source.premedcheck,
                target.premed = source.premed
            WHERE source.patientid IS NOT NULL"));
    }

    public function down () {
        Schema::table('dental_ex_page5', function (Blueprint $table) {
            $table->dropColumn('jointid_stages');
            $table->dropColumn('initial_device_titration_1');
            $table->dropColumn('initial_device_titration_equal_h');
            $table->dropColumn('initial_device_titration_equal_v');
            $table->dropColumn('optimum_echovision_ver');
            $table->dropColumn('optimum_echovision_hor');
        });

        Schema::table('dental_ex_page1', function (Blueprint $table) {
            $table->dropColumn('respirations');
            $table->dropColumn('feet');
            $table->dropColumn('inches');
            $table->dropColumn('weight');
        });

        Schema::table('dental_q_page3', function (Blueprint $table) {
            $table->dropColumn('premedcheck');
            $table->dropColumn('premed');
        });
    }
}
