<?php namespace Ds3\Libraries\Legacy; ?><?php 
session_start();
require_once('includes/config.php');
include("includes/sescheck.php");
include "fckeditor/fckeditor.php";

if($_POST["pagesub"] == 1)
{
	$sel_check = "select * from pages where title = '".s_for($_POST["title"])."' and pageid <> '".s_for($_POST['ed'])."'";
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
		if($_FILES["top_image"]["name"] <> '')
		{
			$fname = $_FILES["top_image"]["name"];
			$lastdot = strrpos($fname,".");
			$name = substr($fname,0,$lastdot);
			$extension = substr($fname,$lastdot+1);
			$banner1 = $name.'_'.date('dmy_Hi');
			$banner1 = str_replace(" ","_",$banner1);
			$banner1 = str_replace(".","_",$banner1);
			$banner1 .= ".".$extension;
			
			@move_uploaded_file($_FILES["top_image"]["tmp_name"],"../top_file/".$banner1);
			@chmod("../top_file/".$banner1,0777);
			
			if($_POST['top_image_old'] <> '')
			{
				@unlink("../top_file/".$_POST['top_image_old']);
			}
		}
		else
		{
			$banner1 = $_POST['top_image_old'];
		}
	
		if($_POST["ed"] != "")
		{
			$ed_sql = "update pages set title = '".s_for($_POST["title"])."', keywords = '".s_for($_POST["keywords"])."', description = '".s_for($_POST["description"])."', status = '".s_for($_POST["status"])."', top_image = '".s_for($banner1)."' where pageid='".$_POST["ed"]."'";
			mysqli_query($con, $ed_sql);
			
			//echo $ed_sql.mysqli_error($con);
			$msg = "Edited Successfully";
			?>
			<script type="text/javascript">
				//alert("<?=$msg;?>");
				parent.window.location='manage_pages.php?msg=<?=$msg;?>';
			</script>
			<?
			trigger_error("Die called", E_USER_ERROR);
		}
		else
		{
			$ins_sql = "insert into pages set title = '".s_for($_POST["title"])."', keywords = '".s_for($_POST["keywords"])."', description = '".s_for($_POST["description"])."', status = '".s_for($_POST["status"])."', top_image = '".s_for($banner1)."', adddate=now(),ip_address='".$_SERVER['REMOTE_ADDR']."'";
			mysqli_query($con, $ins_sql) or trigger_error($ins_sql.mysqli_error($con), E_USER_ERROR);
			
			$msg = "Added Successfully";
			?>
			<script type="text/javascript">
				//alert("<?=$msg;?>");
				parent.window.location='manage_pages.php?msg=<?=$msg;?>';
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
    $thesql = "select * from pages where pageid='".$_REQUEST["ed"]."'";
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
	
	if($themyarray["pageid"] != '')
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
    <form name="pagefrm" action="<?=$_SERVER['PHP_SELF'];?>?add=1" method="post" onSubmit="return pageabc(this)" enctype="multipart/form-data">
    <table width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center">
        <tr>
            <td colspan="2" class="cat_head">
               <?=$but_text?> Page
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
        <!--<tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                Keywords
            </td>
            <td valign="top" class="frmdata">
                <textarea name="keywords" rows="2" cols="29"><?=$keywords?></textarea>
            </td>
        </tr> -->
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
                Top Image
            </td>
            <td valign="top" class="frmdata">
				<? if($top_image <> '') {?>
					<a href="../top_file/<?=$top_image?>" target="_blank">
						<b>Preview</b></a>
					&nbsp;&nbsp;&nbsp;&nbsp;
				<? }?>
				<input type="file" name="top_image" value="" size="26" />
				<input type="hidden" name="top_image_old" value="<?=$top_image;?>" />
				<br />
				(Best Size: 618px � 268px)
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
                <input type="hidden" name="pagesub" value="1" />
                <input type="hidden" name="ed" value="<?=$themyarray["pageid"]?>" />
                <input type="submit" value=" <?=$but_text?> Page " class="button" />
            </td>
        </tr>
    </table>
    </form>
</body>
</html>
