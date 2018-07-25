<?php
namespace Ds3\Libraries\Legacy;

session_start();

// Capture any extra output
ob_start();

require_once('admin/includes/main_include.php');
include_once('admin/includes/password.php');
include("includes/sescheck.php");
include("includes/calendarinc.php");

$db = new Db();

// Discard any extra output
ob_end_clean();

if ($_POST['ed'] != ''){ //post from editing
    $notes = $_POST['notes'];

    if (is_array($notes)) {
        $notes = safeJsonEncode($notes);
    }

    if ($_SESSION['userid'] != ''){
        $update_sql = "UPDATE dental_notes SET
            notes = '".$db->escape($notes)."',
            editor_initials='".$db->escape($_POST['ed_initials'])."',
            procedure_date='".$db->escape(date('Y-m-d', strtotime($_POST['procedure_date'])))."',
            ip_address='".$db->escape($_SERVER['REMOTE_ADDR'])."'
            WHERE notesid='".$db->escape($_POST['ed'])."'";
        $db->query($update_sql);

        echo "save_successful";
    } else {
        echo "logged_out";
    }
} else { //creating a new note.
    $notes = $_POST['notes'];

    if (is_array($notes)) {
        $notes = safeJsonEncode($notes);
    }

    $note_sql = "INSERT INTO dental_notes SET
        patientid = '".$db->escape($_GET['pid'])."',
        userid = '".$db->escape($_SESSION['userid'])."',
        docid = '".$db->escape($_SESSION['docid'])."',
        status = 2,
        notes = '".$db->escape($notes)."',
        adddate = '".date('Y-m-d H:i:s')."',
        procedure_date = '".date('Y-m-d')."',
        ip_address = '".$db->escape($_SERVER['REMOTE_ADDR'])."'";
    $note_id = $db->getInsertId($note_sql);

    $update_sql = "UPDATE dental_notes SET parentid = '".$note_id."' WHERE notesid = '".$note_id."';";
    $db->query($update_sql);

    echo $note_id;
}
