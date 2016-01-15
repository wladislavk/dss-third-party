<?php
namespace Ds3\Libraries\Legacy;

require_once __DIR__ . '/../../includes/constants.inc';

$is_front_office = empty($is_back_office);

$userId = intval($_SESSION['userid']);
$docId = intval($_SESSION['docid']);

if (isset($_GET['hst_id'])) {
    $hstId = intval($_GET['hst_id']);

    $hstData = $db->getRow("SELECT * FROM dental_hst WHERE id = '$hstId'");
    $patientId = $hstData ? $hstData['patientid'] : 0;
    $hstCompanyId = $hstData ? $hstData['company_id'] : 0;

    $bu_sql = "SELECT h.*, uhc.id as uhc_id
        FROM companies h
            JOIN dental_user_hst_company uhc ON uhc.companyid = h.id
                AND uhc.userid = '$docId'
        WHERE h.company_type = '" . DSS_COMPANY_TYPE_HST . "'
        ORDER BY name ASC";

    $hstCompanyList = $db->getResults($bu_sql);
} else {
    $hstId = 0;
    $patientId = intval($_GET['ed']);
    $hstCompanyId = intval($_GET['hst_co']);
}

$bu_sql = "SELECT h.*, uhc.id as uhc_id
    FROM companies h
        JOIN dental_user_hst_company uhc ON uhc.companyid = h.id
            AND uhc.userid = '$docId'
    WHERE h.company_type = '" . DSS_COMPANY_TYPE_HST . "'
        AND h.id = '$hstCompanyId'
    ORDER BY name ASC";

$hstCompany = $db->getRow($bu_sql);
$showSubmitAction = $is_front_office && (!isset($hstCompanyList) || $hstCompany['status'] == DSS_HST_PENDING);

if (isset($_POST['submit'])) {
    $thorton_sql = "SELECT * FROM dental_thorton WHERE patientid = '$patientId'";
    $thorton = $db->getRow($thorton_sql);

    $sleepstudies = "SELECT diagnosis
        FROM dental_summ_sleeplab
        WHERE (
                diagnosis IS NOT NULL
                AND diagnosis != ''
            )
            AND filename IS NOT NULL
            AND patiendid = '$patientId'
        ORDER BY id DESC
        LIMIT 1";
    $d = $db->getRow($sleepstudies);
    $diagnosis = $d['diagnosis'];

    $partialData = [
        $patientId,
        $docId,
        $userId,
        $_POST['company_id'],
        $_POST['ins_co_id'],
        $_POST['ins_phone'],
        $_POST['patient_ins_group_id'],
        $_POST['patient_ins_id'],
        $_POST['patient_firstname'],
        $_POST['patient_lastname'],
        $_POST['patient_add1'],
        $_POST['patient_add2'],
        $_POST['patient_city'],
        $_POST['patient_state'],
        $_POST['patient_zip'],
        date('Y-m-d', strtotime($_POST['patient_dob'])),
        $_POST['patient_cell_phone'],
        $_POST['patient_home_phone'],
        $_POST['patient_email'],
        $_POST['diagnosis_id'],
        $_POST['hst_type'],
        $_POST['hst_nights'],
        @serialize($_POST['hst_device_position']),
        $_POST['provider_firstname'],
        $_POST['provider_lastname'],
        $_POST['provider_address'],
        $_POST['provider_city'],
        $_POST['provider_state'],
        $_POST['provider_zip'],
        $_POST['provider_signature'],
        date('Y-m-d', strtotime($_POST['provider_date'])),
        $thorton['snore_1'],
        $thorton['snore_2'],
        $thorton['snore_3'],
        $thorton['snore_4'],
        $thorton['snore_5'],
    ];

    $partialData = $db->escapeList($partialData);

    $sd = date('Y-m-d H:i:s');
    $sql = "INSERT INTO dental_hst (
            patient_id,
            doc_id,
            user_id,
            company_id,
            ins_co_id,
            ins_phone,
            patient_ins_group_id,
            patient_ins_id,
            patient_firstname,
            patient_lastname,
            patient_add1,
            patient_add2,
            patient_city,
            patient_state,
            patient_zip,
            patient_dob,
            patient_cell_phone,
            patient_home_phone,
            patient_email,
            diagnosis_id,
            hst_type,
            hst_nights,
            hst_positions,
            provider_firstname,
            provider_lastname,
            provider_address,
            provider_city,
            provider_state,
            provider_zip,
            provider_signature,
            provider_date,
            snore_1,
            snore_2,
            snore_3,
            snore_4,
            snore_5,

            status,
            authorized_id,
            authorizeddate,

            adddate,
            ip_address
        ) VALUES ($partialData, ";

    $sign_sql = "SELECT sign_notes FROM dental_users where userid = '$userId'";
    $sign_r = $db->getRow($sign_sql);
    $user_sign = $sign_r['sign_notes'];

    if ($user_sign || $docId == $userId) {
        $sql .= DSS_HST_PENDING . ", '$userId', NOW(), ";
    } else {
        $sql .= DSS_HST_REQUESTED . ", NULL, NULL, ";
    }

    $sql .= "NOW(), '" . $db->escape($_SERVER['REMOTE_ADDR']) . "')";
    $hst_id = $db->getInsertId($sql);

    $sql = "SELECT * FROM dental_q_sleep WHERE patientid = '$patientId'";
    $myarray = $db->getRow($sql);

    $q_sleepid = st($myarray['q_sleepid']);
    $epworthid = st($myarray['epworthid']);
    $analysis = st($myarray['analysis']);

    $epid = [];
    $epseq = [];

    if ($epworthid != '') {
        $epworth_arr1 = split('~', $epworthid);

        foreach ($epworth_arr1 as $i=>$val) {
            $epworth_arr2 = explode('|', $val);
            $epid[$i] = $epworth_arr2[0];
            $epseq[$i] = $epworth_arr2[1];
        }
    }

    $epworth_sql = "SELECT * FROM dental_epworth WHERE status = 1 ORDER BY sortby";
    $epworth_my = $db->getResults($epworth_sql);
    $epworth_number = count($epworth_my);

    foreach ($epworth_my as $epworth_myarray) {
        if (@array_search($epworth_myarray['epworthid'], $epid) === false) {
            $chk = '';
        } else {
            $chk = $epseq[@array_search($epworth_myarray['epworthid'], $epid)];
        }

        if ($chk != '') {
            $hst_sql = "INSERT INTO dental_hst_epworth SET
                hst_id = '" . $db->escape($hst_id) . "',
                epworth_id = '" . $db->escape($epworth_myarray['epworthid']) . "',
                response = '" . $db->escape($chk) . "',
                adddate = now(),
                ip_address = '" . $db->escape($_SERVER['REMOTE_ADDR']) . "'";
            $db->query($hst_sql);
        }
    }

    $c_sql = "SELECT c.email from companies c WHERE c.id = '" . $db->escape($_POST['company_id']) . "'";
    $c = $db->getRow($c_sql);

    if ($c['email'] != '') {
        $headers = join("\r\n", [
            'From: Dental Sleep Solutions <noreply@dentalsleepsolutions.com>',
            'Content-type: text/html',
            'Reply-To: noreply@dentalsleepsolutions.com',
            'X-Mailer: PHP/' . phpversion()
        ]);

        $subject = "New HST Order Created";
        $user_sql = "SELECT * FROM dental_users where userid = '$docId'";
        $user = $db->getRow($user_sql);
        $m = "<html><body>" .
            "<center>" .
                "<table width='600'>" .
                    "<tr>" .
                        "<td colspan='2'>" .
                            "<img alt='A message from your healthcare provider' " .
                                "src='" . $_SERVER['HTTP_HOST'] . "/reg/images/email/email_header_fo.png' />" .
                        "</td>" .
                    "</tr>" .
                    "<tr>" .
                        "<td width='400'>" .
                            "<h2>New HST Order Created</h2>" .
                            "<p>A new HST order has been submitted to you by " .
                                $user['first_name'] . " " . $user['last_name'] . " at " .
                                $user['mailing_practice'] . " on " . date('m/d/Y h:i p') .
                            ".</p>" .
                            "<p>Please log in to your DS3 backoffice account to check the details:" .
                                "<a href='http://" . $_SERVER['HTTP_HOST'] . "/manage/admin'>" .
                                "http://" . $_SERVER['HTTP_HOST'] . "/manage/admin" .
                            "</a>" .
                            "</p>" .
                        "</td>" .
                        "<td>" .
                            "<img alt='Logo' src='" . $_SERVER['HTTP_HOST'] . "/reg/images/email/reg_logo.gif' />" .
                        "</td>" .
                    "</tr>" .
                    "<tr>" .
                        "<td colspan='2'>" .
                            "<img alt='A message from your healthcare provider' src='" .
                                $_SERVER['HTTP_HOST'] . "/reg/images/email/email_footer_fo.png' />" .
                        "</td>" .
                    "</tr>" .
                "</table>" .
            "</center>" .
            "<span style='font-size:12px;'>" .
            "This email was sent by Dental Sleep Solutions&reg; on behalf of " .
            $user['mailing_practice'] . ". " . DSS_EMAIL_FOOTER .
            "</span>" . "</body></html>";

        mail($c['email'], $subject, $m, $headers);
    }

    ?>
    <script type="text/javascript">
        window.location = 'add_patient.php?ed=<?= $patientId ?>&preview=1&addtopat=1&pid=<?= $patientId ?>';
    </script>
<?php
}

$sql = "SELECT u.*
    FROM dental_patients p
        JOIN dental_users u ON p.docid = u.userid
    WHERE p.patientid = '$patientId'";

$user_info = $db->getRow($sql);

$sql = "SELECT
        i.company AS 'ins_co', 'primary' AS 'ins_rank', i.phone1 AS 'ins_phone',
        p.p_m_ins_co, p.p_m_ins_grp AS 'patient_ins_group_id', p.p_m_ins_id AS 'patient_ins_id',
        p.firstname AS 'patient_firstname', p.lastname AS 'patient_lastname',
        p.add1 AS 'patient_add1', p.add2 AS 'patient_add2', p.city AS 'patient_city',
        p.state AS 'patient_state', p.zip AS 'patient_zip', p.dob AS 'patient_dob',
        p.cell_phone AS 'patient_cell_phone', p.home_phone AS 'patient_home_phone',
        p.email AS 'patient_email',
        p.p_m_partyfname AS 'insured_first_name', p.p_m_partylname AS 'insured_last_name',
        p.ins_dob AS 'insured_dob', d.npi AS 'doc_npi', r.national_provider_id AS 'referring_doc_npi',
        d.medicare_npi AS 'doc_medicare_npi', d.tax_id_or_ssn AS 'doc_tax_id_or_ssn',
        tc.amount AS 'trxn_code_amount', q2.confirmed_diagnosis AS 'diagnosis_code',
        d.userid AS 'doc_id', p.home_phone AS 'patient_phone'
    FROM dental_patients p
        LEFT JOIN dental_contact r ON p.referred_by = r.contactid
        LEFT JOIN dental_contact i ON p.p_m_ins_co = i.contactid
        JOIN dental_users d ON p.docid = d.userid
        LEFT JOIN dental_transaction_code tc ON p.docid = tc.docid
            AND tc.transaction_code = 'E0486'
        LEFT JOIN dental_q_page2 q2 ON p.patientid = q2.patientid
    WHERE p.patientid = '$patientId'";

$pat = $db->getRow($sql);

$hstData = !empty($hstData) ? $hstData : [];

if (!$hstData && $pat) {
    $hstData = [
        'patient_firstname' => $pat['patient_firstname'],
        'patient_lastname' => $pat['patient_lastname'],
        'patient_dob' => $pat['patient_dob'],
        'patient_add1' => $pat['patient_add1'],
        'patient_add2' => $pat['patient_add2'],
        'patient_city' => $pat['patient_city'],
        'patient_state' => $pat['patient_state'],
        'patient_zip' => $pat['patient_zip'],
        'patient_cell_phone' => $pat['patient_cell_phone'],
        'patient_home_phone' => $pat['patient_home_phone'],
        'patient_email' => $pat['patient_email'],
        'patient_ins_id' => $pat['patient_ins_id'],
        'patient_ins_group_id' => $pat['patient_ins_group_id'],
        'ins_phone' => $pat['ins_phone'],
        'diagnosis_id' => 0,
        'ins_co_id' => 0,
        'hst_type' => 0,
        'hst_nights' => 2,
        'hst_positions' => '',
        'provider_firstname' => $user_info['fisrt_name'],
        'provider_lastname' => $user_info['last_name'],
        'provider_address' => $user_info['address'],
        'provider_city' => $user_info['city'],
        'provider_state' => $user_info['state'],
        'provider_zip' => $user_info['zip'],
        'provider_signature' => 1,
        'provider_date' => date('m/d/Y'),
    ];
}

$hstData['hst_positions'] = @json_decode($hstData['hst_positions']);
$hstData['hst_positions'] = $hstData['hst_positions'] ?: [];

$diagnosticNightsLimit = 2;
$oatNightsLimit = 3;

$nightsDefault = $hstData['hst_nights'] ?: 2;

?>
<link type="text/css" rel="stylesheet" href="/manage/css/form.css" />
<?php if (!empty($is_back_office)) { ?>
    <a href="/manage/admin/view_hst.php?ed=<?= $hstData['id'] ?><?=
        isset($_GET['status']) ? '&amp;ret_status=' . e($_GET['status']) : ''
    ?>" title="Back to HST Results" class="btn btn-primary btn-sm">
        <span class="glyphicon glyphicon-arrow-left"></span>
        HST Details
    </a>
<?php } ?>
<form id="hst_order_sleep_services" class="fullwidth" name="form1" method="post" action="#" onsubmit="return check_fields(this);">
    <input type="hidden" name="provider_signature" id="provider_signature" value="1" />

    <?php if (!isset($hstCompanyList)) { ?>
        <input type="hidden" name="company_id" value="<?= e($hstCompany['id']) ?>" />
        <h2 align="center">
            <strong><?= e($hstCompany['name']) ?></strong>
        </h2>
    <?php } else { ?>
        <h2>
            <strong>Sleep Services</strong>
        </h2>
    <?php } ?>

    <h3 align="center">Home Sleep Test Order Form For
        <?= e($hstData['patient_firstname'] . ' ' . $hstData['patient_lastname']) ?>
    </h3>

    <?php if (isset($hstCompanyList)) { ?>
        <ul class="frmhead">
            <li>
                <label class="desc">Company</label>
                <hr />
                <?php foreach ($hstCompanyList as $company) { ?>
                    <input type="radio" name="company_id" id="company-id-<?= $company['id'] ?>"
                           value="<?= $company['id'] ?>" <?= $hstData['company_id'] == $company['id'] ? 'checked' : '' ?> />
                    <label for="company-id-<?= $company['id'] ?>"><?= e($company['name']) ?></label>
                    <br />
                <?php } ?>
            </li>
        </ul>
    <?php } ?>
    <p></p>
    <ul class="frmhead">
        <li>
            <label class="desc">Patient Information</label>
            <hr />
            <span>
                <input type="text" name="patient_firstname" id="patient_firstname" value="<?= e($hstData['patient_firstname']) ?>"/>
                <label for="patient_firstname">Patient First Name</label>
            </span>
            <span>
                <input type="text" name="patient_lastname" id="patient_lastname" value="<?= e($hstData['patient_lastname']) ?>" />
                <label for="patient_lastname">Patient Last Name</label>
            </span>
            <span>
                <input type="text" name="patient_dob" id="patient_dob" value="<?= e($hstData['patient_dob']) ?>" />
                <label for="patient_dob">DOB</label>
            </span>
        </li>
        <li>
            <span>
                <input type="text" name="patient_add1" id="patient_add1" value="<?= e($hstData['patient_add1']) ?>" />
                <label for="patient_add1"> Address 1</label>
            </span>
            <span>
                <input type="text" name="patient_add2" id="patient_add2" value="<?= e($hstData['patient_add2']) ?>" />
                <label for="patient_add2"> Address 2</label>
            </span>
            <span>
                <input type="text" name="patient_city" id="patient_city" value="<?= e($hstData['patient_city']) ?>" />
                <label for="patient_city">City</label>
            </span>
            <span>
                <input type="text" name="patient_state" id="patient_state" value="<?= e($hstData['patient_state']) ?>" />
                <label for="patient_state">State</label>
            </span>
            <span>
                <input type="text" name="patient_zip" id="patient_zip" value="<?= e($hstData['patient_zip']) ?>" />
                <label for="patient_zip">Zip</label>
            </span>
        </li>
        <li>
            <span>
                <input type="text" name="patient_cell_phone" id="patient_cell_phone" value="<?= e($hstData['patient_cell_phone']) ?>"/>
                <label for="patient_cell_phone">Mobile phone</label>
            </span>
            <span>
                <input type="text" name="patient_home_phone" id="patient_home_phone" value="<?= e($hstData['patient_home_phone']) ?>" />
                <label for="patient_home_phone">Home Phone</label>
            </span>
            <span>
                <input type="text" name="patient_email" id="patient_email" value="<?= e($hstData['patient_email']) ?>" />
                <label for="patient_email">Email</label>
            </span>
        </li>
        <li>
            <span>
                <select name="ins_co_id" id="ins_co_id">
                    <?php

                    $ins_contact_qry = "SELECT * FROM dental_contact WHERE contacttypeid = '11' AND docid = '$docId'";
                    $ins_contact_qry_run = $db->getResults($ins_contact_qry);

                    foreach ($ins_contact_qry_run as $ins_contact_res) { ?>
                        <option value="<?php echo $ins_contact_res['contactid'] ?>"
                            <?= $hstData['p_m_ins_co'] == $ins_contact_res['contactid'] ? 'selected' : '' ?>>
                            <?php echo addslashes(!empty($ins_contact_res['company']) ? $ins_contact_res['company'] : ''); ?>
                        </option>
                    <?php } ?>
                </select>
                <label for="ins_co_id">Insurance Company</label>
            </span>
            <span>
                <input type="text" name="ins_phone" id="ins_phone" value="<?= e($hstData['ins_phone']) ?>" />
                <label for="ins_phone">Ins. Phone Number</label>
            </span>
            <span>
                <input type="text" name="patient_ins_id" id="patient_ins_id" value="<?= e($hstData['patient_ins_id']) ?>" />
                <label for="patient_ins_id">ID Number</label>
            </span>
            <span>
                <input type="text" name="patient_ins_group_id" id="patient_ins_group_id"
                    value="<?= e($hstData['patient_ins_group_id']) ?>" />
                <label for="patient_ins_group_id">Group Number</label>
            </span>
        </li>
    </ul>
    <p></p>
    <ul class="frmhead">
        <li>
            <label class="desc">Diganosis / Reason for Study</label>
            <hr />
            <?php

            $ins_diag_sql = "select * from dental_ins_diagnosis where status=1 order by sortby";
            $ins_diag_my = $db->getResults($ins_diag_sql);

            foreach ($ins_diag_my as $ins_diag_myarray) { ?>
                <input type="radio" name="diagnosis_id"
                    <?= $ins_diag_myarray['ins_diagnosisid'] == $hstData['diagnosis_id'] ? 'checked' : '' ?>
                       value="<?php echo st($ins_diag_myarray['ins_diagnosisid'])?>"
                       id="diagnosis-<?php echo st($ins_diag_myarray['ins_diagnosisid'])?>">
                <label for="diagnosis-<?php echo st($ins_diag_myarray['ins_diagnosisid'])?>">
                    <?php echo st($ins_diag_myarray['ins_diagnosis'])." ".$ins_diag_myarray['description'];?>
                </label>
                <br />
            <?php } ?>
        </li>
    </ul>
    <p></p>
    <ul class="frmhead">
        <li>
            <label class="desc">Home Sleep Diagnostic Testing</label>
            <hr />
            <input type="radio" name="hst_type" id="hst_order1" value="1" <?= $hstData['hst_type'] == 1 ? 'checked' : '' ?> />
            <label for="hst_order1">
                In-Home Diagnostic Sleep Test
                &mdash;
                number of nights:
            </label>
            <select name="hst_1_nights">
                <?php for ($n=1;$n<=$diagnosticNightsLimit;$n++) { ?>
                    <option <?= $n == $nightsDefault ? 'selected' : '' ?>><?= $n ?></option>
                <?php } ?>
            </select>
        </li>
        <li>
            <input type="radio" name="hst_type" id="hst_order2" value="2" <?= $hstData['hst_type'] == 2 ? 'checked' : '' ?> />
            <label for="hst_order2">In-Home Sleep Test with PAP</label>
        </li>
        <li>
            <input type="radio" name="hst_type" id="hst_order3" value="3" <?= $hstData['hst_type'] == 3 ? 'checked' : '' ?> />
            <label for="hst_order3">
                In-Home Sleep Test with OAT (titration)
                &mdash;
                number of nights:
            </label>
            <select name="hst_3_nights">
                <?php for ($n=1;$n<=$oatNightsLimit;$n++) { ?>
                    <option <?= $n == $nightsDefault ? 'selected' : '' ?>><?= $n ?></option>
                <?php } ?>
            </select>
            <p class="container" <?= $hstData['hst_order'] != 3 ? 'style="display:none;"' : '' ?>>
                <span>Device position:</span>
                <?php for ($n=0;$n<$nightsDefault;$n++) { ?>
                    <span class="field-position">
                            <input type="text" id="device-position-<?= $n ?>" name="hst_device_position[<?= $n ?>]"
                                   value="<?= e($hstData['hst_positions'][$n]) ?>" />
                            <label for="device-position-<?= $n ?>">For night <?= $n + 1 ?></label>
                        </span>
                <?php } ?>
            </p>
        </li>
    </ul>
    <p></p>
    <ul class="frmhead">
        <li>
            <label class="desc">Provider Information</label>
            <hr />
            <label>Deliver HST Results/Report via my <strong>DS3 Software</strong></label>
        </li>
        <li>
            <span>
                <input type="text" name="provider_firstname" id="provider_firstname" value="<?= e($hstData['provider_firstname']) ?>" />
                <label for="provider_firstname">Provider First Name</label>
            </span>
            <span>
                <input type="text" name="provider_lastname" id="provider_lastname" value="<?= e($hstData['provider_lastname']) ?>" />
                <label for="provider_lastname">Provider Last Name</label>
            </span>
            <span>
                <input type="text" name="provider_phone" id="provider_phone" value="<?= e($hstData['provider_phone']) ?>" />
                <label for="provider_phone">Phone</label>
            </span>
        </li>
        <li>
            <span>
                <input type="text" name="provider_address" id="provider_address" value="<?= e($hstData['provider_address']) ?>" />
                <label for="provider_address"> Address</label>
            </span>
            <span>
                <input type="text" name="provider_city" id="provider_city" value="<?= e($hstData['provider_city']) ?>" />
                <label for="provider_city">City</label>
            </span>
            <span>
                <input type="text" name="provider_state" id="provider_state" value="<?= e($hstData['provider_state']) ?>" />
                <label for="provider_state">State</label>
            </span>
            <span>
                <input type="text" name="provider_zip" id="provider_zip" value="<?= e($hstData['provider_zip']) ?>" />
                <label for="provider_zip">Zip</label>
            </span>
        </li>
        <li>
            <span>
                <input type="text" name="provider_date" id="provider_date" value="<?= e($hstData['provider_date']) ?>" />
                <label for="provider_date">Date</label>
            </span>
        </li>
        <li>
            <p>
                <label class="desc">Transmitted Electronically Via DS3 Software.</label>
            </p>
            <label class="desc"><?= e($bu_r['name']) ?></label>
        </li>
        <li>
            Office: <?= format_phone($bu_r['phone']) ?>
            -
            Fax: <?= format_phone($bu_r['fax']) ?>
            -
            Email: <?= e($bu_r['email']) ?>
        </li>
    </ul>
    <?php if ($showSubmitAction) { ?>
        <p class="submit-action">
            <strong>By the below order HST button you are providing a digital signature ordering the HST</strong>
        </p>
        <p class="submit-action">
            <input class="button" type="submit" name="submit" value="Request HST" />
            <a class="red" style="float:right;" href="/manage/add_patient.php?ed=<?= $patientId ?>&pid=<?= $patientId ?>"
               onclick="return confirm('Are you sure you want to cancel?');">Cancel</a>
        </p>
    <?php } ?>
</form>
<br />
<script src="/manage/js/hst_request.js" type="text/javascript"></script>
<script>
    jQuery(function($){
        var $hstRadioButtons = $('[name=hst_type]:radio'),
            $hstContainers = $hstRadioButtons.closest('li');

        $hstRadioButtons.change(function(){
            $hstContainers.find('.container').hide();
            $(this).closest('li').find('.container').show();
        });

        $('[name=hst_3_nights]').change(function(){
            var $this = $(this),
                $container = $hstContainers.last().find('.container'),
                $fields = $container.find('span.field-position'),
                $first = $fields.first(),
                $rest = $fields.not(':eq(0)'),
                $clone;

            $rest.remove();

            for (var n=1;n<$this.val();n++) {
                $clone = $first.clone();
                $clone.find('input').attr('id', 'device-position-' + n).attr('name', 'hst_device_position[' + n + ']');
                $clone.find('label').attr('for', 'device-position-' + n).text('For night ' + (n + 1));
                $clone.appendTo($container);
            }
        });

        /**
         * If data view mode, hide submit buttons
         */
        if ($('[name=company_id]:radio').length) {
            $('#hst_order_sleep_services')
                .find('input, select')
                .not(':radio:checked')
                .prop('disabled', true);

            $('#hst_order_sleep_services').find('[type=submit], .submit-action').hide();
        }
    }(jQuery));
</script>
