<?php 
session_start();
require_once('includes/config.php');
include("includes/sescheck.php");

if($_POST["bannersub"] == 1)
{
	$sel_check = "select * from banner where title = '".s_for($_POST["title"])."' and bannerid <> '".s_for($_POST['ed'])."'";
	$query_check=mysql_query($sel_check);
	
	if(mysql_num_rows($query_check)>0)
	{
		$msg=" Banner Title already exist. So please give another  Banner Title.";
		?>
		<script type="text/javascript">
			alert("<?=$msg;?>");
			window.location="#add";
		</script>
		<?
	} 
	else
	{
		if($_FILES["banner_file"]["name"] <> '')
		{
			$fname = $_FILES["banner_file"]["name"];
			$lastdot = strrpos($fname,".");
			$name = substr($fname,0,$lastdot);
			$extension = substr($fname,$lastdot+1);
			$banner = $name.'_'.date('dmy_Hi');
			$banner = str_replace(" ","_",$banner);
			$banner = str_replace(".","_",$banner);
			$banner .= ".".$extension;
			
			@move_uploaded_file($_FILES["banner_file"]["tmp_name"],"../banner_file/".$banner);
			@chmod("../banner_file/".$banner,0777);
			
			if($_POST['banner_file_old'] <> '')
			{
				@unlink("../banner_file/".$_POST['banner_file_old']);
			}
		}
		else
		{
			$banner = $_POST['banner_file_old'];
		}
		
		$banner_link = '';
		
		if($_POST['banner_link'] <> '')
		{
			if(strpos($_POST['banner_link'],'http://') === false)
			{
				$banner_link = 'http://'.$_POST['banner_link'];
			}
			else
			{
				$banner_link = $_POST['banner_link'];
			}
		}
		
		if($_POST["ed"] != "")
		{
			$ed_sql = "update banner set title = '".s_for($_POST["title"])."', status = '".s_for($_POST["status"])."', banner_file = '".s_for($banner)."', banner_link = '".s_for($banner_link)."' where bannerid='".$_POST["ed"]."'";
			mysql_query($ed_sql) or die($ed_sql." | ".mysql_error());
			
			//echo $ed_sql.mysql_error();
			$msg = "Edited Successfully";
			?>
			<script type="text/javascript">
				//alert("<?=$msg;?>");
				parent.window.location='manage_banner.php?msg=<?=$msg;?>';
			</script>
			<?
			die();
		}
		else
		{
			$ins_sql = "insert into banner set title = '".s_for($_POST["title"])."', status = '".s_for($_POST["status"])."', banner_file = '".s_for($banner)."', banner_link = '".s_for($banner_link)."',adddate=now(),ip_address='".$_SERVER['REMOTE_ADDR']."'";
			mysql_query($ins_sql) or die($ins_sql.mysql_error());
			
			$msg = "Added Successfully";
			?>
			<script type="text/javascript">
				//alert("<?=$msg;?>");
				parent.window.location='manage_banner.php?msg=<?=$msg;?>';
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
    $thesql = "select * from banner where bannerid='".$_REQUEST["ed"]."'";
	$themy = mysql_query($thesql);
	$themyarray = mysql_fetch_array($themy);
	
	if($msg != '')
	{
		$title = $_POST['title'];
		$status = $_POST['status'];
		$banner_file = $_POST['banner_file'];
		$banner_link = $_POST['banner_link'];
	}
	else
	{
		$title = st($themyarray['title']);
		$status = st($themyarray['status']);
		$banner_file = st($themyarray['banner_file']);
		$banner_link = st($themyarray['banner_link']);
		$but_text = "Add ";
	}
	
	if($themyarray["bannerid"] != '')
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
    <form name="bannerfrm" action="<?=$_SERVER['PHP_SELF'];?>?add=1" method="post" onSubmit="return bannerabc(this)" enctype="multipart/form-data">
    <table width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center">
        <tr>
            <td colspan="2" class="cat_head">
               <?=$but_text?>  Banner 
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
            <td valign="top" class="frmhead">
                Banner File
            </td>
            <td valign="top" class="frmdata">
            	<? if($themyarray['banner_file'] <> '') {?>
                    <a href="../banner_file/<?=st($themyarray['banner_file'])?>" target="_blank">
                        <b>Preview</b></a>
                    <br>
                <? }?>
                <input type="file" name="banner_file" value="" size="26" />
                <input type="hidden" name="banner_file_old" value="<?=st($themyarray['banner_file'])?>" />
                <span class="red">*</span>
				<br />
				<b>[BEST SIZE: 300px × 250px]</b>
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                Banner Link
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="banner_link" value="<?=$banner_link?>" class="tbox" /> 
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
                <input type="hidden" name="bannersub" value="1" />
                <input type="hidden" name="ed" value="<?=$themyarray["bannerid"]?>" />
                <input type="submit" value=" <?=$but_text?>  Banner" class="button" />
            </td>
        </tr>
    </table>
    </form>
</body>
</html>