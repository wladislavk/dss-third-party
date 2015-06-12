<?php namespace Ds3\Libraries\Legacy; ?><?php 
	include_once('admin/includes/main_include.php');
	include("admin/includes/sescheck.php");

	if(!empty($_POST["palpationsub"]) && $_POST["palpationsub"] == 1) {
		$sel_check = "select * from dental_palpation where palpation = '".s_for($_POST["palpation"])."' and palpationid <> '".s_for($_POST['ed'])."'";
			
		if($db->getNumberRows($sel_check) > 0) {
			$msg = "Palpation already exist. So please give another Palpation.";
?>
			<script type="text/javascript">
				alert("<?php echo $msg;?>");
				window.location = "#add";
			</script>
<?php
		} else {
			if(s_for($_POST["sortby"]) == '' || is_numeric(s_for($_POST["sortby"])) === false) {
				$sby = 999;
			} else {
				$sby = s_for($_POST["sortby"]);
			}
		
			if($_POST["ed"] != "") {
				$ed_sql = "update dental_palpation set palpation = '".s_for($_POST["palpation"])."', sortby = '".s_for($sby)."', status = '".s_for($_POST["status"])."', description = '".s_for($_POST["description"])."' where palpationid='".$_POST["ed"]."'";
				$db->query($ed_sql);
				$msg = "Edited Successfully";
?>
				<script type="text/javascript">
					parent.window.location = 'custom_palpation.php?msg=<?php echo $msg;?>';
				</script>
<?php
				trigger_error("Die called", E_USER_ERROR);
			} else {
				$ins_sql = "insert into dental_palpation set palpation = '".s_for($_POST["palpation"])."', sortby = '".s_for($sby)."', status = '".s_for($_POST["status"])."', description = '".s_for($_POST["description"])."',adddate=now(),ip_address='".$_SERVER['REMOTE_ADDR']."'";
				$db->query($ins_sql);
				$msg = "Added Successfully";
?>
				<script type="text/javascript">
					parent.window.location = 'custom_palpation.php?msg=<?php echo $msg;?>';
				</script>
<?php
				trigger_error("Die called", E_USER_ERROR);
			}
		}
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<link href="admin/css/admin.css" rel="stylesheet" type="text/css" />
		<script language="javascript" type="text/javascript" src="admin/script/validation.js"></script>
	</head>

	<body>
	    <?php
		    $thesql = "select * from dental_palpation where palpationid='".(!empty($_REQUEST["ed"]) ? $_REQUEST["ed"] : '')."'";
			$themyarray = $db->getRow($thesql);
		
			if(!empty($msg)) {
				$palpation = $_POST['palpation'];
				$sortby = $_POST['sortby'];
				$status = $_POST['status'];
				$description = $_POST['description'];
			} else {
				$palpation = st($themyarray['palpation']);
				$sortby = st($themyarray['sortby']);
				$status = st($themyarray['status']);
				$description = st($themyarray['description']);
				$but_text = "Add ";
			}
	
			if($themyarray["palpationid"] != '') {
				$but_text = "Edit ";
			} else {
				$but_text = "Add ";
			}
		?>

		<br /><br />
	
		<?php if(!empty($msg)) { ?>
		    <div align="center" class="red">
		        <?php echo $msg; ?>
		    </div>
    	<?php } ?>

	    <form name="palpationfrm" action="<?php echo (!empty($_SERVER['admin/PHP_SELF']) ? $_SERVER['admin/PHP_SELF'] : '');?>?add=1" method="post" onSubmit="return palpationabc(this)">
		    <table width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center">
		        <tr>
		            <td colspan="2" class="cat_head">
		               <?php echo $but_text?> Palpation 
		               <?php if($palpation <> "") { ?>
		               		&quot;<?php echo $palpation;?>&quot;
		               <?php } ?>
		            </td>
		        </tr>
		        <tr bgcolor="#FFFFFF">
		            <td valign="top" class="frmhead" width="30%">
		                Palpation
		            </td>
		            <td valign="top" class="frmdata">
		                <input type="text" name="palpation" value="<?php echo $palpation?>" class="tbox" /> 
		                <span class="red">*</span>				
		            </td>
		        </tr>
		        <tr bgcolor="#FFFFFF">
		            <td valign="top" class="frmhead">
		                Sort By
		            </td>
		            <td valign="top" class="frmdata">
		                <input type="text" name="sortby" value="<?php echo $sortby;?>" class="tbox" style="width:30px"/>		
		            </td>
		        </tr>
		        <tr bgcolor="#FFFFFF">
		            <td valign="top" class="frmhead">
		                Status
		            </td>
		            <td valign="top" class="frmdata">
		            	<select name="status" class="tbox">
		                	<option value="1" <?php if($status == 1) echo " selected"; ?>>Active</option>
		                	<option value="2" <?php if($status == 2) echo " selected"; ?>>In-Active</option>
		                </select>
		            </td>
		        </tr>
		        <tr bgcolor="#FFFFFF">
		            <td valign="top" class="frmhead">
		                Description
		            </td>
		            <td valign="top" class="frmdata">
		            	<textarea class="tbox" name="description" style="width:100%;"><?php echo $description;?></textarea>
		            </td>
		        </tr>
		        <tr>
		            <td  colspan="2" align="center">
		                <span class="red">
		                    * Required Fields					
		                </span><br />
		                <input type="hidden" name="palpationsub" value="1" />
		                <input type="hidden" name="ed" value="<?php echo $themyarray["palpationid"]?>" />
		                <input type="submit" value=" <?php echo $but_text?> Palpation" class="button" />
		            </td>
		        </tr>
		    </table>
	    </form>
	</body>
</html>
