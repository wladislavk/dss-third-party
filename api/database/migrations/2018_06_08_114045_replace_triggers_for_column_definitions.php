<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ReplaceTriggersForColumnDefinitions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared("ALTER TABLE `dental_ex_page1` MODIFY `adddate` DATETIME NULL DEFAULT CURRENT_TIMESTAMP;");
        DB::unprepared("ALTER TABLE `dental_ex_page1` MODIFY `updated_at` TIMESTAMP on update CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP;");
        DB::unprepared("ALTER TABLE `dental_ex_page2` MODIFY `adddate` DATETIME NULL DEFAULT CURRENT_TIMESTAMP;");
        DB::unprepared("ALTER TABLE `dental_ex_page2` MODIFY `updated_at` TIMESTAMP on update CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP;");
        DB::unprepared("ALTER TABLE `dental_ex_page3` MODIFY `adddate` DATETIME NULL DEFAULT CURRENT_TIMESTAMP;");
        DB::unprepared("ALTER TABLE `dental_ex_page3` MODIFY `updated_at` TIMESTAMP on update CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP;");
        DB::unprepared("ALTER TABLE `dental_ex_page4` MODIFY `adddate` DATETIME NULL DEFAULT CURRENT_TIMESTAMP;");
        DB::unprepared("ALTER TABLE `dental_ex_page4` MODIFY `updated_at` TIMESTAMP on update CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP;");
        DB::unprepared("ALTER TABLE `dental_ex_page5` MODIFY `adddate` DATETIME NULL DEFAULT CURRENT_TIMESTAMP;");
        DB::unprepared("ALTER TABLE `dental_ex_page5` MODIFY `updated_at` TIMESTAMP on update CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP;");
        DB::unprepared("ALTER TABLE `dental_ex_page6` MODIFY `adddate` DATETIME NULL DEFAULT CURRENT_TIMESTAMP;");
        DB::unprepared("ALTER TABLE `dental_ex_page6` MODIFY `updated_at` TIMESTAMP on update CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP;");
        DB::unprepared("ALTER TABLE `dental_ex_page7` MODIFY `adddate` DATETIME NULL DEFAULT CURRENT_TIMESTAMP;");
        DB::unprepared("ALTER TABLE `dental_ex_page7` MODIFY `updated_at` TIMESTAMP on update CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP;");
        DB::unprepared("ALTER TABLE `dental_ex_page8` MODIFY `adddate` DATETIME NULL DEFAULT CURRENT_TIMESTAMP;");
        DB::unprepared("ALTER TABLE `dental_ex_page8` MODIFY `updated_at` TIMESTAMP on update CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP;");
        DB::unprepared("ALTER TABLE `dental_missing` MODIFY `adddate` DATETIME NULL DEFAULT CURRENT_TIMESTAMP;");
        DB::unprepared("ALTER TABLE `dental_missing` MODIFY `updated_at` TIMESTAMP on update CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP;");
        DB::unprepared("ALTER TABLE `dental_q_page1` MODIFY `adddate` DATETIME NULL DEFAULT CURRENT_TIMESTAMP;");
        DB::unprepared("ALTER TABLE `dental_q_page1` MODIFY `updated_at` TIMESTAMP on update CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP;");
        DB::unprepared("ALTER TABLE `dental_q_page2` MODIFY `adddate` DATETIME NULL DEFAULT CURRENT_TIMESTAMP;");
        DB::unprepared("ALTER TABLE `dental_q_page2` MODIFY `updated_at` TIMESTAMP on update CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP;");
        DB::unprepared("ALTER TABLE `dental_q_page3` MODIFY `adddate` DATETIME NULL DEFAULT CURRENT_TIMESTAMP;");
        DB::unprepared("ALTER TABLE `dental_q_page3` MODIFY `updated_at` TIMESTAMP on update CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP;");
        DB::unprepared("ALTER TABLE `dental_q_page4` MODIFY `adddate` DATETIME NULL DEFAULT CURRENT_TIMESTAMP;");
        DB::unprepared("ALTER TABLE `dental_q_page4` MODIFY `updated_at` TIMESTAMP on update CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP;");
        DB::unprepared("ALTER TABLE `dental_q_sleep` MODIFY `adddate` DATETIME NULL DEFAULT CURRENT_TIMESTAMP;");
        DB::unprepared("ALTER TABLE `dental_q_sleep` MODIFY `updated_at` TIMESTAMP on update CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP;");
        DB::unprepared("ALTER TABLE `dental_summary` MODIFY `adddate` DATETIME NULL DEFAULT CURRENT_TIMESTAMP;");
        DB::unprepared("ALTER TABLE `dental_summary` MODIFY `updated_at` TIMESTAMP on update CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP;");
        DB::unprepared("ALTER TABLE `dental_thorton` MODIFY `adddate` DATETIME NULL DEFAULT CURRENT_TIMESTAMP;");
        DB::unprepared("ALTER TABLE `dental_thorton` MODIFY `updated_at` TIMESTAMP on update CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP;");

        DB::unprepared("DROP TRIGGER IF EXISTS `insert_dental_ex_page1`;");
        DB::unprepared("DROP TRIGGER IF EXISTS `update_dental_ex_page1`;");
        DB::unprepared("DROP TRIGGER IF EXISTS `insert_dental_ex_page2`;");
        DB::unprepared("DROP TRIGGER IF EXISTS `update_dental_ex_page2`;");
        DB::unprepared("DROP TRIGGER IF EXISTS `insert_dental_ex_page3`;");
        DB::unprepared("DROP TRIGGER IF EXISTS `update_dental_ex_page3`;");
        DB::unprepared("DROP TRIGGER IF EXISTS `insert_dental_ex_page4`;");
        DB::unprepared("DROP TRIGGER IF EXISTS `update_dental_ex_page4`;");
        DB::unprepared("DROP TRIGGER IF EXISTS `insert_dental_ex_page5`;");
        DB::unprepared("DROP TRIGGER IF EXISTS `update_dental_ex_page5`;");
        DB::unprepared("DROP TRIGGER IF EXISTS `insert_dental_ex_page6`;");
        DB::unprepared("DROP TRIGGER IF EXISTS `update_dental_ex_page6`;");
        DB::unprepared("DROP TRIGGER IF EXISTS `insert_dental_ex_page7`;");
        DB::unprepared("DROP TRIGGER IF EXISTS `update_dental_ex_page7`;");
        DB::unprepared("DROP TRIGGER IF EXISTS `insert_dental_ex_page8`;");
        DB::unprepared("DROP TRIGGER IF EXISTS `update_dental_ex_page8`;");
        DB::unprepared("DROP TRIGGER IF EXISTS `insert_dental_missing`;");
        DB::unprepared("DROP TRIGGER IF EXISTS `update_dental_missing`;");
        DB::unprepared("DROP TRIGGER IF EXISTS `insert_dental_q_page1`;");
        DB::unprepared("DROP TRIGGER IF EXISTS `update_dental_q_page1`;");
        DB::unprepared("DROP TRIGGER IF EXISTS `insert_dental_q_page2`;");
        DB::unprepared("DROP TRIGGER IF EXISTS `update_dental_q_page2`;");
        DB::unprepared("DROP TRIGGER IF EXISTS `insert_dental_q_page3`;");
        DB::unprepared("DROP TRIGGER IF EXISTS `update_dental_q_page3`;");
        DB::unprepared("DROP TRIGGER IF EXISTS `insert_dental_q_page4`;");
        DB::unprepared("DROP TRIGGER IF EXISTS `update_dental_q_page4`;");
        DB::unprepared("DROP TRIGGER IF EXISTS `insert_dental_q_sleep`;");
        DB::unprepared("DROP TRIGGER IF EXISTS `update_dental_q_sleep`;");
        DB::unprepared("DROP TRIGGER IF EXISTS `insert_dental_summary`;");
        DB::unprepared("DROP TRIGGER IF EXISTS `update_dental_summary`;");
        DB::unprepared("DROP TRIGGER IF EXISTS `insert_dental_thorton`;");
        DB::unprepared("DROP TRIGGER IF EXISTS `update_dental_thorton`;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
