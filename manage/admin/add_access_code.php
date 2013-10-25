<?php 
session_start();
require_once('includes/main_include.php');
include("includes/sescheck.php");


if($_POST["accesscodesub"] == 1)
{
	$sel_check = "select * from dental_access_codes where access_code = '".s_for($_POST["access_code"])."' and id <> '".s_for($_POST['ed'])."'";
	$query_check=mysql_query($sel_check);
	
	if(mysql_num_rows($query_check)>0)
	{
		$msg="Access code already exist. So please give another access code.";
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
			$ed_sql = "update dental_access_codes set 
				access_code = '".mysql_real_escape_string($_POST['access_code'])."',
				notes = '".mysql_real_escape_string($_POST['notes'])."',
				status = '".mysql_real_escape_string($_POST['status'])."',
				plan_id = '".mysql_real_escape_string($_POST['plan_id'])."'
				where id='".$_POST["ed"]."'";
			mysql_query($ed_sql) or die($ed_sql." | ".mysql_error());
			
			//echo $ed_sql.mysql_error();
			$msg = "Edited Successfully";
			?>
			<script type="text/javascript">
				//alert("<?=$msg;?>");
				parent.window.location='manage_access_codes.php?msg=<?=$msg;?>';
			</script>
			<?
			die();
		}
		else
		{
                        $ins_sql = "INSERT INTO dental_access_codes set 
                                access_code = '".mysql_real_escape_string($_POST['access_code'])."',
                                notes = '".mysql_real_escape_string($_POST['notes'])."',
				plan_id = '".mysql_real_escape_string($_POST['plan_id'])."',
                                status = '".mysql_real_escape_string($_POST['status'])."'";

			mysql_query($ins_sql) or die($ins_sql.mysql_error());
			
			$msg = "Added Successfully";
			?>
			<script type="text/javascript">
				//alert("<?=$msg;?>");
				parent.window.location='manage_access_codes.php?msg=<?=$msg;?>';
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
    $thesql = "select * from dental_access_codes where id='".$_REQUEST["ed"]."'";
	$themy = mysql_query($thesql);
	$themyarray = mysql_fetch_array($themy);
	
	if($msg != '')
	{
		$access_code = $_POST['access_code'];
		$notes = $_POST['notes'];
		$plan_id = $_POST['plan_id'];
		$status = $_POST['status'];
	}
	else
	{
		$access_code = $themyarray['access_code'];
		$notes = $themyarray['notes'];
		$plan_id = $themyarray['plan_id'];
		$status = $themyarray['status'];
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
    <form name="contacttypefrm" action="<?=$_SERVER['PHP_SELF'];?>?add=1" method="post" onSubmit="return accesscodeabc(this)">
    <table width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center">
        <tr>
            <td colspan="2" class="cat_head">
               <?=$but_text?> Access Code
               <? if($access_code <> "") {?>
               		&quot;<?=$access_code;?>&quot;
               <? }?>
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Access Code
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="access_code" value="<?=$access_code;?>" class="tbox" /> 
                <span class="red">*</span>				
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                Notes
            </td>
            <td valign="top" class="frmdata">
		<textarea name="notes"><?= $notes; ?></textarea>
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                 Plan
            </td>
            <td valign="top" class="frmdata">
                <select name="plan_id" class="tbox">
                        <?php
                          $p_sql = "SELECT * FROM dental_plans ORDER BY name ASC";
                          $p_q = mysql_query($p_sql);
                          while($p_r = mysql_fetch_assoc($p_q)){ ?>
                            <option value="<?= $p_r['id']; ?>" <?= ($p_r['id'] == $plan_id)?'selected="selected"':''; ?>><?= $p_r['name']; ?></option>
                          <?php } ?>
                </select>
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
               Status
            </td>
            <td valign="top" class="frmdata">
		<select name="status">
			<option value="1" <?= ($status==1)?'selected="selected"':''; ?>>Active</option>
                        <option value="2" <?= ($status==2)?'selected="selected"':''; ?>>In-Active</option>
            </td>
        </tr>

        <tr>
            <td  colspan="2" align="center">
                <span class="red">
                    * Required Fields					
                </span><br />
                <input type="hidden" name="accesscodesub" value="1" />
                <input type="hidden" name="ed" value="<?=$themyarray["id"]?>" />
                <input type="submit" value=" <?=$but_text?> Access Code" class="button" />
            </td>
        </tr>
    </table>
    </form>
    
</body>
</html>
