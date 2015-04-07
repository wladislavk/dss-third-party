<?php 
session_start();
require_once('includes/main_include.php');
include("includes/sescheck.php");
include_once('includes/password.php');
require_once('../includes/constants.inc');
include_once '../includes/general_functions.php';
if($_POST["devsub"] == 1)
{
		if($_POST["ed"] != "")
		{
			$ed_sql = "update dental_device_guide_devices set 
				name = '".mysqli_real_escape_string($con, $_POST["name"])."'
			where id='".$_POST["ed"]."'";
			mysql_query($ed_sql) or die($ed_sql." | ".mysql_error());

  $set_sql = "SELECT * FROM dental_device_guide_settings";
  $set_q = mysql_query($set_sql);
  while($set_r = mysql_fetch_assoc($set_q)){
    $val = $_POST['setting_'.$set_r['id']];
    $check_sql = "SELECT id FROM dental_device_guide_device_setting ds 
	WHERE device_id='".mysqli_real_escape_string($con, $_POST['ed'])."' AND setting_id='".mysqli_real_escape_string($con, $set_r['id'])."'";
    $check_q = mysql_query($check_sql);
    $check_r = mysql_fetch_assoc($check_q);
    if($check_r['id'] == ''){
    $s = "INSERT INTO dental_device_guide_device_setting SET
        device_id = '".mysqli_real_escape_string($con, $_POST['ed'])."',
        setting_id = '".mysqli_real_escape_string($con, $set_r['id'])."',
        value = '".mysqli_real_escape_string($con, $val)."',
                                adddate=now(),
                                ip_address='".$_SERVER['REMOTE_ADDR']."'";
    mysql_query($s);
    }else{
      $s = "UPDATE dental_device_guide_device_setting SET
        value = '".mysqli_real_escape_string($con, $val)."'
	WHERE id='".mysqli_real_escape_string($con, $check_r['id'])."'";
      mysql_query($s);
    }
  }


			//echo $ed_sql.mysql_error();
			$msg = "Edited Successfully";
			?>
			<script type="text/javascript">
				//alert("<?=$msg;?>");
				parent.window.location='manage_device_guide_devices.php?msg=<?=$msg;?>';
			</script>
			<?
			die();
		}
		else
		{


			$ins_sql = "insert into dental_device_guide_devices set 
                                name = '".mysqli_real_escape_string($con, $_POST["name"])."',
				adddate=now(),
				ip_address='".$_SERVER['REMOTE_ADDR']."'";
			mysql_query($ins_sql) or die($ins_sql.mysql_error());
			$d_id = mysql_insert_id();

  $set_sql = "SELECT * FROM dental_device_guide_settings";
  $set_q = mysql_query($set_sql);
  while($set_r = mysql_fetch_assoc($set_q)){
    $val = $_POST['setting_'.$set_r['id']];
    $s = "INSERT INTO dental_device_guide_device_setting SET
	device_id = '".mysqli_real_escape_string($con, $d_id)."',
	setting_id = '".mysqli_real_escape_string($con, $set_r['id'])."',
	value = '".mysqli_real_escape_string($con, $val)."',
                                adddate=now(),
                                ip_address='".$_SERVER['REMOTE_ADDR']."'";
    mysql_query($s);
  }

			$msg = "Added Successfully";
			?>
			<script type="text/javascript">
				//alert("<?=$msg;?>");
				parent.window.location='manage_device_guide_devices.php?msg=<?=$msg;?>';
			</script>
			<?
			die();
		}
}

?>

<?php require_once dirname(__FILE__) . '/includes/popup_top.htm'; ?>

    <?
    $thesql = "select * from dental_device_guide_devices where id='".$_REQUEST["ed"]."'";
	$themy = mysql_query($thesql);
	$themyarray = mysql_fetch_array($themy);
	
	if($msg != '')
	{
		$name = $_POST['name'];
	}
	else
	{
		$name = st($themyarray['name']);
		$but_text = "Add ";
	}
	
	if($themyarray["id"] != '')
	{
		$but_text = "Edit ";
	}
	else
	{
		$but_text = "Add ";
	}
	?>
	
	<br /><br />
	
	<? if($msg != '') {?>
    <div class="alert alert-danger text-center">
        <? echo $msg;?>
    </div>
    <? }?>
    <form name="userfrm" action="<?=$_SERVER['PHP_SELF'];?>?add=1" method="post" >
    <table class="table table-bordered table-hover">
        <tr>
            <td colspan="2" class="cat_head">
               <?=$but_text?> Device Setting
               <? if($name <> "") {?>
               		&quot;<?=$name;?>&quot;
               <? }?>
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                Name
            </td>
            <td valign="top" class="frmdata">
                <input id="name" type="text" name="name" value="<?=$name;?>" class="form-control" /> 
            </td>
        </tr>
<?php
  $set_sql = "SELECT s.*, ds.value FROM dental_device_guide_settings s
		LEFT JOIN dental_device_guide_device_setting ds ON s.id = ds.setting_id AND ds.device_id='".mysqli_real_escape_string($con, $_GET['ed'])."'";
  $set_q = mysql_query($set_sql);
  while($set_r = mysql_fetch_assoc($set_q)){ 
    ?>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                <?= $set_r['name']; ?> 
                                        <?php if($set_r["setting_type"] == DSS_DEVICE_SETTING_TYPE_RANGE){ ?>
                                                (<?= $set_r['range_start']; ?> - <?= $set_r['range_end']; ?>)
                                        <?php } ?>
            </td>
            <td valign="top" class="frmdata">
		<?php if($set_r["setting_type"] == DSS_DEVICE_SETTING_TYPE_RANGE){ ?>
                  <input id="setting_<?= $set_r['id']; ?>" type="text" name="setting_<?= $set_r['id']; ?>" value="<?=$set_r['value'];?>" class="form-control" />
		<?php }else{ ?>
		  <input type="checkbox" <?= ($set_r['value']==1)?'checked="checked"':''; ?> id="setting_<?= $set_r['id']; ?>" type="text" name="setting_<?= $set_r['id']; ?>" value="1" />
		<?php } ?>
            </td>
        </tr>

    <?
  }

?>
        <tr>
            <td  colspan="2" align="center">
                <input type="hidden" name="devsub" value="1" />
                <input type="hidden" name="ed" value="<?=$themyarray["id"]?>" />
                <input type="submit" value="<?=$but_text?> Device" class="btn btn-primary">
            </td>
        </tr>
    </table>
    </form>
</body>
</html>
