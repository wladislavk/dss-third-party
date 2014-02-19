<?php 
session_start();
require_once('includes/main_include.php');
include("includes/sescheck.php");
require_once "../includes/constants.inc";
require_once "../includes/general_functions.php";
/*
if($_POST["mult_devicesub"] == 1)
{
	$op_arr = split("\n",trim($_POST['device']));
				
	foreach($op_arr as $i=>$val)
	{
		if($val <> '')
		{
			$sel_check = "select * from dental_device where device = '".s_for($val)."'";
			$query_check=mysql_query($sel_check);
			
			if(mysql_num_rows($query_check) == 0)
			{
				$ins_sql = "insert into dental_device set device = '".s_for($val)."', adddate=now(),ip_address='".$_SERVER['REMOTE_ADDR']."'";
				mysql_query($ins_sql) or die($ins_sql.mysql_error());
			}
			
		}
	}
	
	$msg = "Added Successfully";
	?>
	<script type="text/javascript">
		//alert("<?=$msg;?>");
		parent.window.location='manage_device.php?msg=<?=$msg;?>';
	</script>
	<?
	die();
}
*/
if($_POST["devicesub"] == 1)
{
	$sel_check = "select * from dental_device where device = '".s_for($_POST["device"])."' and deviceid <> '".s_for($_POST['ed'])."'";
	$query_check=mysql_query($sel_check);
	
	if(mysql_num_rows($query_check)>0)
	{
		$msg="Device already exist. So please give another Device.";
		?>
		<script type="text/javascript">
			alert("<?=$msg;?>");
			window.location="#add";
		</script>
		<?
	} 
	else
	{
		if(s_for($_POST["sortby"]) == '' || is_numeric(s_for($_POST["sortby"])) === false)
		{
			$sby = 999;
		}
		else
		{
			$sby = s_for($_POST["sortby"]);
		}
		
		if($_POST["ed"] != "")
		{



             $filesize = $_FILES["image"]["size"];
             if($filesize <= DSS_IMAGE_MAX_SIZE){
                if($_FILES["image"]["name"] <> '')
                {
                        $fname = $_FILES["image"]["name"];
                        $lastdot = strrpos($fname,".");
                        $name = substr($fname,0,$lastdot);
                        $extension = substr($fname,$lastdot+1);
                        $banner1 = 'dental_device_'.$_POST['ed'];
                        $banner1 .= ".".$extension;
                        $uploaded = uploadImage($_FILES['image'], "../q_file/".$banner1, 'device');
                }
                else
                {
			$uploaded = false;
                }
             }else{
                ?>
                <script type="text/javascript">
                  alert('Max image size exceeded. Uploaded files can be no larger than 10 megabytes.');
                </script>
                <?php
                $uploaded = false;
             }

if(!$uploaded){
  $banner1 = '';
}



			$ed_sql = "update dental_device set device = '".s_for($_POST["device"])."', sortby = '".s_for($sby)."', status = '".s_for($_POST["status"])."', description = '".s_for($_POST["description"])."', image_path='".mysql_real_escape_string($banner1)."' where deviceid='".$_POST["ed"]."'";
			mysql_query($ed_sql) or die($ed_sql." | ".mysql_error());


  $set_sql = "SELECT * FROM dental_device_guide_settings";
  $set_q = mysql_query($set_sql);
  while($set_r = mysql_fetch_assoc($set_q)){
    $val = $_POST['setting_'.$set_r['id']];
    $check_sql = "SELECT id FROM dental_device_guide_device_setting ds 
        WHERE device_id='".mysql_real_escape_string($_POST['ed'])."' AND setting_id='".mysql_real_escape_string($set_r['id'])."'";
    $check_q = mysql_query($check_sql);
    $check_r = mysql_fetch_assoc($check_q);
    if($check_r['id'] == ''){
    $s = "INSERT INTO dental_device_guide_device_setting SET
        device_id = '".mysql_real_escape_string($_POST['ed'])."',
        setting_id = '".mysql_real_escape_string($set_r['id'])."',
        value = '".mysql_real_escape_string($val)."',
                                adddate=now(),
                                ip_address='".$_SERVER['REMOTE_ADDR']."'";
    mysql_query($s);
    }else{
      $s = "UPDATE dental_device_guide_device_setting SET
        value = '".mysql_real_escape_string($val)."'
        WHERE id='".mysql_real_escape_string($check_r['id'])."'";
      mysql_query($s);
    }
  }


			
			//echo $ed_sql.mysql_error();
			$msg = "Edited Successfully";
			?>
			<script type="text/javascript">
				//alert("<?=$msg;?>");
				parent.window.location='manage_device.php?msg=<?=$msg;?>';
			</script>
			<?
			die();
		}
		else
		{
			$ins_sql = "insert into dental_device set device = '".s_for($_POST["device"])."', sortby = '".s_for($sby)."', status = '".s_for($_POST["status"])."', description = '".s_for($_POST["description"])."',adddate=now(),ip_address='".$_SERVER['REMOTE_ADDR']."'";
			mysql_query($ins_sql) or die($ins_sql.mysql_error());
                        $d_id = mysql_insert_id();

  $set_sql = "SELECT * FROM dental_device_guide_settings";
  $set_q = mysql_query($set_sql);
  while($set_r = mysql_fetch_assoc($set_q)){
    $val = $_POST['setting_'.$set_r['id']];
    $s = "INSERT INTO dental_device_guide_device_setting SET
        device_id = '".mysql_real_escape_string($d_id)."',
        setting_id = '".mysql_real_escape_string($set_r['id'])."',
        value = '".mysql_real_escape_string($val)."',
                                adddate=now(),
                                ip_address='".$_SERVER['REMOTE_ADDR']."'";
    mysql_query($s);
  }
			
			$msg = "Added Successfully";
			?>
			<script type="text/javascript">
				//alert("<?=$msg;?>");
				parent.window.location='manage_device.php?msg=<?=$msg;?>';
			</script>
			<?
			die();
		}
	}
}

?>

<?php require_once dirname(__FILE__) . '/includes/popup_top.htm'; ?>

    <?
    $thesql = "select * from dental_device where deviceid='".$_REQUEST["ed"]."'";
	$themy = mysql_query($thesql);
	$themyarray = mysql_fetch_array($themy);
	
	if($msg != '')
	{
		$device = $_POST['device'];
		$sortby = $_POST['sortby'];
		$status = $_POST['status'];
		$description = $_POST['description'];
		$image_path = '';
	}
	else
	{
		$device = st($themyarray['device']);
		$sortby = st($themyarray['sortby']);
		$status = st($themyarray['status']);
		$description = st($themyarray['description']);
		$image_path = st($themyarray['image_path']);
		$but_text = "Add ";
	}
	
	if($themyarray["deviceid"] != '')
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
    <form name="devicefrm" action="<?=$_SERVER['PHP_SELF'];?>?add=1" method="post" onSubmit="return deviceabc(this)" enctype="multipart/form-data">
    <table class="table table-bordered table-hover">
        <tr>
            <td colspan="2" class="cat_head">
               <?=$but_text?> Device 
               <? if($device <> "") {?>
               		&quot;<?=$device;?>&quot;
               <? }?>
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Device
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="device" value="<?=$device?>" class="form-control" /> 
                <span class="red">*</span>				
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                Sort By
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="sortby" value="<?=$sortby;?>" class="form-control" style="width:30px"/>		
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                Status
            </td>
            <td valign="top" class="frmdata">
            	<select name="status" class="form-control">
                	<option value="1" <? if($status == 1) echo " selected";?>>Active</option>
                	<option value="2" <? if($status == 2) echo " selected";?>>In-Active</option>
                </select>
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                Description
            </td>
            <td valign="top" class="frmdata">
            	<textarea class="form-control" name="description" style="width:100%;"><?=$description;?></textarea>
            </td>
        </tr>
<?php
  $set_sql = "SELECT s.*, ds.value FROM dental_device_guide_settings s
                LEFT JOIN dental_device_guide_device_setting ds ON s.id = ds.setting_id AND ds.device_id='".mysql_real_escape_string($_GET['ed'])."'";
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
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
		Image
            </td>
            <td valign="top" class="frmdata">
                  <input id="image" type="file" name="image" class="form-control" />
 		  <?php if($image_path != ''){ ?>
    		    <img src="../q_file/<?= $image_path; ?>" />
		  <?php } ?>
            </td>
        </tr>


        <tr>
            <td  colspan="2" align="center">
                <span class="red">
                    * Required Fields					
                </span><br />
                <input type="hidden" name="devicesub" value="1" />
                <input type="hidden" name="ed" value="<?=$themyarray["deviceid"]?>" />
                <input type="submit" value="<?=$but_text?> Device" class="btn btn-primary">
		<?php if($themyarray["deviceid"] != '' && $_SESSION['admin_access']==1){ ?>
                    <a href="manage_device.php?delid=<?=$themyarray["deviceid"];?>" onclick="javascript: return confirm('Do Your Really want to Delete?.');" target="_parent" class="editdel dellink" title="DELETE">
                                                Delete
                                        </a>
		<?php } ?>
            </td>
        </tr>
    </table>
    </form>
    
    <? 

/*
if($_GET['ed'] == '')
	{?>
    	<div class="alert alert-danger text-center">
    		<b>--------------------------------- OR ---------------------------------</b>
        </div>
		<form name="devicefrm" action="<?=$_SERVER['PHP_SELF'];?>?add=1" method="post" onSubmit="return deviceabc(this)">
        <table class="table table-bordered table-hover">
            <tr>
                <td colspan="2" class="cat_head">
                   Add Multiple Device 
                   <span class="red">
	                   (Type Each New Device on New Line)
                   </span>
                </td>
            </tr>
            <tr bgcolor="#FFFFFF">
                <td valign="top" class="frmdata">
                    <textarea class="form-control" name="device" style="width:100%; height:150px;"></textarea>
                </td>
            </tr>
            <tr>
                <td  colspan="2" align="center">
                    <span class="red">
                        * Required Fields					
                    </span><br />
                    <input type="hidden" name="mult_devicesub" value="1" />
                    <input type="submit" value="Add Multiple Device" class="btn btn-primary">
                </td>
            </tr>
        </table>
        </form>
    
    <? }
*/ ?>
</body>
</html>
