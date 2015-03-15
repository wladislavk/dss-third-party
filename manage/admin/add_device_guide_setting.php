<?php namespace Ds3\Libraries\Legacy; ?><?php 

include_once('includes/main_include.php');
include("includes/sescheck.php");
include_once('includes/password.php');
include_once('../includes/constants.inc');
include_once '../includes/general_functions.php';

if(!empty($_POST["setsub"]) && $_POST["setsub"] == 1)
{
		if($_POST["ed"] != "")
		{
			$ed_sql = "update dental_device_guide_settings set 
				name = '".mysqli_real_escape_string($con,$_POST["name"])."',
                                setting_type = '".mysqli_real_escape_string($con,$_POST["setting_type"])."', 
                                range_start = '".mysqli_real_escape_string($con,$_POST["range_start"])."', 
                                range_start_label = '".mysqli_real_escape_string($con,$_POST["range_start_label"])."', 
                                range_end = '".mysqli_real_escape_string($con,$_POST['range_end'])."',
				range_end_label = '".mysqli_real_escape_string($con,$_POST['range_end_label'])."',
				rank = '".mysqli_real_escape_string($con,$_POST['rank'])."',
				options = '".mysqli_real_escape_string($con,$_POST['options'])."'
			where id='".$_POST["ed"]."'";
			mysqli_query($con,$ed_sql);

			mysqli_query($con,"DELETE FROM dental_device_guide_setting_options WHERE setting_id='".mysqli_real_escape_string($con,$_POST['ed'])."'");
                        for($i=1; $i<=$_POST['options']; $i++){
                          $o_sql = "INSERT INTO dental_device_guide_setting_options SET
                                        option_id='".$i."',
                                        setting_id='".mysqli_real_escape_string($con,$_POST['ed'])."',
                                        label='".$_POST['option_'.$i]."'";
                          mysqli_query($con,$o_sql);
                        }


			$msg = "Edited Successfully";
			?>
			<script type="text/javascript">
				//alert("<?php echo $msg;?>");
				parent.window.location='manage_device_guide_settings.php?msg=<?php echo $msg;?>';
			</script>
			<?
			die();
		}
		else
		{


			$ins_sql = "insert into dental_device_guide_settings set 
                                name = '".mysqli_real_escape_string($con,$_POST["name"])."',
                                setting_type = '".mysqli_real_escape_string($con,$_POST["setting_type"])."', 
                                range_start = '".mysqli_real_escape_string($con,$_POST["range_start"])."', 
                                range_start_label = '".mysqli_real_escape_string($con,$_POST["range_start_label"])."', 
                                range_end = '".mysqli_real_escape_string($con,$_POST['range_end'])."',
                                range_end_label = '".mysqli_real_escape_string($con,$_POST['range_end_label'])."',
				rank = '".mysqli_real_escape_string($con,$_POST['rank'])."',
				options = '".mysqli_real_escape_string($con,$_POST['options'])."',
				adddate=now(),
				ip_address='".$_SERVER['REMOTE_ADDR']."'";
			mysqli_query($con,$ins_sql);

			$setting_id = mysqli_insert_id($con);

			for($i=1; $i<=$_POST['options']; $i++){
			  $o_sql = "INSERT INTO dental_device_guide_setting_options SET
					option_id='".$i."',
					setting_id='".$setting_id."',
					label='".$_POST['option_'.$i]."'";
			  mysqli_query($con,$o_sql);
			}

			$msg = "Added Successfully";
			?>
			<script type="text/javascript">
				//alert("<?php echo $msg;?>");
				parent.window.location='manage_device_guide_settings.php?msg=<?php echo $msg;?>';
			</script>
			<?
			die();
		}
}

?>

<?php include_once dirname(__FILE__) . '/includes/popup_top.htm'; ?>

    <?
    $thesql = "select * from dental_device_guide_settings where id='".(!empty($_REQUEST["ed"]) ? $_REQUEST["ed"] : '')."'";
	$themy = mysqli_query($con,$thesql);
	$themyarray = mysqli_fetch_array($themy);
	
	if(!empty($msg))
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
	
	<?php if(!empty($msg)) {?>
    <div class="alert alert-danger text-center">
        <?php echo $msg;?>
    </div>
    <?php }?>
    <form name="userfrm" action="<?php echo $_SERVER['PHP_SELF'];?>?add=1" method="post" onsubmit="return check_add();">
    <table class="table table-bordered table-hover">
        <tr>
            <td colspan="2" class="cat_head">
               <?php echo $but_text?> Device Setting
               <?php if($name <> "") {?>
               		&quot;<?php echo $name;?>&quot;
               <?php }?>
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                Name
            </td>
            <td valign="top" class="frmdata">
                <input id="name" type="text" name="name" value="<?php echo $name;?>" class="form-control" /> 
		<span class="red">*</span>
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                Rank
            </td>
            <td valign="top" class="frmdata">
                <input id="rank" type="text" name="rank" value="<?php echo $rank;?>" class="form-control" />
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                Setting Type
            </td>
            <td valign="top" class="frmdata">
		<select id="setting_type" name="setting_type">
			<option value="<?php echo  DSS_DEVICE_SETTING_TYPE_RANGE; ?>" <?php echo  ($setting_type==DSS_DEVICE_SETTING_TYPE_RANGE)?'selected="selected"':''; ?>><?php echo  $dss_device_setting_type_labels[DSS_DEVICE_SETTING_TYPE_RANGE]; ?></option>
                        <option value="<?php echo  DSS_DEVICE_SETTING_TYPE_FLAG; ?>" <?php echo  ($setting_type==DSS_DEVICE_SETTING_TYPE_FLAG)?'selected="selected"':''; ?>><?php echo  $dss_device_setting_type_labels[DSS_DEVICE_SETTING_TYPE_FLAG]; ?></option>
 		</select>
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                Range Start
            </td>
            <td valign="top" class="frmdata">
                <input id="range_start" type="text" name="range_start" value="<?php echo $range_start;?>" class="form-control" />
            </td>
        </tr>
	<tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                Range Start Label
            </td>
            <td valign="top" class="frmdata">
                <input id="range_start_label" type="text" name="range_start_label" value="<?php echo $range_start_label;?>" class="form-control" />
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                Range End
            </td>
            <td valign="top" class="frmdata">
                <input id="range_end" type="text" name="range_end" value="<?php echo $range_end;?>" class="form-control" />
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                Range End Label
            </td>
            <td valign="top" class="frmdata">
                <input id="range_end_label" type="text" name="range_end_label" value="<?php echo $range_end_label;?>" class="form-control" />
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                Number of options
            </td>
            <td valign="top" class="frmdata">
		<select id="options" name="options" onchange="update_option_labels();">
		  <?php for($i=1; $i<=10; $i++){ ?>
		    <option value="<?php echo  $i; ?>" <?php echo  ($options == $i)?'selected="selected"':''; ?>><?php echo  $i; ?></option>
		  <?php } ?>
		</select>
            </td>
        </tr>
                  <?php for($i=1; $i<=10; $i++){ ?>
		<?php
			$o_sql = "SELECT label FROM dental_device_guide_setting_options o
					WHERE option_id='".mysqli_real_escape_string($con,$i)."'
						AND setting_id='".mysqli_real_escape_string($con,(!empty($_REQUEST['ed']) ? $_REQUEST['ed'] : ''))."'";
			$o_q = mysqli_query($con,$o_sql);
			$o_r = mysqli_fetch_assoc($o_q);
			
		?>
        <tr bgcolor="#FFFFFF" id="option_row_<?php echo $i;?>" style="display:none;" class="option_row">
            <td valign="top" class="frmhead">
                Option #<?php echo  $i; ?> 
            </td>
            <td valign="top" class="frmdata">
		<input id="option_<?php echo  $i; ?>" type="text" name="option_<?php echo  $i; ?>" value="<?php echo $o_r['label'];?>" class="form-control" />
            </td>
        </tr>
		  <?php } ?>
        <tr>
            <td  colspan="2" align="center">
                <input type="hidden" name="setsub" value="1" />
                <input type="hidden" name="ed" value="<?php echo $themyarray["id"]?>" />
                <input type="submit" value="<?php echo $but_text?> Setting" class="btn btn-primary">
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

  function check_add(){
    if($('#name').val()==""){
      alert('Name is required');
      return false;
    }
    return true;
  }

</script>
</body>
</html>
