<?php
namespace Ds3\Libraries\Legacy;

include "includes/top.htm";
include_once '../includes/constants.inc';
include_once "includes/general.htm";

$fid = (int)array_get($_REQUEST, 'fid', 0);
$pid = (int)array_get($_REQUEST, 'pid', 0);
$iid = (int)array_get($_REQUEST, 'iid', 0);

$isSuperAdmin = is_super($_SESSION['admin_access']);
$adminCompanyId = (int)$_SESSION['admincompanyid'];

if ($fid) {
    $account_name = $db->getColumn("SELECT CONCAT(last_name, ' ', first_name) AS name
        FROM dental_users
        WHERE userid = '$fid'", 'name', '');
}

if ($pid) {
    $patient_name = $db->getColumn("SELECT CONCAT(lastname, ' ', firstname) AS name
        FROM dental_patients
        WHERE patientid = '$pid'", 'name', '');
}

if ($iid) {
    $insurance_name = $db->getColumn("SELECT company
        FROM dental_contact
        WHERE contactid = '$iid'", 'company', '');
}

function insert_preauth_row($patient_id)
{
    if (empty($patient_id)) {
        return;
    }

    $db = new Db();

    $sql = "SELECT 
        p.patientid as 'patient_id', i.company as 'ins_co', 'primary' as 'ins_rank', i.phone1 as 'ins_phone', 
        p.p_m_ins_grp as 'patient_ins_group_id', p.p_m_ins_id as 'patient_ins_id', 
        p.firstname as 'patient_firstname', p.lastname as 'patient_lastname', 
        p.add1 as 'patient_add1', p.add2 as 'patient_add2', p.city as 'patient_city', 
        p.state as 'patient_state', p.zip as 'patient_zip', p.dob as 'patient_dob', 
        p.p_m_partyfname as 'insured_first_name', p.p_m_partylname as 'insured_last_name', 
        p.ins_dob as 'insured_dob', d.npi as 'doc_npi', r.national_provider_id as 'referring_doc_npi', 
        d.medicare_npi as 'doc_medicare_npi', d.tax_id_or_ssn as 'doc_tax_id_or_ssn', 
        tc.amount as 'trxn_code_amount', q2.confirmed_diagnosis as 'diagnosis_code', 
        d.userid as 'doc_id'
        FROM dental_patients p
        JOIN dental_contact r ON p.referred_by = r.contactid  
        JOIN dental_contact i ON p.p_m_ins_co = i.contactid 
        JOIN dental_users d ON p.docid = d.userid 
        JOIN dental_transaction_code tc ON p.docid = tc.docid AND tc.transaction_code = 'E0486' 
        JOIN dental_q_page2_pivot q2 ON p.patientid = q2.patientid
        WHERE p.patientid = '$patient_id'";

    $my_array = $db->getRow($sql);

    $sql = "INSERT INTO dental_insurance_preauth (
        patient_id, doc_id, ins_co, ins_rank, ins_phone, patient_ins_group_id, 
        patient_ins_id, patient_firstname, patient_lastname, patient_add1, 
        patient_add2, patient_city, patient_state, patient_zip, patient_dob, 
        insured_first_name, insured_last_name, insured_dob, doc_npi, referring_doc_npi, 
        trxn_code_amount, diagnosis_code, doc_medicare_npi, doc_tax_id_or_ssn, 
        front_office_request_date, status
        ) VALUES (
        '" . $my_array['patient_id'] . "', 
        '" . $my_array['doc_id'] . "', 
        '" . $my_array['ins_co'] . "', 
        '" . $my_array['ins_rank'] . "', 
        '" . $my_array['ins_phone'] . "', 
        '" . $my_array['patient_ins_group_id'] . "', 
        '" . $my_array['patient_ins_id'] . "', 
        '" . $my_array['patient_firstname'] . "', 
        '" . $my_array['patient_lastname'] . "', 
        '" . $my_array['patient_add1'] . "', 
        '" . $my_array['patient_add2'] . "', 
        '" . $my_array['patient_city'] . "', 
        '" . $my_array['patient_state'] . "', 
        '" . $my_array['patient_zip'] . "', 
        '" . $my_array['patient_dob'] . "', 
        '" . $my_array['insured_first_name'] . "', 
        '" . $my_array['insured_last_name'] . "', 
        '" . $my_array['insured_dob'] . "', 
        '" . $my_array['doc_npi'] . "', 
        '" . $my_array['referring_doc_npi'] . "', 
        '" . $my_array['trxn_code_amount'] . "',
        '" . $my_array['diagnosis_code'] . "', 
        '" . $my_array['doc_medicare_npi'] . "', 
        '" . $my_array['doc_tax_id_or_ssn'] . "', 
        '" . date('Y-m-d H:i:s') . "', "
       . DSS_PREAUTH_PENDING
       . ")";
    $db->query($sql);
}

if (!empty($_REQUEST['gen_preauth']) && $_REQUEST['gen_preauth'] == 1) {
    insert_preauth_row($_REQUEST['patient_id']);
}

define('SORT_BY_DATE', 0);
define('SORT_BY_STATUS', 1);
define('SORT_BY_PATIENT', 2);
define('SORT_BY_FRANCHISEE', 3);
define('SORT_BY_USER', 4);
define('SORT_BY_INSURANCE', 5);
define('SORT_BY_BC', 6);
define('SORT_BY_EDIT', 7);
$sort_dir = strtolower(!empty($_REQUEST['sort_dir']) ? $_REQUEST['sort_dir'] : '');
$sort_dir = (empty($sort_dir) || ($sort_dir != 'asc' && $sort_dir != 'desc')) ? 'asc' : $sort_dir;

$sort_by = (isset($_REQUEST['sort_by'])) ? $_REQUEST['sort_by'] : SORT_BY_STATUS;

switch ($sort_by) {
    case SORT_BY_DATE:
        $sort_by_sql = "preauth.front_office_request_date $sort_dir";
        break;
    case SORT_BY_PATIENT:
        $sort_by_sql = "p.lastname $sort_dir, p.firstname $sort_dir, preauth.front_office_request_date $sort_dir";
        break;
    case SORT_BY_INSURANCE:
        $sort_by_sql = "ins_co $sort_dir, preauth.front_office_request_date $sort_dir";
        break;
    case SORT_BY_FRANCHISEE:
        $sort_by_sql = "doc_name $sort_dir, preauth.front_office_request_date $sort_dir";
        break;
    case SORT_BY_USER:
        $sort_by_sql = "user_name $sort_dir, preauth.front_office_request_date $sort_dir";
        break;
    case SORT_BY_BC:
        $sort_by_sql = "owner_billing_name $sort_dir, preauth.front_office_request_date $sort_dir";
        break;
    case SORT_BY_EDIT:
        $sort_by_sql = "preauth.updated_at $sort_dir, preauth.front_office_request_date $sort_dir";
        break;
    default:
        // default is SORT_BY_STATUS
        $sort_by_sql = "preauth.status $sort_dir, preauth.front_office_request_date $sort_dir";
        break;
}

$status = (isset($_REQUEST['status']) && ($_REQUEST['status'] != '')) ? $_REQUEST['status'] : -1;

if (!empty($_REQUEST["delid"]) && is_super($_SESSION['admin_access'])) {
    $del_sql = "delete from dental_insurance_preauth where id='".$_REQUEST["delid"]."'";
    $db->query($del_sql);

    $msg= "Deleted Successfully";
    ?>
    <script type="text/javascript">
        window.location="<?php echo $_SERVER['PHP_SELF']?>?msg=<?php echo $msg?>";
    </script>
    <?php
    trigger_error("Die called", E_USER_ERROR);
}

$rec_disp = (int)array_get($_GET, 'count', 20);

if (!empty($_REQUEST["page"])) {
    $index_val = $_REQUEST["page"];
} else {
    $index_val = 0;
}
$i_val = $index_val * $rec_disp;

$escapedPendingStatus = $db->escape(DSS_PREAUTH_PENDING);
$totalVobSubQuery = '0';
$joinByUserCompany = '';
$conditionals = [];

if ($isSuperAdmin) {
    $totalVobSubQuery = "(
        SELECT COUNT(dip.id)
        FROM dental_insurance_preauth dip
        WHERE dip.patient_id = p.patientid
    )";
} elseif (is_billing($_SESSION['admin_access'])) {
    /**
     * Doctor billing company can see all VOBs. Former billing companies can see all owned by them, except if they
     * are DSS_PREAUTH_PENDING.
     */
    $conditionals[] = "doctor_billing_company.id = '$adminCompanyId'
        OR (
            preauth.status NOT IN ($escapedPendingStatus)
            AND vob_billing_company.id = '$adminCompanyId'
        )";
} else {
    /**
     * Restrict by HST company
     */
    $joinByUserCompany = "JOIN dental_user_company uc ON uc.userid = p.docid AND uc.companyid = '$adminCompanyId'";
}

$sql = "SELECT
    preauth.id,
    preauth.patient_id,
    i.company AS ins_co,
    p.firstname AS patient_firstname,
    p.lastname AS patient_lastname,
    preauth.doc_id,
    preauth.updated_at,
    preauth.front_office_request_date,
    CONCAT(doctor.first_name, ' ', doctor.last_name) AS doc_name,
    preauth.status,
    DATEDIFF(NOW(), preauth.front_office_request_date) AS days_pending,
    CONCAT(staff.first_name, ' ', staff.last_name) AS user_name,
    $totalVobSubQuery AS total_vob,
    doctor_billing_company.name AS current_billing_name,
    vob_billing_company.name AS stored_billing_name,
    CASE
        WHEN preauth.status IN ($escapedPendingStatus) THEN doctor_billing_company.name
        WHEN IFNULL(vob_billing_company.id, 0) = 0 THEN doctor_billing_company.name
        ELSE vob_billing_company.name
    END AS owner_billing_name,
    doctor_billing_company.id AS current_billing_company_id,
    vob_billing_company.id AS stored_billing_company_id
    FROM dental_insurance_preauth preauth
    JOIN dental_patients p ON preauth.patient_id = p.patientid
    JOIN dental_users doctor ON preauth.doc_id = doctor.userid
    LEFT JOIN dental_users staff ON preauth.userid = staff.userid
    LEFT JOIN dental_contact i ON p.p_m_ins_co = i.contactid
    LEFT JOIN companies doctor_billing_company ON doctor_billing_company.id = doctor.billing_company_id
    LEFT JOIN admin owner ON owner.adminid = preauth.updated_by
    LEFT JOIN admin_company ac ON ac.adminid = owner.adminid
    LEFT JOIN companies vob_billing_company ON vob_billing_company.id = ac.companyid
    $joinByUserCompany
";

// filter based on select lists above table
if ((isset($_REQUEST['status']) && ($_REQUEST['status'] != '')) || !empty($fid)) {
    if (isset($_REQUEST['status']) && ($_REQUEST['status'] != '')) {
        $statuses = preAuthStatusSequence($_REQUEST['status']);
        $statuses = $db->escapeList($statuses);
        $conditionals[] = "preauth.status IN ($statuses)";
    }
    if (!empty($fid)) {
        $conditionals[] = "doctor.userid = '$fid'";
    }
    if (!empty($pid)) {
        $conditionals[] = "preauth.patient_id = '$pid'";
    }
    if (!empty($iid)) {
        $conditionals[] = "p.p_m_ins_co = '$iid'";
    }
}
$whereConditionals = '';
if (count($conditionals)) {
    $conditionals = '(' . join(') AND (', $conditionals) . ')';
    $whereConditionals = "WHERE $conditionals";
}
$sql .= " $whereConditionals ORDER BY $sort_by_sql";
$total_rec = $db->getNumberRows($sql);
$no_pages = $total_rec / $rec_disp;

$sql .= " limit ".$i_val.",".$rec_disp;
$my = $db->getResults($sql);

$pending_selected = ($status == DSS_PREAUTH_PENDING) ? 'selected' : '';
$preauth_selected = ($status == DSS_PREAUTH_PREAUTH_PENDING) ? 'selected' : '';
$complete_selected = ($status == DSS_PREAUTH_COMPLETE) ? 'selected' : '';
?>
<link rel="stylesheet" type="text/css" media="screen" href="popup/popup.css" />
<link rel="stylesheet" type="text/css" media="screen" href="/manage/css/search-hints.css" />
<script type="text/javascript" src="popup/popup.js"></script>
<script type="text/javascript" src="/manage/admin/js/manage_vobs.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        if ($('#patient_hints').length) {
            setup_autocomplete(
                'patient_name',
                'patient_hints',
                'pid',
                '',
                'list_patients_search.php?fid=<?php echo $fid; ?>',
                'patient',
                getParameterByName('pid')
            );
            setup_autocomplete(
                'insurance_name',
                'insurance_hints',
                'iid',
                '',
                'list_insurance_search.php?fid=<?= $fid ?>',
                'insurance',
                getParameterByName('pid')
            );
        }
    });
</script>

<div class="page-header">
    Manage Verification of Benefits
</div>
<div align="center" class="red">
    <b><?php echo (!empty($_GET['msg']) ? $_GET['msg'] : '');?></b>
</div>
<div style="width:98%;margin:auto;">
    <form name="sortfrm" action="<?php echo $_SERVER['PHP_SELF']?>" method="get">
        Status:
        <select name="status">
            <option value="">Any</option>
            <option value="<?= DSS_PREAUTH_PENDING ?>" <?= $pending_selected ?>>
                <?= $dss_preauth_status_labels[DSS_PREAUTH_PENDING] ?>
            </option>
            <option value="<?= DSS_PREAUTH_PREAUTH_PENDING ?>" <?= $preauth_selected ?>>
                <?= $dss_preauth_status_labels[DSS_PREAUTH_PREAUTH_PENDING] ?>
            </option>
            <option value="<?= DSS_PREAUTH_COMPLETE ?>" <?= $complete_selected ?>>
                <?= $dss_preauth_status_labels[DSS_PREAUTH_COMPLETE]?>
            </option>
        </select>
        &nbsp;&nbsp;&nbsp;
        Account:
        <input type="text" id="account_name" onclick="updateval(this)" autocomplete="off" name="account_name" value="<?= ($fid != '') ? $account_name : 'Type contact name' ?>" />
        <div id="account_hints" class="search_hints" style="display:none;">
            <ul id="account_list" class="search_list">
                <li class="template" style="display:none">Doe, John S</li>
            </ul>
        </div>
        <?php if (!empty($fid)) { ?>
            Patients:
            <input type="text" id="patient_name" onclick="updateval(this)" autocomplete="off" name="patient_name" value="<?= ($pid != '') ? $patient_name : 'Type patient name' ?>" />
            <div id="patient_hints" class="search_hints" style="display:none;">
                <ul id="patient_list" class="search_list">
                    <li class="template" style="display:none">Doe, John S</li>
                </ul>
            </div>
            <input type="hidden" name="pid" id="pid" value="<?= $pid ?>" />
            &nbsp;&nbsp;&nbsp;
            Insurance:
            <input type="text" id="insurance_name" onclick="updateval(this)" autocomplete="off" name="insurance_name" value="<?= ($iid != '') ? $insurance_name : 'Type contact name' ?>" />
            <div id="insurance_hints" class="search_hints" style="display:none;">
                <ul id="insurance_list" class="search_list">
                    <li class="template" style="display:none">Doe, John S</li>
                </ul>
            </div>
            <input type="hidden" name="iid" id="iid" value="<?= $iid ?>" />
        <?php } ?>
        <input type="hidden" name="fid" id="fid" value="<?= $fid ?>" />
        <input type="hidden" name="sort_by" value="<?= $sort_by ?>" />
        <input type="hidden" name="sort_dir" value="<?= $sort_dir ?> "/>
        <input type="submit" value="Filter List" class="btn btn-primary">
        <input type="button" value="Reset" onclick="window.location='<?= $_SERVER['PHP_SELF'] ?>'" class="btn btn-primary">
    </form>
</div>

<form name="pagefrm" action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
    <table class="table table-bordered table-hover">
        <?php if ($total_rec > $rec_disp) { ?>
            <tr bgcolor="#ffffff">
                <td align="right" colspan="15" class="bp">
                    Pages:
                    <?php
                    paging($no_pages, $index_val, "fid=".$_GET['fid']."&pid=". $_GET['pid']."&status=". $_GET['status']."&sort_by=".$_GET['sort_by']."&sort_dir=".$_GET['sort_dir']);
                    ?>
                </td>
            </tr>
        <?php } ?>
        <?php
        $sort_qs = $_SERVER['PHP_SELF'] . "?fid=" . $fid . "&pid=" . $pid . "&status=" . (!empty($_REQUEST['status']) ? $_REQUEST['status'] : '') . "&sort_by=%s&sort_dir=%s";
        ?>
        <tr class="tr_bg_h">
            <td valign="top" class="col_head <?php echo get_sort_arrow_class($sort_by, SORT_BY_DATE, $sort_dir) ?>" width="15%">
                <a href="<?php echo sprintf($sort_qs, SORT_BY_DATE, get_sort_dir($sort_by, SORT_BY_DATE, $sort_dir))?>">Requested</a>
            </td>
            <td valign="top" class="col_head <?php echo get_sort_arrow_class($sort_by, SORT_BY_EDIT, $sort_dir) ?>" width="15%">
                <a href="<?php echo sprintf($sort_qs, SORT_BY_EDIT, get_sort_dir($sort_by, SORT_BY_EDIT, $sort_dir))?>">Last Edit</a>
            </td>
            <td valign="top" class="col_head <?php echo get_sort_arrow_class($sort_by, SORT_BY_STATUS, $sort_dir) ?>" width="10%">
                <a href="<?php echo sprintf($sort_qs, SORT_BY_STATUS, get_sort_dir($sort_by, SORT_BY_STATUS, $sort_dir))?>">Status</a>
            </td>
            <td valign="top" class="col_head <?php echo get_sort_arrow_class($sort_by, SORT_BY_PATIENT, $sort_dir) ?>" width="20%">
                <a href="<?php echo sprintf($sort_qs, SORT_BY_PATIENT, get_sort_dir($sort_by, SORT_BY_PATIENT, $sort_dir))?>">Patient Name</a>
            </td>
            <td valign="top" class="col_head <?php echo get_sort_arrow_class($sort_by, SORT_BY_INSURANCE, $sort_dir) ?>" width="20%">
                <a href="<?php echo sprintf($sort_qs, SORT_BY_INSURANCE, get_sort_dir($sort_by, SORT_BY_INSURANCE, $sort_dir))?>">Insurance</a>
            </td>
            <td valign="top" class="col_head <?php echo get_sort_arrow_class($sort_by, SORT_BY_FRANCHISEE, $sort_dir) ?>" width="20%">
                <a href="<?php echo sprintf($sort_qs, SORT_BY_FRANCHISEE, get_sort_dir($sort_by, SORT_BY_FRANCHISEE, $sort_dir))?>">Account</a>
            </td>
            <td valign="top" class="col_head <?php echo get_sort_arrow_class($sort_by, SORT_BY_USER, $sort_dir) ?>" width="20%">
                <a href="<?php echo sprintf($sort_qs, SORT_BY_USER, get_sort_dir($sort_by, SORT_BY_USER, $sort_dir))?>">User</a>
            </td>
            <td valign="top" class="col_head <?php echo get_sort_arrow_class($sort_by, SORT_BY_BC, $sort_dir) ?>" width="20%">
                <a href="<?php echo sprintf($sort_qs, SORT_BY_BC, get_sort_dir($sort_by, SORT_BY_BC, $sort_dir))?>">Billing Company</a>
            </td>
            <td valign="top" class="col_head" width="15%">
                Action
            </td>
        </tr>
        <?php
        if (!count($my)) { ?>
            <tr class="tr_bg">
                <td valign="top" class="col_head" colspan="6" align="center">
                    No Records
                </td>
            </tr>
            <?php
        } else {
            foreach ($my as $myarray) {
                $status = (int)$myarray['status'];
                $isAnyPendingStatus = in_array($status, [DSS_PREAUTH_PENDING, DSS_PREAUTH_PREAUTH_PENDING]);
                $canEdit = preAuthEditPermission($myarray, $adminCompanyId, $isSuperAdmin);

                $status_color = 'success';
                $link_label = 'View';
                $clientClass = 'former-client';

                if ($isAnyPendingStatus) {
                    $status_color = 'warning';
                    if ((int)$myarray['days_pending'] > 7) {
                        $status_color = 'danger';
                    }
                }

                if ($canEdit) {
                    $link_label = 'Edit';
                }

                if ($isSuperAdmin || (int)$myarray['current_billing_company_id'] === $adminCompanyId) {
                    $clientClass = 'current-client';
                }
                ?>
                <tr class="<?= (isset($tr_class) ? $tr_class : '') ?> <?= $clientClass ?>">
                    <td valign="top">
                        <?php echo st($myarray["front_office_request_date"]);?>&nbsp;
                    </td>
                    <td valign="top">
                        <?php echo st($myarray["updated_at"]);?>&nbsp;
                    </td>
                    <td valign="top" class="<?php echo $status_color; ?>">
                        <?php echo st($dss_preauth_status_labels[$status]);?>&nbsp;
                    </td>
                    <td valign="top">
                        <a href="view_patient.php?pid=<?= e($myarray['patient_id']) ?>">
                            <?= e("{$myarray['patient_lastname']}, {$myarray['patient_firstname']}") ?> (View Chart)
                        </a>
                    </td>
                    <td valign="top">
                        <?php echo st($myarray["ins_co"]);?>&nbsp;
                    </td>
                    <td valign="top">
                        <a href="view_user.php?ed=<?= $myarray['doc_id'] ?>"><?= e($myarray["doc_name"]) ?></a>
                        &nbsp;
                    </td>
                    <td valign="top">
                        <?php echo st($myarray["user_name"]);?>&nbsp;
                    </td>
                    <td valign="top">
                        <?= e($myarray['owner_billing_name']) ?>
                        &nbsp;
                    </td>
                    <td valign="top">
                        <a class="btn btn-primary btn-sm" title="<?= $link_label ?>" href="process_vob_page.php?ed=<?= $myarray["id"] ?>">
                            <?= $link_label ?>
                            <span class="glyphicon glyphicon-pencil"></span>
                        </a>
                        <a class="btn btn-primary btn-sm" title="<?= $link_label ?>" href="manage_vobs.php?fid=<?= $myarray['doc_id'] ?>&pid=<?= $myarray["patient_id"] ?>">
                            History
                            <?php if ($myarray['total_vob'] > 1) { ?>
                                (<?= $myarray['total_vob'] ?>)
                            <?php } ?>
                        </a>
                    </td>
                </tr>
                <?php
            }
        } ?>
    </table>
</form>

<div id="popupContact" style="width:750px;height:500px;">
    <a id="popupContactClose"><span class="glyphicon glyphicon-remove"></span></a>
    <iframe id="aj_pop" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
</div>
<div id="backgroundPopup"></div>

<br /><br />	
<?php

include __DIR__ . '/includes/bottom.htm';

/**
 * Determine next status to set in the VOB.
 *
 * @param int $initialStatus
 * @return array
 */
function preAuthStatusSequence($initialStatus)
{
    $initialStatus = (int)$initialStatus;
    
    if ($initialStatus === DSS_PREAUTH_PENDING) {
        return [$initialStatus, DSS_PREAUTH_PREAUTH_PENDING];
    }

    if ($initialStatus === DSS_PREAUTH_COMPLETE) {
        return [$initialStatus, DSS_PREAUTH_REJECTED];
    }

    return [$initialStatus];
}

/**
 * Determine edit permissions. Only Pending statuses can be edited.
 *
 * @param array $preAuthData
 * @param int   $adminCompanyId
 * @param bool  $isSuperAdmin
 * @return bool
 */
function preAuthEditPermission(array $preAuthData, $adminCompanyId, $isSuperAdmin)
{
    $status = (int)$preAuthData['status'];
    $isStatusPending = $status === DSS_PREAUTH_PENDING;
    $isStatusPreAuth = $status === DSS_PREAUTH_PREAUTH_PENDING;
    $isAnyPendingStatus = $isStatusPending || $isStatusPreAuth;

    if (!$isAnyPendingStatus) {
        return false;
    }

    if ($isSuperAdmin) {
        return true;
    }

    $currentBillingCompanyId = (int)$preAuthData['current_billing_company_id'];
    $storedBillingCompanyId = (int)$preAuthData['stored_billing_company_id'];

    if (!$currentBillingCompanyId && !$storedBillingCompanyId) {
        return false;
    }

    if ($currentBillingCompanyId === $storedBillingCompanyId) {
        return true;
    }

    $isCurrentBillingCompany = $currentBillingCompanyId === $adminCompanyId;
    $isStoredBillingCompany = $storedBillingCompanyId === $adminCompanyId;

    if ($isStoredBillingCompany && $isStatusPreAuth) {
        return true;
    }

    if ($isCurrentBillingCompany && $isStatusPending) {
        return true;
    }

    return false;
}
