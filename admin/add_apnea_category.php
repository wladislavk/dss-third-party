<?php 
session_start();
require_once('includes/config.php');
include("includes/sescheck.php");

if($_POST["categorysub"] == 1)
{
	$sel_check = "select * from apnea_category where category = '".s_for($_POST["category"])."' and categoryid <> '".s_for($_POST['ed'])."'";
	$query_check=mysql_query($sel_check);
	
	if(mysql_num_rows($query_check)>0)
	{
		$msg="Apnea Category already exist. So please give another Apnea Category.";
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
			$ed_sql = "update apnea_category set category = '".s_for($_POST["category"])."', sortby = '".s_for($sby)."', status = '".s_for($_POST["status"])."' where categoryid='".$_POST["ed"]."'";
			mysql_query($ed_sql) or die($ed_sql." | ".mysql_error());
			
			//echo $ed_sql.mysql_error();
			$msg = "Edited Successfully";
			?>
			<script type="text/javascript">
				//alert("<?=$msg;?>");
				parent.window.location='manage_apnea_category.php?msg=<?=$msg;?>';
			</script>
			<?
			die();
		}
		else
		{
			$ins_sql = "insert into apnea_category set category = '".s_for($_POST["category"])."', sortby = '".s_for($sby)."', status = '".s_for($_POST["status"])."',adddate=now(),ip_address='".$_SERVER['REMOTE_ADDR']."'";
			mysql_query($ins_sql) or die($ins_sql.mysql_error());
			
			$msg = "Added Successfully";
			?>
			<script type="text/javascript">
				//alert("<?=$msg;?>");
				parent.window.location='manage_apnea_category.php?msg=<?=$msg;?>';
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

    <br />
    <?
    $thesql = "select * from apnea_category where categoryid='".$_REQUEST["ed"]."'";
	$themy = mysql_query($thesql);
	$themyarray = mysql_fetch_array($themy);
	
	if($msg != '')
	{
		$category = $_POST['category'];
		$sortby = $_POST['sortby'];
		$status = $_POST['status'];
	}
	else
	{
		$category = st($themyarray['category']);
		$sortby = st($themyarray['sortby']);
		$status = st($themyarray['status']);
		$but_text = "Add ";
	}
	
	if($themyarray["categoryid"] != '')
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
    <form name="categoryfrm" action="<?=$_SERVER['PHP_SELF'];?>?add=1" method="post" onSubmit="return categoryabc(this)">
    <table width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center">
        <tr>
            <td colspan="2" class="cat_head">
               <?=$but_text?> Apnea Category 
               <? if($category <> "") {?>
               		&quot;<?=$category;?>&quot;
               <? }?>
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Apnea Category
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="category" value="<?=$category?>" class="tbox" /> 
                <span class="red">*</span>				
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                Sort By
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="sortby" value="<?=$sortby;?>" class="tbox" style="width:30px"/>		
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
                <input type="hidden" name="categorysub" value="1" />
                <input type="hidden" name="ed" value="<?=$themyarray["categoryid"]?>" />
                <input type="submit" value=" <?=$but_text?> Apnea Category" class="button" />
            </td>
        </tr>
    </table>
    </form>
</body>
</html>