<? 
include "includes/top.htm";

if(isset($_POST["margins_submit"]) || isset($_POST['margins_test']))
{

  $in_sql = "UPDATE admin SET
                claim_margin_top = '".mysql_real_escape_string($_POST['claim_margin_top'])."',
                claim_margin_left = '".mysql_real_escape_string($_POST['claim_margin_left'])."'
        WHERE adminid='".$_SESSION['adminuserid']."'";
  mysql_query($in_sql);
  if(isset($_POST['margins_test'])){


        ?>
        <script type="text/javascript">
                window.open("claim_margin_test.php");
        </script>
        <?php
  }
}

if(isset($_POST["margins_reset"]))
{

  $in_sql = "UPDATE admin SET
                claim_margin_top = '0',
                claim_margin_left = '0'
        WHERE adminid='".$_SESSION['adminuserid']."'";
  mysql_query($in_sql);
}

?>

<link rel="stylesheet" href="popup/popup.css" type="text/css" media="screen" />
<script src="popup/popup.js" type="text/javascript"></script>

<span class="admin_head">
	Manage Claim Settings
</span>
<br />
<br />


<br />
<div align="center" class="red">
	<b><? echo $_GET['msg'];?></b>
</div>

<?php
  $p_sql = "SELECT * FROM admin where adminid='".mysql_real_escape_string($_SESSION['adminuserid'])."'";
  $p_q = mysql_query($p_sql);
  $practice = mysql_fetch_assoc($p_q);


?>


<div class="half" style="margin-left: 20px;">
  <form action="#" method="post">
  <div class="detail">
    <label>Top:</label>
    <input class="value" name="claim_margin_top" value="<?= $practice['claim_margin_top']; ?>" />
  </div>
  <div class="detail">
    <label>Left:</label>
    <input class="value" name="claim_margin_left" value="<?= $practice['claim_margin_left']; ?>" />
  </div>
  <div class="detail">
    <label>&nbsp;</label>
        <input type="submit" name="margins_submit" value="Update Margins" />
        <input type="submit" name="margins_reset" value="Reset Margins" />
        <input type="submit" name="margins_test" value="Print Test Claim" />
  </div>
  </form>
</div>
<div style="clear:both;"></div>

<br /><br />	
<? include "includes/bottom.htm";?>
