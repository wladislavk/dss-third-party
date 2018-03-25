<?php namespace Ds3\Libraries\Legacy; ?><?php
  session_start();
require_once('admin/includes/main_include.php');
include("includes/sescheck.php"); 
?>
<?php
if(isset($_POST['newcontadded'])){
$insert_new_contactto = "INSERT INTO dental_pcont(contact_id,patient_id) VALUES(".$_POST['contacts'].",".$_POST['patid'].");";
$insert_new_contacttores = mysqli_query($con, $insert_new_contactto);

if($insert_new_contacttores){

echo "<script type=\"text/javascript\">alert('Successfully Added New Contact to Patient');parent.location.reload(1);</script>";

}else{
?>
<script type="text/javascript">
alert('Could not attach patient to contact, please contact your systems administrator.');
parent.location.reload(1);
</script>
<?php
}
}
?>
