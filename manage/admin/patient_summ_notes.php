<div class="clear"></div>

<?php
$sql = "select n.*, u.name signed_name from dental_notes n
        LEFT JOIN dental_users u on u.userid=n.signed_id
where n.patientid='".s_for($_GET['pid'])."' ";
$sql .= " order by n.adddate DESC";
$sql = "select n.*, u.name signed_name, p.adddate as parent_adddate from
        (
        select * from dental_notes where status!=0 and patientid='".s_for($_GET['pid'])."' order by adddate desc
        ) as n
        LEFT JOIN dental_users u on u.userid=n.signed_id
        LEFT JOIN dental_notes p ON p.notesid = n.parentid
        group by n.parentid
        order by n.procedure_date DESC, n.adddate desc
        ";
$my=mysql_query($sql) or die(mysql_error());

include '../partials/patient_notes.php';
?>


