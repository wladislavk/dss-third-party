<?php
namespace Ds3\Libraries\Legacy;

include_once 'includes/patient_info.php';
include_once 'admin/includes/general.htm';
?>
<link rel="stylesheet" href="css/letters.css" />
<?php
if (isset($patient_info) && $patient_info) {
    function userid_asc($a, $b)
    {
        return strcmp($a['userid'], $b['userid']);
    }

    function userid_desc($a, $b)
    {
        return strcmp($b['userid'], $a['userid']);
    }

    function subject_asc($a, $b)
    {
        return strcmp($a['subject'], $b['subject']);
    }

    function subject_desc($a, $b)
    {
        return strcmp($b['subject'], $a['subject']);
    }

    function sentto_asc($a, $b)
    {
        $word_lista = explode(" ", $a['sentto']);
        $word_listb = explode(" ", $b['sentto']);
        if (is_numeric($word_lista[0]) && is_numeric($word_listb[0])) {
            if ($word_lista[0] == $word_listb[0]) {
                return 0;
            }
            return ($word_lista[0] < $word_listb[0]) ? -1 : 1;
        }
        if (is_numeric($word_lista[0])) {
            return -1;
        }
        if (is_numeric($word_listb[0])) {
            return 1;
        }
        return strcmp($a['sentto'], $b['sentto']);
    }

    function sentto_desc($a, $b)
    {
        $word_lista = explode(" ", $a['sentto']);
        $word_listb = explode(" ", $b['sentto']);
        if (is_numeric($word_lista[0]) && is_numeric($word_listb[0])) {
            if ($word_lista[0] == $word_listb[0]) {
                return 0;
            }
            return ($word_lista[0] > $word_listb[0]) ? -1 : 1;
        }
        if (is_numeric($word_lista[0])) {
            return 1;
        }
        if (is_numeric($word_listb[0])) {
            return -1;
        }
        return strcmp($b['sentto'], $a['sentto']);
    }

    function method_asc($a, $b)
    {
        return strcmp($a['send_method'], $b['send_method']);
    }

    function method_desc($a, $b)
    {
        return strcmp($b['send_method'], $a['send_method']);
    }

    function generated_date_asc($a, $b)
    {
        if ($a['generated_date'] == $b['generated_date']) {
            return 0;
        }
        return ($a['generated_date'] < $b['generated_date']) ? -1 : 1;
    }

    function generated_date_desc($a, $b)
    {
        if ($a['generated_date'] == $b['generated_date']) {
            return 0;
        }
        return ($a['generated_date'] > $b['generated_date']) ? -1 : 1;
    }

    function delivery_date_asc($a, $b)
    {
        if ($a['delivery_date'] == $b['delivery_date']) {
            return 0;
        }
        return ($a['delivery_date'] < $b['delivery_date']) ? -1 : 1;
    }

    function delivery_date_desc($a, $b)
    {
        if ($a['delivery_date'] == $b['delivery_date']) {
            return 0;
        }
        return ($a['delivery_date'] > $b['delivery_date']) ? -1 : 1;
    }

    $page = '0';
    $page_limit = '10';
    $filter = "%";

    if (isset($_GET['filter'])) {
        $filter = $db->escape( $_GET['filter']);
    }

    if (!isset($_REQUEST['sort'])) {
        $_REQUEST['sort'] = 'generated_date';
        if (!empty($status) && $status == 'sent') {
            $_REQUEST['sortdir'] = 'DESC';
        } else {
            $_REQUEST['sortdir'] = 'ASC';
        }
    }

    if (!isset($_REQUEST['sort2'])) {
        $_REQUEST['sort2'] = 'generated_date';
        $_REQUEST['sort2dir'] = 'DESC';
    }

    $sort = $_REQUEST['sort'];
    $sortdir = $_REQUEST['sortdir'];
    $patientid = $_REQUEST['pid'];
    $page1 = (!empty($_REQUEST['page1']) ? $_REQUEST['page1'] : '');
    $page2 = (!empty($_REQUEST['page2']) ? $_REQUEST['page2'] : '');
    // Get doctor id
    $docid = $_SESSION['docid'];

    $letters_query = "
        SELECT dental_letters.letterid, dental_letters.templateid, dental_letters.patientid, UNIX_TIMESTAMP(dental_letters.generated_date) as generated_date, UNIX_TIMESTAMP(dental_letters.delivery_date) as delivery_date, dental_letters.send_method, dental_letters.pdf_path, dental_letters.status, dental_letters.topatient, dental_letters.md_list, dental_letters.md_referral_list, dental_letters.pat_referral_list, dental_letters.mailed_date, dental_letters.mailed_once, dental_patients.firstname, dental_patients.lastname, dental_patients.middlename, dental_users.name as userid, dental_letters.template_type, 
            (SELECT f.sfax_status FROM dental_faxes f WHERE f.letterid = dental_letters.letterid ORDER BY f.sent_date DESC LIMIT 1) as sfax_status,
            (SELECT f2.viewed FROM dental_faxes f2 WHERE f2.letterid = dental_letters.letterid ORDER BY f2.sent_date DESC LIMIT 1) AS fax_viewed
        FROM dental_letters 
        JOIN dental_patients on dental_letters.patientid=dental_patients.patientid 
        LEFT JOIN dental_users ON dental_letters.userid=dental_users.userid 
        WHERE dental_letters.patientid = '" . $patientid . "' 
        AND dental_patients.docid='".$docid."' 
        AND dental_letters.deleted = '0' 
        AND (dental_letters.parentid IS NULL OR dental_letters.parentid=0)
        AND dental_letters.templateid LIKE '".$filter."' 
        GROUP BY dental_letters.letterid, dental_letters.parentid 
        ORDER BY dental_letters.letterid ASC;
    ";
    $lettersResult = [];
    if (isset($db) && $db instanceof Db) {
        $lettersResult = $db->getResults($letters_query);
    }
    $dental_letters = [];
    $templateIds = [];
    $customTemplateIds = [];
    $templates = [];
    $customTemplates = [];
    $letterIds = [];
    $childLetters = [];
    $patientIds = [];
    $referredSources = [];
    foreach ($lettersResult as $row) {
        $dental_letters[] = $row;
        if ($row['template_type'] == '0') {
            $templateIds[] = $row['templateid'];
        } else {
            $customTemplateIds[] = $row['templateid'];
        }
        $letterIds[] = $row['letterid'];
        $patientIds[] = $row['patientid'];
    }
    if (count($letterIds)) {
        $letterIdsString = $db->escapeList($letterIds);
        $childLettersSql = "
            SELECT letterid, topatient, patientid, md_list, md_referral_list, pat_referral_list 
            FROM dental_letters
            WHERE status=0 AND deleted=0 AND parentid IN ($letterIdsString);
        ";
        $childLetters = $db->getResults($childLettersSql);
    }
    if (count($patientIds)) {
        $patientIdsString = join(', ', $patientIds);
        $referredSourceSql = "SELECT patientid, referred_source FROM dental_patients where patientid IN ($patientIdsString)";
        $referredSourceResult = $db->getRow($referredSourceSql);
        if ($referredSourceResult) {
            $referredSources[$referredSourceResult['patientid']] = $referredSourceResult['referred_source'];
        }
    }
    if (count($templateIds)) {
        $templateIdsString = $db->escapeList($templateIds);
        $template_sql = "SELECT id, name FROM dental_letter_templates WHERE id IN ($templateIdsString);";
        $templates = $db->getResults($template_sql);
    }
    if (count($customTemplateIds)) {
        $templateIdsString = $db->escapeList($customTemplateIds);
        $template_sql = "SELECT id, name FROM dental_letter_templates_custom WHERE id IN ($templateIdsString);";
        $customTemplates = $db->getResults($template_sql);
    }

    if ($dental_letters) {
        foreach ($dental_letters as $key => $letter) {
            // Get Correspondence Column
            $subject = '';
            if ($letter['template_type'] == '0') {
                foreach ($templates as $template) {
                    if ($template['id'] == $letter['templateid']) {
                        $subject = $template['name'];
                    }
                }
            } else {
                foreach ($customTemplates as $template) {
                    if ($template['id'] == $letter['templateid']) {
                        $subject = $template['name'];
                    }
                }
            }
            $dental_letters[$key]['id'] = $letter['letterid'];
            $dental_letters[$key]['mailed'] = $letter['mailed_date'];
            $dental_letters[$key]['mailed_once'] = $letter['mailed_once'];
            if (!empty($letter['pdf_path']) && $letter['status'] != 0) {
                $dental_letters[$key]['url'] = "/manage/letterpdfs/" . $letter['pdf_path'];
            } else {
                $dental_letters[$key]['url'] = "/manage/edit_letter.php?fid=" . $letter['patientid'] . "&pid=" . $letter['patientid'] . "&lid=" . $letter['letterid']."&goto=letter";
            }
            $dental_letters[$key]['subject'] = $subject;
            if ($letter['templateid'] == 99) {
                $dental_letters[$key]['subject'] = "User Generated";
            }
            $contacts = get_contact_info(
                (($letter['topatient'] == "1") ? $letter['patientid'] : ''),
                $letter['md_list'],
                $letter['md_referral_list'],
                $letter['pat_referral_list']
            );

            //  ADD IN CHILD LETTERS TO CONTACTS
            if ($childLetters) {
                foreach ($childLetters as $childLetter) {
                    if ($childLetter['parentid'] == $letter['letterid']) {
                        $master_contacts = get_contact_info(
                            (($childLetter['topatient'] == "1") ? $childLetter['patientid'] : ''),
                            $childLetter['md_list'],
                            $childLetter['md_referral_list'],
                            $childLetter['pat_referral_list'],
                            $childLetter['letterid']
                        );
                        if (!empty($contacts['patient']) && count($contacts['patient']) && count($master_contacts['patient'])) {
                            // nothing
                        } elseif (isset($master_contacts['patient']) && count($master_contacts['patient'])) {
                            $contacts['patient'] = $master_contacts['patient'];
                        }
                        if (isset($contacts['mds']) && count($contacts['mds']) && isset($master_contacts['mds']) && count($master_contacts['mds'])) {
                            $contacts['mds'] = array_merge($contacts['mds'], $master_contacts['mds']);
                        } elseif (isset($master_contacts['mds']) && count($master_contacts['mds'])) {
                            $contacts['mds'] = $master_contacts['mds'];
                        }
                        if (isset($contacts['md_referrals']) && isset($contacts['md_referrals']) && count($contacts['md_referrals']) && isset($master_contacts['md_referrals']) && count($master_contacts['md_referrals'])) {
                            $contacts['md_referrals'] = array_merge($contacts['md_referrals'], $master_contacts['md_referrals']);
                        } elseif (isset($master_contacts['md_referrals']) && count($master_contacts['md_referrals'])) {
                            $contacts['md_referrals'] = $master_contacts['md_referrals'];
                        }
                        if (isset($contacts['pat_referrals']) && count($contacts['pat_referrals']) && count($master_contacts['pat_referrals'])) {
                            $contacts['pat_referrals'] = array_merge($contacts['pat_referrals'], $master_contacts['pat_referrals']);
                        } elseif (isset($master_contacts['pat_referrals']) && count($master_contacts['pat_referrals'])) {
                            $contacts['pat_referrals'] = $master_contacts['pat_referrals'];
                        }
                    }
                }
            }
            $total_contacts = count((!empty($contacts['patient']) ? $contacts['patient'] : null)) + count((!empty($contacts['mds']) ? $contacts['mds'] : null)) + count((!empty($contacts['md_referrals']) ? $contacts['md_referrals'] : null)) + count((!empty($contacts['pat_referrals']) ? $contacts['pat_referrals'] : null));
            $dental_letters[$key]['total_contacts'] = $total_contacts;
            if ($total_contacts > 1) {
                $dental_letters[$key]['sentto'] = $total_contacts . " Contacts";
                $dental_letters[$key]['patient'] = (!empty($contacts['patient']) ? $contacts['patient'] : '');
                $dental_letters[$key]['mds'] = (!empty($contacts['mds']) ? $contacts['mds'] : '');
                $dental_letters[$key]['md_referrals'] = (!empty($contacts['md_referrals']) ? $contacts['md_referrals'] : '');
                $dental_letters[$key]['pat_referrals'] = (!empty($contacts['pat_referrals']) ? $contacts['pat_referrals'] : '');
            } elseif ($total_contacts == 0) {
                $dental_letters[$key]['sentto'] = "<span class=\"red\">No Contacts</span>";
            } else {
                // Patient: Salutation Lastname, Firstname
                $dental_letters[$key]['sentto'] = '';
                $dental_letters[$key]['sentto'] .= (isset($contacts['patient'][0])) ? ($contacts['patient'][0]['salutation'] . " " . $contacts['patient'][0]['lastname'] . ", " . $contacts['patient'][0]['firstname']. (($dental_letters[$key]['mailed_once']==0)?"<a class=\"delete_letter\" href=\"#\" onclick=\"delete_pending_letter('".$letter['letterid']."', 'patient', '".$contacts['patient'][0]['id']."', 1)\" />Delete</a>":"")) : ("");
                // MD: Salutation Lastname, Firstname - Contact Type
                $dental_letters[$key]['sentto'] .= (isset($contacts['mds'][0])) ? ($contacts['mds'][0]['lastname'] . ", " . $contacts['mds'][0]['salutation'] . " " . $contacts['mds'][0]['firstname'] . ((!empty($contacts['mds']['contacttype'])) ? (" - " . $contacts['mds']['contacttype']) : ("")). (($dental_letters[$key]['mailed_once']==0)?"<a class=\"delete_letter\" href=\"#\" onclick=\"delete_pending_letter('".$letter['letterid']."', 'md', '".$contacts['mds'][0]['id']."', 1)\" />Delete</a>":"")) : ("");
                // MD Referral: Salutation Lastname, Firstname - Contact Type
                $dental_letters[$key]['sentto'] .= (isset($contacts['md_referrals'][0])) ? ($contacts['md_referrals'][0]['lastname'] . ", " . $contacts['md_referrals'][0]['salutation'] . " " . $contacts['md_referrals'][0]['firstname'] . ((!empty($contacts['md_referrals']['contacttype'])) ? (" - " . $contacts['md_referrals']['contacttype']) : ("")). (($dental_letters[$key]['mailed_once']==0)?"<a class=\"delete_letter\" href=\"#\" onclick=\"delete_pending_letter('".$letter['letterid']."', 'md_referral', '".$contacts['md_referrals'][0]['id']."', 1)\" />Delete</a>":"")) : ("");
                // Pat Referral: Salutation Lastname, Firstname - Contact Type
                $dental_letters[$key]['sentto'] .= (isset($contacts['pat_referrals'][0])) ? ($contacts['pat_referrals'][0]['lastname'] . ", " . $contacts['pat_referrals'][0]['salutation'] . " " . $contacts['pat_referrals'][0]['firstname'] .  (($dental_letters[$key]['mailed_once']==0)?"<a class=\"delete_letter\" href=\"#\" onclick=\"delete_pending_letter('".$letter['letterid']."', 'pat_referral', '".$contacts['pat_referrals'][0]['id']."', 1)\" />Delete</a>":"")) : ("");
            }
            // Determine if letter is older than 7 days
            if (!isset($seconds_per_day)) {
                $seconds_per_day = 1;
            }
            if (floor((time() - $letter['generated_date']) / $seconds_per_day) > 7 && !empty($status) && $status == "pending") {
                $dental_letters[$key]['old'] = true;
            }
        }
        // Collect Letters in array
        $pending_letters = [];
        $sent_letters = [];
        foreach ($dental_letters as $letter) {
            if ($letter['status'] == "0") {
                $pending_letters[] = $letter;
            } else {
                $sent_letters[] = $letter;
            }
        }

        // Calculate number of pages
        $num_pages1 = floor(count($pending_letters) / $page_limit);
        if (count($pending_letters) % $page_limit) {
            $num_pages1++;
        }

        // Calculate number of pages
        $num_pages2 = floor(count($sent_letters) / $page_limit);
        if (count($sent_letters) % $page_limit) {
            $num_pages2++;
        }

        // Sort the letters array
        if ($_REQUEST['sort'] == "userid" && $_REQUEST['sortdir'] == "ASC") {
            usort($pending_letters, 'Ds3\Libraries\Legacy\userid_asc');
        }
        if ($_REQUEST['sort'] == "userid" && $_REQUEST['sortdir'] == "DESC") {
            usort($pending_letters, 'Ds3\Libraries\Legacy\userid_desc');
        }
        if ($_REQUEST['sort'] == "subject" && $_REQUEST['sortdir'] == "ASC") {
            usort($pending_letters, 'Ds3\Libraries\Legacy\subject_asc');
        }
        if ($_REQUEST['sort'] == "subject" && $_REQUEST['sortdir'] == "DESC") {
            usort($pending_letters, 'Ds3\Libraries\Legacy\subject_desc');
        }
        if ($_REQUEST['sort'] == "method" && $_REQUEST['sortdir'] == "ASC") {
            usort($pending_letters, 'Ds3\Libraries\Legacy\method_asc');
        }
        if ($_REQUEST['sort'] == "method" && $_REQUEST['sortdir'] == "DESC") {
            usort($pending_letters, 'Ds3\Libraries\Legacy\method_desc');
        }
        if ($_REQUEST['sort'] == "sentto" && $_REQUEST['sortdir'] == "ASC") {
            usort($pending_letters, 'Ds3\Libraries\Legacy\sentto_asc');
        }
        if ($_REQUEST['sort'] == "sentto" && $_REQUEST['sortdir'] == "DESC") {
            usort($pending_letters, 'Ds3\Libraries\Legacy\sentto_desc');
        }
        if ($_REQUEST['sort'] == "generated_date" && $_REQUEST['sortdir'] == "ASC") {
            usort($pending_letters, 'Ds3\Libraries\Legacy\generated_date_asc');
        }
        if ($_REQUEST['sort'] == "generated_date" && $_REQUEST['sortdir'] == "DESC") {
            usort($pending_letters, 'Ds3\Libraries\Legacy\generated_date_desc');
        }
        if ($_REQUEST['sort'] == "delivery_date" && $_REQUEST['sortdir'] == "ASC") {
            usort($pending_letters, 'Ds3\Libraries\Legacy\delivery_date_asc');
        }
        if ($_REQUEST['sort'] == "delivery_date" && $_REQUEST['sortdir'] == "DESC") {
            usort($pending_letters, 'Ds3\Libraries\Legacy\delivery_date_desc');
        }

        // Sort the letters array
        if ($_REQUEST['sort2'] == "userid" && $_REQUEST['sort2dir'] == "ASC") {
            usort($sent_letters, 'Ds3\Libraries\Legacy\userid_asc');
        }
        if ($_REQUEST['sort2'] == "userid" && $_REQUEST['sort2dir'] == "DESC") {
            usort($sent_letters, 'Ds3\Libraries\Legacy\userid_desc');
        }
        if ($_REQUEST['sort2'] == "subject" && $_REQUEST['sort2dir'] == "ASC") {
            usort($sent_letters, 'Ds3\Libraries\Legacy\subject_asc');
        }
        if ($_REQUEST['sort2'] == "subject" && $_REQUEST['sort2dir'] == "DESC") {
            usort($sent_letters, 'Ds3\Libraries\Legacy\subject_desc');
        }
        if ($_REQUEST['sort2'] == "method" && $_REQUEST['sort2dir'] == "ASC") {
            usort($sent_letters, 'Ds3\Libraries\Legacy\method_asc');
        }
        if ($_REQUEST['sort2'] == "method" && $_REQUEST['sort2dir'] == "DESC") {
            usort($sent_letters, 'Ds3\Libraries\Legacy\method_desc');
        }
        if ($_REQUEST['sort2'] == "sentto" && $_REQUEST['sort2dir'] == "ASC") {
            usort($sent_letters, 'Ds3\Libraries\Legacy\sentto_asc');
        }
        if ($_REQUEST['sort2'] == "sentto" && $_REQUEST['sort2dir'] == "DESC") {
            usort($sent_letters, 'Ds3\Libraries\Legacy\sentto_desc');
        }
        if ($_REQUEST['sort2'] == "generated_date" && $_REQUEST['sort2dir'] == "ASC") {
            usort($sent_letters, 'Ds3\Libraries\Legacy\generated_date_asc');
        }
        if ($_REQUEST['sort2'] == "generated_date" && $_REQUEST['sort2dir'] == "DESC") {
            usort($sent_letters, 'Ds3\Libraries\Legacy\generated_date_desc');
        }
        if ($_REQUEST['sort2'] == "delivery_date" && $_REQUEST['sort2dir'] == "ASC") {
            usort($sent_letters, 'Ds3\Libraries\Legacy\delivery_date_asc');
        }
        if ($_REQUEST['sort2'] == "delivery_date" && $_REQUEST['sort2dir'] == "DESC") {
            usort($sent_letters, 'Ds3\Libraries\Legacy\delivery_date_desc');
        }
    }

    $f_sql = "
        SELECT * FROM dental_faxes 
        WHERE sfax_completed=1 
        AND sfax_status=2 
        AND patientid='".$db->escape( $_GET['pid'])."' 
        AND docid='".$db->escape( $_SESSION['docid'])."' 
        AND viewed=0;
    ";
    $f_num = $db->getNumberRows($f_sql);
    if ($f_num > 0) { ?>
        <br /><br />
        <a href="manage_faxes.php?status=3&viewed=0#fax" class="warning" id="fax_alert"><?= $f_num; ?> letter<?= ($f_num > 1) ? 's' : '';?> failed to send via digital fax. Click here to check errors and retry.</a>
        <?php
    } ?>

    <div style="padding-left: 15px;">
        <h1 class="blue" style="width: 300px; float:left;">Patient Letters</h1>
        <?php
        $let_sql = "SELECT use_letters FROM dental_users WHERE userid='".$db->escape($_SESSION['docid'])."'";
        $let_r = $db->getRow($let_sql);
        if ($let_r['use_letters']) { ?>
            <div style="float: right;margin:20px 40px 0 0;">
                <form method="get" action="/manage/new_letter.php">
                    <input type="hidden" name="pid" value="<?= $patientid ?>" />
                    <input class="addButton" type="submit" value="Create New Letter">
                </form>
            </div>
            <?php
        } ?>
        <div style="clear:both;"></div>
        <form name="filter_letters" action="dss_summ.php" method="get" style="float:right;">
            <input type="hidden" name="pid" value="<?= $patientid ?>" />
            <input type="hidden" name="sect" value="letters" />
            <input type="hidden" name="addtopat" value="1" />
            Show letter type:
            <select name="filter" onchange="document.filter_letters.submit();">
                <option value="%"></option>
                <?php
                $templates = "
                    SELECT t.id, t.name, ct.triggerid FROM dental_letter_templates t 
                    INNER JOIN dental_letter_templates ct ON ct.triggerid = t.id
                    WHERE ct.companyid='".$_SESSION['companyid']."'
                    ORDER BY id ASC;
                ";
                $result = $db->getResults($templates);
                foreach ($result as $row) {
                    //DO NOT SHOW LETTER 1 (FROM DSS) FOR USER TYPE SOFTWARE
                    if ($_SESSION['user_type'] != DSS_USER_TYPE_SOFTWARE || $row['triggerid'] != 1) { ?>
                        <option <?= (($filter == $row['id']) ? "selected " : "") ?>value="<?= $row['id'] ?>"><?= $row['id'] ?> - <?= $row['name'] ?></option>
                        <?php
                    }
                } ?>
            </select>
        </form>
    </div>
    <div style="padding:  0 0 0 15px; clear: left;float: left;">
        <h2 class="blue" style="margin:15px 0 5px 0;">Pending Letters</h2>
    </div>
    <div class="letters-pager" style="clear:right; margin-top:10px;">Page(s): <?php paging1($num_pages1, $page1, "pid=$patientid&filter=$filter&sort=$sort&sortdir=$sortdir&sect=letters", $page2); ?></div>
    <div style="clear:both;"></div>
    <table cellpadding="3" id="letters-table" width="97%" style="margin: 0 auto;">
        <tr class="tr_bg_h">
            <td class="col_head <?= ($_REQUEST['sort'] == 'subject') ? 'arrow_'.strtolower($_REQUEST['sortdir']) : ''; ?>"><a href="patient_letters.php?pid=<?= $patientid; ?>&page=<?= $page; ?>&filter=<?= $filter; ?>&sort=subject&sortdir=<?= ($_REQUEST['sort'] == 'subject' && $_REQUEST['sortdir'] == 'ASC') ? 'DESC' : 'ASC'; ?>">Correspondence</a></td>
            <td class="col_head <?= ($_REQUEST['sort'] == 'sentto') ? 'arrow_'.strtolower($_REQUEST['sortdir']) : ''; ?>"><a href="patient_letters.php?pid=<?= $patientid; ?>&page=<?= $page; ?>&filter=<?= $filter; ?>&sort=sentto&sortdir=<?= ($_REQUEST['sort'] == 'sentto' && $_REQUEST['sortdir'] == 'ASC') ? 'DESC' : 'ASC'; ?>">Sent To</a></td>
            <td class="col_head <?= ($_REQUEST['sort'] == 'generated_date') ? 'arrow_'.strtolower($_REQUEST['sortdir']) : ''; ?>"><a href="patient_letters.php?pid=<?= $patientid; ?>&page=<?= $page; ?>&filter=<?= $filter;?>&sort=generated_date&sortdir=<?= ($_REQUEST['sort'] == 'generated_date' && $_REQUEST['sortdir'] == 'ASC') ? 'DESC' : 'ASC'; ?>">Generated On</a></td>
        </tr>
        <?php
        $i = $page_limit * $page1;
        $end = $i + $page_limit;
        while ($i < count($pending_letters) && $i < $end) {
            $url = $pending_letters[$i]['url'];
            $id = $pending_letters[$i]['id'];
            $subject = $pending_letters[$i]['subject'];
            $sentto = $pending_letters[$i]['sentto'];
            $total_contacts = $pending_letters[$i]['total_contacts'];
            $generated = ($pending_letters[$i]['generated_date']) ? date('m/d/Y', $pending_letters[$i]['generated_date']) : '';
            $alert = null;
            if ($pending_letters[$i]['sfax_status'] == '2' && $pending_letters[$i]['fax_viewed'] == '0') {
                $alert = " bgcolor=\"#FFFF33\"";
            } elseif (!empty($pending_letters[$i]['old'])) {
                $alert = " bgcolor=\"#FF9696\"";
            } ?>
            <tr<?= $alert; ?>>
                <td><a href="<?= $url; ?>"><?= $subject; ?></a></td>
                <td>
                    <?php
                    if ($total_contacts > 1) { ?>
                        <a href="#" onclick="$('#contacts_<?= $id; ?>').toggle();"><?= $sentto; ?></a>
                        <div style="display:none;" id="contacts_<?= $id; ?>">
                        <?php
                        if ($pending_letters[$i]['patient']) {
                            foreach ($pending_letters[$i]['patient'] as $pat) { ?>
                                <br />
                                <?php
                                echo $pat['salutation']." ".$pat['firstname']." ".$pat['lastname']; ?>
                                <a href="#" class="delete_letter" onclick="delete_pending_letter('<?= $id; ?>', 'patient', '<?= $pat['id']; ?>', 0)">Delete</a>
                                <?php
                            }
                        }
                        if ($pending_letters[$i]['mds']) {
                            foreach ($pending_letters[$i]['mds'] as $md) { ?>
                                <br />
                                <?php
                                echo $md['salutation']." ".$md['firstname']." ".$md['lastname']; ?>
                                <a href="#" class="delete_letter" onclick="delete_pending_letter('<?= $id; ?>', 'md', '<?= $md['id']; ?>', 0)">Delete</a>
                                <?php
                            }
                        }
                        if ($pending_letters[$i]['md_referrals']) {
                            foreach ($pending_letters[$i]['md_referrals'] as $md_referral) { ?>
                                <br />
                                <?php
                                echo $md_referral['salutation']." ".$md_referral['firstname']." ".$md_referral['lastname']; ?>
                                <a href="#" class="delete_letter" onclick="delete_pending_letter('<?= $id; ?>', 'md_referral', '<?= $md_referral['id']; ?>', 0)">Delete</a>
                                <?php
                            }
                        }
                        if ($pending_letters[$i]['pat_referrals']) {
                            foreach ($pending_letters[$i]['pat_referrals'] as $pat_referral) { ?>
                                <br />
                                <?php
                                echo $pat_referral['salutation']." ".$pat_referral['firstname']." ".$pat_referral['lastname']; ?>
                                <a href="#" class="delete_letter" onclick="delete_pending_letter('<?= $id; ?>', 'pat_referral', '<?= $pat_referral['id']; ?>', 0)">Delete</a>
                                <?php
                            }
                        } ?>
                    </div>
                        <?php
                    } else {
                        echo $sentto;
                    } ?>
                </td>
                <td><?= $generated; ?></td>
            </tr>
            <?php
            $i++;
        } ?>
    </table>
    <br />
    <div style="padding-left: 15px; clear: left;float: left;">
        <h2 class="blue" style="margin:15px 0 5px 0;">Sent Letters</h2>
    </div>
    <div class="letters-pager" style="clear:right; margin-top:10px;">Page(s): <?php paging2($num_pages2, $page2, "pid=$patientid&filter=$filter&sort=$sort&sortdir=$sortdir&sect=letters", $page1); ?></div>
    <div style="clear:both;">
        <table cellpadding="3" id="letters-table" width="97%" style="margin: 0 auto;">
            <tr class="tr_bg_h">
                <td class="col_head <?= ($_REQUEST['sort2'] == 'userid') ? 'arrow_'.strtolower($_REQUEST['sort2dir']) : ''; ?>"><a href="patient_letters.php?pid=<?php echo $patientid;?>&page=<?php echo $page;?>&filter=<?php echo $filter;?>&sort=userid&sort2dir=<?= ($_REQUEST['sort2'] == 'userid' && $_REQUEST['sort2dir'] == 'ASC') ? 'DESC' : 'ASC'; ?>">User ID</a></td>
                <td class="col_head <?= ($_REQUEST['sort2'] == 'subject') ? 'arrow_'.strtolower($_REQUEST['sort2dir']) : ''; ?>"><a href="patient_letters.php?pid=<?php echo $patientid;?>&page=<?php echo $page;?>&filter=<?php echo $filter;?>&sort2=subject&sort2dir=<?= ($_REQUEST['sort2'] == 'subject' && $_REQUEST['sort2dir'] == 'ASC') ? 'DESC' : 'ASC'; ?>">Correspondence</a></td>
                <td class="col_head <?= ($_REQUEST['sort2'] == 'sentto') ? 'arrow_'.strtolower($_REQUEST['sort2dir']) : ''; ?>"><a href="patient_letters.php?pid=<?php echo $patientid;?>&page=<?php echo $page;?>&filter=<?php echo $filter;?>&sort=sent2to&sort2dir=<?= ($_REQUEST['sort2'] == 'sentto' && $_REQUEST['sort2dir'] == 'ASC') ? 'DESC' : 'ASC'; ?>">Sent To</a></td>
                <td class="col_head <?= ($_REQUEST['sort2'] == 'method') ? 'arrow_'.strtolower($_REQUEST['sort2dir']) : ''; ?>"><a href="patient_letters.php?pid=<?php echo $patientid;?>&page=<?php echo $page;?>&filter=<?php echo $filter;?>&sort2=method&sort2dir=<?= ($_REQUEST['sort2'] == 'method' && $_REQUEST['sort2dir'] == 'ASC') ? 'DESC' : 'ASC'; ?>">Method</a></td>
                <td class="col_head <?= ($_REQUEST['sort2'] == 'generated_date') ? 'arrow_'.strtolower($_REQUEST['sort2dir']) : ''; ?>"><a href="patient_letters.php?pid=<?php echo $patientid;?>&page=<?php echo $page;?>&filter=<?php echo $filter;?>&sort2=generated_date&sort2dir=<?= ($_REQUEST['sort2'] == 'generated_date' && $_REQUEST['sort2dir'] == 'ASC') ? 'DESC' : 'ASC'; ?>">Generated On</a></td>
                <td class="col_head <?= ($_REQUEST['sort2'] == 'delivery_date') ? 'arrow_'.strtolower($_REQUEST['sort2dir']) : ''; ?>"><a href="patient_letters.php?pid=<?php echo $patientid;?>&page=<?php echo $page;?>&filter=<?php echo $filter;?>&sort2=delivery_date&sort2dir=<?= ($_REQUEST['sort2'] == 'delivery_date' && $_REQUEST['sort2dir'] == 'ASC') ? 'DESC' : 'ASC'; ?>">Delivered On</a></td>
                <td class="col_head <?= ($_REQUEST['sort2'] == 'mailed') ? 'arrow_'.strtolower($_REQUEST['sort2dir']) : ''; ?>"><a href="patient_letters.php?pid=<?php echo $patientid;?>&page=<?php echo $page;?>&filter=<?php echo $filter;?>&sort=mailed&sortdir=<?= ($_REQUEST['sort'] == 'mailed' && $_REQUEST['sortdir'] == 'ASC') ? 'DESC' : 'ASC'; ?>">Mailed</a></td>
            </tr>
            <?php
            $i = $page_limit * $page2;
            $end = $i + $page_limit;
            while ($i < count($sent_letters) && $i < $end) {
                $userid = $sent_letters[$i]['userid'];
                $url = $sent_letters[$i]['url'];
                $subject = $sent_letters[$i]['subject'];
                $sentto = $sent_letters[$i]['sentto'];
                $method = $sent_letters[$i]['send_method'];
                $generated = date('m/d/Y', $sent_letters[$i]['generated_date']);
                $delivered = ($sent_letters[$i]['delivery_date'] != '' ) ? date('m/d/Y', $sent_letters[$i]['delivery_date']) : '';
                $id = $sent_letters[$i]['id'];
                $mailed = $sent_letters[$i]['mailed'];
                $alert = null;
                ?>
                <tr>
                    <td><?= $userid ?></td>
                    <td><a href="<?= $url ?>"><?= $subject ?></a></td>
                    <td><?= $sentto ?></td>
                    <td><?= letterSendMethod($method, '') ?></td>
                    <td><?= $generated ?></td>
                    <td><?= $delivered ?></td>
                    <?php
                    if ($_SESSION['user_type'] == DSS_USER_TYPE_SOFTWARE) { ?>
                        <td><input type="checkbox" class="mailed_chk" value="<?= $id; ?>" <?= ($mailed != '') ? 'checked="checked"' : ''; ?> /></td>
                        <?php
                    } else { ?>
                        <td><?= ($mailed != '') ? 'X' : ''; ?> </td>
                        <?php
                    } ?>
                </tr>
                <?php
                $i++;
            } ?>
        </table>
    </div>
    <script src="js/summ_letters.js" type="text/javascript"></script>
    <?php
} else {  // end pt info check ?>
    <div style="width: 65%; margin: auto;">Patient Information Incomplete -- Please complete the required fields in Patient Info section to enable this page.</div>
    <?php
} ?>
