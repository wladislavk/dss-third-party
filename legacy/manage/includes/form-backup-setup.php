<?php
namespace Ds3\Libraries\Legacy;

$db = new Db();

/**
 * Define common IDs and handle backup logic
 * Allow override values
 */
$patientId = isset($patientId) ? $patientId : intval($_GET['pid']);
$docId = isset($docId) ? $docId : intval($_SESSION['docid']);
$userId = isset($userId) ? $userId : intval($_SESSION['userid']);
$adminId = isset($adminId) ? $adminId : intval($_SESSION['adminuserid']);
$onBackupSuccess = isset($onBackupSuccess) ? $onBackupSuccess : function () {};

/**
 * History view related items
 */
$isHistoricView = isset($isHistoricView) ? $isHistoricView : isset($_GET['history_id']);

if (!isset($historyId)) {
    $historyId = $isHistoricView ? intval($_GET['history_id']) : 0;
}

/**
 * Action indicators:
 *
 * @var bool $isCreateNew   Show an empty table to allow save new form fields, set a hidden field, "backup_table"
 * @var bool $isBackupTable Backup the base table
 */
$isCreateNew = isset($isCreateNew) ? $isCreateNew : !empty($_POST['create_new']);
$isBackupTable = isset($isBackupTable) ? $isBackupTable : !empty($_POST['backup_table']);
$canBackup = isset($canBackup) ? $canBackup : true;

/**
 * Main table, to retrieve information of the form
 */
$baseTable = !empty($baseTable) ? $baseTable : 'exception_table_not_defined';
$baseSearch = !empty($baseSearch) ? $baseSearch : ['conditional_not_defined' => -1];

$historyTable = preg_replace('/_view$/', '', $baseTable);
$sourceTable = $isHistoricView ? $historyTable : $baseTable;
$primaryKey = $db->primaryKey($historyTable);

/**
 * Secondary tables, rely on the base table
 */
$secondaryTables = isset($secondaryTables) ? $secondaryTables : [];
$secondaryHistoryTables = [];
$secondarySourceTables = [];

foreach ($secondaryTables as $table=>$conditionals) {
    $secondaryHistoryTables[$table] = preg_replace('/_view$/', '', $table);
    $secondarySourceTables[$table] = $isHistoricView ? $secondaryHistoryTables[$table] : $table;
}

/**
 * Date of the backup, if any
 */
$snapshotDate = $db->getRow("SELECT adddate, updated_at
    FROM $historyTable
    WHERE $primaryKey = '$historyId'");

/**
 * Conditionals to display history data, and to NOT display data, under different scenarios
 */
$andHistoryIdConditional = $isHistoricView ? "AND $primaryKey = '$historyId'" : '';
$andReferenceIdConditional = $isHistoricView ? "AND reference_id = '$historyId'" : '';
$andNullConditional = $isCreateNew ? 'AND 1 = -1' : '';

/**
 * Replace named variables with the real values
 */
call_user_func(function () use ($patientId, $docId, $userId, $adminId, $historyId, &$baseSearch, &$secondaryTables) {
    $replacementVars = [
        '$patientId' => $patientId,
        '$docId' => $docId,
        '$userId' => $userId,
        '$adminId' => $adminId,
        '$historyId' => $historyId,
    ];

    foreach ($baseSearch as &$value) {
        if (array_key_exists($value, $replacementVars)) {
            $value = $replacementVars[$value];
        }
    }

    foreach ($secondaryTables as &$conditionals) {
        foreach ($conditionals as &$conditional) {
            if (array_key_exists($conditional, $replacementVars)) {
                $conditional = $replacementVars[$conditional];
            }
        }
    }
});

/**
 * Date range
 */
list($initiatedTimestamp, $lastModifiedTimestamp) = call_user_func(function () use ($sourceTable, $baseSearch, $andHistoryIdConditional) {
    $db = new Db();
    $baseConditionals = $db->escapeAssignmentList($baseSearch, 'AND');

    try {
        $timestamps = $db->getRow("SELECT
                adddate AS created_at,
                updated_at AS updated_at
            FROM $sourceTable
                WHERE $baseConditionals
                $andHistoryIdConditional
        ");
    } catch (\Exception $e) {
        $timestamps = $db->getRow("SELECT
                adddate AS created_at
            FROM $sourceTable
                WHERE $baseConditionals
                $andHistoryIdConditional
        ");
    }

    $initialTimestamp = $timestamps['created_at'];
    $lastModifiedTimestamp = $timestamps['updated_at'] ?: $timestamps['created_at'];

    return [$initialTimestamp, $lastModifiedTimestamp];
});

list($targetId, $historyList) = call_user_func(function () use (
    $docId,
    $userId,
    $patientId,
    $baseTable,
    $baseSearch,
    $historyTable,
    $secondaryTables,
    $canBackup,
    $isHistoricView,
    $isBackupTable,
    $onBackupSuccess
) {
    $db = new Db();
    $primaryKey = $db->primaryKey($historyTable);
    $baseConditionals = $db->escapeAssignmentList($baseSearch, 'AND');

    /**
     * ID of the form the form comes from
     */
    $targetId = $db->getColumn("SELECT $primaryKey
        FROM $baseTable
        WHERE $baseConditionals", $primaryKey, 0);

    /**
     * List of backups, ID and datetime
     */
    $historyListQuery = "SELECT $primaryKey AS id, adddate, updated_at
        FROM $historyTable
        WHERE $baseConditionals
        ORDER BY $primaryKey DESC";

    /**
     * Check permissions
     */
    if (!$canBackup || $isHistoricView || !$isBackupTable || !$targetId) {
        $historyList = $db->getResults($historyListQuery);
        return [$targetId, $historyList];
    }

    backupExamQuestionnaireTable($baseTable, $docId, $userId, $patientId);
    call_user_func($onBackupSuccess, $patientId);

    /**
     * Set the reference_id to match the $targetId from the main table
     */
    foreach ($secondaryTables as $table => $conditionals) {
        $secondaryConditionals = $db->escapeAssignmentList($conditionals, 'AND');

        $db->query("UPDATE $table
            SET reference_id = '$targetId'
            WHERE $secondaryConditionals
                AND reference_id = 0
        ");
    }

    $historyList = $db->getResults($historyListQuery);
    return [$targetId, $historyList];
});

$isListEmpty = sizeof($historyList) < 2;

if (isset($_POST['kill_switch']) && $_POST['kill_switch'] === 'bulk-backup') {
    trigger_error('Die called', E_USER_ERROR);
}
