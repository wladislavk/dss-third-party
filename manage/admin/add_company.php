<?php 
session_start();
require_once('includes/config.php');
include("includes/sescheck.php");
include_once('includes/password.php');
require_once('../includes/constants.inc');
include_once '../includes/general_functions.php';
if($_POST["compsub"] == 1)
{
		if($_POST["ed"] != "")
		{
			$ed_sql = "update companies set 
				name = '".mysql_real_escape_string($_POST["name"])."',
                                add1 = '".mysql_real_escape_string($_POST["add1"])."', 
                                add2 = '".mysql_real_escape_string($_POST["add2"])."', 
                                city = '".mysql_real_escape_string($_POST["city"])."', 
                                state = '".mysql_real_escape_string($_POST["state"])."', 
                                zip = '".mysql_real_escape_string($_POST["zip"])."', 
				status = '".mysql_real_escape_string($_POST["status"])."'
			where id='".$_POST["ed"]."'";
			mysql_query($ed_sql) or die($ed_sql." | ".mysql_error());
			
			//echo $ed_sql.mysql_error();
			$msg = "Edited Successfully";
			?>
			<script type="text/javascript">
				//alert("<?=$msg;?>");
				parent.window.location='manage_companies.php?msg=<?=$msg;?>';
			</script>
			<?
			die();
		}
		else
		{


			$ins_sql = "insert into companies set 
				name = '".mysql_real_escape_string($_POST["name"])."', 
                                add1 = '".mysql_real_escape_string($_POST["add1"])."', 
                                add2 = '".mysql_real_escape_string($_POST["add2"])."', 
                                city = '".mysql_real_escape_string($_POST["city"])."', 
                                state = '".mysql_real_escape_string($_POST["state"])."', 
                                zip = '".mysql_real_escape_string($_POST["zip"])."', 
				status = '".mysql_real_escape_string($_POST['status'])."',
				adddate=now(),
				ip_address='".$_SERVER['REMOTE_ADDR']."'";
			mysql_query($ins_sql) or die($ins_sql.mysql_error());
                        $adminid = mysql_insert_id();			


			$msg = "Added Successfully";
			?>
			<script type="text/javascript">
				//alert("<?=$msg;?>");
				parent.window.location='manage_companies.php?msg=<?=$msg;?>';
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
</head>
<body>

    <?
    $thesql = "select * from companies where id='".$_REQUEST["ed"]."'";
	$themy = mysql_query($thesql);
	$themyarray = mysql_fetch_array($themy);
	
	if($msg != '')
	{
		$name = $_POST['name'];
		$add1 = $_POST['add1'];
		$add2 = $_POST['add2'];
		$city = $_POST['city'];
		$state = $_POST['state'];
		$zip = $_POST['zip'];   	
		$status = $_POST['status'];
	}
	else
	{
		$name = st($themyarray['name']);
		$add1 = st($themyarray['add1']);
                $add2 = st($themyarray['add2']);
                $city = st($themyarray['city']);
                $state = st($themyarray['state']);
                $zip = st($themyarray['zip']);
		$status = st($themyarray['status']);
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
               <?=$but_text?> Company 
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
                <span class="red">*</span>				
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                Address 1
            </td>
            <td valign="top" class="frmdata">
                <input id="add1" type="text" name="add1" value="<?=$add1;?>" class="tbox" />
                <span class="red">*</span>
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                Address 2
            </td>
            <td valign="top" class="frmdata">
                <input id="add2" type="text" name="add2" value="<?=$add2;?>" class="tbox" />
                <span class="red">*</span>
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                City
            </td>
            <td valign="top" class="frmdata">
                <input id="city" type="text" name="city" value="<?=$city;?>" class="tbox" />
                <span class="red">*</span>
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                State
            </td>
            <td valign="top" class="frmdata">
                <input id="state" type="text" name="state" value="<?=$state;?>" class="tbox" />
                <span class="red">*</span>
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                Postal Code
            </td>
            <td valign="top" class="frmdata">
                <input id="zip" type="text" name="zip" value="<?=$zip;?>" class="tbox" />
                <span class="red">*</span>
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                Status
            </td>
            <td valign="top" class="frmdata">
            	<select name="status" class="tbox">
                	<option value="1" <? if($status == 1) echo " selected";?>>Active</option>
                	<option value="2" <? if($status == 2) echo " selected";?>>In-Active</option>
                </select>
            </td>
        </tr>
        <tr>
            <td  colspan="2" align="center">
                <span class="red">
                    * Required Fields					
                </span><br />
                <input type="hidden" name="compsub" value="1" />
                <input type="hidden" name="ed" value="<?=$themyarray["id"]?>" />
                <input type="submit" value=" <?=$but_text?> Company" class="button" />
                <?php if($themyarray["id"] != '' && $_SESSION['admin_access']==1){ ?>
                    <a style="float:right;" href="javascript:parent.window.location='manage_companies.php?delid=<?=$themyarray["id"];?>'" onclick="javascript: return confirm('Do Your Really want to Delete?.');" class="dellink" title="DELETE">
                                                Delete
                                        </a>
		<?php } ?>
            </td>
        </tr>
    </table>
    </form>
</body>
</html>
