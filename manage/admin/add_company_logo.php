<?php 
session_start();
require_once('includes/main_include.php');
include("includes/sescheck.php");
include_once('includes/password.php');
require_once('../includes/constants.inc');
include_once '../includes/general_functions.php';
if($_POST["compsub"] == 1)
{

  $image = $_FILES['logo'];
  $uploadedfile = $image['tmp_name'];
  $fname = $image["name"];
  $lastdot = strrpos($fname,".");
  $name = substr($fname,0,$lastdot);
  $filesize = $image["size"];
  $extension = substr($fname,$lastdot+1);
  $file_name = "company_logo_".$_POST["ed"].".".$extension; 
  $file_path = "../q_file/".$file_name;
  $max_width = 230;
  $max_height = 50;
  list($width,$height)=getimagesize($uploadedfile);
  if(($width>$max_width || $height>$max_height) || $filesize > DSS_IMAGE_MAX_SIZE ){

    if(strtolower($extension)=="jpg" || strtolower($extension)=="jpeg" )
    {
      $src = imagecreatefromjpeg($uploadedfile);
    }
    elseif(strtolower($extension)=="png")
    {
      $src = imagecreatefrompng($uploadedfile);
    }
    else
    {
      $src = imagecreatefromgif($uploadedfile);
    }
    if(($width>$max_width || $height>$max_height) ){
        $resize_width = $max_width;
        $resize_height = $max_height;
	$prop_width = $width/$max_width;
	$prop_height = $height/$max_height;
        if($prop_width>$prop_height){
          $newwidth=$resize_width;
          $newheight=($height/$width)*$newwidth;
        }elseif($prop_height>$prop_width){
          $newheight=$resize_height;
          $newwidth=($width/$height)*$newheight;
        }else{
          $newwidth=$resize_width;
          $newheight=$resize_height;
        }
    }else{
        $newwidth = $width;
        $newheight = $height;
    }
    //$newwidth=DSS_IMAGE_MAX_WIDTH;
    //$newheight=($height/$width)*$newwidth;
    $tmp=imagecreatetruecolor($newwidth,$newheight);
    imagecopyresampled($tmp,$src,0,0,0,0,$newwidth,$newheight,$width,$height);
    if($extension=="jpg" || $extension=="jpeg" )
    {
    imagejpeg($tmp,$file_path,60);
    }
    elseif($extension=="png")
    {
      imagepng($tmp,$file_path,6);
    }
    else
    {
      imagegif($tmp,$file_path,60);
    }
    $uploaded = true;
    if(filesize($file_path) > DSS_FILE_MAX_SIZE){
      @unlink($file_path);
      $uploaded = false;
    }
    imagedestroy($src);
    imagedestroy($tmp);

  }else{
    if($image['size'] <= DSS_FILE_MAX_SIZE){

      @move_uploaded_file($image["tmp_name"],$file_path);
      $uploaded = true;

    }else{
      $uploaded =false;
    }
  }
                        @chmod($file_path,0777);



			$ed_sql = "update companies set 
				logo = '".mysql_real_escape_string($file_name)."'
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

?>

<?php require_once dirname(__FILE__) . '/includes/popup_top.htm'; ?>

    <?
    $thesql = "select * from companies where id='".$_REQUEST["ed"]."'";
	$themy = mysql_query($thesql);
	$themyarray = mysql_fetch_array($themy);
 	 $name = st($themyarray['name']);	
	if($msg != '')
	{
		$logo = $_POST['logo'];
	}
	else
	{
		$logo = st($themyarray['logo']);
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
    <div class="alert alert-danger text-center">
        <? echo $msg;?>
    </div>
    <? }?>
               <? if($logo <> "") {?>
                        <img src="../q_file/<?=$logo;?>" />
               <? }?>
    <form name="userfrm" action="<?=$_SERVER['PHP_SELF'];?>?add=1" method="post" enctype="multipart/form-data">
    <table class="table table-bordered">
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
                Logo
            </td>
            <td valign="top" class="frmdata">
                <input id="logo" type="file" name="logo" class="form-control" /> 
                <span class="red">*</span>				
            </td>
        </tr>
        <tr>
            <td  colspan="2" align="center">
                <span class="red">
                    * Image must be 230x50pix or less.					
                </span><br />
                <input type="hidden" name="compsub" value="1" />
                <input type="hidden" name="ed" value="<?=$themyarray["id"]?>" />
                <input type="submit" value="<?=$but_text?> Company Logo" class="btn btn-primary">
            </td>
        </tr>
    </table>
    </form>
</body>
</html>
