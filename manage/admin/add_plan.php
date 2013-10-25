<?php 
session_start();
require_once('includes/main_include.php');
include("includes/sescheck.php");

if($_POST["plansub"] == 1)
{
		if($_POST["ed"] != "")
		{
			$ed_sql = "update dental_plans set 
				name = '".mysql_real_escape_string($_POST['name'])."',
                                monthly_fee = '".mysql_real_escape_string($_POST['monthly_fee'])."',
                                trial_period = '".mysql_real_escape_string($_POST['trial_period'])."',
                                fax_fee = '".mysql_real_escape_string($_POST['fax_fee'])."',
                                free_fax = '".mysql_real_escape_string($_POST['free_fax'])."',
                                status = '".mysql_real_escape_string($_POST['status'])."'
				WHERE id = '".mysql_real_escape_string($_POST['ed'])."'";
			mysql_query($ed_sql) or die($ed_sql." | ".mysql_error());
			
			//echo $ed_sql.mysql_error();
			$msg = "Edited Successfully";
			?>
			<script type="text/javascript">
				//alert("<?=$msg;?>");
				parent.window.location='manage_plans.php?msg=<?=$msg;?>';
			</script>
			<?
			die();
		}
		else
		{
			$ins_sql = "insert into dental_plans SET
                                name = '".mysql_real_escape_string($_POST['name'])."',
                                monthly_fee = '".mysql_real_escape_string($_POST['monthly_fee'])."',
                                trial_period = '".mysql_real_escape_string($_POST['trial_period'])."',
                                fax_fee = '".mysql_real_escape_string($_POST['fax_fee'])."',
                                free_fax = '".mysql_real_escape_string($_POST['free_fax'])."',
                                status = '".mysql_real_escape_string($_POST['status'])."',
				adddate=now(),ip_address='".$_SERVER['REMOTE_ADDR']."'";
			mysql_query($ins_sql) or die($ins_sql.mysql_error());
			
			$msg = "Added Successfully";
			?>
			<script type="text/javascript">
				//alert("<?=$msg;?>");
				parent.window.location='manage_plans.php?msg=<?=$msg;?>';
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
    $thesql = "select * from dental_plans where id='".$_REQUEST["ed"]."'";
	$themy = mysql_query($thesql);
	$themyarray = mysql_fetch_array($themy);
	
	if($msg != '')
	{
		$name = $_POST['name'];
		$monthly_fee = $_POST['monthly_fee'];
		$trial_period = $_POST['trial_period'];
		$fax_fee = $_POST['fax_fee'];
		$free_fax = $_POST['free_fax'];
		$status = $_POST['status'];
	}
	else
	{
                $name = st($themyarray['name']);
                $monthly_fee = st($themyarray['monthly_fee']);
                $trial_period = st($themyarray['trial_period']);
                $fax_fee = st($themyarray['fax_fee']);
                $free_fax = st($themyarray['free_fax']);
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
    <form name="planfrm" action="<?=$_SERVER['PHP_SELF'];?>?add=1" method="post" onSubmit="return planabc(this)">
    <table width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center">
        <tr>
            <td colspan="2" class="cat_head">
               <?=$but_text?> Plan
               <? if($name <> "") {?>
               		&quot;<?=$name;?>&quot;
               <? }?>
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Name
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="name" value="<?=$name?>" class="tbox" /> 
                <span class="red">*</span>				
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Monthly Fee
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="monthly_fee" value="<?=$monthly_fee?>" class="tbox" />          
                <span class="red">*</span>
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Trial Period (days)
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="trial_period" value="<?=$trial_period?>" class="tbox" />          
                <span class="red">*</span>
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Fax Fee
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="fax_fee" value="<?=$fax_fee?>" class="tbox" />          
                <span class="red">*</span>
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Free Fax
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="free_fax" value="<?=$free_fax?>" class="tbox" />          
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
                <input type="hidden" name="plansub" value="1" />
                <input type="hidden" name="ed" value="<?=$themyarray["id"]?>" />
                <input type="submit" value=" <?=$but_text?> Plan" class="button" />
		<?php if($themyarray["id"] != '' && $_SESSION['admin_access']==1){ ?>
                    <a href="manage_plans.php?delid=<?=$themyarray["id"];?>" onclick="javascript: return confirm('Do Your Really want to Delete?.');" target="_parent" class="editdel dellink" title="DELETE">
                                                Delete
                                        </a>
		<?php } ?>
            </td>
        </tr>
    </table>
    </form>
    
</body>
</html>
