<?php namespace Ds3\Libraries\Legacy; ?><?php 
session_start();
require_once('includes/config.php');
include("includes/sescheck.php");
include "fckeditor/fckeditor.php";

if($_POST["p_pagesub"] == 1)
{
	$sel_check = "select * from p_pages where title = '".s_for($_POST["title"])."' and p_pageid <> '".s_for($_POST['ed'])."'";
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
		if($_POST["ed"] != "")
		{
			$ed_sql = "update p_pages set title = '".s_for($_POST["title"])."', description = '".s_for($_POST["description"])."', status = '".s_for($_POST["status"])."' where p_pageid='".$_POST["ed"]."'";
			mysqli_query($con, $ed_sql);
			
			//echo $ed_sql.mysqli_error($con);
			$msg = "Edited Successfully";
			?>
			<script type="text/javascript">
				//alert("<?=$msg;?>");
				parent.window.location='manage_p_pages.php?msg=<?=$msg;?>';
			</script>
			<?
			trigger_error("Die called", E_USER_ERROR);
		}
		else
		{
			$ins_sql = "insert into p_pages set title = '".s_for($_POST["title"])."', description = '".s_for($_POST["description"])."', status = '".s_for($_POST["status"])."', adddate=now(),ip_address='".$_SERVER['REMOTE_ADDR']."'";
			mysqli_query($con, $ins_sql) or trigger_error($ins_sql.mysqli_error($con), E_USER_ERROR);
			
			$msg = "Added Successfully";
			?>
			<script type="text/javascript">
				//alert("<?=$msg;?>");
				parent.window.location='manage_p_pages.php?msg=<?=$msg;?>';
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
    $thesql = "select * from p_pages where p_pageid='".$_REQUEST["ed"]."'";
	$themy = mysqli_query($con, $thesql);
	$themyarray = mysqli_fetch_array($themy);
	
	if($msg != '')
	{
		$title = $_POST['title'];
		$description = $_POST['description'];
		$keywords = $_POST['keywords'];
		$top_image = $_POST['top_image'];
		$status = $_POST['status'];
	}
	else
	{
		$title = st($themyarray['title']);
		$description = st($themyarray['description']);
		$keywords = $themyarray['keywords'];
		$status = st($themyarray['status']);
		$top_image = st($themyarray['top_image']);
		$but_text = "Add ";
	}
	
	if($themyarray["p_pageid"] != '')
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
    <form name="p_pagefrm" action="<?=$_SERVER['PHP_SELF'];?>?add=1" method="post" onSubmit="return p_pageabc(this)">
    <table width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center">
        <tr>
            <td colspan="2" class="cat_head">
               <?=$but_text?> Popup Page
               <? if($title <> "") {?>
               		&quot;<?=$title;?>&quot;
               <? }?>
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Title
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="title" value="<?=$title?>" class="tbox" /> 
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
                    
                    $oFCKeditor = new FCKeditor('description') ;
                    
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
                <input type="hidden" name="p_pagesub" value="1" />
                <input type="hidden" name="ed" value="<?=$themyarray["p_pageid"]?>" />
                <input type="submit" value=" <?=$but_text?> Popup Page " class="button" />
            </td>
        </tr>
    </table>
    </form>
</body>
</html>
