<?php 
session_start();
require_once('admin/includes/config.php');
include("includes/sescheck.php");
include_once('admin/includes/password.php');
include('includes/general_functions.php');

$sql = "SELECT manage_staff FROM dental_users WHERE userid='".mysql_real_escape_string($_SESSION['userid'])."'";
$q = mysql_query($sql);
$r = mysql_fetch_assoc($q);
if($_SESSION['docid']!=$_SESSION['userid'] && $r['manage_staff'] != 1){
  ?><br />You do not have permissions to edit appointment types.<?php
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
if($_POST["staffsub"] == 1)
{
	$classname = strtolower(str_replace(' ', '_', $_POST['name']));
	$sel_check = "select * from dental_appt_types where docid='".mysql_real_escape_string($_SESSION['docid'])."' AND (name = '".s_for($_POST["name"]) . "' or classname='" . $classname . "') and id <> '" . $_POST['ed']."'";
	$query_check=mysql_query($sel_check);
	
	if(mysql_num_rows($query_check)>0)
	{
		$msg="Appointment Type name already exists. Please give another name.";
		?>
		<script type="text/javascript">
			alert("<?=$msg;?>");
			window.location="#add";
		</script>
		<?
	} 
	else
	{
		if($_POST["ed"] != "")
		{
                        $old_sql = "SELECT name FROM dental_appt_types WHERE docid='".mysql_real_escape_string($_SESSION['docid'])."' AND id='".mysql_real_escape_string($_POST["ed"])."'";
                        $old_q = mysql_query($old_sql);
                        $old_r = mysql_fetch_assoc($old_q);
                        $old_username = $old_r['name'];

			$ed_sql = "update dental_appt_types set name = '".s_for($_POST["name"])."', ";
				$ed_sql .= "color='" . $_POST['color'] . "', ";
				$ed_sql .= "classname='" . $classname . "' ";
				$ed_sql .= " where id='".$_POST["ed"]."'";
			mysql_query($ed_sql) or die($ed_sql." | ".mysql_error());
			//echo $ed_sql.mysql_error();
			$msg = "Edited Successfully" . $_POST['name'];
			?>
			<script type="text/javascript">
				//alert("<?=$msg;?>");
				parent.window.location='manage_appts.php?msg=<?=$msg;?>';
			</script>
			<?
			die();
		}
		else
		{
			$ins_sql = "insert into dental_appt_types (name, color, classname, docid) values ('".s_for($_POST["name"])."', '" . $_POST['color'] . "', '" . $classname . "', '".mysql_real_escape_string($_SESSION['docid'])."')";
			mysql_query($ins_sql) or die($ins_sql.mysql_error());
	
                        $userid = mysql_insert_id();

			$msg = "Added Successfully";
			?>
			<script type="text/javascript">
				//alert("<?=$msg;?>");
				parent.window.location='manage_appts.php?msg=<?=$msg;?>';
			</script>
			<?
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

    <?
    $thesql = "select * from dental_appt_types where id='".$_REQUEST["ed"]."'";
	$themy = mysql_query($thesql);
	$themyarray = mysql_fetch_array($themy);
	
	if($msg != '')
	{
		$name = $_POST['name'];
		$color = $_POST['color'];
	}
	else
	{
		$name = st($themyarray['name']);
		$color = st($themyarray['color']);
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
    <form name="stafffrm" action="<?=$_SERVER['PHP_SELF'];?>?add=1" method="post" onSubmit="return staffabc(this)">
    <table width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center">
        <tr>
            <td colspan="2" class="cat_head">
               <?=$but_text?> Appointment Type
               <? if($name <> "") {?>
               		&quot;<?=$name;?>&quot;
               <? }?>
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Appointment Type Name
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="name" value="<?=$name?>" class="tbox" /> 
                <span class="red">*</span>				
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Appointment Type Color
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="color" value="<?=$color?>" class="color tbox" /> 
                <span class="red">*</span>
            </td>
        </tr>
        <tr>
            <td  colspan="2" align="center">
                <span class="red">
                    * Required Fields					
                </span><br />
                <input type="hidden" name="staffsub" value="1" />
                <input type="hidden" name="ed" value="<?=$themyarray["id"]?>" />
                <input type="submit" value=" <?=$but_text?> Appointment Type" class="button" />
		<?php if($themyarray["id"] != ''){ ?>
<?php
  $l_sql = "SELECT * from dental_login WHERE userid='".mysql_real_escape_string($themyarray['id'])."'";
  $l_q = mysql_query($l_sql);
  $logins = mysql_num_rows($l_q);
?>
                    <a style="float:right;" href="manage_appts.php?delid=<?=$themyarray["id"];?>" onclick="javascript: return confirm_delete(<?= $logins; ?>);" class="dellink" title="DELETE" target="_parent">
                                                 Delete 
                                        </a>
		<?php } ?>
            </td>
        </tr>
    </table>
    </form>

<script type="text/javascript">

  function confirm_delete(logins){
    d = confirm('Are you sure you want to delete?');
    if(!d){
      return false;
    }
    if(logins > 0){
      alert('This user has previously accessed your software. In order to store a record of their activity this user will be marked as INACTIVE. INACTIVE users cannot access your software.');
    }
    return d;

  }
</script>
</body>
</html>
