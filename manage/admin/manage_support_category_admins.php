<?php namespace Ds3\Legacy; ?><?php 
include "includes/top.htm";

if(!empty($_POST["update"]))
{
	$del_sql = "DELETE FROM dental_support_category_admin WHERE category_id='".mysqli_real_escape_string($con,$_REQUEST["catid"])."'";
	mysqli_query($con,$del_sql);
	$admins = $_POST['admin'];

	foreach($admins as $admin){
          $ins_sql = "INSERT INTO dental_support_category_admin SET category_id='".mysqli_real_escape_string($con,$_REQUEST["catid"])."', adminid='".mysqli_real_escape_string($con,$admin)."',
			adddate=now(), ip_address='".mysqli_real_escape_string($con,$_SERVER['REMOTE_ADDR'])."'";
	  mysqli_query($con,$ins_sql);
	}
	$msg= "Updated Successfully";
        ?>
        <script type="text/javascript">
                //alert("Deleted Successfully");
                window.location="manage_support_categories.php?msg=<?php echo $msg?>";
        </script>
        <?
        die();
}

$sql = "select a.*,
	(SELECT '1' FROM dental_support_category_admin ca WHERE ca.adminid=a.adminid AND ca.category_id='".mysqli_real_escape_string($con,$_GET['catid'])."' LIMIT 1) AS selected 
	FROM admin a 
	WHERE a.status=1
	 order by a.name ASC";
$my = mysqli_query($con,$sql);
$total_rec = mysqli_num_rows($my);

?>

<link rel="stylesheet" href="popup/popup.css" type="text/css" media="screen" />
<script src="popup/popup.js" type="text/javascript"></script>

<div class="page-header">
	<h2>Manage Support Category Admins <small>- <?php echo  (!empty($r['title']) ? $r['title'] : ''); ?>
</small></h2></div>
<br />
<br />


<br />
<div align="center" class="red">
	<b><?php echo (!empty($_GET['msg']) ? $_GET['msg'] : '');?></b>
</div>
<form action="<?php echo  $_SERVER['PHP_SELF']; ?>?catid=<?php echo $_GET['catid'];?>" method="post">
<?php
  while($a = mysqli_fetch_assoc($my)){
    ?>
    <input type="checkbox" name="admin[]" value="<?php echo $a['adminid'];?>" <?php echo  ($a['selected'])?'checked="checked"':''; ?> /> <?php echo  $a['name']; ?><br />
    <?php
  }
?>
<input type="submit" name="update" value="Update" class="btn btn-primary">
</form>
<div id="popupContact">
    <a id="popupContactClose"><span class="glyphicon glyphicon-remove"></span></a>
    <iframe id="aj_pop" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
</div>
<div id="backgroundPopup"></div>

<br /><br />	
<?php include "includes/bottom.htm";?>
