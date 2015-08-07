<?php namespace Ds3\Libraries\Legacy; ?><?php
require_once('includes/general.htm');
?>
<link rel="stylesheet" href="../css/letters.css" />
<?php

function userid_asc($a, $b) {
    return strcmp ($a['userid'], $b['userid']);
}

function userid_desc($a, $b) {
    return strcmp ($b['userid'], $a['userid']);
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

function method_asc($a, $b) {
    return strcmp ($a['send_method'], $b['send_method']);
}

function method_desc($a, $b) {
    return strcmp ($b['send_method'], $a['send_method']);
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

$page = '0';
$page_limit = '10';
$column = 'letterid';
$filter = "%";

if (isset($_GET['filter'])) { $filter = mysqli_real_escape_string($con,$_GET['filter']); }
if(!isset($_REQUEST['sort'])){
    $_REQUEST['sort'] = 'generated_date';
    if (!empty($status) && $status == 'sent') {
        $_REQUEST['sortdir'] = 'DESC';
    } else {
        $_REQUEST['sortdir'] = 'ASC';
    }
}

if(!isset($_REQUEST['sort2'])){
    $_REQUEST['sort2'] = 'generated_date';
    $_REQUEST['sort2dir'] = 'DESC';
}
$sort = $_REQUEST['sort'];
$sortdir = $_REQUEST['sortdir'];
$patientid = (!empty($_REQUEST['pid']) ? $_REQUEST['pid'] : '');
$page1 = (!empty($_REQUEST['page1']) ? $_REQUEST['page1'] : '');
$page2 = (!empty($_REQUEST['page2']) ? $_REQUEST['page2'] : '');

$letters_query = "SELECT dental_letters.letterid, dental_letters.templateid, dental_letters.patientid,
    UNIX_TIMESTAMP(dental_letters.generated_date) AS generated_date,
    UNIX_TIMESTAMP(dental_letters.delivery_date) AS delivery_date,
    dental_letters.send_method, dental_letters.pdf_path, dental_letters.status, dental_letters.topatient,
    dental_letters.md_list, dental_letters.md_referral_list, dental_letters.pat_referral_list,
    dental_letters.mailed_date, dental_letters.mailed_once, dental_patients.firstname, dental_patients.lastname,
    dental_patients.middlename, dental_users.name AS userid, dental_letters.template_type,
    (
        SELECT f.sfax_status FROM dental_faxes f
        WHERE f.letterid = dental_letters.letterid
        ORDER BY f.sent_date DESC LIMIT 1
    ) AS sfax_status,
    (
        SELECT f2.viewed FROM dental_faxes f2
        WHERE f2.letterid = dental_letters.letterid
        ORDER BY f2.sent_date DESC LIMIT 1
    ) AS fax_viewed
    FROM dental_letters
    JOIN dental_patients ON dental_letters.patientid=dental_patients.patientid
    LEFT JOIN dental_users ON dental_letters.userid=dental_users.userid 
    WHERE dental_letters.patientid = '" . $patientid . "'
    AND dental_letters.deleted = '0'
    AND (
        dental_letters.parentid IS NULL
        OR dental_letters.parentid=0
    )
    AND dental_letters.templateid LIKE '" . $filter . "'
    GROUP BY dental_letters.letterid, dental_letters.parentid
    ORDER BY dental_letters.letterid ASC;";
$letters_res = mysqli_query($con,$letters_query);

if (!$letters_res) {
    error_log("MYSQL ERROR:".mysqli_errno($con).": ".mysqli_error($con));
    print "Error selecting letters from the database.";
}
else {
    while ($row = mysqli_fetch_assoc($letters_res)) {
        $dental_letters[] = $row;
    }
}

if (!empty($dental_letters)) foreach ($dental_letters as $key => $letter) {
    // Get Correspondence Column
    if ($letter['template_type']=='0') {
        $template_sql = "SELECT name, template FROM dental_letter_templates WHERE id = '".$letter['templateid']."';";
    }
    else {
        $template_sql = "SELECT name FROM dental_letter_templates_custom WHERE id = '".$letter['templateid']."';";
    }
    
    $template_res = mysqli_query($con,$template_sql);
    $correspondence = array();
    $correspondence = mysqli_fetch_assoc($template_res);
    $dental_letters[$key]['id'] = $letter['letterid'];
    $dental_letters[$key]['mailed'] = $letter['mailed_date'];
    $dental_letters[$key]['mailed_once'] = $letter['mailed_once'];
    
    if (!empty($letter['pdf_path'])&&$letter['status']!=0) {
        $dental_letters[$key]['url'] = "/manage/letterpdfs/" . $letter['pdf_path'];
    }
    else {
        $dental_letters[$key]['url'] = "/manage/edit_letter.php?fid=" . $letter['patientid'] . "&pid=" . $letter['patientid'] . "&lid=" . $letter['letterid']."&goto=letter";
    }
    
    $dental_letters[$key]['subject'] = $correspondence['name'];
    
    if ($letter['templateid'] == 99) {
        $dental_letters[$key]['subject'] = "User Generated";
    }
    
    // Get Recipients for Sent to Column
    $s = "SELECT referred_source FROM dental_patients where patientid=".mysqli_real_escape_string($con,$letter['patientid'])." LIMIT 1";
    $q = mysqli_query($con,$s);
    $r = mysqli_fetch_assoc($q);
    $source = $r['referred_source'];
    
    $contacts = get_contact_info((($letter['topatient'] == "1") ? $letter['patientid'] : ''), $letter['md_list'], $letter['md_referral_list'], $letter['pat_referral_list']);
    
    // ADD IN CHILD LETTERS TO CONTACTS
    $master_sql = "SELECT letterid, topatient, patientid, md_list, md_referral_list, pat_referral_list
        FROM dental_letters l
        WHERE status=0 AND deleted=0 AND parentid='".$letter['letterid']."'";
    
    $master_q = mysqli_query($con,$master_sql);
    
    while ($master_r = mysqli_fetch_assoc($master_q)) {
        $master_contacts = get_contact_info((($master_r['topatient'] == "1") ? $master_r['patientid'] : ''), $master_r['md_list'],$master_r['md_referral_list'], $master_r['pat_referral_list'], $master_r['letterid']);
        
        if (!empty($contacts['patient']) && count($contacts['patient']) && count($master_contacts['patient'])) {
            //$contacts['patient'] = array_merge($contacts['patient'], $master_contacts['patient']);
        }
        else if (!empty($master_contacts['patient']) && count($master_contacts['patient'])) {
            $contacts['patient'] = $master_contacts['patient'];
        }
        
        if (!empty($contacts['mds']) && count($contacts['mds']) && !empty($master_contacts['mds']) && count($master_contacts['mds'])) {
            $contacts['mds'] = array_merge($contacts['mds'], $master_contacts['mds']);
        }
        else if (!empty($master_contacts['mds']) && count($master_contacts['mds'])){
            $contacts['mds'] = $master_contacts['mds'];
        }
        
        if (!empty($contacts['md_referrals']) && count($contacts['md_referrals']) && count($master_contacts['md_referrals'])) {
            $contacts['md_referrals'] = array_merge($contacts['md_referrals'], $master_contacts['md_referrals']);
        }
        else if (!empty($master_contacts['md_referrals']) && count($master_contacts['md_referrals'])) {
            $contacts['md_referrals'] = $master_contacts['md_referrals'];
        }
        
        if (!empty($contacts['pat_referrals']) && count($contacts['pat_referrals']) && count($master_contacts['pat_referrals'])) {
            $contacts['pat_referrals'] = array_merge($contacts['pat_referrals'], $master_contacts['pat_referrals']);
        }
        else if (!empty($master_contacts['pat_referrals']) && count($master_contacts['pat_referrals'])) {
            $contacts['pat_referrals'] = $master_contacts['pat_referrals'];
        }
    }
    
    //print_r($contacts); print "<br />";
    $total_contacts = count(!empty($contacts['patient']) ? $contacts['patient'] : array()) + count(!empty($contacts['mds']) ? $contacts['mds'] : array()) + count(!empty($contacts['md_referrals']) ? $contacts['md_referrals'] : array()) + count(!empty($contacts['pat_referrals']) ? $contacts['pat_referrals'] : array());
    $dental_letters[$key]['total_contacts'] = $total_contacts;
    
    if ($total_contacts > 1) {
        $dental_letters[$key]['sentto'] = $total_contacts . " Contacts";
        $dental_letters[$key]['patient'] = (!empty($contacts['patient']) ? $contacts['patient'] : '');
        $dental_letters[$key]['mds'] = $contacts['mds'];
        $dental_letters[$key]['md_referrals'] = (!empty($contacts['md_referrals']) ? $contacts['md_referrals'] : '');
        $dental_letters[$key]['pat_referrals'] = (!empty($contacts['pat_referrals']) ? $contacts['pat_referrals'] : '');
    }
    else if ($total_contacts == 0) {
        $dental_letters[$key]['sentto'] = "<span class=\"red\">No Contacts</span>";
    }
    else {
        // Patient: Salutation Lastname, Firstname
        $dental_letters[$key]['sentto'] = '';
        $dental_letters[$key]['sentto'] .= (isset($contacts['patient'][0])) ? ($contacts['patient'][0]['salutation'] . " " . $contacts['patient'][0]['lastname'] . ", " . $contacts['patient'][0]['firstname']. (($dental_letters[$key]['mailed_once']==0)?"<a class=\"delete_letter btn btn-default btn-sm pull-right\" href=\"#\" onclick=\"delete_pending_letter('".$letter['letterid']."', 'patient', '".$contacts['patient'][0]['id']."', 1)\" />Delete</a>":"")) : ("");
        // MD: Salutation Lastname, Firstname - Contact Type
        $dental_letters[$key]['sentto'] .= (isset($contacts['mds'][0])) ? ($contacts['mds'][0]['lastname'] . ", " . $contacts['mds'][0]['salutation'] . " " . $contacts['mds'][0]['firstname'] . ((!empty($contacts['mds']['contacttype'])) ? (" - " . $contacts['mds']['contacttype']) : ("")). (($dental_letters[$key]['mailed_once']==0)?"<a class=\"delete_letter btn btn-default btn-sm pull-right\" href=\"#\" onclick=\"delete_pending_letter('".$letter['letterid']."', 'md', '".$contacts['mds'][0]['id']."', 1)\" />Delete</a>":"")) : ("");
        // MD Referral: Salutation Lastname, Firstname - Contact Type
        $dental_letters[$key]['sentto'] .= (isset($contacts['md_referrals'][0])) ? ($contacts['md_referrals'][0]['lastname'] . ", " . $contacts['md_referrals'][0]['salutation'] . " " . $contacts['md_referrals'][0]['firstname'] . (($contacts['md_referrals']['contacttype']) ? (" - " . $contacts['md_referrals']['contacttype']) : ("")). (($dental_letters[$key]['mailed_once']==0)?"<a class=\"delete_letter btn btn-default btn-sm pull-right\" href=\"#\" onclick=\"delete_pending_letter('".$letter['letterid']."', 'md_referral', '".$contacts['md_referrals'][0]['id']."', 1)\" />Delete</a>":"")) : ("");
        
        // Pat Referral: Salutation Lastname, Firstname - Contact Type
        $dental_letters[$key]['sentto'] .= (isset($contacts['pat_referrals'][0])) ? ($contacts['pat_referrals'][0]['lastname'] . ", " . $contacts['pat_referrals'][0]['salutation'] . " " . $contacts['pat_referrals'][0]['firstname'] .    (($dental_letters[$key]['mailed_once']==0)?"<a class=\"delete_letter btn btn-default btn-sm pull-right\" href=\"#\" onclick=\"delete_pending_letter('".$letter['letterid']."', 'pat_referral', '".$contacts['pat_referrals'][0]['id']."', 1)\" />Delete</a>":"")) : ("");
    }
    
    // Determine if letter is older than 7 days
    if (!empty($seconds_per_day) && floor((time() - $letter['generated_date']) / $seconds_per_day) > 7 && $status == "pending") {
        $dental_letters[$key]['old'] = true;
    }
}

// Collect Letters in array
$pending_letters = array();
$sent_letters = array();

if (!empty($dental_letters)) foreach ($dental_letters as $letter) {
    if ($letter['status'] == "0") {
        $pending_letters[] = $letter;
    }
    else {
        $sent_letters[] = $letter;
    }
}

// Calculate numer of pages
$num_pages1 = floor(count($pending_letters) / $page_limit);
if (count($pending_letters) % $page_limit) {
    $num_pages1++;
}

// Calculate numer of pages
$num_pages2 = floor(count($sent_letters) / $page_limit);
if (count($sent_letters) % $page_limit) {
    $num_pages2++;
}

// Sort the letters array
if ($_REQUEST['sort'] == "userid" && $_REQUEST['sortdir'] == "ASC") {
    usort($pending_letters, 'ds3\Libraries\Legacy\userid_asc'); 
}
if ($_REQUEST['sort'] == "userid" && $_REQUEST['sortdir'] == "DESC") {
    usort($pending_letters, 'ds3\Libraries\Legacy\userid_desc'); 
}
if ($_REQUEST['sort'] == "subject" && $_REQUEST['sortdir'] == "ASC") {
    usort($pending_letters, 'ds3\Libraries\Legacy\subject_asc'); 
}
if ($_REQUEST['sort'] == "subject" && $_REQUEST['sortdir'] == "DESC") {
    usort($pending_letters, 'ds3\Libraries\Legacy\subject_desc'); 
}
if ($_REQUEST['sort'] == "method" && $_REQUEST['sortdir'] == "ASC") {
    usort($pending_letters, 'ds3\Libraries\Legacy\method_asc'); 
}
if ($_REQUEST['sort'] == "method" && $_REQUEST['sortdir'] == "DESC") {
    usort($pending_letters, 'ds3\Libraries\Legacy\method_desc'); 
}
if ($_REQUEST['sort'] == "sentto" && $_REQUEST['sortdir'] == "ASC") {
    usort($pending_letters, 'ds3\Libraries\Legacy\sentto_asc'); 
}
if ($_REQUEST['sort'] == "sentto" && $_REQUEST['sortdir'] == "DESC") {
    usort($pending_letters, 'ds3\Libraries\Legacy\sentto_desc'); 
}
if ($_REQUEST['sort'] == "generated_date" && $_REQUEST['sortdir'] == "ASC") {
    usort($pending_letters, 'ds3\Libraries\Legacy\generated_date_asc'); 
}
if ($_REQUEST['sort'] == "generated_date" && $_REQUEST['sortdir'] == "DESC") {
    usort($pending_letters, 'ds3\Libraries\Legacy\generated_date_desc'); 
}
if ($_REQUEST['sort'] == "delivery_date" && $_REQUEST['sortdir'] == "ASC") {
    usort($pending_letters, 'ds3\Libraries\Legacy\delivery_date_asc'); 
}
if ($_REQUEST['sort'] == "delivery_date" && $_REQUEST['sortdir'] == "DESC") {
    usort($pending_letters, 'ds3\Libraries\Legacy\delivery_date_desc'); 
}

// Sort the letters array
if ($_REQUEST['sort2'] == "userid" && $_REQUEST['sort2dir'] == "ASC") {
    usort($sent_letters, 'ds3\Libraries\Legacy\userid_asc');
}
if ($_REQUEST['sort2'] == "userid" && $_REQUEST['sort2dir'] == "DESC") {
    usort($sent_letters, 'ds3\Libraries\Legacy\userid_desc');
}
if ($_REQUEST['sort2'] == "subject" && $_REQUEST['sort2dir'] == "ASC") {
    usort($sent_letters, 'ds3\Libraries\Legacy\subject_asc');
}
if ($_REQUEST['sort2'] == "subject" && $_REQUEST['sort2dir'] == "DESC") {
    usort($sent_letters, 'ds3\Libraries\Legacy\subject_desc');
}
if ($_REQUEST['sort2'] == "method" && $_REQUEST['sort2dir'] == "ASC") {
    usort($sent_letters, 'ds3\Libraries\Legacy\method_asc');
}
if ($_REQUEST['sort2'] == "method" && $_REQUEST['sort2dir'] == "DESC") {
    usort($sent_letters, 'ds3\Libraries\Legacy\method_desc');
}
if ($_REQUEST['sort2'] == "sentto" && $_REQUEST['sort2dir'] == "ASC") {
    usort($sent_letters, 'ds3\Libraries\Legacy\sentto_asc');
}
if ($_REQUEST['sort2'] == "sentto" && $_REQUEST['sort2dir'] == "DESC") {
    usort($sent_letters, 'ds3\Libraries\Legacy\sentto_desc');
}
if ($_REQUEST['sort2'] == "generated_date" && $_REQUEST['sort2dir'] == "ASC") {
    usort($sent_letters, 'ds3\Libraries\Legacy\generated_date_asc');
}
if ($_REQUEST['sort2'] == "generated_date" && $_REQUEST['sort2dir'] == "DESC") {
    usort($sent_letters, 'ds3\Libraries\Legacy\generated_date_desc');
}
if ($_REQUEST['sort2'] == "delivery_date" && $_REQUEST['sort2dir'] == "ASC") {
    usort($sent_letters, 'ds3\Libraries\Legacy\delivery_date_asc');
}
if ($_REQUEST['sort2'] == "delivery_date" && $_REQUEST['sort2dir'] == "DESC") {
    usort($sent_letters, 'ds3\Libraries\Legacy\delivery_date_desc');
}

$f_sql = "SELECT * FROM dental_faxes
    WHERE sfax_completed=1
    AND sfax_status=2
    AND patientid='".mysqli_real_escape_string($con,(!empty($_GET['pid']) ? $_GET['pid'] : ''))."'
    AND viewed=0;";

$f_q = mysqli_query($con,$f_sql);
$f_num = mysqli_num_rows($f_q);

if ($f_num > 0) { ?>
    <br /><br />
    <a href="manage_vobs.php?status=3&viewed=0#fax" class="warning" id="fax_alert"><?= $f_num; ?> letter<?=($f_num>1)?'s':'';?> failed to send via digital fax. Click here to check errors and retry.</a>
<?php } ?>

<div class="page-header">
    <h1>Patient Letters</h1>
</div>

<form name="filter_letters" action="dss_summ.php" method="get" class="form-inline pull-right">
    <input type="hidden" name="pid" value="<?=$patientid;?>">
    <input type="hidden" name="sect" value="letters">
    <input type="hidden" name="addtopat" value="1">
    Show letter type:
    <select name="filter" class="form-control" onchange="document.filter_letters.submit();">
        <option value="%"></option>
        <?php
        $templates = "SELECT t.id, t.name, ct.triggerid FROM dental_letter_templates t 
            INNER JOIN dental_letter_templates ct ON ct.triggerid = t.id
            WHERE ct.companyid='".$_SESSION['companyid']."'
            ORDER BY id ASC;";
        $result = mysqli_query($con,$templates);
        while ($row = mysqli_fetch_assoc($result)) {
            //DO NOT SHOW LETTER 1 (FROM DSS) FOR USER TYPE SOFTWARE
            if($_SESSION['user_type'] != DSS_USER_TYPE_SOFTWARE || $row['triggerid']!=1){
                print "<option " . (($filter == $row['id']) ? "selected " : "") . "value=\"" . $row['id'] . "\">" . $row['id'] . " - " . $row['name'] . "</option>";
            }
        }
        ?>
    </select>
</form>

<h2>
    Pending Letters
    <small>Page(s): <?php paging1($num_pages1,$page1,"pid=$patientid&filter=$filter&sort=$sort&sortdir=$sortdir&sect=letters#sect_letters",$page2); ?></small>
</h2>

<table id="letters-table" class="table table-bordered table-hover">
    <tr class="tr_bg_h">
        <!--<th class="col_head <?= ($_REQUEST['sort'] == 'userid')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>">
            <a href="?pid=<?=$patientid;?>&page=<?=$page;?>&filter=<?=$filter;?>&sort=userid&sortdir=<?php echo ($_REQUEST['sort']=='userid'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>#sect_letters">User ID</a>
        </th>-->
        <th class="col_head <?= ($_REQUEST['sort'] == 'subject')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>">
            <a href="?pid=<?=$patientid;?>&page=<?=$page;?>&filter=<?=$filter;?>&sort=subject&sortdir=<?php echo ($_REQUEST['sort']=='subject'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>#sect_letters">Correspondence</a>
        </th>
        <th class="col_head <?= ($_REQUEST['sort'] == 'sentto')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>">
            <a href="?pid=<?=$patientid;?>&page=<?=$page;?>&filter=<?=$filter;?>&sort=sentto&sortdir=<?php echo ($_REQUEST['sort']=='sentto'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>#sect_letters">Sent To</a>
        </th>
        <th class="col_head <?= ($_REQUEST['sort'] == 'generated_date')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>">
            <a href="?pid=<?=$patientid;?>&page=<?=$page;?>&filter=<?=$filter;?>&sort=generated_date&sortdir=<?php echo ($_REQUEST['sort']=='generated_date'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>#sect_letters">Generated On</a>
        </th>
    </tr>
    <?php
    
    $i = $page_limit * $page1;
    $end = $i + $page_limit;
    
    while ($i < count($pending_letters) && $i < $end) {
        //print $pending_letters[$i]['templateid']; print "<br />";
        //$name = $pending_letters[$i]['lastname'] . " " . $pending_letters[$i]['middlename'] . ", " . $pending_letters[$i]['firstname'];
        $userid = $pending_letters[$i]['userid'];
        $url = $pending_letters[$i]['url'];
        $id = $pending_letters[$i]['id'];
        $subject = $pending_letters[$i]['subject'];
        $sentto = $pending_letters[$i]['sentto'];
        $total_contacts = $pending_letters[$i]['total_contacts'];
        $generated = date('m/d/Y', $pending_letters[$i]['generated_date']);
        
        if ($pending_letters[$i]['sfax_status']=='2' AND $pending_letters[$i]['fax_viewed']=='0') {
            $alert = " bgcolor=\"#FFFF33\"";
        }
        else if (!empty($pending_letters[$i]['old'])) {
            $alert = " bgcolor=\"#FF9696\"";
        }
        else {
            $alert = null;
        }
        
        ?>
        <tr <?= $alert; ?>>
            <td>
                <a href="<?= $url; ?>"><?= $subject; ?></a>
            </td>
            <td>
                <?php
                
                if ($total_contacts > 1) { ?>
                    <a href="#" class="btn btn-default btn-sm contacts-toggler">
                        <?= $sentto; ?>
                        <span class="glyphicon glyphicon-chevron-down"></span>
                    </a>
                    <div style="display:none;" id="contacts_<?= $id; ?>">
                        <?php foreach($pending_letters[$i]['patient'] as $pat) { ?>
                            <p>
                                <?= $pat['salutation']." ".$pat['firstname']." ".$pat['lastname']; ?>
                                <a href="#" class="delete_letter btn btn-default btn-sm pull-right" onclick="delete_pending_letter('<?= $id; ?>', 'patient', '<?= $pat['id']; ?>', 0)" />Delete</a>
                            </p>
                        <?php }
                        
                        foreach ($pending_letters[$i]['mds'] as $md) { ?>
                            <p>
                                <?= $md['salutation']." ".$md['firstname']." ".$md['lastname']; ?>
                                <a href="#" class="delete_letter btn btn-default btn-sm pull-right" onclick="delete_pending_letter('<?= $id; ?>', 'md', '<?= $md['id']; ?>', 0)" />Delete</a>
                            </p>
                        <?php }
                        
                        foreach ($pending_letters[$i]['md_referrals'] as $md_referral) { ?>
                            <p>
                                <?= $md_referral['salutation']." ".$md_referral['firstname']." ".$md_referral['lastname']; ?>
                                <a href="#" class="delete_letter btn btn-default btn-sm pull-right" onclick="delete_pending_letter('<?= $id; ?>', 'md_referral', '<?= $md_referral['id']; ?>', 0)" />Delete</a>
                            </p>
                        <?php }
                        
                        foreach ($pending_letters[$i]['pat_referrals'] as $md_referral) { ?>
                            <p>
                                <?= $pat_referral['salutation']." ".$pat_referral['firstname']." ".$pat_referral['lastname']; ?>
                                <a href="#" class="delete_letter btn btn-default btn-sm pull-right" onclick="delete_pending_letter('<?= $id; ?>', 'pat_referral', '<?= $pat_referral['id']; ?>', 0)" />Delete</a>
                            </p>
                        <?php } ?>
                    </div>
                <?php }
                else {
                    echo $sentto;
                } ?>
            </td>
            <td><?= $generated; ?></td>
        </tr>
        <?php
        
        $i++;
    } ?>
</table>
<script type="text/javascript">
function delete_pending_letter (lid, type, rid, par) {
    $.ajax({
        url: "includes/letter_delete.php",
        type: "post",
        data: {
            lid: lid,
            type: type,
            rid: rid,
            par: par
        },
        success: function(data){
            var r = $.parseJSON(data);
            
            if (r.error) {}
            else {
                window.location.reload();
            }
        },
        failure: function(data){}
    });
}
</script>

<h2>
    Sent Letters
    <small>Page(s): <?php paging2($num_pages2,$page2,"pid=$patientid&filter=$filter&sort=$sort&sortdir=$sortdir&sect=letters#sect_letters",$page1); ?></small>
</h2>

<table class="table table-bordered table-hover">
    <tr class="tr_bg_h">
        <th class="col_head <?= ($_REQUEST['sort2'] == 'userid')?'arrow_'.strtolower($_REQUEST['sort2dir']):''; ?>"><a href="?pid=<?=$patientid;?>&page=<?=$page;?>&filter=<?=$filter;?>&sort=userid&sort2dir=<?php echo ($_REQUEST['sort2']=='userid'&&$_REQUEST['sort2dir']=='ASC')?'DESC':'ASC'; ?>#sect_letters">User ID</a></th>
        <th class="col_head <?= ($_REQUEST['sort2'] == 'subject')?'arrow_'.strtolower($_REQUEST['sort2dir']):''; ?>"><a href="?pid=<?=$patientid;?>&page=<?=$page;?>&filter=<?=$filter;?>&sort2=subject&sort2dir=<?php echo ($_REQUEST['sort2']=='subject'&&$_REQUEST['sort2dir']=='ASC')?'DESC':'ASC'; ?>#sect_letters">Correspondence</a></th>
        <th class="col_head <?= ($_REQUEST['sort2'] == 'sentto')?'arrow_'.strtolower($_REQUEST['sort2dir']):''; ?>"><a href="?pid=<?=$patientid;?>&page=<?=$page;?>&filter=<?=$filter;?>&sort=sent2to&sort2dir=<?php echo ($_REQUEST['sort2']=='sentto'&&$_REQUEST['sort2dir']=='ASC')?'DESC':'ASC'; ?>#sect_letters">Sent To</a></th>
        <th class="col_head <?= ($_REQUEST['sort2'] == 'method')?'arrow_'.strtolower($_REQUEST['sort2dir']):''; ?>"><a href="?pid=<?=$patientid;?>&page=<?=$page;?>&filter=<?=$filter;?>&sort2=method&sort2dir=<?php echo ($_REQUEST['sort2']=='method'&&$_REQUEST['sort2dir']=='ASC')?'DESC':'ASC'; ?>#sect_letters">Method</a></th>
        <th class="col_head <?= ($_REQUEST['sort2'] == 'generated_date')?'arrow_'.strtolower($_REQUEST['sort2dir']):''; ?>"><a href="?pid=<?=$patientid;?>&page=<?=$page;?>&filter=<?=$filter;?>&sort2=generated_date&sort2dir=<?php echo ($_REQUEST['sort2']=='generated_date'&&$_REQUEST['sort2dir']=='ASC')?'DESC':'ASC'; ?>#sect_letters">Generated On</a></th>
        <th class="col_head <?= ($_REQUEST['sort2'] == 'delivery_date')?'arrow_'.strtolower($_REQUEST['sort2dir']):''; ?>"><a href="?pid=<?=$patientid;?>&page=<?=$page;?>&filter=<?=$filter;?>&sort2=delivery_date&sort2dir=<?php echo ($_REQUEST['sort2']=='delivery_date'&&$_REQUEST['sort2dir']=='ASC')?'DESC':'ASC'; ?>#sect_letters">Delivered On</a></th>
        <th class="col_head <?= ($_REQUEST['sort2'] == 'mailed')?'arrow_'.strtolower($_REQUEST['sort2dir']):''; ?>"><a href="?pid=<?=$patientid;?>&page=<?=$page;?>&filter=<?=$filter;?>&sort=mailed&sortdir=<?php echo ($_REQUEST['sort']=='mailed'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>#sect_letters">Mailed</a></th>
    </tr>
    <?php
    
    $i = $page_limit * $page2;
    $end = $i + $page_limit;
    
    while ($i < count($sent_letters) && $i < $end) {
        //print $sent_letters[$i]['templateid']; print "<br />";
        //$name = $sent_letters[$i]['lastname'] . " " . $sent_letters[$i]['middlename'] . ", " . $sent_letters[$i]['firstname'];
        $userid = $sent_letters[$i]['userid'];
        $url = $sent_letters[$i]['url'];
        $subject = $sent_letters[$i]['subject'];
        $sentto = $sent_letters[$i]['sentto'];
        $method = $sent_letters[$i]['send_method'];
        $generated = date('m/d/Y', $sent_letters[$i]['generated_date']);
        $delivered = ($sent_letters[$i]['delivery_date'] != '' )?date('m/d/Y', $sent_letters[$i]['delivery_date']):'';
        $id = $sent_letters[$i]['id'];
        $mailed = $sent_letters[$i]['mailed'];
        
        if ($sent_letters[$i]['old']) {
            $alert = " bgcolor=\"#FF9696\"";
        }
        else {
            $alert = null;
        }
        
        ?>
        <tr>
            <td><?= $userid ?></td>
            <td>
                <a href="<?= $url ?>"><?= $subject ?></a>
            </td>
            <td><?= $sentto ?></td>
            <td><?= $method ?></td>
            <td><?= $generated ?></td>
            <td><?= $delivered ?></td>
            <td>
                <?php if ($_SESSION['user_type'] == DSS_USER_TYPE_SOFTWARE) { ?>
                    <input type="checkbox" class="mailed_chk" value="<?= $id; ?>" <?= ($mailed !='')?'checked="checked"':''; ?> />
                <?php } else { ?>
                    <?= ($mailed !='')?'X':''; ?>
                <?php } ?>
            </td>
        </tr>
        <?php
        
        $i++;
    } ?>
</table>
<script type="text/javascript">
$(document).ready(function(){
    $('.contacts-toggler').on('click',function(e){
        e.preventDefault();
        
        var $this = $(this);
        
        $this.next().toggle();
        $this.find('.glyphicon')
        .toggleClass('glyphicon-chevron-up')
        .toggleClass('glyphicon-chevron-down')
        
        return false;
    });
});

$('.mailed_chk').click( function(){
    lid = $(this).val();
    c = $(this).is(':checked');
    
    $.ajax({
        url: "includes/letter_mail.php",
        type: "post",
        data: {lid: lid, mailed: c},
        success: function(data){
            var r = $.parseJSON(data);
            
            if (r.error){}
            else {}
        },
        failure: function(data){}
    });
});
</script>
