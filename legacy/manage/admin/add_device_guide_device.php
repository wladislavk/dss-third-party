<?php
namespace Ds3\Libraries\Legacy;

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
				name = '".$db->escape( $_POST["name"])."'
			where id='".$_POST["ed"]."'";
			mysqli_query($con, $ed_sql) or trigger_error($ed_sql." | ".mysqli_error($con), E_USER_ERROR);

  $set_sql = "SELECT * FROM dental_device_guide_settings";
  $set_q = mysqli_query($con, $set_sql);
  while($set_r = mysqli_fetch_assoc($set_q)){
    $val = $_POST['setting_'.$set_r['id']];
    $check_sql = "SELECT id FROM dental_device_guide_device_setting ds 
	WHERE device_id='".$db->escape( $_POST['ed'])."' AND setting_id='".$db->escape( $set_r['id'])."'";
    $check_q = mysqli_query($con, $check_sql);
    $check_r = mysqli_fetch_assoc($check_q);
    if($check_r['id'] == ''){
    $s = "INSERT INTO dental_device_guide_device_setting SET
        device_id = '".$db->escape( $_POST['ed'])."',
        setting_id = '".$db->escape( $set_r['id'])."',
        value = '".$db->escape( $val)."',
                                adddate=now(),
                                ip_address='".$_SERVER['REMOTE_ADDR']."'";
    mysqli_query($con, $s);
    }else{
      $s = "UPDATE dental_device_guide_device_setting SET
        value = '".$db->escape( $val)."'
	WHERE id='".$db->escape( $check_r['id'])."'";
      mysqli_query($con, $s);
    }
  }
			$msg = "Edited Successfully";
			?>
			<script type="text/javascript">
				parent.window.location='manage_device_guide_devices.php?msg=<?=$msg;?>';
			</script>
			<?php
			trigger_error("Die called", E_USER_ERROR);
		}
		else
		{
			$ins_sql = "insert into dental_device_guide_devices set 
                                name = '".$db->escape( $_POST["name"])."',
				adddate=now(),
				ip_address='".$_SERVER['REMOTE_ADDR']."'";
			mysqli_query($con, $ins_sql) or trigger_error($ins_sql.mysqli_error($con), E_USER_ERROR);
			$d_id = mysqli_insert_id($con);

  $set_sql = "SELECT * FROM dental_device_guide_settings";
  $set_q = mysqli_query($con, $set_sql);
  while($set_r = mysqli_fetch_assoc($set_q)){
    $val = $_POST['setting_'.$set_r['id']];
    $s = "INSERT INTO dental_device_guide_device_setting SET
	device_id = '".$db->escape( $d_id)."',
	setting_id = '".$db->escape( $set_r['id'])."',
	value = '".$db->escape( $val)."',
                                adddate=now(),
                                ip_address='".$_SERVER['REMOTE_ADDR']."'";
    mysqli_query($con, $s);
  }

			$msg = "Added Successfully";
			?>
			<script type="text/javascript">
				parent.window.location='manage_device_guide_devices.php?msg=<?=$msg;?>';
			</script>
			<?php
			trigger_error("Die called", E_USER_ERROR);
		}
}

?>

<?php require_once dirname(__FILE__) . '/includes/popup_top.htm'; ?>

    <?php
    $thesql = "select * from dental_device_guide_devices where id='".$_REQUEST["ed"]."'";
	$themy = mysqli_query($con, $thesql);
	$themyarray = mysqli_fetch_array($themy);
	
	if($msg != '')
	{
		$name = $_POST['name'];
	}
	else
	{
		$name = st($themyarray['name']);
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
	
	<?php if($msg != '') {?>
    <div class="alert alert-danger text-center">
        <?php echo $msg;?>
    </div>
    <?php }?>
    <form name="userfrm" action="<?=$_SERVER['PHP_SELF'];?>?add=1" method="post" >
    <table class="table table-bordered table-hover">
        <tr>
            <td colspan="2" class="cat_head">
               <?=$but_text?> Device Setting
               <?php if($name <> "") {?>
               		&quot;<?=$name;?>&quot;
               <?php }?>
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
		LEFT JOIN dental_device_guide_device_setting ds ON s.id = ds.setting_id AND ds.device_id='".$db->escape( $_GET['ed'])."'";
  $set_q = mysqli_query($con, $set_sql);
  while($set_r = mysqli_fetch_assoc($set_q)){ 
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
    <?php
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
