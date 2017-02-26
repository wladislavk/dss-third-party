<?php
namespace Ds3\Libraries\Legacy;

if ($_GET['backoffice'] == '1') {
    include 'admin/includes/top.htm'; ?>
    <link rel="stylesheet" href="admin/popup/popup.css" type="text/css" media="screen"/>
    <script src="admin/popup/popup.js" type="text/javascript"></script>
<?php } else {
    include 'includes/top.htm';
    include 'admin/includes/invoice_functions.php';
}

$db = new Db();
$docId = intval($_SESSION['docid']);
$userId = intval($_SESSION['userid']);

$margins = $db->getRow("SELECT
        letter_margin_top AS 'top',
        letter_margin_bottom AS 'bottom',
        letter_margin_left AS 'left',
        letter_margin_right AS 'right'
    FROM dental_users
    WHERE userid = '$docId'");

$pageSize = [
    'width' => 216,
    'height' => 279,
];

$googleFonts = [
    'dejavusans' => 'Open Sans',
    'times' => 'Tinos',
    'helvetica' => 'Roboto',
    'courier' => 'Cutive Mono',
];

$letterHeader = '<p>
    %franchisee_fullname%<br />
    %franchisee_practice%<br />
    %franchisee_addr%
</p>';
$emptyParagraph = '<p>&nbsp;</p>';
$letterDate = '<p>%todays_date%</p>';
$letterIndentedAddress = '<table border="0">
    <tr>
        <td width="70"></td>
        <td>
            %contact_fullname%<br />
            %practice%
            %addr1%%addr2%<br />
            %city%, %state% %zip%<br />
        </td>
    </tr>
</table>';
$letterUnindentedAddress = '
%contact_fullname%<br />
%practice%
%addr1%%addr2%<br />
%city%, %state% %zip%
';

$parentLetterId = intval($_GET['lid']);
$patientId = intval($_GET['pid']);

$status_r = $db->getRow("SELECT status, docid
    FROM dental_letters
    WHERE letterid = '$parentLetterId'");
$parent_status = $status_r['status'];
$letter_doc = $status_r['docid'];

if ($_SESSION['docid'] != $letter_doc && (!isset($_SESSION['adminuserid']) || $_SESSION['adminuserid'] == '')) { ?>
    <h2>You are not permitted to view this letter.</h2>
    <?php
    trigger_error("Die called", E_USER_ERROR);
}

$todays_date = date('F d, Y');

/**
 * Patient related information
 */
$itype = $db->getRow("SELECT *
    FROM dental_q_image
    WHERE imagetypeid = 4
        AND patientid = '$patientId'
    ORDER BY adddate DESC
    LIMIT 1");
$patient_photo = $itype['image_file'];

$docpcp = $db->getColumn("SELECT docpcp
    FROM dental_patients
    WHERE patientid = '$patientId'", 'docpcp');

$patient_info = $db->getRow("SELECT salutation, firstname, middlename, lastname, gender, dob, email, p_m_ins_id, docid, referred_source
    FROM dental_patients
    WHERE patientid = '$patientId'");

$patient_info['age'] = floor(time() - strtotime((string)$patient_info['dob'])/31556926);
$source = $patient_info['referred_source'];

$consult_date = $db->getColumn("SELECT date_completed
    FROM dental_flow_pg2_info
    WHERE patientid = '$patientId'
        AND segmentid = 2
    ORDER BY stepid DESC
    LIMIT 1", 'date_completed');
$consult_date = date('F d, Y', strtotime($consult_date));

$impressions_date = $db->getColumn("SELECT date_completed
    FROM dental_flow_pg2_info
    WHERE patientid = '$patientId'
        AND segmentid = 4
    ORDER BY stepid DESC
    LIMIT 1", 'date_completed');
$impressions_date = date('F d, Y', strtotime($impressions_date));

$q3_myarray = $db->getRow("SELECT other_history, other_medications, medicationscheck
    FROM dental_q_page3
    WHERE patientid = '$patientId'");
$history_disp = ($q3_myarray['other_history']) ? $q3_myarray['other_history'] : "none provided";
$medications_disp = $q3_myarray['other_medications'] ?: 'none provided';

// Oldest Sleepstudy Results
$q1_myarray = $db->getRow("SELECT
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
    WHERE patiendid = '$patientId'
    ORDER BY COALESCE(
        STR_TO_DATE(s.date, '%m/%d/%Y'),
        STR_TO_DATE(s.date, '%m/%d/%y'),
        STR_TO_DATE(s.date, '%Y%m%d'),
        STR_TO_DATE(s.date, '%m-%d-%Y'),
        STR_TO_DATE(s.date, '%m-%d-%y'),
        STR_TO_DATE(s.date, '%m%d%Y'),
        STR_TO_DATE(s.date, '%m%d%y')
    ) ASC
    LIMIT 1");

$first_study_date = st($q1_myarray['date']);
$first_diagnosis = st($q1_myarray['ins_diagnosis'] . " " . $q1_myarray['description']);
$first_ahi = st($q1_myarray['ahi']);
$first_rdi = st($q1_myarray['rdi']);
$first_o2sat90 = st($q1_myarray['t9002']);
$first_o2nadir = st($q1_myarray['o2nadir']);
$first_type_study = st($q1_myarray['sleeptesttype']) . " sleep test";
$first_center_name = st($q1_myarray['place']);

$q2_myarray = $db->getRow("SELECT
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
        AND s.patiendid = '$patientId'
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
    LIMIT 1");

$completed_study_date = st($q2_myarray['date']);
$completed_diagnosis = st($q2_myarray['ins_diagnosis'] . " " . $q2_myarray['description']);
$completed_ahi = st($q2_myarray['ahi']);
$completed_rdi = st($q2_myarray['rdi']);
$completed_o2sat90 = st($q2_myarray['t9002']);
$completed_o2nadir = st($q2_myarray['o2nadir']);
$completed_type_study = st($q2_myarray['sleeptesttype']) . " sleep test";

if ($q2_myarray == '0') {
    $completed_sleeplab_name = 'home';
} else {
    $completed_sleeplab_name = $q2_myarray['company'];
}

if ($first_center_name == '0') {
    $first_sleeplab_name = 'home';
} else {
    $first_sleeplab_name = $db->getColumn("SELECT company
        FROM dental_sleeplab
        WHERE status = 1
            AND sleeplabid = '" . $db->escape($first_center_name) . "'", 'company');
}

$q2_myarray = $db->getRow("SELECT
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
    WHERE patiendid = '$patientId'
    ORDER BY COALESCE(
        STR_TO_DATE(dss.date, '%m/%d/%Y'),
        STR_TO_DATE(dss.date, '%m/%d/%y'),
        STR_TO_DATE(dss.date, '%Y%m%d'),
        STR_TO_DATE(dss.date, '%m-%d-%Y'),
        STR_TO_DATE(dss.date, '%m-%d-%y'),
        STR_TO_DATE(dss.date, '%m%d%Y'),
        STR_TO_DATE(dss.date, '%m%d%y')
    ) DESC
    LIMIT 1");

$second_study_date = st($q2_myarray['date']);
$second_diagnosis = st($q2_myarray['ins_diagnosis'] . " " . $q2_myarray['description']);
$second_ahi = st($q2_myarray['ahi']);
$second_ahisupine = st($q2_myarray['ahisupine']);
$second_rdi = st($q2_myarray['rdi']);
$second_o2sat90 = st($q2_myarray['t9002']);
$second_o2nadir = st($q2_myarray['o2nadir']);
$second_type_study = st($q2_myarray['sleeptesttype']) . " sleep test";
$sleep_center_name = st($q2_myarray['place']);

$dd_r = $db->getRow("SELECT dd.device, ex.dentaldevice_date
    FROM dental_ex_page5 ex
        LEFT JOIN dental_device dd ON dd.deviceid = ex.dentaldevice
    WHERE ex.patientid = '$patientId'");

$dentaldevice = $dd_r['device'];
$delivery_date = ($dd_r['dentaldevice_date'] != '') ? date('F d, Y', strtotime($dd_r['dentaldevice_date'])) : '';

$sleeplab_name = $db->getColumn("SELECT company
    FROM dental_sleeplab
    WHERE status = 1
        AND sleeplabid = '" . $db->escape($sleep_center_name) . "'", 'company');

// Oldest Subjective results
$subj1 = $db->getRow("SELECT ep_eadd, ep_sadd, ep_eladd, sleep_qualadd
    FROM dentalsummfu
    WHERE patientid = '$patientId'
    ORDER BY ep_dateadd ASC
    LIMIT 1");

// Newest Subjective Results
$subj2 = $db->getRow("SELECT ep_eadd, ep_sadd, ep_eladd, sleep_qualadd
    FROM dentalsummfu
    WHERE patientid = '$patientId'
    ORDER BY ep_dateadd DESC
    LIMIT 1");

// Delay Reason and Description

$delay = $db->getRow("SELECT delay_reason AS reason, description
    FROM dental_flow_pg2_info
    WHERE patientid = '$patientId'
        AND segmentid = 5
    ORDER BY date_completed DESC, id DESC
    LIMIT 1");

// Select BMI
$bmi = $db->getColumn("SELECT bmi
    FROM dental_patients
    WHERE patientid = '$patientId'", 'bmi');

// Reason seeking treatment
$reason_seeking_tx = $db->getColumn("SELECT reason_seeking_tx
    FROM dental_summary
    WHERE patientid = '$patientId'", 'reason_seeking_tx');

$reason_seeking_tx = $db->getColumn("SELECT chief_complaint_text
    FROM dental_q_page1
    WHERE patientid = '$patientId'", 'chief_complaint_text');

$q1_myarray = $db->getRow("SELECT *
    FROM dental_q_page1
    WHERE patientid = '$patientId'");

$main_reason = st($q1_myarray['main_reason']);
$main_reason_other = st($q1_myarray['main_reason_other']);
$complaintid = st($q1_myarray['complaintid']);

if ($complaintid <> '') {
    $chief_arr = explode('~', $complaintid);

    if (count($chief_arr) <> 0) {
        $c_count = 0;

        foreach ($chief_arr as $c_val) {
            if (trim($c_val) != '') {
                $c_s = explode('|', $c_val);
                $c_id[$c_count] = $c_s[0];
                $c_seq[$c_count] = $c_s[1];
                $c_count++;
            }
        }
    }

    asort($c_seq);

    foreach ($c_seq as $i => $val) {
        $eachId = $db->escape($c_id[$i]);
        $comp_value = $db->getColumn("SELECT complaint
            FROM dental_complaint
            WHERE status = 1
                AND complaintid = '$eachId'", 'complaint');

        if (trim($comp_value) != '') {
            $reason_seeking_tx .= ", " . $comp_value;
        }
    }
}

// Symptoms
$complaintid = $db->getColumn("SELECT complaintid
    FROM dental_q_page1
    WHERE patientid = '$patientId'
    LIMIT 1", 'complaintid');
$complaint = explode('~', rtrim($complaintid, '~'));
$compid = [];

foreach ($complaint as $pair) {
    $idscore = explode('|', $pair);
    $compid []= $idscore[0];
}

foreach ($compid as $id) {
    $result = $db->getResults("SELECT complaint
        FROM dental_complaint
        WHERE complaintid = '" . $db->escape($id) . "'");

    foreach ($result as $row) {
        $symptoms []= $row['complaint'];
    }
}

if (!isset($symptom_list)) {
    $symptom_list = '';
}

if (!empty($symptoms)) {
    foreach ($symptoms as $key => $value) {
        if ($key != count($symptoms) - 1 && $key != count($symptoms) - 2) {
            $symptom_list .= $value . ', ';
        } elseif ($key == count($symptoms) - 2) {
            $symptom_list .= $value . ' and ';
        } else {
            $symptom_list .= $value;
        }
    }
}

// Nights per Week and Current ESS TSS
$followup = $db->getRow("SELECT nightsperweek, ep_eadd, ep_tsadd
    FROM dentalsummfu
    WHERE patientid = '$patientId'
    ORDER BY ep_dateadd DESC
    LIMIT 1");

// Nights per Week and Current ESS TSS
$initesstss_query = $db->getRow("SELECT ess, tss
    FROM dental_q_page1
    WHERE patientid = '$patientId'
    LIMIT 1");

$initess = $initesstss_query['ess'];
$inittss = $initesstss_query['tss'];

// Non Compliance Reason and Description
$noncomp = $db->getRow("SELECT noncomp_reason AS reason, description
    FROM dental_flow_pg2_info
    WHERE patientid = '$patientId'
        AND segmentid = 9
    ORDER BY date_completed DESC, id DESC
    LIMIT 1");

$sign = $db->getRow("SELECT *
    FROM dental_user_signatures
    WHERE user_id = '$userId'
    ORDER BY adddate DESC
    LIMIT 1");
$signature_file = "signature_{$userId}_{$sign['id']}.png";

/**
 * Doctor related information
 */
$companyId = $db->getColumn("SELECT companyid FROM dental_user_company WHERE userid = '$docId'", 'companyid');

$franchisee_info = $db->getRow("SELECT
        user_type,
        mailing_name AS name,
        mailing_practice AS practice,
        mailing_address AS address,
        mailing_city AS city,
        mailing_state AS state,
        mailing_zip AS zip,
        email, use_digital_fax, use_letter_header,
        fax, indent_address, header_space
    FROM dental_users
    WHERE userid = '$docId'");

if ($franchisee_info['user_type'] == DSS_USER_TYPE_SOFTWARE) {
    $use_letter_header = $franchisee_info['use_letter_header'];
    $indent_address = $franchisee_info['indent_address'];
    $header_space = $franchisee_info['header_space'];
} else {
    $use_letter_header = true;
    $indent_address = true;
    $header_space = true;
}

$loc_r = $db->getColumn("SELECT location
    FROM dental_summary
    WHERE patientid = '$patientId'", 'location');

if ($patientId && !empty($loc_r)) {
    $location_query = "SELECT *
        FROM dental_locations
        WHERE id = '$loc_r'
            AND docid = '$docId'";
} else {
    $location_query = "SELECT *
        FROM dental_locations
        WHERE default_location = 1
            AND docid = '$docId'";
}

$location_info = $db->getRow($location_query);
$company_info = $db->getRow("SELECT c.*
    FROM companies c
        JOIN dental_user_company uc ON c.id = uc.companyid
    WHERE uc.userid = '$docId'");

/**
 * Main letter query
 */
$master_c = $db->getResults("SELECT *
    FROM dental_letters l
    WHERE (
            l.letterid = '$parentLetterId'
            OR l.parentid = '$parentLetterId'
        )
        AND status = '$parent_status'
        AND deleted = 0
    ORDER BY edit_date DESC");
$master_q = $master_c;

$master_num = 0;
$cur_letter_num = 0;
$cur_template_num = 0;

//TO COUNT NUMBER OF LETTERS
foreach ($master_c as $master_r) {
    $letterid = $master_r['letterid'];

    $othermd_query = "SELECT md_list, md_referral_list, pat_referral_list
        FROM dental_letters
        WHERE letterid = '$letterid'
        ORDER BY letterid ASC";

    $othermd_result = $db->getResults($othermd_query);
    $md_array = [];
    $md_referral_array = [];
    $pat_referral_array = [];

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

    if ($master_r['topatient']) {
        $master_num++;
    }
}

?>
<script language="javascript" type="text/javascript" src="/manage/3rdParty/tinymce4/tinymce.min.js"></script>
<script type="text/javascript" src="/manage/js/edit_letter.js?v=20170221"></script>
<script>
    var pageSize = <?= json_encode($pageSize) ?>;
    var pageMargins = <?= json_encode($margins) ?>;
</script>
<link type="text/css" rel="stylesheet" href="/manage/css/font-preview.css?v=<?= time() ?>"/>
<style>
    /* Preview area display */
    div.preview-letter {
        width: <?= formatMm($pageSize['width']) ?>;
        min-height: <?= formatMm($pageSize['height']) ?>;
    }

    div.preview-letter div.preview-wrapper {
        margin-top: <?= formatMm($margins['top']) ?>;
        margin-right: <?= formatMm($margins['right']) ?>;
        margin-bottom: <?= formatMm($margins['bottom']) ?>;
        margin-left: <?= formatMm($margins['left']) ?>;
    }

    div.preview-letter div.preview-page-break {
        width: <?= formatMm($pageSize['width']) ?>;
        top: <?= formatMm($pageSize['height'] - $margins['bottom']) ?>;
    }

    div.preview-letter div.preview-bottom-margin {
        width: <?= formatMm($pageSize['width']) ?>;
        height: <?= formatMm($margins['bottom']) ?>;
    }

    <?php for ($n=2; $n <=0; $n++) { ?>
    div.preview-letter div.preview-page-break.break-<?= $n ?> {
        top: <?= formatMm(($pageSize['height'] - $margins['top'] - $margins['bottom'])*$n + $margins['top']) ?>;
    }

    <?php } ?>
    /* Preview area display */
</style>
<?php

/**
 * START Letter loop
 */
foreach ($master_q as $master_r) {
    $letterid = $master_r['letterid'];

    // Select Letter
    $letter_query = "SELECT
            l.templateid, l.patientid, l.topatient, l.cc_topatient,
            l.md_list, l.md_referral_list, l.pat_referral_list, l.cc_pat_referral_list,
            l.template, l.send_method, l.status, l.docid, u.username,
            l.edit_date, l.template_type, l.font_size, l.font_family
        FROM dental_letters l
            LEFT JOIN dental_users u ON u.userid = l.edit_userid
        WHERE l.letterid = '$letterid'";

    $row = $db->getRow($letter_query);
    $letterRow = $row;

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
    $altered_template = html_entity_decode($row['template'], ENT_COMPAT | ENT_IGNORE, "UTF-8");

    $method = $row['send_method'];
    $status = $row['status'];
    $username = $row['username'];
    $edit_date = $row['edit_date'];
    $template_type = $row['template_type'];
    $font_size = $row['font_size'];
    $font_family = $row['font_family'];

    // Pending and Sent Contacts
    $othermd_query = "SELECT
            md_list, md_referral_list, cc_md_list,
            cc_md_referral_list, pat_referral_list, cc_pat_referral_list
        FROM dental_letters
        WHERE letterid = '$letterid'
        ORDER BY letterid ASC";

    $othermd_result = $db->getResults($othermd_query);
    $md_array = [];
    $md_referral_array = [];
    $pat_referral_array = [];

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
        } elseif ($row['pat_referral_list'] != null) {
            $pat_referral_array = array_merge($pat_referral_array, explode(",", $row['pat_referral_list']));
        }

    }

    $full_md_list = implode(",", $md_array);
    $full_md_referral_list = implode(",", $md_referral_array);
    $full_pat_referral_list = implode(",", $pat_referral_array);
    $contacts = get_contact_info('', $full_md_list, $full_md_referral_list, $full_pat_referral_list);
    $md_contacts = [];

    if (!empty($contacts['mds'])) foreach ($contacts['mds'] as $contact) {
        $md_contacts[] = array_merge(['type' => 'md'], $contact);
    }

    if (!empty($contacts['md_referrals'])) foreach ($contacts['md_referrals'] as $contact) {
        $md_contacts[] = array_merge(['type' => 'md_referral'], $contact);
    }

    if (!empty($contacts['pat_referrals'])) foreach ($contacts['pat_referrals'] as $contact) {
        $md_contacts[] = array_merge(['type' => 'pat_referral'], $contact);
    }

    // Get Letter Subject
    if ($template_type == '0') {
        $template_query = "SELECT name
            FROM dental_letter_templates
            WHERE id = '$templateid'";
    } else {
        $template_query = "SELECT name
            FROM dental_letter_templates_custom
            WHERE id = '$templateid'";
    }

    $title = $db->getColumn($template_query, 'name');

    if ($status == DSS_LETTER_PENDING) {
        $f_sql = "SELECT *
            FROM dental_faxes
            WHERE letterid = '$letterid'";

        $f_q = $db->getResults($f_sql);
        if ($f_q) foreach ($f_q as $f_r) {
            ?>
            <div class="warning" id="fax_alert_<?php echo $f_r['id']; ?>">
                This letter failed to send via digital fax to <a href="#"
                                                                 onclick="loadPopup('add_contact.php?ed=<?php echo $f_r['contactid']; ?>');return false;"><?php echo $f_r['to_name']; ?></a>
                at <a href="#"
                      onclick="loadPopup('add_contact.php?ed=<?php echo $f_r['contactid']; ?>');return false;"><?php echo format_phone($f_r['to_number']); ?></a>
                Please check fax number and retry, or change delivery method. Click <a
                    href="manage_faxes.php?status=3&viewed=0#fax">here</a> to view full failure details.
            </div>
            <br/><br/>
        <?php }
    }

    if ($topatient) {
        $contact_info = get_contact_info($patientid, $md_list, $md_referral_list, $pat_referral_list);
    } else {
        $contact_info = get_contact_info('', $md_list, $md_referral_list, $pat_referral_list);
    }

    if ($source == DSS_REFERRED_PHYSICIAN) {
        $md_referral = get_mdreferralids($_GET['pid']);
        $ref_info = get_contact_info('', '', $md_referral_list, $source);
        if (!empty($ref_info['md_referrals'])) {
            if (is_physician($ref_info['md_referrals'][0]['contacttypeid'])) {
                $referral_fullname = $ref_info['md_referrals'][0]['salutation'] . " " . $ref_info['md_referrals'][0]['firstname'] . " " . $ref_info['md_referrals'][0]['lastname'];
            } else {
                $referral_fullname = '';
            }
        } elseif (!empty($pcp)) {
            if (is_physician($ref_info['pcp']['contacttypeid'])) {
                $referral_fullname = $pcp['salutation'] . " " . $pcp['firstname'] . " " . $pcp['lastname'];
            } else {
                $referral_fullname = '';
            }
        } else {
            $referral_fullname = '';
        }
    } elseif ($source == DSS_REFERRED_PATIENT) {
        $referral_fullname = 'a patient';
    } elseif ($source == DSS_REFERRED_MEDIA) {
        $referral_fullname = 'a media source';
    } elseif ($source == DSS_REFERRED_FRANCHISE) {
        $referral_fullname = 'an internal source';
    } elseif ($source == DSS_REFERRED_DSSOFFICE) {
        $referral_fullname = "Dental Sleep Solutions' referral network";
    } elseif ($source == DSS_REFERRED_OTHER) {
        $referral_fullname = 'an unspecified source';
    } else {
        $referral_fullname = '';
    }

    $pt_referral = get_ptreferralids($_GET['pid'], true);
    $ptref_info = get_contact_info('', '', $pt_referral, $source);

    $letter_contacts = [];

    if (!empty($contact_info['patient'])) foreach ($contact_info['patient'] as $contact) {
        $letter_contacts[] = array_merge(['type' => 'patient'], $contact);
    }

    if (!empty($contact_info['md_referrals'])) foreach ($contact_info['md_referrals'] as $contact) {
        $letter_contacts[] = array_merge(['type' => 'md_referral'], $contact);
    }

    if (!empty($contact_info['pat_referrals'])) foreach ($contact_info['pat_referrals'] as $contact) {
        $letter_contacts[] = array_merge(['type' => 'pat_referral'], $contact);
    }

    if (!empty($contact_info['mds'])) foreach ($contact_info['mds'] as $contact) {
        $letter_contacts[] = array_merge(['type' => 'md'], $contact);
    }

    $numletters = count($letter_contacts);

    if (!empty($contact_info['mds'])) foreach ($contact_info['mds'] as $contact) {
        if ($contact['id'] == $docpcp) {
            $pcp = $contact;
        }
    }

    // Load $template
    if ($template_type == '0') {
        $letter_sql = "SELECT body
            FROM dental_letter_templates
            WHERE companyid = '$companyId'
                AND triggerid = '" . $db->escape($templateid) . "'";
    } else {
        $letter_sql = "SELECT body
            FROM dental_letter_templates_custom
            WHERE id = '" . $db->escape($templateid) . "'";
    }

    $template = $db->getColumn($letter_sql, 'body');
    $orig_template = $template;
    $header = '';

    if ($use_letter_header == "1") {
        $header .= $letterHeader;

        if ($header_space) {
            $header .= $emptyParagraph;
        }
    }

    $header .= $letterDate;

    if ($header_space) {
        $header .= $emptyParagraph;
    }

    $header .= $indent_address == '1' ? $letterIndentedAddress : $letterUnindentedAddress;
    $header .= "<br />";

    $orig_header = $header;
    $template = $header . $template;
    $orig_template = $header . $orig_template;

    if (!empty($altered_template) && !isset($_POST['reset_letter'])) {
        $template = $altered_template;
    }

    if (!empty($_POST)) {
        if (!empty($_POST['duplicate_letter'])) {
            foreach ($_POST['duplicate_letter'] as $key => $value) {
                $dupekey = $key;
            }
        }

        // Check for updated templates search and replace 1 of 2
        foreach ($letter_contacts as $key => $contact) {
            /**
             * START SEARCH/REPLACE
             */
            $search = [];
            $replace = [];
            $search[] = '%todays_date%';
            $replace[] = $todays_date;
            $search[] = '%contact_salutation%';
            $replace[] = $contact['salutation'];
            $search[] = '%contact_fullname%';
            $replace[] = $contact['salutation'] . " " . $contact['firstname'] . " " . $contact['lastname'];
            $search[] = '%contact_firstname%';
            $replace[] = $contact['firstname'];
            $search[] = '%contact_lastname%';
            $replace[] = $contact['lastname'];
            $search[] = "%salutation%";
            $replace[] = $letter_contacts[$key]['salutation'];
            $search[] = '%practice%';
            $replace[] = ($letter_contacts[$key]['company']) ? $letter_contacts[$key]['company'] . "<br />" : "";
            $search[] = '%contact_email%';
            $replace[] = $letter_contacts[$key]['email'];
            $search[] = '%addr1%';
            $replace[] = $contact['add1'];
            $search[] = '%addr2%';
            $replace[] = ($contact['add2']) ? ", " . $contact['add2'] : "";
            $search[] = '%insurance_id%';
            $replace[] = (!empty($patient_info['p_m_ins_id']) ? $patient_info['p_m_ins_id'] : '');
            $search[] = '%city%';
            $replace[] = $contact['city'];
            $search[] = '%state%';
            $replace[] = $contact['state'];
            $search[] = '%zip%';
            $replace[] = $contact['zip'];
            $search[] = '%referral_fullname%';

            if ($contact['type'] == 'md_referral' && $contact['id'] == $ref_info['md_referrals'][0]['id']) {
                $replace[] = "you";
            } else {
                $replace[] = $referral_fullname;
            }

            $search[] = '%by_referral_fullname%';
            if ($contact['type'] == 'md_referral' && $contact['id'] == $ref_info['md_referrals'][0]['id']) {
                $replace[] = "by you";
            } else {
                if (trim($referral_fullname) != '') {
                    $replace[] = "by " . $referral_fullname;
                } else {
                    $replace[] = '';
                }
            }

            $search[] = '%referral_lastname%';
            if (!empty($ref_info['md_referrals'])) {
                $replace[] = $ref_info['md_referrals'][0]['lastname'];
            } else {
                $replace[] = (!empty($pcp['lastname']) ? $pcp['lastname'] : '');
            }

            $search[] = '%referral_practice%';
            if (!empty($ref_info['md_referrals'])) {
                $replace[] = ($ref_info['md_referrals'][0]['company']) ? $ref_info['md_referrals'][0]['company'] . "<br />" : "";
            } else {
                $replace[] = !empty($pcp['company']) ? $pcp['company'] . "<br />" : "";
            }

            $search[] = '%ref_addr1%';
            if (!empty($ref_info['md_referrals'])) {
                $replace[] = $ref_info['md_referrals'][0]['add1'];
            } else {
                $replace[] = (!empty($pcp['add1']) ? $pcp['add1'] : '');
            }

            $search[] = '%ref_addr2%';
            if (!empty($ref_info['md_referrals'])) {
                $replace[] = ($ref_info['md_referrals'][0]['add2']) ? $ref_info['md_referrals'][0]['add2'] : "";
            } else {
                $replace[] = !empty($pcp['add2']) ? $pcp['add2'] : "";
            }

            $search[] = '%ref_city%';
            if (!empty($ref_info['md_referrals'])) {
                $replace[] = $ref_info['md_referrals'][0]['city'];
            } else {
                $replace[] = (!empty($pcp['city']) ? $pcp['city'] : '');
            }

            $search[] = '%ref_state%';
            if (!empty($ref_info['md_referrals'])) {
                $replace[] = $ref_info['md_referrals'][0]['state'];
            } else {
                $replace[] = (!empty($pcp['state']) ? $pcp['state'] : '');
            }

            $search[] = '%ref_zip%';
            if (!empty($ref_info['md_referrals'])) {
                $replace[] = $ref_info['md_referrals'][0]['zip'];
            } else {
                $replace[] = (!empty($pcp['zip']) ? $pcp['zip'] : '');
            }

            $search[] = '%ptreferral_fullname%';
            if (!empty($ptref_info['md_referrals'])) {
                if ($contact['type'] == 'md_referral' && $contact['id'] == $ref_info['md_referrals'][0]['id']) {
                    $replace[] = "you";
                } else {
                    $replace[] = trim($ptref_info['md_referrals'][0]['salutation'] . " " . $ptref_info['md_referrals'][0]['firstname'] . " " . $ptref_info['md_referrals'][0]['lastname']);
                }
            } else {
                $replace[] = "";
            }

            $search[] = '%ptreferral_firstname%';
            if (!empty($ptref_info['md_referrals'])) {
                $replace[] = $ptref_info['md_referrals'][0]['firstname'];
            } else {
                $replace[] = "";
            }

            $search[] = '%ptreferral_lastname%';
            if (!empty($ptref_info['md_referrals'])) {
                $replace[] = $ptref_info['md_referrals'][0]['lastname'];
            } else {
                $replace[] = "";
            }

            $search[] = '%ptreferral_practice%';
            if (!empty($ptref_info['md_referrals'])) {
                $replace[] = ($ptref_info['md_referrals'][0]['company']) ? $ptref_info['md_referrals'][0]['company'] . "<br />" : "";
            } else {
                $replace[] = "";
            }

            $search[] = '%ptref_addr1%';
            if (!empty($ptref_info['md_referrals'])) {
                $replace[] = $ptref_info['md_referrals'][0]['add1'];
            } else {
                $replace[] = "";
            }

            $search[] = '%ptref_addr2%';
            if (!empty($ptref_info['md_referrals'])) {
                $replace[] = ($ptref_info['md_referrals'][0]['add2']) ? $ptref_info['md_referrals'][0]['add2'] : "";
            } else {
                $replace[] = "";
            }

            $search[] = '%ptref_city%';
            if (!empty($ptref_info['md_referrals'])) {
                $replace[] = $ptref_info['md_referrals'][0]['city'];
            } else {
                $replace[] = "";
            }

            $search[] = '%ptref_state%';
            if (!empty($ptref_info['md_referrals'])) {
                $replace[] = $ptref_info['md_referrals'][0]['state'];
            } else {
                $replace[] = "";
            }

            $search[] = '%ptref_zip%';
            if (!empty($ptref_info['md_referrals'])) {
                $replace[] = $ptref_info['md_referrals'][0]['zip'];
            } else {
                $replace[] = "";
            }

            $search[] = "%company%";
            $replace[] = $company_info['name'];
            $search[] = "%company_addr%";
            $replace[] = nl2br($company_info['add1'] . " " . $company_info['add2']) . "<br />" . $company_info['city'] . ", " . $company_info['state'] . " " . $company_info['zip'];
            $search[] = "%franchisee_fullname%";
            $replace[] = $location_info['name'];
            $search[] = "%doctor_fullname%";
            $replace[] = $location_info['name'];
            $search[] = "%franchisee_lastname%";
            $replace[] = array_get(explode(' ', $location_info['name']), '0');
            $search[] = "%doctor_lastname%";
            $replace[] = array_get(explode(' ', $location_info['name']), '1');
            $search[] = "%franchisee_practice%";
            $replace[] = $location_info['location'];
            $search[] = "%doctor_practice%";
            $replace[] = $location_info['location'];
            $search[] = "%franchisee_phone%";
            $replace[] = format_phone($location_info['phone']);
            $search[] = "%doctor_phone%";
            $replace[] = format_phone($location_info['phone']);
            $search[] = "%franchisee_addr%";
            $replace[] = nl2br($location_info['address']) . "<br />" . $location_info['city'] . ", " . $location_info['state'] . " " . $location_info['zip'];
            $search[] = "%doctor_addr%";
            $replace[] = nl2br($location_info['address']) . "<br />" . $location_info['city'] . ", " . $location_info['state'] . " " . $location_info['zip'];
            $search[] = "%signature_image%";
            $replace[] = "<img src=\"display_file.php?f=" . $signature_file . "\" />";
            $search[] = "%patient_fullname%";
            $replace[] = (!empty($patient_info['firstname']) ? $patient_info['firstname'] : '') . " " . (!empty($patient_info['lastname']) ? $patient_info['lastname'] : '');
            $search[] = "%patient_titlefullname%";
            $replace[] = (!empty($patient_info['salutation']) ? $patient_info['salutation'] : '') . " " . (!empty($patient_info['firstname']) ? $patient_info['firstname'] : '') . " " . (!empty($patient_info['lastname']) ? $patient_info['lastname'] : '');
            $search[] = "%patient_lastname%";
            $replace[] = (!empty($patient_info['salutation']) ? $patient_info['salutation'] : '') . " " . (!empty($patient_info['lastname']) ? $patient_info['lastname'] : '');
            $search[] = "%ccpatient_fullname%";

            if ($topatient && $contact['type'] != 'patient') {
                $replace[] = $patient_info['salutation'] . " " . $patient_info['firstname'] . " " . $patient_info['lastname'];
            } else {
                $replace[] = "";
            }

            $search[] = "%patient_dob%";
            $replace[] = (!empty($patient_info['dob']) ? $patient_info['dob'] : '');
            $search[] = "%patient_firstname%";
            $replace[] = (!empty($patient_info['firstname']) ? $patient_info['firstname'] : '');
            $search[] = "%patient_age%";
            $replace[] = (!empty($patient_info['age']) ? $patient_info['age'] : '');
            $search[] = "%patient_gender%";
            $replace[] = strtolower(!empty($patient_info['gender']) ? $patient_info['gender'] : '');
            $search[] = "%patient_photo%";

            if ($patient_photo != '') {
                $replace[] = "<img align=\"right\" src=\"display_file.php?f=" . $patient_photo . "\" />";
            } else {
                $replace[] = "";
            }

            $search[] = "%His/Her%";
            $replace[] = (!empty($patient_info['gender']) && $patient_info['gender'] == "Male" ? "His" : "Her");
            $search[] = "%his/her%";
            $replace[] = (!empty($patient_info['gender']) && $patient_info['gender'] == "Male" ? "his" : "her");
            $search[] = "%he/she%";
            $replace[] = (!empty($patient_info['gender']) && $patient_info['gender'] == "Male" ? "he" : "she");
            $search[] = "%him/her%";
            $replace[] = (!empty($patient_info['gender']) && $patient_info['gender'] == "Male" ? "him" : "her");
            $search[] = "%He/She%";
            $replace[] = (!empty($patient_info['gender']) && $patient_info['gender'] == "Male" ? "He" : "She");
            $search[] = "%history%";
            $replace[] = $history_disp;
            $search[] = "%historysentence%";

            if ($history_disp != '') {
                $replace[] = " with a PMH that includes " . $history_disp;
            } else {
                $replace[] = '';
            }

            $search[] = "%medications%";
            $replace[] = $medications_disp;
            $search[] = "%medicationssentence%";

            if ($medications_disp != '') {
                $replace[] = (!empty($patient_info['gender']) && $patient_info['gender'] == "Male" ? "His" : "Her") . " medications include " . $medications_disp . ".";
            } else {
                $replace[] = "";
            }

            $search[] = "%1st_sleeplab_name%";
            $replace[] = $first_sleeplab_name;
            $search[] = "%2nd_sleeplab_name%";
            $replace[] = $sleeplab_name;
            $search[] = "%type_study%";
            $replace[] = $first_type_study;
            $search[] = "%ahi%";
            $replace[] = $first_ahi;
            $search[] = "%diagnosis%";
            $replace[] = $first_diagnosis;
            $search[] = "%1ststudy_date%";
            $replace[] = $first_study_date;
            $search[] = "%completed_sleeplab_name%";
            $replace[] = $completed_sleeplab_name;
            $search[] = "%completed_type_study%";
            $replace[] = $completed_type_study;
            $search[] = "%completed_ahi%";
            $replace[] = $completed_ahi;
            $search[] = "%completed_diagnosis%";
            $replace[] = $completed_diagnosis;
            $search[] = "%completed_study_date%";
            $replace[] = $completed_study_date;
            $search[] = "%1stRDI%";
            $replace[] = $first_rdi;
            $search[] = "%1stRDI/AHI%";
            $replace[] = $first_rdi . "/" . $first_ahi;
            $search[] = "%1stLowO2%";
            $replace[] = $first_o2nadir;
            $search[] = "%1stTO290%";
            $replace[] = $first_o2sat90;
            $search[] = "%2ndtype_study%";
            $replace[] = $second_type_study;
            $search[] = "%2ndahi%";
            $replace[] = $second_ahi;
            $search[] = "%2ndahisupine%";
            $replace[] = $second_ahisupine;
            $search[] = "%2ndrdi%";
            $replace[] = $second_rdi;
            $search[] = "%2ndO2Sat90%";
            $replace[] = $second_o2sat90;
            $search[] = "%2ndstudy_date%";
            $replace[] = $second_study_date;
            $search[] = "%2ndRDI/AHI%";
            $replace[] = $second_rdi . "/" . $second_ahi;
            $search[] = "%2ndLowO2%";
            $replace[] = $second_o2nadir;
            $search[] = "%2ndTO290%";
            $replace[] = $second_o2sat90;
            $search[] = "%2nddiagnosis%";
            $replace[] = $second_diagnosis;
            $search[] = "%delivery_date%";
            $replace[] = $delivery_date;
            $search[] = "%dental_device%";
            $replace[] = $dentaldevice;
            $search[] = "%1stESS%";
            $replace[] = $subj1['ep_eadd'];
            $search[] = "%1stSnoring%";
            $replace[] = $subj1['ep_sadd'];
            $search[] = "%1stEnergy%";
            $replace[] = $subj1['ep_eladd'];
            $search[] = "%1stQuality%";
            $replace[] = $subj1['sleep_qualadd'];
            $search[] = "%2ndESS%";
            $replace[] = (!empty($subj2['ep_eadd']) ? $subj2['ep_eadd'] : '');
            $search[] = "%2ndSnoring%";
            $replace[] = (!empty($subj2['ep_sadd']) ? $subj2['ep_sadd'] : '');
            $search[] = "%2ndEnergy%";
            $replace[] = (!empty($subj2['ep_eladd']) ? $subj2['ep_eladd'] : '');
            $search[] = "%2ndQuality%";
            $replace[] = (!empty($subj2['sleep_qualadd']) ? $subj2['sleep_qualadd'] : '');
            $search[] = "%bmi%";
            $replace[] = $bmi;
            $search[] = "%reason_seeking_tx%";
            $replace[] = $reason_seeking_tx;
            $search[] = "%patprogress%";

            if ($contact['type'] == 'patient') {
                $replace[] = "<p>We work hard to keep your doctors up-to-date on your progress in order to help you receive better, more thorough, and more accurate care from all your physicians. We appreciate your cooperation and patronage. Below is a copy of correspondence mailed to the treating physicians we have on file for you; this copy is being sent to you for your records:</p>";
            } else {
                $replace[] = '';
            }

            $search[] = "%tyreferred%";

            if ($contact['type'] == 'md_referral') {
                $replace[] = "Thank you for referring " . $patient_info['salutation'] . " " . $patient_info['firstname'] . " " . $patient_info['lastname'] . " to our office for treatment with a dental sleep device.";
            } else {
                $replace[] = "Our mutual patient, " . (!empty($patient_info['salutation']) ? $patient_info['salutation'] : '') . " " . (!empty($patient_info['firstname']) ? $patient_info['firstname'] : '') . " " . (!empty($patient_info['lastname']) ? $patient_info['lastname'] : '') . ", was referred to our office for treatment with a dental sleep device.";
            }

            $search[] = "%symptoms%";
            $replace[] = $symptom_list;
            $search[] = "%nightsperweek%";
            $replace[] = (!empty($followup['nightsperweek']) ? $followup['nightsperweek'] : '');
            $search[] = "%esstssupdate%";

            if (!empty($followup['ep_eadd']) || !empty($followup['ep_tsadd'])) {
                $replace[] = ($patient_info['gender'] == "Male" ? "His" : "Her") . " Epworth Sleepiness Scale / Thornton Snoring Scale has changed from " . $initess . "/" . $inittss . " to " . $followup['ep_eadd'] . "/" . $followup['ep_tsadd'] . ".";
            } else {
                $replace[] = '';
            }

            $search[] = "%currESS/TSS%";
            $replace[] = (!empty($followup['ep_eadd']) ? $followup['ep_eadd'] : '') . "/" . (!empty($followup['ep_tsadd']) ? $followup['ep_tsadd'] : '');
            $search[] = "%initESS/TSS%";
            $replace[] = $initess . "/" . $inittss;
            $search[] = "%patient_email%";
            $replace[] = (!empty($patient_info['email']) ? $patient_info['email'] : '');
            $search[] = "%consult_date%";
            $replace[] = $consult_date;
            $search[] = "%impressions_date%";
            $replace[] = $impressions_date;
            $search[] = "%sleeplab_name%";
            $replace[] = $sleeplab_name;
            $search[] = "%delay_reason%";

            switch ($delay['reason']) {
                case 'insurance':
                    $replace[] = "insurance problems or issues";
                    break;
                case 'dental work':
                    $replace[] = "additional pending dental work";
                    break;
                case 'deciding':
                    $replace[] = "personal decision";
                    break;
                case 'sleep study':
                    $replace[] = "a pending sleep study";
                    break;
                case 'other':
                    if ($delay['description'] == '') {
                        $replace[] = "(warning: other was selected, but no info provided)";
                    } else {
                        $replace[] = $delay['description'];
                    }
                    break;
                default:
                    $replace[] = "(warning: no reason has been selected)";
            }

            $search[] = "%noncomp_reason%";

            switch ($noncomp['reason']) {
                case 'pain/discomfort':
                    $replace[] = "pain and/or discomfort";
                    break;
                case 'lost device':
                    $replace[] = "the device being lost and not replaced";
                    break;
                case 'device not working':
                    $replace[] = "patient claims that the device is not working properly or adequately";
                    break;
                case 'other':
                    if ($noncomp['description'] == '') {
                        $replace[] = "(warning: other was selected, but no info provided)";
                    } else {
                        $replace[] = $noncomp['description'];
                    }
                    break;
                default:
                    $replace[] = "(warning: no reason has been selected)";
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
            $replace[] = $other_mds;
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
                $replace[] = $nonpcp_mds;
            } else {
                $replace[] = $other_mds;
            }
            /**
             * END SEARCH/REPLACE
             */

            $new_template[$cur_template_num] = restorePlaceholders($_POST['letter' . $cur_template_num]);

            if ($new_template[$cur_template_num] == null && !empty($_POST['new_template'][$cur_template_num])) {
                $new_template[$cur_template_num] = html_entity_decode($_POST['new_template'][$cur_template_num], ENT_COMPAT | ENT_QUOTES, 'UTF-8');
            }

            // Template hasn't changed
            if ($new_template[$cur_template_num] == $orig_template) {
                $new_template[$cur_template_num] = null;
            }

            $cur_template_num++;
        }

        // Duplicate Letter Template
        if (isset($_POST['duplicate_letter']) && empty($duplicated) && !empty($new_template) && !empty($dupekey)) {
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
                $new_template[$resetid] = null;
            }

            reset_letter($letterid);

            ?>
            <script type="text/javascript">
                window.location = window.location;
            </script>
            <?php
            trigger_error('Die called', E_USER_ERROR);
        }
    }

    ?>
    <form
        action="?pid=<?= $patientId ?>&lid=<?= $parentLetterId ?>&goto=<?= urlencode(array_get($_REQUEST, 'goto')) ?><?= empty($isBackOffice) ? '' : '&backoffice=1' ?>"
        method="post" class="letter">
        <input type="hidden" name="numletters" value="<?= $numletters ?>"/>

        <?php

        /**
         * START Contact loop
         */
        foreach ($letter_contacts as $key => $contact) {
            /**
             * START SEARCH/REPLACE
             */
            $search = [];
            $replace = [];
            $search[] = '%todays_date%';
            $replace[] = $todays_date;
            $search[] = '%contact_salutation%';
            $replace[] = $contact['salutation'];
            $search[] = '%contact_fullname%';
            $replace[] = $contact['salutation'] . " " . $contact['firstname'] . " " . $contact['lastname'];
            $search[] = '%contact_firstname%';
            $replace[] = $contact['firstname'];
            $search[] = '%contact_lastname%';
            $replace[] = $contact['lastname'];
            $search[] = "%salutation%";
            $replace[] = $letter_contacts[$key]['salutation'];
            $search[] = '%practice%';
            $replace[] = !empty($letter_contacts[$key]['company']) ? $letter_contacts[$key]['company'] . "<br />" : "";
            $search[] = '%insurance_id%';
            $replace[] = (!empty($patient_info['p_m_ins_id']) ? $patient_info['p_m_ins_id'] : '');
            $search[] = '%contact_email%';
            $replace[] = $letter_contacts[$key]['email'];
            $search[] = '%addr1%';
            $replace[] = $contact['add1'];
            $search[] = '%addr2%';
            $replace[] = ($contact['add2']) ? ", " . $contact['add2'] : "";
            $search[] = '%city%';
            $replace[] = $contact['city'];
            $search[] = '%state%';
            $replace[] = $contact['state'];
            $search[] = '%zip%';
            $replace[] = $contact['zip'];
            $search[] = '%referral_fullname%';

            if ($contact['type'] == 'md_referral' && $contact['id'] == $ref_info['md_referrals'][0]['id']) {
                $replace[] = "you";
            } else {
                $replace[] = $referral_fullname;
            }

            $search[] = '%by_referral_fullname%';
            if ($contact['type'] == 'md_referral' && $contact['id'] == $ref_info['md_referrals'][0]['id']) {
                $replace[] = "by you";
            } else {
                if (trim($referral_fullname) != '') {
                    $replace[] = "by " . $referral_fullname;
                } else {
                    $replace[] = '';
                }
            }

            $search[] = '%referral_lastname%';
            if (!empty($ref_info['md_referrals'])) {
                $replace[] = $ref_info['md_referrals'][0]['lastname'];
            } else {
                $replace[] = (!empty($pcp['lastname']) ? $pcp['lastname'] : '');
            }

            $search[] = '%referral_practice%';
            if (!empty($ref_info['md_referrals'])) {
                $replace[] = ($ref_info['md_referrals'][0]['company']) ? $ref_info['md_referrals'][0]['company'] . "<br />" : "";
            } else {
                $replace[] = !empty($pcp['company']) ? $pcp['company'] . "<br />" : "";
            }

            $search[] = '%ref_addr1%';
            if (!empty($ref_info['md_referrals'])) {
                $replace[] = $ref_info['md_referrals'][0]['add1'];
            } else {
                $replace[] = (!empty($pcp['add1']) ? $pcp['add1'] : '');
            }

            $search[] = '%ref_addr2%';
            if (!empty($ref_info['md_referrals'])) {
                $replace[] = ($ref_info['md_referrals'][0]['add2']) ? $ref_info['md_referrals'][0]['add2'] : "";
            } else {
                $replace[] = !empty($pcp['add2']) ? $pcp['add2'] : "";
            }

            $search[] = '%ref_city%';
            if (!empty($ref_info['md_referrals'])) {
                $replace[] = $ref_info['md_referrals'][0]['city'];
            } else {
                $replace[] = (!empty($pcp['city']) ? $pcp['city'] : '');
            }

            $search[] = '%ref_state%';
            if (!empty($ref_info['md_referrals'])) {
                $replace[] = $ref_info['md_referrals'][0]['state'];
            } else {
                $replace[] = (!empty($pcp['state']) ? $pcp['state'] : '');
            }

            $search[] = '%ref_zip%';
            if (!empty($ref_info['md_referrals'])) {
                $replace[] = $ref_info['md_referrals'][0]['zip'];
            } else {
                $replace[] = (!empty($pcp['zip']) ? $pcp['zip'] : '');
            }

            $search[] = '%ptreferral_fullname%';
            if (!empty($ptref_info['md_referrals'])) {
                if ($contact['type'] == 'md_referral' && $contact['id'] == $ref_info['md_referrals'][0]['id']) {
                    $replace[] = "you";
                } else {
                    $replace[] = trim($ptref_info['md_referrals'][0]['salutation'] . " " . $ptref_info['md_referrals'][0]['firstname'] . " " . $ptref_info['md_referrals'][0]['lastname']);
                }
            } else {
                $replace[] = "";
            }

            $search[] = '%ptreferral_firstname%';
            if (!empty($ptref_info['md_referrals'])) {
                $replace[] = $ptref_info['md_referrals'][0]['firstname'];
            } else {
                $replace[] = "";
            }

            $search[] = '%ptreferral_lastname%';
            if (!empty($ptref_info['md_referrals'])) {
                $replace[] = $ptref_info['md_referrals'][0]['lastname'];
            } else {
                $replace[] = "";
            }

            $search[] = '%ptreferral_practice%';
            if (!empty($ptref_info['md_referrals'])) {
                $replace[] = ($ptref_info['md_referrals'][0]['company']) ? $ptref_info['md_referrals'][0]['company'] . "<br />" : "";
            } else {
                $replace[] = "";
            }

            $search[] = '%ptref_addr1%';
            if (!empty($ptref_info['md_referrals'])) {
                $replace[] = $ptref_info['md_referrals'][0]['add1'];
            } else {
                $replace[] = "";
            }

            $search[] = '%ptref_addr2%';
            if (!empty($ptref_info['md_referrals'])) {
                $replace[] = ($ptref_info['md_referrals'][0]['add2']) ? $ptref_info['md_referrals'][0]['add2'] : "";
            } else {
                $replace[] = "";
            }

            $search[] = '%ptref_city%';
            if (!empty($ptref_info['md_referrals'])) {
                $replace[] = $ptref_info['md_referrals'][0]['city'];
            } else {
                $replace[] = "";
            }

            $search[] = '%ptref_state%';
            if (!empty($ptref_info['md_referrals'])) {
                $replace[] = $ptref_info['md_referrals'][0]['state'];
            } else {
                $replace[] = "";
            }

            $search[] = '%ptref_zip%';
            if (!empty($ptref_info['md_referrals'])) {
                $replace[] = $ptref_info['md_referrals'][0]['zip'];
            } else {
                $replace[] = "";
            }

            $search[] = "%company%";
            $replace[] = $company_info['name'];
            $search[] = "%company_addr%";
            $replace[] = nl2br($company_info['add1'] . " " . $company_info['add2']) . "<br />" . $company_info['city'] . ", " . $company_info['state'] . " " . $company_info['zip'];
            $search[] = "%franchisee_fullname%";
            $replace[] = $location_info['name'];
            $search[] = "%doctor_fullname%";
            $replace[] = $location_info['name'];
            $search[] = "%franchisee_lastname%";
            $replace[] = array_get(explode(' ', $location_info['name']), '0');
            $search[] = "%doctor_lastname%";
            $replace[] = array_get(explode(' ', $location_info['name']), '1');
            $search[] = "%franchisee_practice%";
            $replace[] = $location_info['location'];
            $search[] = "%doctor_practice%";
            $replace[] = $location_info['location'];
            $search[] = "%franchisee_phone%";
            $replace[] = format_phone($location_info['phone']);
            $search[] = "%doctor_phone%";
            $replace[] = format_phone($location_info['phone']);
            $search[] = "%signature_image%";
            $replace[] = "<img src=\"display_file.php?f=" . $signature_file . "\" />";
            $search[] = "%franchisee_addr%";
            $replace[] = nl2br($location_info['address']) . "<br />" . $location_info['city'] . ", " . $location_info['state'] . " " . $location_info['zip'];
            $search[] = "%doctor_addr%";
            $replace[] = nl2br($location_info['address']) . "<br />" . $location_info['city'] . ", " . $location_info['state'] . " " . $location_info['zip'];
            $search[] = "%patient_fullname%";
            $replace[] = (!empty($patient_info['firstname']) ? $patient_info['firstname'] : '') . " " . (!empty($patient_info['lastname']) ? $patient_info['lastname'] : '');
            $search[] = "%patient_titlefullname%";
            $replace[] = (!empty($patient_info['salutation']) ? $patient_info['salutation'] : '') . " " . (!empty($patient_info['firstname']) ? $patient_info['firstname'] : '') . " " . (!empty($patient_info['lastname']) ? $patient_info['lastname'] : '');
            $search[] = "%patient_lastname%";
            $replace[] = (!empty($patient_info['salutation']) ? $patient_info['salutation'] : '') . " " . (!empty($patient_info['lastname']) ? $patient_info['lastname'] : '');
            $search[] = "%ccpatient_fullname%";

            if ($topatient && $contact['type'] != 'patient') {
                $replace[] = (!empty($patient_info['salutation']) ? $patient_info['salutation'] : '') . " " . (!empty($patient_info['firstname']) ? $patient_info['firstname'] : '') . " " . (!empty($patient_info['lastname']) ? $patient_info['lastname'] : '');
            } else {
                $replace[] = "";
            }

            $search[] = "%patient_dob%";
            $replace[] = (!empty($patient_info['dob']) ? $patient_info['dob'] : '');
            $search[] = "%patient_firstname%";
            $replace[] = (!empty($patient_info['firstname']) ? $patient_info['firstname'] : '');
            $search[] = "%patient_age%";
            $replace[] = (!empty($patient_info['age']) ? $patient_info['age'] : '');
            $search[] = "%patient_gender%";
            $replace[] = strtolower((!empty($patient_info['gender'])) ? $patient_info['gender'] : '');
            $search[] = "%patient_photo%";

            if ($patient_photo != '') {
                $replace[] = "<img style=\"float:right;\" src=\"display_file.php?f=" . $patient_photo . "\" />";
            } else {
                $replace[] = "";
            }

            $search[] = "%His/Her%";
            $replace[] = (!empty($patient_info['gender']) && $patient_info['gender'] == "Male" ? "His" : "Her");
            $search[] = "%his/her%";
            $replace[] = (!empty($patient_info['gender']) && $patient_info['gender'] == "Male" ? "his" : "her");
            $search[] = "%he/she%";
            $replace[] = (!empty($patient_info['gender']) && $patient_info['gender'] == "Male" ? "he" : "she");
            $search[] = "%him/her%";
            $replace[] = (!empty($patient_info['gender']) && $patient_info['gender'] == "Male" ? "him" : "her");
            $search[] = "%He/She%";
            $replace[] = (!empty($patient_info['gender']) && $patient_info['gender'] == "Male" ? "He" : "She");
            $search[] = "%history%";
            $replace[] = $history_disp;
            $search[] = "%historysentence%";

            if ($history_disp != '') {
                $replace[] = " with a PMH that includes " . $history_disp;
            } else {
                $replace[] = '';
            }

            $search[] = "%medications%";
            $replace[] = $medications_disp;
            $search[] = "%medicationssentence%";

            if ($medications_disp != '') {
                $replace[] = (!empty($patient_info['gender']) && $patient_info['gender'] == "Male" ? "His" : "Her") . " medications include " . $medications_disp . ".";
            } else {
                $replace[] = "";
            }

            $search[] = "%sleeplab_name%";
            $replace[] = $sleeplab_name;
            $search[] = "%1st_sleeplab_name%";
            $replace[] = $first_sleeplab_name;
            $search[] = "%2nd_sleeplab_name%";
            $replace[] = $sleeplab_name;
            $search[] = "%type_study%";
            $replace[] = $first_type_study;
            $search[] = "%ahi%";
            $replace[] = $first_ahi;
            $search[] = "%diagnosis%";
            $replace[] = $first_diagnosis;
            $search[] = "%1ststudy_date%";
            $replace[] = $first_study_date;
            $search[] = "%completed_sleeplab_name%";
            $replace[] = $completed_sleeplab_name;
            $search[] = "%completed_type_study%";
            $replace[] = $completed_type_study;
            $search[] = "%completed_ahi%";
            $replace[] = $completed_ahi;
            $search[] = "%completed_diagnosis%";
            $replace[] = $completed_diagnosis;
            $search[] = "%completed_study_date%";
            $replace[] = $completed_study_date;
            $search[] = "%1stRDI%";
            $replace[] = $first_rdi;
            $search[] = "%1stRDI/AHI%";
            $replace[] = $first_rdi . "/" . $first_ahi;
            $search[] = "%1stLowO2%";
            $replace[] = $first_o2nadir;
            $search[] = "%1stTO290%";
            $replace[] = $first_o2sat90;
            $search[] = "%2ndtype_study%";
            $replace[] = $second_type_study;
            $search[] = "%2ndahi%";
            $replace[] = $second_ahi;
            $search[] = "%2ndahisupine%";
            $replace[] = $second_ahisupine;
            $search[] = "%2ndrdi%";
            $replace[] = $second_rdi;
            $search[] = "%2ndO2Sat90%";
            $replace[] = $second_o2sat90;
            $search[] = "%2ndstudy_date%";
            $replace[] = $second_study_date;
            $search[] = "%2ndRDI/AHI%";
            $replace[] = $second_rdi . "/" . $second_ahi;
            $search[] = "%2ndLowO2%";
            $replace[] = $second_o2nadir;
            $search[] = "%2ndTO290%";
            $replace[] = $second_o2sat90;
            $search[] = "%2nddiagnosis%";
            $replace[] = $second_diagnosis;
            $search[] = "%delivery_date%";
            $replace[] = $delivery_date;
            $search[] = "%dental_device%";
            $replace[] = $dentaldevice;
            $search[] = "%1stESS%";
            $replace[] = $subj1['ep_eadd'];
            $search[] = "%1stSnoring%";
            $replace[] = $subj1['ep_sadd'];
            $search[] = "%1stEnergy%";
            $replace[] = $subj1['ep_eladd'];
            $search[] = "%1stQuality%";
            $replace[] = $subj1['sleep_qualadd'];
            $search[] = "%2ndESS%";
            $replace[] = (!empty($subj2['ep_eadd']) ? $subj2['ep_eadd'] : '');
            $search[] = "%2ndSnoring%";
            $replace[] = (!empty($subj2['ep_sadd']) ? $subj2['ep_sadd'] : '');
            $search[] = "%2ndEnergy%";
            $replace[] = (!empty($subj2['ep_eladd']) ? $subj2['ep_eladd'] : '');
            $search[] = "%2ndQuality%";
            $replace[] = (!empty($subj2['sleep_qualadd']) ? $subj2['sleep_qualadd'] : '');
            $search[] = "%bmi%";
            $replace[] = $bmi;
            $search[] = "%reason_seeking_tx%";
            $replace[] = $reason_seeking_tx;
            $search[] = "%patprogress%";

            if ($contact['type'] == 'patient') {
                $replace[] = "<p>We work hard to keep your doctors up-to-date on your progress in order to help you receive better, more thorough, and more accurate care from all your physicians. We appreciate your cooperation and patronage. Below is a copy of correspondence mailed to the treating physicians we have on file for you; this copy is being sent to you for your records:</p>";
            } else {
                $replace[] = '';
            }

            $search[] = "%tyreferred%";
            if ($contact['type'] == 'md_referral') {
                $replace[] = "Thank you for referring " . $patient_info['salutation'] . " " . $patient_info['firstname'] . " " . $patient_info['lastname'] . " to our office for treatment with a dental sleep device.";
            } else {
                $replace[] = "Our mutual patient, " . (!empty($patient_info['salutation']) ? $patient_info['salutation'] : '') . " " . (!empty($patient_info['firstname']) ? $patient_info['firstname'] : '') . " " . (!empty($patient_info['lastname']) ? $patient_info['lastname'] : '') . ", was referred to our office for treatment with a dental sleep device.";
            }

            $search[] = "%symptoms%";
            $replace[] = $symptom_list;
            $search[] = "%nightsperweek%";
            $replace[] = (!empty($followup['nightsperweek']) ? $followup['nightsperweek'] : '');
            $search[] = "%esstssupdate%";

            if (!empty($followup['ep_eadd']) || !empty($followup['ep_tsadd'])) {
                $replace[] = ($patient_info['gender'] == "Male" ? "His" : "Her") . " Epworth Sleepiness Scale / Thornton Snoring Scale has changed from " . $initess . "/" . $inittss . " to " . $followup['ep_eadd'] . "/" . $followup['ep_tsadd'] . ".";
            } else {
                $replace[] = '';
            }

            $search[] = "%currESS/TSS%";
            $replace[] = (!empty($followup['ep_eadd']) ? $followup['ep_eadd'] : '') . "/" . (!empty($followup['ep_tsadd']) ? $followup['ep_tsadd'] : '');
            $search[] = "%initESS/TSS%";
            $replace[] = $initess . "/" . $inittss;
            $search[] = "%patient_email%";
            $replace[] = (!empty($patient_info['email']) ? $patient_info['email'] : '');
            $search[] = "%consult_date%";
            $replace[] = $consult_date;
            $search[] = "%impressions_date%";
            $replace[] = $impressions_date;
            $search[] = "%delay_reason%";

            switch ($delay['reason']) {
                case 'insurance':
                    $replace[] = "insurance problems or issues";
                    break;
                case 'dental work':
                    $replace[] = "additional pending dental work";
                    break;
                case 'deciding':
                    $replace[] = "personal decision";
                    break;
                case 'sleep study':
                    $replace[] = "a pending sleep study";
                    break;
                case 'other':
                    if ($delay['description'] == '') {
                        $replace[] = "(warning: other was selected, but no info provided)";
                    } else {
                        $replace[] = $delay['description'];
                    }
                    break;
                default:
                    $replace[] = "(warning: no reason has been selected)";
            }

            $search[] = "%noncomp_reason%";
            switch ($noncomp['reason']) {
                case 'pain/discomfort':
                    $replace[] = "pain and/or discomfort";
                    break;
                case 'lost device':
                    $replace[] = "the device being lost and not replaced";
                    break;
                case 'device not working':
                    $replace[] = "patient claims that the device is not working properly or adequately";
                    break;
                case 'other':
                    if ($noncomp['description'] == '') {
                        $replace[] = "(warning: other was selected, but no info provided)";
                    } else {
                        $replace[] = $noncomp['description'];
                    }
                    break;
                default:
                    $replace[] = "(warning: no reason has been selected)";
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

            $replace[] = $other_mds;
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
                $replace[] = $nonpcp_mds;
            } else {
                $replace[] = $other_mds;
            }
            /**
             * END SEARCH/REPLACE
             */

            if (!empty($new_template[$cur_letter_num])) {
                $letter[$cur_letter_num] = parseLetterTemplate($search, $replace, $new_template[$cur_letter_num]);
            } else {
                $letter[$cur_letter_num] = parseLetterTemplate($search, $replace, $template);
            }

            $new_template[$cur_letter_num] = parseLetterTemplate($search, $replace, (!empty($new_template[$cur_letter_num]) ? $new_template[$cur_letter_num] : ''));

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

                if ($_GET['backoffice'] == '1' || $_SESSION['user_type'] == DSS_USER_TYPE_SOFTWARE) {
                    create_letter_pdf($letterid);
                    ?>
                    <script type="text/javascript">
                        $(document).ready(function () {
                            loadPopup("letter_approve.php?id=<?php echo $letterid; ?>&pid=<?php echo $_GET['pid']; ?>&backoffice=<?php echo $_GET['backoffice']; ?><?php echo ($parent) ? '&parent=1' : ''; ?>&goto=<?php echo $_GET['goto']; ?>");
                        });
                    </script>
                    <?php
                    $letter_approve = true;
                } else {
                    $sentletterid = send_letter($letterid, $parent, $type, $recipientid, $new_template[$cur_letter_num]);

                    if (!$parent) { ?>
                        <script type="text/javascript">
                            window.location = window.location;
                        </script>
                    <?php }
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

                if (isset($_POST['font_size'][$cur_letter_num])) {
                    $font_size = $_POST['font_size'][$cur_letter_num];
                } else {
                    $font_size = null;
                }

                if (isset($_POST['font_family'][$cur_letter_num])) {
                    $font_family = $_POST['font_family'][$cur_letter_num];
                } else {
                    $font_family = null;
                }

                if ($_POST['fax_letter'][$cur_letter_num] != null) {
                    $send_method = 'fax';
                } elseif ($_POST['paper_letter'][$cur_letter_num] != null) {
                    $send_method = 'paper';
                } elseif ($_POST['email_letter'][$cur_letter_num] != null) {
                    $send_method = 'email';
                } else {
                    $send_method = '';
                }

                $saveletterid = save_letter($letterid, $parent, $type, $recipientid, $message, $send_method, $font_size, $font_family);
                $num_contacts = num_letter_contacts($_GET['lid']);

                if ($_POST['send_letter'][$cur_letter_num] != null) {
                    create_letter_pdf($saveletterid);
                    ?>
                    <script type="text/javascript">
                        $(document).ready(function () {
                            loadPopup("letter_approve.php?id=<?php echo $saveletterid; ?>&pid=<?php echo $_GET['pid']; ?>&backoffice=<?php echo $_GET['backoffice']; ?><?php echo ($parent) ? '&parent=1' : ''; ?>&goto=<?php echo $_GET['goto']; ?>");
                        });
                    </script>
                    <?php
                    $letter_approve = true;
                } else { ?>
                    <script type="text/javascript">
                        window.location = window.location;
                    </script>
                <?php }
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
                    if (isset($_REQUEST['goto']) && $_REQUEST['goto'] != '') {
                        if ($_REQUEST['goto'] == 'flowsheet') {
                            $page = 'manage_flowsheet3.php?pid=' . $_GET['pid'] . '&addtopat=1';
                        } elseif ($_REQUEST['goto'] == 'letter') {
                            $page = 'dss_summ.php?sect=letters&pid=' . $_GET['pid'] . '&addtopat=1';
                        } elseif ($_REQUEST['goto'] == 'new_letter') {
                            $page = 'new_letter.php?pid=' . $_GET['pid'];
                        } elseif ($_REQUEST['goto'] == 'faxes') {
                            $page = 'manage_faxes.php';
                        }

                        ?>
                        <script type="text/javascript">
                            window.location = '<?= $page ?>';
                        </script>
                    <?php } else { ?>
                        <script type="text/javascript">
                            window.location = '<?= $_GET['backoffice'] == '1' ? '/manage/admin/manage_letters.php?status=pending' : '/manage/letters.php?status=pending' ?>';
                        </script>
                    <?php }
                } else { ?>
                    <script type="text/javascript">
                        window.location = window.location;
                    </script>
                <?php }

                trigger_error('Die called', E_USER_ERROR);
                continue;
            }

            if (!empty($parent) && $parent && !$letter_approve) {
                if (isset($_REQUEST['goto']) && $_REQUEST['goto'] != '') {
                    if ($_REQUEST['goto'] == 'flowsheet') {
                        $page = 'manage_flowsheet3.php?pid=' . $_GET['pid'] . '&addtopat=1';
                    } elseif ($_REQUEST['goto'] == 'letter') {
                        $page = 'dss_summ.php?sect=letters&pid=' . $_GET['pid'] . '&addtopat=1';
                    } elseif ($_REQUEST['goto'] == 'faxes') {
                        $page = 'manage_faxes.php';
                    }

                    ?>
                    <script type="text/javascript">
                        window.location = '<?= $page ?>';
                    </script>
                <?php } else { ?>
                    <script type="text/javascript">
                        window.location = '<?= $_GET['backoffice'] == '1' ? '/manage/admin/manage_letters.php?status=pending' : '/manage/letters.php?status=pending' ?>';
                    </script>
                <?php }
            }

            // Print Letter Body
            ?>

            <div style="margin: auto; width: 95%; padding: 3px;" class="single-letter">
                <div>
                    <span class="admin_head" style="float: none; display: inline-block; margin-top: -5px;">
                        <?= e($title) ?>
                    </span>
                    &nbsp;&nbsp;
                    <?php

                    if (!empty($_REQUEST['goto'])) {
                        if ($_REQUEST['goto'] == 'flowsheet') {
                            $page = 'manage_flowsheet3.php?pid=' . $_GET['pid'] . '&addtopat=1';
                        } elseif ($_REQUEST['goto'] == 'letter') {
                            $page = 'dss_summ.php?sect=letters&pid=' . $_GET['pid'] . '&addtopat=1';
                        } elseif ($_REQUEST['goto'] == 'new_letter') {
                            $page = 'new_letter.php?pid=' . $_GET['pid'];
                        } elseif ($_REQUEST['goto'] == 'faxes') {
                            $page = 'manage_faxes.php';
                        }

                        ?>
                        <a href="<?php echo $page; ?>" class="editlink" title="Pending Letters">
                            <b>&lt;&lt;Back</b>
                        </a>
                    <?php } else { ?>
                        <a href="<?php print (!empty($_GET['backoffice']) && $_GET['backoffice'] == '1' ? "/manage/admin/manage_letters.php?status=pending&backoffice=1" : "/manage/letters.php?status=pending"); ?>"
                           class="editlink" title="Pending Letters">
                            <b>&lt;&lt;Back</b>
                        </a>
                    <?php } ?>
                </div>
                <div style="float:left; text-align: left">
                    &nbsp;&nbsp;
                    Letter <strong><?= $cur_letter_num + 1 ?></strong> of <strong><?= $master_num ?></strong>.
                    To <?= contactType($patientid, $contact['id'], $contact['type']) ?>:
                    <?= e("{$contact['salutation']} {$contact['firstname']} {$contact['lastname']}") ?>
                    <input type="hidden" name="contacts[<?= $cur_letter_num ?>][id]" value="<?= $contact['id'] ?>"/>
                    <input type="hidden" name="contacts[<?= $cur_letter_num ?>][type]" value="<?= $contact['type'] ?>"/>
                </div>
                <div style="float: right; text-align: right;">
                    Delivery Method: <?= letterSendMethod($method, $contact['preferredcontact']) ?>
                    <a href="#"
                       onclick="$('#del_meth_<?= $cur_letter_num ?>').css('display','inline');$(this).hide();return false;"
                       id="change_method_<?= $cur_letter_num ?>" class="addButton"> Change </a>
                    <div id="del_meth_<?= $cur_letter_num ?>" style="display:none;">
                        <?php $send_meth = $method ?: $contact['preferredcontact']; ?>

                        <?php if ($send_meth == 'fax') { ?>
                            <input type="button" class="addButton" value="Fax"
                                   onclick="$('#del_meth_<?= $cur_letter_num ?>').hide();$('#change_method_<?= $cur_letter_num ?>').css('display','inline');return false;"/>
                        <?php } elseif ($contact['fax'] != '') { ?>
                            <input type="submit" name="fax_letter[<?= $cur_letter_num ?>]" class="addButton"
                                   value="Fax"/>
                        <?php } else { ?>
                            <input type="button" name="fax_letter[<?= $cur_letter_num ?>]" class="addButton grayButton"
                                   value="Fax"
                                   onclick="alert('No fax number is available for this contact. Set a fax number for this contact via the \'Contacts\' page in your software.');return false;"/>
                        <?php } ?>

                        <?php if ($send_meth == 'paper') { ?>
                            <input type="button" class="addButton" value="Paper"
                                   onclick="$('#del_meth_<?= $cur_letter_num ?>').hide();$('#change_method_<?= $cur_letter_num ?>').css('display','inline');return false;"/>
                        <?php } else { ?>
                            <input type="submit" name="paper_letter[<?= $cur_letter_num ?>]" class="addButton"
                                   value="Paper"/>
                        <?php } ?>

                        <input type="button" class="addButton" value="Cancel"
                               onclick="$('#del_meth_<?= $cur_letter_num ?>').hide();$('#change_method_<?= $cur_letter_num ?>').css('display','inline'); return false;"/>
                    </div>
                    &nbsp;&nbsp;
                    <?php if (isset($_SESSION['user_type']) && $_SESSION['user_type'] == DSS_USER_TYPE_SOFTWARE) { ?>
                        <select name="font_size[<?php echo $cur_letter_num ?>]" style="display:none;"
                                class="edit_letter<?php echo $cur_letter_num ?>" onchange="javascript:return false;">
                            <option <?php echo ($font_size == 8) ? 'selected="selected"' : ''; ?> value="8">8</option>
                            <option <?php echo ($font_size == 10) ? 'selected="selected"' : ''; ?> value="10">10
                            </option>
                            <option <?php echo ($font_size == 12) ? 'selected="selected"' : ''; ?> value="12">12
                            </option>
                            <option <?php echo ($font_size == 14 || empty($font_size)) ? 'selected="selected"' : ''; ?>
                                value="14">14
                            </option>
                            <option <?php echo ($font_size == 16) ? 'selected="selected"' : ''; ?> value="16">16
                            </option>
                            <option <?php echo ($font_size == 20) ? 'selected="selected"' : ''; ?> value="20">20
                            </option>
                        </select>
                        <select name="font_family[<?php echo $cur_letter_num ?>]" style="display:none;"
                                class="edit_letter<?php echo $cur_letter_num ?>" onchange="javascript:return false;">
                            <option <?php echo ($font_family == 'dejavusans' || empty($font_family)) ? 'selected="selected"' : ''; ?>
                                value="dejavusans">Dejavu Sans
                            </option>
                            <option <?php echo ($font_family == 'times') ? 'selected="selected"' : ''; ?> value="times">
                                Times New Roman
                            </option>
                            <option <?php echo ($font_family == 'courier') ? 'selected="selected"' : ''; ?>
                                value="courier">Courier
                            </option>
                            <option <?php echo ($font_family == 'helvetica') ? 'selected="selected"' : ''; ?>
                                value="helvetica">Helvetica
                            </option>
                        </select>

                        <input type="submit" name="font_submit[<?php echo $cur_letter_num ?>]"
                               id="font_submit_<?php echo $cur_letter_num ?>" style="display:none;"/>
                    <?php } ?>
                    <span id="preview-tools-letter<?= $cur_letter_num ?>" class="preview-tools">
                        <button id="toggle-hidden-letter<?= $cur_letter_num ?>" class="preview-toggle-hidden addButton"
                                onclick="return false;" title="Show/hide line breaks">
                            &#xb6;
                        </button>
                        &nbsp;&nbsp;
                        <button id="toggle-placeholders-letter<?= $cur_letter_num ?>"
                                class="preview-toggle-placeholders addButton"
                                onclick="return false;" title="Show/hide placeholder hints">
                          <?= $letterRow['edit_date'] ? 'Show' : 'Hide' ?> placeholders
                        </button>
                    </span>
                    &nbsp;&nbsp;
                    <button id="edit_but_letter<?php echo $cur_letter_num; ?>" class="addButton"
                            onclick="Javascript: edit_letter('letter<?php echo $cur_letter_num ?>', '<?php echo $font_size; ?>','<?php echo $font_family; ?>');return false;">
                        Edit Letter
                    </button>
                    <button style="display:none;" id="cancel_edit_but_letter<?php echo $cur_letter_num; ?>"
                            class="addButton"
                            onclick="Javascript: hide_edit_letter('letter<?= $cur_letter_num ?>');return false;">
                        Cancel Edits
                    </button>
                    &nbsp;&nbsp;

                    <?php if (($method ? $method : $contact['preferredcontact']) == 'fax' && $franchisee_info['use_digital_fax'] != 1 && $_GET['backoffice'] != '1') { ?>
                        <input type="submit" name="send_letter[<?php echo $cur_letter_num ?>]" class="addButton"
                               onclick="return confirm('Warning! Digital fax is not enabled in your account. Click OK to send the letter via standard printing. To enable digital faxing for your account please contact the DSS corporate office.');"
                               value="Send Letter"/>
                    <?php } elseif (($method ? $method : $contact['preferredcontact']) == 'fax' && $location_info['fax'] == "" && $_GET['backoffice'] != '1') { ?>
                        <input type="submit" name="send_letter[<?php echo $cur_letter_num ?>]" class="addButton"
                               onclick="return confirm('Warning! You have not specified a return fax number for your location, and no return fax number will appear on this correspondence. Please set your fax number in Admin -> Profile. Click OK to send this fax without your return fax number, or Cancel to add your fax number and retry.');"
                               value="Send Letter"/>
                    <?php } else { ?>
                        <input type="submit" name="send_letter[<?php echo $cur_letter_num ?>]" class="addButton"
                               value="Send Letter"/>
                    <?php } ?>
                    &nbsp;&nbsp;
                </div>
                <div style="width: 100%; text-align: center; clear: both;">
                    <?php if ($status == DSS_LETTER_SEND_FAILED) { ?>
                        Sending of letter failed. Letter was attempted to be sent to
                        <a href="#"
                           onclick="loadPopup('add_contact.php?ed=<?php echo $contact['id']; ?>'); return false;"><?php echo $contact['firstname'] . " " . $contact['lastname']; ?></a>
                    <?php } ?>
                </div>

                <table width="95%" cellpadding="3" cellspacing="1" border="0" align="center">
                    <tr>
                        <td valign="top">
                            <div id="letter<?= $cur_letter_num ?>"
                                 class="preview-letter preview-font-<?= $font_family ?> preview-size-<?= $font_size ?: 14 ?> <?= $letterRow['edit_date'] ? '' : 'show-placeholders' ?>"
                                 data-initial-class="preview-letter preview-font-<?= $font_family ?> preview-size-<?= $font_size ?: 14 ?> <?= $letterRow['edit_date'] ? '' : 'show-placeholders' ?>">
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
                                <?php for ($n = 1; $n <= 0; $n++) { ?>
                                    <div class="preview-page-break break-<?= $n ?>">page <?= $n + 1 ?></div><?php } ?>
                                <div class="preview-bottom-margin"></div>
                            </div>
                            <input type="hidden" name="new_template[<?php echo $cur_letter_num ?>]"
                                   value="<?php echo preg_replace('/(&Acirc;|&nbsp;)+/i', '', htmlentities($letter[$cur_letter_num], ENT_COMPAT | ENT_IGNORE, "UTF-8")) ?>"/>
                        </td>
                    </tr>
                </table>

                <div style="float:left;">
                    <input type="submit" style="display:none;" name="reset_letter[<?php echo $cur_letter_num ?>]"
                           class="addButton edit_letter<?php echo $cur_letter_num ?>" value="Reset"/>
                    &nbsp;&nbsp;&nbsp;&nbsp;

                    <?php if (!(!empty($_GET['backoffice']) && $_GET['backoffice'] == "1" && $_SESSION['admin_access'] != 1)) { ?>
                        <input type="submit" name="delete_letter[<?php echo $cur_letter_num ?>]" class="addButton"
                               value="Delete"/>
                        &nbsp;&nbsp;&nbsp;&nbsp;
                    <? } ?>
                </div>
                <div style="float:right;">
                    <input type="submit" style="display:none;" name="save_letter[<?php echo $cur_letter_num ?>]"
                           class="addButton edit_letter<?php echo $cur_letter_num ?>" value="Save Changes"/>
                </div>

                <?php if ($username) { ?>
                    <div style="clear:both; width:100%; text-align:center;">
                        Last edited by <?php echo $username; ?>
                        on <?php echo date('m/d/Y h:i:s a', strtotime($edit_date)); ?>
                    </div>
                <?php } ?>
            </div>
            <br><br>
            <hr width="90%"/>
            <br><br>
            <?php
            $cur_letter_num++; //increment letter num to identify next letter;
        }
        /**
         * END Contact loop
         */

        ?>
    </form>
<?php }
/**
 * END Letter loop
 */

?>

<?php foreach ($googleFonts as $localName => $remoteName) { ?>
    <link href="https://fonts.googleapis.com/css?family=<?= urlencode($remoteName) ?>" rel="stylesheet">
<?php } ?>
    <?php

if (!empty($isBackOffice)) {
    include 'admin/includes/bottom.htm';
    ?>

    <div id="popupContact" style="width:750px;">
        <a id="popupContactClose">
            <button>X</button>
        </a>
        <iframe id="aj_pop" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
    </div>
    <div id="backgroundPopup"></div>
<?php } else {
    include 'includes/bottom.htm';
}

/**
 * Format number for valid CSS values
 *
 * @param int|float $number
 * @return string
 */
function formatMm($number)
{
    return number_format($number, 1, '.', '') . 'mm';
}

/**
 * Determine proper contact type as shown in New Letter page
 *
 * @param int    $patientId
 * @param int    $contactId
 * @param string $contactType
 * @return string
 */
function contactType($patientId, $contactId, $contactType)
{
    static $contactTypeList = [];

    if (!$contactTypeList) {
        $db = new Db();
        $patientId = intval($patientId);

        $contactTypeList = $db->getRow("SELECT
        docsleep AS 'Sleep MD',
        docpcp AS 'Primary Care MD',
        docdentist AS 'Dentist',
        docent AS 'ENT'
    FROM dental_patients
    WHERE patientid = '$patientId'");

        $contactTypeList = $contactTypeList ?: [];
    }

    switch ($contactType) {
        case 'patient':
            $type = 'Patient';
            break;
        case 'md':
            $find = array_search($contactId, $contactTypeList);
            $type = $find ?: 'Other MD';
            break;
        case 'md_referral':
        default:
            $type = 'Other MD';
    }

    return $type;
}

/**
 * Determine if the contact is physician
 *
 * @param int $id
 * @return bool
 */
function is_physician($id)
{
    $db = new Db();
    $r = $db->getColumn("SELECT physician
        FROM dental_contacttype
        WHERE contacttypeid='" . $db->escape($id) . "'", 'physician');

    return $r == 1;
}

/**
 * Clean up replacements that contain HTML
 *
 * @param array $replacements
 * @return array
 */
function preProcessReplacements($replacements)
{
    $imgRegex = '@
            src="(?P<src> .*? )"
            | width="(?P<width> .*? )"
            | height="(?P<height> .*? )"
            | align="(?P<align> .*? )"
            | style="(?P<style> .*? )"
        @Si';
    $imgRegex = preg_replace('@[\s\r\t\n]+@', '', $imgRegex);

    array_walk($replacements, function (&$each) use ($imgRegex) {
        if (is_array($each)) {
            return;
        }

        $paragraph = false;

        switch (true) {
            case substr($each, 0, 4) === '<img':
                preg_match_all($imgRegex, $each, $matches);
                $each = [
                    'image' => true,
                    'src' => current(array_filter(array_get($matches, 'src'))),
                    'width' => current(array_filter(array_get($matches, 'width'))),
                    'height' => current(array_filter(array_get($matches, 'height'))),
                    'style' => current(array_filter(array_get($matches, 'style'))),
                    'align' => current(array_filter(array_get($matches, 'align'))),
                ];
                break;
            /** @noinspection PhpMissingBreakStatementInspection */
            case substr($each, 0, 3) === '<p>':
                $each = preg_replace('@^ *<p>([\s\S]*)</p> *$@i', '$1', $each);
                $paragraph = true;
            // fallthrough
            default:
                $each = preg_split('@<br */?>@i', $each);

                if ($paragraph) {
                    $each['paragraph'] = true;
                }
        }
    });

    return $replacements;
}

/**
 * Generate desired HTML from arrays. Adds an HTML invalid placeholder, to signal where to set the title
 *
 * @param array $replacements
 * @return array
 */
function processReplacements($replacements)
{
    $class = 'preview-placeholder';
    $requiredImgAttributes = ['src', 'alt'];

    array_walk($replacements, function (&$each, $placeholder) use ($class, $requiredImgAttributes) {
        if (!is_array($each)) {
            $each = e($each);

            return;
        }

        $attributes = str_replace(
            ['$class', '$title'],
            [$class, templateEscape($placeholder)],
            'class="$class" title="$title"'
        );

        if (!empty($each['image'])) {
            $replacement = [];
            unset($each['image']);

            /**
             * Required img attributes
             */
            array_walk($requiredImgAttributes, function ($attribute) use (&$each) {
                $each[$attribute] = array_get($each, $attribute);
            });

            array_walk($each, function ($value, $attribute) use (&$replacement, $requiredImgAttributes) {
                if ($attribute === 'title') {
                    $replacement []= $attribute . '="' . templateEscape($value) . '"';
                } elseif (in_array($attribute, $requiredImgAttributes) || strlen($value)) {
                    $replacement []= $attribute . '="' . e($value) . '"';
                }
            });

            $each = "<img $attributes " . join($replacement, ' ') . ' />';
            return;
        }

        $paragraph = false;

        if (!empty($each['paragraph'])) {
            $paragraph = true;
            unset($each['paragraph']);
        }

        $replacement = array_map(e, $each);
        $replacement = join('<br />', $replacement);

        if ($paragraph) {
            $each = "<p $attributes>$replacement</p>";
        } else {
            $each = "<mark $attributes>$replacement</mark>";
        }
    });

    return $replacements;
}

/**
 * Allow special rules for replacements
 *
 * @param array $placeholders
 * @param array $replacements
 * @param string $template
 * @return string
 */
function parseLetterTemplate($placeholders, $replacements, $template)
{
    if (!trim($template)) {
        return $template;
    }

    /**
     * Assume the placeholders can contain the following:
     *
     * - some br tags
     * - enclosed in p tag
     */
    $replacements = array_combine($placeholders, $replacements);
    $replacements = preProcessReplacements($replacements);
    $replacements = processReplacements($replacements);

    $restoredTemplate = restorePlaceholders($template);
    $parsedTemplate = str_replace($placeholders, $replacements, $restoredTemplate);

    return $parsedTemplate;
}

/**
 * Escape placeholder delimiters
 *
 * @param string $string
 * @return string
 */
function templateEscape($string)
{
    return str_replace('%', '&#37;', e($string));
}

/**
 * Restore placeholders, knowing certain HTML attributes signal attributes
 *
 * @param string $processedTemplate
 * @return string
 */
function restorePlaceholders($processedTemplate)
{
    /**
     * The following modifiers did not work reliably:
     *
     * - m: multiline
     * - x: extended match
     */
    $titleRegex = '\s [^>]*? title="(&#37;|%) (?P<placeholder> [^">&]*? ) \2" [^>]*?';
    $textRegex = "@<(?P<tag> p|mark ) $titleRegex>(?P<contents> [\\s\\S]*? )</\\1>@Si";
    $imageRegex = "@<(?P<tag> img ) $titleRegex /?>@Si";

    $textRegex = preg_replace('@\s+@', '', $textRegex);
    $imageRegex = preg_replace('@\s+@', '', $imageRegex);

    $template = preg_replace_callback($textRegex, function ($match) {
        // Assume the placeholder is already escaped
        $contents = $match['contents'];
        $placeholder = "%{$match['placeholder']}%";

        switch (true) {
            case preg_match('@<(strong|b)>[\s\S]*?<(em|i)>@S', $contents) > 0:
                return "<strong><em>$placeholder</em></strong>";
                break;
            case preg_match('@<(strong|b)>@S', $contents) > 0:
                return "<strong>$placeholder</strong>";
                break;
            case preg_match('@<(em|i)>@S', $contents) > 0:
                return "<em>$placeholder</em>";
                break;
            default:
                return $placeholder;
        }
    }, $processedTemplate);

    $template = preg_replace_callback($imageRegex, function ($match) {
        // Assume the placeholder is already escaped
        return "%{$match['placeholder']}%";
    }, $template);

    return $template;
}
