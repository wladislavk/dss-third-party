<?php
namespace Ds3\Libraries\Legacy;

include_once('admin/includes/main_include.php');
include("includes/sescheck.php");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <link href="css/admin.css?v=20160404" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="css/form.css" type="text/css" />
    <script type="text/javascript" src="/manage/admin/js/tracekit.js"></script>
    <script type="text/javascript" src="/manage/admin/js/tracekit.handler.js"></script>
    <script type="text/javascript" src="admin/script/jquery-1.6.2.min.js"></script>
    <script type="text/javascript" src="script/validation.js"></script>
</head>
<body>

<?php
$db = new Db();

$rec_qry = "SELECT `ledgerid`,`patientid`,`service_date` ,`entry_date`,`description` ,`producer` ,`amount` ,`transaction_type` ,`paid_amount` ,`userid` ,`docid` ,`status` ,`adddate` ,`ip_address`,`transaction_code` FROM dental_ledger_rec WHERE patientid='". (!empty($_GET['pid']) ? $_GET['pid'] : '') ."' ORDER BY service_date ASC";
$row = $db->getRow($rec_qry);

echo '<table style="margin:20px;" border="1" width="95%"><tr>';
if (!empty($row)) foreach($row as $name => $value) {
    echo "<th>$name</th>";
}
echo '</tr>';
unset($row);

$rows = $db->getResults($rec_qry);
if (!empty($rows)) {
    foreach($rows as $row) {
        echo '<tr>';
        foreach ($row as $value) {
            echo "<td style=\"color:#FFFFFF;\">$value</td>";
        }
        echo '</tr>';
    }
}
echo '</table>';
?>
</body>
</html>
