<?php include 'includes/top.htm'; 

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

$status = 'pending';
$page = '0';
$page_limit = '10';
$column = 'letterid';
$filter = "%";
if (isset($_GET['status'])) { $status = $_GET['status']; }
if (isset($_GET['page'])) { $page = $_GET['page']; }
//if (isset($_GET['sort'])) { $sort = mysql_real_escape_string($_GET['sort']); }
//if (isset($_GET['column'])) { $column = mysql_real_escape_string($_GET['column']); }
if (isset($_GET['filter'])) { $filter = mysql_real_escape_string($_GET['filter']); }
if(!isset($_REQUEST['sort'])){
  $_REQUEST['sort'] = 'generated_date';
  $_REQUEST['sortdir'] = 'asc';
}
$sort = $_REQUEST['sort'];
$sortdir = $_REQUEST['sortdir'];

// Get doctor id
$docid = $_SESSION['docid'];

// Select Letters into Array
if ($status == 'pending') {
  $letters_query = "SELECT dental_letters.letterid, dental_letters.templateid, dental_letters.patientid, UNIX_TIMESTAMP(dental_letters.generated_date) as generated_date, dental_letters.topatient, dental_letters.md_list, dental_letters.md_referral_list, dental_patients.firstname, dental_patients.lastname, dental_patients.middlename FROM dental_letters JOIN dental_patients on dental_letters.patientid=dental_patients.patientid WHERE dental_patients.docid='".$docid."' AND dental_letters.status = '0' AND dental_letters.templateid LIKE '".$filter."' ORDER BY dental_letters.letterid ASC;";
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
  $letters_query = "SELECT dental_letters.letterid, dental_letters.templateid, dental_letters.patientid, UNIX_TIMESTAMP(dental_letters.generated_date) as generated_date, dental_letters.topatient, dental_letters.md_list, dental_letters.md_referral_list, dental_patients.firstname, dental_patients.lastname, dental_patients.middlename FROM dental_letters JOIN dental_patients on dental_letters.patientid=dental_patients.patientid WHERE dental_patients.docid='".$docid."' AND dental_letters.status = '1' AND dental_letters.templateid LIKE '".$filter."' ORDER BY dental_letters.letterid ASC;";
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
	// Get Correspondance Column
	$template_sql = "SELECT name, template FROM dental_letter_templates WHERE id = '".$letter['templateid']."';";
	$template_res = mysql_query($template_sql);
	$correspondance = array();
	$correspondance = mysql_fetch_assoc($template_res);
	$dental_letters[$key]['url'] = $correspondance['template'] . "?fid=" . $letter['patientid'] . "&pid=" . $letter['patientid'] . "&lid=" . $letter['letterid'];
	$dental_letters[$key]['subject'] = $correspondance['name'];
	// Get Recipients for Sent to Column
	$contacts = get_contact_info((($letter['topatient'] == "1") ? $letter['patientid'] : ''), $letter['md_list'], $letter['md_referral_list']);
	//print_r($contacts); print "<br />";
	$total_contacts = count($contacts['patient']) + count($contacts['mds']) + count($contacts['md_referrals']);
	if ($total_contacts > 1) {
		$dental_letters[$key]['sentto'] = $total_contacts . " Contacts";
	} elseif ($total_contacts == 0) {
		$dental_letters[$key]['sentto'] = "<span class=\"red\">No Contacts</span>";
	} else {
		// Patient: Salutation Lastname, Firstname
		$dental_letters[$key]['sentto'] = '';
		$dental_letters[$key]['sentto'] .= (isset($contacts['patient'][0])) ? ($contacts['patient'][0]['salutation'] . " " . $contacts['patient'][0]['lastname'] . ", " . $contacts['patient'][0]['firstname']) : ("");
		// MD: Salutation Lastname, Firstname - Contact Type
		$dental_letters[$key]['sentto'] .= (isset($contacts['mds'][0])) ? ($contacts['mds'][0]['salutation'] . " " . $contacts['mds'][0]['lastname'] . ", " . $contacts['mds'][0]['firstname'] . (($contacts['mds']['contacttype']) ? (" - " . $contacts['mds']['contacttype']) : (""))) : ("");
		// MD Referral: Salutation Lastname, Firstname - Contact Type
		$dental_letters[$key]['sentto'] .= (isset($contacts['md_referrals'][0])) ? ($contacts['md_referrals'][0]['salutation'] . " " . $contacts['md_referrals'][0]['lastname'] . ", " . $contacts['md_referrals'][0]['firstname'] . (($contacts['md_referrals']['contacttype']) ? (" - " . $contacts['md_referrals']['contacttype']) : (""))) : ("");
	}
  // Determine if letter is older than 7 days
  if (floor((time() - $letter['generated_date']) / $seconds_per_day) > 7) {
    $dental_letters[$key]['old'] = true;
  }
}

// Sort the letters array
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

//print_r($dental_letters);

?>

<div class="letters-tryptych1">
  <h1 class="blue"><?php echo ($status == 'pending') ? "Pending" : "Sent" ?> Letters (<?php echo count($dental_letters); ?>)</h1>
  <form name="filter_letters" action="/manage/letters.php?status=<?php echo $status ?>" method="get">
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
  <div style="float:right;">
  	<form method="post" action="/manage/new_letter.php">
  	<input class="addButton" type="submit" value="Create New">
  	</form>
  </div>
  <div style="float:right;margin-right: 10px;">
  	<form method="post" action="/manage/letters.php?status=sent">
  	<input class="addButton" type="submit" value="Sent Letters">
  	</form>
  </div>
</div>
<div class="letters-pager">Page(s): <?php paging($num_pages,$page,"status=$status&sort=$sort&sortdir=$sortdir"); ?></div>
<div style="clear:both;">
<table cellpadding="3px" id="letters-table" width="97%" style="margin: 0 auto;">
  <tr class="tr_bg_h">
    <td class="col_head <?= ($_REQUEST['sort'] == 'patient_name')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>"><a href="letters.php?status=<?=$status;?>&page=<?=$page;?>&filter=<?=$filter;?>&sort=patient_name&sortdir=<?php echo ($_REQUEST['sort']=='patient_name'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Patient Name</a></th>
    <td class="col_head <?= ($_REQUEST['sort'] == 'subject')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>"><a href="letters.php?status=<?=$status;?>&page=<?=$page;?>&filter=<?=$filter;?>&sort=subject&sortdir=<?php echo ($_REQUEST['sort']=='subject'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Correspondance</a></th>
    <td class="col_head <?= ($_REQUEST['sort'] == 'sentto')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>"><a href="letters.php?status=<?=$status;?>&page=<?=$page;?>&filter=<?=$filter;?>&sort=sentto&sortdir=<?php echo ($_REQUEST['sort']=='sentto'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Sent To</a></th>
    <td class="col_head <?= ($_REQUEST['sort'] == 'generated_date')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>"><a href="letters.php?status=<?=$status;?>&page=<?=$page;?>&filter=<?=$filter;?>&sort=generated_date&sortdir=<?php echo ($_REQUEST['sort']=='generated_date'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Generated On</a></th>
  </tr>
<?php
  $i = $page_limit * $page;
  $end = $i + $page_limit;
  while ($i < count($dental_letters) && $i < $end) {
    //print $dental_letters[$i]['templateid']; print "<br />";
    $name = $dental_letters[$i]['lastname'] . " " . $dental_letters[$i]['middlename'] . ", " . $dental_letters[$i]['firstname'];
    $url = $dental_letters[$i]['url'];
    $subject = $dental_letters[$i]['subject'];
    $sentto = $dental_letters[$i]['sentto'];
    $generated = date('m/d/Y', $dental_letters[$i]['generated_date']);
    if ($dental_letters[$i]['old']) {
      $alert = " bgcolor=\"#F44E4E\"";
    } else {
      $alert = null;
    }
    
    print "<tr$alert><td>$name</td><td><a href=\"$url\">$subject</a></td><td>$sentto</td><td>$generated</td></tr>";
    $i++;
  }
?>
</table>

</div>

<?php include 'includes/bottom.htm'; ?>
