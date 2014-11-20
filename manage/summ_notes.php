<button onclick="Javascript: loadPopup('add_notes.php?pid=<?php echo (!empty($_GET['pid']) ? $_GET['pid'] : '');?>');" class="addButton" style="float: right;">
    + Add New Progress Note
</button>
<div class="clear"></div>

<?php
$sql = "select n.*, CONCAT(u.first_name,' ',u.last_name) signed_name from dental_notes n
        LEFT JOIN dental_users u on u.userid=n.signed_id
        where n.docid='".$_SESSION['docid']."' and n.patientid='".s_for((!empty($_GET['pid']) ? $_GET['pid'] : ''))."' ";
$sql .= " order by n.adddate DESC";
$sql = "select n.*, CONCAT(u.first_name,' ',u.last_name) signed_name, p.adddate as parent_adddate from
        (
        select * from dental_notes where status!=0 AND docid='".$_SESSION['docid']."' and patientid='".s_for((!empty($_GET['pid']) ? $_GET['pid'] : ''))."' order by adddate desc
        ) as n
        LEFT JOIN dental_users u on u.userid=n.signed_id
        LEFT JOIN dental_notes p ON p.notesid = n.parentid
        group by n.parentid
        order by n.procedure_date DESC, n.adddate desc
        ";
$my = $db->getResults($sql);

include 'partials/patient_notes.php'; ?>

<a href="print_notes.php?pid=<?php echo (!empty($_GET['pid']) ? $_GET['pid'] : '');?>" target="_blank" class="addButton" style="float: left;">
    Print All Progress Notes
</a>
<button onClick="sign_notes(); return false;" class="addButton" style="float: right;">
    Sign Selected Notes
</button>

<script src="js/summ_notes.js" type="text/javascript"></script>