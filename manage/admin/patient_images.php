<?
include "includes/top.htm";

include 'includes/patient_nav.php';



//$pat_sql = "select * from dental_patients where patientid='".s_for($_GET['pid'])."'";
$pat_sql = "select * from dental_patients where patientid='".s_for($_GET['pid'])."'";
$pat_my = mysql_query($pat_sql);
$pat_myarray = mysql_fetch_array($pat_my);

$name = st($pat_myarray['lastname'])." ".st($pat_myarray['middlename']).", ".st($pat_myarray['firstname']);

if($pat_myarray['patientid'] == '')
{
        ?>
        <script type="text/javascript">
                window.location = 'manage_patient.php';
        </script>
        <?
        die();
}

$sql = "select * from dental_q_image where patientid='".$_GET['pid']."'";
if($_GET['sh'] <> '')
        $sql .= " and imagetypeid='".$_GET['sh']."' ";

If(!isset($_REQUEST['sort'])){
  $_REQUEST['sort'] = 'adddate';
}
If(!isset($_REQUEST['sortdir'])){
  $_REQUEST['sortdir'] = 'DESC';
}
$sql .= " order by ".$_REQUEST['sort']." ".$_REQUEST['sortdir'];
$my = mysql_query($sql);


include '../partials/patient_images.php';

?>








<?php include "includes/bottom.htm"; ?>
