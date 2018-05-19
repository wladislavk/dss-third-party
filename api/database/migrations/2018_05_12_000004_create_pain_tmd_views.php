<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreatePainTmdViews extends Migration
{
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
    const NON_SINGLETON_TABLES = [
        'dental_q_page2_surgery',
    ];

    public function up()
    {
        foreach (self::BASE_TABLES as $table => $primaryKey) {
            $this->setUpViews($table, $primaryKey);
        }
        foreach (self::REFERENCED_TABLES as $table => $primaryKey) {
            $this->setUpViews($table, $primaryKey, true);
        }
    }

    public function down()
    {
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
     * @param bool   $addReferenceId
     */
    private function setUpViews(string $table, string $primaryKey, bool $addReferenceId = false)
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
        $this->setUpPivotView($table, $primaryKey, $addReferenceId);
        $this->setUpFinalView($table);
    }

    /**
     * @param string $table
     * @param string $primaryKey
     * @param bool $addReferenceId
     */
    private function setUpPivotView(string $table, string $primaryKey, bool $addReferenceId = false)
    {
        DB::unprepared("DROP VIEW IF EXISTS {$table}_pivot");
        if (in_array($table, self::NON_SINGLETON_TABLES)) {
            DB::unprepared("CREATE VIEW {$table}_pivot AS
                SELECT inner_table.*
                FROM {$table} inner_table
                WHERE inner_table.reference_id = 0
            ");
            return;
        }
        $andReferenceIdConditional = '';
        if ($addReferenceId) {
            $andReferenceIdConditional = 'AND inner_table.reference_id = 0';
        }
        DB::unprepared("CREATE VIEW {$table}_pivot AS
            SELECT inner_table.*
            FROM $table inner_table
                LEFT OUTER JOIN $table outer_table
                    ON inner_table.patientid = outer_table.patientid
                        AND inner_table.$primaryKey < outer_table.$primaryKey
            WHERE outer_table.patientid IS NULL
                $andReferenceIdConditional
        ");
        $this->setUpTrigger($table);
    }

    /**
     * @param string $table
     */
    private function setUpFinalView(string $table)
    {
        DB::unprepared("DROP VIEW IF EXISTS {$table}_view");
        DB::unprepared("CREATE VIEW {$table}_view AS
            SELECT * FROM {$table}_pivot
        ");
    }

    /**
     * @param string $table
     */
    private function setUpTrigger(string $table)
    {
        DB::unprepared("DROP TRIGGER IF EXISTS insert_{$table}");
        DB::unprepared("CREATE TRIGGER insert_{$table}
            BEFORE INSERT ON $table FOR EACH ROW SET new.adddate = NOW(), new.updated_at = NOW()
        ");
        DB::unprepared("DROP TRIGGER IF EXISTS update_{$table}");
        DB::unprepared("CREATE TRIGGER update_{$table}
            BEFORE UPDATE ON $table FOR EACH ROW SET new.updated_at = NOW()
        ");
    }

    /**
     * @param string $table
     */
    private function tearDownViews(string $table)
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
        DB::unprepared("DROP TRIGGER IF EXISTS insert_{$table}");
        DB::unprepared("DROP TRIGGER IF EXISTS update_{$table}");
    }
}
