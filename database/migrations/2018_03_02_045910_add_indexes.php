<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIndexes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared("ALTER TABLE `dental_letters` ADD INDEX `generated` (`generated_date`);");
        DB::unprepared("ALTER TABLE `dental_screener_epworth` ADD INDEX `screener_id` (`screener_id`);");
        DB::unprepared("ALTER TABLE `dental_screener_epworth` ADD INDEX `epworth_id` (`epworth_id`);");
        DB::unprepared("ALTER TABLE `dental_screener_epworth` ADD INDEX `response` (`response`);");
        DB::unprepared("ALTER TABLE `dental_q_page1` ADD INDEX `patientid` (`patientid`);");
        DB::unprepared("ALTER TABLE `dental_q_page1` ADD INDEX `parent_patientid` (`parent_patientid`);");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared("ALTER TABLE `dental_q_page1` DROP INDEX `parent_patientid`;");
        DB::unprepared("ALTER TABLE `dental_q_page1` DROP INDEX `patientid`;");
        DB::unprepared("ALTER TABLE `dental_screener_epworth` DROP INDEX `response`;");
        DB::unprepared("ALTER TABLE `dental_screener_epworth` DROP INDEX `epworth_id`;");
        DB::unprepared("ALTER TABLE `dental_screener_epworth` DROP INDEX `screener_id`;");
        DB::unprepared("ALTER TABLE `dental_letters` DROP INDEX `generated`;");
    }
}
