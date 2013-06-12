<? 
include "includes/top.htm";

if($_POST["update"] != "")
{
	$del_sql = "DELETE FROM dental_support_category_admin WHERE category_id='".mysql_real_escape_string($_REQUEST["catid"])."'";
	mysql_query($del_sql);
	$admins = $_POST['admin'];

	foreach($admins as $admin){
          $ins_sql = "INSERT INTO dental_support_category_admin SET category_id='".mysql_real_escape_string($_REQUEST["catid"])."', adminid='".mysql_real_escape_string($admin)."',
			adddate=now(), ip_address='".mysql_real_escape_string($_SERVER['REMOTE_ADDR'])."'";
	  mysql_query($ins_sql);
	}
	$msg= "Updated Successfully";
        ?>
        <script type="text/javascript">
                //alert("Deleted Successfully");
                window.location="manage_support_categories.php?msg=<?=$msg?>";
        </script>
        <?
        die();
}

$sql = "select a.*,
	(SELECT '1' FROM dental_support_category_admin ca WHERE ca.adminid=a.adminid AND ca.category_id='".mysql_real_escape_string($_GET['catid'])."' LIMIT 1) AS selected 
	FROM admin a 
	WHERE a.status=1
	 order by a.name ASC";
$my = mysql_query($sql);
$total_rec = mysql_num_rows($my);

?>

<link rel="stylesheet" href="popup/popup.css" type="text/css" media="screen" />
<script src="popup/jquery-1.2.6.min.js" type="text/javascript"></script>
<script src="popup/popup.js" type="text/javascript"></script>

<span class="admin_head">
	Manage Support Category Admins - <?= $r['title']; ?>
</span>
<br />
<br />


<br />
<div align="center" class="red">
	<b><? echo $_GET['msg'];?></b>
</div>
<form action="<?= $_SERVER['PHP_SELF']; ?>?catid=<?=$_GET['catid'];?>" method="post">
<?php
  while($a = mysql_fetch_assoc($my)){
    ?>
    <input type="checkbox" name="admin[]" value="<?=$a['adminid'];?>" <?= ($a['selected'])?'checked="checked"':''; ?> /> <?= $a['name']; ?><br />
    <?php
  }
?>
<input type="submit" name="update" value="Update" />
</form>
<div id="popupContact">
    <a id="popupContactClose"><button>X</button></a>
    <iframe id="aj_pop" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
</div>
<div id="backgroundPopup"></div>

<br /><br />	
<? include "includes/bottom.htm";?>
