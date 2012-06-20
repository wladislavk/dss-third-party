<?php
include "includes/top.htm";
require_once('includes/dental_patient_summary.php');
require_once('admin/includes/password.php');

$docsql = "SELECT use_patient_portal FROM dental_users WHERE userid='".mysql_real_escape_string($_SESSION['docid'])."'";
$docq = mysql_query($docsql);
$docr = mysql_fetch_assoc($docq);
$doc_patient_portal = $docr['use_patient_portal'];

include "includes/similar.php";
function trigger_letter20($pid) {
  $letterid = '20';
  $md_list = get_mdcontactids($pid);
	$pt_referral_list = get_ptreferralids($pid);
  $letter = create_letter($letterid, $pid, '', '', $md_list, $pt_referral_list);
  if (!is_numeric($letter)) {
    print "Can't send letter 20: " . $letter;
    die();
  } else {
    return $letter;
  }
}

// Trigger Letter 20 Thankyou
$pt_referralid = get_ptreferralids($_GET['pid']);
if ($pt_referralid) {
	$sql = "SELECT letterid FROM dental_letters WHERE patientid = '".s_for($_GET['pid'])."' AND templateid = '20' AND md_referral_list = '".s_for($pt_referralid)."';";
	$result = mysql_query($sql);
	$numrows = mysql_num_rows($result);
	if ($numrows == 0) {
		trigger_letter20($_GET['pid']);
	}
}


?>
<script type="text/javascript" src="/manage/js/preferred_contact.js"></script>
<script type="text/javascript" src="/manage/js/patient_dob.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
		$(':input:not(#patient_search)').change(function() { 
			window.onbeforeunload = confirmExit;
		});
		$('#patientfrm').submit(function() {
			window.onbeforeunload = null;
		});
$('input,select').keypress(function() { return event.keyCode != 13; });
updateNumber('p_m_ins_phone');
updateNumber2('s_m_ins_phone');
	});
  function confirmExit()
  {
    return "You have attempted to leave this page.  If you have made any changes to the fields without clicking the Save button, your changes will be lost.  Are you sure you want to exit this page?";
  }
</script>
<?php
  /*=======================================================
	TRIGGERING LETTERS
  =======================================================*/
  // Trigger Letter 1 and 2 if New MD was added
  function trigger_letter1and2($pid) {
    $letter1id = "1";
    $letter2id = "2";
    $mdcontacts = array();
    $mdcontacts[] = $_POST['docsleep'];
    $mdcontacts[] = $_POST['docpcp'];
    $mdcontacts[] = $_POST['docdentist'];
    $mdcontacts[] = $_POST['docent'];
    $mdcontacts[] = $_POST['docmdother'];
    $recipients	= array();
    foreach ($mdcontacts as $contact) {
      if ($contact != "Not Set") {
        $letter_query = "SELECT md_list FROM dental_letters WHERE md_list IS NOT NULL AND CONCAT(',', md_list, ',') LIKE CONCAT('%,', '".$contact."', ',%') AND templateid IN(".$letter1id.",".$letter2id.");";
        $letter_result = mysql_query($letter_query);
        $num_rows = mysql_num_rows($letter_result);
        if(!$letter_result) {
          print "MYSQL ERROR:".mysql_errno().": ".mysql_error()."<br/>"."Error Selecting Letters from Database";
	  die();
        }
        if ($num_rows == 0 && $contact != "") {
  	  $recipients[] = $contact;
        }
      }
    } 
    if (count($recipients) > 0) {
      $recipients_list = implode(',', $recipients);
      $letter1 = create_letter($letter1id, $pid, '', '', $recipients_list);
      $letter2 = create_letter($letter2id, $pid, '', '', $recipients_list);
      if (!is_numeric($letter1)) {
        print $letter1;
        die();
      }
      if (!is_numeric($letter2)) {
        print $letter2;
        die();
      }
    }
  }

function trigger_letter3($pid) {
  $letterid = '3';
  $topatient = '1';
  $letter = create_letter($letterid, $pid, '', $topatient);
  if (!is_numeric($letter)) {
    print $letter;
    die();
  } else {
    return $letter;
  }
}

/*///////////////////////////
// sendRegEmail
//
// Sends registration email to patient
*/
function sendRegEmail($id, $e, $l, $old_email=''){
    $s = "SELECT * FROM dental_patients WHERE patientid='".mysql_real_escape_string($id)."'";
    $q = mysql_query($s);
      $r = mysql_fetch_assoc($q);
	if($r['recover_hash']=='' || $e!=$old_email){
                $recover_hash = hash('sha256', $r['patientid'].$r['email'].rand());
                $ins_sql = "UPDATE dental_patients set text_num=0, text_date=NOW(), access_code='', registration_senton=NOW(), registration_status=1, recover_hash='".$recover_hash."', recover_time=NOW() WHERE patientid='".$r['patientid']."'";
                mysql_query($ins_sql);
	}else{
		$ins_sql = "UPDATE dental_patients set registration_senton=NOW(), registration_status=1 WHERE patientid='".$r['patientid']."'";
                mysql_query($ins_sql);
		$recover_hash = $r['recover_hash'];
	}
  $usql = "SELECT u.phone from dental_users u inner join dental_patients p on u.userid=p.docid where p.patientid='".mysql_real_escape_string($r['patientid'])."'";
  $uq = mysql_query($usql);
  $ur = mysql_fetch_assoc($uq);
  $n = $ur['phone'];
  $from = "SWsupport@dentalsleepsolutions.com";
$mime_boundary = 'Multipart_Boundary_x'.md5(time()).'x';
	$headers  = "MIME-Version: 1.0\r\n";
	$headers .= "Content-Type: multipart/alternative; boundary=\"$mime_boundary\"\r\n";
	$headers .= "Content-Transfer-Encoding: 7bit\r\n";
	$body	=  "";
	$body	.= "--$mime_boundary\n";
	$body	.= "Content-Type: text/plain; charset=\"iso-8859-1\"\n";
	$body	.= "Content-Transfer-Encoding: 7bit\n\n";
	$body	.= "A message from Dental Sleep Solutions

Your New Account
A new patient account has been created for you.
Your Patient Portal login information is:
Email: ".$e."

Save Time - Complete Your Paperwork Online

Click the link below to log in and complete your patient forms online. Paperless forms take only a few minutes to complete and let you avoid unnecessary waiting during your next visit. Saving tre
es is good too!

Click Here to Complete Your Forms Online (http://".$_SERVER['HTTP_HOST']."/reg/activate.php?id=".$r['patientid']."&hash=".$recover_hash.")

Need Assistance?
Contact us at ".$n." or at patient@dentalsleepsolutions.com
"; 
	$body	.= "\n\n";

	$body	.= "--$mime_boundary\n";
	$body	.= "Content-Type: text/html; charset=\"UTF-8\"\n";
	$body	.= "Content-Transfer-Encoding: 7bit\n\n";
	$body	.= "<html><body><center>
<table width='600'>
<tr><td colspan='2'><img alt='A message from Dental Sleep Solutions' src='".$_SERVER['HTTP_HOST']."/reg/images/email/email_header.png' /></td></tr>
<tr><td width='400'>
<h2>Your New Account</h2>
<p>A new patient account has been created for you.<br />Your Patient Portal login information is:</p>
<p><b>Email:</b> ".$e."</p>
</td><td><img alt='Dental Sleep Solutions' src='".$_SERVER['HTTP_HOST']."/reg/images/email/reg_logo.gif' /></td></tr>
<tr><td colspan='2'>
<center>
<h2>Save Time - Complete Your Paperwork Online</h2>
</center>
<p>Click the link below to log in and complete your patient forms online. Paperless forms take only a few minutes to complete and let you avoid unnecessary waiting during your next visit. Saving trees is good too!</p>
<center><h3><a href='http://".$_SERVER['HTTP_HOST']."/reg/activate.php?id=".$r['patientid']."&hash=".$recover_hash."'>Click Here to Complete Your Forms Online</a></h3></center>
</td></tr>
<tr><td>
<h3>Need Assistance?</h3>
<p><b>Contact us at ".$n." or at<br>
patient@dentalsleepsolutions.com</b></p>
</td></tr>
<tr><td colspan='2'><img alt='www.dentalsleepsolutions.com' title='www.dentalsleepsolutions.com' src='".$_SERVER['HTTP_HOST']."/reg/images/email/email_footer.png' /></td></tr>
</table>
</center></body></html>";
	$body	.= "\n\n";
	// End email
	$body	.= "--$mime_boundary--\n";

	# Finish off headers
	$headers .= "From: ".$from."\r\n";
	$headers .= "X-Sender-IP: $_SERVER[SERVER_ADDR]\r\n";
	$headers .= 'Date: '.date('n/d/Y g:i A')."\r\n";

$headers = 'From: "Dental Sleep Solutions" <Patient@dentalsleepsolutions.com>' . "\n"; 
        $headers .= "MIME-Version: 1.0\n";
        $headers .= "Content-Type: multipart/alternative; boundary=\"$mime_boundary\"\n";
        $headers .= "Content-Transfer-Encoding: 7bit\n";
        $headers .= 'X-Mailer: PHP/' . phpversion();

                $subject = "Dental Sleep Solutions Registration";

                mail($e, $subject, $body, $headers);
}

/*///////////////////////////
// sendRemEmail
//
// Sends reminder email to patient
*/
function sendRemEmail($id, $e){
  $usql = "SELECT u.phone from dental_users u inner join dental_patients p on u.userid=p.docid where p.patientid='".mysql_real_escape_string($id)."'";
  $uq = mysql_query($usql);
  $ur = mysql_fetch_assoc($uq);
  $n = $ur['phone'];
  $m = "<html><body><center>
<table width='600'>
<tr><td colspan='2'><img alt='A message from Dental Sleep Solutions' src='".$_SERVER['HTTP_HOST']."/reg/images/email/email_header.png' /></td></tr>
<tr><td width='400'>
<h2>Your New Account</h2>
<p>A new patient account has been created for you.<br />Your Patient Portal login information is:</p>
<p><b>Email:</b> ".$e."</p>
</td><td><img alt='Dental Sleep Solutions' src='".$_SERVER['HTTP_HOST']."/reg/images/email/reg_logo.gif' /></td></tr>
<tr><td colspan='2'>
<center>
<h2>Save Time - Complete Your Paperwork Online</h2>
</center>
<p>Click the link below to log in and complete your patient forms online. Paperless forms take only a few minutes to complete and let you avoid unnecessary waiting during your next visit. Saving
 trees is good too!</p>
<center><h3><a href='http://".$_SERVER['HTTP_HOST']."/reg/login.php?email=".str_replace('+', '%2B', $e)."'>Click Here to Complete Your Forms Online</a></h3></center>
</td></tr>
<tr><td>
<h3>Need Assistance?</h3>
<p><b>Contact us at ".$n." or at<br>
patient@dentalsleepsolutions.com</b></p>
</td></tr>
<tr><td colspan='2'><img alt='www.dentalsleepsolutions.com' title='www.dentalsleepsolutions.com' src='".$_SERVER['HTTP_HOST']."/reg/images/email/email_footer.png' /></td></tr>
</table>
</center></body></html>
";


$headers = 'From: SWsupport@dentalsleepsolutions.com' . "\r\n" .
                    'Content-type: text/html' ."\r\n" .
                    'Reply-To: SWsupport@dentalsleepsolutions.com' . "\r\n" .
                     'X-Mailer: PHP/' . phpversion();

                $subject = "Dental Sleep Solutions Registration";

                mail($e, $subject, $m, $headers);
}



/*==========================================
  	FORM SUBMISSION
==========================================*/
if($_POST["patientsub"] == 1)
{
	$use_patient_portal = $_POST['use_patient_portal'];
	if($_POST["ed"] != "") //existing patient (update)
	{
		$s_sql = "SELECT referred_by, referred_source, email, password, registration_status FROM dental_patients
			WHERE patientid=".mysql_real_escape_string($_GET['pid']);
		$s_q = mysql_query($s_sql);
		$s_r = mysql_fetch_assoc($s_q);
		$old_referred_by = $s_r['referred_by'];
		$old_referred_source = $s_r['referred_source'];
		if($s_r['registration_status']==2 && $_POST['email'] != $s_r['email']){ //if registered attempt to send update email
			sendUpdatedEmail($_GET['pid'], $_POST['email'], $s_r['email'], 'doc');
		}elseif(isset($_POST['sendRem'])){ 
			  sendRemEmail($_POST['ed'], $_POST['email']); //send reminder email
		}elseif(!isset($_POST['sendReg']) && $s_r['registration_status']==1 && trim($_POST['email']) != trim($s_r['email'])){
			if($doc_patient_portal && $use_patient_portal){
			  sendRegEmail($_POST['ed'], $_POST['email'], ''); //send reg email if email is updated and not registered 
			}
		}
		$ed_sql = "update dental_patients 
		set 
		firstname = '".s_for($_POST["firstname"])."', 
		lastname = '".s_for($_POST["lastname"])."', 
		middlename = '".s_for($_POST["middlename"])."', 
                preferred_name = '".s_for($_POST["preferred_name"])."',
		salutation = '".s_for($_POST["salutation"])."',
    member_no = '".s_for($_POST['member_no'])."',
	  group_no = '".s_for($_POST['group_no'])."',
	  plan_no = '".s_for($_POST["plan_no"])."', 
		add1 = '".s_for($_POST["add1"])."', 
		add2 = '".s_for($_POST["add2"])."', 
		city = '".s_for($_POST["city"])."', 
		state = '".s_for($_POST["state"])."', 
		zip = '".s_for($_POST["zip"])."', 
		dob = '".s_for($_POST["dob"])."', 
		gender = '".s_for($_POST["gender"])."', 
		marital_status = '".s_for($_POST["marital_status"])."', 
		ssn = '".s_for(num($_POST["ssn"], false))."', 
		feet= '".s_for($_POST['feet'])."',
                inches= '".s_for($_POST['inches'])."',
                weight= '".s_for($_POST['weight'])."',
                bmi= '".s_for($_POST['bmi'])."',
		home_phone = '".s_for(num($_POST["home_phone"]))."', 
		work_phone = '".s_for(num($_POST["work_phone"]))."', 
		cell_phone = '".s_for(num($_POST["cell_phone"]))."', 
		best_time = '".s_for($_POST["best_time"])."',
		best_number = '".s_for($_POST["best_number"])."',
		email = '".s_for($_POST["email"])."', 
		patient_notes = '".s_for($_POST["patient_notes"])."', 
		p_d_party = '".s_for($_POST["p_d_party"])."', 
		p_d_relation = '".s_for($_POST["p_d_relation"])."', 
		p_d_other = '".s_for($_POST["p_d_other"])."', 
		p_d_employer = '".s_for($_POST["p_d_employer"])."', 
		p_d_ins_co = '".s_for($_POST["p_d_ins_co"])."', 
		p_d_ins_id = '".s_for($_POST["p_d_ins_id"])."', 
		s_d_party = '".s_for($_POST["s_d_party"])."', 
		s_d_relation = '".s_for($_POST["s_d_relation"])."', 
		s_d_other = '".s_for($_POST["s_d_other"])."', 
		s_d_employer = '".s_for($_POST["s_d_employer"])."', 
		s_d_ins_co = '".s_for($_POST["s_d_ins_co"])."', 
		s_d_ins_id = '".s_for($_POST["s_d_ins_id"])."', 
		p_m_partyfname = '".s_for($_POST["p_m_partyfname"])."',
		p_m_partymname = '".s_for($_POST["p_m_partymname"])."',
		p_m_partylname = '".s_for($_POST["p_m_partylname"])."',
    p_m_ins_grp = '".s_for($_POST["p_m_ins_grp"])."',
    s_m_ins_grp = '".s_for($_POST["s_m_ins_grp"])."',
    p_m_dss_file = '".s_for($_POST["p_m_dss_file"])."',
    s_m_dss_file = '".s_for($_POST["s_m_dss_file"])."',
    p_m_ins_type = '".s_for($_POST["p_m_ins_type"])."',
    s_m_ins_type = '".s_for($_POST["s_m_ins_type"])."',
    p_m_ins_ass = '".s_for($_POST["p_m_ins_ass"])."',
    s_m_ins_ass = '".s_for($_POST["s_m_ins_ass"])."',
    ins_dob = '".s_for($_POST["ins_dob"])."',
    ins2_dob = '".s_for($_POST["ins2_dob"])."',
    p_m_relation = '".s_for($_POST["p_m_relation"])."', 
		p_m_other = '".s_for($_POST["p_m_other"])."', 
		p_m_employer = '".s_for($_POST["p_m_employer"])."', 
		p_m_ins_co = '".s_for($_POST["p_m_ins_co"])."', 
		p_m_ins_id = '".s_for($_POST["p_m_ins_id"])."', 
		has_s_m_ins = '".s_for($_POST["s_m_ins"])."',
		s_m_partyfname = '".s_for($_POST["s_m_partyfname"])."',
    s_m_partymname = '".s_for($_POST["s_m_partymname"])."',
    s_m_partylname = '".s_for($_POST["s_m_partylname"])."', 
		s_m_relation = '".s_for($_POST["s_m_relation"])."', 
		s_m_other = '".s_for($_POST["s_m_other"])."', 
		s_m_employer = '".s_for($_POST["s_m_employer"])."', 
		s_m_ins_co = '".s_for($_POST["s_m_ins_co"])."', 
		s_m_ins_id = '".s_for($_POST["s_m_ins_id"])."',
		p_m_ins_plan = '".s_for($_POST["p_m_ins_plan"])."',
    s_m_ins_plan = '".s_for($_POST["s_m_ins_plan"])."', 
		employer = '".s_for($_POST["employer"])."', 
		emp_add1 = '".s_for($_POST["emp_add1"])."', 
		emp_add2 = '".s_for($_POST["emp_add2"])."', 
		emp_city = '".s_for($_POST["emp_city"])."', 
		emp_state = '".s_for($_POST["emp_state"])."', 
		emp_zip = '".s_for($_POST["emp_zip"])."', 
		emp_phone = '".s_for(num($_POST["emp_phone"]))."', 
		emp_fax = '".s_for(num($_POST["emp_fax"]))."', 
		plan_name = '".s_for($_POST["plan_name"])."', 
		group_number = '".s_for($_POST["group_number"])."', 
		ins_type = '".s_for($_POST["ins_type"])."', 
		accept_assignment = '".s_for($_POST["accept_assignment"])."', 
		print_signature = '".s_for($_POST["print_signature"])."', 
		medical_insurance = '".s_for($_POST["medical_insurance"])."', 
		mark_yes = '".s_for($_POST["mark_yes"])."',
    inactive = '".s_for($_POST["inactive"])."',
    partner_name = '".s_for($_POST["partner_name"])."',
    docsleep = '".s_for($_POST["docsleep"])."',
    docpcp = '".s_for($_POST["docpcp"])."',
    mark_yes = '".s_for($_POST["mark_yes"])."',
    docdentist = '".s_for($_POST["docdentist"])."',
    docent = '".s_for($_POST["docent"])."',
    docmdother = '".s_for($_POST["docmdother"])."',
    emergency_name = '".s_for($_POST["emergency_name"])."',
    emergency_relationship = '".s_for($_POST["emergency_relationship"])."',
    emergency_number = '".s_for(num($_POST["emergency_number"]))."',
    docent = '".s_for($_POST["docent"])."',
		emergency_name = '".s_for($_POST["emergency_name"])."',
		emergency_number = '".s_for(num($_POST["emergency_number"]))."',
		referred_source = '".s_for($_POST["referred_source"])."',
		referred_by = '".s_for($_POST["referred_by"])."',
		referred_notes = '".s_for($_POST["referred_notes"])."',
		copyreqdate = '".s_for($_POST["copyreqdate"])."',
		status = '".s_for($_POST["status"])."',
		use_patient_portal = '".s_for($_POST["use_patient_portal"])."',
		preferredcontact = '".s_for($_POST["preferredcontact"])."'
		where 
		patientid='".$_POST["ed"]."'";
		mysql_query($ed_sql) or die($ed_sql." | ".mysql_error());
	        mysql_query("UPDATE dental_patients set email='".mysql_real_escape_string($_POST['email'])."' WHERE parent_patientid='".mysql_real_escape_string($_POST["ed"])."'");	
	
		if(isset($_POST['location'])){
			$loc_query = "UPDATE dental_summary SET location='".mysql_real_escape_string($_POST['location'])."' WHERE patientid='".$_GET['pid']."';";
			mysql_query($loc_query);
		}

		$lsql = "SELECT login, password, registration_status FROM dental_patients WHERE patientid='".mysql_real_escape_string($_POST['ed'])."'";
		$lq = mysql_query($lsql);
		$l = mysql_fetch_assoc($lq);
		$login = $l['login'];
		$pass = $l['password'];
		if($login == ''){
	                $clogin = strtolower(substr($_POST["firstname"],0,1).$_POST["lastname"]);
        	        $csql = "SELECT login FROM dental_patients WHERE login LIKE '".$clogin."%'";
                	$cq = mysql_query($csql);
	                $carray = array();
        	        while($c = mysql_fetch_assoc($cq)){
                	        array_push($carray, $c['login']);
                	}
                	if(in_array($clogin, $carray)){
                  	  	$count = 1;
                  		while(in_array($clogin.$count, $carray)){
                    			$count++;
                 	 	}
                  		$login = strtolower($clogin.$count);
                	}else{
                  		$login = strtolower($clogin);
                	}
			$ilsql = "UPDATE dental_patients set login='".mysql_real_escape_string($login)."'  WHERE patientid='".mysql_real_escape_string($_POST['ed'])."'";
			mysql_query($ilsql);
		}
		if(isset($_POST['sendReg']) && $doc_patient_portal && $_POST['use_patient_portal']){
		if(trim($_POST['email'])!='' && trim($_POST['cell_phone'])!=''){
			sendRegEmail($_POST['ed'], $_POST['email'], $login, $s_r['email']); 
		}else{
			?><script type="text/javascript">alert('Unable to send registration email because no cell_phone is set. Please enter a cell_phone and try again.');</script><?php
		}
		}

	$s1 = "UPDATE dental_flow_pg2_info SET date_completed = '".date('Y-m-d', strtotime($_POST['copyreqdate']))."' WHERE patientid='".$_POST['ed']."' AND stepid='1';";
mysql_query($s1);
	
		if($old_referred_by != $_POST["referred_by"] || $old_referred_source != $_POST["referred_source"]){
			if($_POST['referred_by']){
				$sql = "UPDATE dental_letters SET md_referral_list=".$_POST["referred_by"]." WHERE patientid=".mysql_real_escape_string($_POST['ed'])."";
			}else{
				$sql = "DELETE FROM dental_letters where patientid=".mysql_real_escape_string($_POST['ed'])." AND (topatient=0 OR topatient IS NULL) AND (md_list = '' OR md_list IS NULL)";
			}
			mysql_query($sql);
		}

		trigger_letter1and2($_POST['ed']);

		if($_POST['introletter'] == 1) {
		  trigger_letter3($_POST['ed']);
		}

		if(isset($_POST['add_ref_but'])) {
			?>
			<script type="text/javascript">
			window.location = "add_referredby.php?addtopat=<?php echo $_GET['pid']; ?>";
			</script>
			<?php
		}


		if(isset($_POST['add_ins_but'])) {
			?>
			<script type="text/javascript">
			window.location = "add_contact.php?ctype=ins<?php if(isset($_GET['pid'])){echo "&pid=".$_GET['pid']."&type=11&ctypeeq=1&activePat=".$_GET['pid'];} ?>";
			</script>
			<?php
		}

		if(isset($_POST['add_contact_but'])) {
			?>
			<script type="text/javascript">
			window.location = "add_patient_to.php?ed=<?php echo $_GET['pid']; ?>";
			</script>
			<?php
		}

		//echo $ed_sql.mysql_error();
		$msg = "Edited Successfully";
		?>
		<script type="text/javascript">
			//alert("<?=$msg;?>");
			parent.window.location='add_patient.php?ed=<?= $_GET['pid']; ?>&preview=1&addtopat=1&pid=<?= $_GET['pid']; ?>&msg=<?=$msg;?>';
		</script>
		<?
		die();
	}
	else
	{
        //echo('in');
		$clogin = strtolower(substr($_POST["firstname"],0,1).$_POST["lastname"]);
		$csql = "SELECT login FROM dental_patients WHERE login LIKE '".$clogin."%'";
		$cq = mysql_query($csql);
		$carray = array();
		while($c = mysql_fetch_assoc($cq)){
			array_push($carray, $c['login']);
		}
		if(in_array($clogin, $carray)){
		  $count = 1;
		  while(in_array($clogin.$count, $carray)){
		    $count++;
		  }
		  $login = strtolower($clogin.$count);
		}else{
		  $login = strtolower($clogin);
		}
		
		if($_POST['ssn']!=''){
			$salt = create_salt();
			$p = preg_replace('/\D/', '', $_POST['ssn']);
                	$password = gen_password($p , $salt);
		}else{
			$salt = '';
			$password = '';
		}
		$ins_sql = "insert 
		into 
		dental_patients 
		set 
		firstname = '".s_for($_POST["firstname"])."', 
		lastname = '".s_for($_POST["lastname"])."', 
		middlename = '".s_for($_POST["middlename"])."', 
                preferred_name = '".s_for($_POST["preferred_name"])."',
		login = '".$login."',
		salt = '".$salt."',
		password = '".$password."',
		salutation = '".s_for($_POST["salutation"])."',
    member_no = '".s_for($_POST['member_no'])."',
	  group_no = '".s_for($_POST['group_no'])."',
	  plan_no = '".s_for($_POST["plan_no"])."',  
		add1 = '".s_for($_POST["add1"])."', 
		add2 = '".s_for($_POST["add2"])."', 
		city = '".s_for($_POST["city"])."', 
		state = '".s_for($_POST["state"])."', 
		zip = '".s_for($_POST["zip"])."', 
		dob = '".s_for($_POST["dob"])."', 
		gender = '".s_for($_POST["gender"])."', 
		marital_status = '".s_for($_POST["marital_status"])."', 
		ssn = '".s_for(num($_POST["ssn"], false))."', 
                feet= '".s_for($_POST['feet'])."',
                inches= '".s_for($_POST['inches'])."',
                weight= '".s_for($_POST['weight'])."',
                bmi= '".s_for($_POST['bmi'])."',
		home_phone = '".s_for(num($_POST["home_phone"]))."', 
		work_phone = '".s_for(num($_POST["work_phone"]))."', 
		cell_phone = '".s_for(num($_POST["cell_phone"]))."', 
                best_time = '".s_for($_POST["best_time"])."',
                best_number = '".s_for($_POST["best_number"])."',
		email = '".s_for($_POST["email"])."', 
		patient_notes = '".s_for($_POST["patient_notes"])."', 
		p_d_party = '".s_for($_POST["p_d_party"])."', 
		p_d_relation = '".s_for($_POST["p_d_relation"])."', 
		p_d_other = '".s_for($_POST["p_d_other"])."', 
		p_d_employer = '".s_for($_POST["p_d_employer"])."', 
		p_d_ins_co = '".s_for($_POST["p_d_ins_co"])."', 
		p_d_ins_id = '".s_for($_POST["p_d_ins_id"])."', 
		s_d_party = '".s_for($_POST["s_d_party"])."', 
		s_d_relation = '".s_for($_POST["s_d_relation"])."', 
		s_d_other = '".s_for($_POST["s_d_other"])."', 
		s_d_employer = '".s_for($_POST["s_d_employer"])."', 
		s_d_ins_co = '".s_for($_POST["s_d_ins_co"])."', 
		s_d_ins_id = '".s_for($_POST["s_d_ins_id"])."', 
		p_m_partyfname = '".s_for($_POST["p_m_partyfname"])."',
    p_m_partymname = '".s_for($_POST["p_m_partymname"])."',
    p_m_partylname = '".s_for($_POST["p_m_partylname"])."',  
		p_m_relation = '".s_for($_POST["p_m_relation"])."', 
		p_m_other = '".s_for($_POST["p_m_other"])."', 
		p_m_employer = '".s_for($_POST["p_m_employer"])."', 
		p_m_ins_co = '".s_for($_POST["p_m_ins_co"])."', 
		p_m_ins_id = '".s_for($_POST["p_m_ins_id"])."', 
		has_s_m_ins = '".s_for($_POST["s_m_ins"])."',
		s_m_partyfname = '".s_for($_POST["s_m_partyfname"])."',
    s_m_partymname = '".s_for($_POST["s_m_partymname"])."',
    s_m_partylname = '".s_for($_POST["s_m_partylname"])."',  
		s_m_relation = '".s_for($_POST["s_m_relation"])."', 
		s_m_other = '".s_for($_POST["s_m_other"])."', 
		s_m_employer = '".s_for($_POST["s_m_employer"])."', 
		s_m_ins_co = '".s_for($_POST["s_m_ins_co"])."', 
		s_m_ins_id = '".s_for($_POST["s_m_ins_id"])."',
    p_m_ins_grp = '".s_for($_POST["p_m_ins_grp"])."',
    s_m_ins_grp = '".s_for($_POST["s_m_ins_grp"])."',
    p_m_dss_file = '".s_for($_POST["p_m_dss_file"])."',
    s_m_dss_file = '".s_for($_POST["s_m_dss_file"])."',
    p_m_ins_type = '".s_for($_POST["p_m_ins_type"])."',
    s_m_ins_type = '".s_for($_POST["s_m_ins_type"])."',
    p_m_ins_ass = '".s_for($_POST["p_m_ins_ass"])."',
    s_m_ins_ass = '".s_for($_POST["s_m_ins_ass"])."',
    p_m_ins_plan = '".s_for($_POST["p_m_ins_plan"])."',
    s_m_ins_plan = '".s_for($_POST["s_m_ins_plan"])."',
    ins_dob = '".s_for($_POST["ins_dob"])."',
    ins2_dob = '".s_for($_POST["ins2_dob"])."', 
		employer = '".s_for($_POST["employer"])."', 
		emp_add1 = '".s_for($_POST["emp_add1"])."', 
		emp_add2 = '".s_for($_POST["emp_add2"])."', 
		emp_city = '".s_for($_POST["emp_city"])."', 
		emp_state = '".s_for($_POST["emp_state"])."', 
		emp_zip = '".s_for($_POST["emp_zip"])."', 
		emp_phone = '".s_for(num($_POST["emp_phone"]))."', 
		emp_fax = '".s_for(num($_POST["emp_fax"]))."', 
		plan_name = '".s_for($_POST["plan_name"])."', 
		group_number = '".s_for($_POST["group_number"])."', 
		ins_type = '".s_for($_POST["ins_type"])."', 
		accept_assignment = '".s_for($_POST["accept_assignment"])."', 
		print_signature = '".s_for($_POST["print_signature"])."', 
		medical_insurance = '".s_for($_POST["medical_insurance"])."', 
		mark_yes = '".s_for($_POST["mark_yes"])."', 
		inactive = '".s_for($_POST["inactive"])."',
    docsleep = '".s_for($_POST["docsleep"])."',
		docpcp = '".s_for($_POST["docpcp"])."',
		docdentist = '".s_for($_POST["docdentist"])."',
		docent = '".s_for($_POST["docent"])."',
		docmdother = '".s_for($_POST["docmdother"])."', 
		partner_name = '".s_for($_POST["partner_name"])."', 
		emergency_name = '".s_for($_POST["emergency_name"])."',
    emergency_relationship = '".s_for($_POST["emergency_relationship"])."',
		emergency_number = '".s_for(num($_POST["emergency_number"]))."',
		referred_source = '".s_for($_POST["referred_source"])."',
		referred_by = '".s_for($_POST["referred_by"])."',
		referred_notes = '".s_for($_POST["referred_notes"])."',
		copyreqdate = '".s_for($_POST["copyreqdate"])."',
		userid='".$_SESSION['userid']."', 
		docid='".$_SESSION['docid']."', 
		status = '".s_for($_POST["status"])."',
		use_patient_portal = '".s_for($_POST["use_patient_portal"])."',
		adddate=now(),
		ip_address='".$_SERVER['REMOTE_ADDR']."',
		preferredcontact='".s_for($_POST["preferredcontact"])."';";
		mysql_query($ins_sql) or die($ins_sql.mysql_error());

		if(isset($_POST['location'])){
                	$loc_query = "UPDATE dental_summary SET location='".mysql_real_escape_string($_POST['location'])."' WHERE patientid='".$_GET['pid']."';";
                	mysql_query($loc_query);
		}

                $pid = mysql_insert_id();
   		trigger_letter1and2($pid);

                if(isset($_POST['sendReg'])&& $doc_patient_portal && $_POST["use_patient_portal"]){
                if(trim($_POST['email'])!='' && trim($_POST['cell_phone'])!=''){
                        sendRegEmail($pid, $_POST['email'], $login);
                }else{
                        ?><script type="text/javascript">alert('Unable to send registration email because no cell_phone is set. Please enter a cell_phone and try again.');</script><?php
                }
                }

		if($_POST['introletter'] == 1) {
		  trigger_letter3($pid);
		}
      $flowinsertqry = "INSERT INTO dental_flow_pg1 (`id`,`copyreqdate`,`pid`) VALUES (NULL,'".s_for($_POST["copyreqdate"])."','".$pid."');";
      $flowinsert = mysql_query($flowinsertqry);
      if(!$flowinsert){
        //$message = "MYSQL ERROR:".mysql_errno().": ".mysql_error()."<br/>"."Error inserting flowsheet record, please try again!1";
      }else{
        $referred_result = mysql_query($referredbyqry);
        $message = "Successfully updated flowsheet!2";
      }


      $stepid = '1';
      $segmentid = '1';
      $scheduled = strtotime($copyreqdate);
      $gen_date = date('Y-m-d H:i:s', strtotime($_POST["copyreqdate"]));
      $steparray_query = "INSERT INTO dental_flow_pg2 (`patientid`, `steparray`) VALUES ('".$pid."', '".$segmentid."');";
      $flow_pg2_info_query = "INSERT INTO dental_flow_pg2_info (`patientid`, `stepid`, `segmentid`, `date_scheduled`, `date_completed`) VALUES ('".$pid."', '".$stepid."', '".$segmentid."', '".$scheduled."', '".$gen_date."');";
      $steparray_insert = mysql_query($steparray_query);
      if (!$steparray_insert) {
        $message = "MYSQL ERROR:".mysql_errno().": ".mysql_error()."<br/>"."Error inserting Initial Contact to Flowsheet Page 2";
      }
      $flow_pg2_info_insert = mysql_query($flow_pg2_info_query);
      if (!$flow_pg2_info_insert) {
        $message = "MYSQL ERROR:".mysql_errno().": ".mysql_error()."<br/>"."Error inserting Initial Contact Information to Flowsheet Page 2";
      }

		$sim = similar_patients($pid);
                        if(count($sim) > 0){
                ?>
                <script type="text/javascript">
                        parent.window.location='duplicate_patients.php?pid=<?= $pid; ?>';
                </script>
                <?
                die();

		}else{
		$msg = "Patient ".$_POST["firstname"]." ".$_POST["lastname"]." added Successfully";
		?>
		<script type="text/javascript">
			alert("<?=$msg;?>");
			parent.window.location='add_patient.php?pid=<?= $pid; ?>&ed=<?=$pid; ?>&addtopat=1';
		</script>
		<?
		die();
		}
	}

}

?>


    <?
    $thesql = "select * from dental_patients where patientid='".$_REQUEST["ed"]."'";
	$themy = mysql_query($thesql);
	$themyarray = mysql_fetch_array($themy);
	
	if($msg != '')
	{
		$firstname = $_POST['firstname'];
		$middlename = $_POST['middlename'];
		$lastname = $_POST['lastname'];
                $preferred_name = $_POST['preferred_name'];
		$salutation = $_POST['salutation'];
		$login = $_POST['login'];
		$member_no = $_POST['member_no'];
	  $group_no = $_POST['group_no'];
	  $plan_no = $_POST['plan_no'];
		$dob = $_POST['dob'];
		$add1 = $_POST['add1'];
		$add2= $_POST['add2'];
		$city = $_POST['city'];
		$state = $_POST['state'];
		$zip = $_POST['zip'];
		$gender = $_POST['gender'];
		$marital_status = $_POST['marital_status'];
		$ssn = $_POST['ssn'];
		$feet = $_POST['feet'];
                $inches = $_POST['inches'];
                $weight = $_POST['weight'];
                $bmi = $_POST['bmi'];
		$home_phone = $_POST['home_phone'];
		$work_phone = $_POST['work_phone'];
		$cell_phone = $_POST['cell_phone'];
		$best_time = $_POST['best_time'];
		$best_number = $_POST['best_number'];
		$email = $_POST['email'];
		$patient_notes = $_POST['patient_notes'];
		$p_d_party = $_POST["p_d_party"]; 
		$p_d_relation = $_POST["p_d_relation"];
		$p_d_other = $_POST["p_d_other"];
		$p_d_employer = $_POST["p_d_employer"];
		$p_d_ins_co = $_POST["p_d_ins_co"];
		$p_d_ins_id = $_POST["p_d_ins_id"];
		$s_d_party = $_POST["s_d_party"]; 
		$s_d_relation = $_POST["s_d_relation"];
		$s_d_other = $_POST["s_d_other"];
		$s_d_employer = $_POST["s_d_employer"];
		$s_d_ins_co = $_POST["s_d_ins_co"];
		$s_d_ins_id = $_POST["s_d_ins_id"];
		$p_m_partyfname = $_POST["p_m_partyfname"];
    $p_m_partymname = $_POST["p_m_partymname"];
		$p_m_partylname = $_POST["p_m_partylname"]; 
		$p_m_relation = $_POST["p_m_relation"];
		$p_m_other = $_POST["p_m_other"];
		$p_m_employer = $_POST["p_m_employer"];
		$p_m_ins_co = $_POST["p_m_ins_co"];
		$p_m_ins_id = $_POST["p_m_ins_id"];
		$has_s_m_ins = $_POST["s_m_ins"];
		$s_m_partyfname = $_POST["s_m_partyfname"];
    $s_m_partymname = $_POST["s_m_partymname"];
		$s_m_partylname = $_POST["s_m_partylname"];  
		$s_m_relation = $_POST["s_m_relation"];
		$s_m_other = $_POST["s_m_other"];
		$s_m_employer = $_POST["s_m_employer"];
		$s_m_ins_co = $_POST["s_m_ins_co"];
		$s_m_ins_id = $_POST["s_m_ins_id"];
		$p_m_ins_grp = $_POST["p_m_ins_grp"];
    $s_m_ins_grp = $_POST["s_m_ins_grp"];
    $p_m_dss_file = $_POST["p_m_dss_file"];
    $s_m_dss_file = $_POST["s_m_dss_file"];
    $p_m_ins_type = $_POST["p_m_ins_type"];
    $s_m_ins_type = $_POST["s_m_ins_type"];
    $p_m_ins_ass = $_POST["p_m_ins_ass"];
    $s_m_ins_ass = $_POST["s_m_ins_ass"];
    $p_m_ins_plan = $_POST["p_m_ins_plan"];
    $s_m_ins_plan = $_POST["s_m_ins_plan"];
    $ins_dob = $_POST["ins_dob"];
    $ins2_dob = $_POST["ins2_dob"];
		$employer = $_POST["employer"];
		$emp_add1 = $_POST["emp_add1"];
		$emp_add2 = $_POST["emp_add2"];
		$emp_city = $_POST["emp_city"];
		$emp_state = $_POST["emp_state"];
		$emp_zip = $_POST["emp_zip"];
		$emp_phone = $_POST["emp_phone"];
		$docsleep = $_POST["docsleep"];
		$docpcp = $_POST["docpcp"];
		$docdentist = $_POST["docdentist"];
		$docent = $_POST["docent"];
		$docmdother = $_POST["docmdother"];
		$emp_fax = $_POST["emp_fax"];
		$plan_name = $_POST["plan_name"];
		$group_number = $_POST["group_number"];
		$ins_type = $_POST["ins_type"];
		$status = $_POST["status"];
		$use_patient_portal = $_POST["use_patient_portal"];
		$accept_assignment = $_POST["accept_assignment"];
		$print_signature = $_POST["print_signature"];
		$medical_insurance = $_POST["medical_insurance"];
		$mark_yes = $_POST["mark_yes"];
		$inactive = $_POST["inactive"];
		$partner_name = $_POST["partner_name"];
		$emergency_name = $_POST["emergency_name"];
    		$emergency_relationship = $_POST["emergency_relationship"];
		$emergency_number = $_POST["emergency_number"];
		$referred_source = $_POST["referred_source"];
		$referred_by = $_POST["referred_by"];
		$referred_notes = $_POST["referred_notes"];
		$copyreqdate = $_POST["copyreqdate"];
		$preferredcontact = $_POST["preferredcontact"];
		$location = $_POST["location"];
		
	}
	else
	{
		$firstname = st($themyarray['firstname']);
		$middlename = st($themyarray['middlename']);
		$lastname = st($themyarray['lastname']);
                $preferred_name = st($themyarray['preferred_name']);
		$salutation = st($themyarray['salutation']);
		$login = st($themyarray['login']);
			$member_no = st($themyarray['member_no']);
	$group_no = st($themyarray['group_no']);
	$plan_no = st($themyarray['plan_no']);
		$dob = st($themyarray['dob']);
		$add1 = st($themyarray['add1']);
		$add2 = st($themyarray['add2']);
		$city = st($themyarray['city']);
		$state = st($themyarray['state']);
		$zip = st($themyarray['zip']);
		$gender = st($themyarray['gender']);
		$marital_status = st($themyarray['marital_status']);
		$ssn = st($themyarray['ssn']);
                $feet = st($themyarray['feet']);
                $inches = st($themyarray['inches']);
                $weight = st($themyarray['weight']);
                $bmi = st($themyarray['bmi']);
		$home_phone = st($themyarray['home_phone']);
		$work_phone = st($themyarray['work_phone']);
		$cell_phone = st($themyarray['cell_phone']);
		$best_time = st($themyarray['best_time']);
		$best_number = st($themyarray['best_number']);
		$email = st($themyarray['email']);
		$patient_notes = st($themyarray['patient_notes']);
		$p_d_party = st($themyarray["p_d_party"]); 
		$p_d_relation = st($themyarray["p_d_relation"]);
		$p_d_other = st($themyarray["p_d_other"]);
		$p_d_employer = st($themyarray["p_d_employer"]);
		$p_d_ins_co = st($themyarray["p_d_ins_co"]);
		$p_d_ins_id = st($themyarray["p_d_ins_id"]);
		$s_d_party = st($themyarray["s_d_party"]); 
		$s_d_relation = st($themyarray["s_d_relation"]);
		$s_d_other = st($themyarray["s_d_other"]);
		$s_d_employer = st($themyarray["s_d_employer"]);
		$s_d_ins_co = st($themyarray["s_d_ins_co"]);
		$s_d_ins_id = st($themyarray["s_d_ins_id"]);
		$p_m_partyfname = st($themyarray["p_m_partyfname"]);
    $p_m_partymname = st($themyarray["p_m_partymname"]);
		$p_m_partylname = st($themyarray["p_m_partylname"]);
		$p_m_relation = st($themyarray["p_m_relation"]);
		$p_m_other = st($themyarray["p_m_other"]);
		$p_m_employer = st($themyarray["p_m_employer"]);
		$p_m_ins_co = st($themyarray["p_m_ins_co"]);
		$p_m_ins_id = st($themyarray["p_m_ins_id"]);
		$has_s_m_ins = st($themyarray["has_s_m_ins"]);
		$s_m_partyfname = st($themyarray["s_m_partyfname"]);
    $s_m_partymname = st($themyarray["s_m_partymname"]);
		$s_m_partylname = st($themyarray["s_m_partylname"]);
		$s_m_relation = st($themyarray["s_m_relation"]);
		$s_m_other = st($themyarray["s_m_other"]);
		$s_m_employer = st($themyarray["s_m_employer"]);
		$s_m_ins_co = st($themyarray["s_m_ins_co"]);
		$s_m_ins_id = st($themyarray["s_m_ins_id"]);
		$p_m_ins_grp = st($themyarray["p_m_ins_grp"]);
    $s_m_ins_grp = st($themyarray["s_m_ins_grp"]);
    $p_m_dss_file = st($themyarray["p_m_dss_file"]);
    $s_m_dss_file = st($themyarray["s_m_dss_file"]);
    $p_m_ins_type = st($themyarray["p_m_ins_type"]);
    $s_m_ins_type = st($themyarray["s_m_ins_type"]);
    $p_m_ins_ass = st($themyarray["p_m_ins_ass"]);
    $s_m_ins_ass = st($themyarray["s_m_ins_ass"]);
    $p_m_ins_plan = st($themyarray["p_m_ins_plan"]);
    $s_m_ins_plan = st($themyarray["s_m_ins_plan"]);
    $ins_dob = st($themyarray["ins_dob"]);
    $ins2_dob = st($themyarray["ins2_dob"]);
		$employer = st($themyarray["employer"]);
		$emp_add1 = st($themyarray["emp_add1"]);
		$emp_add2 = st($themyarray["emp_add2"]);
		$emp_city = st($themyarray["emp_city"]);
		$emp_state = st($themyarray["emp_state"]);
		$emp_zip = st($themyarray["emp_zip"]);
		$emp_phone = st($themyarray["emp_phone"]);
		$emp_fax = st($themyarray["emp_fax"]);
		$plan_name = st($themyarray["plan_name"]);
		$group_number = st($themyarray["group_number"]);
		$ins_type = st($themyarray["ins_type"]);
		$status = st($themyarray["status"]);
		$use_patient_portal = st($themyarray["use_patient_portal"]);
		$accept_assignment = st($themyarray["accept_assignment"]);
		$print_signature = st($themyarray["print_signature"]);
		$medical_insurance = st($themyarray["medical_insurance"]);
		$mark_yes = st($themyarray["mark_yes"]);
		$docsleep = st($themyarray["docsleep"]);
		  $dsql = "SELECT dc.lastname, dc.firstname, dct.contacttype FROM dental_contact dc
                                LEFT JOIN dental_contacttype dct ON dct.contacttypeid = dc.contacttypeid
                        WHERE contactid=".$docsleep;
                  $dq = mysql_query($dsql);
                  $d = mysql_fetch_assoc($dq);
                  $docsleep_name = $d['lastname'].", ".$d['firstname'].(($d['contacttype']!='')?' - '.$d['contacttype']:'');
		$docpcp = st($themyarray["docpcp"]);
                  $dsql = "SELECT dc.lastname, dc.firstname, dct.contacttype FROM dental_contact dc
                                LEFT JOIN dental_contacttype dct ON dct.contacttypeid = dc.contacttypeid
                        WHERE contactid=".$docpcp;
                  $dq = mysql_query($dsql);
                  $d = mysql_fetch_assoc($dq);
                  $docpcp_name = $d['lastname'].", ".$d['firstname'].(($d['contacttype']!='')?' - '.$d['contacttype']:'');

		$docdentist = st($themyarray["docdentist"]);
                  $dsql = "SELECT dc.lastname, dc.firstname, dct.contacttype FROM dental_contact dc
                                LEFT JOIN dental_contacttype dct ON dct.contacttypeid = dc.contacttypeid
                        WHERE contactid=".$docdentist;
                  $dq = mysql_query($dsql);
                  $d = mysql_fetch_assoc($dq);
                  $docdentist_name = $d['lastname'].", ".$d['firstname'].(($d['contacttype']!='')?' - '.$d['contacttype']:'');

		$docent = st($themyarray["docent"]);
                  $dsql = "SELECT dc.lastname, dc.firstname, dct.contacttype FROM dental_contact dc
                                LEFT JOIN dental_contacttype dct ON dct.contacttypeid = dc.contacttypeid
                        WHERE contactid=".$docent;
                  $dq = mysql_query($dsql);
                  $d = mysql_fetch_assoc($dq);
                  $docent_name = $d['lastname'].", ".$d['firstname'].(($d['contacttype']!='')?' - '.$d['contacttype']:'');

		$docmdother = st($themyarray["docmdother"]);
                  $dsql = "SELECT dc.lastname, dc.firstname, dct.contacttype FROM dental_contact dc
				LEFT JOIN dental_contacttype dct ON dct.contacttypeid = dc.contacttypeid
			WHERE contactid=".$docmdother;
                  $dq = mysql_query($dsql);
                  $d = mysql_fetch_assoc($dq);
                  $docmdother_name = $d['lastname'].", ".$d['firstname'].(($d['contacttype']!='')?' - '.$d['contacttype']:'');

		$inactive = st($themyarray["inactive"]);
		$partner_name = st($themyarray["partner_name"]);
		$emergency_name = st($themyarray["emergency_name"]);
    $emergency_relationship = st($themyarray["emergency_relationship"]);
		$emergency_number = st($themyarray["emergency_number"]);
		$referred_source = st($themyarray["referred_source"]);
		$referred_by = st($themyarray["referred_by"]);
		$referred_notes = st($themyarray["referred_notes"]);
		if($referred_source==DSS_REFERRED_PATIENT){
		  $rsql = "SELECT lastname, firstname FROM dental_patients WHERE patientid=".$referred_by;
		  $rq = mysql_query($rsql);
		  $r = mysql_fetch_assoc($rq);
		  $referred_name = $r['lastname'].", ".$r['firstname'] . " - Patient";
		}elseif($referred_source==DSS_REFERRED_PHYSICIAN){
                  $rsql = "SELECT dc.lastname, dc.firstname, dct.contacttype FROM dental_contact dc
			LEFT JOIN dental_contacttype dct on dc.contacttypeid=dct.contacttypeid
			WHERE contactid=".$referred_by;
                  $rq = mysql_query($rsql);
                  $r = mysql_fetch_assoc($rq);
                  $referred_name = $r['lastname'].", ".$r['firstname'];
		  if($r['contacttype'] != ''){
    			$referred_name .= " - " . $r['contacttype'];
		  }
                }

		$copyreqdate = st($themyarray["copyreqdate"]);
		$preferredcontact = st($themyarray["preferredcontact"]);
		$referred_notes = st($themyarray["referred_notes"]);
		$name = st($themyarray['lastname'])." ".st($themyarray['middlename']).", ".st($themyarray['firstname']);

		$loc_sql = "SELECT location from dental_summary WHERE patientid='".$_GET['pid']."';";
		$loc_q = mysql_query($loc_sql);
		$loc_r = mysql_fetch_assoc($loc_q);
		$location = $loc_r['location'];
		
		$but_text = "Add ";
	}
	
	if($themyarray["userid"] != '')
	{
		$but_text = "Save/Update ";
	}
	else
	{
		$but_text = "Add ";
	}

	// Check if required information is filled out
	$complete_info = 0;
	if (!empty($home_phone) || !empty($work_phone) || !empty($cell_phone)) {
		$patientphone = true;
	}
  if (!empty($email)) {
		$patientemail = true;
	}
	if (($patientemail || $patientphone) && !empty($add1) && !empty($city) && !empty($state) && !empty($zip) && !empty($dob) && !empty($gender)) {
		$complete_info = 1;
	}
	// Determine Whether Patient Info has been set
	update_patient_summary($_GET['ed'], 'patient_info', $complete_info);

	?>
	
	<? if($msg != '') {?>
    <div align="center" class="red">
        <? echo $msg;?>
    </div>
    <? }?>

<script type="text/javascript">
var clickedBut;
$(document).ready(function() {
$('#patientfrm :submit').click(function() { 
clickedBut = $(this).attr("name");  
}); 
});
function validate_add_patient(fa){
p = patientabc(fa);
var valid = true;
                                  $.ajax({
                                        url: "includes/check_email.php",
                                        type: "post",
                                        data: {email: fa.email.value<?= (isset($_GET['pid']))?", id: ".$_GET['pid']:''; ?>},
                                        async: false,
                                        success: function(data){
						var r = $.parseJSON(data);
                                                if(r.error){
                                                  alert("Error: The email address you entered is already associated with another patient. Please enter a different email address.");
						  valid = false; 
                                                }
                                        },
                                        failure: function(data){
                                                //alert('fail');
                                        }
                                  });
if(!valid){ return false; }
var sendEmail = false;
var emailConfirm = false;
                                  $.ajax({
                                        url: "includes/check_send.php",
                                        type: "post",
                                        data: {email: fa.email.value<?= (isset($_GET['pid']))?", id: ".$_GET['pid']:''; ?>},
                                        async: false,
                                        success: function(data){
                                                var r = $.parseJSON(data);
                                                if(r.success){                                                          
							emailConfirm = true;
							c = confirm("You have changed the patient's email address. The patient must be notified via email or he/she will not be able to access the Patient Portal. Send email notification and proceed?");
                                                        if(!c){ sendEmail = true; }
                                                }
                                        },
                                        failure: function(data){
                                                //alert('fail');
                                        }
                                  });
if(sendEmail){ return false; }
if(clickedBut == "sendReg" && !emailConfirm){
    if(!regabc(fa)){ return false; }
}else if(clickedBut == "sendRem" && !emailConfirm){
    if(!remabc(fa)){ return false; }
}
if(p){
  if(document.getElementById('s_m_dss_file_yes').checked){
    i2 = validateDate('ins2_dob');
  }else{
    i2 = true;
  }
  if(document.getElementById('p_m_dss_file_yes').checked){
    i = validateDate('ins_dob');
  }else{
    i = true;
  }
  /*d = validateDate('dob');*/
}
if(p){
  result = true;
  if( /*d &&*/ i && i2){
		var result = true;
		info = required_info(fa);
		if (info.length == 0) {
			result = true;
		} else {
			m = 'Warning! Patient info is incomplete. Software functionality will be disabled for this patient until all required fields are entered. Are you sure you want to continue?\n\n';
			m += "Missing fields:";
			for(i=0;i<info.length;i++){
			  m += "\n"+info[i];
			}
			result = confirm(m);
		}
	if(!result){
    		return result;
	}
  }

                if(trim(fa.p_m_partyfname.value) != "" || 
			trim(fa.p_m_partylname.value) != "" ||
                	trim(fa.p_m_relation.value) != "" ||
                	trim(fa.ins_dob.value) != "" ||
                	trim(fa.p_m_ins_co.value) != "" ||
                	trim(fa.p_m_party.value) != "" ||
                	trim(fa.p_m_ins_grp.value) != "" ||
                	trim(fa.p_m_ins_plan.value) != "" ||
                	trim(fa.p_m_ins_type.value) != "Select Type"){ 

if(document.getElementById('p_m_dss_file_yes').checked || document.getElementById('p_m_dss_file_no').checked){
  //ok
}else{
  alert('Is DSS filing insurance?  Please select Yes or No.');
  return false;
}
}
if(document.getElementById('s_m_dss_file_yes').checked && !document.getElementById('p_m_dss_file_yes').checked){
  alert('DSS must file Primary Insurance in order to file Secondary Insurance.');
  return false;
}
return result;

//workaround for settimeout being called in conditionals even if not true
var err = '';
if(!d){
  err = "dob" 
}else if(!i){
  err = "ins_dob"
}else if(!i2){
  err = "ins2_dob"
}
if(err != ''){
el = document.getElementById(err);
setTimeout("el.focus()", 0);
}
}
return false;

}

</script>

<?php

$notifications = find_patient_notifications($_GET['pid']);
foreach($notifications AS $not){
?>
<div id="not_<?= $not['id']; ?>" class="warning <?= $not['notification_type']; ?>">
<span><?= $not['notification']; ?> <?= ($not['notification_date'])?"- ".date('m/d/Y h:i a', strtotime($not['notification_date'])):''; ?></span>
<a href="#" class="close_but" onclick="remove_notification('<?= $not['id']; ?>');return false;">X</a>
</div>
<?php
}
?>
<script type="text/javascript">
function remove_notification(id){
  $.ajax({
    url: 'includes/notifications_remove.php',
    type: 'post',
    data: 'id='+id,
    success: function( data ) {
        var r = $.parseJSON(data);
        if(r.success){
           $('#not_'+id).hide('slow');
        }else{
		//alert('Error');
        }
    }
  });


}
</script>
<?php
        if($_GET['search'] != ''){
	  if(strpos($_GET['search'], ' ')){
            $firstname = substr($_GET['search'], 0, strpos($_GET['search'], ' '));
            $lastname = substr($_GET['search'], strpos($_GET['search'],' ')+1);
	  }else{
	    $firstname = $_GET['search'];	
	  }
        }

?>
    <form name="patientfrm" id="patientfrm" action="<?=$_SERVER['PHP_SELF'];?>?pid=<?= $_GET['pid']; ?>&add=1" method="post" onSubmit="return validate_add_patient(this);">

    
    <script language="JavaScript" src="calendar1.js"></script>
<script language="JavaScript" src="calendar2.js"></script>
    
    
    <table width="98%" style="margin-left:11px;" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center">
	<tr>
              <td >
            <font style="color:#0a5da0; font-weight:bold; font-size:16px;">GENERAL INFORMATION</font>
              </td>

		<td  align="right">
			<?php 
			if($doc_patient_portal && $use_patient_portal){
			  if($themyarray['registration_status']==1 || $themyarray['registration_status']==0){  ?>
		 	    <input type="submit" name="sendReg" value="Send Registration Email" class="button" />
			<?php 
			  }else{ ?>
			    <input type="submit" name="sendRem" value="Send Reminder Email" class="button" />
			<?php
			  }	
			} ?>
                        <input type="submit" value=" <?=$but_text?> Patient" class="button" />
		</td>
	</tr>
        <tr>
        	<td valign="top" colspan="2" class="frmhead">
				<ul>
                    <li id="foli8" class="complex">	
<div style="float:right; width:270px;">
<?php
                                $pid = $_GET['pid'];
  $itype_sql = "select * from dental_q_image where imagetypeid=4 AND patientid=".$pid." ORDER BY adddate DESC LIMIT 1";
  $itype_my = mysql_query($itype_sql);
$num_face = mysql_num_rows($itype_my);
?>
<span style="float:right">
<?php if($num_face==0){ ?>
        <a href="#" onclick="loadPopup('add_image.php?pid=<?=$_GET['pid'];?>&sh=<?=$_GET['sh'];?>&it=4');return false;" >
		<img src="images/add_patient_photo.png" />
        </a>
<?php }else{ 
  while($image = mysql_fetch_array($itype_my)){
   echo "<img src='q_file/".$image['image_file']."' height='150' style='float:right;' />";
  }

} ?>

</div>
                        <label class="desc" id="title0" for="Field0" style="float:left;">
                            Name
                            <span id="req_0" class="req">*</span>
                        </label>

                        <div style="float:left; clear:left;">
                            <span>
                                <select name="salutation" style="width:80px;" >
                                  <option value="Mr." <?php if($salutation == "Mr."){echo "selected='selected'";} ?>>Mr.</option>
                                  <option value="Mrs." <?php if($salutation == "Mrs."){echo "selected='selected'";} ?>>Mrs.</option>
                                  <option value="Ms." <?php if($salutation == "Ms."){echo "selected='selected'";} ?>>Ms.</option>
                                  <option value="Dr." <?php if($salutation == "Dr."){echo "selected='selected'";} ?>>Dr.</option>
                                </select>
                                <label for="salutation">Salutation</label>
                            </span>
                            <span>
                                <input id="firstname" name="firstname" type="text" class="field text addr tbox" value="<?=$firstname?>" maxlength="255" style="width:150px;" />
                                <label for="firstname">First Name</label>
                            </span>
                            <span>
                                <input id="lastname" name="lastname" type="text" class="field text addr tbox" value="<?=$lastname?>" maxlength="255" style="width:190px;" />
                                <label for="lastname">Last Name</label>
                            </span>
                            <span>
                                <input id="middlename" name="middlename" type="text" class="field text addr tbox" value="<?=$middlename?>" style="width:30px;" maxlength="1" />
                                <label for="middlename">MI</label>
                            </span>
                            <span>
                                <input id="preferred_name" name="preferred_name" type="text" class="field text addr tbox" value="<?=$preferred_name?>" maxlength="255" style="width:150px" />
                                <label for="preferred_name">Preferred Name</label>
                            </span>
                       </div>   
		        <div style="float:left">
                            <span>
                                <input id="home_phone" name="home_phone" type="text" class="phonemask field text addr tbox" value="<?=$home_phone?>"  maxlength="255" style="width:100px;" />
                                <label for="home_phone">Home Phone
                                                                                                                                <span id="req_0" class="req">*</span>
                                                                                                                                </label>
                            </span>
                            <span>
                                <input id="cell_phone" name="cell_phone" type="text" class="phonemask field text addr tbox" value="<?=$cell_phone?>"  maxlength="255" style="width:100px;" />
                                <label for="cell_phone">Cell Phone</label>
                            </span>
                            <span>
                                <input id="work_phone" name="work_phone" type="text" class="extphonemask field text addr tbox" value="<?=$work_phone?>" maxlength="255" style="width:150px;" />
                                <label for="work_phone">Work Phone</label>
                            </span>
                            <span>
                                <input id="email" name="email" type="text" class="field text addr tbox" value="<?=$email?>"  maxlength="255" style="width:275px;" />
                                <label for="email">Email/Pt. Portal Login</label>

                            </span>

                                                </div>
			<div style="clear:both">
			    <span style="width:140px;">
				<select id="best_time" name="best_time">
					<option value="">Please Select</option>
					<option value="morning" <?= ($best_time=='morning')?'selected="selected"':''; ?>>Morning</option>
                                        <option value="midday" <?= ($best_time=='midday')?'selected="selected"':''; ?>>Mid-Day</option>
                                        <option value="evening" <?= ($best_time=='evening')?'selected="selected"':''; ?>>Evening</option>
				</select>
				<label for="best_time">Best time to contact</label>
			    </span>
			    <span style="width:150px;">
                                <select id="best_number" name="best_number">
                                        <option value="">Please Select</option>
                                        <option value="home" <?= ($best_number=='home')?'selected="selected"':''; ?>>Home Phone</option>
                                        <option value="work" <?= ($best_number=='work')?'selected="selected"':''; ?>>Work Phone</option>
                                        <option value="cell" <?= ($best_number=='cell')?'selected="selected"':''; ?>>Cell Phone</option>
                                </select>
                                <label for="best_number">Best number to contact</label>
			    </span>
			    <span style="width:160px;">
                <select id="preferredcontact" name="preferredcontact" >
                        <option value="paper" <? if($preferredcontact == 'paper') echo " selected";?>>Paper Mail</option>
                        <option value="email" <? if($preferredcontact == 'email') echo " selected";?>>Email</option>
                </select>
				<label>Preferred Contact Method</label>
			    </span>
<div>Portal:
<span style="color:#933; float:none;">
                                  <?php
                                    if($themyarray['use_patient_portal']==1){
                                        switch($themyarray['registration_status']){
                                        case 0:
                                                echo 'Unregistered';
                                                break;
                                        case 1:
                                                echo 'Registration Emailed '.date('m/d/Y h:i a', strtotime($themyarray['registration_senton']));
                                                break;
                                        case 2:
                                                echo 'Registered';
                                                break;
                                        }
                                    }else{
                                                echo 'Patient Portal In-active';
                                    }
                                  ?>
                                </span>
            </div>            </div>
                    </li>
                </ul>
            </td>
        </tr>
        <!-- <tr>
        	<td valign="top" colspan="2" class="frmhead">
				<ul>
                    <li id="foli8" class="complex">	
                        <label class="desc" id="title0" for="Field0">
                            Premedication
                            <span id="req_0" class="req">*</span>
                        </label>
                        <div>
                            <span>
                                <label for="premedcheck">Is Patient Pre-Med?<input id="premedcheck" name="premedcheck" tabindex="5" type="checkbox"  <?php if($premedcheck == 1){ echo "checked=\"checked\"";} ?> onclick="document.getElementById('premeddet').disabled=!(this.checked)" value="1" /></label>
                                
                            </span>
                            <span>
                                <textarea name="premeddet" id="premeddet" class="field text addr tbox" style="width:610px;" tabindex="18" <?php if($premedcheck == 0){ echo "disabled";} ?>><?=$premeddet;?></textarea>
                            </span>
                          
                       </div>   
                    </li>
                </ul>
            </td>
        </tr>-->
        <tr> 
        	<td valign="top" colspan="2" class="frmhead">
            	<ul>
            		<li id="foli8" class="complex">	
                    	<label class="desc" id="title0" for="Field0">
                            Address
                            <span id="req_0" class="req">*</span>
                        </label>
                        <div>
                            <span>
                                <input id="add1" name="add1" type="text" class="field text addr tbox" value="<?=$add1?>" style="width:225px;"  maxlength="255"/>
                                <label for="add1">Address1</label>
                            </span>
                            <span>
                                <input id="add2" name="add2" type="text" class="field text addr tbox" value="<?=$add2?>" style="width:175px;" maxlength="255" />
                                <label for="add2">Address2</label>
                            </span>
                            <span>
                                <input id="city" name="city" type="text" class="field text addr tbox" value="<?=$city?>" style="width:200px;" maxlength="255" />
                                <label for="city">City</label>
                            </span>
                            <span>
                                <input id="state" name="state" type="text" class="field text addr tbox" value="<?=$state?>" style="width:25px;" maxlength="2" />
                                <label for="state">State</label>
                            </span>
                            <span>
                                <input id="zip" name="zip" type="text" class="field text addr tbox" value="<?=$zip?>" style="width:80px;" maxlength="255" />
                                <label for="zip">Zip / Post Code </label>
                            </span>
				<?php
				$loc_sql = "SELECT * FROM dental_locations WHERE docid='".$docid."'";
                		$loc_q = mysql_query($loc_sql);
				$num_loc = mysql_num_rows($loc_q);
				if($num_loc > 1){
				?>
			    <span>
				<select name="location">
                        		<option value="">Select</option>
        			<?php
                		while($loc_r = mysql_fetch_assoc($loc_q)){
                        		?><option <?= ($location==$loc_r['id'])?'selected="selected"':''; ?>value="<?= $loc_r['id']; ?>"><?= $loc_r['location']; ?></option><?php
                		}
        			?>
                		</select>
				<label for"location">Office Site</label>
			    </span>
			  <?php } ?>
                        </div>
                    </li>
				</ul>
            </td>
        </tr>
        <tr>
        	<td valign="top" colspan="2" class="frmhead">
            	<ul>
            		<li id="foli8" class="complex">	
                        <div>
                            <span>
                                <input id="dob" name="dob" type="text" class="field text addr tbox calendar" value="<?=$dob?>" style="width:100px;" maxlength="255" onChange="validateDate('dob');"  value="example 11/11/1234" /><span id="req_0" class="req">*</span>
                                <label for="dob">Birthday</label>
                            </span>
                            <span>
                            	<select name="gender" id="gender" class="field text addr tbox" style="width:100px;" >
                                	<option value="">Select</option>
                                    <option value="Male" <? if($gender == 'Male') echo " selected";?>>Male</option>
                                    <option value="Female" <? if($gender == 'Female') echo " selected";?>>Female</option>
                                </select><span id="req_0" class="req">*</span>
                                <label for="gender">Gender</label>
                            </span>
                            <span style="width:150px">
                                <input id="ssn" name="ssn" type="text" class="ssnmask field text addr tbox" value="<?=$ssn?>"  maxlength="255" style="width:100px;" />
                                <label for="ssn">Social Security No.</label>
                            </span>
                <script type="text/javascript">
                                function cal_bmi()
                                {
                                        fa = document.patientfrm;
                                        if(fa.feet.value != 0 && fa.inches.value != -1 && fa.weight.value != 0)
                                        {
                                                var inc = (parseInt(fa.feet.value) * 12) + parseInt(fa.inches.value);
                                                //alert(inc);
                                                
                                                var inc_sqr = parseInt(inc) * parseInt(inc);
                                                var wei = parseInt(fa.weight.value) * 703;
                                                var bmi = parseInt(wei) / parseInt(inc_sqr);
                                                
                                                //alert("BMI " + bmi.toFixed(2));
                                                fa.bmi.value = bmi.toFixed(1);
                                        }
                                        else
                                        {
                                                fa.bmi.value = '';
                                        }
                                }
                        </script>

<span>
                            <select name="feet" id="feet" class="field text addr tbox" style="width:100px;" tabindex="5" onchange="cal_bmi();" >
                                <option value="0">Feet</option>
                                <? for($i=1;$i<9;$i++)
                                                                {
                                                                ?>
                                                                        <option value="<?=$i?>" <? if($feet == $i) echo " selected";?>><?=$i?></option>
                                                                <?
                                                                }?>
                            </select>
                            <?php
                                showPatientValue('dental_patients', $_GET['pid'], 'feet', $pat_row['feet'], $feet, true, $showEdits);
                            ?>
                            <label for="feet">Height: Feet</label>
                        </span>

                        <span>
                            <select name="inches" id="inches" class="field text addr tbox" style="width:100px;" tabindex="6" onchange="cal_bmi();">
                                <option value="-1">Inches</option>
                                <? for($i=0;$i<12;$i++)
                                                                {
                                                                ?>
                                                                        <option value="<?=$i?>" <? if($inches!='' && $inches == $i) echo " selected";?>><?=$i?></option>
                                                                <?
                                                                }?>
                            </select>
                            <?php
                                showPatientValue('dental_patients', $_GET['pid'], 'inches', $pat_row['inches'], $inches, true, $showEdits);
                            ?>
                            <label for="inches">Inches</label>
                        </span>

                        <span>
                            <select name="weight" id="weight" class="field text addr tbox" style="width:100px;" tabindex="7" onchange="cal_bmi();">
                                <option value="0">Weight</option>
                                <? for($i=80;$i<=500;$i++)
                                                                {
                                                                ?>
                                                                        <option value="<?=$i?>" <? if($weight == $i) echo " selected";?>><?=$i?></option>
                                                                <?
                                                                }?>
                            </select>
                            <?php
                                showPatientValue('dental_patients', $_GET['pid'], 'weight', $pat_row['weight'], $weight, true, $showEdits);
                            ?>

                            <label for="inches">Weight in Pounds&nbsp;&nbsp;&nbsp;&nbsp;</label>
                        </span>

                        <span>
                                <span style="color:#000000; padding-top:2px;">BMI</span>
                                <input id="bmi" name="bmi" type="text" class="field text addr tbox" value="<?=$bmi?>" tabindex="8" maxlength="255" style="width:50px;" readonly="readonly" />
                        </span>
                        <span>
                                <label for="inches">
                                &lt; 18.5 is Underweight
                                <br />
                                &nbsp;&nbsp;&nbsp;
                                18.5 - 24.9 is Normal
                                <br />
                                &nbsp;&nbsp;&nbsp;
                                25 - 29.9 is Overweight
                                <br />
                                &gt; 30 is Obese
                            </label>
                        </span>
			</div>
		  </li>
		</ul>
	</td>
	</tr> 

        <tr>
	<td class="frmhead">
		<ul>
		  <li>
                            <span>
                                <select name="marital_status" id="marital_status" class="field text addr tbox" style="width:130px;" >
                                        <option value="">Select</option>
                                    <option value="Married" <? if($marital_status == 'Married') echo " selected";?>>Married</option>
                                    <option value="Single" <? if($marital_status == 'Single') echo " selected";?>>Single</option>
                                                                        <option value="Life Partner" <? if($marital_status == 'Life Partner') echo " selected";?>>Life Partner</option>
                                    <option value="Minor" <? if($marital_status == 'Minor') echo " selected";?>>Minor</option>
                                </select>
                                <label for="marital_status">Marital Status</label>
                            </span>
                                                        <span>
                                <input id="partner_name" name="partner_name" type="text" class="field text addr tbox" value="<?=$partner_name?>"  maxlength="255" />
                                <label for="partner_name">Partner/Guardian Name</label>
                            </span>
                        </div>
                    </li>
				</ul>
            </td>
        	<td valign="top" class="frmhead">
            	<ul>
            		<li id="foli8" class="complex">	
                    	<!--<label class="desc" id="title0" for="Field0">
                            Optional Fields (not used in letters)
                        </label>-->
			  <div>
                            <span>
                            	<textarea name="patient_notes"  id="patient_notes" class="field text addr tbox" style="width:410px;" ><?=$patient_notes;?></textarea>
                                <label for="patient_notes">Patient Notes</label>
                            </span>
                        </div>
                    </li>
				</ul>
            </td>
        </tr>
		<tr> 
        	<td valign="top" colspan="2" class="frmhead">
            	<ul>
            		<li id="foli8" class="complex">	
                    	<label class="desc" id="title0" for="Field0">
                            In case of an emergency
                        </label>
                        <div>
                            <span>
                                <input id="emergency_name" name="emergency_name" type="text" class="field text addr tbox" value="<?=$emergency_name?>" maxlength="255" style="width:200px;" />
                                <label for="home_phone">Name</label>
                            </span>
                            <span>
                                <input id="emergency_relationship" name="emergency_relationship" type="text" class="field text addr tbox" value="<?=$emergency_relationship?>" maxlength="255" style="width:150px;" />
                                <label for="home_phone">Relationship</label>
                            </span>
                            <span>
                                <input id="emergency_number" name="emergency_number" type="text" class="extphonemask field text addr tbox" value="<?=$emergency_number?>" maxlength="255" style="width:150px;" />
                                <label for="emergency_number">Number</label>
                            </span>
						</div>
                    </li>
				</ul>
            </td>
        </tr>
                          <tr>
              <td colspan="2">
            <font style="color:#0a5da0; font-weight:bold; font-size:16px;">REFERRED BY</font>
              </td>
          </tr>

		<tr> 
        	<td valign="top" colspan="2" class="frmhead">
            	<ul>
            		<li id="foli8" class="complex">	
                    	<label class="desc" id="title0" for="Field0">
                           &nbsp;
                        </label>
                        <div>
<div style="float:left;">
<?php if(!isset($pid)){ $copyreqdate = date('m/d/Y'); } ?>
                           <input id="copyreqdate" name="copyreqdate" type="text" class="field text addr tbox calendar" value="<?php echo $copyreqdate; ?>"  style="width:100px;" maxlength="255" onChange="validateDate('copyreqdate');" value="example 11/11/1234" />
<label>Date</label>
				</div>
<style type="text/css">
#referred_source div{ float:left; }
</style>
				<div style="float:left;" id="referred_source_div">
				
				<input name="referred_source_r" <?= ($referred_source==DSS_REFERRED_PATIENT||$referred_source==DSS_REFERRED_PHYSICIAN)?'checked="checked"':''; ?> type="radio" value="person" onclick="show_referredby('person', '')" /> Person
				<input name="referred_source_r" <?= ($referred_source==DSS_REFERRED_MEDIA)?'checked="checked"':''; ?> type="radio" value="<?= DSS_REFERRED_MEDIA; ?>" onclick="show_referredby('notes', <?= DSS_REFERRED_MEDIA; ?>)" /> <?= $dss_referred_labels[DSS_REFERRED_MEDIA]; ?>
                                <input name="referred_source_r" <?= ($referred_source==DSS_REFERRED_FRANCHISE)?'checked="checked"':''; ?> type="radio" value="<?= DSS_REFERRED_FRANCHISE; ?>" onclick="show_referredby('notes',<?= DSS_REFERRED_FRANCHISE; ?>)" /> <?= $dss_referred_labels[DSS_REFERRED_FRANCHISE]; ?>
                                <input name="referred_source_r" <?= ($referred_source==DSS_REFERRED_DSSOFFICE)?'checked="checked"':''; ?> type="radio" value="<?= DSS_REFERRED_DSSOFFICE; ?>" onclick="show_referredby('notes',<?= DSS_REFERRED_DSSOFFICE; ?>)" /> <?= $dss_referred_labels[DSS_REFERRED_DSSOFFICE]; ?>
                                <input name="referred_source_r" <?= ($referred_source==DSS_REFERRED_OTHER)?'checked="checked"':''; ?> type="radio" value="<?= DSS_REFERRED_OTHER; ?>" onclick="show_referredby('notes',<?= DSS_REFERRED_OTHER; ?>)" /> <?= $dss_referred_labels[DSS_REFERRED_OTHER]; ?>

				</div>
<script type="text/javascript">
function show_referredby(t, rs){
	if(t=='person'){
                document.getElementById('referred_notes').style.display="none";
                document.getElementById('referred_person').style.display="block";
	}else{
                document.getElementById('referred_notes').style.display="block";
		document.getElementById('referred_person').style.display="none";
	}
                $('#referred_source').val(rs);
}
</script>
				<div style="clear:both;float:left;">
					<div id="referred_person" <?= ($referred_source!=DSS_REFERRED_PATIENT && $referred_source!=DSS_REFERRED_PHYSICIAN )?'style="display:none;margin-left:100px;"':'style="margin-left:100px"'; ?>>	
					<input type="text" id="referredby_name" onclick="updateval(this)" autocomplete="off" name="referredby_name" value="<?= ($referred_name!='')?$referred_name:'Type referral name'; ?>" style="width:300px;" />
<input type="button" class="button" style="width:150px;" onclick="loadPopupRefer('add_contact.php?addtopat=<?php echo $_GET['pid']; ?>&from=add_patient');" value="+ Create New Contact" />
<br />
        <div id="referredby_hints" class="search_hints" style="margin-top:20px; display:none;">
                <ul id="referredby_list" class="search_list">
                        <li class="template" style="display:none">Doe, John S</li>
                </ul>
        </div>
<script type="text/javascript">
$(document).ready(function(){
  setup_autocomplete('referredby_name', 'referredby_hints', 'referred_by', 'referred_source', 'list_referrers.php', 'referrer', <?= $_GET['pid']; ?>);
});
</script>
					</div>
					<div id="referred_notes" <?= ($referred_source!=DSS_REFERRED_MEDIA && $referred_source!=DSS_REFERRED_FRANCHISE && $referred_source!=DSS_REFERRED_DSSOFFICE && $referred_source!=DSS_REFERRED_OTHER )?'style="display:none;margin-left:200px;"':'style="margin-left:200px;"'; ?>>
						<textarea name="referred_notes" style="width:300px;"><?= $referred_notes; ?></textarea> 	
					</div>
<input type="hidden" name="referred_by" id="referred_by" value="<?=$referred_by;?>" />
<input type="hidden" name="referred_source" id="referred_source" value="<?=$referred_source;?>" />

                               <!-- <input id="referred_by" name="referred_by" type="text" class="field text addr tbox" value="<?=$referred_by?>" maxlength="255" style="width:300px;" /> -->
                            </div>
                    </li>
				</ul>
            </td>
        </tr>
           

                          <tr>
              <td colspan="2">
            <font style="color:#0a5da0; font-weight:bold; font-size:16px;">EMPLOYER</font>
              </td>
          </tr>
                <tr>
                <td valign="top" colspan="2" class="frmhead">
                <ul>
                        <li id="foli8" class="complex">
                        <label class="desc" id="title0" for="Field0">
                            Employer Information
                        </label>
                                                <div>
                            <span>
                                <input id="employer" name="employer" type="text" class="field text addr tbox" value="<?php echo $employer; ?>" style="width:325px;"  maxlength="255"/>
                                <label for="add1">Employer</label>
                            </span>
                                                        <span>
                                <input id="emp_phone" name="emp_phone" type="text" class="extphonemask field text addr tbox" value="<?=$emp_phone?>"  style="width:150px;" maxlength="255" />
                                <label for="state">&nbsp;&nbsp;Phone</label>
                            </span>
                                                        <span>
                                <input id="emp_fax" name="emp_fax" type="text" class="phonemask field text addr tbox" value="<?=$emp_fax?>"  style="width:120px;" maxlength="255" />
                                <label for="state">Fax</label>
                            </span>

                        </div>
                        <div>
                            <span>
                                <input id="emp_add1" name="emp_add1" type="text" class="field text addr tbox" value="<?=$emp_add1?>" style="width:225px;"  maxlength="255"/>
                                <label for="add1">Address1</label>
                            </span>
                            <span>
                                <input id="emp_add2" name="emp_add2" type="text" class="field text addr tbox" value="<?=$emp_add2?>" style="width:175px;" maxlength="255" />
                                <label for="add2">Address2</label>
                            </span>
                            <span>
                                <input id="emp_city" name="emp_city" type="text" class="field text addr tbox" value="<?=$emp_city?>" style="width:200px;" maxlength="255" />
                                <label for="city">City</label>
                            </span>
                            <span>
                                <input id="emp_state" name="emp_state" type="text" class="field text addr tbox" value="<?=$emp_state?>"  style="width:80px;" maxlength="255" />
                                <label for="state">State</label>
                            </span>
                            <span>
                                <input id="emp_zip" name="emp_zip" type="text" class="field text addr tbox" value="<?=$emp_zip?>" style="width:80px;" maxlength="255" />
                                <label for="zip">Zip Code </label>
                            </span>
                        </div>
                    </li>
                                </ul>
            </td>
        </tr>







 
	  <tr>
	      <td colspan="2">
            <font style="color:#0a5da0; font-weight:bold; font-size:16px;">INSURANCE</font>	      
	      </td>
	  </tr>
		
		<tr> 
        	<td valign="top" colspan="2" class="frmhead">
            	<ul>
            		<li id="foli8" class="complex">	
                    	<label class="desc" id="title0" for="Field0">
                            Primary Medical &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;DSS filing insurance?<input id="p_m_dss_file_yes" type="radio" name="p_m_dss_file" value="1" <? if($p_m_dss_file == '1') echo "checked='checked'";?>>Yes&nbsp;&nbsp;&nbsp;&nbsp;<input  id="p_m_dss_file_no" type="radio" name="p_m_dss_file" value="2" <? if($p_m_dss_file == '2') echo "checked='checked'";?>>No
                        </label>
                        <div>
                            <span>
                                                                <select id="p_m_relation" name="p_m_relation" class="field text addr tbox" style="width:200px;">
                                                                        <option value="" <? if($p_m_relation == '') echo " selected";?>>None</option>
                                                                        <option value="Self" <? if($p_m_relation == 'Self') echo " selected";?>>Self</option>
                                                                        <option value="Spouse" <? if($p_m_relation == 'Spouse') echo " selected";?>>Spouse</option>
                                                                        <option value="Child" <? if($p_m_relation == 'Child') echo " selected";?>>Child</option>
                                                                        <option value="Other" <? if($p_m_relation == 'Other') echo " selected";?>>Other</option>
                                                                </select>
                                <label for="work_phone">Relationship to insured party</label>
                            </span>

                            <span>
                                <input id="p_m_partyfname" name="p_m_partyfname" type="text" class="field text addr tbox" value="<?=$p_m_partyfname?>" maxlength="255" style="width:150px;" /><input id="p_m_partymname" name="p_m_partymname" type="text" class="field text addr tbox" value="<?=$p_m_partymname?>" maxlength="255" style="width:50px;" /><input id="p_m_partylname" name="p_m_partylname" type="text" class="field text addr tbox" value="<?=$p_m_partylname?>" maxlength="255" style="width:150px;" />
                                <label for="p_m_partyfname">Insured party First&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Middle&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Last</label>
                            </span>
                            <span>
                                <input id="ins_dob" name="ins_dob" type="text" class="field text addr tbox calendar" value="<?=$ins_dob?>" maxlength="255" style="width:150px;" onChange="validateDate('ins_dob');" />
                                <label for="ins_dob">Insured Date of Birth</label>
                            </span>
			    <span>
				        <button onclick="Javascript: loadPopup('add_image.php?pid=<?=$_GET['pid'];?>&sh=<?=$_GET['sh'];?>&it=10');return false;" class="addButton">
                + Add Insurance Card Image
        </button>
			    </span>
						</div>
						<div>
                            
						</div>
                    </li>
				</ul>
            </td>
        </tr>
        
        
        
        		<tr> 
        	<td valign="top" colspan="2" class="frmhead">
            	<ul>
            		<li id="foli8" class="complex">	
                  
                        <div>
                            <span>
                                <select id="p_m_ins_co" name="p_m_ins_co" class="field text addr tbox" maxlength="255" onchange="updateNumber('p_m_ins_phone');" style="width:200px;" />
																	<option value="">Select Insurance Company</option>
<script type="text/javascript">
                                function updateNumber(f){
                                   var selectBox = document.getElementById("p_m_ins_co");
    var selectedValue = selectBox.options[selectBox.selectedIndex].value;
                                   document.getElementById(f).innerHTML = insurance_nums[selectedValue];
                                }
                                insurance_nums = [];
                            <?php
                            $ins_contact_qry = "SELECT * FROM `dental_contact` WHERE contacttypeid = '11' AND docid='".$_SESSION['docid']."'";
                            $ins_contact_qry_run = mysql_query($ins_contact_qry);
                            while($ins_contact_res = mysql_fetch_array($ins_contact_qry_run)){
                            ?>
                                document.write('<option value="<?php echo $ins_contact_res['contactid']; ?>" <?php if($p_m_ins_co == $ins_contact_res['contactid']){echo "selected=\"selected\"";} ?>><?php echo addslashes($ins_contact_res['company']); ?></option>');
                                
                                <?php } ?>
				</script>
                                </select>
                                <label for="p_m_ins_co">Insurance Co.</label><br />
																<!--<input class="button" style="width:150px;" type="submit" name="add_ins_but" value="Add Insurance Company" />-->
<input type="button" class="button" style="width:215px;" onclick="loadPopupRefer('add_contact.php?from=add_patient&from_id=p_m_ins_co&ctype=ins<?php if(isset($_GET['pid'])){echo "&pid=".$_GET['pid']."&type=11&ctypeeq=1&activePat=".$_GET['pid'];} ?>');" value="+ Create New Insurance Company" />
                            </span>
                            <span>
								 <input id="p_m_party" name="p_m_ins_id" type="text" class="field text addr tbox" value="<?=$p_m_ins_id?>" maxlength="255" style="width:190px;" />
                                <label for="home_phone">Insurance ID.</label>
                            </span>
                            <span>
                                 <input id="p_m_ins_grp" name="p_m_ins_grp" type="text" class="field text addr tbox" value="<?=$p_m_ins_grp?>" maxlength="255" style="width:100px;" />
                                <label for="home_phone">Group #</label>
                            </span>
                            
                            <span>
                                 <input id="p_m_ins_plan" name="p_m_ins_plan" type="text" class="field text addr tbox" value="<?=$p_m_ins_plan?>" maxlength="255" style="width:200px;" />
                                <label for="home_phone">Plan Name</label>
                            </span>
<span>                                                                 <textarea id="p_m_ins_phone" name="p_m_ins_phone" class="field text addr tbox" disabled="disabled" style="width:190px;height:60px;background:#ccc;"></textarea>
                                <label for="p_m_ins_phone">Address</label>
                            </span>

						</div>
						<div>
                            
						</div>
                    </li>
				</ul>
            </td>
        </tr>
        
        
        
        
        
        
        
        <tr> 
        	<td valign="top" colspan="2" class="frmhead">
            	<ul>
            		<li id="foli8" class="complex">	
                  
                        <div>
                            <span>
                                <select id="p_m_ins_type" name="p_m_ins_type" class="field text addr tbox" maxlength="255" style="width:200px;" />
                                     <option>Select Type</option>
                                     <option value="1" <?php if($p_m_ins_type == '1'){ echo " selected='selected'";} ?>>Medicare</option>
                                     <option value="2" <?php if($p_m_ins_type == '2'){ echo " selected='selected'";} ?>>Medicaid</option>
                                     <option value="3" <?php if($p_m_ins_type == '3'){ echo " selected='selected'";} ?>>Tricare Champus</option>
                                     <option value="4" <?php if($p_m_ins_type == '4'){ echo " selected='selected'";} ?>>Champ VA</option>
                                     <option value="5" <?php if($p_m_ins_type == '5'){ echo " selected='selected'";} ?>>Group Health Plan</option>
                                     <option value="6" <?php if($p_m_ins_type == '6'){ echo " selected='selected'";} ?>>FECA BLKLUNG</option>
                                     <option value="7" <?php if($p_m_ins_type == '7'){ echo " selected='selected'";} ?>>Other</option>                                
                                </select>
                                <label for="home_phone">Insurance Type</label>
                            </span>
                            <span>
								            <input id="p_m_ins_ass_yes" type="radio" name="p_m_ins_ass" value="Yes" <?php if($p_m_ins_ass == 'Yes'){ echo " checked='checked'";} ?>>Accept Assignment of Benefits &nbsp;&nbsp;&nbsp;&nbsp;<input id="p_m_ins_ass_no" type="radio" name="p_m_ins_ass" value="No" <?php if($p_m_ins_ass == 'No'){ echo " checked='checked'";} ?>>Payment to Patient
                            </span>
                            
						</div>
						<div>
                            
						</div>
                    </li>
				</ul>
            </td>
        </tr>
        
        
        
        
        
        
        
        
        
        
        
		<tr> 
        	<td valign="top" colspan="2" class="frmhead">
            	<ul>
            		<li id="foli8" class="complex">	
                        <div style="height:40px;display:block;">
                            <span>
				<label style="display:inline;">Does patient have secondary insurance?</label>
                                <input type="radio" value="Yes" <?= ($has_s_m_ins == "Yes")?'checked="checked"':''; ?> name="s_m_ins" onclick="$('.s_m_ins_div').show();" /> Yes
                                <input type="radio" value="No" <?= ($has_s_m_ins != "Yes")?'checked="checked"':''; ?> name="s_m_ins" onclick="$('.s_m_ins_div').hide(); clearInfo();" /> No
                            </span>
                        </div>

		<script type="text/javascript">
			function clearInfo(){
				$('.s_m_ins_div input[type="text"]').val('');
				$('.s_m_ins_div select option[value=]').attr('selected', 'selected');
				$('.s_m_ins_div input[type="radio"]').removeAttr("checked");
			}

		</script>
                    	<label class="desc s_m_ins_div" id="title0" for="Field0"  <?= ($has_s_m_ins != "Yes")?'style="display:none;"':''; ?>>
                            Secondary Medical  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;DSS filing insurance?<input id="s_m_dss_file_yes" type="radio" name="s_m_dss_file" value="1" <? if($s_m_dss_file == '1') echo "checked='checked'";?>>Yes&nbsp;&nbsp;&nbsp;&nbsp;<input id="s_m_dss_file_no" type="radio" name="s_m_dss_file" value="2" <? if($s_m_dss_file == '2') echo "checked='checked'";?>>No
                        </label>
                        <div class="s_m_ins_div" <?= ($has_s_m_ins != "Yes")?'style="display:none;"':''; ?>>
                            <span>
                                                                <select id="s_m_relation" name="s_m_relation" class="field text addr tbox" style="width:200px;">
                                                                        <option value="" <? if($s_m_relation == '') echo " selected";?>>None</option>
                                                                        <option value="Self" <? if($s_m_relation == 'Self') echo " selected";?>>Self</option>
                                                                        <option value="Spouse" <? if($s_m_relation == 'Spouse') echo " selected";?>>Spouse</option>
                                                                        <option value="Child" <? if($s_m_relation == 'Child') echo " selected";?>>Child</option>
                                                                        <option value="Other" <? if($s_m_relation == 'Other') echo " selected";?>>Other</option>
                                                                </select>
                                <label for="work_phone">Relationship to insured party</label>
                            </span>
                            <span>
                                <input id="s_m_partyfname" name="s_m_partyfname" type="text" class="field text addr tbox" value="<?=$s_m_partyfname?>" maxlength="255" style="width:150px;" /><input id="s_m_partymname" name="s_m_partymname" type="text" class="field text addr tbox" value="<?=$s_m_partymname?>" maxlength="255" style="width:50px;" /><input id="s_m_partylname" name="s_m_partylname" type="text" class="field text addr tbox" value="<?=$s_m_partylname?>" maxlength="255" style="width:150px;" />
                                <label for="s_m_partyfname">Insured party First&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Middle&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Last</label>
                            </span>
                            <span>
                                <input id="ins2_dob" name="ins2_dob" type="text" class="field text addr tbox calendar" value="<?=$ins2_dob?>" maxlength="255" style="width:150px;" onChange="validateDate('ins2_dob');" />
                                <label for="ins2_dob">Insured Date of Birth</label>
                            </span>
			    <span>
                                        <button onclick="Javascript: loadPopup('add_image.php?pid=<?=$_GET['pid'];?>&sh=<?=$_GET['sh'];?>&it=10');return false;" class="addButton">
                + Add Insurance Card Image
        </button>
			    </span>
						</div>
						<div>
                            
						</div>
                    </li>
				</ul>
            </td>
        </tr>
        
        
        
        		<tr> 
        	<td valign="top" colspan="2" class="frmhead">
            	<ul>
            		<li id="foli8" class="complex">	
                        <div class="s_m_ins_div" <?= ($has_s_m_ins != "Yes")?'style="display:none;"':''; ?>>
                            <span>
                             <select id="s_m_ins_co" name="s_m_ins_co" class="field text addr tbox" maxlength="255" style="width:200px;" onchange="updateNumber2('s_m_ins_phone')" />
															<option value="">Select Insurance Company</option>
<script type="text/javascript">
                                function updateNumber2(f){
                                   var selectBox = document.getElementById("s_m_ins_co");
    var selectedValue = selectBox.options[selectBox.selectedIndex].value;
                                   document.getElementById(f).innerHTML = insurance_nums[selectedValue];
                                }
                                insurance_nums = []; 
                            <?php
                            $ins_contact_qry = "SELECT * FROM `dental_contact` WHERE contacttypeid = '11' AND docid='".$_SESSION['docid']."'";
                            $ins_contact_qry_run = mysql_query($ins_contact_qry);
                            while($ins_contact_res = mysql_fetch_array($ins_contact_qry_run)){
                            ?>
					insurance_nums[<?= $ins_contact_res['contactid']; ?>] = "<?= $ins_contact_res['add1']; ?>\n<?= $ins_contact_res['add2']; ?><?= ($ins_contact_res['add2'])?'\n':''; ?><?= $ins_contact_res['city']; ?> <?= $ins_contact_res['state']; ?> <?= $ins_contact_res['zip']; ?>\n<?= $ins_contact_res['phone1']; ?>"
                                document.write('<option value="<?php echo $ins_contact_res['contactid']; ?>" <?php if($s_m_ins_co == $ins_contact_res['contactid']){echo "selected=\"selected\"";} ?>><?php echo addslashes($ins_contact_res['company']); ?></option>');
                                
                                <?php } ?>
				</script>
                                </select>
                                <label for="s_m_ins_co">Insurance Co.</label><br />
<input type="button" class="button" style="width:215px;" onclick="loadPopupRefer('add_contact.php?from=add_patient&from_id=s_m_ins_co&ctype=ins<?php if(isset($_GET['pid'])){echo "&pid=".$_GET['pid']."&type=11&ctypeeq=1&activePat=".$_GET['pid'];} ?>');" value="+ Create New Insurance Company" />
                            </span>

                            <span>
								 <input id="s_m_party" name="s_m_ins_id" type="text" class="field text addr tbox" value="<?=$s_m_ins_id?>" maxlength="255" style="width:190px;" />
                                <label for="s_m_ins_id">Insurance ID.</label>
                            </span>
                            <span>
                                 <input id="s_m_ins_grp" name="s_m_ins_grp" type="text" class="field text addr tbox" value="<?=$s_m_ins_grp?>" maxlength="255" style="width:100px;" />
                                <label for="s_m_ins_grp">Group #</label>
                            </span>
                            
                            <span>
                                 <input id="s_m_ins_plan" name="s_m_ins_plan" type="text" class="field text addr tbox" value="<?=$s_m_ins_plan?>" maxlength="255" style="width:200px;" />
                                <label for="s_m_ins_plan">Plan Name</label>
                            </span>
<span>
                                                                 <textarea id="s_m_ins_phone" name="s_m_ins_phone" type="text" class="field text addr tbox" disabled="disabled" style="width:190px;height:60px;background:#ccc;"></textarea>
                                <label for="s_m_ins_phone">Address</label>
                            </span>
						</div>
						<div>
                            
						</div>
                    </li>
				</ul>
            </td>
        </tr>
        
        
        
        
        
        
        
        <tr class="s_m_ins_div" <?= ($has_s_m_ins!== "Yes")?'style="display:none;"':''; ?>> 
        	<td valign="top" colspan="2" class="frmhead">
            	<ul>
            		<li id="foli8" class="complex">	
                  
                        <div>
                            <span>
                                <select id="s_m_ins_type" name="s_m_ins_type" class="field text addr tbox" maxlength="255" style="width:200px;" />
                                     <option>Select Type</option>
                                     <option value="1" <?php if($s_m_ins_type == '1'){ echo " selected='selected'";} ?>>Medicare</option>
                                     <option value="2" <?php if($s_m_ins_type == '2'){ echo " selected='selected'";} ?>>Medicaid</option>
                                     <option value="3" <?php if($s_m_ins_type == '3'){ echo " selected='selected'";} ?>>Tricare Champus</option>
                                     <option value="4" <?php if($s_m_ins_type == '4'){ echo " selected='selected'";} ?>>Champ VA</option>
                                     <option value="5" <?php if($p_m_ins_type == '5'){ echo " selected='selected'";} ?>>Group Health Plan</option>
                                     <option value="6" <?php if($p_m_ins_type == '6'){ echo " selected='selected'";} ?>>FECA BLKLUNG</option>
                                     <option value="7" <?php if($p_m_ins_type == '7'){ echo " selected='selected'";} ?>>Other</option>                                 
                                </select>
                                <label for="s_m_ins_type">Insurance Type</label>
                            </span>
                            <span>
								            <input id="s_m_ins_ass_yes" type="radio" name="s_m_ins_ass" value="Yes" <?php if($s_m_ins_ass == 'Yes'){ echo " checked='checked'";} ?>>Accept Assignment of Benefits &nbsp;&nbsp;&nbsp;&nbsp;<input id="s_m_ins_ass_no" type="radio" name="s_m_ins_ass" value="No" <?php if($s_m_ins_ass == 'No'){ echo " checked='checked'";} ?>>Payment to Patient
                            </span>
                            
						</div>
						<div>
                            
						</div>
                    </li>
				</ul>
            </td>
        </tr>        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        

        
        
        
        
        
        
        
        
        
        
		
		      <?php if((isset($_GET['pid']) && isset($_GET['ed'])) || (isset($_GET['pid']) && isset($_GET['addtopat']))){?>
		    	  <tr>
	      <td colspan="2">
            <font style="color:#0a5da0; font-weight:bold; font-size:16px;">CONTACT SECTION</font>	      
	      </td>
	  </tr>
        
		    <tr>
		        <td class="frmhead" colspan="2">
		        
		        
		       <table id="contactmds" style="float:left;">



                         <tr height="35">

                       <td>
           <span style="padding-left:10px; float:left;">Add medical contacts so they can receive correspondence about this patient.</span>
           <span style="float:left; margin-left:20px;"><input type="button" class="button" style="float:left; width:150px;" onclick="loadPopupRefer('add_contact.php?addtopat=<?php echo $_GET['pid']; ?>&from=add_patient');" value="+ Create New Contact" /></span>

                       <ul>
                        <li  id="foli8" class="complex">
                         <label style="display: block; float: left; width: 110px;">Primary Care MD</label>
                                        <input type="text" id="docpcp_name" style="width:300px;" onclick="updateval(this)" autocomplete="off" name="docpcp_name" value="<?= ($docpcp!='')?$docpcp_name:'Type contact name'; ?>" />
<br />        <div id="docpcp_hints" class="search_hints" style="display:none;">
                <ul id="docpcp_list" class="search_list">
                        <li class="template" style="display:none">Doe, John S</li>
                </ul>
<script type="text/javascript">
$(document).ready(function(){
  setup_autocomplete('docpcp_name', 'docpcp_hints', 'docpcp', '', 'list_contacts.php');
});
</script>
                                        </div>
<input type="hidden" name="docpcp" id="docpcp" value="<?=$docpcp;?>" />
                         </li>
                         </ul>

                         </td>
                         </tr>




              <tr height="35">

                       <td>

                       <ul>
                        <li  id="foli8" class="complex">
                         <label style="display: block; float: left; width: 110px;">ENT</label>
                                        <input type="text" id="docent_name" style="width:300px;" onclick="updateval(this)" autocomplete="off" name="docent_name" value="<?= ($docent!='')?$docent_name:'Type contact name'; ?>" />
<br />        <div id="docent_hints" class="search_hints" style="display:none;">
                <ul id="docent_list" class="search_list">
                        <li class="template" style="display:none">Doe, John S</li>
                </ul>
<script type="text/javascript">
$(document).ready(function(){
  setup_autocomplete('docent_name', 'docent_hints', 'docent', '', 'list_contacts.php');
});
</script>
                                        </div>
<input type="hidden" name="docent" id="docent" value="<?=$docent;?>" />

                         </li>
                         </ul>

                         </td>
                         </tr>



           <tr height="35"> 
		        
		       <td>
            <ul>
		        <li  id="foli8" class="complex">
		        <label style="display: block; float: left; width: 110px;">Sleep MD</label>


                                        <input type="text" id="docsleep_name" style="width:300px;" onclick="updateval(this)" autocomplete="off" name="docsleep_name" value="<?= ($docsleep!='')?$docsleep_name:'Type contact name'; ?>" />
<br />        <div id="docsleep_hints" class="search_hints" style="display:none;">
                <ul id="docsleep_list" class="search_list">
                        <li class="template" style="display:none">Doe, John S</li>
                </ul>
<script type="text/javascript">
$(document).ready(function(){
  setup_autocomplete('docsleep_name', 'docsleep_hints', 'docsleep', '', 'list_contacts.php', 'contact', <?= $_GET['pid']; ?>);
});
</script>
                                        </div>
<input type="hidden" name="docsleep" id="docsleep" value="<?=$docsleep;?>" />
		         </li>
		         </ul>
		          </td>
		         </tr>
		         
		         
		         
		         
		         
		         
		         
		         
		         <tr height="35"> 
		        
		       <td> 
		        
		       <ul>
		        <li  id="foli8" class="complex">
		         <label style="display: block; float: left; width: 110px;">Dentist</label>
                                        <input type="text" id="docdentist_name" style="width:300px;" onclick="updateval(this)" autocomplete="off" name="docdentist_name" value="<?= ($docdentist!='')?$docdentist_name:'Type contact name'; ?>" />
<br />        <div id="docdentist_hints" class="search_hints" style="display:none;">
                <ul id="docdentist_list" class="search_list">
                        <li class="template" style="display:none">Doe, John S</li>
                </ul>
<script type="text/javascript">
$(document).ready(function(){
  setup_autocomplete('docdentist_name', 'docdentist_hints', 'docdentist', '', 'list_contacts.php', 'contact', <?= $_GET['pid']; ?>);
});
</script>
                                        </div>
<input type="hidden" name="docdentist" id="docdentist" value="<?=$docdentist;?>" />

		         </li>
		         </ul>
		         
		         </td>
		         </tr>
             
             
             
             
             
             
             
             
             
             
             
             
             
             
             
             
		         
		         <tr height="35"> 
		        
		       <td> 
		        
		       <ul>
		        <li  id="foli8" class="complex">
		         <label style="display: block; float: left; width: 110px;">Other MD</label>
                                        <input type="text" id="docmdother_name" style="width:300px;" onclick="updateval(this)" autocomplete="off" name="docmdother_name" value="<?= ($docmdother!='')?$docmdother_name:'Type contact name'; ?>" />
<br />        <div id="docmdother_hints" class="search_hints" style="display:none;">
                <ul id="docmdother_list" class="search_list">
                        <li class="template" style="display:none">Doe, John S</li>
                </ul>
<script type="text/javascript">
$(document).ready(function(){
  setup_autocomplete('docmdother_name', 'docmdother_hints', 'docmdother', '', 'list_contacts.php', 'contact', <?= $_GET['pid']; ?>);
});
</script>
                                        </div>
<input type="hidden" name="docmdother" id="docmdother" value="<?=$docmdother;?>" />

		         </li>
		         </ul>
		          
		         </td>
		         </tr>
		         
		         
		        

		         
		         
		         
		         
		         </table>
		        </td>
		        
		        
		        
		        
		         
		         
	
	
	
	
	
	
	
	
	
	
	
	
	
		    </tr>
		    
		    <?php } ?>
		    
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                Patient Status
            </td>
            <td valign="top" class="frmdata">
            	<select name="status" id="status" class="tbox" onchange="updatePPAlert()";>
                	<option value="1" <? if($status == 1) echo " selected";?>>Active</option>
                	<option value="2" <? if($status == 2) echo " selected";?>>In-Active</option>
                </select>
                <br />&nbsp;
            </td>
        </tr>
<script type="text/javascript">
function updatePPAlert(){
  if($('#status').val()==2){
	$('#ppAlert').show();
  }else{
	$('#ppAlert').hide();
  }
}
</script>
<?php if($doc_patient_portal){ ?>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                Portal Status
		<br />
		<span id="ppAlert" style="font-weight:normal;font-size:12px; <?= ($status == 2)?'':'display:none;'; ?>">Patient is in-active and will not be able to access<br />Patient Portal regardless of the setting of this field.</span>
            </td>
            <td valign="top" class="frmdata">
                <select name="use_patient_portal" class="tbox" >
                        <option value="1" <? if($use_patient_portal == 1) echo " selected";?>>Active</option>
                        <option value="0" <? if($use_patient_portal!='' && $use_patient_portal == 0) echo " selected";?>>In-Active</option>
                </select>
                <br />&nbsp;
            </td>
        </tr>
<?php } ?>
       <tr>
       <td valign="top">
				<?php
					$sql = "SELECT generated_date FROM dental_letters WHERE templateid = '3' AND deleted = '0' AND patientid = '". $_GET['pid'] ."' ORDER BY generated_date ASC LIMIT 1;";
					$result = mysql_query($sql);
					$date_generated = mysql_result($result, 0);
					if (mysql_num_rows($result) == 0) {
				?>
         <input id="introletter" name="introletter" type="checkbox" value="1"> Send Intro Letter to DSS patient
				<?php
					} else {
						print "DSS Intro Letter Sent to Patient $date_generated";
					}
				?>
       </td>
       </tr>
        <tr>
            <td  colspan="2" align="right">
                <span class="red">
                    * Required Fields					
                </span><br />
                <input type="hidden" name="patientsub" value="1" />
                <input type="hidden" name="ed" value="<?=$themyarray["patientid"]?>" />
                <input type="submit" value=" <?=$but_text?> Patient" class="button" />
            </td>
        </tr>

    </table>
    </form>





    
  </div>
<div style="margin:0 auto;background:url(images/dss_05.png) no-repeat top left;width:980px; height:28px;"> </div>
  </td>
</tr>
<!-- Stick Footer Section Here -->
</table>
<div id="popupContact" style="width:750px;">
    <a id="popupContactClose"><button>X</button></a>
    <iframe id="aj_pop" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
</div>
<div id="backgroundPopup"></div>
<div id="popupRefer" style="height:550px; width:750px;">
    <a id="popupReferClose"><button>X</button></a>
    <iframe id="aj_ref" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
</div>
<div id="backgroundPopupRef"></div>
<script type="text/javascript">

function updateReferredBy(o, el){
$('#'+el).append(o);

}

function updateContactField(inField, inVal, idField, idVal){
$('#'+inField).val(inVal);
$('#'+idField).val(idVal);
if(inField=="referredby_name"){
  $('#referred_source').val('2');
}
}


</script>
<script type="text/javascript">
var cal1 = new calendar2(document.getElementById('ins_dob'));
</script>
<script type="text/javascript">
var cal2 = new calendar2(document.getElementById('ins2_dob'));
</script>
<script type="text/javascript">
var cal3 = new calendar2(document.getElementById('dob'));
var cal4 = new calendar2(document.getElementById('copyreqdate'));

</script>
</body>
</html>
