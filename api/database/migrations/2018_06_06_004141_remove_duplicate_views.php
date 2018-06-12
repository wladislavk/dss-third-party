<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveDuplicateViews extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared("DROP VIEW IF EXISTS `dental_ex_page1_view`");
        DB::unprepared("DROP VIEW IF EXISTS `dental_ex_page2_view`");
        DB::unprepared("DROP VIEW IF EXISTS `dental_ex_page3_view`");
        DB::unprepared("DROP VIEW IF EXISTS `dental_ex_page4_view`");
        DB::unprepared("DROP VIEW IF EXISTS `dental_ex_page5_view`");
        DB::unprepared("DROP VIEW IF EXISTS `dental_ex_page6_view`");
        DB::unprepared("DROP VIEW IF EXISTS `dental_ex_page7_view`");
        DB::unprepared("DROP VIEW IF EXISTS `dental_ex_page8_view`");
        DB::unprepared("DROP VIEW IF EXISTS `dental_q_page1_view`");
        DB::unprepared("DROP VIEW IF EXISTS `dental_q_page2_view`");
        DB::unprepared("DROP VIEW IF EXISTS `dental_q_page3_view`");
        DB::unprepared("DROP VIEW IF EXISTS `dental_q_page4_view`");
        DB::unprepared("DROP VIEW IF EXISTS `dental_summary_view`");
        DB::unprepared("DROP VIEW IF EXISTS `dental_q_page2_surgery_view`");
        DB::unprepared("DROP VIEW IF EXISTS `dental_q_sleep_view`");
        DB::unprepared("DROP VIEW IF EXISTS `dental_thorton_view`");
        DB::unprepared("DROP VIEW IF EXISTS `dental_missing_view`");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared("CREATE VIEW IF NOT EXISTS `dental_ex_page1_view` AS SELECT * FROM `dental_ex_page1_pivot`");
        DB::unprepared("CREATE VIEW IF NOT EXISTS `dental_ex_page2_view` AS SELECT * FROM `dental_ex_page2_pivot`");
        DB::unprepared("CREATE VIEW IF NOT EXISTS `dental_ex_page3_view` AS SELECT * FROM `dental_ex_page3_pivot`");
        DB::unprepared("CREATE VIEW IF NOT EXISTS `dental_ex_page4_view` AS SELECT * FROM `dental_ex_page4_pivot`");
        DB::unprepared("CREATE VIEW IF NOT EXISTS `dental_ex_page5_view` AS SELECT * FROM `dental_ex_page5_pivot`");
        DB::unprepared("CREATE VIEW IF NOT EXISTS `dental_ex_page6_view` AS SELECT * FROM `dental_ex_page6_pivot`");
        DB::unprepared("CREATE VIEW IF NOT EXISTS `dental_ex_page7_view` AS SELECT * FROM `dental_ex_page7_pivot`");
        DB::unprepared("CREATE VIEW IF NOT EXISTS `dental_ex_page8_view` AS SELECT * FROM `dental_ex_page8_pivot`");
        DB::unprepared("CREATE VIEW IF NOT EXISTS `dental_q_page1_view` AS SELECT * FROM `dental_q_page1_pivot`");
        DB::unprepared("CREATE VIEW IF NOT EXISTS `dental_q_page2_view` AS SELECT * FROM `dental_q_page2_pivot`");
        DB::unprepared("CREATE VIEW IF NOT EXISTS `dental_q_page3_view` AS SELECT * FROM `dental_q_page3_pivot`");
        DB::unprepared("CREATE VIEW IF NOT EXISTS `dental_q_page4_view` AS SELECT * FROM `dental_q_page4_pivot`");
        DB::unprepared("CREATE VIEW IF NOT EXISTS `dental_summary_view` AS SELECT * FROM `dental_summary_pivot`");
        DB::unprepared("CREATE VIEW IF NOT EXISTS `dental_q_page2_surgery_view` AS SELECT * FROM `dental_q_page2_surgery_pivot`");
        DB::unprepared("CREATE VIEW IF NOT EXISTS `dental_q_sleep_view` AS SELECT * FROM `dental_q_sleep_pivot`");
        DB::unprepared("CREATE VIEW IF NOT EXISTS `dental_thorton_view` AS SELECT * FROM `dental_thorton_pivot`");
        DB::unprepared("CREATE VIEW IF NOT EXISTS `dental_missing_view` AS SELECT * FROM `dental_missing_pivot`");
    }
}
