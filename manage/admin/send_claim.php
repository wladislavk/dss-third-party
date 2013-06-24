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
    $_GET['memid'] = $_POST['memid'];
    $_GET['test'] = $_POST['test'];
    include '../insurance_electronic_file.php';

      $p_sql = "SELECT response FROM dental_claim_electronic where claimid='".mysql_real_escape_string($_REQUEST['insid'])."' ORDER BY id DESC";
      $p_q = mysql_query($p_sql);
      $p_r = mysql_fetch_assoc($p_q);
      echo $p_r['response'];

  }else{
    ?>CLAIM NOT FOUND!<?php
  }

}
?>

<form method="post">
Ins. id <input type="text" name="insid" />
<br />
Member ID <input type="text" name="memid" />
<br />
<input type="checkbox" name="test" value="1" /> Test
<br />
<input type="submit" name="submit" value="Send Electronic Claim" />
</form>

<? include 'includes/bottom.htm';?>
