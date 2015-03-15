<?php namespace Ds3\Legacy; ?><?php 
include "includes/top.htm";

if(isset($_POST["margins_submit"]) || isset($_POST['margins_test']))
{

  $in_sql = "UPDATE admin SET
                claim_margin_top = '".mysqli_real_escape_string($con,$_POST['claim_margin_top'])."',
                claim_margin_left = '".mysqli_real_escape_string($con,$_POST['claim_margin_left'])."'
        WHERE adminid='".$_SESSION['adminuserid']."'";
  mysqli_query($con,$in_sql);
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
  mysqli_query($con,$in_sql);
}

?>

<link rel="stylesheet" href="popup/popup.css" type="text/css" media="screen" />
<script src="popup/popup.js" type="text/javascript"></script>

<div class="page-header">
	Manage Claim Settings
</div>
<br />
<br />


<br />
<div align="center" class="red">
	<b><?php echo (!empty($_GET['msg']) ? $_GET['msg'] : '');?></b>
</div>

<?php
  $p_sql = "SELECT * FROM admin where adminid='".mysqli_real_escape_string($con,$_SESSION['adminuserid'])."'";
  $p_q = mysqli_query($con,$p_sql);
  $practice = mysqli_fetch_assoc($p_q);


?>

<div>
<strong>Configuring your CMS 1500 form:</strong>
<ol>
<li>Insert a valid CMS 1500 form into your printer.</li>
<li>Click "Print Test Claim" to print test data on the CMS 1500 form in your printer.</li>
<li>Check alignment.  Adjust "Claim Margins" settings to shift the form up/down/left/right.</li>
<li>Click "Update Margins" to save your new margins.</li>
<li>Repeat steps 1-4 until your test claim shows the data aligned within the center of the CMS 1500 form boxes.</li>
<li>Your printer is now calibrated for the CMS 1500 form.</li>
</ol>

<p>NOTE: Make sure that "Page Scaling" is set to NONE in your print settings when you print the PDF test file, or you will experience alignment issues.</p>

<p>If you wish to reset the claim back to original settings click "Reset Margins".</p>
</div>
<div class="half" style="margin-left: 20px;">
<h3>Claim Margins</h3>
  <form action="#" method="post">
  <div class="detail">
    <label>Top:</label>
    <input class="value" name="claim_margin_top" value="<?php echo  $practice['claim_margin_top']; ?>" />
	mm. Positive values shift down, negative shift up.
  </div>
  <div class="detail">
    <label>Left:</label>
    <input class="value" name="claim_margin_left" value="<?php echo  $practice['claim_margin_left']; ?>" />
	mm. Positive values shift right, negative shift left.
  </div>
  <div class="detail">
    <label>&nbsp;</label>
        <input type="submit" name="margins_submit" value="Update Margins" class="btn btn-primary">
        <input type="submit" name="margins_reset" value="Reset Margins" class="btn btn-danger">
        <input type="submit" name="margins_test" value="Print Test Claim" class="btn btn-info">
  </div>
  </form>
</div>
<div style="clear:both;"></div>

<br /><br />	
<?php include "includes/bottom.htm";?>
