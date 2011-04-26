<?php include 'includes/top.htm'; 

$status = $_GET['status'];
$page = '0';
$page_limit = '10';
$sort = 'asc';
$column = 'letterid';
if (isset($_GET['page'])) { $page = $_GET['page']; }
if (isset($_GET['sort'])) { $sort = mysql_real_escape_string($_GET['sort']); }
if (isset($_GET['column'])) { $column = mysql_real_escape_string($_GET['column']); }

// Get doctor id
$docid = $_SESSION['docid'];

// Select Letters into Array
if ($status == 'pending') {
  $letters_query = "SELECT dental_letters.letterid, dental_letters.templateid, dental_letters.patientid, UNIX_TIMESTAMP(dental_letters.generated_date) as generated_date, dental_letters.topatient, dental_letters.md_list, dental_letters.md_referral_list, dental_patients.firstname, dental_patients.lastname, dental_patients.middlename FROM dental_letters JOIN dental_patients on dental_letters.patientid=dental_patients.patientid WHERE dental_patients.docid='".$docid."' ORDER BY ".$column." ".$sort.";";
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

//print_r($dental_letters);

?>

<div class="letters-tryptych1">
  <h1 class="blue">Pending Letters (<?php echo $pending_letters; ?>)</h1>
  Filter by type:
</div>
<div class="letters-tryptych2">
  <h2>You have <span class="blue"><?php echo $pending_letters; ?></span> letters to review.</h1>
  <h2>The oldest letter is <span class="red"><?php echo $oldest_letter; ?> day(s) old.</h1>
</div>
<div class="letters-tryptych3">
  [Sent Letters] [Create New]
</div>
<div class="letters-pager">Page(s): <?php paging($num_pages,$page,"status=$status"); ?></div>
<div style="clear:both;">
<table cellpadding="3px" id="letters-table" width="97%" style="margin: 0 auto;">
  <tr class="tr_bg_h">
    <td class="col_head">Patient Name</th>
    <td class="col_head">Correspondance</th>
    <td class="col_head">Sent To</th>
    <td class="col_head">Generated On</th>
  </tr>
<?php
  $i = $page_limit * $page;
  $end = $i + $page_limit;
  while ($i < count($dental_letters) && $i < $end) {
    $name = $dental_letters[$i]['lastname'] . " " . $dental_letters[$i]['middlename'] . ", " . $dental_letters[$i]['firstname'];
    $generated = date('m/d/Y', $dental_letters[$i]['generated_date']);
    // Get Correspondance Column
    $template_sql = "SELECT name, template FROM dental_letter_templates WHERE id = '".$dental_letters[$i]['templateid']."';";
    $template_res = mysql_query($template_sql);
    $correspondance = array();
    $correspondance = mysql_fetch_assoc($template_res);
    $subject = $correspondance['name'];
    $url = $correspondance['template'] . "?fid=" . $dental_letters[$i]['patientid'] . "&pid=" . $dental_letters[$i]['patientid'];
    // Get Recipients for Sent to Column
    $contacts = get_contact_info((isset($dental_letters[$i]['topatient']) ? $dental_letters[$i]['patientid'] : ''), $dental_letters[$i]['md_list'], $dental_letters[$i]['md_referral_list']);
    $total_contacts = count($contacts['patient']) + count($contacts['mds']) + count($contacts['md_referrals']);
    if ($total_contacts > 1) {
      $sentto = $total_contacts . " Contacts";
    } else {
      // Patient: Salutation Lastname, Firstname
      $sentto .= (isset($contacts['patient'][0])) ? ($contacts['patient'][0]['salutation'] . " " . $contacts['patient'][0]['lastname'] . ", " . $contacts['patient'][0]['firstname']) : ("");
      // MD: Salutation Lastname, Firstname - Contact Type
      $sentto .= (isset($contacts['mds'][0])) ? ($contacts['mds'][0]['salutation'] . " " . $contacts['mds'][0]['lastname'] . ", " . $contacts['mds'][0]['firstname'] (($contacts['mds']['contacttype']) ? (" - " . $contacts['mds']['contacttype']) : (""))) : ("");
      // MD Referral: Salutation Lastname, Firstname - Contact Type
      $sentto .= (isset($contacts['md_referrals'][0])) ? ($contacts['md_referrals'][0]['salutation'] . " " . $contacts['md_referrals'][0]['lastname'] . ", " . $contacts['md_referrals'][0]['firstname'] (($contacts['md_referrals']['contacttype']) ? (" - " . $contacts['md_referrals']['contacttype']) : (""))) : ("");
    }
    
    print "<tr><td>$name</td><td><a href=\"$url\">$subject</a></td><td>$sentto</td><td>$generated</td></tr>";
    $i++;
  }
?>
</table>

</div>

<?php include 'includes/bottom.htm'; ?>
