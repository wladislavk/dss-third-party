<? 
include "includes/top.htm";
include_once "includes/constants.inc";

if(isset($_GET['vobdel'])){

  $d = "DELETE FROM dental_insurance_preauth WHERE id='".mysql_real_escape_string($_GET['vobdel'])."'
		AND doc_id = '".mysql_real_escape_string($_SESSION['docid'])."'";
  mysql_query($d);

}

  include 'vob_checklist.php';
?>
<div style="clear:both;"></div>
<?php
  $api_sql = "SELECT use_eligible_api FROM dental_users
		WHERE userid='".mysql_real_escape_string($_SESSION['docid'])."'";
  $api_q = mysql_query($api_sql);
  $api_r = mysql_fetch_assoc($api_q);
  if($api_r['use_eligible_api']==1){
    //include 'eligible_api.php';
    ?><center><iframe width="98%" onLoad="autoResize('eligible');" id="eligible" class="eligible" src="eligible_check/eligible_check.php?pid=<?=$_GET['pid']; ?>">
    </iframe></center><?php
?>

<script language="JavaScript">
<!--
function autoResize(id){
    var newheight;
    var newwidth;

    if(document.getElementById){
        newheight=document.getElementById(id).contentWindow.document .body.scrollHeight;
        newwidth=document.getElementById(id).contentWindow.document .body.scrollWidth;
    }

    document.getElementById(id).height= (newheight) + "px";
    document.getElementById(id).width= (newwidth) + "px";
}
//-->
</script>


<?php
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

