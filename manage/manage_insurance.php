<? 
include "includes/top.htm";
include_once "includes/constants.inc";

  include 'vob_checklist.php';
?>
<div style="clear:both;"></div>
<?php
  $api_sql = "SELECT use_eligible_api FROM dental_users
		WHERE userid='".mysql_real_escape_string($_SESSION['docid'])."'";
  $api_q = mysql_query($api_sql);
  $api_r = mysql_fetch_assoc($api_q);
  if($api_r['use_eligible_api']==1){
    include 'eligible_api.php';
  }
include 'includes/bottom.htm';
?>

<?php
if(isset($_GET['sendins'])&&$_GET['sendins']==1){
  ?>
  <script type="text/javascript">
    window.location = "insurance_electronic_file.php?insid=<?= $_GET['insid']; ?>&type=<?=$_GET['type'];?>&pid=<?= $_GET['pid'];?>";
  </script>
  <?php
}
if(isset($_GET['showins'])&&$_GET['showins']==1){
  ?>
  <script type="text/javascript">
    window.location = "insurance_fdf.php?insid=<?= $_GET['insid']; ?>&type=<?=$_GET['type'];?>&pid=<?= $_GET['pid'];?>";
  </script>
  <?php
}
?>

