<?php namespace Ds3\Libraries\Legacy; ?><?php
require_once '../../manage/admin/includes/main_include.php';
require_once '../../manage/includes/constants.inc';
$t = $_POST['type'];
    $s = "SELECT * FROM dental_patients WHERE email='".mysqli_real_escape_string($con, $_POST['email'])."' AND parent_patientid IS NULL";
    $q = mysqli_query($con, $s);
    if(mysqli_num_rows($q) > 0){
      $r = mysqli_fetch_assoc($q);
	if($r['registration_status']==1 && $r['password']==''){ $t = 'activate'; }
      if($r['password']!='' && $t=='activate'){
        echo '{"error":"existing"}';
      }elseif($r['password']=='' && $t=='reset'){
	echo '{"error":"activate"}';
      }elseif($t == 'activate' && $r['registration_status']==0){
	echo '{"error":"restricted"}';
      }else{

    if($r['recover_hash'] == ''){

                $recover_hash = hash('sha256', $r['patientid'].$_POST['email'].rand());
                $ins_sql = "UPDATE dental_patients set recover_hash='".$recover_hash."', recover_time=NOW() WHERE patientid='".$r['patientid']."'";
                mysqli_query($con, $ins_sql);

    }else{
      $recover_hash = $r['recover_hash'];
    }
  $usql = "SELECT u.phone from dental_users u inner join dental_patients p on u.userid=p.docid where p.patientid='".mysqli_real_escape_string($con, $r['patientid'])."'";
  $uq = mysqli_query($con, $usql);
  $ur = mysqli_fetch_assoc($uq);
  $n = $ur['phone'];


$loc_sql = "SELECT location FROM dental_summary where patientid='".mysqli_real_escape_string($con, $r['patientid'])."'";
$loc_q = mysqli_query($con, $loc_sql);
$loc_r = mysqli_fetch_assoc($loc_q);
if($loc_r['location'] != '' && $loc_r['location'] != '0'){
  $location_query = "SELECT  l.phone mailing_phone, u.user_type, u.logo, l.location mailing_practice, l.address mailing_address, l.city mailing_city, l.state mailing_state, l.zip mailing_zip 
from dental_users u inner join dental_patients p on u.userid=p.docid 
                LEFT JOIN dental_locations l ON l.docid = u.userid
        WHERE l.id='".mysqli_real_escape_string($con, $loc_r['location'])."' AND l.docid='".mysqli_real_escape_string($con, $r['docid'])."'";
}else{
  $location_query = "SELECT l.phone mailing_phone, u.user_type, u.logo, l.location mailing_practice, l.address mailing_address, l.city mailing_city, l.state mailing_state, l.zip mailing_zip from dental_users u inner join dental_patients p on u.userid=p.docid 
                LEFT JOIN dental_locations l ON l.docid = u.userid AND l.default_location=1
        where p.patientid='".mysqli_real_escape_string($con, $r['patientid'])."'";
}
  $uq = mysqli_query($con, $location_query);
  $ur = mysqli_fetch_assoc($uq);
  $n = format_phone($ur['mailing_phone']);
  if($ur['user_type'] == DSS_USER_TYPE_SOFTWARE){
    $logo = "/manage/q_file/".$ur['logo'];
  }else{
    $logo = "/reg/images/email/reg_logo.gif";
  }



if($t == 'activate'){
  $m = "<html><body><center>
<table width='600'>
<tr><td colspan='2'><img alt='A message from your healthcare provider' src='".$_SERVER['HTTP_HOST']."/reg/images/email/email_header_fo.png' /></td></tr>
<tr><td width='400'>
<h2>Your New Account - A new patient account has been created for you</h2>
<p>Please click the following link to activate your account.</p>
<p><a href='http://".$_SERVER['HTTP_HOST']."/reg/activate.php?id=".$r['patientid']."&hash=".$recover_hash."'>http://".$_SERVER['HTTP_HOST']."/reg/activate.php?id=".$r['patientid']."&hash=".$recover_hash."</a></p>
</td><td><img alt='Dental Sleep Solutions' src='http://".$_SERVER['HTTP_HOST'].$logo."' /></td></tr>
<tr><td>
<h3>Didn't request this change or need assistance?</h3>
<p><b>Contact us at ".$n." or at<br>
patient@dentalsleepsolutions.com</b></p>
</td></tr>
<tr><td colspan='2'><img alt='A message from your healthcare provider' src='".$_SERVER['HTTP_HOST']."/reg/images/email/email_footer_fo.png' /></td></tr>
</table>
</center><span style=\"font-size:12px;\">This email was sent by Dental Sleep Solutions&reg; on behalf of ".$ur['mailing_practice'].". ".DSS_EMAIL_FOOTER."</span></body></html>
";
$m .= $email_footer;
}else{
  $m = "<html><body><center>
<table width='600'>
<tr><td colspan='2'><img alt='A message from your healthcare provider' src='".$_SERVER['HTTP_HOST']."/reg/images/email/email_header_fo.png' /></td></tr>
<tr><td width='400'>
<h2>Reset your password</h2><p>Please click the following link to reset your password.</p>
<p><a href='http://".$_SERVER['HTTP_HOST']."/reg/reset.php?id=".$r['patientid']."&hash=".$recover_hash."'>http://".$_SERVER['HTTP_HOST']."/reg/reset.php?id=".$r['patientid']."&hash=".$recover_hash."</a></p>
</td><td><img alt='Dental Sleep Solutions' src='http://".$_SERVER['HTTP_HOST'].$logo."' /></td></tr>
<tr><td>
<h3>Didn't request this change or need assistance?</h3>
<p><b>Contact us at ".$n." or at<br>
patient@dentalsleepsolutions.com</b></p></td></tr>
<tr><td colspan='2'><img alt='A message from your healthcare provider' src='".$_SERVER['HTTP_HOST']."/reg/images/email/email_footer_fo.png' /></td></tr>
</table>
</center><span style=\"font-size:12px;\">This email was sent by Dental Sleep Solutions&reg; on behalf of ".$ur['mailing_practice'].". ".DSS_EMAIL_FOOTER."</span></body></html>

";
}
$headers = 'From: SWsupport@dentalsleepsolutions.com' . "\r\n" .
                    'Content-type: text/html' ."\r\n" .
                    'Reply-To: SWsupport@dentalsleepsolutions.com' . "\r\n" .
                     'X-Mailer: PHP/' . phpversion();

                $subject = "Dental Sleep Solutions Account Activation";
//$_POST['email'] = "adambert@gmail.com";
                $mail = mail($_POST['email'], $subject, $m, $headers);
          echo '{"success":true}';
	}
    }else{
	echo '{"error":"email"}';
    }
?> 
