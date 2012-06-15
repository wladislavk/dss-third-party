<?php





function uploadImage($image, $file_path, $profile = false){
  $uploadedfile = $image['tmp_name'];
  $fname = $image["name"];
  $lastdot = strrpos($fname,".");
  $name = substr($fname,0,$lastdot);
  $extension = substr($fname,$lastdot+1);
  list($width,$height)=getimagesize($uploadedfile);
  if(($width>DSS_IMAGE_MAX_WIDTH || $height>DSS_IMAGE_MAX_HEIGHT) || ($profile && ($width >DSS_IMAGE_PROFILE_WIDTH || $height>DSS_IMAGE_PROFILE_HEIGHT)) ){

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
	$resize_width = ($profile)?DSS_IMAGE_PROFILE_WIDTH:DSS_IMAGE_RESIZE_WIDTH;
	$resize_height = ($profile)?DSS_IMAGE_PROFILE_HEIGHT:DSS_IMAGE_RESIZE_HEIGHT;

    if($width>$height){
      $newwidth=$resize_width;
      $newheight=($height/$width)*$newwidth;
    }elseif($height>$width){
      $newheight=$resize_height;
      $newwidth=($width/$height)*$newheight;
    }else{
      $newwidth=$resize_width;
      $newheight=$resize_height;
    }
    //$newwidth=DSS_IMAGE_MAX_WIDTH;
    //$newheight=($height/$width)*$newwidth;
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

function sendUpdatedEmail($id, $new, $old, $by){
if(trim($new) != trim($old)){
  $sql = "SELECT u.phone from dental_users u inner join dental_patients p on u.userid=p.docid where p.patientid='".mysql_real_escape_string($id)."'";
  $q = mysql_query($sql);
  $r = mysql_fetch_assoc($q);
  $n = $r['phone'];
if($by=='doc'){
  $m = "<html><body><center>
<table width='600'>
<tr><td colspan='2'><img alt='Dental Sleep Solutions' src='http://".$_SERVER['HTTP_HOST']."/reg/images/email/email_header.png' /></td></tr>
<tr><td width='400'>
<h2>Your Updated Account</h2>
<p>An update has been made to your account.<br />Please use the updated email address below to login:</p>
<h3>New Email: ".$new."</h3>
<p><b>Old Email:</b> ".$old."</p>
</td><td><img alt='Dental Sleep Solutions' src='http://".$_SERVER['HTTP_HOST']."/reg/images/email/reg_logo.gif' /></td></tr>
<tr><td>
<p>Click the link below to login with your new email address:<br />
<a href='http://".$_SERVER['HTTP_HOST']."/reg/login.php'>http://".$_SERVER['HTTP_HOST']."/reg/login.php</a></p>
<h3>Need assistance?</h3>
<p><b>Contact us at ".$n." or at<br>
patient@dentalsleepsolutions.com</b></p>
</td></tr>
<tr><td colspan='2'><img alt='www.dentalsleepsolutions.com' title='www.dentalsleepsolutions.com' src='http://".$_SERVER['HTTP_HOST']."/reg/images/email/email_footer.png' /></td></tr>
</table>
</center></body></html>
";
}else{
  $m = "<html><body><center>
<table width='600'>
<tr><td colspan='2'><img alt='Dental Sleep Solutions' src='http://".$_SERVER['HTTP_HOST']."/reg/images/email/email_header.png' /></td></tr>
<tr><td width='400'>
<h2>Your Updated Account</h2>
<p>You have updated your account.<br />Please use the updated email address below to login:</p>
<h3>New Email: ".$new."</h3>
<p><b>Old Email:</b> ".$old."</p>
</td><td><img alt='Dental Sleep Solutions' src='http://".$_SERVER['HTTP_HOST']."/reg/images/email/reg_logo.gif' /></td></tr>
<tr><td>
<p>Click the link below to login with your new email address:<br />
<a href='http://".$_SERVER['HTTP_HOST']."/reg/login.php'>http://".$_SERVER['HTTP_HOST']."/reg/login.php</a></p>
<h3>Didn't request this change or need assistance?</h3>
<p><b>Contact us at ".$n." or at<br>
patient@dentalsleepsolutions.com</b></p>
</td></tr>
<tr><td colspan='2'><img alt='www.dentalsleepsolutions.com' title='www.dentalsleepsolutions.com' src='http://".$_SERVER['HTTP_HOST']."/reg/images/email/email_footer.png' /></td></tr>
</table>
</center></body></html>
";



}
$headers = 'From: SWsupport@dentalsleepsolutions.com' . "\r\n" .
                    'Content-type: text/html' ."\r\n" .
                    'Reply-To: SWsupport@dentalsleepsolutions.com' . "\r\n" .
                     'X-Mailer: PHP/' . phpversion();

                $subject = "Dental Sleep Solutions Email update";

                mail($new, $subject, $m, $headers);
                mail($old, $subject, $m, $headers);
}
}



function showPatientValue($table, $pid, $f, $pv, $fv, $showValues = true, $show=true, $type="text"){
  if($pv != $fv && $show){
	?>
	<span id="patient_<?= $f; ?>" class="patient_change">
		<?php if($showValues){ ?>
		   <?php if($type=="radio" && $pv=='0'){ ?>
			> No
		   <?php }elseif($type=="radio" && $pv=='1'){ ?>
			> Yes
		   <?php }else{ ?>
			 > <?= $pv; ?>
		   <?php } ?>
		<?php } ?>
                <a href="#" title="Reject" class="reject" onclick="updateQuestionnaire('<?= $table; ?>', '<?= $pid; ?>', '<?= $f; ?>', '<?= $fv; ?>', '<?= $type; ?>'); return false;"></a>
		<a href="#" title="Accept" class="accept" onclick="updateQuestionnaire('<?= $table; ?>', '<?= $pid; ?>', '<?= $f; ?>', '<?= $pv; ?>', '<?= $type; ?>'); return false;"></a>
	</span>
	<script type="text/javascript">
		$('#<?= $f; ?>').addClass('edits');
	</script>
	<?php
  }
}


function num($n, $phone=true){
$n = preg_replace('/\D/', '', $n);
if(!$phone){return $n; }
$pattern = '/([1]*)(.*)/';
preg_match($pattern, $n, $matches);
return $matches[2];
}


?>
