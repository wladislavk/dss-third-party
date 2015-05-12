<?php namespace Ds3\Libraries\Legacy; ?><?php 
session_start();
require_once('includes/config.php');
include("includes/sescheck.php");
include "fckeditor/fckeditor.php";

if($_POST["sleep_apneaub"] == 1)
{
	$sel_check = "select * from sleep_apnea where title = '".s_for($_POST["title"])."' and sleep_apneaid <> '".s_for($_POST['ed'])."'";
	$query_check=mysqli_query($con, $sel_check);
	
	if(mysqli_num_rows($query_check)>0)
	{
		$msg="Title already exist. So please give another Title.";
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
			$ed_sql = "update sleep_apnea set title = '".s_for($_POST["title"])."', categoryid = '".s_for($_POST["categoryid"])."', description = '".s_for($_POST["description"])."', status = '".s_for($_POST["status"])."', sortby = '".$sby."' where sleep_apneaid='".$_POST["ed"]."'";
			mysqli_query($con, $ed_sql);
			
			//echo $ed_sql.mysqli_error($con);
			$msg = "Edited Successfully";
			?>
			<script type="text/javascript">
				//alert("<?=$msg;?>");
				parent.window.location='manage_sleep_apnea.php?msg=<?=$msg;?>&cid=<?=$_POST["categoryid"]?>';
			</script>
			<?
			trigger_error("Die called", E_USER_ERROR);
		}
		else
		{
			$ins_sql = "insert into sleep_apnea set title = '".s_for($_POST["title"])."', categoryid = '".s_for($_POST["categoryid"])."', description = '".s_for($_POST["description"])."', status = '".s_for($_POST["status"])."', sortby = '".$sby."', adddate=now(),ip_address='".$_SERVER['REMOTE_ADDR']."'";
			mysqli_query($con, $ins_sql) or trigger_error($ins_sql.mysqli_error($con), E_USER_ERROR);
			
			$msg = "Added Successfully";
			?>
			<script type="text/javascript">
				//alert("<?=$msg;?>");
				parent.window.location='manage_sleep_apnea.php?msg=<?=$msg;?>&cid=<?=$_POST["categoryid"]?>';
			</script>
			<?
			trigger_error("Die called", E_USER_ERROR);
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
    $thesql = "select * from sleep_apnea where sleep_apneaid='".$_REQUEST["ed"]."'";
	$themy = mysqli_query($con, $thesql);
	$themyarray = mysqli_fetch_array($themy);
	
	if($msg != '')
	{
		$title = $_POST['title'];
		$description = $_POST['description'];
		$sortby = $_POST['sortby'];
		$status = $_POST['status'];
		$categoryid = $_POST['categoryid'];
	}
	else
	{
		$title = st($themyarray['title']);
		$description = st($themyarray['description']);
		$status = st($themyarray['status']);
		$sortby = st($themyarray['sortby']);
		$categoryid = st($themyarray['categoryid']);
		$but_text = "Add ";
	}
	
	if($_GET['cid'] <> '' && $categoryid == '')
	{
		$categoryid = $_GET['cid'];
	}
	
	if($themyarray["sleep_apneaid"] != '')
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
    <form name="sleep_apneafrm" action="<?=$_SERVER['PHP_SELF'];?>?add=1" method="post" onSubmit="return sleep_apneaabc(this)">
    <table width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center">
        <tr>
            <td colspan="2" class="cat_head">
               <?=$but_text?> Sleep Apnea
               <? if($title <> "") {?>
               		&quot;<?=$title;?>&quot;
               <? }?>
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                Apnea Category
            </td>
            <td valign="top" class="frmdata">
				<select name="categoryid" style="width:350px;" >
					<option value="">Select</option>
					<? 
					$cat_sql = "select * from apnea_category where status=1 order by sortby";
					$cat_my = mysqli_query($con, $cat_sql);
					while($cat_myarray = mysqli_fetch_array($cat_my))
					{
					?>
						<option value="<?=st($cat_myarray['categoryid'])?>" <? if($categoryid == st($cat_myarray['categoryid'])) echo " selected";?>>
							<?=st($cat_myarray['category'])?>
						</option>
					<?
					}?>
				</select>
                <span class="red">*</span>				
            </td>
        </tr>
		 <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Title
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="title" value="<?=$title?>" class="tbox" style="width:350px;" /> 
                <span class="red">*</span>				
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" colspan="2">
                Description
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmdata" colspan="2">
                <?php
                    
                    $oFCKeditor = new \FCKeditor('description') ;
                    
                    $oFCKeditor->ToolbarSet = 'MyToolbar';
                    $oFCKeditor->BasePath = 'fckeditor/';
                    $oFCKeditor->Height = '300';
                    
                    $oFCKeditor->Value = html_entity_decode($description);
                    
                    $oFCKeditor->Create() ;
                ?>	
                
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
                <input type="hidden" name="sleep_apneaub" value="1" />
                <input type="hidden" name="ed" value="<?=$themyarray["sleep_apneaid"]?>" />
                <input type="submit" value=" <?=$but_text?> Sleep Apnea " class="button" />
            </td>
        </tr>
    </table>
    </form>
</body>
</html>
