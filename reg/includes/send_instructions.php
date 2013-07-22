<?php
require_once '../../manage/admin/includes/main_include.php';
require_once '../../manage/includes/constants.inc';
$t = $_POST['type'];
    $s = "SELECT * FROM dental_patients WHERE email='".mysql_real_escape_string($_POST['email'])."'";
    $q = mysql_query($s);
    if(mysql_num_rows($q) > 0){
      $r = mysql_fetch_assoc($q);
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
                mysql_query($ins_sql);

    }else{
      $recover_hash = $r['recover_hash'];
    }
  $usql = "SELECT u.phone from dental_users u inner join dental_patients p on u.userid=p.docid where p.patientid='".mysql_real_escape_string($r['patientid'])."'";
  $uq = mysql_query($usql);
  $ur = mysql_fetch_assoc($uq);
  $n = $ur['phone'];

if($t == 'activate'){
  $m = "<html><body><center>
<table width='600'>
<tr><td colspan='2'><img alt='Dental Sleep Solutions' src='http://".$_SERVER['HTTP_HOST']."/reg/images/email/email_header.png' /></td></tr>
<tr><td width='400'>
<h2>Your New Account - A new patient account has been created for you</h2>
<p>Please click the following link to activate your account.</p>
<p><a href='http://".$_SERVER['HTTP_HOST']."/reg/activate.php?id=".$r['patientid']."&hash=".$recover_hash."'>http://".$_SERVER['HTTP_HOST']."/reg/activate.php?id=".$r['patientid']."&hash=".$recover_hash."</a></p>
</td><td><img alt='Dental Sleep Solutions' src='http://".$_SERVER['HTTP_HOST']."/reg/images/email/reg_logo.gif' /></td></tr>
<tr><td>
<h3>Didn't request this change or need assistance?</h3>
<p><b>Contact us at ".$n." or at<br>
patient@dentalsleepsolutions.com</b></p>
</td></tr>
<tr><td colspan='2'><img alt='www.dentalsleepsolutions.com' title='www.dentalsleepsolutions.com' src='http://".$_SERVER['HTTP_HOST']."/reg/images/email/email_footer.png' /></td></tr>
</table>
</center></body></html>
";
$m .= $email_footer;
}else{
  $m = "<html><body><center>
<table width='600'>
<tr><td colspan='2'><img alt='Dental Sleep Solutions' src='http://".$_SERVER['HTTP_HOST']."/reg/images/email/email_header.png' /></td></tr>
<tr><td width='400'>
<h2>Reset your password</h2><p>Please click the following link to reset your password.</p>
<p><a href='http://".$_SERVER['HTTP_HOST']."/reg/reset.php?id=".$r['patientid']."&hash=".$recover_hash."'>http://".$_SERVER['HTTP_HOST']."/reg/reset.php?id=".$r['patientid']."&hash=".$recover_hash."</a></p>
</td><td><img alt='Dental Sleep Solutions' src='http://".$_SERVER['HTTP_HOST']."/reg/images/email/reg_logo.gif' /></td></tr>
<tr><td>
<h3>Didn't request this change or need assistance?</h3>
<p><b>Contact us at ".$n." or at<br>
patient@dentalsleepsolutions.com</b></p></td></tr>
<tr><td colspan='2'><img alt='www.dentalsleepsolutions.com' title='www.dentalsleepsolutions.com' src='http://".$_SERVER['HTTP_HOST']."/reg/images/email/email_footer.png' /></td></tr>
</table>
</center></body></html>
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
