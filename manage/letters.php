<?php
  include 'includes/top.htm';
  include 'admin/classes/Db.php';

  $db = new Db();

  if(!$use_letters){ 
?>
    <h3 style="width:100%; text-align:center;">Letters feature has been disabled.</h3>
<?php
    die();
  }
?>

<link rel="stylesheet" href="css/letters.css" />
<script src="js/letters.js" type="text/javascript"></script>

<?php

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

function send_method_asc($a, $b) {
  return strcmp ($a['send_method'], $b['send_method']);
}

function send_method_desc($a, $b) {
  return strcmp ($b['send_method'], $a['send_method']);
}

$status = 'pending';
$page = '0';
$page_limit = '10';
$column = 'letterid';
$filter = "%";

if (isset($_GET['status'])) {
 $status = $_GET['status'];
}

if (isset($_GET['page'])) {
  $page = $_GET['page'];
}

if (isset($_GET['filter'])) {
  $filter = mysql_real_escape_string($_GET['filter']);
}

if (!isset($_REQUEST['sort'])) {
  $_REQUEST['sort'] = 'generated_date';

  if ($status == 'sent') {
    $_REQUEST['sortdir'] = 'DESC';
  } else {
    $_REQUEST['sortdir'] = 'ASC';
  }
}

$sort = $_REQUEST['sort'];
$sortdir = $_REQUEST['sortdir'];

// Get doctor id
$docid = $_SESSION['docid'];

// Select Letters into Array
if ($status == 'pending') {
  $letters_query = "SELECT dental_letters.letterid, dental_letters.templateid, dental_letters.patientid, UNIX_TIMESTAMP(dental_letters.generated_date) as generated_date, dental_letters.topatient, dental_letters.md_list, dental_letters.md_referral_list, dental_letters.pat_referral_list, dental_letters.send_method, dental_patients.firstname, dental_patients.lastname, dental_patients.middlename, dental_letters.template_type FROM dental_letters 
    LEFT JOIN dental_patients on dental_letters.patientid=dental_patients.patientid 
    WHERE dental_letters.docid='" . $docid . "' AND dental_letters.delivered=0 AND dental_letters.status = '0' AND dental_letters.deleted = '0' AND dental_letters.templateid LIKE '".$filter."' ORDER BY dental_letters.letterid ASC;";
  $letters_res = $db->getResults($letters_query);
  if (!count($letters_res)) {
    print "MYSQL ERROR:" . mysql_errno() . ": " . mysql_error() . "<br/>" . "Error selecting letters from the database.";
  } else {
    foreach ($letters_res as $row) {
      $dental_letters[] = $row;
    }
  }
} elseif ($status == 'sent') {
  $letters_query = "SELECT dental_letters.letterid, 
    dental_letters.templateid, 
    dental_letters.patientid, 
    UNIX_TIMESTAMP(dental_letters.generated_date) as generated_date, 
    UNIX_TIMESTAMP(dental_letters.date_sent) as date_sent, 
    dental_letters.pdf_path, 
    dental_letters.topatient, 
    dental_letters.md_list, 
    dental_letters.md_referral_list, 
    dental_letters.send_method, 
    dental_patients.firstname, 
    dental_patients.lastname, 
    dental_patients.middlename, 
    dental_letters.mailed_date,
    dental_letters.template_type
    FROM dental_letters LEFT JOIN dental_patients on dental_letters.patientid=dental_patients.patientid 
    WHERE 
     dental_letters.docid='" . $docid . "' AND 
     (dental_letters.status = '1' OR dental_letters.delivered = '1') AND 
     dental_letters.deleted = '0' AND dental_letters.templateid LIKE '" . $filter . "'";

  if (isset($_GET['mailed']) && $_GET['mailed'] != '' ) {
    if ($_GET['mailed']==0) {
      $letters_query .= " AND mailed_date IS NULL "; 
    } elseif ($_GET['mailed']==1) {
      $letters_query .= " AND mailed_date IS NOT NULL ";
    }
  }
  
  $letters_query .= " ORDER BY dental_letters.letterid ASC;";
  $letters_res = $db->getResults($letters_query); 
  if (!count($letters_res)) {
    print "MYSQL ERROR:" . mysql_errno() . ": " . mysql_error() . "<br/>" . "Error selecting letters from the database.";
  } else {
    foreach ($letters_res as $row) {
      $dental_letters[] = $row;
    }
  }
}

// Calculate numer of pages
$num_pages = floor(count($dental_letters) / $page_limit);
if (count($dental_letters) % $page_limit) {
  $num_pages++;
}

if (!empty($dental_letters)){
  foreach ($dental_letters as $key => $letter) {
    // Get Correspondance Column
    $template_sql = "SELECT name, template FROM dental_letter_templates WHERE id = '" . $letter['templateid'] . "';";

    if ($letter['template_type'] == '0') {
      $template_sql = "SELECT name, template FROM dental_letter_templates WHERE id = '" . $letter['templateid'] . "';";
    } else {
      $template_sql = "SELECT name FROM dental_letter_templates_custom WHERE id = '" . $letter['templateid'] . "';";
    }

    $correspondance = $db->getRow($template_sql);
    $dental_letters[$key]['id'] = $letter['letterid'];

    if (!empty($letter['pdf_path'])) {
      $dental_letters[$key]['url'] = "/manage/letterpdfs/" . $letter['pdf_path'];
    } else {
      $dental_letters[$key]['url'] = "/manage/edit_letter.php?fid=" . $letter['patientid'] . "&pid=" . $letter['patientid'] . "&lid=" . $letter['letterid'];
    }

    $dental_letters[$key]['subject'] = $correspondance['name'];
    // Get Recipients for Sent to Column
    if(isset($letter['patientid'])){
      $s = "SELECT referred_source FROM dental_patients where patientid=" . mysql_real_escape_string($letter['patientid']) . " LIMIT 1";
      $r = $db->getRow($s);
      $source = $r['referred_source'];
    } else {
      $source = '';
    }

    $contacts = get_contact_info((($letter['topatient'] == "1") ? $letter['patientid'] : ''), $letter['md_list'], $letter['md_referral_list'], $letter['pat_referral_list']);

    $total_contacts = 0;
    $total_contacts += (isset($contacts['patient'])) ? count($contacts['patient']) : 0;
    $total_contacts += (isset($contacts['mds'])) ? count($contacts['mds']) : 0;
    $total_contacts += (isset($contacts['md_referrals'])) ? count($contacts['md_referrals']) : 0;
    $total_contacts += (isset($contacts['pat_referrals'])) ? count($contacts['pat_referrals']) : 0;

    $dental_letters[$key]['total_contacts'] = $total_contacts;

    if ($total_contacts > 1) {
      $dental_letters[$key]['sentto'] = $total_contacts . " Contacts";

      if (isset($contacts['patient'])) {
        $dental_letters[$key]['patient'] = $contacts['patient'];
      }
      
      if(isset($contacts['mds'])){
        $dental_letters[$key]['mds'] = $contacts['mds'];
      }
      
      if(isset($contacts['md_referrals'])){
        $dental_letters[$key]['md_referrals'] = $contacts['md_referrals'];
      }
      
      if(isset($contacts['pat_referrals'])){
        $dental_letters[$key]['pat_referrals'] = $contacts['pat_referrals'];
      }
    } elseif ($total_contacts == 0) {
      $dental_letters[$key]['sentto'] = "<span class=\"red\">No Contacts</span>";
    } else {
      // Patient: Salutation Lastname, Firstname
      $dental_letters[$key]['sentto'] = '';
      
      if (isset($contacts['patient'][0])) {
        $dental_letters[$key]['sentto'] .= ($contacts['patient'][0]['lastname'] . ", " . $contacts['patient'][0]['salutation'] . " " . $contacts['patient'][0]['firstname']);
        
        if($status == 'pending'){
          $dental_letters[$key]['sentto'] .= "<a href=\"#\" onclick=\"delete_pending_letter('" . $letter['letterid'] . "', 'patient', '" . $contacts['patient'][0]['id'] . "', 1); return false;\" class=\"delete_letter\" />Delete</a>";
        }
      }
      // MD: Salutation Lastname, Firstname - Contact Type
      if (isset($contacts['mds'][0])) {
        $dental_letters[$key]['sentto'] .= ($contacts['mds'][0]['lastname'] . ", " . $contacts['mds'][0]['salutation'] . " " . $contacts['mds'][0]['firstname'] . ((isset($contacts['mds']['contacttype'])) ? (" - " . $contacts['mds']['contacttype']) : (""))); 
        
        if($status == 'pending'){
          $dental_letters[$key]['sentto'] .= "<a href=\"#\" onclick=\"delete_pending_letter('" . $letter['letterid'] . "', 'md', '" . $contacts['mds'][0]['id'] . "', 1); return false;\" class=\"delete_letter\" />Delete</a>";
        }
      }
      // MD Referral: Salutation Lastname, Firstname - Contact Type
      if (isset($contacts['md_referrals'][0])) {
        $dental_letters[$key]['sentto'] .= ($contacts['md_referrals'][0]['lastname'] . ", " . $contacts['md_referrals'][0]['salutation'] . " " . $contacts['md_referrals'][0]['firstname'] . ((isset($contacts['md_referrals']['contacttype'])) ? (" - " . $contacts['md_referrals']['contacttype']) : (""))); 
        
        if($status == 'pending'){
          $dental_letters[$key]['sentto'] .= "<a href=\"#\" onclick=\"delete_pending_letter('".$letter['letterid']."', 'md_referral', '".$contacts['md_referrals'][0]['id']."', 1); return false;\" class=\"delete_letter\" />Delete</a>";
        }
      }

      if (isset($contacts['pat_referrals'][0])) {
        $dental_letters[$key]['sentto'] .= ($contacts['pat_referrals'][0]['lastname'] . ", " . $contacts['pat_referrals'][0]['salutation'] . " " . $contacts['pat_referrals'][0]['firstname'] );
        
        if($status == 'pending'){
          $dental_letters[$key]['sentto'] .= "<a href=\"#\" onclick=\"delete_pending_letter('".$letter['letterid']."', 'pat_referral', '".$contacts['pat_referrals'][0]['id']."', 1); return false;\" class=\"delete_letter\" />Delete</a>";
        }
      }
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
    // Determine if letter is older than 7 days
    if (floor((time() - $letter['generated_date']) / $seconds_per_day) > 7 && $status == "pending") {
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
  if ($_REQUEST['sort'] == "date_sent" && $_REQUEST['sortdir'] == "ASC") {
    usort($dental_letters, 'date_sent_asc'); 
  }
  if ($_REQUEST['sort'] == "date_sent" && $_REQUEST['sortdir'] == "DESC") {
    usort($dental_letters, 'date_sent_desc'); 
  }

  if ($_REQUEST['sort'] == "send_method" && $_REQUEST['sortdir'] == "ASC") {
    usort($dental_letters, 'send_method_asc'); 
  }
  if ($_REQUEST['sort'] == "send_method" && $_REQUEST['sortdir'] == "DESC") {
    usort($dental_letters, 'send_method_desc'); 
  }

}


//print_r($dental_letters);

$mailed = (isset($_GET['mailed']) && $_GET['mailed'] != '')?$_GET['mailed']:'';
?>

<div class="letters-tryptych1">
  <h1 class="blue"><?php 
	if($mailed=="0"){
		echo "Unmailed";
	}elseif($status == 'pending'){
		echo "Pending";
  }elseif($status == "sent"){
		echo "Sent";
	} ?> Letters (<?php echo count($dental_letters); ?>)</h1>
  <form name="filter_letters" action="/manage/letters.php" method="get">
		<input type="hidden" name="status" value="<?php echo $status;?>" />
      Filter by type: <select name="filter" onchange="document.filter_letters.submit();">
    <option value="%"></option>
    <?php
    $templates = "SELECT t.id, t.name, ct.triggerid FROM dental_letter_templates t 
                        INNER JOIN dental_letter_templates ct ON ct.triggerid = t.id
                        WHERE ct.companyid='".$_SESSION['companyid']."'
                        ORDER BY id ASC;";
    $result = $db->getResults($templates);
    foreach ($result as $row) {
      //DO NOT SHOW LETTER 1 (FROM DSS) FOR USER TYPE SOFTWARE
      if($_SESSION['user_type'] != DSS_USER_TYPE_SOFTWARE || $row['triggerid']!=1){
        print "<option " . (($filter == $row['id']) ? "selected " : "") . "value=\"" . $row['id'] . "\">" . $row['id'] . " - " . $row['name'] . "</option>";
      }
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
<?php if ($status != "sent" || $mailed == "0"): ?>
  <div style="float:right;margin-right: 10px;">
  	<form method="post" action="/manage/letters.php?status=sent">
  	<input class="addButton" type="submit" value="Sent Letters">
  	</form>
  </div>
<?php endif; ?>
<?php if ($status != "pending"): ?>
  <div style="float:right;margin-right: 10px;">
  	<form method="post" action="/manage/letters.php?status=pending">
  	<input class="addButton" type="submit" value="Pending Letters">
  	</form>
  </div>
<?php endif; ?>
<?php if ($mailed != "0" && $_SESSION['user_type']==DSS_USER_TYPE_SOFTWARE): ?>
  <div style="float:right;margin-right: 10px;">
        <form method="post" action="/manage/letters.php?status=sent&mailed=0">
        <input class="addButton" type="submit" value="Unmailed Letters">
        </form>
  </div>
<?php endif; ?>

</div>
<div class="letters-pager">Page(s): <?php paging($num_pages,$page,"status=$status&mailed=$mailed&filter=$filter&sort=$sort&sortdir=$sortdir"); ?></div>
<div style="clear:both;">
  <table cellpadding="3px" id="letters-table" width="97%" style="margin: 0 auto;">
    <tr class="tr_bg_h">
      <td class="col_head <?php echo ($_REQUEST['sort'] == 'patient_name')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>">
        <a href="letters.php?status=<?php echo $status;?>&page=<?php echo $page;?>&filter=<?php echo $filter;?>&sort=patient_name&sortdir=<?php echo ($_REQUEST['sort']=='patient_name'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Patient Name</a>
      </td>
      <td class="col_head <?php echo ($_REQUEST['sort'] == 'subject')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>">
        <a href="letters.php?status=<?php echo $status;?>&page=<?php echo $page;?>&filter=<?php echo $filter;?>&sort=subject&sortdir=<?php echo ($_REQUEST['sort']=='subject'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Correspondence</a>
      </td>
      <td class="col_head <?php echo ($_REQUEST['sort'] == 'sentto')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>">
        <a href="letters.php?status=<?php echo $status;?>&page=<?php echo $page;?>&filter=<?php echo $filter;?>&sort=sentto&sortdir=<?php echo ($_REQUEST['sort']=='sentto'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Sent To</a>
      </td>
      <td class="col_head <?php echo ($_REQUEST['sort'] == 'send_method')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>">
        <a href="letters.php?status=<?php echo $status;?>&page=<?php echo $page;?>&filter=<?php echo $filter;?>&sort=send_method&sortdir=<?php echo ($_REQUEST['sort']=='send_method'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Method</a>
      </td>
      <td class="col_head <?php echo ($_REQUEST['sort'] == 'generated_date')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>">
        <a href="letters.php?status=<?php echo $status;?>&page=<?php echo $page;?>&filter=<?php echo $filter;?>&sort=generated_date&sortdir=<?php echo ($_REQUEST['sort']=='generated_date'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Generated On</a>
      </td>
  <?php if ($status == "sent"): ?>
      <td class="col_head <?php echo ($_REQUEST['sort'] == 'date_sent')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>">
        <a href="letters.php?status=<?php echo $status;?>&page=<?php echo $page;?>&filter=<?php echo $filter;?>&sort=date_sent&sortdir=<?php echo ($_REQUEST['sort']=='date_sent'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Sent On</a>
      </td>
      <td class="col_head <?php echo ($_REQUEST['sort'] == 'mailed')?'arrow_'.strtolower($_REQUEST['mailed']):''; ?>">
        <a href="letters.php?status=<?php echo $status;?>&page=<?php echo $page;?>&filter=<?php echo $filter;?>&sort=mailed&sortdir=<?php echo ($_REQUEST['sort']=='mailed'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Mailed</a>
      </td>
  <?php endif; ?>
    </tr>
  <?php
    $i = $page_limit * $page;
    $end = $i + $page_limit;
    while ($i < count($dental_letters) && $i < $end) {
      //print $dental_letters[$i]['templateid']; print "<br />";
      $name = $dental_letters[$i]['lastname'] . " " . $dental_letters[$i]['middlename'] . ", " . $dental_letters[$i]['firstname'];
      $url = $dental_letters[$i]['url'];
      $subject = $dental_letters[$i]['subject'];
      if($subject==''){ 
        $subject='[View Letter]'; 
      }
      $sentto = $dental_letters[$i]['sentto'];
  		$method = $dental_letters[$i]['send_method'];
      $generated = date('m/d/Y', $dental_letters[$i]['generated_date']);
      $sent = (isset($dental_letters[$i]['date_sent']))?date('m/d/Y', $dental_letters[$i]['date_sent']):'';
      $id = $dental_letters[$i]['id'];
      $mailed = $dental_letters[$i]['mailed_date'];
      $total_contacts = $dental_letters[$i]['total_contacts'];
      if ($dental_letters[$i]['old']) {
        $alert = " bgcolor=\"#FF9696\"";
      } else {
        $alert = null;
      }
      ?> 
        <tr <?php echo $alert;?>>
          <td>
            <?php echo $name;?>
          </td>
          <td>
            <a <?php echo (end(explode('.', $url)) == "pdf" ? "target=\"_blank\" " : "" ); ?> href="<?php echo  $url; ?>"><?php echo  $subject; ?></a>
          </td>
          <td>
            <?php if($total_contacts>1){ ?>
              <a href="#" onclick="$('#contacts_<?php echo  $id; ?>').toggle(); return false;"><?php echo  $sentto; ?></a>
              <div style="display:none;" id="contacts_<?php echo  $id; ?>">
              <?php if(isset($dental_letters[$i]['patient'])){
                foreach($dental_letters[$i]['patient'] as $pat){
                  echo "<br />" . $pat['salutation']." ".$pat['firstname']." ".$pat['lastname'];
                  if($status == 'pending'){ ?>
                  <a href="#" onclick="delete_pending_letter('<?php echo  $id; ?>', 'patient', '<?php echo  $pat['id']; ?>', 0)" class="delete_letter" />Delete</a><?php
                  }
                }
  				    }
  				    if(isset($dental_letters[$i]['mds'])){
                foreach($dental_letters[$i]['mds'] as $md){
                 echo "<br />" . $md['salutation']." ".$md['firstname']." ".$md['lastname'];
  					     if($status == 'pending'){ ?>
                 <a href="#" onclick="delete_pending_letter('<?php echo  $id; ?>', 'md', '<?php echo  $md['id']; ?>', 0)" class="delete_letter" />Delete</a><?php
  					     }
                }
  				    }
  			      if(isset($dental_letters[$i]['md_referrals'])){
                foreach($dental_letters[$i]['md_referrals'] as $md_referral){
                  echo "<br />" . $md_referral['salutation']." ".$md_referral['firstname']." ".$md_referral['lastname'];
                  if($status == 'pending'){ ?>
                    <a href="#" onclick="delete_pending_letter('<?php echo  $id; ?>', 'md_referral', '<?php echo  $md_referral['id']; ?>', 0)" class="delete_letter" />Delete</a><?php
                  }
                }
  				    } ?>
              </div>
              <?php
            }else{
              echo $sentto;
            } ?>
          </td>
          <td>
            <?php echo  $method; ?>
          </td>
          <td>
            <?php echo  $generated; ?>
          </td>
          <?php if($status == "sent"){ ?>
          <td>
            <?php echo  $sent; ?>
          </td>
          <?php if($_SESSION['user_type'] == DSS_USER_TYPE_SOFTWARE) { ?>
          <td>
            <input type="checkbox" class="mailed_chk" value="<?php echo  $id; ?>" <?php echo  ($mailed !='')?'checked="checked"':''; ?> />
          </td>
  		    <?php } ?>
          <?php if($_SESSION['user_type'] == DSS_USER_TYPE_FRANCHISEE) { ?>
          <td><?php echo  ($mailed !='')?'X':''; ?></td>
          <?php }
        } ?>
        </tr>
      <?php
      $i++;
    }?>
  </table>
</div>

<?php include 'includes/bottom.htm'; ?>
