<?php

use Illuminate\Database\Migrations\Migration;

class AddTaskDataForDoc1 extends Migration
{
    /**
     * @return void
     */
    public function up()
    {
        if (env('APP_ENV') == 'production') {
            return;
        }

        DB::insert("INSERT INTO `dental_task` (`task`, `userid`, `responsibleid`, `status`, `due_date`, `patientid`) VALUES ('Very important task 1', '1', '1', '0', '2012-04-01 00:00:00', '0');");
        DB::insert("INSERT INTO `dental_task` (`task`, `userid`, `responsibleid`, `status`, `due_date`, `patientid`) VALUES ('Very important task 2', '1', '1', '0', '2012-04-01 00:00:00', '0');");
        DB::insert("INSERT INTO `dental_task` (`task`, `userid`, `responsibleid`, `status`, `due_date`, `patientid`) VALUES ('Very important task 3', '1', '1', '0', '2012-04-01 00:00:00', '0');");
        DB::insert("INSERT INTO `dental_task` (`task`, `userid`, `responsibleid`, `status`, `due_date`, `patientid`) VALUES ('Very important task 4', '1', '1', '0', '2012-04-01 00:00:00', '0');");

        DB::update("UPDATE `dental_task` SET `due_date`='2014-01-24 00:00:00' WHERE `task`='review HST' and `responsibleid` = 4;");
        DB::update("UPDATE `dental_task` SET `due_date`='2014-01-23 00:00:00' WHERE `task`='vbvzvn';");
        DB::update("UPDATE `dental_task` SET `due_date`='2013-07-15 00:00:00' WHERE `task`='Need to call patient and see how doing';");
        DB::update("UPDATE `dental_task` SET `due_date`='2013-07-14 00:00:00' WHERE `task`='Check on HST equipment' and `responsibleid` = 4;");
        DB::update("UPDATE `dental_task` SET `due_date`='2013-07-13 00:00:00' WHERE `task`='Check on HST equipment' and `responsibleid` = 1;");

    }

    /**
     * @return void
     */
    public function down()
    {
        if (env('APP_ENV') == 'production') {
            return;
        }

        DB::delete("DELETE FROM dental_task WHERE task LIKE 'Very important task%' and `userid` = '1';");
        DB::update("UPDATE `dental_task` SET `due_date`='2014-01-25 00:00:00' WHERE `task`='review HST' and `responsibleid` = 4;");
        DB::update("UPDATE `dental_task` SET `due_date`='2014-01-25 00:00:00' WHERE `task`='vbvzvn';");
        DB::update("UPDATE `dental_task` SET `due_date`='2013-07-16 00:00:00' WHERE `task`='Need to call patient and see how doing';");
        DB::update("UPDATE `dental_task` SET `due_date`='2013-07-16 00:00:00' WHERE `task`='Check on HST equipment' and `responsibleid` = 4;");
        DB::update("UPDATE `dental_task` SET `due_date`='2013-07-16 00:00:00' WHERE `task`='Check on HST equipment' and `responsibleid` = 1;");
    }
}
