<?php namespace Ds3\Libraries\Legacy; ?><?php

session_start();

// Capture any extra output
ob_start();

require_once('admin/includes/main_include.php');
include_once('admin/includes/password.php');
include("includes/sescheck.php");
include("includes/calendarinc.php");

// Discard any extra output
ob_end_clean();

if ($_POST['ed'] != ''){ //post from editing
  if ($_SESSION['userid'] != ''){
    $update_sql = "UPDATE dental_notes SET
    status = 2,
    notes = '".s_for($_POST['notes'])."',
    editor_initials='".s_for($_POST['ed_initials'])."',
    procedure_date='".s_for(date('Y-m-d', strtotime($_POST['procedure_date'])))."',
    ip_address='".s_for($_SERVER['REMOTE_ADDR'])."'
    WHERE notesid='".s_for($_POST['ed'])."';";
    $update_result = mysqli_query($con, $update_sql);
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
      status = 2,
      notes = '".s_for($_POST['notes'])."',
      adddate = '".date('Y-m-d H:i:s')."',
      procedure_date = '".date('Y-m-d')."',
      ip_address = '".s_for($_SERVER['REMOTE_ADDR'])."'";
  $note_result = mysqli_query($con, $note_sql);
  
  $note_id =  mysqli_insert_id($con);
  $update_sql = "UPDATE dental_notes SET parentid = '".$note_id."' WHERE notesid = '".$note_id."';";
  $update_result = mysqli_query($con, $update_sql);

  echo $note_id;
}
