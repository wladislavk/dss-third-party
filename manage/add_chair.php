<?php
	include_once('admin/includes/main_include.php');
	include("includes/sescheck.php");
	include_once('admin/includes/password.php');

	$sql = "SELECT manage_staff FROM dental_users WHERE userid='".mysql_real_escape_string($_SESSION['userid'])."'";
	
	$r = $db->getRow($sql);
	if($_SESSION['docid']!=$_SESSION['userid'] && $r['manage_staff'] != 1) {
?>
		<br />You do not have permissions to edit resources.
<?php
	  	die();
	}
?>
	<script type="text/javascript" src="/manage/admin/script/jquery-1.6.2.min.js"></script>
	<script type="text/javascript" src="/manage/admin/script/jquery-ui-1.8.22.custom.min.js"></script>
	<script type="text/javascript" src="/manage/includes/modal.js"></script>
	<link rel="stylesheet" href="/manage/admin/css/jquery-ui-1.8.22.custom.css" />
	<link rel="stylesheet" href="css/modal.css" />
<?php
	if($_POST["staffsub"] == 1) {
		$sel_check = "select * from dental_resources where docid='".$_SESSION['docid']."' AND name = '".s_for($_POST["name"]) . "' and id <> " . $_POST['ed'];
		
		if($db->getNumberRows($sel_check)>0) {
			$msg = "Resource name already exists. Please give another name.";
?>
			<script type="text/javascript">
				alert("<?php echo $msg;?>");
				window.location = "#add";
			</script>
<?php
		} else if(!is_numeric( $_POST['rank'] ) || !is_int( 0+$_POST['rank'] ) ) {
			$msg = "Rank must be an integer. Please give another rank.";
?>
			<script type="text/javascript">
				alert("<?php echo $msg;?>");
				window.location="#add";
			</script>
<?php
		} else {
			if($_POST["ed"] != "") {
	            $old_sql = "SELECT name FROM dental_resources WHERE docid='".$_SESSION['docid']."' AND id='".mysql_real_escape_string($_POST["ed"])."'";
	            
	            $old_r = $db->getRow($old_sql);
	            $old_username = $old_r['name'];
				$ed_sql = "update dental_resources set name = '".s_for($_POST["name"])."', ";
				$ed_sql .= "rank=" . $_POST['rank'] . " ";
				$ed_sql .= " where id='".$_POST["ed"]."'";

				$db->query($ed_sql);
				$msg = "Edited Successfully" . $_POST['name'];
?>
				<script type="text/javascript">
					parent.window.location='manage_chairs.php?msg=<?php echo $msg;?>';
				</script>
<?php
				die();
			} else {
				$ins_sql = "insert into dental_resources (name, rank, docid) values ('".s_for($_POST["name"])."', " . $_POST['rank'] . ", " . $_SESSION['docid'] .")";
	            $userid = $db->getInsertId($ins_sql);
				$msg = "Added Successfully";
?>
				<script type="text/javascript">
					parent.window.location='manage_chairs.php?msg=<?php echo $msg;?>';
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
	    $thesql = "select * from dental_resources where docid=".mysql_real_escape_string($_SESSION['docid'])." AND id='".$_REQUEST["ed"]."'";
		
		$themyarray = $db->getRow($thesql);
		
		if($msg != '') {
			$name = $_POST['name'];
			$rank = $_POST['rank'];
		} else {
			$name = st($themyarray['name']);
			$rank = st($themyarray['rank']);
		}
		
		if($themyarray["id"] != '') {
			$but_text = "Edit ";
		} else {
			$but_text = "Add ";
		}
	?>
	
		<br /><br />
	
	<?php if($msg != ''){ ?>
	    <div align="center" class="red">
	        <?php echo $msg;?>
	    </div>
    <?php }?>
	    <form name="stafffrm" action="<?php echo $_SERVER['PHP_SELF'];?>?add=1" method="post" onSubmit="return staffabc(this)">
		    <table width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center">
		        <tr>
		            <td colspan="2" class="cat_head">
		               <?php echo $but_text?> Resource 
		               <?php if($name <> "") {?>
		               		&quot;<?php echo $name;?>&quot;
		               <?php }?>
		            </td>
		        </tr>
		        <tr bgcolor="#FFFFFF">
		            <td valign="top" class="frmhead" width="30%">
		                Resource Name
		            </td>
		            <td valign="top" class="frmdata">
		                <input type="text" name="name" value="<?php echo $name?>" class="tbox" /> 
		                <span class="red">*</span>				
		            </td>
		        </tr>
		        <tr bgcolor="#FFFFFF">
		            <td valign="top" class="frmhead" width="30%">
		                Resource Rank
		            </td>
		            <td valign="top" class="frmdata">
		                <input type="text" name="rank" value="<?php echo $rank?>" class="tbox" /> 
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
		                <input type="submit" value=" <?php echo $but_text?> Resource" class="button" />
						<?php if($themyarray["id"] != '') { ?>
							<?php
							  $l_sql = "SELECT * from dental_login WHERE userid='".mysql_real_escape_string($themyarray['id'])."'";
							  
							  $logins = $db->getNumberRows($l_sql);
							?>
	                    	<a style="float:right;" href="manage_chairs.php?delid=<?php echo $themyarray["id"];?>" onclick="javascript: return confirm_delete(<?php echo  $logins; ?>);" class="dellink" title="DELETE" target="_parent">
	                            Delete 
	                        </a>
						<?php } ?>
            		</td>
        		</tr>
    		</table>
    	</form>

		<script type="text/javascript" src="js/add_chair.js"></script>
	</body>
</html>
