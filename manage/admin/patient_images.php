<?php namespace Ds3\Libraries\Legacy; ?><?
include "includes/top.htm";

include 'includes/patient_nav.php';



//$pat_sql = "select * from dental_patients where patientid='".s_for($_GET['pid'])."'";
$pat_sql = "select * from dental_patients where patientid='".s_for($_GET['pid'])."'";
$pat_my = mysqli_query($con,$pat_sql);
$pat_myarray = mysqli_fetch_array($pat_my);

$name = st($pat_myarray['lastname'])." ".st($pat_myarray['middlename']).", ".st($pat_myarray['firstname']);

if($pat_myarray['patientid'] == '')
{
        ?>
        <script type="text/javascript">
                window.location = 'manage_patient.php';
        </script>
        <?
        trigger_error("Die called", E_USER_ERROR);
}

$sql = "select * from dental_q_image where patientid='".$_GET['pid']."'";
$sql = "select i.*,
        CASE 
                WHEN i.userid!=''
                THEN CONCAT(u.first_name, ' ',u.last_name)
                WHEN i.adminid!=''
                THEN CONCAT(a.first_name, ' ',a.last_name)
        END added_by

         from dental_q_image i
        LEFT join dental_users u ON u.userid=i.userid
        LEFT join admin a ON a.adminid=i.adminid
        where i.patientid='".$_GET['pid']."'";
if(!empty($_GET['sh']))
        $sql .= " and imagetypeid='".$_GET['sh']."' ";

If(!isset($_REQUEST['sort'])){
  $_REQUEST['sort'] = 'adddate';
}
If(!isset($_REQUEST['sortdir'])){
  $_REQUEST['sortdir'] = 'DESC';
}
$sql .= " order by ".$_REQUEST['sort']." ".$_REQUEST['sortdir'];
$my = mysqli_query($con,$sql);

?>
 <div align="right">
        <button onclick="Javascript: loadPopup('add_image.php?pid=<?=$_GET['pid'];?>');" class="btn btn-success">
                Add Image
                <span class="glyphicon glyphicon-plus">
        </button>
        &nbsp;&nbsp;
</div> 
<?php
include '../partials/patient_images.php';

?>








<?php include "includes/bottom.htm"; ?>
