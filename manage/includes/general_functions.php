<?php namespace Ds3\Legacy; ?><?php





function uploadImage($image, $file_path, $type = 'general'){
  $uploadedfile = $image['tmp_name'];
  $fname = $image["name"];
  $lastdot = strrpos($fname,".");
  $name = substr($fname,0,$lastdot);
  $filesize = $image["size"];
  $extension = substr($fname,$lastdot+1);
  list($width,$height)=getimagesize($uploadedfile);
  if(($width>DSS_IMAGE_MAX_WIDTH || $height>DSS_IMAGE_MAX_HEIGHT) || $filesize > DSS_IMAGE_MAX_SIZE 
		|| ($type == 'profile' && ($width >DSS_IMAGE_PROFILE_WIDTH || $height>DSS_IMAGE_PROFILE_HEIGHT))
                || ($type == 'device' && ($width >DSS_IMAGE_DEVICE_WIDTH || $height>DSS_IMAGE_DEVICE_HEIGHT)) 
		 ){

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
    if(($width>DSS_IMAGE_MAX_WIDTH || $height>DSS_IMAGE_MAX_HEIGHT) 
		|| ($type == 'profile' && ($width >DSS_IMAGE_PROFILE_WIDTH || $height>DSS_IMAGE_PROFILE_HEIGHT))
		|| ($type == 'device' && ($width >DSS_IMAGE_DEVICE_WIDTH || $height>DSS_IMAGE_DEVICE_HEIGHT))
		 ){
	if($type=='profile'){
	$resize_width = DSS_IMAGE_PROFILE_WIDTH;
	$resize_height = DSS_IMAGE_PROFILE_HEIGHT;
	}elseif($type=='device'){
        $resize_width = DSS_IMAGE_DEVICE_WIDTH;
        $resize_height = DSS_IMAGE_DEVICE_HEIGHT;
        }else{
        $resize_width = DSS_IMAGE_RESIZE_WIDTH;
        $resize_height = DSS_IMAGE_RESIZE_HEIGHT;
        }
        $prop_width = $width/$resize_width;
        $prop_height = $height/$resize_height;
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
  return $uploaded;
}

function sendUpdatedEmail($id, $new, $old, $by){

$db = new Db();
$con = $GLOBALS['con'];

if(trim($new) != trim($old)){
  $sql = "SELECT l.phone mailing_phone, u.user_type, u.logo, l.location mailing_practice, l.address mailing_address, l.city mailing_city, l.state mailing_state, l.zip mailing_zip from dental_users u inner join dental_patients p on u.userid=p.docid 
                LEFT JOIN dental_locations l ON l.docid = u.userid AND l.default_location=1
	where p.patientid='".mysqli_real_escape_string($con,$id)."'";

  $r = $db->getRow($sql);
  $n = $r['mailing_phone'];
  if($ur['user_type'] == DSS_USER_TYPE_SOFTWARE){
    $logo = "/manage/q_file/".$ur['logo'];
  }else{
    $logo = "/reg/images/email/reg_logo.gif";
  }

if($by=='doc'){
  $m = "<html><body><center>
<table width='600'>
<tr><td colspan='2'><img alt='A message from your healthcare provider' src='http://".$_SERVER['HTTP_HOST']."/reg/images/email/email_header_fo.png' /></td></tr>
<tr><td width='400'>
<h2>Your Updated Account</h2>
<p>An update has been made to your account.<br />Please use the updated email address below to login:</p>
<h3>New Email: ".$new."</h3>
<p><b>Old Email:</b> ".$old."</p>
</td><td><img alt='Logo' src='http://".$_SERVER['HTTP_HOST'].$logo."' /></td></tr>
<tr><td>
<p>Click the link below to login with your new email address:<br />
<a href='http://".$_SERVER['HTTP_HOST']."/reg/login.php'>http://".$_SERVER['HTTP_HOST']."/reg/login.php</a></p>
<p>".$r['mailing_practice']."<br />
".$r['mailing_address']."<br />
".$r['mailing_city']." ".$r['mailing_state']." ".$r['mailing_zip']."<br />
".format_phone($r['mailing_phone'])."</p>
<h3>Need assistance?</h3>
<p><b>Contact us at ".$n."</b></p>
</td></tr>
<tr><td colspan='2'><img alt='A message from your healthcare provider' src='".$_SERVER['HTTP_HOST']."/reg/images/email/email_footer_fo.png' /></td></tr>
</table>
</center><span style=\"font-size:12px;\">This email was sent by Dental Sleep Solutions&reg; on behalf of ".$r['mailing_practice'].". ".DSS_EMAIL_FOOTER."</span></body></html>
";
}else{
  $m = "<html><body><center>
<table width='600'>
<tr><td colspan='2'><img alt='A message from your healthcare provider' src='http://".$_SERVER['HTTP_HOST']."/reg/images/email/email_header_fo.png' /></td></tr>
<tr><td width='400'>
<h2>Your Updated Account</h2>
<p>You have updated your account.<br />Please use the updated email address below to login:</p>
<h3>New Email: ".$new."</h3>
<p><b>Old Email:</b> ".$old."</p>
</td><td><img alt='Logo' src='http://".$_SERVER['HTTP_HOST'].$logo."' /></td></tr>
<tr><td>
<p>Click the link below to login with your new email address:<br />
<a href='http://".$_SERVER['HTTP_HOST']."/reg/login.php'>http://".$_SERVER['HTTP_HOST']."/reg/login.php</a></p>
<p>".$r['mailing_practice']."<br />
".$r['mailing_address']."<br />
".$r['mailing_city']." ".$r['mailing_state']." ".$r['mailing_zip']."<br />
".format_phone($r['mailing_phone'])."</p>
<h3>Didn't request this change or need assistance?</h3>
<p><b>Contact us at ".$n."</b></p>
</td></tr>
<tr><td colspan='2'><img alt='A message from your healthcare provider' src='http://".$_SERVER['HTTP_HOST']."/reg/images/email/email_footer_fo.png' /></td></tr>
</table>
</center><span style=\"font-size:12px;\">This email was sent by Dental Sleep Solutions&reg; on behalf of ".$r['mailing_practice'].". ".DSS_EMAIL_FOOTER."</span></body></html>
";



}
$headers = 'From: Dental Sleep Solutions <patient@dentalsleepsolutions.com>' . "\r\n" .
                    'Content-type: text/html' ."\r\n" .
                    'Reply-To: patient@dentalsleepsolutions.com' . "\r\n" .
                     'X-Mailer: PHP/' . phpversion();

                $subject = "Online Patient Portal Email Update";

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

function format_phone($data){
if(  preg_match( '/.*(\d{3}).*(\d{3}).*(\d{4}).*(\d*)$/', $data,  $matches ) )
{
    $result = '(' . $matches[1] . ') ' .$matches[2] . '-' . $matches[3];
    if($matches[4]!=''){
      $result .= ' x'.$matches[4];
    }
    return $result;
}
}

function split_phone($num, $a){
        $num = preg_replace("[^0-9]", "", $num);
        preg_match('/([0-1]*)(.*)/',$num, $m);
        $num = $m[2];
  if($a){
        return substr($num, 0, 3);
  }else{
        return substr($num,3);
  }
  return $num;
}

?>
