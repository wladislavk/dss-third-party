<?php 
include 'includes/top.htm';?>

<?php
if(isset($_POST['submit'])){

  $p_sql = "SELECT patientid FROM dental_insurance where insuranceid='".mysql_real_escape_string($_REQUEST['insid'])."'";
  $p_q = mysql_query($p_sql);
  
  if(mysql_num_rows($p_q)>0){
    $p = mysql_fetch_assoc($p_q);

    $_GET['insid'] = $_POST['insid'];
    $_GET['pid'] = $p['patientid'];
    include '../insurance_electronic_file.php';

      $p_sql = "SELECT eligible_response FROM dental_insurance where insuranceid='".mysql_real_escape_string($_REQUEST['insid'])."'";
      $p_q = mysql_query($p_sql);
      $p_r = mysql_fetch_assoc($p_q);
      echo $p_r['eligible_response'];

  }else{
    ?>CLAIM NOT FOUND!<?php
  }

}
?>

<form method="post">
Ins. id <input type="text" name="insid" />
<br />

<input type="submit" name="submit" value="Send Electronic Claim" />
</form>

<? include 'includes/bottom.htm';?>
