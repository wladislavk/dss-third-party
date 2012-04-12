<?php 
session_start();
require_once('admin/includes/config.php');
require_once('includes/constants.inc');
include("includes/sescheck.php");
require_once('includes/general_functions.php');
?>
<script type="text/javascript" src="admin/script/jquery-1.6.2.min.js"></script>
<?php
if($_POST["imagesub"] == 1)
{
	
	if ($_POST['imagetypeid'] ==0 || (array_search($_FILES["image_file"]["type"], $dss_file_types) !== false) ) {
		$title = $_POST['title'];
		$imagetypeid = $_POST['imagetypeid'];
	

	  if($imagetypeid == '0'){
                        $fname = $_FILES["image_file_1"]["name"];
                        $lastdot = strrpos($fname,".");
                        $name = substr($fname,0,$lastdot);
                        $extension = substr($fname,$lastdot+1);
                        $banner1 = $name.'_'.date('dmy_Hi');
                        $banner1 = str_replace(" ","_",$banner1);
                        $banner1 = str_replace(".","_",$banner1);
                        $banner1 .= ".".$extension;

		// Get new sizes
		$newwidth = 1500;
		$newheight = 1500;

		// Load
		$thumb = imagecreatetruecolor($newwidth, $newheight);
		for($i=1;$i<=9;$i++){
                        $fname = $_FILES["image_file_".$i]["name"];
                        $lastdot = strrpos($fname,".");
                        $name = substr($fname,0,$lastdot);
                        $extension2 = substr($fname,$lastdot+1);
			switch($extension2){
			  case 'jpg':
			  case 'jpeg':
				$source = imagecreatefromjpeg($_FILES["image_file_".$i]["tmp_name"]);
				break;
                          case 'gif':
                                $source = imagecreatefromgif($_FILES["image_file_".$i]["tmp_name"]);
                                break;
                          case 'png':
                                $source = imagecreatefrompng($_FILES["image_file_".$i]["tmp_name"]);
                                break;
			}
			list($width, $height) = getimagesize($_FILES["image_file_".$i]["tmp_name"]);
			$x = (($i-1)%3)*500;
			$y = floor(($i-1)/3)*500;	
			// Resize
			imagecopyresized($thumb, $source, $x, $y, 0, 0, 500, 500, $width, $height);

		}
			$fname = $_FILES["image_file_1"]["name"];
                        $lastdot = strrpos($fname,".");
                        $name = substr($fname,0,$lastdot);
                        $extension = substr($fname,$lastdot+1);
                        $banner1 = $name.'_'.date('dmy_Hi');
                        $banner1 = str_replace(" ","_",$banner1);
                        $banner1 = str_replace(".","_",$banner1);
                        $banner1 .= ".".$extension;

		// Output
                        switch($extension){
                          case 'jpg':
                          case 'jpeg':
                		imagejpeg($thumb, "q_file/".$banner1);
                                break;
                          case 'gif':
                                imagegif($thumb, "q_file/".$banner1);                               
                                break;
                          case 'png':
                                imagepng($thumb, "q_file/".$banner1);
                                break;
                        }

		@chmod("q_file/".$banner1,0777);
		// Free up memory
		//imagedestroy($thumb);
		$uploaded = true;

	  }else{

	
		if($_FILES["image_file"]["name"] <> '')
		{
			$fname = $_FILES["image_file"]["name"];
			$lastdot = strrpos($fname,".");
			$name = substr($fname,0,$lastdot);
			$extension = substr($fname,$lastdot+1);
			$banner1 = $name.'_'.date('dmy_Hi');
			$banner1 = str_replace(" ","_",$banner1);
			$banner1 = str_replace(".","_",$banner1);
			$banner1 .= ".".$extension;

			$uploaded = uploadImage($_FILES['image_file'], "q_file/".$banner1);
			if($_POST['image_file_old'] <> '')
			{
				@unlink("q_file/".$_POST['image_file_old']);
			}
		}
		else
		{
			$banner1 = $_POST['image_file_old'];
		}
	}	
if($uploaded){		
		if($_POST["ed"] != "")
		{
			$ed_sql = " update dental_q_image set 
			title = '".s_for($title)."',
			imagetypeid = '".s_for($imagetypeid)."',
			image_file = '".s_for($banner1)."'
			where imageid = '".s_for($_POST['ed'])."'";
			
			mysql_query($ed_sql) or die($ed_sql." | ".mysql_error());
			
			$msg = "Edited Successfully";
			?>
			<script type="text/javascript">
				parent.window.location='q_image.php?pid=<?=$_GET['pid'];?>&sh=<?=$_GET['sh'];?>';
			</script>
			<?
			die();
		}
		else
		{
			$ins_sql = " insert into dental_q_image set 
			patientid = '".s_for($_GET['pid'])."',
			title = '".s_for($title)."',
			imagetypeid = '".s_for($imagetypeid)."',
			image_file = '".s_for($banner1)."',
			userid = '".s_for($_SESSION['userid'])."',
			docid = '".s_for($_SESSION['docid'])."',
			adddate = now(),
			ip_address = '".s_for($_SERVER['REMOTE_ADDR'])."'";
			
			mysql_query($ins_sql) or die($ins_sql." | ".mysql_error());
			$msg = "Uploaded Successfully";
			if ($_REQUEST['flow'] == "1") {
				?>
				<script type="text/javascript">
					parent.window.location="/manage/manage_flowsheet3.php?pid=<?=$_GET['pid'];?>"
				</script>
				<?
				die();
			} else {
				?>
				<script type="text/javascript">
					parent.window.location='q_image.php?pid=<?=$_GET['pid'];?>';
				</script>
				<?
				die();
			}
		}
}else{
  ?>
                        <script type="text/javascript">
                                alert("File too Large");
                        </script>
                <?php
}
	} else {
		?>
			<script type="text/javascript">
				alert("Invalid File Type");
			</script>           
		<?php
	}
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="css/admin.css" rel="stylesheet" type="text/css" />
<script language="javascript" type="text/javascript" src="script/validation.js"></script>

<link rel="stylesheet" href="css/form.css" type="text/css" />
<script type="text/javascript" src="script/wufoo.js"></script>
</head>
<body>
<div id="loader" style="position:absolute;width:100%; height:98%; display:none;">
<img style="margin:100px 0 0 45%" src="images/DSS-ajax-animated_loading-gif.gif" />
</div>
    <?
    $thesql = "select * from dental_q_image where imageid='".$_REQUEST["ed"]."'";
	$themy = mysql_query($thesql);
	$themyarray = mysql_fetch_array($themy);
	
	if($msg != '')
	{
		$title = $_POST['title'];
		$imagetypeid = $_POST['imagetypeid'];
	}
	else
	{
		$title = st($themyarray['title']);
		$image_file = st($themyarray['image_file']);
		$imagetypeid = st($themyarray['imagetypeid']);
		
		$but_text = "Add ";
	}
	
	if($imagetypeid == '')
		$imagetypeid = $_GET['sh'];
		
	if($themyarray["contactid"] != '')
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
    <form name="imagefrm" action="<?=$_SERVER['PHP_SELF'];?>?add=1&pid=<?=$_GET['pid'];?>&sh=<?=$_GET['sh'];?>" method="post" onSubmit="return imageabc(this);" enctype="multipart/form-data">
 
		<input name="flow" type="hidden" value="<?=$_GET['flow'];?>" />
    <table width="700" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center">
        <tr>
            <td colspan="2" class="cat_head">
               <?=$but_text?> Image
               <? if($title <> "") {?>
               		&quot;<?=$title;?>&quot;
               <? }?>
            </td>
        </tr>
		<tr>
        	<td valign="top" colspan="2" class="frmhead">
				<ul>
                    <li id="foli8" class="complex">	
						<span>
							Image Type
							&nbsp;&nbsp;
							<? 
							$itype_sql = "select * from dental_imagetype where status=1 order by sortby";
							$itype_my = mysql_query($itype_sql);
							?>
							<select id="imagetypeid" name="imagetypeid" class="field text addr tbox">
								<option value=""></option>
								<? while($itype_myarray = mysql_fetch_array($itype_my))
								{?>
									<option value="<?=st($itype_myarray['imagetypeid']);?>" <? if($imagetypeid == st($itype_myarray['imagetypeid']) || $_GET['it']==$itype_myarray['imagetypeid']) echo " selected"; ?>>
										<?=st($itype_myarray['imagetype']);?>
									</option>
								<? }?>
								<option value="0">Clinical Photos (Pre-Tx)</option>
							</select>
						</span> 
						<span id="req_0" class="req">*</span>
                    </li>
                </ul>
            </td>
        </tr>
<script type="text/javascript">
  $('#imagetypeid').change(function(){
	if($(this).val() == '0'){
		$('#extra_files').show();
		$('#orig_file').hide();
	}else{
		$('#extra_files').hide();
		$('#orig_file').show();
	}
  });
</script>
        <tr> 
        	<td valign="top" colspan="2" class="frmhead">
            	<ul>
            		<li id="foli8" class="complex">	
						<span>
							Title
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<input id="title" name="title" type="text" class="field text addr tbox" value="<?=$title;?>" maxlength="255"/>
						</span>
						<span id="req_0" class="req">*</span>
                    </li>
				</ul>
            </td>
        </tr>
        <tr id="orig_file"> 
        	<td valign="top" colspan="2" class="frmhead">
            	<ul>
            		<li id="foli8" class="complex">	
						<span>
							Image
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							
							<? if($image_file <> '') {?>
                                <a href="q_file/<?=$image_file?>" target="_blank">
                                    <b>Preview</b></a>
                                &nbsp;&nbsp;&nbsp;&nbsp;
                            <? }?>
                            <input type="file" name="image_file" value="" size="26" />
                            <input type="hidden" name="image_file_old" value="<?=$image_file;?>" />
						</span>
						<span id="req_0" class="req">*</span>
                    </li>
				</ul>
            </td>
        </tr>
	<tr id="extra_files" style="display:none;">
		<td colspan="2" class="frmhead">
		<?php
			$labels = array('', 'Facial Right', 'Facial Front', 'Facial Left', 'Retracted Right', 'Retracted Frontal', 'Retracted Left', 'Occlusal Upper', 'Mallampati', 'Occlusal Lower');
		?>
			<?php for($i=1;$i<=9;$i++){ ?>
			<label style="width:100px; float:left; display:block;"><?= $labels[$i]; ?></label>
				<input type="file" name="image_file_<?= $i; ?>" value="" size="26" /><br />
			<?php } ?>
		</td>
	</tr>
        <tr>
            <td  colspan="2" align="center">
                <span class="red">
                    * Required Fields					
                </span><br />
                <input type="hidden" name="imagesub" value="1" />
                <input type="hidden" name="ed" value="<?=$themyarray["imageid"]?>" />
                <input type="submit" value=" <?=$but_text?> Image" class="button" />
            </td>
        </tr>
    </table>
    </form>
</body>
</html>
