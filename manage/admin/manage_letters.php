
<?php include 'includes/top.htm'; 

function franchisee_asc($a, $b) {
  return strcmp ($a['franchisee'], $b['franchisee']);
}

function franchisee_desc($a, $b) {
  return strcmp ($b['franchisee'], $a['franchisee']);
}

function user_asc($a, $b) {
  return strcmp ($a['username'], $b['username']);
}

function user_desc($a, $b) {
  return strcmp ($b['username'], $a['username']);
}


function name_asc($a, $b) {
  return strcmp ($a['lastname'] . $a['middlename'] . $a['firstname'], $b['lastname'] . $b['middlename'] . $b['firstname']);
}

function name_desc($a, $b) {
  return strcmp ($b['lastname'] . $b['middlename'] . $b['firstname'], $a['lastname'] . $a['middlename'] . $a['firstname']);
}

function subject_asc($a, $b) {
  return strcmp ($a['subject'], $b['subject']);
}

function subject_desc($a, $b) {
  return strcmp ($b['subject'], $a['subject']);
}

function sentto_asc($a, $b) {
  $word_lista = explode(" ", $a['sentto']);
  $word_listb = explode(" ", $b['sentto']);
  if (is_numeric($word_lista[0]) && is_numeric($word_listb[0])) {
    if ($word_lista[0] == $word_listb[0]) {
      return 0;
    } else {
      return ($word_lista[0] < $word_listb[0]) ? -1 : 1;
    }
  }
  if (is_numeric($word_lista[0])) {
		return -1;
  }
  if (is_numeric($word_listb[0])) {
		return 1;
  }
  return strcmp ($a['sentto'], $b['sentto']);
}

function sentto_desc($a, $b) {
  $word_lista = explode(" ", $a['sentto']);
  $word_listb = explode(" ", $b['sentto']);
  if (is_numeric($word_lista[0]) && is_numeric($word_listb[0])) {
    if ($word_lista[0] == $word_listb[0]) {
      return 0;
    } else {
      return ($word_lista[0] > $word_listb[0]) ? -1 : 1;
    }
  }
  if (is_numeric($word_lista[0])) {
		return 1;
  }
  if (is_numeric($word_listb[0])) {
		return -1;
  }
  return strcmp ($b['sentto'], $a['sentto']);
}

function generated_date_asc($a, $b) {
  if ($a['generated_date'] == $b['generated_date']) {
		return 0;
	}
	return ($a['generated_date'] < $b['generated_date']) ? -1 : 1;
}

function generated_date_desc($a, $b) {
  if ($a['generated_date'] == $b['generated_date']) {
		return 0;
	}
	return ($a['generated_date'] > $b['generated_date']) ? -1 : 1;
}

function date_sent_asc($a, $b) {
  if ($a['date_sent'] == $b['date_sent']) {
		return 0;
	}
	return ($a['date_sent'] < $b['date_sent']) ? -1 : 1;
}

function date_sent_desc($a, $b) {
  if ($a['date_sent'] == $b['date_sent']) {
		return 0;
	}
	return ($a['date_sent'] > $b['date_sent']) ? -1 : 1;
}

function delivery_date_asc($a, $b) {
  if ($a['delivery_date'] == $b['delivery_date']) {
		return 0;
	}
	return ($a['delivery_date'] < $b['delivery_date']) ? -1 : 1;
}

function delivery_date_desc($a, $b) {
  if ($a['delivery_date'] == $b['delivery_date']) {
		return 0;
	}
	return ($a['delivery_date'] > $b['delivery_date']) ? -1 : 1;
}

function send_method_asc($a, $b) {
  return strcmp ($a['send_method'], $b['send_method']);
}

function send_method_desc($a, $b) {
  return strcmp ($b['send_method'], $a['send_method']);
}

$status = 'pending';
$page = '0';
$page_limit = '20';
$column = 'letterid';
$filter = "%";
if (isset($_GET['status'])) { $status = $_GET['status']; }
if (isset($_GET['page'])) { $page = $_GET['page']; }
//if (isset($_GET['sort'])) { $sort = mysql_real_escape_string($_GET['sort']); }
//if (isset($_GET['column'])) { $column = mysql_real_escape_string($_GET['column']); }
if (isset($_GET['filter'])) { $filter = mysql_real_escape_string($_GET['filter']); }
if(!isset($_REQUEST['sort'])){
  $_REQUEST['sort'] = 'date_sent';
	if ($status == 'sent') {
  	$_REQUEST['sortdir'] = 'DESC';
	} else {
  	$_REQUEST['sortdir'] = 'ASC';
	}
}
$sort = $_REQUEST['sort'];
$sortdir = $_REQUEST['sortdir'];

// Letters count and Oldest letter
//$dental_letters_query = "SELECT UNIX_TIMESTAMP(dental_letters.generated_date) as generated_date FROM dental_letters JOIN dental_patients ON dental_letters.patientid=dental_patients.patientid WHERE dental_letters.status = '1' AND dental_letters.delivered = '0' AND dental_letters.deleted = '0' ORDER BY generated_date ASC;";
$dental_letters_query = "SELECT dental_letters.letterid, dental_letters.templateid, dental_letters.patientid, UNIX_TIMESTAMP(dental_letters.date_sent) as date_sent, UNIX_TIMESTAMP(dental_letters.generated_date) as generated_date, dental_letters.topatient, dental_letters.md_list, dental_letters.md_referral_list, dental_letters.docid, dental_letters.userid, dental_letters.send_method, dental_patients.firstname, dental_patients.lastname, dental_patients.middlename FROM dental_letters LEFT JOIN dental_patients on dental_letters.patientid=dental_patients.patientid WHERE dental_letters.status = '1' AND dental_letters.delivered = '0' AND dental_letters.deleted = '0' AND dental_letters.templateid LIKE '".$filter."' ORDER BY dental_letters.letterid ASC;";
$dental_letters_res = mysql_query($dental_letters_query);
$pending_letters = mysql_num_rows($dental_letters_res);
$generated_date = mysql_fetch_array($dental_letters_res);
$seconds_per_day = 86400;
if($generated_date){
$oldest_letter = floor((time() - array_pop($generated_date)) / $seconds_per_day);
}else{
$oldest_letter = '0';
}
// Select Letters into Array
if ($status == 'pending') {
  if(is_super($_SESSION['admin_access'])){
  $letters_query = "SELECT dental_letters.letterid, 
			dental_letters.templateid, 
			dental_letters.patientid, 
			UNIX_TIMESTAMP(dental_letters.date_sent) as date_sent, 
			UNIX_TIMESTAMP(dental_letters.generated_date) as generated_date, 
			dental_letters.topatient, 
			dental_letters.md_list, 
			dental_letters.md_referral_list, 
			dental_letters.docid, 
			dental_letters.userid, 
			dental_letters.send_method, 
			dental_patients.firstname, 
			dental_patients.lastname, 
			dental_patients.middlename FROM dental_letters 
		JOIN dental_users u ON u.userid = dental_letters.docid
		LEFT JOIN dental_patients on dental_letters.patientid=dental_patients.patientid 
			WHERE dental_letters.status = '1' AND 
				dental_letters.delivered = '0' AND 
				dental_letters.deleted = '0' AND 
				dental_letters.templateid LIKE '".$filter."' AND
				u.user_type = '".DSS_USER_TYPE_FRANCHISEE."'
			ORDER BY dental_letters.letterid ASC;";
  }else{
  $letters_query = "SELECT dental_letters.letterid, 
			dental_letters.templateid, 
			dental_letters.patientid, 
			UNIX_TIMESTAMP(dental_letters.date_sent) as date_sent, 
			UNIX_TIMESTAMP(dental_letters.generated_date) as generated_date, 
			dental_letters.topatient, 
			dental_letters.md_list, 
			dental_letters.md_referral_list, 
			dental_letters.docid, 
			dental_letters.userid, 
			dental_letters.send_method, 
			dental_patients.firstname, 
			dental_patients.lastname, 
			dental_patients.middlename FROM dental_letters 
	JOIN dental_user_company uc ON uc.userid = dental_letters.docid
	JOIN dental_users u ON u.userid = dental_letters.docid
	LEFT JOIN dental_patients on dental_letters.patientid=dental_patients.patientid 
		WHERE uc.companyid='".mysql_real_escape_string($_SESSION['companyid'])."' AND
			dental_letters.status = '1' AND 
			dental_letters.delivered = '0' AND 
			dental_letters.deleted = '0' AND 
			dental_letters.templateid LIKE '".$filter."' AND
			u.user_type = '".DSS_USER_TYPE_FRANCHISEE."'
		ORDER BY dental_letters.letterid ASC;";

  }
  $letters_res = mysql_query($letters_query);
  if (!$letters_res) {
    print "MYSQL ERROR:".mysql_errno().": ".mysql_error()."<br/>"."Error selecting letters from the database.";
  } else {
    while ($row = mysql_fetch_assoc($letters_res)) {
      $dental_letters[] = $row;
    }
  }
}

if ($status == 'sent') {
  if(is_super($_SESSION['admin_access'])){
  $letters_query = "SELECT dental_letters.letterid, 
dental_letters.templateid, 
dental_letters.patientid, 
UNIX_TIMESTAMP(dental_letters.generated_date) as generated_date, 
UNIX_TIMESTAMP(dental_letters.delivery_date) as delivery_date, 
dental_letters.pdf_path, 
dental_letters.topatient, 
dental_letters.md_list, 
dental_letters.md_referral_list, 
dental_letters.docid, 
dental_letters.userid, 
dental_letters.send_method, 
dental_patients.firstname, 
dental_patients.lastname, 
dental_patients.middlename FROM dental_letters 
JOIN dental_users u ON dental_letters.docid = u.userid
LEFT JOIN dental_patients on dental_letters.patientid=dental_patients.patientid WHERE dental_letters.delivered = '1' AND dental_letters.deleted = '0' AND dental_letters.templateid LIKE '".$filter."' AND u.user_type = '".DSS_USER_TYPE_FRANCHISEE."' ORDER BY dental_letters.letterid ASC;";
  }else{

  }
  $letters_res = mysql_query($letters_query);
  if (!$letters_res) {
    print "MYSQL ERROR:".mysql_errno().": ".mysql_error()."<br/>"."Error selecting letters from the database.";
  } else {
    while ($row = mysql_fetch_assoc($letters_res)) {
      $dental_letters[] = $row;
    }
  }
}


/* Calculate oldest letter age
foreach ($dental_letters as $key => $row) {
  $generated_date[$key] = $row['generated_date'];
}
arsort($generated_date);
$seconds_per_day = 86400;
$oldest_letter = floor((time() - array_pop($generated_date)) / $seconds_per_day);*/

// Calculate numer of pages
$num_pages = floor(count($dental_letters) / $page_limit);
if (count($dental_letters) % $page_limit) {
  $num_pages++;
}

foreach ($dental_letters as $key => $letter) {
  // Get Franchisee Name
  //$franchisee_query = "SELECT dental_users.name FROM dental_users JOIN dental_patients ON dental_patients.docid=dental_users.userid WHERE dental_patients.patientid = '".$letter['patientid']."';";
  $dental_letters[$key]['id'] = $letter['letterid'];
  $franchisee_query = "SELECT dental_users.name FROM dental_users WHERE userid='".$letter['docid']."'";
  $result = mysql_query($franchisee_query);
  $dental_letters[$key]['franchisee'] = mysql_result($result, 0);
	// Get Username
	$username_query = "SELECT name from dental_users WHERE userid = '" . $letter['userid'] . "';";
	$username_result = mysql_query($username_query);
	$dental_letters[$key]['username'] = mysql_result($username_result, 0);
  // Get Correspondance Column
  $template_sql = "SELECT name, template FROM dental_letter_templates WHERE id = '".$letter['templateid']."';";
  $template_res = mysql_query($template_sql);
  $correspondance = array();
  $correspondance = mysql_fetch_assoc($template_res);
	if (!empty($letter['pdf_path'])) {
    $dental_letters[$key]['url'] = "/manage/letterpdfs/" . $letter['pdf_path'];
  } else { 
  	$dental_letters[$key]['url'] = "/manage/edit_letter.php?fid=" . $letter['patientid'] . "&pid=" . $letter['patientid'] . "&lid=" . $letter['letterid'] . "&backoffice=1";
	}
  $dental_letters[$key]['subject'] = $correspondance['name'];
  if($letter['templateid']==99){
    $dental_letters[$key]['subject'] = "User generated";
  }
  // Get Recipients for Sent to Column
  $contacts = get_contact_info((($letter['topatient'] == "1") ? $letter['patientid'] : ''), $letter['md_list'], $letter['md_referral_list']);
  //print_r($contacts); print "<br />";
  $total_contacts = 0;
    $total_contacts += (isset($contacts['patient']))?count($contacts['patient']):0;
    $total_contacts += (isset($contacts['mds']))?count($contacts['mds']):0;
    $total_contacts += (isset($contacts['md_referrals']))?count($contacts['md_referrals']):0;
  if ($total_contacts > 1) {
    $dental_letters[$key]['sentto'] = $total_contacts . " Contacts";
  } elseif ($total_contacts == 0) {
    $dental_letters[$key]['sentto'] = "<span class=\"red\">No Contacts</span>";
  } else {
    // Patient: Salutation Lastname, Firstname
    $dental_letters[$key]['sentto'] = '';
    $dental_letters[$key]['sentto'] .= (isset($contacts['patient'][0])) ? ($contacts['patient'][0]['lastname'] . ", " . $contacts['patient'][0]['salutation'] . " " . $contacts['patient'][0]['firstname']) : ("");
    // MD: Salutation Lastname, Firstname - Contact Type
    $dental_letters[$key]['sentto'] .= (isset($contacts['mds'][0])) ? ($contacts['mds'][0]['lastname'] . ", " . $contacts['mds'][0]['salutation'] . " " . $contacts['mds'][0]['firstname'] . ((isset($contacts['mds']['contacttype'])) ? (" - " . $contacts['mds']['contacttype']) : (""))) : ("");
    // MD Referral: Salutation Lastname, Firstname - Contact Type
    $dental_letters[$key]['sentto'] .= (isset($contacts['md_referrals'][0])) ? ($contacts['md_referrals'][0]['lastname'] . ", " . $contacts['md_referrals'][0]['salutation'] . " " . $contacts['md_referrals'][0]['firstname'] . ((isset($contacts['md_referrals']['contacttype'])) ? (" - " . $contacts['md_referrals']['contacttype']) : (""))) : ("");
  }
	// Determine Delivery Method
	if ($letter['send_method'] == '') {
		$method = array();
		if(isset($contacts['patient'])){
		foreach($contacts['patient'] as $contact) {
			$method[] = $contact['preferredcontact'];
		}
		}
                if(isset($contacts['mds'])){
		foreach($contacts['mds'] as $contact) {
			$method[] = $contact['preferredcontact'];
		}
		}
                if(isset($contacts['md_referrals'])){
		foreach($contacts['md_referrals'] as $contact) {
			$method[] = $contact['preferredcontact'];
		}
		}
		$result = array_unique($method);
		if (count($result) == 1) {
			$dental_letters[$key]['send_method'] = $result[0];
		} else {
			$dental_letters[$key]['send_method'] = 'multiple';
		}
	}
  // Determine Delivery Status
  if ($status == "pending") {
		$age_in_days = floor((time() - $letter['date_sent']) / $seconds_per_day);
		if ($age_in_days > 7) $dental_letters[$key]['bg'] = "redbg";
    if ($age_in_days <= 7) $dental_letters[$key]['bg'] = "yellowbg";
  } elseif ($status == "sent") {
		$dental_letters[$key]['bg'] = "greenbg";
  }
}

// Sort the letters array
if ($_REQUEST['sort'] == "franchisee" && $_REQUEST['sortdir'] == "ASC") {
  usort($dental_letters, 'franchisee_asc'); 
}
if ($_REQUEST['sort'] == "franchisee" && $_REQUEST['sortdir'] == "DESC") {
  usort($dental_letters, 'user_desc'); 
}
if ($_REQUEST['sort'] == "user" && $_REQUEST['sortdir'] == "ASC") {
  usort($dental_letters, 'franchisee_asc'); 
}
if ($_REQUEST['sort'] == "user" && $_REQUEST['sortdir'] == "DESC") {
 usort($dental_letters, 'user_desc'); 
}
if ($_REQUEST['sort'] == "patient_name" && $_REQUEST['sortdir'] == "ASC") {
  usort($dental_letters, 'name_asc'); 
}
if ($_REQUEST['sort'] == "patient_name" && $_REQUEST['sortdir'] == "DESC") {
  usort($dental_letters, 'name_desc'); 
}
if ($_REQUEST['sort'] == "subject" && $_REQUEST['sortdir'] == "ASC") {
  usort($dental_letters, 'subject_asc'); 
}
if ($_REQUEST['sort'] == "subject" && $_REQUEST['sortdir'] == "DESC") {
  usort($dental_letters, 'subject_desc'); 
}
if ($_REQUEST['sort'] == "sentto" && $_REQUEST['sortdir'] == "ASC") {
  usort($dental_letters, 'sentto_asc'); 
}
if ($_REQUEST['sort'] == "sentto" && $_REQUEST['sortdir'] == "DESC") {
  usort($dental_letters, 'sentto_desc'); 
}
if ($_REQUEST['sort'] == "generated_date" && $_REQUEST['sortdir'] == "ASC") {
  usort($dental_letters, 'generated_date_asc'); 
}
if ($_REQUEST['sort'] == "generated_date" && $_REQUEST['sortdir'] == "DESC") {
  usort($dental_letters, 'generated_date_desc'); 
}
if ($_REQUEST['sort'] == "date_sent" && $_REQUEST['sortdir'] == "ASC") {
  usort($dental_letters, 'date_sent_asc'); 
}
if ($_REQUEST['sort'] == "date_sent" && $_REQUEST['sortdir'] == "DESC") {
  usort($dental_letters, 'date_sent_desc'); 
}
if ($_REQUEST['sort'] == "delivery_date" && $_REQUEST['sortdir'] == "ASC") {
  usort($dental_letters, 'delivery_date_asc'); 
}
if ($_REQUEST['sort'] == "delivery_date" && $_REQUEST['sortdir'] == "DESC") {
  usort($dental_letters, 'delivery_date_desc'); 
}
if ($_REQUEST['sort'] == "send_method" && $_REQUEST['sortdir'] == "ASC") {
  usort($dental_letters, 'send_method_asc'); 
}
if ($_REQUEST['sort'] == "send_method" && $_REQUEST['sortdir'] == "DESC") {
  usort($dental_letters, 'send_method_desc'); 
}


//print_r($dental_letters);

?>

<style>
.redbg{
background:red;
color: white;
}
tr.redbg > td{
color: white;
}
.yellowbg{
background: yellow;
}

.greenbg{
background:green;
color: white;
}
tr.greenbg > td{
color: white;
}
</style>

<div class="letters-tryptych1">
  <h1 class="blue"><?php echo ($status == 'pending') ? "Pending" : "Sent" ?> Letters (<?php echo count($dental_letters); ?>)</h1>
  <form name="filter_letters" action="/manage/admin/manage_letters.php" method="get">
		<input type="hidden" name="status" value="<?=$status?>" />
  Filter by type: <select name="filter" onchange="document.filter_letters.submit();">
    <option value="%"></option>
    <?php
    $templates = "SELECT id, name FROM dental_letter_templates ORDER BY id ASC;";
    $result = mysql_query($templates);
    while ($row = mysql_fetch_assoc($result)) {
      print "<option " . (($filter == $row['id']) ? "selected " : "") . "value=\"" . $row['id'] . "\">" . $row['id'] . " - " . $row['name'] . "</option>";
    }
    ?>
    </select>
  </form>
</div>
<div class="letters-tryptych2">
  <h2>You have <span class="blue"><?php echo $pending_letters; ?></span> letters to review.</h1>
  <h2>The oldest letter is <span class="red"><?php echo $oldest_letter; ?> day(s) old.</h1>
</div>
<div class="letters-tryptych3">
<?php if ($status == "pending"): ?>
  <div style="float:right;margin-right: 10px;">
  	<form method="post" action="/manage/admin/manage_letters.php?status=sent&sort=delivery_date&sortdir=DESC">
  	<input class="addButton" type="submit" value="Sent Letters">
  	</form>
  </div>
<?php endif; ?>
<?php if ($status == "sent"): ?>
  <div style="float:right;margin-right: 10px;">
  	<form method="post" action="/manage/admin/manage_letters.php?status=pending">
  	<input class="addButton" type="submit" value="Pending Letters">
  	</form>
  </div>
<?php endif; ?>
</div>
<div class="letters-pager">Page(s): <?php paging($num_pages,$page,"status=$status&filter=$filter&sort=$sort&sortdir=$sortdir"); ?></div>
<div style="clear:both;">
<table cellpadding="3px" id="letters-table" width="97%" style="margin: 0 auto;">
  <tr class="tr_bg_h">
    <td class="col_head <?= ($_REQUEST['sort'] == 'franchisee')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>"><a href="manage_letters.php?status=<?=$status;?>&page=<?=$page;?>&filter=<?=$filter;?>&sort=franchisee&sortdir=<?php echo ($_REQUEST['sort']=='franchisee'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Franchisee</a></td>
    <td class="col_head <?= ($_REQUEST['sort'] == 'user')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>"><a href="manage_letters.php?status=<?=$status;?>&page=<?=$page;?>&filter=<?=$filter;?>&sort=user&sortdir=<?php echo ($_REQUEST['sort']=='user'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Username</a></td>
<?php if ($status == "pending"): ?>
    <td class="col_head <?= ($_REQUEST['sort'] == 'date_sent')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>"><a href="manage_letters.php?status=<?=$status;?>&page=<?=$page;?>&filter=<?=$filter;?>&sort=date_sent&sortdir=<?php echo ($_REQUEST['sort']=='date_sent'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Received</a></td>
<?php endif; ?>
<?php if ($status == "sent"): ?>
    <td class="col_head <?= ($_REQUEST['sort'] == 'delivery_date')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>"><a href="manage_letters.php?status=<?=$status;?>&page=<?=$page;?>&filter=<?=$filter;?>&sort=delivery_date&sortdir=<?php echo ($_REQUEST['sort']=='delivery_date'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Sent On</a></td>
<?php endif; ?>
    <td class="col_head <?= ($_REQUEST['sort'] == 'patient_name')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>"><a href="manage_letters.php?status=<?=$status;?>&page=<?=$page;?>&filter=<?=$filter;?>&sort=patient_name&sortdir=<?php echo ($_REQUEST['sort']=='patient_name'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Patient Name</a></td>
    <td class="col_head <?= ($_REQUEST['sort'] == 'subject')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>"><a href="manage_letters.php?status=<?=$status;?>&page=<?=$page;?>&filter=<?=$filter;?>&sort=subject&sortdir=<?php echo ($_REQUEST['sort']=='subject'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Correspondance</a></td>
    <td class="col_head <?= ($_REQUEST['sort'] == 'sentto')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>"><a href="manage_letters.php?status=<?=$status;?>&page=<?=$page;?>&filter=<?=$filter;?>&sort=sentto&sortdir=<?php echo ($_REQUEST['sort']=='sentto'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Sent To</a></td>
    <td class="col_head <?= ($_REQUEST['sort'] == 'send_method')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>"><a href="manage_letters.php?status=<?=$status;?>&page=<?=$page;?>&filter=<?=$filter;?>&sort=send_method&sortdir=<?php echo ($_REQUEST['sort']=='send_method'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Method</a></td>
    <td class="col_head <?= ($_REQUEST['sort'] == 'generated_date')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>"><a href="manage_letters.php?status=<?=$status;?>&page=<?=$page;?>&filter=<?=$filter;?>&sort=generated_date&sortdir=<?php echo ($_REQUEST['sort']=='generated_date'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Generated On</a></td>
  </tr>
<?php
  $i = $page_limit * $page;
  $end = $i + $page_limit;
  while ($i < count($dental_letters) && $i < $end) {
    //print $dental_letters[$i]['templateid']; print "<br />";
    $franchisee = $dental_letters[$i]['franchisee'];
		$username = $dental_letters[$i]['username'];
    $received = date('m/d/Y', $dental_letters[$i]['date_sent']);
    $name = $dental_letters[$i]['lastname'] . " " . $dental_letters[$i]['middlename'] . ", " . $dental_letters[$i]['firstname'];
    $url = $dental_letters[$i]['url'];
    $subject = $dental_letters[$i]['subject'];
    $sentto = $dental_letters[$i]['sentto'];
    $id = $dental_letters[$i]['id'];
		$method = $dental_letters[$i]['send_method'];
    $generated = date('m/d/Y', $dental_letters[$i]['generated_date']);
		$delivered = (isset($dental_letters[$i]['delivery_date']))?date('m/d/Y', $dental_letters[$i]['delivery_date']):'';
    if (isset($dental_letters[$i]['bg'])) {
      $bgcolor = ' class="'.$dental_letters[$i]['bg'].'"';
    } else {
      $bgcolor = null;
    }
    
    print "<tr><td>$franchisee</td><td>$username</td>".($status == "pending" ? "<td$bgcolor>$received</td>" : "").($status == "sent" ? "<td$bgcolor>$delivered</td>" : "")."<td>$name</td><td><a href=\"$url\">$subject</a></td><td>$sentto</td><td>$method</td><td>$generated</td></tr>";
    $i++;
  }
?>
</table>

</div>

<?php include 'includes/bottom.htm'; ?>
