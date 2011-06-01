<?php
include "includes/top.htm";
?>
<script type="text/javascript" src="/manage/js/preferred_contact.js"></script>
<script type="text/javascript" src="/manage/js/patient_dob.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
		$(':input').change(function() { 
			window.onbeforeunload = confirmExit;
		});
		$('#patientfrm').submit(function() {
			window.onbeforeunload = null;
		});
	});
  function confirmExit()
  {
    return "You have attempted to leave this page.  If you have made any changes to the fields without clicking the Save button, your changes will be lost.  Are you sure you want to exit this page?";
  }
</script>
<?php
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

if($_POST["patientsub"] == 1)
{
	if($_POST["ed"] != "")
	{
		$ed_sql = "update dental_patients 
		set 
		firstname = '".s_for($_POST["firstname"])."', 
		lastname = '".s_for($_POST["lastname"])."', 
		middlename = '".s_for($_POST["middlename"])."', 
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
		ssn = '".s_for($_POST["ssn"])."', 
		home_phone = '".s_for($_POST["home_phone"])."', 
		work_phone = '".s_for($_POST["work_phone"])."', 
		cell_phone = '".s_for($_POST["cell_phone"])."', 
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
		emp_phone = '".s_for($_POST["emp_phone"])."', 
		emp_fax = '".s_for($_POST["emp_fax"])."', 
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
    emergency_name = '".s_for($_POST["emergency_name"])."',
    emergency_number = '".s_for($_POST["emergency_number"])."',
    docent = '".s_for($_POST["docent"])."',
		emergency_name = '".s_for($_POST["emergency_name"])."',
		emergency_number = '".s_for($_POST["emergency_number"])."',
		referred_source = '".s_for($_POST["referred_source"])."',
		referred_by = '".s_for($_POST["referred_by"])."',
    premedcheck = '".s_for($_POST["premedcheck"])."',
		premed = '".s_for($_POST["premeddet"])."', 
		status = '".s_for($_POST["status"])."',
		preferredcontact = '".s_for($_POST["preferredcontact"])."'
		where 
		patientid='".$_POST["ed"]."'";
		mysql_query($ed_sql) or die($ed_sql." | ".mysql_error());
		
		trigger_letter1and2($_POST['ed']);

		if($_POST['introletter'] == 1) {
		  trigger_letter3($_POST['ed']);
		}

		//echo $ed_sql.mysql_error();
		$msg = "Edited Successfully";
		?>
		<script type="text/javascript">
			//alert("<?=$msg;?>");
			parent.window.location='manage_patient.php?msg=<?=$msg;?>';
		</script>
		<?
		die();
	}
	else
	{
		$ins_sql = "insert 
		into 
		dental_patients 
		set 
		firstname = '".s_for($_POST["firstname"])."', 
		lastname = '".s_for($_POST["lastname"])."', 
		middlename = '".s_for($_POST["middlename"])."', 
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
		ssn = '".s_for($_POST["ssn"])."', 
		home_phone = '".s_for($_POST["home_phone"])."', 
		work_phone = '".s_for($_POST["work_phone"])."', 
		cell_phone = '".s_for($_POST["cell_phone"])."', 
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
		emp_phone = '".s_for($_POST["emp_phone"])."', 
		emp_fax = '".s_for($_POST["emp_fax"])."', 
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
		emergency_number = '".s_for($_POST["emergency_number"])."',
		referred_source = '".s_for($_POST["referred_source"])."',
		referred_by = '".s_for($_POST["referred_by"])."',
		premedcheck = '".s_for($_POST["premedcheck"])."',
		premed = '".s_for($_POST["premeddet"])."',
		userid='".$_SESSION['userid']."', 
		docid='".$_SESSION['docid']."', 
		status = '".s_for($_POST["status"])."',
		adddate=now(),
		ip_address='".$_SERVER['REMOTE_ADDR']."',
		preferredcontact='".s_for($_POST["preferredcontact"])."';";
		mysql_query($ins_sql) or die($ins_sql.mysql_error());
		
                $pid = mysql_insert_id();
   		trigger_letter1and2($pid);

		if($_POST['introletter'] == 1) {
		  trigger_letter3($pid);
		}

		$msg = "Added Successfully";
		?>
		<script type="text/javascript">
			//alert("<?=$msg;?>");
			parent.window.location='manage_patient.php?msg=<?=$msg;?>';
		</script>
		<?
		die();
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
		$salutation = $_POST['salutation'];
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
		$home_phone = $_POST['home_phone'];
		$work_phone = $_POST['work_phone'];
		$cell_phone = $_POST['cell_phone'];
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
		$accept_assignment = $_POST["accept_assignment"];
		$print_signature = $_POST["print_signature"];
		$medical_insurance = $_POST["medical_insurance"];
		$mark_yes = $_POST["mark_yes"];
		$inactive = $_POST["inactive"];
		$partner_name = $_POST["partner_name"];
		$emergency_name = $_POST["emergency_name"];
		$emergency_number = $_POST["emergency_number"];
		$referred_source = $_POST["referred_source"];
		$referred_by = $_POST["referred_by"];
		$premedcheck = $_POST["premedcheck"];
		$premed = $_POST["premeddet"];
		$preferredcontact = $_POST["preferredcontact"];
		
	}
	else
	{
		$firstname = st($themyarray['firstname']);
		$middlename = st($themyarray['middlename']);
		$lastname = st($themyarray['lastname']);
		$salutation = st($themyarray['salutation']);
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
		$home_phone = st($themyarray['home_phone']);
		$work_phone = st($themyarray['work_phone']);
		$cell_phone = st($themyarray['cell_phone']);
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
		$accept_assignment = st($themyarray["accept_assignment"]);
		$print_signature = st($themyarray["print_signature"]);
		$medical_insurance = st($themyarray["medical_insurance"]);
		$mark_yes = st($themyarray["mark_yes"]);
		$docsleep = st($themyarray["docsleep"]);
		$docpcp = st($themyarray["docpcp"]);
		$docdentist = st($themyarray["docdentist"]);
		$docent = st($themyarray["docent"]);
		$docmdother = st($themyarray["docmdother"]);
		$inactive = st($themyarray["inactive"]);
		$partner_name = st($themyarray["partner_name"]);
		$emergency_name = st($themyarray["emergency_name"]);
		$emergency_number = st($themyarray["emergency_number"]);
		$referred_source = st($themyarray["referred_source"]);
		$referred_by = st($themyarray["referred_by"]);
		$premedcheck = st($themyarray["premedcheck"]);
		$premeddet = st($themyarray["premed"]);
		$preferredcontact = st($themyarray["preferredcontact"]);
		$name = st($themyarray['lastname'])." ".st($themyarray['middlename']).", ".st($themyarray['firstname']);
		
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
	?>
	
	<br /><br />
	
	<? if($msg != '') {?>
    <div align="center" class="red">
        <? echo $msg;?>
    </div>
    <? }?>
    <form name="patientfrm" id="patientfrm" action="<?=$_SERVER['PHP_SELF'];?>?add=1" method="post" onSubmit="return patientabc(this);validateDate('dob');validateDate('ins_dob');validateDate('ins2_dob');">
    
    <script language="JavaScript" src="calendar1.js"></script>
<script language="JavaScript" src="calendar2.js"></script>
    
    
    <table width="98%" style="margin-left:11px;" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center">
        <tr>
            <td colspan="2" class="cat_head">
               <?=$but_text?> Patient
               <? if($name <> "") {?>
               		&quot;<?=$name;?>&quot;
               <? }?>
            </td>
        </tr>
        	  <tr>
	      <td colspan="2">
            <font style="color:#0a5da0; font-weight:bold; font-size:16px;">GENERAL INFORMATION</font>	      
	      </td>
	  </tr>
        <tr>
        	<td valign="top" colspan="2" class="frmhead">
				<ul>
                    <li id="foli8" class="complex">	
                        <label class="desc" id="title0" for="Field0">
                            Name
                            <span id="req_0" class="req">*</span>
                        </label>
                        <div>
                            <span>
                                <input id="firstname" name="firstname" type="text" class="field text addr tbox" value="<?=$firstname?>" tabindex="1" maxlength="255" />
                                <label for="firstname">First Name</label>
                            </span>
                            <span>
                                <input id="lastname" name="lastname" type="text" class="field text addr tbox" value="<?=$lastname?>" tabindex="2" maxlength="255" />
                                <label for="lastname">Last Name</label>
                            </span>
                            <span>
                                <input id="middlename" name="middlename" type="text" class="field text addr tbox" value="<?=$middlename?>" tabindex="3" style="width:50px;" maxlength="1" />
                                <label for="middlename">Middle <br />Init</label>
                            </span>
                            <span>
                                <select name="salutation" style="width:80px;" >
                                  <option value="Mr." <?php if($salutation == "Mr."){echo "selected='selected'";} ?>>Mr.</option>
                                  <option value="Mrs." <?php if($salutation == "Mrs."){echo "selected='selected'";} ?>>Mrs.</option>
                                  <option value="Miss." <?php if($salutation == "Miss."){echo "selected='selected'";} ?>>Miss.</option>
                                  <option value="Ms." <?php if($salutation == "Ms."){echo "selected='selected'";} ?>>Ms.</option>
                                  <option value="Dr." <?php if($salutation == "Dr."){echo "selected='selected'";} ?>>Dr.</option>
                                  <option value="Prof." <?php if($salutation == "Prof."){echo "selected='selected'";} ?>>Prof.</option>                                
                                </select>
                                <label for="salutation">Salutation</label>
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
        </tr>
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
                                <input id="add1" name="add1" type="text" class="field text addr tbox" value="<?=$add1?>" tabindex="5" style="width:325px;"  maxlength="255"/>
                                <label for="add1">Address1</label>
                            </span>
                            <span>
                                <input id="add2" name="add2" type="text" class="field text addr tbox" value="<?=$add2?>" tabindex="6" style="width:325px;" maxlength="255" />
                                <label for="add2">Address2</label>
                            </span>
                        </div>
                        <div>
                            <span>
                                <input id="city" name="city" type="text" class="field text addr tbox" value="<?=$city?>" tabindex="7" style="width:200px;" maxlength="255" />
                                <label for="city">City</label>
                            </span>
                            <span>
                                <input id="state" name="state" type="text" class="field text addr tbox" value="<?=$state?>" tabindex="8" style="width:25px;" maxlength="2" />
                                <label for="state">State</label>
                            </span>
                            <span>
                                <input id="zip" name="zip" type="text" class="field text addr tbox" value="<?=$zip?>" tabindex="9" style="width:80px;" maxlength="255" />
                                <label for="zip">Zip / Post Code </label>
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
                        <div>
                            <span>
                                <input id="dob" name="dob" type="text" class="field text addr tbox" value="<?=$dob?>" tabindex="10" style="width:100px;" maxlength="255" onChange="validateDate('dob');"  value="example 11/11/1234" /><span id="req_0" class="req">*</span>
                                <label for="dob">Birthday</label>
                            </span>
                            <span>
                            	<select name="gender" id="gender" class="field text addr tbox" style="width:100px;" tabindex="11">
                                	<option value="">Select</option>
                                    <option value="Male" <? if($gender == 'Male') echo " selected";?>>Male</option>
                                    <option value="Female" <? if($gender == 'Female') echo " selected";?>>Female</option>
                                </select><span id="req_0" class="req">*</span>
                                <label for="gender">Gender</label>
                            </span>
                            
                            <span>
                            	<select name="marital_status" id="marital_status" class="field text addr tbox" style="width:130px;" tabindex="12">
                                	<option value="">Select</option>
                                    <option value="Married" <? if($marital_status == 'Married') echo " selected";?>>Married</option>
                                    <option value="Single" <? if($marital_status == 'Single') echo " selected";?>>Un-Married</option>
									<option value="Life Partner" <? if($marital_status == 'Life Partner') echo " selected";?>>Life Partner</option>
                                </select>
                                <label for="marital_status">Marital Status</label>
                            </span>
							<span>
                                <input id="partner_name" name="partner_name" type="text" class="field text addr tbox" value="<?=$partner_name?>" tabindex="13" maxlength="255" />
                                <label for="partner_name">Partner Name</label>
                            </span>
						</div>
						<div>
                            <span>
                                <input id="ssn" name="ssn" type="text" class="field text addr tbox" value="<?=$ssn?>" tabindex="13" maxlength="255" />
                                <label for="ssn">Patient's Soc Sec No.</label>
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
                    	<!--<label class="desc" id="title0" for="Field0">
                            Optional Fields (not used in letters)
                        </label>-->
                        <div>
                            <span>
                                <input id="home_phone" name="home_phone" type="text" class="field text addr tbox" value="<?=$home_phone?>" tabindex="14" maxlength="255" style="width:200px;" />
                                <label for="home_phone">Home Phone
																<span id="req_0" class="req">*</span>
																</label>
                            </span>
                            <span>
                                <input id="work_phone" name="work_phone" type="text" class="field text addr tbox" value="<?=$work_phone?>" tabindex="15" maxlength="255" style="width:200px;" />
                                <label for="work_phone">Work Phone</label>
                            </span>
                            <span>
                                <input id="cell_phone" name="cell_phone" type="text" class="field text addr tbox" value="<?=$cell_phone?>" tabindex="16" maxlength="255" style="width:200px;" />
                                <label for="cell_phone">Cell Phone</label>
                            </span>
						</div>
                        <div>
                            <span>
                                <input id="email" name="email" type="text" class="field text addr tbox" value="<?=$email?>" tabindex="17" maxlength="255" style="width:325px;" />
                                <label for="email">Email</label>
                            </span>
                        </div>
                        <div>
                            <span>
                            	<textarea name="patient_notes"  id="patient_notes" class="field text addr tbox" style="width:610px;" tabindex="18"><?=$patient_notes;?></textarea>
                                <label for="patient_notes">Patient Notes</label>
                            </span>
                        </div>
                    </li>
				</ul>
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="20%">
                Preferred Contact Method
            </td>
            <td valign="top" class="frmdata" width="80%">
            	<select id="preferredcontact" name="preferredcontact" class="tbox" tabindex="22">
                	<option value="paper" <? if($preferredcontact == 'paper') echo " selected";?>>Paper Mail</option>
                	<option value="email" <? if($preferredcontact == 'email') echo " selected";?>>Email</option>
                </select>
                <br />&nbsp;
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
                            <span class="left">
                                <input id="emergency_name" name="emergency_name" type="text" class="field text addr tbox" value="<?=$emergency_name?>" maxlength="255" style="width:300px;" />
                                <label for="home_phone">Name</label>
                            </span>
                            <span class="right">
                                <input id="emergency_number" name="emergency_number" type="text" class="field text addr tbox" value="<?=$emergency_number?>" maxlength="255" style="width:300px;" />
                                <label for="emergency_number">Number</label>
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
                           &nbsp;
                        </label>
                        <div>
                            
                            <span class="left">
								<?
								$referredby_sql = "select * from dental_referredby where status=1 and docid='".$_SESSION['docid']."' order by firstname";
								$referredby_my = mysql_query($referredby_sql);
								?>
								<select name="referred_by" class="field text addr tbox">
									<option value=""></option>
									<? while($referredby_myarray = mysql_fetch_array($referredby_my)) 
									{
										$ref_name = st($referredby_myarray['salutation'])." ".st($referredby_myarray['firstname'])." ".st($referredby_myarray['middlename'])." ".st($referredby_myarray['lastname']);
									?>
										<option value="<?=st($referredby_myarray['referredbyid'])?>" <? if($referred_by == st($referredby_myarray['referredbyid']) ) echo " selected";?>>
											<?=$ref_name;?>
										</option>
									<? }?>
								</select>
							
                               <!-- <input id="referred_by" name="referred_by" type="text" class="field text addr tbox" value="<?=$referred_by?>" maxlength="255" style="width:300px;" /> -->
                                <label for="referred_by">Referred By</label><a href="add_referredby.php?addtopat=<?php echo $_GET['ed']; ?>">Add New Referrer</a>
                            </span>
                            
                            
                            
                            <span class="right">
								<select name="referred_source" id="referred_source" class="field text addr tbox" style="width:300px;" >
                  <option value="">Select</option>
                  <option value="Patient" <? if($referred_source == 'Patient') echo " selected";?>>Patient</option>
                  <option value="Physician" <? if($referred_source == 'Physician') echo " selected";?>>Physician</option>
									<option value="Media" <? if($referred_source == 'Media') echo " selected";?>>Media</option>
									<option value="Franchise" <? if($referred_source == 'Franchise') echo " selected";?>>Franchise</option>
									<option value="DSS Office" <? if($referred_source == 'DSS Office') echo " selected";?>>DSS Office</option>
									<option value="Other" <? if($referred_source == 'Other') echo " selected";?>>Other</option>
                                </select>
                                <label for="referred_source">Referred Source</label>
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
                            Primary Medical &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;DSS filing insurance?<input id="p_m_dss_file_yes" type="radio" name="p_m_dss_file" value="1" <? if($p_m_dss_file == '1') echo "checked='checked'";?>>Yes&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="p_m_dss_file" value="2" <? if($p_m_dss_file == '2') echo "checked='checked'";?>>No
                        </label>
                        <div>
                            <span>
                                <input id="p_m_partyfname" name="p_m_partyfname" type="text" class="field text addr tbox" value="<?=$p_m_partyfname?>" maxlength="255" style="width:150px;" /><input id="p_m_partymname" name="p_m_partymname" type="text" class="field text addr tbox" value="<?=$p_m_partymname?>" maxlength="255" style="width:50px;" /><input id="p_m_partylname" name="p_m_partylname" type="text" class="field text addr tbox" value="<?=$p_m_partylname?>" maxlength="255" style="width:150px;" />
                                <label for="p_m_partyfname">Insured party First&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Middle&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Last</label>
                            </span>
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
                                <input id="ins_dob" name="ins_dob" type="text" class="field text addr tbox" value="<?=$ins_dob?>" maxlength="255" style="width:200px;" onChange="validateDate('ins_dob');" />
                                <label for="ins_dob">Insured Date of Birth</label>
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
                                <select id="p_m_ins_co" name="p_m_ins_co" class="field text addr tbox" maxlength="255" style="width:200px;" />
																	<option value="">Select Insurance Company</option>
                            <?php
                            $ins_contact_qry = "SELECT * FROM `dental_contact` WHERE contacttypeid = '11'";
                            $ins_contact_qry_run = mysql_query($ins_contact_qry);
                            while($ins_contact_res = mysql_fetch_array($ins_contact_qry_run)){
                            ?>
                                <option value="<?php echo $ins_contact_res['contactid']; ?>" <?php if($p_m_ins_co == $ins_contact_res['contactid']){echo "selected='selected'";} ?>><?php echo $ins_contact_res['company']; ?></option>
                                
                                <?php } ?>
                                </select>
                                <label for="p_m_ins_co">Insurance Co.</label><br />
                                <a onclick="Javascript: window.location.href='add_contact.php<?php if(isset($_GET['pid'])){echo "?pid=".$_GET['pid']."&type=11&ctypeeq=1&activePat=".$_GET['pid'];} ?>';" href="javascript:scroll(0,0)">Add Insurance Company</a>
                            </span>
                            <span>
								 <input id="p_m_party" name="p_m_ins_id" type="text" class="field text addr tbox" value="<?=$p_m_ins_id?>" maxlength="255" style="width:200px;" />
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
                    	<label class="desc" id="title0" for="Field0">
                            Secondary Medical  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;DSS filing insurance?<input id="s_m_dss_file_yes" type="radio" name="s_m_dss_file" value="1" <? if($s_m_dss_file == '1') echo "checked='checked'";?>>Yes&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="s_m_dss_file" value="2" <? if($s_m_dss_file == '2') echo "checked='checked'";?>>No
                        </label>
                        <div>
                            <span>
                                <input id="s_m_partyfname" name="s_m_partyfname" type="text" class="field text addr tbox" value="<?=$s_m_partyfname?>" maxlength="255" style="width:150px;" /><input id="s_m_partymname" name="s_m_partymname" type="text" class="field text addr tbox" value="<?=$s_m_partymname?>" maxlength="255" style="width:50px;" /><input id="s_m_partylname" name="s_m_partylname" type="text" class="field text addr tbox" value="<?=$s_m_partylname?>" maxlength="255" style="width:150px;" />
                                <label for="s_m_partyfname">Insured party First&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Middle&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Last</label>
                            </span>
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
                                <input id="ins2_dob" name="ins2_dob" type="text" class="field text addr tbox" value="<?=$ins2_dob?>" maxlength="255" style="width:200px;" onChange="validateDate('ins2_dob');" />
                                <label for="ins2_dob">Insured Date of Birth</label>
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
                             <select id="s_m_ins_co" name="s_m_ins_co" class="field text addr tbox" maxlength="255" style="width:200px;" />
															<option value="">Select Insurance Company</option>
                            <?php
                            $ins_contact_qry = "SELECT * FROM `dental_contact` WHERE contacttypeid = '11'";
                            $ins_contact_qry_run = mysql_query($ins_contact_qry);
                            while($ins_contact_res = mysql_fetch_array($ins_contact_qry_run)){
                            ?>
                                <option value="<?php echo $ins_contact_res['contactid']; ?>" <?php if($s_m_ins_co == $ins_contact_res['contactid']){echo "selected='selected'";} ?>><?php echo $ins_contact_res['company']; ?></option>
                                
                                <?php } ?>
                                </select>
                                <label for="s_m_ins_co">Insurance Co.</label><br />
                                <a onclick="Javascript: window.location.href='add_contact.php<?php if(isset($_GET['pid'])){echo "?pid=".$_GET['pid']."&type=11&ctypeeq=1&activePat=".$_GET['pid'];} ?>';" href="javascript:scroll(0,0)">Add Insurance Company</a>
                            </span>
                            <span>
								 <input id="s_m_party" name="s_m_ins_id" type="text" class="field text addr tbox" value="<?=$s_m_ins_id?>" maxlength="255" style="width:200px;" />
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
                                <input id="employer" name="employer" type="text" class="field text addr tbox" value="<?php echo $employer; ?>" style="width:525px;"  maxlength="255"/>
                                <label for="add1">Employer</label>
                            </span>
                        </div>
                        <div>
                            <span>
                                <input id="emp_add1" name="emp_add1" type="text" class="field text addr tbox" value="<?=$emp_add1?>" style="width:325px;"  maxlength="255"/>
                                <label for="add1">Address1</label>
                            </span>
                            <span>
                                <input id="emp_add2" name="emp_add2" type="text" class="field text addr tbox" value="<?=$emp_add2?>" style="width:325px;" maxlength="255" />
                                <label for="add2">Address2</label>
                            </span>
                        </div>
                        <div>
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
							<span>
                                <input id="emp_phone" name="emp_phone" type="text" class="field text addr tbox" value="<?=$emp_phone?>"  style="width:120px;" maxlength="255" />
                                <label for="state">&nbsp;&nbsp;Phone</label>
                            </span>
							<span>
                                <input id="emp_fax" name="emp_fax" type="text" class="field text addr tbox" value="<?=$emp_fax?>"  style="width:120px;" maxlength="255" />
                                <label for="state">Fax</label>
                            </span>
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
		        <td class="frmhead" colspan="1" valign="top">
		        <ul>
		        <li  id="foli8" class="complex">
		        <label for="Field0" id="title0" class="desc">
                            Contacts:
                        </label>
		         <div>
		         <?php include('contact_includes.php'); ?>
		         </div>
		         </li>
		         </ul>
		        </td>
		        
		        <td class="frmhead" colspan="1">
		        
		        
		       <table id="contactmds">
           <tr height="35"> 
		        
		       <td>
           <font style="padding-left:10px;">Add Contact to left then assign here:</font> 
		        <p>&nbsp;</p>
            <ul>
		        <li  id="foli8" class="complex">
		        <label style="display: block; float: left; width: 110px;">Sleep MD</label>
		        <select name="docsleep" id="textfield6" style="width:150px;" />
<option>Not Set</option>
<?php
                $patid=$_GET['ed'];
               $pcont_qry = "SELECT * FROM dental_pcont WHERE patient_id=".$patid;
 $pcont_array = mysql_query($pcont_qry);


 $pcont_qry = "SELECT * FROM dental_pcont LEFT JOIN dental_contact ON dental_pcont.contact_id = dental_contact.contactid WHERE dental_pcont.patient_id=".$patid." UNION SELECT * FROM dental_pcont RIGHT JOIN dental_contact ON dental_pcont.contact_id = dental_contact.contactid WHERE dental_pcont.patient_id=".$patid;
 $pcont_array = mysql_query($pcont_qry);

?>

<?php 
 while($pcont_l = mysql_fetch_array($pcont_array)){
 
?>

<?php

if($pcont_l['contacttypeid'] != '0'){
$type_check = "SELECT contacttype FROM dental_contacttype WHERE contacttypeid=".$pcont_l['contacttypeid'];
$type_query = mysql_query($type_check);
$type_array = mysql_fetch_array($type_query);
$currentcontact_type = $type_array['contacttype'];
}else{
$currentcontact_type = "Type Not Set";
}

if($docsleep == $pcont_l['contactid']){
$selected = "selected=\"selected\"";
}else{
$selected = " ";
}



echo "<option value=\"". $pcont_l['contactid'] ."\"". $selected .">".$pcont_l['firstname']." ".$pcont_l['lastname']." - ". $currentcontact_type ."</option>";
?>

<?php 
 }
?>
              
      </select>
      
		
		         </li>
		         </ul>
		          </td>
		         </tr>
		         
		         
		         
		         
		         
		         
		         
		         
		         <tr height="35"> 
		        
		       <td> 
		        
		       <ul>
		        <li  id="foli8" class="complex">
		         <label style="display: block; float: left; width: 110px;">Primary Care MD</label>
		        <select name="docpcp" id="textfield6" style="width:150px;" />
<option>Not Set</option>
<?php
                $patid=$_GET['ed'];
               $pcont_qry = "SELECT * FROM dental_pcont WHERE patient_id=".$patid;
 $pcont_array = mysql_query($pcont_qry);


 $pcont_qry = "SELECT * FROM dental_pcont LEFT JOIN dental_contact ON dental_pcont.contact_id = dental_contact.contactid WHERE dental_pcont.patient_id=".$patid." UNION SELECT * FROM dental_pcont RIGHT JOIN dental_contact ON dental_pcont.contact_id = dental_contact.contactid WHERE dental_pcont.patient_id=".$patid;
 $pcont_array = mysql_query($pcont_qry);

?>

<?php 
 while($pcont_l = mysql_fetch_array($pcont_array)){
 
?>

<?php

if($pcont_l['contacttypeid'] != '0'){
$type_check = "SELECT contacttype FROM dental_contacttype WHERE contacttypeid=".$pcont_l['contacttypeid'];
$type_query = mysql_query($type_check);
$type_array = mysql_fetch_array($type_query);
$currentcontact_type = $type_array['contacttype'];
}else{
$currentcontact_type = "Type Not Set";
}

if($docpcp == $pcont_l['contactid']){
$selected = "selected=\"selected\"";
}else{
$selected = " ";
}



echo "<option value=\"". $pcont_l['contactid'] ."\"". $selected .">".$pcont_l['firstname']." ".$pcont_l['lastname']." - ". $currentcontact_type ."</option>";
?>

<?php 
 }
?>
              
      </select>
      
		
		         </li>
		         </ul>
		         
		         </td>
		         </tr>
		         
		         
		         
		         
		         
		         
		         
		         <tr height="35"> 
		        
		       <td> 
		        
		       <ul>
		        <li  id="foli8" class="complex">
		         <label style="display: block; float: left; width: 110px;">Dentist</label>
		        <select name="docdentist" id="textfield6" style="width:150px;" />
<option>Not Set</option>
<?php
                $patid=$_GET['ed'];
               $pcont_qry = "SELECT * FROM dental_pcont WHERE patient_id=".$patid;
 $pcont_array = mysql_query($pcont_qry);


 $pcont_qry = "SELECT * FROM dental_pcont LEFT JOIN dental_contact ON dental_pcont.contact_id = dental_contact.contactid WHERE dental_pcont.patient_id=".$patid." UNION SELECT * FROM dental_pcont RIGHT JOIN dental_contact ON dental_pcont.contact_id = dental_contact.contactid WHERE dental_pcont.patient_id=".$patid;
 $pcont_array = mysql_query($pcont_qry);

?>

<?php 
 while($pcont_l = mysql_fetch_array($pcont_array)){
 
?>

<?php

if($pcont_l['contacttypeid'] != '0'){
$type_check = "SELECT contacttype FROM dental_contacttype WHERE contacttypeid=".$pcont_l['contacttypeid'];
$type_query = mysql_query($type_check);
$type_array = mysql_fetch_array($type_query);
$currentcontact_type = $type_array['contacttype'];
}else{
$currentcontact_type = "Type Not Set";
}

if($docdentist == $pcont_l['contactid']){
$selected = "selected=\"selected\"";
}else{
$selected = " ";
}



echo "<option value=\"". $pcont_l['contactid'] ."\"". $selected .">".$pcont_l['firstname']." ".$pcont_l['lastname']." - ". $currentcontact_type ."</option>";
?>

<?php 
 }
?>
              
      </select>
      

		         </li>
		         </ul>
		         
		         </td>
		         </tr>
             
             
             
             
             
             
             
             
             
             
             
             
             
             
             
             
              <tr height="35"> 
		        
		       <td> 
		        
		       <ul>
		        <li  id="foli8" class="complex">
		         <label style="display: block; float: left; width: 110px;">ENT</label>
		        <select name="docent" id="textfield6" style="width:150px;" />
<option>Not Set</option>
<?php
                $patid=$_GET['ed'];
               $pcont_qry = "SELECT * FROM dental_pcont WHERE patient_id=".$patid;
 $pcont_array = mysql_query($pcont_qry);


 $pcont_qry = "SELECT * FROM dental_pcont LEFT JOIN dental_contact ON dental_pcont.contact_id = dental_contact.contactid WHERE dental_pcont.patient_id=".$patid." UNION SELECT * FROM dental_pcont RIGHT JOIN dental_contact ON dental_pcont.contact_id = dental_contact.contactid WHERE dental_pcont.patient_id=".$patid;
 $pcont_array = mysql_query($pcont_qry);

?>

<?php 
 while($pcont_l = mysql_fetch_array($pcont_array)){
 
?>

<?php

if($pcont_l['contacttypeid'] != '0'){
$type_check = "SELECT contacttype FROM dental_contacttype WHERE contacttypeid=".$pcont_l['contacttypeid'];
$type_query = mysql_query($type_check);
$type_array = mysql_fetch_array($type_query);
$currentcontact_type = $type_array['contacttype'];
}else{
$currentcontact_type = "Type Not Set";
}

if($docent == $pcont_l['contactid']){
$selected = "selected=\"selected\"";
}else{
$selected = " ";
}



echo "<option value=\"". $pcont_l['contactid'] ."\"". $selected .">".$pcont_l['firstname']." ".$pcont_l['lastname']." - ". $currentcontact_type ."</option>";
?>

<?php 
 }
?>
              
      </select>
	
		         </li>
		         </ul>
		         
		         </td>
		         </tr>
		         
		         
		         
		         
		         
		         
		         
		         
		         <tr height="35"> 
		        
		       <td> 
		        
		       <ul>
		        <li  id="foli8" class="complex">
		         <label style="display: block; float: left; width: 110px;">Other MD</label>
		        <select name="docmdother" id="textfield6" style="width:150px;" />
<option>Not Set</option>
<?php
                $patid=$_GET['ed'];
               $pcont_qry = "SELECT * FROM dental_pcont WHERE patient_id=".$patid;
 $pcont_array = mysql_query($pcont_qry);


 $pcont_qry = "SELECT * FROM dental_pcont LEFT JOIN dental_contact ON dental_pcont.contact_id = dental_contact.contactid WHERE dental_pcont.patient_id=".$patid." UNION SELECT * FROM dental_pcont RIGHT JOIN dental_contact ON dental_pcont.contact_id = dental_contact.contactid WHERE dental_pcont.patient_id=".$patid;
 $pcont_array = mysql_query($pcont_qry);

?>

<?php 
 while($pcont_l = mysql_fetch_array($pcont_array)){
 
?>

<?php

if($pcont_l['contacttypeid'] != '0'){
$type_check = "SELECT contacttype FROM dental_contacttype WHERE contacttypeid=".$pcont_l['contacttypeid'];
$type_query = mysql_query($type_check);
$type_array = mysql_fetch_array($type_query);
$currentcontact_type = $type_array['contacttype'];
}else{
$currentcontact_type = "Type Not Set";
}

if($docmdother == $pcont_l['contactid']){
$selected = "selected=\"selected\"";
}else{
$selected = " ";
}



echo "<option value=\"". $pcont_l['contactid'] ."\"". $selected .">".$pcont_l['firstname']." ".$pcont_l['lastname']." - ". $currentcontact_type ."</option>";
?>

<?php 
 }
?>
              
      </select>
      
		
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
                Status
            </td>
            <td valign="top" class="frmdata">
            	<select name="status" class="tbox" tabindex="19">
                	<option value="1" <? if($status == 1) echo " selected";?>>Active</option>
                	<option value="2" <? if($status == 2) echo " selected";?>>In-Active</option>
                </select>
                <br />&nbsp;
            </td>
        </tr>
       <tr>
       <td valign="top">
         <input id="introletter" name="introletter" tabindex="20" type="checkbox" value="1"> Send Intro Letter to DSS patient
       </td>
       </tr>
        <tr>
            <td  colspan="2" align="center">
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
<script type="text/javascript">
var cal1 = new calendar2(document.getElementById('ins_dob'));
</script>
<script type="text/javascript">
var cal2 = new calendar2(document.getElementById('ins2_dob'));
</script>
<script type="text/javascript">
var cal3 = new calendar2(document.getElementById('dob'));
</script>
</body>
</html>
