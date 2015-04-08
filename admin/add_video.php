<?php 
session_start();
require_once('includes/config.php');
include("includes/sescheck.php");

if($_POST["videosub"] == 1)
{
	$sel_check = "select * from video where title = '".s_for($_POST["title"])."' and videoid <> '".s_for($_POST['ed'])."'";
	$query_check=mysqli_query($con, $sel_check);
	
	if(mysqli_num_rows($query_check)>0)
	{
		$msg=" Video Title already exist. So please give another  Video Title.";
		?>
		<script type="text/javascript">
			alert("<?=$msg;?>");
			window.location="#add";
		</script>
		<?
	} 
	else
	{
		if($_FILES["video_file"]["name"] <> '')
		{
			$fname = $_FILES["video_file"]["name"];
			$lastdot = strrpos($fname,".");
			$name = substr($fname,0,$lastdot);
			$extension = substr($fname,$lastdot+1);
			$video = $name.'_'.date('dmy_Hi');
			$video = str_replace(" ","_",$video);
			$video = str_replace(".","_",$video);
			$video .= ".".$extension;
			
			@move_uploaded_file($_FILES["video_file"]["tmp_name"],"../video_file/".$video);
			@chmod("../video_file/".$video,0777);
			
			if($_POST['video_file_old'] <> '')
			{
				@unlink("../video_file/".$_POST['video_file_old']);
			}
		}
		else
		{
			$video = $_POST['video_file_old'];
		}
		
		$video_link = '';
		
		if($_POST["ed"] != "")
		{
			$ed_sql = "update video set title = '".s_for($_POST["title"])."', status = '".s_for($_POST["status"])."', video_file = '".s_for($video)."' where videoid='".$_POST["ed"]."'";
			mysqli_query($con, $ed_sql) or die($ed_sql." | ".mysqli_error($con));
			
			//echo $ed_sql.mysqli_error($con);
			$msg = "Edited Successfully";
			?>
			<script type="text/javascript">
				//alert("<?=$msg;?>");
				parent.window.location='manage_video.php?msg=<?=$msg;?>';
			</script>
			<?
			die();
		}
		else
		{
			$ins_sql = "insert into video set title = '".s_for($_POST["title"])."', status = '".s_for($_POST["status"])."', video_file = '".s_for($video)."',adddate=now(),ip_address='".$_SERVER['REMOTE_ADDR']."'";
			mysqli_query($con, $ins_sql) or die($ins_sql.mysqli_error($con));
			
			$msg = "Added Successfully";
			?>
			<script type="text/javascript">
				//alert("<?=$msg;?>");
				parent.window.location='manage_video.php?msg=<?=$msg;?>';
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
    $thesql = "select * from video where videoid='".$_REQUEST["ed"]."'";
	$themy = mysqli_query($con, $thesql);
	$themyarray = mysqli_fetch_array($themy);
	
	if($msg != '')
	{
		$title = $_POST['title'];
		$status = $_POST['status'];
		$video_file = $_POST['video_file'];
	}
	else
	{
		$title = st($themyarray['title']);
		$status = st($themyarray['status']);
		$video_file = st($themyarray['video_file']);
		$but_text = "Add ";
	}
	
	if($themyarray["videoid"] != '')
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
    <form name="videofrm" action="<?=$_SERVER['PHP_SELF'];?>?add=1" method="post" onSubmit="return videoabc(this)" enctype="multipart/form-data">
    <table width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center">
        <tr>
            <td colspan="2" class="cat_head">
               <?=$but_text?>  Video 
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
                Video File
            </td>
            <td valign="top" class="frmdata">
            	<? if($themyarray['video_file'] <> '') {?>
                    <a href="../video_file/<?=st($themyarray['video_file'])?>" target="_blank">
                        <b>Preview</b></a>
                    <br>
                <? }?>
                <input type="file" name="video_file" value="" size="26" />
                <input type="hidden" name="video_file_old" value="<?=st($themyarray['video_file'])?>" />
                <span class="red">*</span>
				<br />
				<b>[BEST SIZE: 300px × 250px, Only FLV file]</b>
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
                <input type="hidden" name="videosub" value="1" />
                <input type="hidden" name="ed" value="<?=$themyarray["videoid"]?>" />
                <input type="submit" value=" <?=$but_text?>  Video" class="button" />
            </td>
        </tr>
    </table>
    </form>
</body>
</html>