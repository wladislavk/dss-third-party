<?php namespace Ds3\Legacy; ?><?php 
	include_once('admin/includes/main_include.php');
	include("includes/sescheck.php");
	include_once('admin/includes/password.php');

	$sql = "SELECT manage_staff FROM dental_users WHERE userid='".mysqli_real_escape_string($con,$_SESSION['userid'])."'";
	
	$r = $db->getRow($sql);
	if($_SESSION['docid']!=$_SESSION['userid'] && $r['manage_staff'] != 1) {
?>
		<br />You do not have permissions to edit appointment types.
<?php
	  	die();
	}
?>
	<script type="text/javascript" src="/manage/admin/script/jquery-1.6.2.min.js"></script>
	<script type="text/javascript" src="/manage/admin/script/jquery-ui-1.8.22.custom.min.js"></script>
	<script type="text/javascript" src="/manage/includes/modal.js"></script>
	<script type="text/javascript" src="/manage/3rdParty/jscolor/jscolor.js"></script>
	<link rel="stylesheet" href="/manage/admin/css/jquery-ui-1.8.22.custom.css" />
	<link rel="stylesheet" href="css/modal.css" />
<?php
	if(!empty($_POST["staffsub"]) && $_POST["staffsub"] == 1) {
		$classname = strtolower(str_replace('.','',str_replace('/','',str_replace(' ', '_', $_POST['name']))));
		$sel_check = "select * from dental_appt_types where docid='".mysqli_real_escape_string($con,$_SESSION['docid'])."' AND (name = '".s_for($_POST["name"]) . "' or classname='" . $classname . "') and id <> '" . $_POST['ed']."'";
		
		if($db->getNumberRows($sel_check)>0)
		{
			$msg = "Appointment Type name already exists. Please give another name.";
?>
			<script type="text/javascript">
				alert("<?php echo $msg;?>");
				window.location="#add";
			</script>
<?php
		} else {
			if($_POST["ed"] != "") {
	            $old_sql = "SELECT name, classname FROM dental_appt_types WHERE docid='".mysqli_real_escape_string($con,$_SESSION['docid'])."' AND id='".mysqli_real_escape_string($con,$_POST["ed"])."'";
	            
	            $old_r = $db->getRow($old_sql);
	            $old_name = $old_r['name'];
				$old_class = $old_r['classname'];

				$ed_sql = "update dental_appt_types set name = '".s_for($_POST["name"])."', ";
				$ed_sql .= "color='" . $_POST['color'] . "', ";
				$ed_sql .= "classname='" . $classname . "' ";
				$ed_sql .= " where id='".$_POST["ed"]."'";

				$db->query($ed_sql);

				$update_sql = "update dental_calendar SET category='".mysqli_real_escape_string($con,$classname)."' WHERE category='".mysqli_real_escape_string($con,$old_class)."' and docid='".mysqli_real_escape_string($con,$_SESSION['docid'])."'";
				$db->query($update_sql);
				$msg = "Edited Successfully" . $_POST['name'];
?>
				<script type="text/javascript">
					parent.window.location = 'manage_appts.php?msg=<?php echo $msg;?>';
				</script>
<?php
				die();
			} else {
				$ins_sql = "insert into dental_appt_types (name, color, classname, docid) values ('".s_for($_POST["name"])."', '" . $_POST['color'] . "', '" . $classname . "', '".mysqli_real_escape_string($con,$_SESSION['docid'])."')";
	            $userid = $db->getInsertId($ins_sql);
				$msg = "Added Successfully";
?>
				<script type="text/javascript">
					parent.window.location = 'manage_appts.php?msg=<?php echo $msg;?>';
				</script>
<?php
				die();
			}
		}
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<link href="css/admin.css" rel="stylesheet" type="text/css" />
		<script language="javascript" type="text/javascript" src="script/validation.js"></script>
	</head>

	<body>
	    <?php
		    $thesql = "select * from dental_appt_types where id='".(!empty($_REQUEST["ed"]) ? $_REQUEST["ed"] : '')."'";
			
			$themyarray = $db->getRow($thesql);
			
			if(!empty($msg)) {
				$name = $_POST['name'];
				$color = $_POST['color'];
			} else {
				$name = st($themyarray['name']);
				$color = st($themyarray['color']);
			}
			
			if($themyarray["id"] != '') {
				$but_text = "Edit ";
			} else {
				$but_text = "Add ";
			}
		?>
			<br /><br />
	
		<?php if(!empty($msg)) { ?>
		    <div align="center" class="red">
		        <?php echo $msg;?>
		    </div>
    	<?php } ?>
		    <form name="stafffrm" action="<?php echo $_SERVER['PHP_SELF'];?>?add=1" method="post" onSubmit="return staffabc(this)">
			    <table width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center">
			        <tr>
			            <td colspan="2" class="cat_head">
			               <?php echo $but_text?> Appointment Type
			               <?php if($name <> "") {?>
			               		&quot;<?php echo $name;?>&quot;
			               <?php }?>
			            </td>
			        </tr>
			        <tr bgcolor="#FFFFFF">
			            <td valign="top" class="frmhead" width="30%">
			                Appointment Type Name
			            </td>
			            <td valign="top" class="frmdata">
			                <input type="text" name="name" value="<?php echo $name?>" class="tbox" /> 
			                <span class="red">*</span>				
			            </td>
			        </tr>
			        <tr bgcolor="#FFFFFF">
			            <td valign="top" class="frmhead" width="30%">
			                Appointment Type Color
			            </td>
			            <td valign="top" class="frmdata">
			                <input type="text" name="color" value="<?php echo $color?>" class="color tbox" /> 
			                <span class="red">*</span>
			            </td>
			        </tr>
			        <tr>
			            <td  colspan="2" align="center">
			                <span class="red">
			                    * Required Fields					
			                </span><br />
			                <input type="hidden" name="staffsub" value="1" />
			                <input type="hidden" name="ed" value="<?php echo $themyarray["id"]?>" />
			                <input type="submit" value=" <?php echo $but_text?> Appointment Type" class="button" />
							<?php if($themyarray["id"] != '') { ?>
								<?php
								  $l_sql = "SELECT * from dental_login WHERE userid='".mysqli_real_escape_string($con,$themyarray['id'])."'";
								  
								  $logins = $db->getNumberRows($l_sql);
								?>
                    			<a style="float:right;" href="manage_appts.php?delid=<?php echo $themyarray["id"];?>" onclick="javascript: return confirm_delete(<?php echo  $logins; ?>);" class="dellink" title="DELETE" target="_parent">
                                    Delete 
                                </a>
							<?php } ?>
            			</td>
        			</tr>
    			</table>
    		</form>

			<script type="text/javascript" src="js/add_appt.js"></script>
	</body>
</html>
