<?php
namespace Ds3\Libraries\Legacy;

require_once __DIR__ . '/../../includes/constants.inc';
require_once __DIR__ . '/../../includes/hst_functions.php';

$is_front_office = empty($is_back_office);
$hstCompanyType = DSS_COMPANY_TYPE_HST;

if (!empty($_REQUEST['hst_id'])) {
    $hstId = intval($_REQUEST['hst_id']);

    $hstData = $db->getRow("SELECT * FROM dental_hst WHERE id = '$hstId'");
    $patientId = $hstData ? $hstData['patient_id'] : 0;
    $hstCompanyId = $hstData ? $hstData['company_id'] : 0;
} else {
    $patientId = intval($_GET['ed']);
    $hstCompanyId = intval($_GET['hst_co']);
    $hstCompanyCompleteStatuses = $db->escapeList([DSS_HST_COMPLETE, DSS_HST_REJECTED, DSS_HST_CANCELED]);

    $hstData = $db->getRow("SELECT *
        FROM dental_hst
        WHERE patient_id = '$patientId'
            AND company_id = '$hstCompanyId'
            AND status NOT IN ($hstCompanyCompleteStatuses)");
    $hstId = $hstData ? $hstData['id'] : 0;
}

if ($is_front_office) {
    $userId = $is_front_office ? intval($_SESSION['userid']) : 0;
    $docId = $is_front_office ? intval($_SESSION['docid']) : 0;

    $isStaff = $userId == $docId ||
        $db->getColumn("SELECT sign_notes FROM dental_users WHERE userid = '$userId'", 'sign_notes');

    $authorizedProviderJoinConditional = $isStaff ? "'$userId'" : "'$docId'";
} else {
    $userId = 0;
    $docId = intval($db->getColumn("SELECT docid FROM dental_patients WHERE patientid = '$patientId'"));

    $isStaff = false;
    $authorizedProviderJoinConditional = 'p.docid';
}

$hstCompanyList = $db->getResults("SELECT h.*, uhc.id as uhc_id
    FROM companies h
        JOIN dental_user_hst_company uhc ON uhc.companyid = h.id
            AND uhc.userid = '$docId'
    WHERE h.company_type = '$hstCompanyType'
    ORDER BY name ASC");

$hstCompany = $db->getRow("SELECT h.*, uhc.id as uhc_id
    FROM companies h
        JOIN dental_user_hst_company uhc ON uhc.companyid = h.id
            AND uhc.userid = '$docId'
    WHERE h.company_type = '$hstCompanyType'
        AND h.id = '$hstCompanyId'
    ORDER BY name ASC");

$patientData = $db->getRow("SELECT
        p.firstname AS 'patient_firstname',
        p.lastname AS 'patient_lastname',
        p.dob AS 'patient_dob',
        p.add1 AS 'patient_add1',
        p.add2 AS 'patient_add2',
        p.city AS 'patient_city',
        p.state AS 'patient_state',
        p.zip AS 'patient_zip',
        p.cell_phone AS 'patient_cell_phone',
        p.home_phone AS 'patient_home_phone',
        p.email AS 'patient_email',
        p.p_m_ins_id AS 'patient_ins_id',
        p.p_m_ins_grp AS 'patient_ins_group_id',
        p.p_m_ins_co AS 'ins_co_id',
        i.phone1 AS 'ins_phone',
        u.first_name AS 'provider_firstname',
        u.last_name AS 'provider_lastname',
        IF(u.producer_files AND LENGTH(TRIM(u.phone)), u.phone, d.phone) AS 'provider_phone',
        IF(u.producer_files AND LENGTH(TRIM(u.address)), u.address, d.address) AS 'provider_address',
        IF(u.producer_files AND LENGTH(TRIM(u.city)), u.city, d.city) AS 'provider_city',
        IF(u.producer_files AND LENGTH(TRIM(u.state)), u.state, d.state) AS 'provider_state',
        IF(u.producer_files AND LENGTH(TRIM(u.zip)), u.zip, d.zip) AS 'provider_zip'
    FROM dental_patients p
        LEFT JOIN dental_contact i ON i.contactid = p.p_m_ins_co
        LEFT JOIN dental_users u ON u.userid = $authorizedProviderJoinConditional
        LEFT JOIN dental_users d ON d.userid = IF(u.docid, u.docid, u.userid)
    WHERE p.patientid = '$patientId'");

$hstData = !empty($hstData) ? $hstData : [];

if ($patientData) {
    /**
     * @see DSS-166
     *
     * If the HST request has not been found, create a new set to be displayed
     * Otherwise, complete blank fields for HST not requested (status = DSS_HST_REQUESTED)
     */
    if (!$hstData) {
        $hstData = $patientData + [
                'company_id' => 0,
                'diagnosis_id' => 0,
                'hst_type' => 0,
                'hst_nights' => 2,
                'hst_positions' => '',
                'provider_signature' => 1,
                'provider_date' => date('m/d/Y'),
            ];
    } elseif ($hstData['status'] == DSS_HST_REQUESTED) {
        foreach ($patientData as $field=>$value) {
            $hstData[$field] = $hstData[$field] ?: $value;
        }
    }
}

$hstData['hst_positions'] = @json_decode($hstData['hst_positions']);
$hstData['hst_positions'] = $hstData['hst_positions'] ?: [];

$diagnosticNightsLimit = 2;
$oatNightsLimit = 3;

$nightsDefault = $hstId ? $hstData['hst_nights'] : 2;

$canAuthorize = $is_front_office && $hstData['status'] == DSS_HST_REQUESTED && $isStaff;
$canFinishLater = $is_front_office && $hstData['status'] == DSS_HST_REQUESTED;

if ($is_front_office && isset($_POST['delete'])) {
    cancelHSTRequest($hstId, $userId);

    ?>
    <script type="text/javascript">
        window.location = '/manage/manage_hst.php?msg=<?= rawurlencode('HST Request deleted successfully.') ?>';
    </script>
    <?php

    trigger_error('Die called', E_USER_ERROR);
}

if ($hstData['status'] != DSS_HST_CANCELED && (isset($_POST['authorize']) || isset($_POST['save']))) {
    $hstId = intval($_POST['hst_id']);
    $authorize = !empty($_POST['authorize']);

    $updateData = [
        'company_id' => $_POST['company_id'],
        'ins_co_id' => $_POST['ins_co_id'],
        'ins_phone' => $_POST['ins_phone'],
        'patient_ins_group_id' => $_POST['patient_ins_group_id'],
        'patient_ins_id' => $_POST['patient_ins_id'],
        'patient_firstname' => $_POST['patient_firstname'],
        'patient_lastname' => $_POST['patient_lastname'],
        'patient_add1' => $_POST['patient_add1'],
        'patient_add2' => $_POST['patient_add2'],
        'patient_city' => $_POST['patient_city'],
        'patient_state' => $_POST['patient_state'],
        'patient_zip' => $_POST['patient_zip'],
        'patient_dob' => date('Y-m-d', strtotime($_POST['patient_dob'])),
        'patient_cell_phone' => $_POST['patient_cell_phone'],
        'patient_home_phone' => $_POST['patient_home_phone'],
        'patient_email' => $_POST['patient_email'],
        'diagnosis_id' => $_POST['diagnosis_id'],
        'hst_type' => $_POST['hst_type'],
        'hst_nights' => $_POST['hst_type'] == 3 ? $_POST['hst_3_nights'] : $_POST['hst_1_nights'],
        'hst_positions' => @json_encode($_POST['hst_device_position']),
        'provider_firstname' => $_POST['provider_firstname'],
        'provider_lastname' => $_POST['provider_lastname'],
        'provider_phone' => $_POST['provider_phone'],
        'provider_address' => $_POST['provider_address'],
        'provider_city' => $_POST['provider_city'],
        'provider_state' => $_POST['provider_state'],
        'provider_zip' => $_POST['provider_zip'],
        'provider_signature' => $_POST['provider_signature'],
        'provider_date' => date('Y-m-d', strtotime($_POST['provider_date'])),
    ];

    if ($hstId) {
        $updateData = $db->escapeAssignmentList($updateData);
        $db->query("UPDATE dental_hst SET $updateData WHERE id = '$hstId'");
    } else {
        $thorton_sql = "SELECT * FROM dental_thorton WHERE patientid = '$patientId'";
        $thorton = $db->getRow($thorton_sql);

        $insertData = $updateData + [
            'patient_id' => $patientId,
            'doc_id' => $docId,
            'user_id' => $userId,
            'snore_1' => $thorton['snore_1'],
            'snore_2' => $thorton['snore_2'],
            'snore_3' => $thorton['snore_3'],
            'snore_4' => $thorton['snore_4'],
            'snore_5' => $thorton['snore_5'],
            'status' => DSS_HST_REQUESTED,
            'ip_address' => $_SERVER['REMOTE_ADDR']
        ];

        $insertData = $db->escapeAssignmentList($insertData);

        $hstId = $db->getInsertId("INSERT INTO dental_hst
            SET $insertData, authorized_id = NULL, authorizeddate = NULL, adddate = NOW()");
    }

    if (!$authorize) { ?>
        <script type="text/javascript">
            window.location = '/manage/manage_hst.php?status=0&viewed=0';
        </script>
        <?php

        trigger_error('Die called', E_USER_ERROR);
    }

    if ($canAuthorize) {
        authorizeHSTRequest($hstId, $hstCompanyId, $userId, $docId);

        ?>
        <script type="text/javascript">
            window.location = 'add_patient.php?ed=<?= $patientId ?>&preview=1&addtopat=1&pid=<?= $patientId ?>';
        </script>
        <?php

        trigger_error('Die called', E_USER_ERROR);
    }
}

$insuranceCompanyList = [];
$unorderedInsuranceCompanyList = $db->getResults("SELECT contactid AS id, company AS name, phone1 AS phone
    FROM dental_contact
    WHERE contacttypeid = '11'
        AND docid = '$docId'");

foreach ($unorderedInsuranceCompanyList as $insuranceCompany) {
    $insuranceCompanyList[$insuranceCompany['id']] = $insuranceCompany;
}

$providerList = [];
$unorderedProviderList = $db->getResults("SELECT
        u.userid,
        u.first_name AS 'provider_firstname',
        u.last_name AS 'provider_lastname',
        IF(u.producer_files AND LENGTH(TRIM(u.phone)), u.phone, d.phone) AS 'provider_phone',
        IF(u.producer_files AND LENGTH(TRIM(u.address)), u.address, d.address) AS 'provider_address',
        IF(u.producer_files AND LENGTH(TRIM(u.city)), u.city, d.city) AS 'provider_city',
        IF(u.producer_files AND LENGTH(TRIM(u.state)), u.state, d.state) AS 'provider_state',
        IF(u.producer_files AND LENGTH(TRIM(u.zip)), u.zip, d.zip) AS 'provider_zip'
    FROM dental_users u
        LEFT JOIN dental_users d ON d.userid = IF(u.docid, u.docid, u.userid)
    WHERE u.userid = '$docId'
        OR (u.docid = '$docId' AND u.sign_notes = 1)
    ORDER BY u.last_name, u.first_name, u.userid");

foreach ($unorderedProviderList as $provider) {
    $providerList[$provider['userid']] = $provider;
}

$defaultProvider = $isStaff ? $userId : $docId;

?>
<script>
    var providerList = <?= json_encode($providerList) ?>,
        insuranceCompanyList = <?= json_encode($insuranceCompanyList) ?>;
</script>
<script type="text/javascript" src="/manage/3rdParty/input_mask/jquery.maskedinput-1.3.min.js"></script>
<script type="text/javascript" src="/manage/js/masks.js"></script>
<?php require_once __DIR__ . '/../../includes/calendarinc.php' ?>
<link type="text/css" rel="stylesheet" href="/manage/css/form.css" />
<?php if (!empty($is_back_office)) { ?>
    <a href="/manage/admin/view_hst.php?ed=<?= $hstData['id'] ?><?=
        isset($_GET['status']) ? '&amp;ret_status=' . e($_GET['status']) : ''
    ?>" title="Back to HST Results" class="btn btn-primary btn-sm">
        <span class="glyphicon glyphicon-arrow-left"></span>
        HST Details
    </a>
<?php } ?>
<form id="hst_order_sleep_services" class="fullwidth" name="form1" method="post" action="#">
    <input type="hidden" name="hst_id" value="<?= $hstId ?>" />
    <input type="hidden" name="provider_signature" id="provider_signature" value="1" />

    <h3 align="center">Home Sleep Test Order Form For
        <?= e($hstData['patient_firstname'] . ' ' . $hstData['patient_lastname']) ?>
    </h3>

    <ul class="frmhead">
        <li>
            <label class="desc">Company</label>
            <hr />
            <?php foreach ($hstCompanyList as $company) { ?>
                <input type="radio" name="company_id" id="company-id-<?= $company['id'] ?>"
                       value="<?= $company['id'] ?>" <?= $company['id'] == $hstCompanyId ? 'checked' : '' ?> />
                <label for="company-id-<?= $company['id'] ?>"><?= e($company['name']) ?></label>
                <br />
            <?php } ?>
        </li>
    </ul>
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
                <input type="text" name="patient_dob" id="patient_dob" class="calendar"
                    onChange="validateDate('patient_dob');" placeholder="YYYY-MM-DD" data-date-format="Y-m-d"
                    value="<?= e($hstData['patient_dob']) ?>" />
                <label for="patient_dob">DOB</label>
            </span>
        </li>
        <li>
            <span>
                <input type="text" name="patient_add1" id="patient_add1" value="<?= e($hstData['patient_add1']) ?>" />
                <label for="patient_add1">Address 1</label>
            </span>
            <span>
                <input type="text" name="patient_add2" id="patient_add2" value="<?= e($hstData['patient_add2']) ?>" />
                <label for="patient_add2">Address 2</label>
            </span>
            <span>
                <input type="text" name="patient_city" id="patient_city" value="<?= e($hstData['patient_city']) ?>" />
                <label for="patient_city">City</label>
            </span>
            <span>
                <input type="text" name="patient_state" id="patient_state"
                    value="<?= e($hstData['patient_state']) ?>" />
                <label for="patient_state">State</label>
            </span>
            <span>
                <input type="text" name="patient_zip" id="patient_zip" class="zipmask" size="10"
                    value="<?= e($hstData['patient_zip']) ?>" />
                <label for="patient_zip">Zip</label>
            </span>
        </li>
        <li>
            <span>
                <input type="text" name="patient_cell_phone" id="patient_cell_phone" class="phonemask"
                    value="<?= e($hstData['patient_cell_phone']) ?>"/>
                <label for="patient_cell_phone">Mobile phone</label>
            </span>
            <span>
                <input type="text" name="patient_home_phone" id="patient_home_phone" class="phonemask"
                    value="<?= e($hstData['patient_home_phone']) ?>" />
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
                    <option value="" <?= !$hstData['p_m_ins_co'] ? 'selected' : '' ?>>Select Insurance Company</option>
                    <?php foreach ($insuranceCompanyList as $insuranceCompany) { ?>
                        <option value="<?= $insuranceCompany['id'] ?>"
                            <?= $hstData['ins_co_id'] == $insuranceCompany['id'] ? 'selected' : '' ?>>
                            <?= e(!empty($insuranceCompany['name']) ? $insuranceCompany['name'] : '') ?>
                        </option>
                    <?php } ?>
                </select>
                <label for="ins_co_id">Insurance Company</label>
            </span>
            <span>
                <input type="text" name="ins_phone" id="ins_phone" class="phonemask"
                    value="<?= e($hstData['ins_phone']) ?>" />
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
                <option <?= !$nightsDefault ? 'selected' : '' ?>></option>
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
                <option <?= !$nightsDefault ? 'selected' : '' ?>></option>
                <?php for ($n=1;$n<=$oatNightsLimit;$n++) { ?>
                    <option <?= $n == $nightsDefault ? 'selected' : '' ?>><?= $n ?></option>
                <?php } ?>
            </select>
            <p class="container" <?= $hstData['hst_type'] == 3 ? '' : 'style="display:none;"' ?>>
                <span>Device position:</span>
                <?php for ($n=0;!$n || $n<$nightsDefault;$n++) { ?>
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
        <li class="submit-action">
            <span>
                Select a provider to auto-populate the details:
                <select id="provider_selector">
                    <option></option>
                    <?php foreach ($providerList as $id=>$provider) { ?>
                        <option value="<?= $id ?>" <?= $id == $defaultProvider ? 'selected' : '' ?>>
                            <?= e($provider['provider_lastname'] . ', ' . $provider['provider_firstname']) ?>
                        </option>
                    <?php } ?>
                </select>
            </span>
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
                <input type="text" name="provider_phone" id="provider_phone" class="phonemask"
                    value="<?= e($hstData['provider_phone']) ?>" />
                <label for="provider_phone">Phone</label>
            </span>
        </li>
        <li>
            <span>
                <input type="text" name="provider_address" id="provider_address" value="<?= e($hstData['provider_address']) ?>" />
                <label for="provider_address">Address</label>
            </span>
            <span>
                <input type="text" name="provider_city" id="provider_city" value="<?= e($hstData['provider_city']) ?>" />
                <label for="provider_city">City</label>
            </span>
            <span>
                <input type="text" name="provider_state" id="provider_state"
                    value="<?= e($hstData['provider_state']) ?>" />
                <label for="provider_state">State</label>
            </span>
            <span>
                <input type="text" name="provider_zip" id="provider_zip" class="zipmask" size="10"
                    value="<?= e($hstData['provider_zip']) ?>" />
                <label for="provider_zip">Zip</label>
            </span>
        </li>
        <li>
            <span>
                <input type="text" name="provider_date" id="provider_date" class="calendar"
                    onChange="validateDate('provider_date');" placeholder="YYYY-MM-DD" data-date-format="Y-m-d"
                    value="<?= e($hstData['provider_date']) ?>" />
                <label for="provider_date">Date</label>
            </span>
        </li>
        <li>
            <p>
                <label class="desc">Transmitted Electronically Via DS3 Software.</label>
            </p>
            <label class="desc"><?= e($hstCompany['name']) ?></label>
        </li>
        <li>
            Office: <?= format_phone($hstCompany['phone']) ?>
            -
            Fax: <?= format_phone($hstCompany['fax']) ?>
            -
            Email: <?= e($hstCompany['email']) ?>
        </li>
    </ul>
    <?php if ($canAuthorize || $canFinishLater) { ?>
        <p class="submit-action">
            <strong>Click "Request HST" to authorize the order of this HST with your digital signature.</strong>
        </p>
        <p class="submit-action">
            <?php if ($canAuthorize) { ?>
                <input class="button" type="submit" name="authorize" value="Request HST" />
            <?php } ?>
            <?php if ($canFinishLater) { ?>
                <input class="button" type="submit" name="save" value="Save / Finish Later" />
            <?php } ?>
            <?php if ($canAuthorize) { ?>
                <a class="red" style="float:right;" href="/manage/manage_hst.php?delid=<?= $hstId ?>"
                   title="Cancel HST and delete from queue"
                   onclick="return confirm('Are you sure you want to delete this HST?');">Delete</a>
            <?php } ?>
        </p>
    <?php } ?>
</form>
<?php

if ($hstData['status'] == DSS_HST_COMPLETE) {
    $patientName = $hstData['patient_firstname'] . ' ' . $hstData['patient_lastname'];
    $patientDOB = $hstData['patient_dob'] ? date('m/d/Y', strtotime($hstData['patient_dob'])) : 'unknown';
    $authorizedDate = $hstData['authorizeddate'] ? date('m/d/Y', strtotime($hstData['authorizeddate'])) : 'unknown';
    $authorizedName = $db->getColumn("SELECT CONCAT(first_name, ' ', last_name) AS name
        FROM dental_users
        WHERE userid = '{$hstData['authorized_id']}'", 'name');

    ?>
    <h1>Home Sleep Test Request</h1>
    <h3>Patient: <?= e($patientName) ?></h3>
    <h3>DOB: <?= $patientDOB ?></h3>
    <h3>Requested by: <?= e($authorizedName) ?></h3>
    <p>&nbsp;</p>
    <p>Dr. <?= e($authorizedName) ?> has electronically requested a Home Sleep Test for <?= e($patientName) ?> for Obstructive Sleep Apnea (OSA).</p>
    <p>Authorized on: <?= $authorizedDate ?></p>
<?php } ?>
<br />
<script type="text/javascript" src="/manage/js/hst_request.js?v=20160208"></script>
