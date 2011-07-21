<?php





function uploadImage($image, $file_path){
  $uploadedfile = $image['tmp_name'];
  $fname = $image["name"];
  $lastdot = strrpos($fname,".");
  $name = substr($fname,0,$lastdot);
  $extension = substr($fname,$lastdot+1);
  list($width,$height)=getimagesize($uploadedfile);
  if($width>DSS_IMAGE_MAX_WIDTH || $height>DSS_IMAGE_MAX_HEIGHT){

    if($extension=="jpg" || $extension=="jpeg" )
    {
      $src = imagecreatefromjpeg($uploadedfile);
    }
    elseif($extension=="png")
    {
      $src = imagecreatefrompng($uploadedfile);
    }
    else
    {
      $src = imagecreatefromgif($uploadedfile);
    }


    if($width>$height){
      $newwidth=DSS_IMAGE_MAX_WIDTH;
      $newheight=($height/$width)*$newwidth;
    }elseif($height>$width){
      $newheight=DSS_IMAGE_MAX_HEIGHT;
      $newwidth=($width/$height)*$newheight;
    }else{
      $newwidth=DSS_IMAGE_MAX_WIDTH;
      $newheight=DSS_IMAGE_MAX_HEIGHT;
    }
    $newwidth=DSS_IMAGE_MAX_WIDTH;
    $newheight=($height/$width)*$newwidth;
    $tmp=imagecreatetruecolor($newwidth,$newheight);
    imagecopyresampled($tmp,$src,0,0,0,0,$newwidth,$newheight,$width,$height);
    if($extension=="jpg" || $extension=="jpeg" )
    {
    imagejpeg($tmp,$file_path,100);
    }
    elseif($extension=="png")
    {
      imagepng($tmp,$file_path,100);
    }
    else
    {
      imagegif($tmp,$file_path,100);
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
  return $uploaded;
}


?>
