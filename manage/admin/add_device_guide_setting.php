<?php 
session_start();
require_once('includes/config.php');
include("includes/sescheck.php");
include_once('includes/password.php');
require_once('../includes/constants.inc');
include_once '../includes/general_functions.php';
if($_POST["setsub"] == 1)
{
		if($_POST["ed"] != "")
		{
			$ed_sql = "update dental_device_guide_settings set 
				name = '".mysql_real_escape_string($_POST["name"])."',
                                setting_type = '".mysql_real_escape_string($_POST["setting_type"])."', 
                                range_start = '".mysql_real_escape_string($_POST["range_start"])."', 
                                range_start_label = '".mysql_real_escape_string($_POST["range_start_label"])."', 
                                range_end = '".mysql_real_escape_string($_POST['range_end'])."',
				range_end_label = '".mysql_real_escape_string($_POST['range_end_label'])."',
				rank = '".mysql_real_escape_string($_POST['rank'])."',
				options = '".mysql_real_escape_string($_POST['options'])."'
			where id='".$_POST["ed"]."'";
			mysql_query($ed_sql) or die($ed_sql." | ".mysql_error());

			mysql_query("DELETE FROM dental_device_guide_setting_options WHERE setting_id='".mysql_real_escape_string($_POST['ed'])."'");
                        for($i=1; $i<=$_POST['options']; $i++){
                          $o_sql = "INSERT INTO dental_device_guide_setting_options SET
                                        option_id='".$i."',
                                        setting_id='".mysql_real_escape_string($_POST['ed'])."',
                                        label='".$_POST['option_'.$i]."'";
                          mysql_query($o_sql);
                        }



			//echo $ed_sql.mysql_error();
			$msg = "Edited Successfully";
			?>
			<script type="text/javascript">
				//alert("<?=$msg;?>");
				parent.window.location='manage_device_guide_settings.php?msg=<?=$msg;?>';
			</script>
			<?
			die();
		}
		else
		{


			$ins_sql = "insert into dental_device_guide_settings set 
                                name = '".mysql_real_escape_string($_POST["name"])."',
                                setting_type = '".mysql_real_escape_string($_POST["setting_type"])."', 
                                range_start = '".mysql_real_escape_string($_POST["range_start"])."', 
                                range_start_label = '".mysql_real_escape_string($_POST["range_start_label"])."', 
                                range_end = '".mysql_real_escape_string($_POST['range_end'])."',
                                range_end_label = '".mysql_real_escape_string($_POST['range_end_label'])."',
				rank = '".mysql_real_escape_string($_POST['rank'])."',
				options = '".mysql_real_escape_string($_POST['options'])."',
				adddate=now(),
				ip_address='".$_SERVER['REMOTE_ADDR']."'";
			mysql_query($ins_sql) or die($ins_sql.mysql_error());

			$setting_id = mysql_insert_id();

			for($i=1; $i<=$_POST['options']; $i++){
			  $o_sql = "INSERT INTO dental_device_guide_setting_options SET
					option_id='".$i."',
					setting_id='".$setting_id."',
					label='".$_POST['option_'.$i]."'";
			  mysql_query($o_sql);
			}

			$msg = "Added Successfully";
			?>
			<script type="text/javascript">
				//alert("<?=$msg;?>");
				parent.window.location='manage_device_guide_settings.php?msg=<?=$msg;?>';
			</script>
			<?
			die();
		}
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="css/admin.css" rel="stylesheet" type="text/css" />
<script language="javascript" type="text/javascript" src="script/validation.js"></script>
  <script type="text/javascript" src="/manage/admin/script/jquery-1.6.2.min.js"></script>
</head>
<body>

    <?
    $thesql = "select * from dental_device_guide_settings where id='".$_REQUEST["ed"]."'";
	$themy = mysql_query($thesql);
	$themyarray = mysql_fetch_array($themy);
	
	if($msg != '')
	{
		$name = $_POST['name'];
		$setting_type = $_POST['setting_type'];
	 	$range_start = $_POST['range_start'];
                $range_start_label = $_POST['range_start_label'];
                $range_end = $_POST['range_end'];
		$range_end_label = $_POST['range_end_label'];
		$rank = $_POST['rank'];
		$options = $_POST['options'];
	}
	else
	{
		$name = st($themyarray['name']);
                $setting_type = st($themyarray['setting_type']);
                $range_start = st($themyarray['range_start']);
                $range_start_label = st($themyarray['range_start_label']);
                $range_end = st($themyarray['range_end']);
                $range_end_label = st($themyarray['range_end_label']);
		$rank = st($themyarray['rank']);
		$options = st($themyarray['options']);
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
    <div align="center" class="red">
        <? echo $msg;?>
    </div>
    <? }?>
    <form name="userfrm" action="<?=$_SERVER['PHP_SELF'];?>?add=1" method="post" >
    <table width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center">
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
                <input id="name" type="text" name="name" value="<?=$name;?>" class="tbox" /> 
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                Rank
            </td>
            <td valign="top" class="frmdata">
                <input id="rank" type="text" name="rank" value="<?=$rank;?>" class="tbox" />
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                Setting Type
            </td>
            <td valign="top" class="frmdata">
		<select id="setting_type" name="setting_type">
			<option value="<?= DSS_DEVICE_SETTING_TYPE_RANGE; ?>" <?= ($setting_type==DSS_DEVICE_SETTING_TYPE_RANGE)?'selected="selected"':''; ?>><?= $dss_device_setting_type_labels[DSS_DEVICE_SETTING_TYPE_RANGE]; ?></option>
                        <option value="<?= DSS_DEVICE_SETTING_TYPE_FLAG; ?>" <?= ($setting_type==DSS_DEVICE_SETTING_TYPE_FLAG)?'selected="selected"':''; ?>><?= $dss_device_setting_type_labels[DSS_DEVICE_SETTING_TYPE_FLAG]; ?></option>
 		</select>
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                Range Start
            </td>
            <td valign="top" class="frmdata">
                <input id="range_start" type="text" name="range_start" value="<?=$range_start;?>" class="tbox" />
            </td>
        </tr>
	<tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                Range Start Label
            </td>
            <td valign="top" class="frmdata">
                <input id="range_start_label" type="text" name="range_start_label" value="<?=$range_start_label;?>" class="tbox" />
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                Range End
            </td>
            <td valign="top" class="frmdata">
                <input id="range_end" type="text" name="range_end" value="<?=$range_end;?>" class="tbox" />
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                Range End Label
            </td>
            <td valign="top" class="frmdata">
                <input id="range_end_label" type="text" name="range_end_label" value="<?=$range_end_label;?>" class="tbox" />
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                Number of options
            </td>
            <td valign="top" class="frmdata">
		<select id="options" name="options" onchange="update_option_labels();">
		  <?php for($i=1; $i<=10; $i++){ ?>
		    <option value="<?= $i; ?>" <?= ($options == $i)?'selected="selected"':''; ?>><?= $i; ?></option>
		  <?php } ?>
		</select>
            </td>
        </tr>
                  <?php for($i=1; $i<=10; $i++){ ?>
		<?php
			$o_sql = "SELECT label FROM dental_device_guide_setting_options o
					WHERE option_id='".mysql_real_escape_string($i)."'
						AND setting_id='".mysql_real_escape_string($_REQUEST['ed'])."'";
			$o_q = mysql_query($o_sql);
			$o_r = mysql_fetch_assoc($o_q);
			
		?>
        <tr bgcolor="#FFFFFF" id="option_row_<?=$i;?>" style="display:none;" class="option_row">
            <td valign="top" class="frmhead">
                Option #<?= $i; ?> 
            </td>
            <td valign="top" class="frmdata">
		<input id="option_<?= $i; ?>" type="text" name="option_<?= $i; ?>" value="<?=$o_r['label'];?>" class="tbox" />
            </td>
        </tr>
		  <?php } ?>
        <tr>
            <td  colspan="2" align="center">
                <input type="hidden" name="setsub" value="1" />
                <input type="hidden" name="ed" value="<?=$themyarray["id"]?>" />
                <input type="submit" value=" <?=$but_text?> Setting" class="button" />
            </td>
        </tr>
    </table>
    </form>
<script type="text/javascript">
  function update_option_labels(){
    $('.option_row').hide();
    num = $('#options').val();
    for(i=1;i<=num;i++){
      $('#option_row_'+i).show();
    }
  }
  $(document).ready(function(){
    update_option_labels();
  });
</script>
</body>
</html>
