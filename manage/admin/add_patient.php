<?php 
session_start();
require_once('includes/main_include.php');
include("includes/sescheck.php");
$docid = $_REQUEST['docid'];
if(!empty($_POST["patientsub"]) && $_POST["patientsub"] == 1)
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
		ssn = '".s_for(num($_POST["ssn"], false))."', 
		home_phone = '".s_for(num($_POST["home_phone"]))."', 
		work_phone = '".s_for(num($_POST["work_phone"]))."', 
		cell_phone = '".s_for(num($_POST["cell_phone"]))."', 
		email = '".s_for($_POST["email"])."', 
		patient_notes = '".s_for($_POST["patient_notes"])."',
    docid = '".s_for($_POST["docid"])."', 
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
    emergency_name = '".s_for($_POST["emergency_name"])."',
    emergency_number = '".s_for(num($_POST["emergency_number"]))."',
    docent = '".s_for($_POST["docent"])."',
		emergency_name = '".s_for($_POST["emergency_name"])."',
		emergency_number = '".s_for(num($_POST["emergency_number"]))."',
		referred_source = '".s_for($_POST["referred_source"])."',
		referred_by = '".s_for($_POST["referred_by"])."',
    premedcheck = '".s_for($_POST["premedcheck"])."',
		premed = '".s_for($_POST["premeddet"])."', 
		status = '".s_for($_POST["status"])."' 
		where 
		patientid='".$_POST["ed"]."'";
		mysqli_query($con,$ed_sql) or die($ed_sql." | ".mysqli_error($con));
		
		//echo $ed_sql.mysqli_error($con);
		$msg = "Edited Successfully";
		?>
		<script type="text/javascript">
			//alert("<?php echo $msg;?>");
			parent.window.location='manage_patient.php?msg=<?php echo $msg;?>&docid=<?php echo($_REQUEST["docid"]); ?>';
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
    member_no = '".s_for(!empty($_POST['member_no']) ? $_POST['member_no'] : '')."',
	  group_no = '".s_for(!empty($_POST['group_no']) ? $_POST['group_no'] : '')."',
	  plan_no = '".s_for(!empty($_POST["plan_no"]) ? $_POST["plan_no"] : '')."',  
		add1 = '".s_for($_POST["add1"])."', 
		add2 = '".s_for($_POST["add2"])."', 
		city = '".s_for($_POST["city"])."', 
		state = '".s_for($_POST["state"])."', 
		zip = '".s_for($_POST["zip"])."', 
		dob = '".s_for($_POST["dob"])."', 
		gender = '".s_for($_POST["gender"])."', 
		marital_status = '".s_for($_POST["marital_status"])."', 
		ssn = '".s_for(num($_POST["ssn"], false))."', 
		home_phone = '".s_for(num($_POST["home_phone"]))."', 
		work_phone = '".s_for(num($_POST["work_phone"]))."', 
		cell_phone = '".s_for(num($_POST["cell_phone"]))."', 
		email = '".s_for($_POST["email"])."', 
		patient_notes = '".s_for($_POST["patient_notes"])."',
    docid = '".s_for($_POST["docid"])."', 
		p_d_party = '".s_for(!empty($_POST["p_d_party"]) ? $_POST["p_d_party"] : '')."', 
		p_d_relation = '".s_for(!empty($_POST["p_d_relation"]) ? $_POST["p_d_relation"] : '')."', 
		p_d_other = '".s_for(!empty($_POST["p_d_other"]) ? $_POST["p_d_other"] : '')."', 
		p_d_employer = '".s_for(!empty($_POST["p_d_employer"]) ? $_POST["p_d_employer"] : '')."', 
		p_d_ins_co = '".s_for(!empty($_POST["p_d_ins_co"]) ? $_POST["p_d_ins_co"] : '')."', 
		p_d_ins_id = '".s_for(!empty($_POST["p_d_ins_id"]) ? $_POST["p_d_ins_id"] : '')."', 
		s_d_party = '".s_for(!empty($_POST["s_d_party"]) ? $_POST["s_d_party"] : '')."', 
		s_d_relation = '".s_for(!empty($_POST["s_d_relation"]) ? $_POST["s_d_relation"] : '')."', 
		s_d_other = '".s_for(!empty($_POST["s_d_other"]) ? $_POST["s_d_other"] : '')."', 
		s_d_employer = '".s_for(!empty($_POST["s_d_employer"]) ? $_POST["s_d_employer"] : '')."', 
		s_d_ins_co = '".s_for(!empty($_POST["s_d_ins_co"]) ? $_POST["s_d_ins_co"] : '')."', 
		s_d_ins_id = '".s_for(!empty($_POST["s_d_ins_id"]) ? $_POST["s_d_ins_id"] : '')."', 
		p_m_partyfname = '".s_for(!empty($_POST["p_m_partyfname"]) ? $_POST["p_m_partyfname"] : '')."',
    p_m_partymname = '".s_for($_POST["p_m_partymname"])."',
    p_m_partylname = '".s_for($_POST["p_m_partylname"])."',  
		p_m_relation = '".s_for($_POST["p_m_relation"])."', 
		p_m_other = '".s_for(!empty($_POST["p_m_other"]) ? $_POST["p_m_other"] : '')."', 
		p_m_employer = '".s_for(!empty($_POST["p_m_employer"]) ? $_POST["p_m_employer"] : '')."', 
		p_m_ins_co = '".s_for($_POST["p_m_ins_co"])."', 
		p_m_ins_id = '".s_for($_POST["p_m_ins_id"])."', 
		s_m_partyfname = '".s_for($_POST["s_m_partyfname"])."',
    s_m_partymname = '".s_for($_POST["s_m_partymname"])."',
    s_m_partylname = '".s_for($_POST["s_m_partylname"])."',  
		s_m_relation = '".s_for($_POST["s_m_relation"])."', 
		s_m_other = '".s_for(!empty($_POST["s_m_other"]) ? $_POST["s_m_other"] : '')."', 
		s_m_employer = '".s_for(!empty($_POST["s_m_employer"]) ? $_POST["s_m_employer"] : '')."', 
		s_m_ins_co = '".s_for($_POST["s_m_ins_co"])."', 
		s_m_ins_id = '".s_for($_POST["s_m_ins_id"])."',
    p_m_ins_grp = '".s_for($_POST["p_m_ins_grp"])."',
    s_m_ins_grp = '".s_for($_POST["s_m_ins_grp"])."',
    p_m_dss_file = '".s_for(!empty($_POST["p_m_dss_file"]) ? $_POST["p_m_dss_file"] : '')."',
    s_m_dss_file = '".s_for(!empty($_POST["s_m_dss_file"]) ? $_POST["s_m_dss_file"] : '')."',
    p_m_ins_type = '".s_for($_POST["p_m_ins_type"])."',
    s_m_ins_type = '".s_for($_POST["s_m_ins_type"])."',
    p_m_ins_ass = '".s_for(!empty($_POST["p_m_ins_ass"]) ? $_POST["p_m_ins_ass"] : '')."',
    s_m_ins_ass = '".s_for(!empty($_POST["s_m_ins_ass"]) ? $_POST["s_m_ins_ass"] : '')."',
    p_m_ins_plan = '".s_for($_POST["p_m_ins_plan"])."',
    s_m_ins_plan = '".s_for($_POST["s_m_ins_plan"])."',
    ins_dob = '".s_for($_POST["ins_dob"])."',
    ins2_dob = '".s_for(!empty($_POST["ins2_dob"]) ? $_POST["ins2_dob"] : '')."', 
		employer = '".s_for($_POST["employer"])."', 
		emp_add1 = '".s_for($_POST["emp_add1"])."', 
		emp_add2 = '".s_for($_POST["emp_add2"])."', 
		emp_city = '".s_for($_POST["emp_city"])."', 
		emp_state = '".s_for($_POST["emp_state"])."', 
		emp_zip = '".s_for($_POST["emp_zip"])."', 
		emp_phone = '".s_for(num($_POST["emp_phone"]))."', 
		emp_fax = '".s_for(num($_POST["emp_fax"]))."', 
		plan_name = '".s_for(!empty($_POST["plan_name"]) ? $_POST["plan_name"] : '')."', 
		group_number = '".s_for(!empty($_POST["group_number"]) ? $_POST["group_number"] : '')."', 
		ins_type = '".s_for(!empty($_POST["ins_type"]) ? $_POST["ins_type"] : '')."', 
		accept_assignment = '".s_for(!empty($_POST["accept_assignment"]) ? $_POST["accept_assignment"] : '')."', 
		print_signature = '".s_for(!empty($_POST["print_signature"]) ? $_POST["print_signature"] : '')."', 
		medical_insurance = '".s_for(!empty($_POST["medical_insurance"]) ? $_POST["medical_insurance"] : '')."', 
		mark_yes = '".s_for(!empty($_POST["mark_yes"]) ? $_POST["mark_yes"] : '')."', 
		inactive = '".s_for(!empty($_POST["inactive"]) ? $_POST["inactive"] : '')."',
    docsleep = '".s_for(!empty($_POST["docsleep"]) ? $_POST["docsleep"] : '')."',
		docpcp = '".s_for(!empty($_POST["docpcp"]) ? $_POST["docpcp"] : '')."',
		docdentist = '".s_for(!empty($_POST["docdentist"]) ? $_POST["docdentist"] : '')."',
		docent = '".s_for(!empty($_POST["docent"]) ? $_POST["docent"] : '')."',
		docmdother = '".s_for(!empty($_POST["docmdother"]) ? $_POST["docmdother"] : '')."', 
		partner_name = '".s_for($_POST["partner_name"])."', 
		emergency_name = '".s_for($_POST["emergency_name"])."',
		emergency_number = '".s_for(num($_POST["emergency_number"]))."',
		referred_source = '".s_for($_POST["referred_source"])."',
		referred_by = '".s_for($_POST["referred_by"])."',
		premedcheck = '".s_for((!empty($_POST["premedcheck"]) ? $_POST["premedcheck"] : ''))."',
		premed = '".s_for((!empty($_POST["premeddet"]) ? $_POST["premeddet"] : ''))."',
		userid='".(!empty($_SESSION['userid']) ? $_SESSION['userid'] : '')."',  
		status = '".s_for($_POST["status"])."',
		adddate=now(),
		ip_address='".$_SERVER['REMOTE_ADDR']."'";
		mysqli_query($con,$ins_sql) or die($ins_sql.mysqli_error($con));
		
		$msg = "Added Successfully";
		?>
		<script type="text/javascript">
			//alert("<?php echo $msg;?>");
			parent.window.location='manage_patient.php?msg=<?php echo $msg;?>&docid=<?php echo($_REQUEST["docid"]); ?>';
		</script>
		<?
		die();
	}
}

?>

<?php require_once dirname(__FILE__) . '/includes/popup_top.htm'; ?>

    <?
    $thesql = "select * from dental_patients where patientid='".(!empty($_REQUEST["ed"]) ? $_REQUEST["ed"] : '')."'";
	$themy = mysqli_query($con,$thesql);
	$themyarray = mysqli_fetch_array($themy);
	
	if(!empty($msg) || !isset($_REQUEST["ed"]))
	{
		$firstname = (!empty($_POST['firstname']) ? $_POST['firstname'] : '');
		$middlename = (!empty($_POST['middlename']) ? $_POST['middlename'] : '');
		$lastname = (!empty($_POST['lastname']) ? $_POST['lastname'] : '');
		$salutation = (!empty($_POST['salutation']) ? $_POST['salutation'] : '');
		$member_no = (!empty($_POST['member_no']) ? $_POST['member_no'] : '');
	  $group_no = (!empty($_POST['group_no']) ? $_POST['group_no'] : '');
	  $plan_no = (!empty($_POST['plan_no']) ? $_POST['plan_no'] : '');
		$dob = (!empty($_POST['dob']) ? $_POST['dob'] : '');
		$add1 = (!empty($_POST['add1']) ? $_POST['add1'] : '');
		$add2= (!empty($_POST['add2']) ? $_POST['add2'] : '');
		$city = (!empty($_POST['city']) ? $_POST['city'] : '');
		$state = (!empty($_POST['state']) ? $_POST['state'] : '');
		$zip = (!empty($_POST['zip']) ? $_POST['zip'] : '');
		$gender = (!empty($_POST['gender']) ? $_POST['gender'] : '');
		$marital_status = (!empty($_POST['marital_status']) ? $_POST['marital_status'] : '');
		$ssn = (!empty($_POST['ssn']) ? $_POST['ssn'] : '');
		$home_phone = (!empty($_POST['home_phone']) ? $_POST['home_phone'] : '');
		$work_phone = (!empty($_POST['work_phone']) ? $_POST['work_phone'] : '');
		$cell_phone = (!empty($_POST['cell_phone']) ? $_POST['cell_phone'] : '');
		$email = (!empty($_POST['email']) ? $_POST['email'] : '');
		$patient_notes = (!empty($_POST['patient_notes']) ? $_POST['patient_notes'] : '');
		$docid = (!empty($_REQUEST['docid']) ? $_REQUEST['docid'] : '');
		$p_d_party = (!empty($_POST["p_d_party"]) ? $_POST["p_d_party"] : ''); 
		$p_d_relation = (!empty($_POST["p_d_relation"]) ? $_POST["p_d_relation"] : '');
		$p_d_other = (!empty($_POST["p_d_other"]) ? $_POST["p_d_other"] : '');
		$p_d_employer = (!empty($_POST["p_d_employer"]) ? $_POST["p_d_employer"] : '');
		$p_d_ins_co = (!empty($_POST["p_d_ins_co"]) ? $_POST["p_d_ins_co"] : '');
		$p_d_ins_id = (!empty($_POST["p_d_ins_id"]) ? $_POST["p_d_ins_id"] : '');
		$s_d_party = (!empty($_POST["s_d_party"]) ? $_POST["s_d_party"] : ''); 
		$s_d_relation = (!empty($_POST["s_d_relation"]) ? $_POST["s_d_relation"] : '');
		$s_d_other = (!empty($_POST["s_d_other"]) ? $_POST["s_d_other"] : '');
		$s_d_employer = (!empty($_POST["s_d_employer"]) ? $_POST["s_d_employer"] : '');
		$s_d_ins_co = (!empty($_POST["s_d_ins_co"]) ? $_POST["s_d_ins_co"] : '');
		$s_d_ins_id = (!empty($_POST["s_d_ins_id"]) ? $_POST["s_d_ins_id"] : '');
		$p_m_partyfname = (!empty($_POST["p_m_partyfname"]) ? $_POST["p_m_partyfname"] : '');
    $p_m_partymname = (!empty($_POST["p_m_partymname"]) ? $_POST["p_m_partymname"] : '');
		$p_m_partylname = (!empty($_POST["p_m_partylname"]) ? $_POST["p_m_partylname"] : ''); 
		$p_m_relation = (!empty($_POST["p_m_relation"]) ? $_POST["p_m_relation"] : '');
		$p_m_other = (!empty($_POST["p_m_other"]) ? $_POST["p_m_other"] : '');
		$p_m_employer = (!empty($_POST["p_m_employer"]) ? $_POST["p_m_employer"] : '');
		$p_m_ins_co = (!empty($_POST["p_m_ins_co"]) ? $_POST["p_m_ins_co"] : '');
		$p_m_ins_id = (!empty($_POST["p_m_ins_id"]) ? $_POST["p_m_ins_id"] : '');
		$s_m_partyfname = (!empty($_POST["s_m_partyfname"]) ? $_POST["s_m_partyfname"] : '');
    $s_m_partymname = (!empty($_POST["s_m_partymname"]) ? $_POST["s_m_partymname"] : '');
		$s_m_partylname = (!empty($_POST["s_m_partylname"]) ? $_POST["s_m_partylname"] : '');  
		$s_m_relation = (!empty($_POST["s_m_relation"]) ? $_POST["s_m_relation"] : '');
		$s_m_other = (!empty($_POST["s_m_other"]) ? $_POST["s_m_other"] : '');
		$s_m_employer = (!empty($_POST["s_m_employer"]) ? $_POST["s_m_employer"] : '');
		$s_m_ins_co = (!empty($_POST["s_m_ins_co"]) ? $_POST["s_m_ins_co"] : '');
		$s_m_ins_id = (!empty($_POST["s_m_ins_id"]) ? $_POST["s_m_ins_id"] : '');
		$p_m_ins_grp = (!empty($_POST["p_m_ins_grp"]) ? $_POST["p_m_ins_grp"] : '');
    $s_m_ins_grp = (!empty($_POST["s_m_ins_grp"]) ? $_POST["s_m_ins_grp"] : '');
    $p_m_dss_file = (!empty($_POST["p_m_dss_file"]) ? $_POST["p_m_dss_file"] : '');
    $s_m_dss_file = (!empty($_POST["s_m_dss_file"]) ? $_POST["s_m_dss_file"] : '');
    $p_m_ins_type = (!empty($_POST["p_m_ins_type"]) ? $_POST["p_m_ins_type"] : '');
    $s_m_ins_type = (!empty($_POST["s_m_ins_type"]) ? $_POST["s_m_ins_type"] : '');
    $p_m_ins_ass = (!empty($_POST["p_m_ins_ass"]) ? $_POST["p_m_ins_ass"] : '');
    $s_m_ins_ass = (!empty($_POST["s_m_ins_ass"]) ? $_POST["s_m_ins_ass"] : '');
    $p_m_ins_plan = (!empty($_POST["p_m_ins_plan"]) ? $_POST["p_m_ins_plan"] : '');
    $s_m_ins_plan = (!empty($_POST["s_m_ins_plan"]) ? $_POST["s_m_ins_plan"] : '');
    $ins_dob = (!empty($_POST["ins_dob"]) ? $_POST["ins_dob"] : '');
    $ins2_dob = (!empty($_POST["ins2_dob"]) ? $_POST["ins2_dob"] : '');
		$employer = (!empty($_POST["employer"]) ? $_POST["employer"] : '');
		$emp_add1 = (!empty($_POST["emp_add1"]) ? $_POST["emp_add1"] : '');
		$emp_add2 = (!empty($_POST["emp_add2"]) ? $_POST["emp_add2"] : '');
		$emp_city = (!empty($_POST["emp_city"]) ? $_POST["emp_city"] : '');
		$emp_state = (!empty($_POST["emp_state"]) ? $_POST["emp_state"] : '');
		$emp_zip = (!empty($_POST["emp_zip"]) ? $_POST["emp_zip"] : '');
		$emp_phone = (!empty($_POST["emp_phone"]) ? $_POST["emp_phone"] : '');
		$docsleep = (!empty($_POST["docsleep"]) ? $_POST["docsleep"] : '');
		$docpcp = (!empty($_POST["docpcp"]) ? $_POST["docpcp"] : '');
		$docdentist = (!empty($_POST["docdentist"]) ? $_POST["docdentist"] : '');
		$docent = (!empty($_POST["docent"]) ? $_POST["docent"] : '');
		$docmdother = (!empty($_POST["docmdother"]) ? $_POST["docmdother"] : '');
		$emp_fax = (!empty($_POST["emp_fax"]) ? $_POST["emp_fax"] : '');
		$plan_name = (!empty($_POST["plan_name"]) ? $_POST["plan_name"] : '');
		$group_number = (!empty($_POST["group_number"]) ? $_POST["group_number"] : '');
		$ins_type = (!empty($_POST["ins_type"]) ? $_POST["ins_type"] : '');
		$accept_assignment = (!empty($_POST["accept_assignment"]) ? $_POST["accept_assignment"] : '');
		$print_signature = (!empty($_POST["print_signature"]) ? $_POST["print_signature"] : '');
		$medical_insurance = (!empty($_POST["medical_insurance"]) ? $_POST["medical_insurance"] : '');
		$mark_yes = (!empty($_POST["mark_yes"]) ? $_POST["mark_yes"] : '');
		$inactive = (!empty($_POST["inactive"]) ? $_POST["inactive"] : '');
		$partner_name = (!empty($_POST["partner_name"]) ? $_POST["partner_name"] : '');
		$emergency_name = (!empty($_POST["emergency_name"]) ? $_POST["emergency_name"] : '');
		$emergency_number = (!empty($_POST["emergency_number"]) ? $_POST["emergency_number"] : '');
		$referred_source = (!empty($_POST["referred_source"]) ? $_POST["referred_source"] : '');
		$referred_by = (!empty($_POST["referred_by"]) ? $_POST["referred_by"] : '');
		$premedcheck = (!empty($_POST["premedcheck"]) ? $_POST["premedcheck"] : '');
		$premed = (!empty($_POST["premeddet"]) ? $_POST["premeddet"] : '');
		
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
		$docid = st($themyarray['docid']);
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
		
		$name = st($themyarray['lastname'])." ".st($themyarray['middlename']).", ".st($themyarray['firstname']);
		
		$but_text = "Add ";
	}
	
	if($themyarray["userid"] != '')
	{
		$but_text = "Edit ";
	}
	else
	{
		$but_text = "Add ";
	}
	?>
    <div class="col-md-6 col-md-offset-3">
        <?php if (isset($_GET['msg'])) { ?>
        <div class="alert alert-danger text-center">
            <strong><?php echo  $_GET['msg'] ?></strong>
        </div>
        <?php } ?>
        
        <?php if (!empty($msg)) { ?>
        <div class="alert alert-success text-center">
            <?php echo  $msg ?>
        </div>
        <?php } ?>
        
        <div class="page-header">
            <h1>
                <?php echo $but_text?> Patient
                <?php if(!empty($name)) {?>
               		&quot;<?php echo $name;?>&quot;
                <?php }?>
            </h1>
        </div>
        
        <form name="patientfrm" id="patientfrm" action="<?php echo $_SERVER['PHP_SELF'];?>?add=1" method="post" onSubmit="return patientabc(this);validateDate('dob');validateDate('ins_dob');validateDate('ins2_dob');" class="form-horizontal">
            <div class="page-header">
                <strong>Name</strong>
            </div>
            <div class="form-group">
                <label for="salutation" class="col-md-3 control-label">Salutation</label>
                <div class="col-md-9">
                    <select name="salutation" id="salutation" class="form-control" tabindex="1" style="width:80px;" >
                        <option value=""></option>
                        <option value="Dr." <?php echo  ($salutation == 'Dr.') ? 'selected' : '' ?>>Dr.</option>
                        <option value="Mr." <?php echo  ($salutation == 'Mr.') ? 'selected' : '' ?>>Mr.</option>
                        <option value="Mrs." <?php echo  ($salutation == 'Mrs.') ? 'selected' : '' ?>>Mrs.</option>
                        <option value="Miss." <?php echo  ($salutation == 'Miss.') ? 'selected' : '' ?>>Miss.</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="firstname" class="col-md-3 control-label">First Name</label>
                <div class="col-md-9">
                    <input type="text" class="form-control" name="firstname" id="firstname" placeholder="First name" value="<?php echo  $firstname ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="middlename" class="col-md-3 control-label">Middle Name</label>
                <div class="col-md-9">
                    <input type="text" class="form-control" name="middlename" id="middlename" placeholder="Middle name" value="<?php echo  $middlename ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="lastname" class="col-md-3 control-label">Last Name</label>
                <div class="col-md-9">
                    <input type="text" class="form-control" name="lastname" id="lastname" placeholder="Last name" value="<?php echo  $lastname ?>">
                </div>
            </div>
            
            <div class="page-header">
                <strong>Premedication</strong>
            </div>
            <div class="form-group">
                <label for="premedcheck" class="col-md-4 control-label">
                	Patient is Pre-Med
                	 &nbsp;&nbsp;&nbsp;
                    <input type="checkbox" name="premedcheck" id="premedcheck" <?php if($premedcheck == 1){ echo "checked=\"checked\"";} ?> class="pull-right" onclick="document.getElementById('premeddet').disabled=!(this.checked)">
                </label>
                <div class="col-md-8">
                    <textarea class="form-control" name="premeddet" id="premeddet" placeholder="Medications" <?php if($premedcheck == 0){ echo "disabled";} ?>><?php echo  (!empty($premeddet) ? $premeddet : '') ?></textarea>
                </div>
            </div>
            
            <div class="page-header">
                <strong>Address</strong>
            </div>
            <div class="form-group">
                <label for="add1" class="col-md-3 control-label">Address</label>
                <div class="col-md-9">
                    <input type="text" class="form-control" name="add1" id="add1" placeholder="Address" value="<?php echo  $add1 ?>">
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-9 col-md-offset-3">
                    <input type="text" class="form-control" name="add2" id="add2" placeholder="Address (second line)" value="<?php echo  $add2 ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="city" class="col-md-3 control-label">City</label>
                <div class="col-md-9">
                    <input type="text" class="form-control" name="city" id="city" placeholder="City" value="<?php echo  $city ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="state" class="col-md-3 control-label">State</label>
                <div class="col-md-9">
                    <input type="text" class="form-control" name="state" id="state" placeholder="State" value="<?php echo  $state ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="zip" class="col-md-3 control-label">Zip/Postal Code</label>
                <div class="col-md-9">
                    <input type="text" class="form-control" name="zip" id="zip" placeholder="Zip/Postal Code" value="<?php echo  $zip ?>">
                </div>
            </div>
            
            <div class="page-header">
                <strong>Personal Information</strong>
            </div>
            <div class="form-group">
                <label for="dob" class="col-md-3 control-label">Birthday</label>
                <div class="col-md-9">
                    <div class="input-group date" data-date="<?php echo  $dob ?>" data-date-format="yyyy-dd-mm">
                        <input class="form-control text-center" type="text" name="dob" value="<?php echo  $dob ?>">
                        <span class="input-group-addon">
                        <i class="glyphicon glyphicon-calendar"></i>
                        </span>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="gender" class="col-md-3 control-label">Gender</label>
                <div class="col-md-9">
                    <select name="gender" id="gender" class="form-control">
                        <option value="">Select</option>
                        <option value="Male" <?php if($gender == 'Male') echo " selected";?>>Male</option>
                        <option value="Female" <?php if($gender == 'Female') echo " selected";?>>Female</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="marital_status" class="col-md-3 control-label">Marital Status</label>
                <div class="col-md-9">
                    <select name="marital_status" id="marital_status" class="form-control">
                        <option value="">Select</option>
                        <option value="Married" <?php if($marital_status == 'Married') echo " selected";?>>Married</option>
                        <option value="Single" <?php if($marital_status == 'Single') echo " selected";?>>Un-Married</option>
                        <option value="Life Partner" <?php if($marital_status == 'Life Partner') echo " selected";?>>Life Partner</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="partner_name" class="col-md-3 control-label">Partner Name</label>
                <div class="col-md-9">
                    <input type="text" class="form-control" name="partner_name" id="partner_name" placeholder="Partner Name" value="<?php echo  $partner_name ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="ssn" class="col-md-3 control-label">Patient's SSN</label>
                <div class="col-md-9">
                    <input type="text" class="form-control" name="ssn" id="ssn" placeholder="SSN" value="<?php echo  $ssn ?>">
                </div>
            </div>
            
            <div class="page-header">
                <strong>Optional Fields</strong>
            </div>
            <div class="form-group">
                <label for="home_phone" class="col-md-3 control-label">Home Phone</label>
                <div class="col-md-9">
                    <input type="text" class="form-control" name="home_phone" id="home_phone" placeholder="Home Phone" value="<?php echo  $home_phone ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="work_phone" class="col-md-3 control-label">Work Phone</label>
                <div class="col-md-9">
                    <input type="text" class="form-control" name="work_phone" id="work_phone" placeholder="Work Phone" value="<?php echo  $work_phone ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="cell_phone" class="col-md-3 control-label">Mobile</label>
                <div class="col-md-9">
                    <input type="text" class="form-control" name="cell_phone" id="cell_phone" placeholder="Mobile" value="<?php echo  $cell_phone ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="email" class="col-md-3 control-label">Email</label>
                <div class="col-md-9">
                    <input type="email" class="form-control" name="email" id="email" placeholder="Email" value="<?php echo  $email ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="patient_notes" class="col-md-3 control-label">Notes</label>
                <div class="col-md-9">
                    <textarea name="patient_notes" id="patient_notes" class="form-control"><?php echo  $patient_notes ?></textarea>
                </div>
            </div>
            
            <div class="page-header">
                <strong>Emergency Contact Information</strong>
            </div>
            <div class="form-group">
                <label for="emergency_name" class="col-md-3 control-label">Name</label>
                <div class="col-md-9">
                    <input type="text" class="form-control" name="emergency_name" id="emergency_name" placeholder="Whom to contact in case of emergency" value="<?php echo  $emergency_name ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="emergency_number" class="col-md-3 control-label">Number</label>
                <div class="col-md-9">
                    <input type="text" class="form-control" name="emergency_number" id="emergency_number" placeholder="Number to dial in case of emergency" value="<?php echo  $emergency_number ?>">
                </div>
            </div>
            
            <div class="page-header">
                <strong>Referral</strong>
            </div>
            <div class="form-group">
                <label for="referred_by" class="col-md-3 control-label">Referred by</label>
                <div class="col-md-5">
                    <?
                    $referredby_sql = "select * from dental_contact where referrer=1 and status=1 and docid='".(!empty($_SESSION['docid']) ? $_SESSION['docid'] : '')."' order by firstname";
                    $referredby_my = mysqli_query($con,$referredby_sql);
                    ?>
                    <select name="referred_by" id="referred_by" class="form-control">
                        <option value=""></option>
                        <?php while($referredby_myarray = mysqli_fetch_array($referredby_my)) 
                        {
                            $ref_name = st($referredby_myarray['salutation'])." ".st($referredby_myarray['firstname'])." ".st($referredby_myarray['middlename'])." ".st($referredby_myarray['lastname']);
                        ?>
                            <option value="<?php echo st($referredby_myarray['contractid'])?>" <?php if($referred_by == st($referredby_myarray['contactid']) ) echo " selected";?>>
                                <?php echo $ref_name;?>
                            </option>
                        <?php }?>
                    </select>
                </div>
                <div class="col-md-4 text-center">
                    <a class="btn btn-success" href="add_referredby.php?addtopat=<?php echo (!empty($_GET['ed']) ? $_GET['ed'] : ''); ?>">
                        Add New Referrer
                        <span class="glyphicon glyphicon-plus"></span>
                    </a>
                </div>
            </div>
            <div class="form-group">
                <label for="referred_source" class="col-md-3 control-label">Referral Source</label>
                <div class="col-md-9">
                    <select name="referred_source" id="referred_source" class="form-control">
                        <option value="">Select</option>
                        <option value="MD" <?php if($referred_source == 'MD') echo " selected";?>>MD</option>
                        <option value="Radio" <?php if($referred_source == 'Radio') echo " selected";?>>Radio</option>
                        <option value="Internet Marketing" <?php if($referred_source == 'Internet Marketing') echo " selected";?>>Internet Marketing</option>
                    </select>
                </div>
            </div>
            
            <div class="page-header">
                <strong>Primary Medical Insurance</strong>
            </div>
            <div class="form-group">
                <label class="col-md-3 control-label">DSS filing insurance</label>
                <div class="col-md-2 col-md-push-2 radio">
                    <label><input type="radio" name="p_m_dss_file" value="1" <?php if($p_m_dss_file == '1') echo "checked='checked'";?>> Yes</label>
                </div>
                <div class="col-md-2 col-md-push-2 radio">
                    <label><input type="radio" name="p_m_dss_file" value="2" <?php if($p_m_dss_file == '2') echo "checked='checked'";?>> No</label>
                </div>
            </div>
            <div class="form-group">
                <label for="p_m_partyfname" class="col-md-3 control-label">First Name</label>
                <div class="col-md-9">
                    <input type="text" class="form-control" name="p_m_partyfname" id="p_m_partyfname" placeholder="First Name" value="<?php echo  $p_m_partyfname ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="p_m_partymname" class="col-md-3 control-label">Middle Name</label>
                <div class="col-md-9">
                    <input type="text" class="form-control" name="p_m_partymname" id="p_m_partymname" placeholder="Middle Name" value="<?php echo  $p_m_partymname ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="p_m_partylname" class="col-md-3 control-label">Last Name</label>
                <div class="col-md-9">
                    <input type="text" class="form-control" name="p_m_partylname" id="p_m_partylname" placeholder="Last Name" value="<?php echo  $p_m_partylname ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="p_m_relation" class="col-md-4 control-label">Relationship to insured party</label>
                <div class="col-md-8">
                    <select name="p_m_relation" id="p_m_relation" class="form-control">
                        <option value="" <?php if($p_m_relation == '') echo " selected";?>>None</option>
                        <option value="Self" <?php if($p_m_relation == 'Self') echo " selected";?>>Self</option>
                        <option value="Spouse" <?php if($p_m_relation == 'Spouse') echo " selected";?>>Spouse</option>
                        <option value="Child" <?php if($p_m_relation == 'Child') echo " selected";?>>Child</option>
                        <option value="Other" <?php if($p_m_relation == 'Other') echo " selected";?>>Other</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="ins_dob" class="col-md-3 control-label">Insured Date of Birth</label>
                <div class="col-md-9">
                    <div class="input-group date" data-date="<?php echo  $ins_dob ?>" data-date-format="yyyy-dd-mm">
                        <input class="form-control text-center" type="text" name="ins_dob" value="<?php echo  $ins_dob ?>">
                        <span class="input-group-addon">
                        <i class="glyphicon glyphicon-calendar"></i>
                        </span>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="p_m_ins_co" class="col-md-3">Insurance Company</label>
                <div class="col-md-5">
                    <select id="p_m_ins_co" name="p_m_ins_co" class="form-control">
                    <?php
                    $ins_contact_qry = "SELECT * FROM `dental_contact` WHERE contacttypeid = '11'";
                    $ins_contact_qry_run = mysqli_query($con,$ins_contact_qry);
                    while($ins_contact_res = mysqli_fetch_array($ins_contact_qry_run)){
                    ?>
                        <option value="<?php echo $ins_contact_res['contactid']; ?>" <?php if($p_m_ins_co == $ins_contact_res['contactid']){echo "selected='selected'";} ?>><?php echo $ins_contact_res['company']; ?></option>
                        
                    <?php } ?>
                    </select>
                </div>
                <div class="col-md-4 text-center">
                    <a onclick="Javascript: window.location.href='add_contact.php<?php if(isset($_GET['pid'])){echo "?pid=".$_GET['pid']."&type=11&ctypeeq=1&activePat=".$_GET['pid'];} ?>';" href="javascript:scroll(0,0)" class="btn btn-primary">
                        Add Insurance Company
                        <span class="glyphicon glyphicon-plus"></span>
                    </a>
                </div>
            </div>
            <div class="form-group">
                <label for="p_m_ins_id" class="col-md-3 control-label">Insurance ID</label>
                <div class="col-md-9">
                    <input type="text" class="form-control" name="p_m_ins_id" id="p_m_ins_id" placeholder="ID" value="<?php echo  $p_m_ins_id ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="p_m_ins_grp" class="col-md-3 control-label">Group Number</label>
                <div class="col-md-9">
                    <input type="text" class="form-control" name="p_m_ins_grp" id="p_m_ins_grp" placeholder="Group Number" value="<?php echo  $p_m_ins_grp ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="p_m_ins_plan" class="col-md-3 control-label">Plan Name</label>
                <div class="col-md-9">
                    <input type="text" class="form-control" name="p_m_ins_plan" id="p_m_ins_plan" placeholder="Plan Name" value="<?php echo  $p_m_ins_plan ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="p_m_ins_type" class="col-md-3 control-label">Insurance Type</label>
                <div class="col-md-9">
                    <select id="p_m_ins_type" name="p_m_ins_type" class="form-control">
                        <option>Select Type</option>
                        <option value="1" <?php if($p_m_ins_type == '1'){ echo " selected='selected'";} ?>>Medicare</option>
                        <option value="2" <?php if($p_m_ins_type == '2'){ echo " selected='selected'";} ?>>Medicaid</option>
                        <option value="3" <?php if($p_m_ins_type == '3'){ echo " selected='selected'";} ?>>Tricare Champus</option>
                        <option value="4" <?php if($p_m_ins_type == '4'){ echo " selected='selected'";} ?>>Champ VA</option>
                        <option value="5" <?php if($p_m_ins_type == '5'){ echo " selected='selected'";} ?>>Group Health Plan</option>
                        <option value="6" <?php if($p_m_ins_type == '6'){ echo " selected='selected'";} ?>>FECA BLKLUNG</option>
                        <option value="7" <?php if($p_m_ins_type == '7'){ echo " selected='selected'";} ?>>Other</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-4 col-md-push-2 radio">
                    <label><input type="radio" name="p_m_ins_ass" value="Yes" <?php if($p_m_ins_ass == 'Yes'){ echo " checked='checked'";} ?>>Accept Assignment of Benefits</label>
                </div>
                <div class="col-md-4 col-md-push-3 radio">
                    <label><input type="radio" name="p_m_ins_ass" value="No" <?php if($p_m_ins_ass == 'No'){ echo " checked='checked'";} ?>>Payment to Patient</label>
                </div>
            </div>
            
            <div class="page-header">
                <strong>Secondary Medical Insurance</strong>
            </div>
            <div class="form-group">
                <label class="col-md-3 control-label">DSS filing insurance</label>
                <div class="col-md-2 col-md-push-2 radio">
                    <label><input type="radio" name="s_m_dss_file" value="1" <?php if($s_m_dss_file == '1') echo "checked='checked'";?>> Yes</label>
                </div>
                <div class="col-md-2 col-md-push-2 radio">
                    <label><input type="radio" name="s_m_dss_file" value="2" <?php if($s_m_dss_file == '2') echo "checked='checked'";?>> No</label>
                </div>
            </div>
            <div class="form-group">
                <label for="s_m_partyfname" class="col-md-3 control-label">First Name</label>
                <div class="col-md-9">
                    <input type="text" class="form-control" name="s_m_partyfname" id="s_m_partyfname" placeholder="First Name" value="<?php echo  $s_m_partyfname ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="s_m_partymname" class="col-md-3 control-label">Middle Name</label>
                <div class="col-md-9">
                    <input type="text" class="form-control" name="s_m_partymname" id="s_m_partymname" placeholder="Middle Name" value="<?php echo  $s_m_partymname ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="s_m_partylname" class="col-md-3 control-label">Last Name</label>
                <div class="col-md-9">
                    <input type="text" class="form-control" name="s_m_partylname" id="s_m_partylname" placeholder="Last Name" value="<?php echo  $s_m_partylname ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="s_m_relation" class="col-md-4 control-label">Relationship to insured party</label>
                <div class="col-md-8">
                    <select name="s_m_relation" id="s_m_relation" class="form-control">
                        <option value="" <?php if($s_m_relation == '') echo " selected";?>>None</option>
                        <option value="Self" <?php if($s_m_relation == 'Self') echo " selected";?>>Self</option>
                        <option value="Spouse" <?php if($s_m_relation == 'Spouse') echo " selected";?>>Spouse</option>
                        <option value="Child" <?php if($s_m_relation == 'Child') echo " selected";?>>Child</option>
                        <option value="Other" <?php if($s_m_relation == 'Other') echo " selected";?>>Other</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="ins_dob" class="col-md-3 control-label">Insured Date of Birth</label>
                <div class="col-md-9">
                    <div class="input-group date" data-date="<?php echo  $ins_dob ?>" data-date-format="yyyy-dd-mm">
                        <input class="form-control text-center" type="text" name="ins_dob" value="<?php echo  $ins_dob ?>">
                        <span class="input-group-addon">
                        <i class="glyphicon glyphicon-calendar"></i>
                        </span>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="s_m_ins_co" class="col-md-3">Insurance Company</label>
                <div class="col-md-5">
                    <select id="s_m_ins_co" name="s_m_ins_co" class="form-control">
                    <?php
                    $ins_contact_qry = "SELECT * FROM `dental_contact` WHERE contacttypeid = '11'";
                    $ins_contact_qry_run = mysqli_query($con,$ins_contact_qry);
                    while($ins_contact_res = mysqli_fetch_array($ins_contact_qry_run)){
                    ?>
                        <option value="<?php echo $ins_contact_res['contactid']; ?>" <?php if($s_m_ins_co == $ins_contact_res['contactid']){echo "selected='selected'";} ?>><?php echo $ins_contact_res['company']; ?></option>
                        
                    <?php } ?>
                    </select>
                </div>
                <div class="col-md-4 text-center">
                    <a onclick="Javascript: window.location.href='add_contact.php<?php if(isset($_GET['pid'])){echo "?pid=".$_GET['pid']."&type=11&ctypeeq=1&activePat=".$_GET['pid'];} ?>';" href="javascript:scroll(0,0)" class="btn btn-primary">
                        Add Insurance Company
                        <span class="glyphicon glyphicon-plus"></span>
                    </a>
                </div>
            </div>
            <div class="form-group">
                <label for="s_m_ins_id" class="col-md-3 control-label">Insurance ID</label>
                <div class="col-md-9">
                    <input type="text" class="form-control" name="s_m_ins_id" id="s_m_ins_id" placeholder="ID" value="<?php echo  $s_m_ins_id ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="s_m_ins_grp" class="col-md-3 control-label">Group Number</label>
                <div class="col-md-9">
                    <input type="text" class="form-control" name="s_m_ins_grp" id="s_m_ins_grp" placeholder="Group Number" value="<?php echo  $s_m_ins_grp ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="s_m_ins_plan" class="col-md-3 control-label">Plan Name</label>
                <div class="col-md-9">
                    <input type="text" class="form-control" name="s_m_ins_plan" id="s_m_ins_plan" placeholder="Plan Name" value="<?php echo  $s_m_ins_plan ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="s_m_ins_type" class="col-md-3 control-label">Insurance Type</label>
                <div class="col-md-9">
                    <select id="s_m_ins_type" name="s_m_ins_type" class="form-control">
                        <option>Select Type</option>
                        <option value="1" <?php if($s_m_ins_type == '1'){ echo " selected='selected'";} ?>>Medicare</option>
                        <option value="2" <?php if($s_m_ins_type == '2'){ echo " selected='selected'";} ?>>Medicaid</option>
                        <option value="3" <?php if($s_m_ins_type == '3'){ echo " selected='selected'";} ?>>Tricare Champus</option>
                        <option value="4" <?php if($s_m_ins_type == '4'){ echo " selected='selected'";} ?>>Champ VA</option>
                        <option value="5" <?php if($s_m_ins_type == '5'){ echo " selected='selected'";} ?>>Group Health Plan</option>
                        <option value="6" <?php if($s_m_ins_type == '6'){ echo " selected='selected'";} ?>>FECA BLKLUNG</option>
                        <option value="7" <?php if($s_m_ins_type == '7'){ echo " selected='selected'";} ?>>Other</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-4 col-md-push-2 radio">
                    <label><input type="radio" name="s_m_ins_ass" value="Yes" <?php if($s_m_ins_ass == 'Yes'){ echo " checked='checked'";} ?>>Accept Assignment of Benefits</label>
                </div>
                <div class="col-md-4 col-md-push-3 radio">
                    <label><input type="radio" name="s_m_ins_ass" value="No" <?php if($s_m_ins_ass == 'No'){ echo " checked='checked'";} ?>>Payment to Patient</label>
                </div>
            </div>
            
            <div class="page-header">
                <strong>Employer</strong>
            </div>
            <div class="form-group">
                <label for="employer" class="col-md-3 control-label">Employer</label>
                <div class="col-md-9">
                    <input type="text" class="form-control" name="employer" id="employer" placeholder="Employer" value="<?php echo  $employer ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="emp_add1" class="col-md-3 control-label">Address</label>
                <div class="col-md-9">
                    <input type="text" class="form-control" name="emp_add1" id="emp_add1" placeholder="Address" value="<?php echo  $emp_add1 ?>">
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-9 col-md-offset-3">
                    <input type="text" class="form-control" name="emp_add2" id="emp_add2" placeholder="Address (second line)" value="<?php echo  $emp_add2 ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="emp_city" class="col-md-3 control-label">City</label>
                <div class="col-md-9">
                    <input type="text" class="form-control" name="emp_city" id="emp_city" placeholder="City" value="<?php echo  $emp_city ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="emp_state" class="col-md-3 control-label">State</label>
                <div class="col-md-9">
                    <input type="text" class="form-control" name="emp_state" id="emp_state" placeholder="State" value="<?php echo  $emp_state ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="emp_zip" class="col-md-3 control-label">Zip/Postal Code</label>
                <div class="col-md-9">
                    <input type="text" class="form-control" name="emp_zip" id="emp_zip" placeholder="Zip/Postal Code" value="<?php echo  $emp_zip ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="emp_phone" class="col-md-3 control-label">Phone</label>
                <div class="col-md-9">
                    <input type="text" class="form-control" name="emp_phone" id="emp_phone" placeholder="Phone" value="<?php echo  $emp_phone ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="emp_fax" class="col-md-3 control-label">Fax</label>
                <div class="col-md-9">
                    <input type="text" class="form-control" name="emp_fax" id="emp_fax" placeholder="Fax" value="<?php echo  $emp_fax ?>">
                </div>
            </div>
            
            <?php if (
                (isset($_GET['pid']) && isset($_GET['ed'])) ||
                (isset($_GET['pid']) && isset($_GET['addtopat']))
            ) {
                $patid = $_GET['ed'];
                $pcont_qry = "SELECT * FROM dental_pcont WHERE patient_id=".$patid;
                $pcont_array = mysqli_query($con,$pcont_qry);
                $pcont_qry = "SELECT * FROM dental_pcont LEFT JOIN dental_contact ON dental_pcont.contact_id = dental_contact.contactid WHERE dental_pcont.patient_id=".$patid." UNION SELECT * FROM dental_pcont RIGHT JOIN dental_contact ON dental_pcont.contact_id = dental_contact.contactid WHERE dental_pcont.patient_id=".$patid;
                $pcont_array = mysqli_query($con,$pcont_qry);
                $contact_list = array();
                
                while ($pcont_l = mysqli_fetch_array($pcont_array)) {
                    if ($pcont_l['contacttypeid'] != '0') {
                        $type_check = "SELECT contacttype FROM dental_contacttype WHERE contacttypeid=".$pcont_l['contacttypeid'];
                        $type_query = mysqli_query($con,$type_check);
                        $type_array = mysqli_fetch_array($type_query);
                        $currentcontact_type = $type_array['contacttype'];
                    }
                    else {
                        $currentcontact_type = "Type Not Set";
                    }
                    
                    $contact_list []= array(
                        'id' => $pcont_l['contactid'],
                        'name' => "$pcont_l[firstname] $pcont_l[lastname]",
                        'type' => $currentcontact_type
                    );
                }
                
                ?>
            <div class="page-header">
                <strong>Contact Information</strong>
            </div>
            <div class="form-group">
                <label class="col-md-3 control-label">Contacts</label>
                <div class="col-md-9">
                    <?php include dirname(__FILE__) . '/../contact_includes.php' ?>
                </div>
            </div>
            <div class="col-md-6 col-md-push-3 text-center page-header">
                Add Contact above, then assign here:
            </div>
            <div class="clearfix"></div>
            <div class="form-group">
                <label for="docsleep" class="col-md-3 control-label">Sleep MD</label>
                <div class="col-md-9">
                    <select name="docsleep" id="docsleep" class="form-control">
                        <option>Not Set</option>
                        <?php foreach ($contact_list as $current) { ?>
                        <option value="<?php echo  $current['id'] ?>" <?php echo  ($docsleep == $current['id'] ? 'selected="selected"' : '') ?>><?php echo  "$current[name] - $current[type]" ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="docpcp" class="col-md-3 control-label">Primary Care MD</label>
                <div class="col-md-9">
                    <select name="docpcp" id="docpcp" class="form-control">
                        <option>Not Set</option>
                        <?php foreach ($contact_list as $current) { ?>
                        <option value="<?php echo  $current['id'] ?>" <?php echo  ($docpcp == $current['id'] ? 'selected="selected"' : '') ?>><?php echo  "$current[name] - $current[type]" ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="docdentist" class="col-md-3 control-label">Dentist</label>
                <div class="col-md-9">
                    <select name="docdentist" id="docdentist" class="form-control">
                        <option>Not Set</option>
                        <?php foreach ($contact_list as $current) { ?>
                        <option value="<?php echo  $current['id'] ?>" <?php echo  ($docdentist == $current['id'] ? 'selected="selected"' : '') ?>><?php echo  "$current[name] - $current[type]" ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="docent" class="col-md-3 control-label">ENT</label>
                <div class="col-md-9">
                    <select name="docent" id="docent" class="form-control">
                        <option>Not Set</option>
                        <?php foreach ($contact_list as $current) { ?>
                        <option value="<?php echo  $current['id'] ?>" <?php echo  ($docent == $current['id'] ? 'selected="selected"' : '') ?>><?php echo  "$current[name] - $current[type]" ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="docmdother" class="col-md-3 control-label">Other MD</label>
                <div class="col-md-9">
                    <select name="docmdother" id="docmdother" class="form-control">
                        <option>Not Set</option>
                        <?php foreach ($contact_list as $current) { ?>
                        <option value="<?php echo  $current['id'] ?>" <?php echo  ($docmdother == $current['id'] ? 'selected="selected"' : '') ?>><?php echo  "$current[name] - $current[type]" ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <?php } ?>
            
            <div class="page-header">
                <strong>General</strong>
            </div>
            <div class="form-group">
                <label for="status" class="col-md-3 control-label">Status</label>
                <div class="col-md-9">
                    <select name="status" id="status" class="form-control">
                        <option value="1" <?php if(!empty($status) && $status == 1) echo " selected";?>>Active</option>
                        <option value="2" <?php if(!empty($status) && $status == 2) echo " selected";?>>In-Active</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="docid" class="col-md-3 control-label">Assign to</label>
                <div class="col-md-9">
                    <select name="docid" id="docid" class="form-control">
                    <?php
                    
                    $query = "SELECT * FROM dental_users WHERE `user_access` = 2;";
                    $result = mysqli_query($con,$query);
                    
                    while ($array = mysqli_fetch_array($result)) { ?>
                        <option value="<?php echo $array['userid']; ?>" <?php if($docid == $array['userid']){ echo " selected"; }?>><?php echo $array['name']; ?></option>
                    <?php } ?>    
                    </select>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-9 col-md-offset-3">
                    <input type="hidden" name="patientsub" value="1">
                    <input type="hidden" name="ed" value="<?php echo $themyarray["patientid"]?>">
                    <input type="submit" value="<?php echo $but_text?> Patient" class="btn btn-primary">
                <?php if($themyarray["userid"] != '' && $_SESSION['admin_access']==1){ ?>
                    <a href="manage_patient.php?delid=<?php echo $themyarray["patientid"];?>&docid=<?php echo $_GET['docid']?>" onclick="javascript: return confirm('Do Your Really want to Delete?.');" target="_parent" class="btn btn-danger pull-right" title="DELETE">
                        Delete
                    </a>
                <?php } ?>
                </div>
            </div>
        </form>
    </div>
</body>
</html>
