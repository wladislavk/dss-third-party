<?php namespace Ds3\Libraries\Legacy; ?><?php 
  include_once('admin/includes/main_include.php');
  include("includes/sescheck.php");
  include_once('includes/constants.inc');
  include_once 'includes/general_functions.php';
  include_once 'admin/includes/form_updates.php';

  if(!empty($_POST["compsub"]) && $_POST["compsub"] == 1) {
?>
    <img  id="loading_gif" src="images/DSS-ajax-animated_loading-gif.gif" />
<?php
    $image = $_FILES['logo'];
    $uploadedfile = $image['tmp_name'];
    $fname = $image["name"];
    $lastdot = strrpos($fname,".");
    $name = substr($fname,0,$lastdot);
    $filesize = $image["size"];
    $extension = substr($fname,$lastdot+1);
    if(strtolower($extension) != 'png' && strtolower($extension) != 'gif' && strtolower($extension) !='jpg' && strtolower($extension) != 'jpeg'){
?>
      <script type="text/javascript">
        alert('Logo must be a png, jpg or gif');
        document.getElementById('loading_gif').remove();
      </script>
<?php
    } else {
      $file_name = "user_logo_".$_SESSION["docid"].".".$extension; 
      $file_path = "../../../shared/q_file/".$file_name;
      $max_width = 120;
      $max_height = 80;
      list($width,$height) = getimagesize($uploadedfile);
      if(($width>$max_width || $height>$max_height) || $filesize > DSS_IMAGE_MAX_SIZE ){
        if(strtolower($extension)=="jpg" || strtolower($extension)=="jpeg" ) {
          $src = imagecreatefromjpeg($uploadedfile);
        } elseif(strtolower($extension)=="png") {
          $src = imagecreatefrompng($uploadedfile);
        } else {
          $src = imagecreatefromgif($uploadedfile);
        }

        if(($width > $max_width || $height > $max_height) ){
          $resize_width = $max_width;
          $resize_height = $max_height;
        	$prop_width = $width / $max_width;
        	$prop_height = $height / $max_height;

          if($prop_width > $prop_height) {
            $newwidth = $resize_width;
            $newheight = ($height / $width) * $newwidth;
          } elseif ($prop_height > $prop_width) {
            $newheight = $resize_height;
            $newwidth = ($width / $height) * $newheight;
          } else {
            $newwidth = $resize_width;
            $newheight = $resize_height;
          }
        } else {
          $newwidth = $width;
          $newheight = $height;
        }

        //$newwidth=DSS_IMAGE_MAX_WIDTH;
        //$newheight=($height/$width)*$newwidth;
        $tmp = imagecreatetruecolor($newwidth,$newheight);

        switch (strtolower($extension)) {
            case "png":
                // integer representation of the color black (rgb: 0,0,0)
                $background = imagecolorallocate($tmp, 0, 0, 0);
                // removing the black from the placeholder
                imagecolortransparent($tmp, $background);

                // turning off alpha blending (to ensure alpha channel information 
                // is preserved, rather than removed (blending with the rest of the 
                // image in the form of black))
                imagealphablending($tmp, false);

                // turning on alpha channel information saving (to ensure the full range 
                // of transparency is preserved)
                imagesavealpha($tmp, true);

                break;
            case "gif":
                // integer representation of the color black (rgb: 0,0,0)
                $background = imagecolorallocate($tmp, 0, 0, 0);
                // removing the black from the placeholder
                imagecolortransparent($tmp, $background);

                break;
        }

        imagecopyresampled($tmp, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
        if($extension == "jpg" || $extension == "jpeg" ) {
          imagejpeg($tmp,$file_path,60);
        } elseif($extension=="png") {
          imagepng($tmp,$file_path,6);
        } else {
          imagegif($tmp,$file_path,60);
        }

        $uploaded = true;
        if(filesize($file_path) > DSS_FILE_MAX_SIZE){
          @unlink($file_path);
          $uploaded = false;
        }
        imagedestroy($src);
        imagedestroy($tmp);
      } else {
        if($image['size'] <= DSS_FILE_MAX_SIZE) {
          @move_uploaded_file($image["tmp_name"],$file_path);
          $uploaded = true;
        } else {
          $uploaded = false;
        }
      }
      @chmod($file_path,0777);

			$ed_sql = "update dental_users set 
				         logo = '".mysqli_real_escape_string($con, $file_name)."',
				         updated_at=now()
			           where userid='".$_SESSION["docid"]."'";

			$db->query($ed_sql);

      //not updating forms for the time being since this is not being used anywhere there isn't auto creating forms
      //form_update_all($_SESSION['docid']);
			//echo $ed_sql.mysql_error();
			$msg = "Edited Successfully";
?>
			<script type="text/javascript">
				parent.window.location = 'manage_profile.php?msg=<?php echo $msg;?>';
			</script>
<?php
			trigger_error("Die called", E_USER_ERROR);
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
    <?php
      $thesql = "select * from dental_users where userid='".$_SESSION['docid']."'";

    	$themyarray = $db->getRow($thesql);
   	  $name = st($themyarray['name']);

    	if(!empty($msg)) {
    		$logo = $_POST['logo'];
    	} else {
    		$logo = st($themyarray['logo']);
    		$but_text = "Add ";
    	}
  	
    	if(!empty($themyarray["id"])) {
    		$but_text = "Edit ";
    	} else {
    		$but_text = "Add ";
    	}
	  ?>
	
	  <br /><br />
	
	  <?php if(!empty($msg)) { ?>
      <div align="center" class="red">
        <?php echo $msg;?>
      </div>
    <?php } ?>

    <?php if($logo <> "") { ?>
      <img src="../../../shared/q_file/<?php echo $logo;?>" />
    <?php } ?>

    <form name="userfrm" action="<?php echo $_SERVER['PHP_SELF'];?>?add=1" method="post" enctype="multipart/form-data">
      <table width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center">
        <tr>
          <td colspan="2" class="cat_head">
             <?php echo $but_text?> User Logo
             <?php if($name <> "") { ?>
             		&quot;<?php echo $name;?>&quot;
             <?php } ?>
          </td>
        </tr>
        <tr bgcolor="#FFFFFF">
          <td valign="top" class="frmhead">
              Logo
          </td>
          <td valign="top" class="frmdata">
              <input id="logo" type="file" name="logo" class="tbox" /> 
              <span class="red">*</span>				
          </td>
        </tr>
        <tr>
          <td  colspan="2" align="center">
              <span class="red">
                  * Image must be 120x80pix or less.					
              </span><br />
              <input type="hidden" name="compsub" value="1" />
              <input type="hidden" name="ed" value="<?php echo $themyarray["userid"]?>" />
              <input type="submit" value=" <?php echo $but_text?> User Logo" class="button" />
          </td>
        </tr>
      </table>
    </form>
  </body>
</html>
