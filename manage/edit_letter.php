<?php
namespace Ds3\Libraries\Legacy;

if ($_GET['backoffice'] == '1') {
    include 'admin/includes/top.htm'; ?>
    <link rel="stylesheet" href="admin/popup/popup.css" type="text/css" media="screen" />
    <script src="admin/popup/popup.js" type="text/javascript"></script>
<?php } else {
    include 'includes/top.htm';
    include 'admin/includes/invoice_functions.php';
}

$docId = intval($_SESSION['docid']);

$margins = $db->getRow("SELECT
    letter_margin_top AS 'top',
    letter_margin_bottom AS 'bottom',
    letter_margin_left AS 'left',
    letter_margin_right AS 'right'
  FROM dental_users
  WHERE userid = '$docId'
  ");

$pageSize = [
    'width' => 215.9,
    'height' => 279.4
];

$googleFonts = [
    'dejavusans' => 'Open Sans',
    'times' => 'Tinos',
    'helvetica' => 'Roboto',
    'courier' => 'Cutive',
];
$fontsInUse = [];

?>
<script language="javascript" type="text/javascript" src="/manage/3rdParty/tinymce4/tinymce.min.js"></script>
<script type="text/javascript" src="/manage/js/edit_letter.js?v=<?= time() ?>"></script>
<script>
  var pageSize = <?= json_encode($pageSize) ?>;
  var pageMargins = <?= json_encode($margins) ?>;
</script>
<style>
  div.preview-letter {
    width: <?= number_format($pageSize['width'], 1, '.', '') ?>mm;
    min-height: <?= number_format($pageSize['height'], 1, '.', '') ?>mm;
    margin: 30px auto;
    border: 1px solid #ccc;
    -moz-box-shadow: 3px 3px 3px #999;
    -webkit-box-shadow: 3px 3px 3px #999;
    box-shadow: 3px 3px 3px #999;
    overflow: hidden;
    position: relative;
    line-height: 1.2em;
  }

  div.preview-letter div.preview-page-break {
    position: absolute;
    z-index: 1;
    width: <?= $pageSize['width'] ?>mm;
    top: <?= number_format($pageSize['height'] - $margins['bottom'], 1, '.', '') ?>mm;
    border-top: 1px dashed #999;
    color: #999;
    font-family: "Arial", "Helvetica", sans-serif;
    font-size: 11px;
    cursor: default;
    -webkit-user-select: none; /* Chrome/Safari */
    -moz-user-select: none; /* Firefox */
    -ms-user-select: none; /* IE10+ */
    -o-user-select: none;
    user-select: none;
  }

  div.preview-letter div.preview-bottom-margin {
    position: absolute;
    z-index: 2;
    width: <?= $pageSize['width'] ?>mm;
    height: <?= $margins['bottom'] ?>mm;
    bottom: 0;
    background-color: #fff;
  }

  <?php for ($n=2; $n <=10; $n++) { ?>
  div.preview-letter div.preview-page-break.break-<?= $n ?> {
    top: <?= number_format(($pageSize['height'] - $margins['top'] - $margins['bottom'])*$n + $margins['top'], 1, '.', '') ?>mm;
  }
  <?php } ?>

  div.preview-letter p {
    margin-block-start: 1.1em;
    margin-block-end: 1.1em;
  }

  div.preview-letter ul,
  div.preview-letter ol {
    width: auto;
    padding-eft: 3em;
  }

  div.preview-letter li {
    padding: 0;
  }

  div.preview-letter table {
    border-spacing: 0;
  }

  div.preview-letter td {
    padding: 0;
  }

  div.preview-letter p:first-child {
    margin-top: 0;
  }

  div.preview-letter p:empty::after {
    content: "\00A0";
  }

  div.preview-letter.show-hidden p::after {
    content: "\b6";
    color: #ccc;
    cursor: default;
  }

  div.preview-letter.show-hidden span.br-marker {
    position: absolute;
    color: #ccc;
    cursor: default;
  }

  div.preview-letter.show-hidden br::before,
  div.preview-letter.show-hidden span.br-marker::before {
    content: "\21b5";
    position: absolute;
    color #ccc;
    cursor: default;
  }

  div.preview-letter,
  div.preview-letter td,
  div.preview-letter ul,
  div.preview-letter ol {
    font-size: 14pt;
  }

  div.preview-letter div.preview-wrapper {
    position: relative;
    margin: <?= "{$margins['top']}mm {$margins['right']}mm {$margins['bottom']}mm {$margins['left']}mm" ?>;
  }

  div.preview-letter div.preview-inner-wrapper {
    position: relative;
    margin: 0;
  }

  div.preview-letter.preview-font-dejavusans,
  div.preview-letter.preview-font-dejavusans td,
  div.preview-letter.preview-font-dejavusans ul,
  div.preview-letter.preview-font-dejavusans ol {
    font-family: "DejaVu Sans", "Open Sans", "Verdana", "Geneva", sans-serif;
  }

  div.preview-letter.preview-font-times,
  div.preview-letter.preview-font-times td,
  div.preview-letter.preview-font-times ul,
  div.preview-letter.preview-font-times ol {
    font-family: "Times New Roman", "Tinos", "Times", "Liberation Serif", "Nimbus Roman No9 L", serif;
  }

  div.preview-letter.preview-font-helvetica,
  div.preview-letter.preview-font-helvetica td,
  div.preview-letter.preview-font-helvetica ul,
  div.preview-letter.preview-font-helvetica ol {
    font-family: "Helvetica", "Roboto", "Helvetica Neue", "HelveticaNeue", "TeX Gyre Heros", "TeXGyreHeros", "FreeSans", "Nimbus Sans L", "Liberation Sans", sans-serif;
  }

  div.preview-letter.preview-font-courier,
  div.preview-letter.preview-font-courier td,
  div.preview-letter.preview-font-courier ul,
  div.preview-letter.preview-font-courier ol {
    font-family: "Courier", "Cutive", "Courier 10 Pitch", "Consolas", "Courier New", "Nimbus Mono L", monospace;
  }

  div.preview-letter.preview-size-8,
  div.preview-letter.preview-size-8 td,
  div.preview-letter.preview-size-8 ul,
  div.preview-letter.preview-size-8 ol {
    font-size: 8pt;
  }

  div.preview-letter.preview-size-10,
  div.preview-letter.preview-size-10 td,
  div.preview-letter.preview-size-10 ul,
  div.preview-letter.preview-size-10 ol {
    font-size: 10pt;
  }

  div.preview-letter.preview-size-12,
  div.preview-letter.preview-size-12 td,
  div.preview-letter.preview-size-12 ul,
  div.preview-letter.preview-size-12 ol {
    font-size: 12pt;
  }

  div.preview-letter.preview-size-14,
  div.preview-letter.preview-size-14 td,
  div.preview-letter.preview-size-14 ul,
  div.preview-letter.preview-size-14 ol {
    font-size: 14pt;
  }

  div.preview-letter.preview-size-16,
  div.preview-letter.preview-size-16 td,
  div.preview-letter.preview-size-16 ul,
  div.preview-letter.preview-size-16 ol {
    font-size: 16pt;
  }

  div.preview-letter.preview-size-20,
  div.preview-letter.preview-size-20 td,
  div.preview-letter.preview-size-20 ul,
  div.preview-letter.preview-size-20 ol {
    font-size: 20pt;
  }
</style>
<?php
  $status_sql = "SELECT status, docid FROM dental_letters
		WHERE letterid='".mysqli_real_escape_string($con, (!empty($_GET['lid']) ? $_GET['lid'] : ''))."'";

  $status_r = $db->getRow($status_sql);
  $parent_status = $status_r['status'];
  $letter_doc = $status_r['docid'];

  $pat_sql = "SELECT docid FROM dental_patients WHERE patientid='" . mysqli_real_escape_string($con, (!empty($_GET['pid']) ? $_GET['pid'] : '')) . "'";
  
  $pat = $db->getRow($pat_sql);

  $itype_sql = "SELECT * FROM dental_q_image WHERE imagetypeid=4 AND patientid='".mysqli_real_escape_string($con, (!empty($_GET['pid']) ? $_GET['pid'] : ''))."' ORDER BY adddate DESC LIMIT 1"; /////

  $itype = $db->getRow($itype_sql);

  $patient_photo = $itype['image_file'];

  if ($_SESSION['docid'] != $letter_doc && (!isset($_SESSION['adminuserid']) || $_SESSION['adminuserid'] == '')) {
?>

    <h2>You are not permitted to view this letter.</h2>

<?php
    trigger_error("Die called", E_USER_ERROR);
  }

  $masterid = $_GET['lid'];

  $master_sql = "SELECT * FROM dental_letters l
  		  WHERE (l.letterid='".mysqli_real_escape_string($con, $_GET['lid'])."'
  			OR l.parentid='".mysqli_real_escape_string($con, $_GET['lid'])."')
  			AND status='".$parent_status."' AND deleted=0 ORDER BY edit_date DESC";

  $master_c = $db->getResults($master_sql);
  $master_q = $db->getResults($master_sql);

  $master_num = 0;
  $cur_letter_num = 0;
  $cur_template_num = 0;

  //TO COUNT NUMBER OF LETTERS
  foreach ($master_c as $master_r) {
    $letterid = $master_r['letterid'];

    $othermd_query = "SELECT md_list, md_referral_list, pat_referral_list FROM dental_letters where letterid = '".$letterid."' ORDER BY letterid ASC;";
    
    $othermd_result = $db->getResults($othermd_query);
    $md_array = array();
    $md_referral_array = array();
    $pat_referral_array = array();

    foreach ($othermd_result as $row) {
      if ($row['md_list'] != null) {
        $md_array = array_merge($md_array, explode(",", $row['md_list']));
      }

      if ($row['md_referral_list'] != null) {
        $md_referral_array = array_merge($md_referral_array, explode(",", $row['md_referral_list']));
      }

	    if ($row['pat_referral_list'] != null) {
        $pat_referral_array = array_merge($pat_referral_array, explode(",", $row['pat_referral_list']));
      }
    }

    $full_md_list = implode(",", $md_array);
    $full_md_referral_list = implode(",", $md_referral_array);
    $full_pat_referral_list = implode(",", $pat_referral_array);
    $contacts = get_contact_info('', $full_md_list, $full_md_referral_list, $full_pat_referral_list);
    $master_num += count(!empty($contacts['mds']) ? $contacts['mds'] : null);
    $master_num += count(!empty($contacts['md_referrals']) ? $contacts['md_referrals'] : null);
    $master_num += count(!empty($contacts['pat_referrals']) ? $contacts['pat_referrals'] : null);

    if($master_r['topatient']){ 
      $master_num++;
    }
  }

//LOOP THROUGH LETTERS
foreach ($master_q as $master_r) {
  $letterid = $master_r['letterid'];

  // Select Letter
  $letter_query = "SELECT l.templateid, l.patientid, l.topatient, l.cc_topatient, l.md_list, l.md_referral_list, l.pat_referral_list, l.cc_pat_referral_list, l.template, l.send_method, l.status, l.docid, u.username, l.edit_date, l.template_type, l.font_size, l.font_family FROM dental_letters l
  	LEFT JOIN dental_users u ON u.userid=l.edit_userid
  	 where l.letterid = ".$letterid;
  	
  $row = $db->getRow($letter_query);

  $templateid = $row['templateid'];
  $patientid = $row['patientid'];
  $topatient = $row['topatient'];
  $cc_topatient = $row['cc_topatient'];
  $md_list = $row['md_list'];
  $md_referral_list = $row['md_referral_list'];
  $pat_referral_list = $row['pat_referral_list'];

  $mds = explode(",", $md_list);
  $md_referrals = explode(",", $md_referral_list);
  $pat_referrals = explode(",", $pat_referral_list);
	$altered_template = html_entity_decode($row['template'], ENT_COMPAT | ENT_IGNORE,"UTF-8");
	
  $method = $row['send_method'];
  $status = $row['status'];
  $docid = $row['docid'];
  $username = $row['username'];
  $edit_date = $row['edit_date'];
  $template_type = $row['template_type'];
  $font_size = $row['font_size'];
  $font_family = $row['font_family'];

  $fontsInUse[$font_family] = true;

  // Pending and Sent Contacts
  $othermd_query = "SELECT md_list, md_referral_list, cc_md_list, cc_md_referral_list, pat_referral_list, cc_pat_referral_list FROM dental_letters where letterid = '".$letterid."' ORDER BY letterid ASC;";
  
  $othermd_result = $db->getResults($othermd_query);
  $md_array = array();
  $md_referral_array = array();

  foreach ($othermd_result as $row) {
  	if ($row['cc_md_list'] != null) {
      $md_array = array_merge($md_array, explode(",", $row['cc_md_list']));
    } elseif ($row['md_list'] != null) {
  		$md_array = array_merge($md_array, explode(",", $row['md_list']));
  	}

  	if ($row['cc_md_referral_list'] != null) {
      $md_referral_array = array_merge($md_referral_array, explode(",", $row['cc_md_referral_list']));
    } elseif ($row['md_referral_list'] != null) {
  		$md_referral_array = array_merge($md_referral_array, explode(",", $row['md_referral_list']));
  	}

    if ($row['cc_pat_referral_list'] != null) {
      $pat_referral_array = array_merge($pat_referral_array, explode(",", $row['cc_pat_referral_list']));
    }elseif ($row['pat_referral_list'] != null) {
      $pat_referral_array = array_merge($pat_referral_array, explode(",", $row['pat_referral_list']));
    }

  }

  $full_md_list = implode(",", $md_array);
  $full_md_referral_list = implode(",", $md_referral_array);
  $full_pat_referral_list = implode(",", $pat_referral_array);
  $contacts = get_contact_info('', $full_md_list, $full_md_referral_list, $full_pat_referral_list);
  $md_contacts = array();

  if (!empty($contacts['mds'])) foreach ($contacts['mds'] as $contact) {
    $md_contacts[] = array_merge(array('type' => 'md'), $contact);
  }

  if (!empty($contacts['md_referrals'])) foreach ($contacts['md_referrals'] as $contact) {
    $md_contacts[] = array_merge(array('type' => 'md_referral'), $contact);
  }

  if (!empty($contacts['pat_referrals'])) foreach ($contacts['pat_referrals'] as $contact) {
    $md_contacts[] = array_merge(array('type' => 'pat_referral'), $contact);
  }

  // Get Letter Subject
  if($template_type=='0'){
    $template_query = "SELECT name FROM dental_letter_templates WHERE id = ".$templateid.";";
  }else{
    $template_query = "SELECT name FROM dental_letter_templates_custom WHERE id = ".$templateid.";";
  }

  $title = $db->getRow($template_query)['name'];
?>

<br />
<span class="admin_head">
	<?php print $title; ?>
</span>
<br />&nbsp;&nbsp;

<?php 
  if(!empty($_REQUEST['goto'])) {
    if($_REQUEST['goto'] == 'flowsheet') {
      $page = 'manage_flowsheet3.php?pid='.$_GET['pid'].'&addtopat=1';
    } elseif ($_REQUEST['goto'] == 'letter') {
      $page = 'dss_summ.php?sect=letters&pid='.$_GET['pid'].'&addtopat=1';
    } elseif ($_REQUEST['goto'] == 'new_letter') {
      $page = 'new_letter.php?pid='.$_GET['pid'];
    } elseif ($_REQUEST['goto'] == 'faxes') {
      $page = 'manage_faxes.php';
    }
?>
  <a href="<?php echo $page; ?>" class="editlink" title="Pending Letters">
<?php
  } else {
?>
  <a href="<?php print (!empty($_GET['backoffice']) && $_GET['backoffice'] == '1' ? "/manage/admin/manage_letters.php?status=pending&backoffice=1" : "/manage/letters.php?status=pending"); ?>" class="editlink" title="Pending Letters">
<?php } ?>

<b>&lt;&lt;Back</b></a>
<br /><br>

<?php
  if ($status == DSS_LETTER_PENDING) {
    $f_sql = "SELECT * FROM dental_faxes WHERE letterid='".mysqli_real_escape_string($con, $letterid)."';";
    
    $f_q = $db->getResults($f_sql);
    if ($f_q) foreach ($f_q as $f_r) {
?>
    	<div class="warning" id="fax_alert_<?php echo $f_r['id']; ?>">
        This letter failed to send via digital fax to <a href="#" onclick="loadPopup('add_contact.php?ed=<?php echo $f_r['contactid'];?>');return false;"><?php echo  $f_r['to_name']; ?></a> at <a href="#" onclick="loadPopup('add_contact.php?ed=<?php echo $f_r['contactid'];?>');return false;"><?php echo  format_phone($f_r['to_number']); ?></a> Please check fax number and retry, or change delivery method. Click <a href="manage_faxes.php?status=3&viewed=0#fax">here</a> to view full failure details.
      </div>
    	<br /><br />
<?php
    }
  }

$s = "SELECT referred_source FROM dental_patients WHERE patientid='".mysqli_real_escape_string($con, (!empty($_GET['pid']) ? $_GET['pid'] : ''))."' LIMIT 1";
  // Get Contact Info for Recipients
  $r = $db->getRow($s);

  $source = $r['referred_source'];
  if ($topatient) {
    $contact_info = get_contact_info($patientid, $md_list, $md_referral_list, $pat_referral_list);
  } else {
    $contact_info = get_contact_info('', $md_list, $md_referral_list, $pat_referral_list);
  }

  if( $source == DSS_REFERRED_PHYSICIAN) {
    $md_referral = get_mdreferralids($_GET['pid']);
    $ref_info = get_contact_info('', '', $md_referral_list, $source);
    	if (!empty($ref_info['md_referrals'])) {                        
    		if (is_physician($ref_info['md_referrals'][0]['contacttypeid'])) {
    			$referral_fullname = "<strong>" . $ref_info['md_referrals'][0]['salutation'] . " " . $ref_info['md_referrals'][0]['firstname'] . " " . $ref_info['md_referrals'][0]['lastname'] . "</strong>";
    		} else {
    			$referral_fullname = '';
    		}
      } elseif(!empty($pcp)) {
    		if (is_physician($ref_info['pcp']['contacttypeid'])) {
    	    $referral_fullname = "<strong>" . $pcp['salutation'] . " " . $pcp['firstname'] . " " . $pcp['lastname'] . "</strong>";
  		  } else {
  		 	  $referral_fullname = '';
  		  }
      } else {
  		  $referral_fullname = '';
  	  }
  } elseif ($source == DSS_REFERRED_PATIENT) {
  	$referral_fullname = '<strong>a patient</strong>';
  } elseif ($source == DSS_REFERRED_MEDIA ) {
    $referral_fullname = '<strong>a media source</strong>';
  } elseif ($source == DSS_REFERRED_FRANCHISE ) {
    $referral_fullname = '<strong>an internal source</strong>';
  } elseif ($source == DSS_REFERRED_DSSOFFICE ) {
    $referral_fullname = "<strong>Dental Sleep Solutions' referral network</strong>";
  } elseif ($source == DSS_REFERRED_OTHER ) {
    $referral_fullname = '<strong>an unspecified source</strong>';
  } else {
    $referral_fullname = '';
  }

  $pt_referral = get_ptreferralids($_GET['pid']);
  $ptref_info = get_contact_info('', '', $pt_referral, $source);

  $letter_contacts = array();

  if (!empty($contact_info['patient'])) foreach ($contact_info['patient'] as $contact) {
    $letter_contacts[] = array_merge(array('type' => 'patient'), $contact);
  }

  if (!empty($contact_info['md_referrals'])) foreach ($contact_info['md_referrals'] as $contact) {
    $letter_contacts[] = array_merge(array('type' => 'md_referral'), $contact);
  }

  if (!empty($contact_info['pat_referrals'])) foreach ($contact_info['pat_referrals'] as $contact) {
    $letter_contacts[] = array_merge(array('type' => 'pat_referral'), $contact);
  }

  if (!empty($contact_info['mds'])) foreach ($contact_info['mds'] as $contact) {
    $letter_contacts[] = array_merge(array('type' => 'md'), $contact);
  }

  $numletters = count($letter_contacts);

  $sql = "select docpcp from dental_patients where patientid = '".s_for($_GET['pid'])."';";
  
  $docpcp = $db->getRow($sql)['docpcp'];
  if (!empty($contact_info['mds'])) foreach ($contact_info['mds'] as $contact) {
  	if ($contact['id'] == $docpcp) {
  		$pcp = $contact;
  	}
  }

  // Get Date
  $todays_date = date('F d, Y');
  // Get Patient Information
  $patient_query = "SELECT salutation, firstname, middlename, lastname, gender, dob, email, p_m_ins_id, docid FROM dental_patients WHERE patientid = '".$patientid."';";
  
  $patient_result = $db->getResults($patient_query);
  $patient_info = array();

  if ($patient_result) foreach ($patient_result as $row) {
    $patient_info = $row;
  }

  $c_sql = "SELECT companyid from dental_user_company WHERE userid='".$docid."'";

  $c_r = $db->getRow($c_sql);
  $companyid = $c_r['companyid'];
  $patient_info['age'] = floor((time() - strtotime(!empty($patient_info['dob']) ? $patient_info['dob'] : ''))/31556926);
  $did = (!empty($patient_info['docid']) ? $patient_info['docid'] : '');

  // Get Franchisee Name and Address
  $franchisee_query = "SELECT user_type, mailing_name as name, mailing_practice as practice, mailing_address as address, mailing_city as city, mailing_state as state, mailing_zip as zip, email, use_digital_fax, use_letter_header, fax, indent_address, header_space FROM dental_users WHERE userid = '".$docid."';";
  
  $franchisee_result = $db->getResults($franchisee_query);

  foreach ($franchisee_result as $row) {
  	$franchisee_info = $row;
  }

  if($franchisee_info['user_type'] == DSS_USER_TYPE_SOFTWARE) {
    $use_letter_header = $franchisee_info['use_letter_header'];
    $indent_address = $franchisee_info['indent_address'];
    $header_space = $franchisee_info['header_space'];
  } else {
    $use_letter_header = true;
    $indent_address = true;
    $header_space = true;
  }

  $loc_sql = "SELECT location FROM dental_summary where patientid='".mysqli_real_escape_string($con, $_GET['pid'])."'";

  $loc_r = $db->getRow($loc_sql);

  if ($_GET['pid']!='' && $loc_r['location'] != '' && $loc_r['location'] != '0') {
    $location_query = "SELECT * FROM dental_locations WHERE id='".mysqli_real_escape_string($con, $loc_r['location'])."' AND docid='".mysqli_real_escape_string($con, $docid)."'";
  } else {
    $location_query = "SELECT * FROM dental_locations WHERE default_location=1 AND docid='".mysqli_real_escape_string($con, $docid)."'";
  }

  $location_info = $db->getRow($location_query);

  // Get Company Name and Address
  $company_query = "SELECT c.* FROM companies c 
  		JOIN dental_user_company uc ON c.id = uc.companyid
  		WHERE uc.userid = '".$docid."';";

  $company_result = $db->getResults($company_query);
  foreach ($company_result as $row) {
    $company_info = $row;
  }

  // Consult Appointment Date
  $consult_query = "SELECT date_completed FROM dental_flow_pg2_info WHERE patientid = '".$patientid."' AND segmentid = 2 ORDER BY stepid DESC LIMIT 1;";
  
  $consult_result = $db->getRow($consult_query)['date_completed'];
  $consult_date = date('F d, Y', strtotime($consult_result));

  // Impressions Appointment Date
  $impressions_query = "SELECT date_completed FROM dental_flow_pg2_info WHERE patientid = '".$patientid."' AND segmentid = 4 ORDER BY stepid DESC LIMIT 1;";
  
  $impressions_result = $db->getRow($impressions_query)['date_completed'];
  $impressions_date = date('F d, Y', strtotime($impressions_result));

  // Get Medical Information
  $q3_sql = "SELECT other_history, other_medications, medicationscheck from dental_q_page3 WHERE patientid = '".$patientid."';";
  
  $q3_myarray = $db->getRow($q3_sql);
  $history_disp = ($q3_myarray['other_history'])?$q3_myarray['other_history']:"none provided";

  if ($q3_myarray['medicationscheck']) {
    $medications_disp = $q3_myarray['other_medications'];
  } else {
    $medications_disp = 'none provided';
  }

  // Oldest Sleepstudy Results
  $q1_sql = "SELECT
            s.date,
            s.sleeptesttype,
            s.ahi,
            s.rdi,
            s.t9002,
            s.o2nadir,
            s.diagnosis,
            s.place,
            s.dentaldevice,
            d.ins_diagnosis,
            d.description
        FROM dental_summ_sleeplab s
            LEFT JOIN dental_ins_diagnosis d ON s.diagnosis = d.ins_diagnosisid
        WHERE patiendid = '$patientid'
        ORDER BY COALESCE(
            STR_TO_DATE(s.date, '%m/%d/%Y'),
            STR_TO_DATE(s.date, '%m/%d/%y'),
            STR_TO_DATE(s.date, '%Y%m%d'),
            STR_TO_DATE(s.date, '%m-%d-%Y'),
            STR_TO_DATE(s.date, '%m-%d-%y'),
            STR_TO_DATE(s.date, '%m%d%Y'),
            STR_TO_DATE(s.date, '%m%d%y')
        ) ASC
        LIMIT 1";

  $q1_myarray = $db->getRow($q1_sql);

  $first_study_date = st($q1_myarray['date']);
  $first_diagnosis = st($q1_myarray['ins_diagnosis']." ".$q1_myarray['description']);
  $first_ahi = st($q1_myarray['ahi']);
  $first_rdi = st($q1_myarray['rdi']);
  $first_o2sat90 = st($q1_myarray['t9002']);
  $first_o2nadir = st($q1_myarray['o2nadir']);
  $first_type_study = st($q1_myarray['sleeptesttype']) . " sleep test";
  $first_center_name = st($q1_myarray['place']);

  $q2_sql = "SELECT
            s.date,
            s.sleeptesttype,
            s.ahi,
            s.rdi,
            s.t9002,
            s.o2nadir,
            d.ins_diagnosis,
            d.description,
            s.place,
            s.dentaldevice,
            sl.company,
            CASE s.sleeptesttype
                WHEN 'PSG Baseline' THEN '1'
                WHEN 'HST Baseline' THEN '2'
                WHEN 'PSG' THEN '3'
                WHEN 'HST' THEN '4'
                ELSE '5'
            END AS sort_order
        FROM dental_summ_sleeplab s
            JOIN dental_patients p ON p.patientid = s.patiendid
            JOIN dental_ins_diagnosis d ON s.diagnosis = d.ins_diagnosisid
            LEFT JOIN dental_sleeplab sl ON s.place = sl.sleeplabid
        WHERE (
                p.p_m_ins_type != '1'
                OR (
                    COALESCE(s.diagnosising_doc, '') != ''
                    AND COALESCE(s.diagnosising_npi, '') != ''
                )
            )
            AND COALESCE(s.diagnosis, '') != ''
            AND s.filename IS NOT NULL
            AND s.patiendid = '$patientid'
            AND s.sleeptesttype IN ('PSG Baseline', 'HST Baseline', 'PSG', 'HST')
        ORDER BY sort_order ASC, COALESCE(
            STR_TO_DATE(s.date, '%m/%d/%Y'),
            STR_TO_DATE(s.date, '%m/%d/%y'),
            STR_TO_DATE(s.date, '%Y%m%d'),
            STR_TO_DATE(s.date, '%m-%d-%Y'),
            STR_TO_DATE(s.date, '%m-%d-%y'),
            STR_TO_DATE(s.date, '%m%d%Y'),
            STR_TO_DATE(s.date, '%m%d%y')
        ) DESC, s.id DESC
        LIMIT 1;";
  
  $q2_myarray = $db->getRow($q2_sql);

  $completed_study_date = st($q2_myarray['date']);
  $completed_diagnosis = st($q2_myarray['ins_diagnosis']." ".$q2_myarray['description']);
  $completed_ahi = st($q2_myarray['ahi']);
  $completed_rdi = st($q2_myarray['rdi']);
  $completed_o2sat90 = st($q2_myarray['t9002']);
  $completed_o2nadir = st($q2_myarray['o2nadir']);
  $completed_type_study = st($q2_myarray['sleeptesttype']) . " sleep test";
  
  if ($q2_myarray == '0') {
    $completed_sleeplab_name = 'home';
  } else {
    $completed_sleeplab_name = st($q2_myarray['company']);
  }

  if ($first_center_name == '0') {
    $first_sleeplab_name = 'home';
  } else {
    $sleeplab_sql = "select company from dental_sleeplab where status=1 and sleeplabid='".$first_center_name."';";
    
    $sleeplab_myarray = $db->getRow($sleeplab_sql);

    $first_sleeplab_name = st($sleeplab_myarray['company']);
  }

  $q2_sql = "SELECT
        date,
        sleeptesttype,
        ahi,
        ahisupine,
        rdi,
        t9002,
        o2nadir,
        diagnosis,
        place,
        dd.device,
        d.ins_diagnosis,
        d.description
    FROM dental_summ_sleeplab dss
        LEFT JOIN dental_ins_diagnosis d ON dss.diagnosis = d.ins_diagnosisid
        LEFT JOIN dental_device dd ON dd.deviceid = dss.dentaldevice
    WHERE patiendid = '$patientid'
    ORDER BY COALESCE(
        STR_TO_DATE(dss.date, '%m/%d/%Y'),
        STR_TO_DATE(dss.date, '%m/%d/%y'),
        STR_TO_DATE(dss.date, '%Y%m%d'),
        STR_TO_DATE(dss.date, '%m-%d-%Y'),
        STR_TO_DATE(dss.date, '%m-%d-%y'),
        STR_TO_DATE(dss.date, '%m%d%Y'),
        STR_TO_DATE(dss.date, '%m%d%y')
    ) DESC
    LIMIT 1";
  
  $q2_myarray = $db->getRow($q2_sql);

  $second_study_date = st($q2_myarray['date']);
  $second_diagnosis = st($q2_myarray['ins_diagnosis']." ".$q2_myarray['description']);
  $second_ahi = st($q2_myarray['ahi']);
  $second_ahisupine = st($q2_myarray['ahisupine']);
  $second_rdi = st($q2_myarray['rdi']);
  $second_o2sat90 = st($q2_myarray['t9002']);
  $second_o2nadir = st($q2_myarray['o2nadir']);
  $second_type_study = st($q2_myarray['sleeptesttype']) . " sleep test";
  $sleep_center_name = st($q2_myarray['place']);

  $dd_sql = "select dd.device, ex.dentaldevice_date FROM dental_ex_page5 ex LEFT JOIN dental_device dd ON dd.deviceid=ex.dentaldevice WHERE ex.patientid='".$patientid."'";
  
  $dd_r = $db->getRow($dd_sql);

  $dentaldevice = $dd_r['device'];
  $delivery_date = ($dd_r['dentaldevice_date'] != '') ? date('F d, Y', strtotime($dd_r['dentaldevice_date'])):'';

  $sleeplab_sql = "select company from dental_sleeplab where status=1 and sleeplabid='".$sleep_center_name."';";

  $sleeplab_myarray = $db->getRow($sleeplab_sql);

  $sleeplab_name = st($sleeplab_myarray['company']);

  // Oldest Subjective results
  $subj1_query = "SELECT ep_eadd, ep_sadd, ep_eladd, sleep_qualadd FROM dentalsummfu WHERE patientid = '".$patientid."' ORDER BY ep_dateadd ASC LIMIT 1;";
  
  $subj1_result = $db->getResults($subj1_query);
  if ($subj1_result) foreach ($subj1_result as $row) {
  	$subj1 = $row;
  }

  $s = "SELECT ess as ep_eadd, snoring_sound as ep_sadd, energy_level as ep_eladd, sleep_qual as sleep_qualadd FROM dental_q_page1 WHERE patientid='".mysqli_real_escape_string($con, $_GET['pid'])."'";
  
  $r = $db->getRow($s);
  $subj1 = $r;

  // Newest Subjective Results
  $subj2_query = "SELECT ep_eadd, ep_sadd, ep_eladd, sleep_qualadd FROM dentalsummfu WHERE patientid = '".$patientid."' ORDER BY ep_dateadd DESC LIMIT 1;";
  
  $subj2_result = $db->getResults($subj2_query);
  if ($subj2_result) foreach ($subj2_result as $row) {
  	$subj2 = $row;
  }

  /*

  // Device Delivery Date
  $device_query = "SELECT date_completed FROM dental_flow_pg2_info WHERE patientid = '".$patientid."' AND segmentid = 7 ORDER BY stepid DESC LIMIT 1;";
  $device_result = mysqli_query($con, $device_query);
  //$delivery_date = date('F d, Y', strtotime(mysql_result($device_result, 0)));

  */

  // Delay Reason and Description
  $reason_query = "SELECT delay_reason as reason, description FROM dental_flow_pg2_info WHERE patientid = '".$patientid."' AND segmentid = 5 ORDER BY date_completed DESC, id DESC LIMIT 1;";
  
  $reason_result = $db->getResults($reason_query);
  if ($reason_result) foreach ($reason_result as $row) {
  	$delay = $row;
  }
  $delay['description'] = (!empty($delay['description']) ? $delay['description'] : '');

  // Select BMI
  $bmi_query = "SELECT bmi FROM dental_patients WHERE patientid = '".$patientid."';";
  
  $bmi = $db->getRow($bmi_query)['bmi'];

  // Reason seeking treatment
  $reason_query = "SELECT reason_seeking_tx FROM dental_summary WHERE patientid = '".$patientid."';";
  
  $reason_seeking_tx = $db->getRow($reason_query)['reason_seeking_tx'];

  $cc_sql = "select chief_complaint_text from dental_q_page1 WHERE patientid='".mysqli_real_escape_string($con, (!empty($patientid) ? $patientid : ''))."'";

  $cc_row = $db->getRow($cc_sql);

  $reason_seeking_tx = $cc_row['chief_complaint_text'];

  $q1_sql = "select * from dental_q_page1 where patientid='".$patientid."'";

  $q1_myarray = $db->getRow($q1_sql);

  $main_reason = st($q1_myarray['main_reason']);
  $main_reason_other = st($q1_myarray['main_reason_other']);
  $complaintid = st($q1_myarray['complaintid']);

  if($complaintid <> '')
  {
    $chief_arr = explode('~',$complaintid);

    if (count($chief_arr) <> 0) {
      $c_count = 0;

      foreach($chief_arr as $c_val)
      {
        if(trim($c_val) <> '')
        {
                $c_s = explode('|',$c_val);
                $c_id[$c_count] = $c_s[0];
                $c_seq[$c_count] = $c_s[1];
                $c_count++;
        }
      }
    }

    asort($c_seq );

    foreach($c_seq as $i=>$val)
    {
      $comp_sql = "select * from dental_complaint where status=1 and complaintid='".$c_id[$i]."'";
      
      $comp_myarray = $db->getRow($comp_sql);

      $reason_seeking_tx .= ", " . st($comp_myarray['complaint']);
    }
  }

  // Symptoms 
  $sql = "SELECT complaintid FROM dental_q_page1 WHERE patientid = '".$patientid."' LIMIT 1;";
  
  $result = $db->getResults($sql);

  foreach ($result as $row) {
  	$complaint = explode("~", rtrim($row['complaintid'], "~"));
  }

  foreach ($complaint as $pair) {
  	$idscore = explode("|", $pair);
  	$compid[] = $idscore[0];
  }
  foreach ($compid as $id) {
  	$sql = "SELECT complaint FROM dental_complaint WHERE complaintid = '".$id."';";
  	
    $result = $db->getResults($sql);
  	if ($result) foreach ($result as $row) {
  		$symptoms[] = $row['complaint'];
  	}
  }

  if (!isset($symptom_list)) {
    $symptom_list = '';
  }

  if ($symptoms) foreach ($symptoms as $key => $value) {
  	if ($key != count($symptoms) -1 && $key != count($symptoms) -2) {
  		$symptom_list .= $value . ", ";
  	} elseif ($key == count($symptoms) -2) {
  		$symptom_list .= $value . " and ";
  	} else {
  		$symptom_list .= $value;
  	}
  }

  // Nights per Week and Current ESS TSS 
  $followup_query = "SELECT nightsperweek, ep_eadd, ep_tsadd FROM dentalsummfu where patientid = '".$patientid."' ORDER BY ep_dateadd DESC LIMIT 1;";
  
  $followup_result = $db->getResults($followup_query);
  if ($followup_result) foreach ($followup_result as $row) {
  	$followup = $row;
  }

  // Nights per Week and Current ESS TSS 
  $initesstss_query = "SELECT ess, tss from dental_q_page1 WHERE patientid = '".$patientid."' LIMIT 1;";
  
  $initess = $db->getRow($initesstss_query)['ess'];
  $inittss = $db->getRow($initesstss_query)['tss'];

  // Non Compliance Reason and Description
  $reason_query = "SELECT noncomp_reason as reason, description FROM dental_flow_pg2_info WHERE patientid = '".$patientid."' AND segmentid = 9 ORDER BY date_completed DESC, id DESC LIMIT 1";
  
  $reason_result = $db->getResults($reason_query);

  if ($reason_result) foreach ($reason_result as $row) {
  	$noncomp = $row;
  }

  $noncomp['description'] = (!empty($noncomp['description']) ? $noncomp['description'] : '');

  $sign_sql = "SELECT * FROM dental_user_signatures WHERE user_id='".mysqli_real_escape_string($con, $_SESSION['userid'])."' ORDER BY adddate DESC LIMIT 1";

  $sign = $db->getRow($sign_sql);
  $signature_file = 'signature_'.$_SESSION['userid'].'_'.$sign['id'].'.png';

  // Load $template
  if ($template_type == '0') {
    $letter_sql = "SELECT body FROM dental_letter_templates WHERE companyid='".mysqli_real_escape_string($con, $companyid)."' AND triggerid='".mysqli_real_escape_string($con, $templateid)."'";
  } else {
    $letter_sql = "SELECT body FROM dental_letter_templates_custom WHERE id='".mysqli_real_escape_string($con, $templateid)."'";
  }

  $letter_r = $db->getRow($letter_sql);
  $template = $letter_r['body'];
  $orig_template = $letter_r['body'];
  $header = '';

  if ($use_letter_header == "1") {
    $header .= '<p>
      %franchisee_fullname%<br />
      %franchisee_practice%<br />
      %franchisee_addr%
      </p>
      ';
    if ($header_space) { 
  	  $header .= "<p> &nbsp; </p>"; 
    }
  }

  $header .= '<p>%todays_date%</p>';

  if ($header_space) {
    $header .= "<p> &nbsp; </p>";
  }

  if ($indent_address == "1") {
    $header .= '
      <table border="0">
        <tr>
          <td width="70"></td>
          <td>
            %contact_fullname%<br />
            %practice%
            %addr1%%addr2%<br />
            %city%, %state% %zip%<br />
          </td>
        </tr>
      </table>
      ';
  } else {
    $header .= '
      %contact_fullname%<br />
      %practice%
      %addr1%%addr2%<br />
      %city%, %state% %zip%
      ';
  }

  $header .= "<br />";
  $orig_header = $header;
  $template = $header . $template;
  $orig_template = $header . $orig_template;

  if (!empty($altered_template) && !isset($_POST['reset_letter'])) $template = $altered_template;
?>

<form action="/manage/edit_letter.php?pid=<?php echo $patientid?>&lid=<?php echo $masterid?>&goto=<?php echo (!empty($_REQUEST['goto']) ? $_REQUEST['goto'] : '');?><?php print (!empty($_GET['backoffice']) && $_GET['backoffice'] == 1 ? "&backoffice=".$_GET['backoffice'] : ""); ?>" method="post" class="letter">
  <input type="hidden" name="numletters" value="<?php echo $numletters?>" />
    
    <?php
      if ($_POST != array()) {
        if (!empty($_POST['duplicate_letter'])) {
  	      foreach ($_POST['duplicate_letter'] as $key => $value) {
            $dupekey = $key;
          }
        }

        // Check for updated templates search and replace 1 of 2
        foreach ($letter_contacts as $key => $contact) {
      		$search = array();
      		$replace = array();
      		$search[] = '%todays_date%';
      		$replace[] = "<strong>" . $todays_date . "</strong>";
      		$search[] = '%contact_salutation%';
          $replace[] = "<strong>" . $contact['salutation'] . "</strong>";
      		$search[] = '%contact_fullname%';
      		$replace[] = "<strong>" . $contact['salutation'] . " " . $contact['firstname'] . " " . $contact['lastname'] . "</strong>";
      		$search[] = '%contact_firstname%';
      		$replace[] = "<strong>" . $contact['firstname'] . "</strong>";
      		$search[] = '%contact_lastname%';
      		$replace[] = "<strong>" . $contact['lastname'] . "</strong>";
      		$search[] = "%salutation%";
      		$replace[] = "<strong>" . $letter_contacts[$key]['salutation'] . "</strong>";
      		$search[] = '%practice%';
      		$replace[] = ($letter_contacts[$key]['company']) ? "<strong>" . $letter_contacts[$key]['company'] . "</strong><br />" : "";	
      		$search[] = '%contact_email%';
      		$replace[] = "<strong>" . $letter_contacts[$key]['email'] . "</strong>";
      		$search[] = '%addr1%';
      		$replace[] = "<strong>" . $contact['add1'] . "</strong>";
      		$search[] = '%addr2%';
      		$replace[] = ($contact['add2']) ? ", <strong>" . $contact['add2'] . "</strong>" : "";
      		$search[] = '%insurance_id%';
      		$replace[] = "<strong>" . (!empty($patient_info['p_m_ins_id']) ? $patient_info['p_m_ins_id'] : '') . "</strong>";
      		$search[] = '%city%';
      		$replace[] = "<strong>" . $contact['city'] . "</strong>";
      		$search[] = '%state%';
      		$replace[] = "<strong>" . $contact['state'] . "</strong>";
      		$search[] = '%zip%';
      		$replace[] = "<strong>" . $contact['zip'] . "</strong>";
      		$search[] = '%referral_fullname%';
          
          if ($contact['type'] == 'md_referral' && $contact['id'] == $ref_info['md_referrals'][0]['id']) {
            $replace[] = "<strong>you</strong>";
          } else {
            $replace[] = $referral_fullname;
          }

          $search[] = '%by_referral_fullname%';     
          if ($contact['type'] == 'md_referral' && $contact['id'] == $ref_info['md_referrals'][0]['id']) {
            $replace[] = "by <strong>you</strong>";
          } else {
            if(trim($referral_fullname)!=''){
              $replace[] = "by ".$referral_fullname;
            } else {
              $replace[] = '';
            }
          }

      		$search[] = '%referral_lastname%';
      		if (!empty($ref_info['md_referrals'])) {
      			$replace[] = "<strong>" . $ref_info['md_referrals'][0]['lastname'] . "</strong>";
      		} else {
      			$replace[] = "<strong>" . (!empty($pcp['lastname']) ? $pcp['lastname'] : '') . "</strong>";
      		}

      		$search[] = '%referral_practice%';
      		if (!empty($ref_info['md_referrals'])) {
      			$replace[] = ($ref_info['md_referrals'][0]['company']) ? "<strong>" . $ref_info['md_referrals'][0]['company'] . "</strong><br />" : "";	
      		} else {
      			$replace[] = !empty($pcp['company']) ? "<strong>" . $pcp['company'] . "</strong><br />" : "";	
      		}

      		$search[] = '%ref_addr1%';
      		if (!empty($ref_info['md_referrals'])) {
      			$replace[] = "<strong>" . $ref_info['md_referrals'][0]['add1'] . "</strong>";
      		} else {
      			$replace[] = "<strong>" . (!empty($pcp['add1']) ? $pcp['add1'] : '') . "</strong>";
      		}

      		$search[] = '%ref_addr2%';
      		if (!empty($ref_info['md_referrals'])) {
      			$replace[] = ($ref_info['md_referrals'][0]['add2']) ? "<strong>" . $ref_info['md_referrals'][0]['add2'] . "</strong>" : "";
      		} else {
      			$replace[] = !empty($pcp['add2']) ? "<strong>" . $pcp['add2'] . "</strong>" : "";
      		}

      		$search[] = '%ref_city%';
      		if (!empty($ref_info['md_referrals'])) {
      			$replace[] = "<strong>" . $ref_info['md_referrals'][0]['city'] . "</strong>";
      		} else {
      			$replace[] = "<strong>" . (!empty($pcp['city']) ? $pcp['city'] : '') . "</strong>";
      		}

      		$search[] = '%ref_state%';
      		if (!empty($ref_info['md_referrals'])) {
      			$replace[] = "<strong>" . $ref_info['md_referrals'][0]['state'] . "</strong>";
      		} else {
      			$replace[] = "<strong>" . (!empty($pcp['state']) ? $pcp['state'] : '') . "</strong>";
      		}

      		$search[] = '%ref_zip%';
      		if (!empty($ref_info['md_referrals'])) {
      			$replace[] = "<strong>" . $ref_info['md_referrals'][0]['zip'] . "</strong>";
      		} else {
      			$replace[] = "<strong>" . (!empty($pcp['zip']) ? $pcp['zip'] : '') . "</strong>";
      		}

      		$search[] = '%ptreferral_fullname%';
      		if (!empty($ptref_info['md_referrals'])) {
      			$replace[] = "<strong>" . $ptref_info['md_referrals'][0]['salutation'] . " " . $ptref_info['md_referrals'][0]['firstname'] . " " . $ptref_info['md_referrals'][0]['lastname'] . "</strong>";
      		} else {
            $replace[] = "";
          }

      		$search[] = '%ptreferral_firstname%';
      		if (!empty($ptref_info['md_referrals'])) {
      			$replace[] = "<strong>" . $ptref_info['md_referrals'][0]['firstname'] . "</strong>";
      		} else {
            $replace[] = "";
          }

      		$search[] = '%ptreferral_lastname%';
      		if (!empty($ptref_info['md_referrals'])) {
      			$replace[] = "<strong>" . $ptref_info['md_referrals'][0]['lastname'] . "</strong>";
      		} else {
            $replace[] = "";
          }

      		$search[] = '%ptreferral_practice%';
      		if (!empty($ptref_info['md_referrals'])) {
      			$replace[] = ($ptref_info['md_referrals'][0]['company']) ? "<strong>" . $ptref_info['md_referrals'][0]['company'] . "</strong><br />" : "";	
      		} else {
            $replace[] = "";
          }

      		$search[] = '%ptref_addr1%';
      		if (!empty($ptref_info['md_referrals'])) {
      			$replace[] = "<strong>" . $ptref_info['md_referrals'][0]['add1'] . "</strong>";
      		} else {
            $replace[] = "";
          }

      		$search[] = '%ptref_addr2%';
      		if (!empty($ptref_info['md_referrals'])) {
      			$replace[] = ($ptref_info['md_referrals'][0]['add2']) ? "<strong>" . $ptref_info['md_referrals'][0]['add2'] . "</strong>" : "";
      		} else {
            $replace[] = "";
          } 

      		$search[] = '%ptref_city%';
      		if (!empty($ptref_info['md_referrals'])) {
      			$replace[] = "<strong>" . $ptref_info['md_referrals'][0]['city'] . "</strong>";
      		} else {
            $replace[] = "";
          } 

      		$search[] = '%ptref_state%';
      		if (!empty($ptref_info['md_referrals'])) {
      			$replace[] = "<strong>" . $ptref_info['md_referrals'][0]['state'] . "</strong>";
      		} else {
            $replace[] = "";
          }

      		$search[] = '%ptref_zip%';
      		if (!empty($ptref_info['md_referrals'])) {
      			$replace[] = "<strong>" . $ptref_info['md_referrals'][0]['zip'] . "</strong>";
      		} else {
            $replace[] = "";
          }

          $search[] = "%company%";
          $replace[] = "<strong>" . $company_info['name'] . "</strong>";
          $search[] = "%company_addr%";
          $replace[] = "<strong>" . nl2br($company_info['add1']." ".$company_info['add2']) . "<br />" . $company_info['city'] . ", " . $company_info['state'] . " " . $company_info['zip'] . "</strong>";
      		$search[] = "%franchisee_fullname%";
      		$replace[] = "<strong>" . $location_info['name'] . "</strong>";
          $search[] = "%doctor_fullname%";
          $replace[] = "<strong>" . $location_info['name'] . "</strong>";
      		$search[] = "%franchisee_lastname%";
      		$replace[] = "<strong>" . array_pop((explode(" ", $location_info['name']))) . "</strong>";
          $search[] = "%doctor_lastname%";
          $replace[] = "<strong>" . array_pop((explode(" ", $location_info['name']))) . "</strong>";
      		$search[] = "%franchisee_practice%";
      		$replace[] = "<strong>" . $location_info['location'] . "</strong>";
          $search[] = "%doctor_practice%";
          $replace[] = "<strong>" . $location_info['location'] . "</strong>";
      		$search[] = "%franchisee_phone%";
      		$replace[] = "<strong>" . format_phone($location_info['phone']) . "</strong>";
          $search[] = "%doctor_phone%";
          $replace[] = "<strong>" . format_phone($location_info['phone']) . "</strong>";
      		$search[] = "%franchisee_addr%";
      		$replace[] = "<strong>" . nl2br($location_info['address']) . "<br />" . $location_info['city'] . ", " . $location_info['state'] . " " . $location_info['zip'] . "</strong>";
          $search[] = "%doctor_addr%";
          $replace[] = "<strong>" . nl2br($location_info['address']) . "<br />" . $location_info['city'] . ", " . $location_info['state'] . " " . $location_info['zip'] . "</strong>";
          $search[] = "%signature_image%";
          $replace[] = "<img src=\"display_file.php?f=".$signature_file."\" />";
      		$search[] = "%patient_fullname%";
      		$replace[] = "<strong>" . (!empty($patient_info['firstname']) ? $patient_info['firstname'] : '') . " " . (!empty($patient_info['lastname']) ? $patient_info['lastname'] : '') . "</strong>";
          $search[] = "%patient_titlefullname%";
          $replace[] = "<strong>" . (!empty($patient_info['salutation']) ? $patient_info['salutation'] : '') . " " . (!empty($patient_info['firstname']) ? $patient_info['firstname'] : '') . " " . (!empty($patient_info['lastname']) ? $patient_info['lastname'] : '') . "</strong>";
      		$search[] = "%patient_lastname%";
      		$replace[] = "<strong>" . (!empty($patient_info['salutation']) ? $patient_info['salutation'] : '') . " " . (!empty($patient_info['lastname']) ? $patient_info['lastname'] : '') . "</strong>";
      		$search[] = "%ccpatient_fullname%";

      		if ($topatient && $contact['type']!='patient') {
      		  $replace[] = "<strong>" . $patient_info['salutation'] . " " . $patient_info['firstname'] . " " . $patient_info['lastname'] . "</strong>";
      		} else {
      		  $replace[] = "";
      		}

      		$search[] = "%patient_dob%";
      		$replace[] = "<strong>" . (!empty($patient_info['dob']) ? $patient_info['dob'] : '') . "</strong>";
      		$search[] = "%patient_firstname%";
      		$replace[] = "<strong>" . (!empty($patient_info['firstname']) ? $patient_info['firstname'] : '') . "</strong>";
      		$search[] = "%patient_age%";
      		$replace[] = "<strong>" . (!empty($patient_info['age']) ? $patient_info['age'] : '') . "</strong>";
      		$search[] = "%patient_gender%";
      		$replace[] = "<strong>" . strtolower(!empty($patient_info['gender']) ? $patient_info['gender'] : '') . "</strong>";
      		$search[] = "%patient_photo%";

      		if($patient_photo!='') {
      			$replace[] = "<img align=\"right\" src=\"display_file.php?f=".$patient_photo."\" />";
      		}else{
      			$replace[] = "";
      		}

      		$search[] = "%His/Her%";
      		$replace[] = "<strong>" . (!empty($patient_info['gender']) && $patient_info['gender'] == "Male" ? "His" : "Her") . "</strong>";
      		$search[] = "%his/her%";
      		$replace[] = "<strong>" . (!empty($patient_info['gender']) && $patient_info['gender'] == "Male" ? "his" : "her") . "</strong>";
      		$search[] = "%he/she%";
      		$replace[] = "<strong>" . (!empty($patient_info['gender']) && $patient_info['gender'] == "Male" ? "he" : "she") . "</strong>";
      		$search[] = "%him/her%";
      		$replace[] = "<strong>" . (!empty($patient_info['gender']) && $patient_info['gender'] == "Male" ? "him" : "her") . "</strong>";
      		$search[] = "%He/She%";
      		$replace[] = "<strong>" . (!empty($patient_info['gender']) && $patient_info['gender'] == "Male" ? "He" : "She") . "</strong>";
      		$search[] = "%history%";
      		$replace[] = "<strong>" . $history_disp . "</strong>";
          $search[] = "%historysentence%";

      		if($history_disp != '') {
            $replace[] = " with a PMH that includes <strong>" . $history_disp . "</strong>";
      		} else {
      			$replace[] = '';
      		}

      		$search[] = "%medications%";
      		$replace[] = "<strong>" . $medications_disp . "</strong>";
	        $search[] = "%medicationssentence%";

        	if ($medications_disp!='') {
            $replace[] = "<strong>" . (!empty($patient_info['gender']) && $patient_info['gender'] == "Male" ? "His" : "Her") . "</strong> medications include <strong>" . $medications_disp . "</strong>.";
        	} else {
            $replace[] = "";
        	}

      		$search[] = "%1st_sleeplab_name%";
      		$replace[] = "<strong>" . $first_sleeplab_name . "</strong>";
      		$search[] = "%2nd_sleeplab_name%";
      		$replace[] = "<strong>" . $sleeplab_name . "</strong>";
      		$search[] = "%type_study%";
      		$replace[] = "<strong>" . $first_type_study . "</strong>";
      		$search[] = "%ahi%";
      		$replace[] = "<strong>" . $first_ahi . "</strong>";
      		$search[] = "%diagnosis%";
      		$replace[] = "<strong>" . $first_diagnosis . "</strong>";
      		$search[] = "%1ststudy_date%";
      		$replace[] = "<strong>" . $first_study_date . "</strong>";
          $search[] = "%completed_sleeplab_name%";
          $replace[] = "<strong>" . $completed_sleeplab_name . "</strong>";
          $search[] = "%completed_type_study%";
          $replace[] = "<strong>" . $completed_type_study . "</strong>";
          $search[] = "%completed_ahi%";
          $replace[] = "<strong>" . $completed_ahi . "</strong>";
          $search[] = "%completed_diagnosis%";
          $replace[] = "<strong>" . $completed_diagnosis . "</strong>";
          $search[] = "%completed_study_date%";
          $replace[] = "<strong>" . $completed_study_date . "</strong>";
      		$search[] = "%1stRDI%";
      		$replace[] = "<strong>" . $first_rdi . "</strong>";
      		$search[] = "%1stRDI/AHI%";		
      		$replace[] = "<strong>" . $first_rdi . "/" . $first_ahi . "</strong>";
      		$search[] = "%1stLowO2%";
      		$replace[] = "<strong>" . $first_o2nadir . "</strong>";
      		$search[] = "%1stTO290%";
      		$replace[] = "<strong>" . $first_o2sat90 . "</strong>";
      		$search[] = "%2ndtype_study%";
      		$replace[] = "<strong>" . $second_type_study . "</strong>";
      		$search[] = "%2ndahi%";
      		$replace[] = "<strong>" . $second_ahi . "</strong>";
      		$search[] = "%2ndahisupine%";
      		$replace[] = "<strong>" . $second_ahisupine . "</strong>";
      		$search[] = "%2ndrdi%";
      		$replace[] = "<strong>" . $second_rdi . "</strong>";
      		$search[] = "%2ndO2Sat90%";
      		$replace[] = "<strong>" . $second_o2sat90 . "</strong>";
      		$search[] = "%2ndstudy_date%";
      		$replace[] = "<strong>" . $second_study_date . "</strong>";
      		$search[] = "%2ndRDI/AHI%";
      		$replace[] = "<strong>" . $second_rdi . "/" . $second_ahi . "</strong>";
      		$search[] = "%2ndLowO2%";
      		$replace[] = "<strong>" . $second_o2nadir . "</strong>";
      		$search[] = "%2ndTO290%";
      		$replace[] = "<strong>" . $second_o2sat90 . "</strong>";
      		$search[] = "%2nddiagnosis%";
      		$replace[] = "<strong>" . $second_diagnosis . "</strong>";
      		$search[] = "%delivery_date%";
      		$replace[] = "<strong>" . $delivery_date . "</strong>";
      		$search[] = "%dental_device%";
      		$replace[] = "<strong>" . $dentaldevice . "</strong>";
      		$search[] = "%1stESS%";
      		$replace[] = "<strong>" . $subj1['ep_eadd'] . "</strong>";
      		$search[] = "%1stSnoring%";
      		$replace[] = "<strong>" . $subj1['ep_sadd'] . "</strong>";
      		$search[] = "%1stEnergy%";
      		$replace[] = "<strong>" . $subj1['ep_eladd'] . "</strong>";
      		$search[] = "%1stQuality%";
      		$replace[] = "<strong>" . $subj1['sleep_qualadd'] . "</strong>";
      		$search[] = "%2ndESS%";
      		$replace[] = "<strong>" . (!empty($subj2['ep_eadd']) ? $subj2['ep_eadd'] : '') . "</strong>";
      		$search[] = "%2ndSnoring%";
      		$replace[] = "<strong>" . (!empty($subj2['ep_sadd']) ? $subj2['ep_sadd'] : '') . "</strong>";
      		$search[] = "%2ndEnergy%";
      		$replace[] = "<strong>" . (!empty($subj2['ep_eladd']) ? $subj2['ep_eladd'] : '') . "</strong>";
      		$search[] = "%2ndQuality%";
      		$replace[] = "<strong>" . (!empty($subj2['sleep_qualadd']) ? $subj2['sleep_qualadd'] : '') . "</strong>";
      		$search[] = "%bmi%";
      		$replace[] = "<strong>" . $bmi . "</strong>";
      		$search[] = "%reason_seeking_tx%";
      		$replace[] = "<strong>" . $reason_seeking_tx . "</strong>";
        	$search[] = "%patprogress%";

        	if ($contact['type']=='patient') {
            $replace[] = "<p>We work hard to keep your doctors up-to-date on your progress in order to help you receive better, more thorough, and more accurate care from all your physicians. We appreciate your cooperation and patronage. Below is a copy of correspondence mailed to the treating physicians we have on file for you; this copy is being sent to you for your records:</p>";
        	} else {
            $replace[] = '';
        	}

		      $search[] = "%tyreferred%";

      		if ($contact['type']=='md_referral') {
            $replace[] = "Thank you for referring <strong>" . $patient_info['salutation'] . " " . $patient_info['firstname'] . " " . $patient_info['lastname'] . "</strong> to our office for treatment with a dental sleep device.";
      		} else {
      			$replace[] = "Our mutual patient, <strong>" . (!empty($patient_info['salutation']) ? $patient_info['salutation'] : '') . " " . (!empty($patient_info['firstname']) ? $patient_info['firstname'] : '') . " " . (!empty($patient_info['lastname']) ? $patient_info['lastname'] : '') . "</strong>, was referred to our office for treatment with a dental sleep device.";
      		}

      		$search[] = "%symptoms%";
      		$replace[] = "<strong>" . $symptom_list . "</strong>";
      		$search[] = "%nightsperweek%";
      		$replace[] = "<strong>" . (!empty($followup['nightsperweek']) ? $followup['nightsperweek'] : '') . "</strong>";
      		$search[] = "%esstssupdate%";

        	if (!empty($followup['ep_eadd']) || !empty($followup['ep_tsadd'])) {
            $replace[] = "<strong>" . ($patient_info['gender'] == "Male" ? "His" : "Her") . "</strong> Epworth Sleepiness Scale / Thornton Snoring Scale has changed from <strong>" . $initess . "/" . $inittss . "</strong> to <strong>" . $followup['ep_eadd'] . "/" . $followup['ep_tsadd'] . "</strong>.";
        	} else {
            $replace[] = '';
        	}

      		$search[] = "%currESS/TSS%";
      		$replace[] = "<strong>" . (!empty($followup['ep_eadd']) ? $followup['ep_eadd'] : '') . "/" . (!empty($followup['ep_tsadd']) ? $followup['ep_tsadd'] : '') . "</strong>";
      		$search[] = "%initESS/TSS%";
      		$replace[] = "<strong>" . $initess . "/" . $inittss . "</strong>";
      		$search[] = "%patient_email%";
      		$replace[] = "<strong>" . (!empty($patient_info['email']) ? $patient_info['email'] : '') . "</strong>";
      		$search[] = "%consult_date%";
      		$replace[] = "<strong>" . $consult_date . "</strong>";
      		$search[] = "%impressions_date%";
      		$replace[] = "<strong>" . $impressions_date . "</strong>";
          $search[] = "%sleeplab_name%";
          $replace[] = "<strong>" . $sleeplab_name . "</strong>";
		      $search[] = "%delay_reason%";

      		switch ($delay['reason']) {
      			case 'insurance':
      				$replace[] = "<strong>insurance problems or issues</strong>";
      				break;
      			case 'dental work':
      				$replace[] = "<strong>additional pending dental work</strong>";
      				break;
      			case 'deciding':
      				$replace[] = "<strong>personal decision</strong>";
      				break;
      			case 'sleep study':
      				$replace[] = "<strong>a pending sleep study</strong>";
      				break;
      			case 'other':
      				if ($delay['description'] == '') {
      					$replace[] = "<strong>(warning: other was selected, but no info provided)</strong>";
      				} else {
      					$replace[] = "<strong>" . $delay['description'] . "</strong>";
      				}
      				break;
      			default:
      				$replace[] = "<strong>(warning: no reason has been selected)</strong>";
      		}

		      $search[] = "%noncomp_reason%";

      		switch ($noncomp['reason']) {
      			case 'pain/discomfort':
      				$replace[] = "<strong>pain and/or discomfort</strong>";
      				break;
      			case 'lost device':
      				$replace[] = "<strong>the device being lost and not replaced</strong>";
      				break;
      			case 'device not working':
      				$replace[] = "<strong>patient claims that the device is not working properly or adequately</strong>";
      				break;
      			case 'other':
      				if ($noncomp['description'] == '') {
      					$replace[] = "<strong>(warning: other was selected, but no info provided)</strong>";
      				} else {
      					$replace[] = "<strong>" . $noncomp['description'] . "</strong>";
      				}
      				break;
      			default:
      				$replace[] = "<strong>(warning: no reason has been selected)</strong>";
      		}

      		$search[] = "%other_mds%";
      		$other_mds = "";
      		$count = 1;

		      foreach ($md_contacts as $index => $md) {
  				  $md_fullname = $md['salutation'] . " " . $md['firstname'] . " " . $md['lastname'];
  				  
            if ($md_fullname != $contact['salutation'] . " " . $contact['firstname'] . " " . $contact['lastname']) {
  					  $other_mds .= $md_fullname;

    					if ($count < count($contacts['mds'])) {
    						$other_mds .= ",<br /> ";
    					}

  					  $count++;
				    }
          }

      		$other_mds = rtrim($other_mds, ",<br /> ");
      		$other_mds .= "PAT,<br />";
      		$replace[] = "<strong>" . $other_mds . "</strong>";
      		$search[] = "%nonpcp_mds%";
      		$nonpcp_mds = "";
      		$count = 1;

      		foreach ($md_contacts as $index => $md) {
      			if ($md['type'] != "md_referral" && !empty($md['contacttype']) && $md['contacttype'] != 'Primary Care Physician') {
      				$md_fullname = $md['salutation'] . " " . $md['firstname'] . " " . $md['lastname'];
      				if ($md_fullname != $contact['salutation'] . " " . $contact['firstname'] . " " . $contact['lastname']) {
      					$nonpcp_mds .= $md_fullname;
      					if ($count < count($contacts['mds'])) {
      						$nonpcp_mds .= ",<br /> ";
      					}	
      					$count++;
      				}
      			}
      		}

		      $nonpcp_mds = rtrim($nonpcp_mds, ",<br /> ");

      		if (empty($ref_info['md_referrals'])) {
      			$replace[] = "<strong>" . $nonpcp_mds . "</strong>";
      		} else {
      			$replace[] = "<strong>" . $other_mds . "</strong>";
      		}

          /**

          */

          $new_template[$cur_template_num] = str_replace($replace, $search, $_POST['letter' . $cur_template_num]);

       		if ($new_template[$cur_template_num] == null && !empty($_POST['new_template'][$cur_template_num])) {
              $new_template[$cur_template_num] = html_entity_decode($_POST['new_template'][$cur_template_num], ENT_COMPAT | ENT_QUOTES, "UTF-8");
          }

          /**

          */

          // Template hasn't changed
          if ($new_template[$cur_template_num] == $orig_template) {
      			$new_template[$cur_template_num] = null;	
          }

          $cur_template_num++;
        }

        // Duplicate Letter Template
      	if (isset($_POST['duplicate_letter']) && !$duplicated) {
      		$dupe_template = $new_template[$dupekey];
          foreach ($letter_contacts as $key => $contact) {
            $new_template[$key] = $dupe_template;
          }
      		$duplicated = true;
      	}

      	// Reset Letter
      	if (isset($_POST['reset_letter'])) {
      		foreach ($_POST['reset_letter'] as $key => $value) {
      			$resetid = $key;
      		}
      		reset_letter($letterid);
      		$new_template[$resetid] = null;
    ?>
      <script type="text/javascript">
        window.location=window.location;
      </script>
    <?php
      	}
      }

      foreach ($letter_contacts as $key => $contact) {
      	// Token search and replace arrays search and replace 2 of 2
      	$search = array();
      	$replace = array();
      	$search[] = '%todays_date%';
      	$replace[] = "<strong>" . $todays_date . "</strong>";
      	$search[] = '%contact_salutation%';
        $replace[] = "<strong>" . $contact['salutation'] . "</strong>";
      	$search[] = '%contact_fullname%';
      	$replace[] = "<strong>" . $contact['salutation'] . " " . $contact['firstname'] . " " . $contact['lastname'] . "</strong>";
      	$search[] = '%contact_firstname%';
      	$replace[] = "<strong>" . $contact['firstname'] . "</strong>";
      	$search[] = '%contact_lastname%';
      	$replace[] = "<strong>" . $contact['lastname'] . "</strong>";
      	$search[] = "%salutation%";
      	$replace[] = "<strong>" . $letter_contacts[$key]['salutation'] . "</strong>";
      	$search[] = '%practice%';
      	$replace[] = !empty($letter_contacts[$key]['company']) ? "<strong>" . $letter_contacts[$key]['company'] . "</strong><br />" : "";	
        $search[] = '%insurance_id%';
        $replace[] = "<strong>" . (!empty($patient_info['p_m_ins_id']) ? $patient_info['p_m_ins_id'] : '') . "</strong>";
      	$search[] = '%contact_email%';
      	$replace[] = "<strong>" . $letter_contacts[$key]['email'] . "</strong>";
      	$search[] = '%addr1%';
      	$replace[] = "<strong>" . $contact['add1'] . "</strong>";
        $search[] = '%addr2%';
      	$replace[] = ($contact['add2']) ? ", <strong>" . $contact['add2'] . "</strong>" : "";
        $search[] = '%city%';
      	$replace[] = "<strong>" . $contact['city'] . "</strong>";
        $search[] = '%state%';
      	$replace[] = "<strong>" . $contact['state'] . "</strong>";
        $search[] = '%zip%';
      	$replace[] = "<strong>" . $contact['zip'] . "</strong>";
      	$search[] = '%referral_fullname%';

        if ($contact['type']=='md_referral' && $contact['id'] == $ref_info['md_referrals'][0]['id'] ){
          $replace[] = "<strong>you</strong>";
        } else {
          $replace[] = $referral_fullname;
        }

        $search[] = '%by_referral_fullname%';
        if ($contact['type']=='md_referral' && $contact['id'] == $ref_info['md_referrals'][0]['id'] ){
          $replace[] = "by <strong>you</strong>";
        } else {
    			if(trim($referral_fullname)!=''){
                            	$replace[] = "by ".$referral_fullname;
    			}else{
    				$replace[] = '';
    			}
        }

	      $search[] = '%referral_lastname%';
      	if (!empty($ref_info['md_referrals'])) {
      		$replace[] = "<strong>" . $ref_info['md_referrals'][0]['lastname'] . "</strong>";
      	} else {
      		$replace[] = "<strong>" . (!empty($pcp['lastname']) ? $pcp['lastname'] : '') . "</strong>";
      	}

      	$search[] = '%referral_practice%';
      	if (!empty($ref_info['md_referrals'])) {
      		$replace[] = ($ref_info['md_referrals'][0]['company']) ? "<strong>" . $ref_info['md_referrals'][0]['company'] . "</strong><br />" : "";	
      	} else {
      		$replace[] = !empty($pcp['company']) ? "<strong>" . $pcp['company'] . "</strong><br />" : "";	
      	}

      	$search[] = '%ref_addr1%';
      	if (!empty($ref_info['md_referrals'])) {
      		$replace[] = "<strong>" . $ref_info['md_referrals'][0]['add1'] . "</strong>";
      	} else {
      		$replace[] = "<strong>" . (!empty($pcp['add1']) ? $pcp['add1'] : '') . "</strong>";
      	}

      	$search[] = '%ref_addr2%';
      	if (!empty($ref_info['md_referrals'])) {
      		$replace[] = ($ref_info['md_referrals'][0]['add2']) ? "<strong>" . $ref_info['md_referrals'][0]['add2'] . "</strong>" : "";
      	} else {
      		$replace[] = !empty($pcp['add2']) ? "<strong>" . $pcp['add2'] . "</strong>" : "";
      	}

      	$search[] = '%ref_city%';
      	if (!empty($ref_info['md_referrals'])) {
      		$replace[] = "<strong>" . $ref_info['md_referrals'][0]['city'] . "</strong>";
      	} else {
      		$replace[] = "<strong>" . (!empty($pcp['city']) ? $pcp['city'] : '') . "</strong>";
      	}

      	$search[] = '%ref_state%';
      	if (!empty($ref_info['md_referrals'])) {
      		$replace[] = "<strong>" . $ref_info['md_referrals'][0]['state'] . "</strong>";
      	} else {
      		$replace[] = "<strong>" . (!empty($pcp['state']) ? $pcp['state'] : '') . "</strong>";
      	}

      	$search[] = '%ref_zip%';
      	if (!empty($ref_info['md_referrals'])) {
      		$replace[] = "<strong>" . $ref_info['md_referrals'][0]['zip'] . "</strong>";
      	} else {
      		$replace[] = "<strong>" . (!empty($pcp['zip']) ? $pcp['zip'] : '') . "</strong>";
      	}

		    $search[] = '%ptreferral_fullname%';
        if (!empty($ptref_info['md_referrals'])) {
		      $replace[] = "<strong>" . $ptref_info['md_referrals'][0]['salutation'] . " " . $ptref_info['md_referrals'][0]['firstname'] . " " . $ptref_info['md_referrals'][0]['lastname'] . "</strong>";
	      } else {
          $replace[] = "";
        }

    		$search[] = '%ptreferral_firstname%';
        if (!empty($ptref_info['md_referrals'])) {
    		  $replace[] = "<strong>" . $ptref_info['md_referrals'][0]['firstname'] . "</strong>";
    	  } else {
          $replace[] = "";
        }

    		$search[] = '%ptreferral_lastname%';
        if (!empty($ptref_info['md_referrals'])) {
    		  $replace[] = "<strong>" . $ptref_info['md_referrals'][0]['lastname'] . "</strong>";
    	  } else {
          $replace[] = "";
        }

		    $search[] = '%ptreferral_practice%';
        if (!empty($ptref_info['md_referrals'])) {
		      $replace[] = ($ptref_info['md_referrals'][0]['company']) ? "<strong>" . $ptref_info['md_referrals'][0]['company'] . "</strong><br />" : "";	
	      } else {
          $replace[] = "";
        }

		    $search[] = '%ptref_addr1%';
        if (!empty($ptref_info['md_referrals'])) {
		      $replace[] = "<strong>" . $ptref_info['md_referrals'][0]['add1'] . "</strong>";
	      } else {
          $replace[] = "";
        }

    		$search[] = '%ptref_addr2%';
        if (!empty($ptref_info['md_referrals'])) {
    		  $replace[] = ($ptref_info['md_referrals'][0]['add2']) ? "<strong>" . $ptref_info['md_referrals'][0]['add2'] . "</strong>" : "";
    	  } else {
          $replace[] = "";
        } 

    		$search[] = '%ptref_city%';
        if (!empty($ptref_info['md_referrals'])) {
    		  $replace[] = "<strong>" . $ptref_info['md_referrals'][0]['city'] . "</strong>";
    	  }else{
          $replace[] = "";
        }

    		$search[] = '%ptref_state%';
        if (!empty($ptref_info['md_referrals'])) {
    		  $replace[] = "<strong>" . $ptref_info['md_referrals'][0]['state'] . "</strong>";
    	  }else{
          $replace[] = "";
        }

    		$search[] = '%ptref_zip%';
        if (!empty($ptref_info['md_referrals'])) {
    		  $replace[] = "<strong>" . $ptref_info['md_referrals'][0]['zip'] . "</strong>";
    	  }else{
    		  $replace[] = "";
    	  } 

        $search[] = "%company%";
        $replace[] = "<strong>" . $company_info['name'] . "</strong>";
        $search[] = "%company_addr%";
        $replace[] = "<strong>" . nl2br($company_info['add1']." ".$company_info['add2']) . "<br />" . $company_info['city'] . ", " . $company_info['state'] . " " . $company_info['zip'] . "</strong>";
      	$search[] = "%franchisee_fullname%";
      	$replace[] = "<strong>" . $location_info['name'] . "</strong>";
        $search[] = "%doctor_fullname%";
        $replace[] = "<strong>" . $location_info['name'] . "</strong>";
      	$search[] = "%franchisee_lastname%";
      	$replace[] = "<strong>" . array_pop((explode(" ", $location_info['name']))) . "</strong>";
        $search[] = "%doctor_lastname%";
        $replace[] = "<strong>" . array_pop((explode(" ", $location_info['name']))) . "</strong>";
      	$search[] = "%franchisee_practice%";
      	$replace[] = "<strong>" . $location_info['location'] . "</strong>";
        $search[] = "%doctor_practice%";
        $replace[] = "<strong>" . $location_info['location'] . "</strong>";
      	$search[] = "%franchisee_phone%";
      	$replace[] = "<strong>" . format_phone($location_info['phone']) . "</strong>";
        $search[] = "%doctor_phone%";
        $replace[] = "<strong>" . format_phone($location_info['phone']) . "</strong>";
        $search[] = "%signature_image%";
        $replace[] = "<img src=\"display_file.php?f=".$signature_file."\" />";
      	$search[] = "%franchisee_addr%";
      	$replace[] = "<strong>" . nl2br($location_info['address']) . "<br />" . $location_info['city'] . ", " . $location_info['state'] . " " . $location_info['zip'] . "</strong>";
        $search[] = "%doctor_addr%";
        $replace[] = "<strong>" . nl2br($location_info['address']) . "<br />" . $location_info['city'] . ", " . $location_info['state'] . " " . $location_info['zip'] . "</strong>";
      	$search[] = "%patient_fullname%";
      	$replace[] = "<strong>" . (!empty($patient_info['firstname']) ? $patient_info['firstname'] : '') . " " . (!empty($patient_info['lastname']) ? $patient_info['lastname'] : '') . "</strong>";
        $search[] = "%patient_titlefullname%";
        $replace[] = "<strong>" . (!empty($patient_info['salutation']) ? $patient_info['salutation'] : '') . " " . (!empty($patient_info['firstname']) ? $patient_info['firstname'] : '') . " " . (!empty($patient_info['lastname']) ? $patient_info['lastname'] : '') . "</strong>";
      	$search[] = "%patient_lastname%";
      	$replace[] = "<strong>" . (!empty($patient_info['salutation']) ? $patient_info['salutation'] : '') . " " . (!empty($patient_info['lastname']) ? $patient_info['lastname'] : '') . "</strong>";
      	$search[] = "%ccpatient_fullname%";

        if($topatient && $contact['type']!='patient'){
          $replace[] = "<strong>" . (!empty($patient_info['salutation']) ? $patient_info['salutation'] : '') . " " . (!empty($patient_info['firstname']) ? $patient_info['firstname'] : '') . " " . (!empty($patient_info['lastname']) ? $patient_info['lastname'] : '') . "</strong>";
        } else {
          $replace[] = "";
        }

      	$search[] = "%patient_dob%";
      	$replace[] = "<strong>" . (!empty($patient_info['dob']) ? $patient_info['dob'] : '') . "</strong>";
      	$search[] = "%patient_firstname%";
      	$replace[] = "<strong>" . (!empty($patient_info['firstname']) ? $patient_info['firstname'] : '') . "</strong>";
      	$search[] = "%patient_age%";
      	$replace[] = "<strong>" . (!empty($patient_info['age']) ? $patient_info['age'] : '') . "</strong>";
      	$search[] = "%patient_gender%";
      	$replace[] = "<strong>" . strtolower((!empty($patient_info['gender'])) ? $patient_info['gender'] : '') . "</strong>";
      	$search[] = "%patient_photo%";

        if($patient_photo!=''){
          $replace[] = "<img style=\"float:right;\" src=\"display_file.php?f=".$patient_photo."\" />";
        } else {
          $replace[] = "";
        }

      	$search[] = "%His/Her%";
      	$replace[] = "<strong>" . (!empty($patient_info['gender']) && $patient_info['gender'] == "Male" ? "His" : "Her") . "</strong>";
      	$search[] = "%his/her%";
      	$replace[] = "<strong>" . (!empty($patient_info['gender']) && $patient_info['gender'] == "Male" ? "his" : "her") . "</strong>";
      	$search[] = "%he/she%";
      	$replace[] = "<strong>" . (!empty($patient_info['gender']) && $patient_info['gender'] == "Male" ? "he" : "she") . "</strong>";
      	$search[] = "%him/her%";
      	$replace[] = "<strong>" . (!empty($patient_info['gender']) && $patient_info['gender'] == "Male" ? "him" : "her") . "</strong>";
      	$search[] = "%He/She%";
      	$replace[] = "<strong>" . (!empty($patient_info['gender']) && $patient_info['gender'] == "Male" ? "He" : "She") . "</strong>";
      	$search[] = "%history%";
      	$replace[] = "<strong>" . $history_disp . "</strong>";
        $search[] = "%historysentence%";

        if($history_disp != ''){
          $replace[] = " with a PMH that includes <strong>" . $history_disp . "</strong>";
        } else {
          $replace[] = '';
        }

      	$search[] = "%medications%";
      	$replace[] = "<strong>" . $medications_disp . "</strong>";
        $search[] = "%medicationssentence%";

      	if($medications_disp!=''){
          $replace[] = "<strong>" . (!empty($patient_info['gender']) && $patient_info['gender'] == "Male" ? "His" : "Her") . "</strong> medications include <strong>" . $medications_disp . "</strong>.";
      	} else {
      		$replace[] = "";
      	}

        $search[] = "%sleeplab_name%";
        $replace[] = "<strong>" . $sleeplab_name . "</strong>";
      	$search[] = "%1st_sleeplab_name%";
      	$replace[] = "<strong>" . $first_sleeplab_name . "</strong>";
      	$search[] = "%2nd_sleeplab_name%";
      	$replace[] = "<strong>" . $sleeplab_name . "</strong>";
      	$search[] = "%type_study%";
      	$replace[] = "<strong>" . $first_type_study . "</strong>";
      	$search[] = "%ahi%";
      	$replace[] = "<strong>" . $first_ahi . "</strong>";
      	$search[] = "%diagnosis%";
      	$replace[] = "<strong>" . $first_diagnosis . "</strong>";
      	$search[] = "%1ststudy_date%";
      	$replace[] = "<strong>" . $first_study_date . "</strong>";
        $search[] = "%completed_sleeplab_name%";
        $replace[] = "<strong>" . $completed_sleeplab_name . "</strong>";
        $search[] = "%completed_type_study%";
        $replace[] = "<strong>" . $completed_type_study . "</strong>";
        $search[] = "%completed_ahi%";
        $replace[] = "<strong>" . $completed_ahi . "</strong>";
        $search[] = "%completed_diagnosis%";
        $replace[] = "<strong>" . $completed_diagnosis . "</strong>";
        $search[] = "%completed_study_date%";
        $replace[] = "<strong>" . $completed_study_date . "</strong>";
      	$search[] = "%1stRDI%";
      	$replace[] = "<strong>" . $first_rdi . "</strong>";
      	$search[] = "%1stRDI/AHI%";
      	$replace[] = "<strong>" . $first_rdi . "/" . $first_ahi . "</strong>";
      	$search[] = "%1stLowO2%";
      	$replace[] = "<strong>" . $first_o2nadir . "</strong>";
      	$search[] = "%1stTO290%";
      	$replace[] = "<strong>" . $first_o2sat90 . "</strong>";
      	$search[] = "%2ndtype_study%";
      	$replace[] = "<strong>" . $second_type_study . "</strong>";
      	$search[] = "%2ndahi%";
      	$replace[] = "<strong>" . $second_ahi . "</strong>";
      	$search[] = "%2ndahisupine%";
      	$replace[] = "<strong>" . $second_ahisupine . "</strong>";
      	$search[] = "%2ndrdi%";
      	$replace[] = "<strong>" . $second_rdi . "</strong>";
      	$search[] = "%2ndO2Sat90%";
      	$replace[] = "<strong>" . $second_o2sat90 . "</strong>";
      	$search[] = "%2ndstudy_date%";
      	$replace[] = "<strong>" . $second_study_date . "</strong>";
      	$search[] = "%2ndRDI/AHI%";
      	$replace[] = "<strong>" . $second_rdi . "/" . $second_ahi . "</strong>";
      	$search[] = "%2ndLowO2%";
      	$replace[] = "<strong>" . $second_o2nadir . "</strong>";
      	$search[] = "%2ndTO290%";
      	$replace[] = "<strong>" . $second_o2sat90 . "</strong>";
      	$search[] = "%2nddiagnosis%";
      	$replace[] = "<strong>" . $second_diagnosis . "</strong>";
      	$search[] = "%delivery_date%";
      	$replace[] = "<strong>" . $delivery_date . "</strong>";
      	$search[] = "%dental_device%";
      	$replace[] = "<strong>" . $dentaldevice . "</strong>";
      	$search[] = "%1stESS%";
      	$replace[] = "<strong>" . $subj1['ep_eadd'] . "</strong>";
      	$search[] = "%1stSnoring%";
      	$replace[] = "<strong>" . $subj1['ep_sadd'] . "</strong>";
      	$search[] = "%1stEnergy%";
      	$replace[] = "<strong>" . $subj1['ep_eladd'] . "</strong>";
      	$search[] = "%1stQuality%";
      	$replace[] = "<strong>" . $subj1['sleep_qualadd'] . "</strong>";
      	$search[] = "%2ndESS%";
      	$replace[] = "<strong>" . (!empty($subj2['ep_eadd']) ? $subj2['ep_eadd'] : '') . "</strong>";
      	$search[] = "%2ndSnoring%";
      	$replace[] = "<strong>" . (!empty($subj2['ep_sadd']) ? $subj2['ep_sadd'] : '') . "</strong>";
      	$search[] = "%2ndEnergy%";
      	$replace[] = "<strong>" . (!empty($subj2['ep_eladd']) ? $subj2['ep_eladd'] : '') . "</strong>";
      	$search[] = "%2ndQuality%";
      	$replace[] = "<strong>" . (!empty($subj2['sleep_qualadd']) ? $subj2['sleep_qualadd'] : '') . "</strong>";
      	$search[] = "%bmi%";
      	$replace[] = "<strong>" . $bmi . "</strong>";
      	$search[] = "%reason_seeking_tx%";
      	$replace[] = "<strong>" . $reason_seeking_tx . "</strong>";
      	$search[] = "%patprogress%";

      	if($contact['type']=='patient'){
      		$replace[] = "<p>We work hard to keep your doctors up-to-date on your progress in order to help you receive better, more thorough, and more accurate care from all your physicians. We appreciate your cooperation and patronage. Below is a copy of correspondence mailed to the treating physicians we have on file for you; this copy is being sent to you for your records:</p>";
      	} else {
      		$replace[] = '';
      	}

        $search[] = "%tyreferred%";
        if($contact['type']=='md_referral'){
          $replace[] = "Thank you for referring <strong>" . $patient_info['salutation'] . " " . $patient_info['firstname'] . " " . $patient_info['lastname'] . "</strong> to our office for treatment with a dental sleep device.";
        } else {
          $replace[] = "Our mutual patient, <strong>" . (!empty($patient_info['salutation']) ? $patient_info['salutation'] : '') . " " . (!empty($patient_info['firstname']) ? $patient_info['firstname'] : '') . " " . (!empty($patient_info['lastname']) ? $patient_info['lastname'] : '') . "</strong>, was referred to our office for treatment with a dental sleep device.";
        }

      	$search[] = "%symptoms%";
      	$replace[] = "<strong>" . $symptom_list . "</strong>";
      	$search[] = "%nightsperweek%";
      	$replace[] = "<strong>" . (!empty($followup['nightsperweek']) ? $followup['nightsperweek'] : '') . "</strong>";
        $search[] = "%esstssupdate%";

      	if(!empty($followup['ep_eadd']) || !empty($followup['ep_tsadd'])){	
          $replace[] = "<strong>" . ($patient_info['gender'] == "Male" ? "His" : "Her") . "</strong> Epworth Sleepiness Scale / Thornton Snoring Scale has changed from <strong>" . $initess . "/" . $inittss . "</strong> to <strong>" . $followup['ep_eadd'] . "/" . $followup['ep_tsadd'] . "</strong>.";
      	} else {
      		$replace[] = '';
      	}

      	$search[] = "%currESS/TSS%";
      	$replace[] = "<strong>" . (!empty($followup['ep_eadd']) ? $followup['ep_eadd'] : '') . "/" . (!empty($followup['ep_tsadd']) ? $followup['ep_tsadd'] : '') . "</strong>";
      	$search[] = "%initESS/TSS%";
      	$replace[] = "<strong>" . $initess . "/" . $inittss . "</strong>";
      	$search[] = "%patient_email%";
      	$replace[] = "<strong>" . (!empty($patient_info['email']) ? $patient_info['email'] : '') . "</strong>";
      	$search[] = "%consult_date%";
      	$replace[] = "<strong>" . $consult_date . "</strong>";
      	$search[] = "%impressions_date%";
      	$replace[] = "<strong>" . $impressions_date . "</strong>";
      	$search[] = "%delay_reason%";

      	switch ($delay['reason']) {
      		case 'insurance':
      			$replace[] = "<strong>insurance problems or issues</strong>";
      			break;
      		case 'dental work':
      			$replace[] = "<strong>additional pending dental work</strong>";
      			break;
      		case 'deciding':
      			$replace[] = "<strong>personal decision</strong>";
      			break;
      		case 'sleep study':
      			$replace[] = "<strong>a pending sleep study</strong>";
      			break;
      		case 'other':
      			if ($delay['description'] == '') {
      				$replace[] = "<strong>(warning: other was selected, but no info provided)</strong>";
      			} else {
      				$replace[] = "<strong>" . $delay['description'] . "</strong>";
      			}
      			break;
      		default:
      			$replace[] = "<strong>(warning: no reason has been selected)</strong>";
      	}

      	$search[] = "%noncomp_reason%";
      	switch ($noncomp['reason']) {
      		case 'pain/discomfort':
      			$replace[] = "<strong>pain and/or discomfort</strong>";
      			break;
      		case 'lost device':
      			$replace[] = "<strong>the device being lost and not replaced</strong>";
      			break;
      		case 'device not working':
      			$replace[] = "<strong>patient claims that the device is not working properly or adequately</strong>";
      			break;
      		case 'other':
      			if ($noncomp['description'] == '') {
      				$replace[] = "<strong>(warning: other was selected, but no info provided)</strong>";
      			} else {
      				$replace[] = "<strong>" . $noncomp['description'] . "</strong>";
      			}
      			break;
      		default:
      			$replace[] = "<strong>(warning: no reason has been selected)</strong>";
      	}

      	$search[] = "%other_mds%";
      	$other_mds = "";
      	$count = 1;
        $firstmd = true;

	      foreach ($md_contacts as $index => $md) {
    			$md_fullname = $md['salutation'] . " " . $md['firstname'] . " " . $md['lastname'];
    			if ($md_fullname != $contact['salutation'] . " " . $contact['firstname'] . " " . $contact['lastname']) {
    				if (!$firstmd) {
    					$other_mds .= ",<br /> ";
    				} else {
    					$firstmd = false;
    				}	
            $other_mds .= $md_fullname;
    			}
    			$count++;
    	  }

        /*

      	if($cc_topatient && $contact['type']!='patient'){
      		//$other_mds .= ",<br />".$patient_info['firstname']." ".$patient_info['lastname'];
      	}

        */

      	$replace[] = "<strong>" . $other_mds . "</strong>";
      	$search[] = "%nonpcp_mds%";
      	$nonpcp_mds = "";
      	$count = 1;

      	foreach ($md_contacts as $index => $md) {
      		if ($md['type'] != "md_referral" && !empty($md['contacttype']) && $md['contacttype'] != 'Primary Care Physician') {
      			$md_fullname = $md['salutation'] . " " . $md['firstname'] . " " . $md['lastname'];
      			if ($md_fullname != $contact['salutation'] . " " . $contact['firstname'] . " " . $contact['lastname']) {
      				$nonpcp_mds .= $md_fullname;
      				if ($count < count($contacts['mds'])) {
      					$nonpcp_mds .= ",<br /> ";
      				}	
      				$count++;
      			}
      		}
      	}

      	$nonpcp_mds = rtrim($nonpcp_mds, ",<br /> ");
        if (empty($ref_info['md_referrals'])) {
      		$replace[] = "<strong>" . $nonpcp_mds . "</strong>";
      	} else {
      		$replace[] = "<strong>" . $other_mds . "</strong>";
      	}
       	if (!empty($new_template[$cur_letter_num])) {
      	  $letter[$cur_letter_num] = str_replace($search, $replace, $new_template[$cur_letter_num]);
      	} else {
      	  $letter[$cur_letter_num] = str_replace($search, $replace, $template);
       	}

	      $new_template[$cur_letter_num] = str_replace($search, $replace, (!empty($new_template[$cur_letter_num]) ? $new_template[$cur_letter_num] : ''));

	      // Print Letter Body		

        if($status == DSS_LETTER_SEND_FAILED){
    ?>
          <div style="width: 100%; text-align: center;">Sending of letter failed. Letter was attempted to be sent to <a href="#" onclick="loadPopup('add_contact.php?ed=<?php echo  $contact['id']; ?>'); return false;"><?php echo  $contact['firstname'] . " " . $contact['lastname']; ?></a></div>
    <?php
        }
    ?>

	      <div style="margin: auto; width: 95%; padding: 3px;">
		      <div align="left" style="width: 40%; padding: 3px; float: left">
                <input type="hidden" name="contacts[<?= $cur_letter_num ?>][id]" value="<?= $contact['id'] ?>" />
                <input type="hidden" name="contacts[<?= $cur_letter_num ?>][type]" value="<?= $contact['type'] ?>" />
			      Letter <?php print $cur_letter_num+1; ?> of <?php print $master_num; ?>.&nbsp;  Delivery Method: <?php print ($method ? $method : $contact['preferredcontact']); ?> <a href="#" onclick="$('#del_meth_<?php print $cur_letter_num; ?>').css('display','inline');$(this).hide();return false;" id="change_method_<?php print $cur_letter_num; ?>" class="addButton"> Change </a>
            
            <div id="del_meth_<?php print $cur_letter_num; ?>" style="display:none;">
              <?php $send_meth = $method ? $method : $contact['preferredcontact']; ?>
              
              <?php if($send_meth == 'fax') { ?>
                <input type="button" onclick="$('#del_meth_<?php print $cur_letter_num; ?>').hide();$('#change_method_<?php print $cur_letter_num; ?>').css('display','inline');return false;" class="addButton" value="Fax" />
              <?php } elseif ($contact['fax']!='') { ?>
                <input type="submit" name="fax_letter[<?php echo $cur_letter_num?>]" class="addButton" value="Fax" />
              <?php } else { ?>
                <input type="button" name="fax_letter[<?php echo $cur_letter_num?>]" onclick="alert('No fax number is available for this contact. Set a fax number for this contact via the \'Contacts\' page in your software.');return false;" class="addButton grayButton" value="Fax" />
              <?php } ?>

              <?php if($send_meth == 'paper') { ?>
                <input type="button" onclick="$('#del_meth_<?php print $cur_letter_num; ?>').hide();$('#change_method_<?php print $cur_letter_num; ?>').css('display','inline');return false;" class="addButton" value="Paper"  />
              <?php } else { ?>
                <input type="submit" name="paper_letter[<?php echo $cur_letter_num?>]" class="addButton" value="Paper" />
              <?php } ?>

              <input type="button" onclick="$('#del_meth_<?php print $cur_letter_num; ?>').hide();$('#change_method_<?php print $cur_letter_num; ?>').css('display','inline'); return false;" class="addButton" value="Cancel" />
            </div>
		      </div>

		      <div align="right" style="width:30%; padding: 3px; float: right">
                <button id="toggle-hidden-letter<?= $cur_letter_num ?>" class="preview-toggle-hidden addButton"
                        onclick="return false;" title="Show/hide line breaks">
                  &#xb6;
                </button>
                &nbsp;&nbsp;
        		<button id="edit_but_letter<?php echo $cur_letter_num;?>" class="addButton" onclick="Javascript: edit_letter('letter<?php echo $cur_letter_num?>', '<?php echo $font_size;?>','<?php echo $font_family;?>');return false;" >
        			Edit Letter
        		</button>
            <button style="display:none;" id="cancel_edit_but_letter<?php echo $cur_letter_num;?>" class="addButton" onclick="Javascript: hide_edit_letter('letter<?= $cur_letter_num ?>');return false;" >
              Cancel Edits
            </button>
        		&nbsp;&nbsp;&nbsp;&nbsp;
        		&nbsp;&nbsp;&nbsp;&nbsp;

          	<?php if(($method ? $method : $contact['preferredcontact'])=='fax' && $franchisee_info['use_digital_fax']!=1 && $_GET['backoffice'] != '1'){ ?>
          		<input type="submit" name="send_letter[<?php echo $cur_letter_num?>]" class="addButton" onclick="return confirm('Warning! Digital fax is not enabled in your account. Click OK to send the letter via standard printing. To enable digital faxing for your account please contact the DSS corporate office.');" value="Send Letter" />
          	<?php } elseif(($method ? $method : $contact['preferredcontact'])=='fax' && $location_info['fax']=="" && $_GET['backoffice'] != '1'){ ?>
              <input type="submit" name="send_letter[<?php echo $cur_letter_num?>]" class="addButton" onclick="return confirm('Warning! You have not specified a return fax number for your location, and no return fax number will appear on this correspondence. Please set your fax number in Admin -> Profile. Click OK to send this fax without your return fax number, or Cancel to add your fax number and retry.');" value="Send Letter" />
            <?php } else { ?>
		          <input type="submit" name="send_letter[<?php echo $cur_letter_num?>]" class="addButton" value="Send Letter" />
	          <?php } ?>
		        &nbsp;&nbsp;&nbsp;&nbsp;
		      </div>

          <?php if(isset($_SESSION['user_type']) && $_SESSION['user_type'] == DSS_USER_TYPE_SOFTWARE) { ?>
            <select name="font_size[<?php echo $cur_letter_num?>]" style="display:none;" class="edit_letter<?php echo $cur_letter_num?>" onchange="javascript:return false;">
              <option <?php echo  ($font_size==8)?'selected="selected"':''; ?> value="8">8</option>
              <option <?php echo  ($font_size==10)?'selected="selected"':''; ?> value="10">10</option>
              <option <?php echo  ($font_size==12)?'selected="selected"':''; ?> value="12">12</option>
              <option <?php echo  ($font_size==14||empty($font_size))?'selected="selected"':''; ?> value="14">14</option>
              <option <?php echo  ($font_size==16)?'selected="selected"':''; ?> value="16">16</option>
              <option <?php echo  ($font_size==20)?'selected="selected"':''; ?> value="20">20</option>
            </select>
            <select name="font_family[<?php echo $cur_letter_num?>]" style="display:none;" class="edit_letter<?php echo $cur_letter_num?>" onchange="javascript:return false;">
              <option <?php echo  ($font_family=='dejavusans'||empty($font_family))?'selected="selected"':''; ?> value="dejavusans">Dejavu Sans</option>
              <option <?php echo  ($font_family=='times')?'selected="selected"':''; ?> value="times">Times New Roman</option>
              <option <?php echo  ($font_family=='courier')?'selected="selected"':''; ?> value="courier">Courier</option>
              <option <?php echo  ($font_family=='helvetica')?'selected="selected"':''; ?> value="helvetica">Helvetica</option>
            </select>

            <input type="submit" name="font_submit[<?php echo $cur_letter_num?>]" id="font_submit_<?php echo $cur_letter_num?>" style="display:none;" />
          <?php } ?>
        	<table width="95%" cellpadding="3" cellspacing="1" border="0" align="center">
        		<tr>
        			<td valign="top">
        				<div id="letter<?= $cur_letter_num ?>"
                             class="preview-letter preview-font-<?= $font_family ?> preview-size-<?= $font_size ?: 14 ?>">
        				  <div class="preview-wrapper">
                            <div class="preview-inner-wrapper">
                              <?= html_entity_decode(
                                preg_replace(
                                    '/(&Acirc;|&nbsp;)+/i',
                                    '',
                                    htmlentities($letter[$cur_letter_num], ENT_COMPAT | ENT_IGNORE, 'UTF-8')
                                ),
                                ENT_COMPAT | ENT_IGNORE,
                                'UTF-8'
                              ) ?>
                            </div>
                          </div>
                          <?php for ($n=1; $n<=10; $n++) { ?><div class="preview-page-break break-<?= $n ?>">page <?= $n + 1 ?></div><?php } ?>
                          <div class="preview-bottom-margin"></div>
        				</div>
        				<input type="hidden" name="new_template[<?php echo $cur_letter_num?>]" value="<?php echo preg_replace('/(&Acirc;|&nbsp;)+/i', '',htmlentities($letter[$cur_letter_num], ENT_COMPAT | ENT_IGNORE,"UTF-8"))?>" />
        			</td>
        		</tr>
        	</table>

        	<div style="float:left;">
        		<input type="submit" style="display:none;" name="reset_letter[<?php echo $cur_letter_num?>]" class="addButton edit_letter<?php echo $cur_letter_num?>" value="Reset" />
        		&nbsp;&nbsp;&nbsp;&nbsp;

        		<?php if(!(!empty($_GET['backoffice']) && $_GET['backoffice'] == "1" && $_SESSION['admin_access']!=1)) { ?>
        		  <input type="submit" name="delete_letter[<?php echo $cur_letter_num?>]" class="addButton" value="Delete" />
        		  &nbsp;&nbsp;&nbsp;&nbsp;
        		<? } ?>
        	</div>
          <div style="float:right;">
            <input type="submit" style="display:none;" name="save_letter[<?php echo $cur_letter_num?>]" class="addButton edit_letter<?php echo $cur_letter_num?>" value="Save Changes" />
          </div>

          <?php if($username) { ?>
        	  <div style="clear:both; width:100%; text-align:center;">
        		  Last edited by  <?php echo  $username; ?> on <?php echo  date('m/d/Y h:i:s a', strtotime($edit_date)); ?>
        	  </div>
        	<?php } ?>

        </div>
        <br><br>
      	<hr width="90%" />
        <br><br>

        <?php
          if (!isset($letter_approve)) {
            $letter_approve = false;
          }
	        // Catch Post Send Submit Button and Send letters Here
          if (isset($_GET['edit_send']) && $_GET['edit_send'] == $cur_letter_num) {
            if (count($letter_contacts) == 1) {
            	$parent = true;
            } else {
          	  $parent = false;
            }

         		$type = $contact['type'];
        		$recipientid = $contact['id'];
  		      if ($_GET['backoffice'] == '1' || $_SESSION['user_type']==DSS_USER_TYPE_SOFTWARE) {
        			$message = $letter[$cur_letter_num];
        			$search= array("<strong>","</strong>");
        			$message = str_replace($search, "", $message);	
  			      echo create_letter_pdf($letterid);
          ?>
              <script type="text/javascript">
                $(document).ready( function(){
                  loadPopup("letter_approve.php?id=<?php echo $letterid; ?>&pid=<?php echo  $_GET['pid']; ?>&backoffice=<?php echo  $_GET['backoffice']; ?><?php echo  ($parent)?'&parent=1':''; ?>&goto=<?php echo  $_GET['goto']; ?>");
                });
              </script>
          <?php
  			      $letter_approve = true;
  		      } else {
    	    		$sentletterid = send_letter($letterid, $parent, $type, $recipientid, $new_template[$cur_letter_num]);
    		      if(!$parent){
  		    ?>
                <script type="text/javascript">
                  window.location=window.location;
                </script>
  		    <?php
  	          }
  		      }
          }

          // Catch Post Send Submit Button and Send letters Here
          if ((!empty($_POST['send_letter'][$cur_letter_num]) || !empty($_POST['save_letter'][$cur_letter_num])
        	  || !empty($_POST['fax_letter'][$cur_letter_num])
            || !empty($_POST['paper_letter'][$cur_letter_num])
            || !empty($_POST['email_letter'][$cur_letter_num])
            || !empty($_POST['font_submit'][$cur_letter_num])
        	  ) && $numletters == $_POST['numletters']) {
              if (count($letter_contacts) == 1) {
                $parent = true;
              } else {
                $parent = false;
              }

              $type = !empty($_POST['contacts'][$cur_letter_num]['type']) ?
                  $_POST['contacts'][$cur_letter_num]['type'] : $contact['type'];
              $recipientid = !empty($_POST['contacts'][$cur_letter_num]['id']) ?
                  $_POST['contacts'][$cur_letter_num]['id'] : $contact['id'];
        		  $message = $new_template[$cur_letter_num];
              $search= array("<strong>","</strong>");
              $message = str_replace($search, "", $message);

          		if(isset($_POST['font_size'][$cur_letter_num])){
          		  $font_size = $_POST['font_size'][$cur_letter_num];
          		} else {
          		  $font_size = null;
          		}

              if(isset($_POST['font_family'][$cur_letter_num])){
                $font_family = $_POST['font_family'][$cur_letter_num];
              } else {
                $font_family = null;
              }

              if($_POST['fax_letter'][$cur_letter_num] != null){
                $send_method = 'fax';
              } elseif($_POST['paper_letter'][$cur_letter_num] != null){
                $send_method = 'paper';
              } elseif($_POST['email_letter'][$cur_letter_num] != null){
                $send_method = 'email';
              } else {
                $send_method = '';
              }

              $saveletterid = save_letter($letterid, $parent, $type, $recipientid, $message, $send_method, $font_size, $font_family);
   	          $num_contacts = num_letter_contacts($_GET['lid']);
  	          
              if($_POST['send_letter'][$cur_letter_num] != null){
                create_letter_pdf($saveletterid);
          ?>
                <script type="text/javascript">
                  $(document).ready( function(){
                    loadPopup("letter_approve.php?id=<?php echo $saveletterid; ?>&pid=<?php echo  $_GET['pid']; ?>&backoffice=<?php echo  $_GET['backoffice']; ?><?php echo  ($parent)?'&parent=1':''; ?>&goto=<?php echo  $_GET['goto']; ?>");
                  });
                </script>
          <?php
                $letter_approve = true;
	            } else {
          ?>
                <script type="text/javascript">
                  window.location=window.location;
                </script>
          <?php
	            }
          }

        	// Catch Post Delete Button and Delete letters Here
          if (!empty($_POST['delete_letter'][$cur_letter_num]) && $numletters == $_POST['numletters']) {
            if (count($letter_contacts) == 1) {
          		$parent = true;
            } else {
        			$parent = false;
        		}

         		$type = $contact['type'];
        		$recipientid = $contact['id'];
            delete_letter($letterid, $parent, $type, $recipientid, $new_template[$cur_letter_num]);
        		
            if ($parent) {
        			if(isset($_REQUEST['goto']) && $_REQUEST['goto'] != '') {
        				if($_REQUEST['goto'] == 'flowsheet') {
        					$page = 'manage_flowsheet3.php?pid='.$_GET['pid'].'&addtopat=1';
        				} elseif($_REQUEST['goto'] == 'letter') {
                  $page = 'dss_summ.php?sect=letters&pid='.$_GET['pid'].'&addtopat=1';
                } elseif($_REQUEST['goto'] == 'new_letter') {
                  $page = 'new_letter.php?pid='.$_GET['pid'];
                } elseif($_REQUEST['goto'] == 'faxes') {
                  $page = 'manage_faxes.php';
                }

          ?>
                <script type="text/javascript">
                        window.location = '<?php echo  $page ?>';
                </script>
          <?php
        			} else {
			    ?>
          			<script type="text/javascript">
          				window.location = '<?php print ($_GET['backoffice'] == "1") ? "/manage/admin/manage_letters.php?status=pending" : "/manage/letters.php?status=pending"; ?>';
          			</script>
			    <?php
			        }
		        } else {
          ?>
              <script type="text/javascript">
                window.location = window.location;
              </script>
          <?php
            }

	          trigger_error("Die called", E_USER_ERROR);
            continue;
          }
          ?>

          <?php
            if (!empty($parent) && $parent && !$letter_approve) {
              if(isset($_REQUEST['goto']) && $_REQUEST['goto'] != '') {
                if($_REQUEST['goto'] == 'flowsheet') {
                  $page = 'manage_flowsheet3.php?pid='.$_GET['pid'].'&addtopat=1';
                } elseif($_REQUEST['goto'] == 'letter') {
                  $page = 'dss_summ.php?sect=letters&pid='.$_GET['pid'].'&addtopat=1';
                } elseif($_REQUEST['goto'] == 'faxes') {
                  $page = 'manage_faxes.php';
                }
          ?>
                <script type="text/javascript">
                        window.location = '<?php echo  $page ?>';
                </script>
          <?php
              } else {
	        ?>
              	<script type="text/javascript">
              		window.location = '<?php print ($_GET['backoffice'] == "1") ? "/manage/admin/manage_letters.php?status=pending" : "/manage/letters.php?status=pending"; ?>';
              	</script>
	  <?php
			        }
            }

            $cur_letter_num++; //increment letter num to identify next letter;
            continue;
      } // End foreach loop through letters
    ?>
  </form>
<?php
  } // END MASTER LOOP
?>
			</div>
		</td>
	</tr>
</table>

<!-- include footer -->
<?php foreach ($googleFonts as $localName=>$remoteName) { ?>
  <link href="https://fonts.googleapis.com/css?family=<?= urlencode($remoteName) ?>" rel="stylesheet">
<?php } ?>
<?php
  function is_physician($id) {
    $db = new Db();
    $con = $GLOBALS['con'];

    $sql = "SELECT physician FROM dental_contacttype where contacttypeid='".mysqli_real_escape_string($con, $id)."'";

    $r = $db->getRow($sql);
    return $r['physician'] == 1;
  }

  if(!empty($_GET['backoffice']) && $_GET['backoffice'] == '1') {
    include 'admin/includes/bottom.htm';
?>

    <div id="popupContact" style="width:750px;">
      <a id="popupContactClose">
        <button>X</button>
      </a>
      <iframe id="aj_pop" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
    </div>
    <div id="backgroundPopup"></div>

<?php
  } else {
	  include 'includes/bottom.htm';
  } 
?>

<!-- function remove_alert not used anywhere -->

<script type="text/javascript">
/*
  function remove_alert(id){
    $.ajax({
      url: "includes/fax_remove_alert.php",
      type: "post",
      data: {id: id},
      success: function(data){
          var r = $.parseJSON(data);
          if(r.error) {
          } else {
            $('#fax_alert_'+id).remove();
          }
      }
    });
  }
*/
</script>
