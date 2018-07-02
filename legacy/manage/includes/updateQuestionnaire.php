<?php
namespace Ds3\Libraries\Legacy;

include_once '../admin/includes/main_include.php';

$db = new Db();

$field = (!empty($_POST['field']) ? $_POST['field'] : '');
$value = (!empty($_POST['val']) ? $_POST['val'] : '');
$patient = (!empty($_POST['pid']) ? $_POST['pid'] : '');
$table = (!empty($_POST['table']) ? $_POST['table'] : '');

$ids = [];
if (strstr($table, '_pivot')) {
    $primaryKey = $db->primaryKey($table);
    $idQuery = "SELECT $primaryKey FROM $table WHERE patientid=$patient OR parent_patientid=$patient";
    $result = $db->getResults($idQuery);
    foreach ($result as $row) {
        $ids[] = $row[$primaryKey];
    }
    if (count($ids)) {
        $table = str_replace('_pivot', '', $table);
        $idString = join(',', $ids);
        $s = "UPDATE " . $db->escape( $table) . " 
            SET " . $db->escape( $field) . "='" . $db->escape( $value) . "' 
            WHERE $primaryKey IN (" . $db->escape( $idString) . ")";
    }
} else {
    $s = "UPDATE " . $db->escape( $table) . " 
        SET " . $db->escape( $field) . "='" . $db->escape( $value) . "' 
        WHERE patientid='" . $db->escape( $patient) . "' OR parent_patientid='" . $db->escape( $patient) . "'";
}
$q = $db->query($s);

if ($q) {
    echo '{"success":true}';
} else {
    echo '{"error":"mysql"}';
}
