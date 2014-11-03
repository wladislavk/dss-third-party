<?php
session_start();
?>
<script type="text/javascript" src="/manage/admin/script/jquery-1.6.2.min.js"></script>
<?php
require_once('admin/includes/main_include.php');
include_once('admin/includes/password.php');
include("includes/sescheck.php");
include("includes/calendarinc.php");


if ($_POST['ed'] != ''){ //post from editing
  if ($_SESSION['userid'] != ''){
    $update_sql = "UPDATE dental_notes SET
    status = 2,
    notes = '".$_POST['notes']."',
    editor_initials='".$_POST['ed_initials']."',
    procedure_date='".date('Y-m-d', strtotime($_POST['procedure_date']))."',
    ip_address='".s_for($_SERVER['REMOTE_ADDR'])."'
    WHERE notesid='".s_for($_POST['ed'])."';";
    $update_result = mysql_query($update_sql);
    if ($update_result){
      echo "save_successful";
    }
    else
    {
      echo "save_failed";
    }
  }
  else
  {
    echo "logged_out";
  }
}
else //creating a new note.
{
  $note_sql = "INSERT INTO dental_notes SET
      patientid = '".s_for($_GET['pid'])."',
      userid = '".s_for($_SESSION['userid'])."',
      docid = '".s_for($_SESSION['docid'])."',
      status = 0, 
      adddate = '".date('Y-m-d H:i:s')."',
      procedure_date = '".date('Y-m-d')."',
      ip_address = '".s_for($_SERVER['REMOTE_ADDR'])."'";
  $note_result = mysql_query($note_sql);
  
  $note_id =  mysql_insert_id();
  $update_sql = "UPDATE dental_notes SET parentid = '".$note_id."' WHERE notesid = '".$note_id."';";
  $update_result = mysql_query($update_sql);

  echo $note_id;
}
?>