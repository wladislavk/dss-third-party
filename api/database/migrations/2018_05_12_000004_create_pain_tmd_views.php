<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreatePainTmdViews extends Migration
{
    const BASE_GROUP_BY = 'patientid';
    const REFERENCED_GROUP_BY = 'reference_id';
    const BASE_TABLES = [
        'dental_ex_page1' => 'ex_page1id',
        'dental_ex_page2' => 'ex_page2id',
        'dental_ex_page3' => 'ex_page3id',
        'dental_ex_page4' => 'ex_page4id',
        'dental_ex_page5' => 'ex_page5id',
        'dental_ex_page6' => 'ex_page6id',
        'dental_ex_page7' => 'ex_page7id',
        'dental_ex_page8' => 'ex_page8id',
        'dental_q_page1' => 'q_page1id',
        'dental_q_page2' => 'q_page2id',
        'dental_q_page3' => 'q_page3id',
        'dental_q_page4' => 'q_page4id',
        'dental_summary' => 'summaryid',
    ];
    const REFERENCED_TABLES = [
        'dental_q_page2_surgery' => 'id',
        'dental_q_sleep' => 'q_sleepid',
        'dental_thorton' => 'thortonid',
        'dental_missing' => 'missingid',
    ];

    // CREATE VIEW dental_q_page2_surgery_pivot AS SELECT inner_table.* FROM dental_q_page2_surgery inner_table WHERE inner_table.reference_id = 0;
    /*
    create trigger insert_ex_page1 before insert on `dental_ex_page1` for each row set new.adddate = now(), new.updated_at = now(); create trigger update_ex_page1 before update on `dental_ex_page1` for each row set new.updated_at = now();
    create trigger insert_ex_page2 before insert on `dental_ex_page2` for each row set new.adddate = now(), new.updated_at = now(); create trigger update_ex_page2 before update on `dental_ex_page2` for each row set new.updated_at = now();
    create trigger insert_ex_page3 before insert on `dental_ex_page3` for each row set new.adddate = now(), new.updated_at = now(); create trigger update_ex_page3 before update on `dental_ex_page3` for each row set new.updated_at = now();
    create trigger insert_ex_page4 before insert on `dental_ex_page4` for each row set new.adddate = now(), new.updated_at = now(); create trigger update_ex_page4 before update on `dental_ex_page4` for each row set new.updated_at = now();
    create trigger insert_ex_page5 before insert on `dental_ex_page5` for each row set new.adddate = now(), new.updated_at = now(); create trigger update_ex_page5 before update on `dental_ex_page5` for each row set new.updated_at = now();
    create trigger insert_ex_page6 before insert on `dental_ex_page6` for each row set new.adddate = now(), new.updated_at = now(); create trigger update_ex_page6 before update on `dental_ex_page6` for each row set new.updated_at = now();
    create trigger insert_ex_page7 before insert on `dental_ex_page7` for each row set new.adddate = now(), new.updated_at = now(); create trigger update_ex_page7 before update on `dental_ex_page7` for each row set new.updated_at = now();
    create trigger insert_ex_page8 before insert on `dental_ex_page8` for each row set new.adddate = now(), new.updated_at = now(); create trigger update_ex_page8 before update on `dental_ex_page8` for each row set new.updated_at = now();
    create trigger insert_missing before insert on `dental_missing` for each row set new.adddate = now(), new.updated_at = now(); create trigger update_missing before update on `dental_missing` for each row set new.updated_at = now();
    create trigger insert_q_page1 before insert on `dental_q_page1` for each row set new.adddate = now(), new.updated_at = now(); create trigger update_q_page1 before update on `dental_q_page1` for each row set new.updated_at = now();
    create trigger insert_q_page2 before insert on `dental_q_page2` for each row set new.adddate = now(), new.updated_at = now(); create trigger update_q_page2 before update on `dental_q_page2` for each row set new.updated_at = now();
    create trigger insert_q_page3 before insert on `dental_q_page3` for each row set new.adddate = now(), new.updated_at = now(); create trigger update_q_page3 before update on `dental_q_page3` for each row set new.updated_at = now();
    create trigger insert_q_page4 before insert on `dental_q_page4` for each row set new.adddate = now(), new.updated_at = now(); create trigger update_q_page4 before update on `dental_q_page4` for each row set new.updated_at = now();
    create trigger insert_q_sleep before insert on `dental_q_sleep` for each row set new.adddate = now(), new.updated_at = now(); create trigger update_q_sleep before update on `dental_q_sleep` for each row set new.updated_at = now();
    create trigger insert_summary before insert on `dental_summary` for each row set new.adddate = now(), new.updated_at = now(); create trigger update_summary before update on `dental_summary` for each row set new.updated_at = now();
    create trigger insert_thorton before insert on `dental_thorton` for each row set new.adddate = now(), new.updated_at = now(); create trigger update_thorton before update on `dental_thorton` for each row set new.updated_at = now();
     */

    public function up () {
        foreach (self::BASE_TABLES as $table => $primaryKey) {
            $this->setUpViews($table, $primaryKey, self::BASE_GROUP_BY);
        }
        foreach (self::REFERENCED_TABLES as $table => $primaryKey) {
            $this->setUpViews($table, $primaryKey, self::REFERENCED_GROUP_BY, true);
        }
    }

    public function down () {
        foreach (self::BASE_TABLES as $table => $primaryKey) {
            $this->tearDownViews($table);
        }
        foreach (self::REFERENCED_TABLES as $table => $primaryKey) {
            $this->tearDownViews($table);
        }
    }

    /**
     * @param string $table
     * @param string $primaryKey
     * @param string $groupBy
     * @param bool   $addReferenceId
     */
    private function setUpViews($table, $primaryKey, $groupBy, $addReferenceId = false)
    {
        if (Schema::hasColumn($table, 'adddate') && !Schema::hasColumn($table, 'updated_at')) {
            Schema::table($table, function (Blueprint $table) {
                $table->timestamp('updated_at')
                    ->default(DB::raw('CURRENT_TIMESTAMP'))
                ;
            });
            DB::update("UPDATE $table SET updated_at = adddate");
        }

        if ($addReferenceId && !Schema::hasColumn($table, 'reference_id')) {
            Schema::table($table, function (Blueprint $table) {
                $table->integer('reference_id')
                    ->default(0)
                ;
                $table->index('reference_id');
            });
        }

        $andReferenceIdConditional = '';
        if ($addReferenceId) {
            $andReferenceIdConditional = 'AND inner_table.reference_id = 0';
        }

        DB::unprepared("DROP VIEW IF EXISTS {$table}_pivot");
        DB::unprepared("CREATE VIEW {$table}_pivot AS
            SELECT inner_table.*
            FROM $table inner_table
                LEFT OUTER JOIN $table outer_table
                    ON inner_table.patientid = outer_table.patientid
                        AND inner_table.$primaryKey < outer_table.$primaryKey
            WHERE outer_table.patientid IS NULL
                $andReferenceIdConditional
        ");

        DB::unprepared("DROP VIEW IF EXISTS {$table}_view");
        DB::unprepared("CREATE VIEW {$table}_view AS
            SELECT * FROM {$table}_pivot
        ");
    }

    /**
     * @param string $table
     */
    private function tearDownViews($table)
    {
        if (Schema::hasColumn($table, 'updated_at')) {
            Schema::table($table, function (Blueprint $table) {
                $table->dropColumn('updated_at');
            });
        }

        if (Schema::hasColumn($table, 'reference_id')) {
            Schema::table($table, function (Blueprint $table) {
                $table->dropColumn('reference_id');
            });
        }

        DB::unprepared("DROP VIEW IF EXISTS {$table}_view");
        DB::unprepared("DROP VIEW IF EXISTS {$table}_pivot");
    }
}
