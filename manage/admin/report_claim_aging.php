<?php
namespace Ds3\Libraries\Legacy;

require_once __DIR__ . '/includes/top.htm';
require_once __DIR__ . '/includes/ledger-functions.php';

$is_front_office = false;
$is_back_office = true;

$subQueries = ledgerBalanceSubQueries('claim', 'claim');
$andDocIdConditional = isset($_GET['fid']) ? " AND p.docid = '" . intval($_GET['fid']) . "' " : '';
$andBillingIdConditional = '';

if (isset($_GET['bc'])) {
    $andBillingIdConditional = " AND COALESCE(i.p_m_billing_id, 0) ";
} elseif (isset($_GET['nbc'])) {
    $andBillingIdConditional = " AND NOT COALESCE(i.p_m_billing_id, 0) ";
}

switch ($_GET['group_by']) {
    case 'insurance':
        $groupId = 'p_m_ins_co';
        $groupName = 'insurance';

        $sortBy = 'primary_insurance.company, secondary_insurance.company';
        $groupBy = 'p.p_m_ins_co';
        break;
    case 'patient':
    default:
        $groupId = 'patientid';
        $groupName = 'patient';

        $sortBy = 'p.lastname ASC, p.firstname ASC';
        $groupBy = 'p.patientid';
        break;
}

if (is_super($_SESSION['admin_access'])) {
    $sql = "SELECT
            p.firstname,
            p.lastname,
            CONCAT(u.first_name, ' ', u.last_name) AS doc_name,
            p.patientid,
            p.p_m_ins_co,
            p.s_m_ins_co,
            primary_insurance.company AS primary_insurance,
            secondary_insurance.company AS secondary_insurance
        FROM dental_patients p
            LEFT JOIN dental_users u ON u.userid = p.docid
            LEFT JOIN dental_contact primary_insurance ON primary_insurance.contactid = p.p_m_ins_co
                AND primary_insurance.merge_id IS NULL
                AND primary_insurance.docid = p.docid
            LEFT JOIN dental_contact secondary_insurance ON secondary_insurance.contactid = p.s_m_ins_co
                AND secondary_insurance.merge_id IS NULL
                AND secondary_insurance.docid = p.docid
        WHERE (
            SELECT SUM(
                {$subQueries['debits']}
                - {$subQueries['credits']}
                - {$subQueries['adjustments']}
            )
            FROM dental_insurance claim
            WHERE claim.patientid = p.patientid
                AND claim.mailed_date IS NOT NULL
                $andBillingIdConditional
        ) > 0
        $andDocIdConditional
        GROUP BY $groupBy
        ORDER BY $sortBy
        ";
} elseif (is_software($_SESSION['admin_access'])) {
    $adminCompanyId = intval($_SESSION['admincompanyid']);

    $sql = "SELECT
            p.firstname,
            p.lastname,
            CONCAT(u.first_name, ' ', u.last_name) AS doc_name,
            p.patientid,
            p.p_m_ins_co,
            p.s_m_ins_co,
            primary_insurance.company AS primary_insurance,
            secondary_insurance.company AS secondary_insurance
        FROM dental_patients p
            JOIN dental_users u ON u.userid = p.docid
            JOIN dental_user_company uc ON uc.userid = u.userid
            LEFT JOIN dental_contact primary_insurance ON primary_insurance.contactid = p.p_m_ins_co
                AND primary_insurance.merge_id IS NULL
                AND primary_insurance.docid = p.docid
            LEFT JOIN dental_contact secondary_insurance ON secondary_insurance.contactid = p.s_m_ins_co
                AND secondary_insurance.merge_id IS NULL
                AND secondary_insurance.docid = p.docid
        WHERE uc.companyid = '$adminCompanyId'
            $andDocIdConditional
        GROUP BY $groupBy
        ORDER BY $sortBy
        ";
} elseif (is_billing($_SESSION['admin_access'])) {
    $adminUserId = intval($_SESSION['adminuserid']);

    $a_sql = "SELECT ac.companyid
        FROM admin_company ac
            JOIN admin a ON a.adminid = ac.adminid
        WHERE a.adminid = '$adminUserId'";

    $adminCompanyId = $db->getColumn($a_sql, 'companyid');

    $sql = "SELECT
            p.firstname,
            p.lastname,
            CONCAT(u.first_name, ' ', u.last_name) AS doc_name,
            p.patientid,
            p.p_m_ins_co,
            p.s_m_ins_co,
            primary_insurance.company AS primary_insurance,
            secondary_insurance.company AS secondary_insurance
        FROM dental_patients p
            JOIN dental_users u ON u.userid = p.docid
            LEFT JOIN dental_contact primary_insurance ON primary_insurance.contactid = p.p_m_ins_co
                AND primary_insurance.merge_id IS NULL
                AND primary_insurance.docid = p.docid
            LEFT JOIN dental_contact secondary_insurance ON secondary_insurance.contactid = p.s_m_ins_co
                AND secondary_insurance.merge_id IS NULL
                AND secondary_insurance.docid = p.docid
        WHERE u.billing_company_id = '$adminCompanyId'
            $andDocIdConditional
        GROUP BY $groupBy
        ORDER BY $sortBy
        ";
}

$my = $db->getResults($sql);
$total_rec = count($my);

$claimChargesQuery = "SELECT
        insuranceid,
        COALESCE(
            CONVERT(
                REPLACE(IF(primary_claim_id, 0, total_charge), ',', ''),
                DECIMAL(11, 2)
            ), 0
        ) AS total_charge
    FROM dental_insurance
    ";

$ledgerPaymentsQuery = "SELECT SUM(dlp.amount) AS paid_amount
    FROM dental_ledger dl
        LEFT JOIN dental_ledger_payment dlp ON dlp.ledgerid = dl.ledgerid
    ";

?>
<link rel="stylesheet" href="css/ledger.css" />
<link rel="stylesheet" href="admin/popup/popup.css" type="text/css" media="screen" />
<link rel="stylesheet" href="admin/css/table_hover.css" type="text/css" media="screen" />
<script src="admin/popup/popup.js" type="text/javascript"></script>

<span class="lead">
    Claim Aging Report
</span>

<div class="clearfix"></div>

<?php $fid = (isset($_REQUEST['fid']))?$_REQUEST['fid']:'';?>
<form name="sortfrm" action="<?php echo $_SERVER['PHP_SELF']?>" method="get" style="width:60%; float:left; margin-left:10px;">
    Account:
    <select name="fid">
        <option value="">Any</option>
        <?php

        $franchisees = (is_billing($_SESSION['admin_access']))?get_billing_franchisees():get_franchisees();

        if ($franchisees) foreach ($franchisees as $row) {
            $selected = $row['userid'] == $fid ? 'selected' : '';

            ?>
            <option value="<?= $row['userid'] ?>" <?= $selected ?>>
                [<?= $row['userid'] ?>] <?= e($row['first_name'] . ' ' . $row['last_name']) ?>
            </option>
      <?php } ?>
    </select>
    &nbsp;&nbsp;&nbsp;
    <input type="submit" value="Filter List"/>
    <input type="button" value="Reset" onclick="window.location='<?php echo $_SERVER['PHP_SELF']?>'"/>
</form>

<div style="float:right; margin-right:20px;">
    <a href="?nbc=1" class="btn btn-primary">No Billing Company</a>
    <a href="?bc=1" class="btn btn-primary">Billing Company</a>
    <a href="?all" class="btn btn-primary">All</a>
</div>

<p class="clearfix"></p>

<div align="center" class="red">
    <b><?php echo (!empty($_GET['msg']) ? $_GET['msg'] : '');?></b>
</div>

<table class="table table-hover" width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center">
    <thead>
        <tr class="tr_bg_h">
            <th valign="top" class="col_head">
                <?php

                switch ($groupName) {
                    case 'insurance':
                        echo 'Insurance Company';
                        break;
                    case 'patient':
                    default:
                        echo 'Patient Name';
                        break;
                }

                ?>
            </th>
            <th valign="top" class="col_head">
                Account
            </th>
            <th valign="top" class="col_head">
                0-29 Days
            </th>
            <th valign="top" class="col_head">
                30-59 Days
            </th>
            <th valign="top" class="col_head">
                60-89 Days
            </th>
            <th valign="top" class="col_head">
                90-119 Days
            </th>
            <th valign="top" class="col_head">
                120+
            </th>
            <th valign="top" class="col_head">
                Total
            </th>
        </tr>
    </thead>
    <tbody>
        <?php

        $total_029 = $total_3059 = $total_6089 = $total_90119 = $total_120 = $grand_total = 0;

        foreach ($my as $r) {
            $pat_total = 0;

            ?>
            <tr>
                <td valign="top">
                    <a href="view_patient.php?pid=<?= $r['patientid'] ?>">
                        <?php

                        switch ($groupName) {
                            case 'insurance':
                                echo e($r['primary_insurance']);
                                break;
                            case 'patient':
                            default:
                                echo e($r['firstname'] . ' ' . $r['lastname']);
                                break;
                        }

                        ?>
                    </a>
                </td>
                <td valign="top">
                    <?= e($r['doc_name']) ?>
                </td>
                <?php

                for ($lowerLimit=0; $lowerLimit<=120; $lowerLimit+=30) {
                    $c_total = $p_total = 0;
                    $upperLimit = $lowerLimit == 120 ? '' : $lowerLimit + 29;

                    $claimChargesResults =
                        getClaimChargesResults(
                            [$lowerLimit, $upperLimit],
                            $r[$groupId],
                            $groupName,
                            $andBillingIdConditional
                        );

                    foreach ($claimChargesResults as $claimCharges) {
                        $c_total += $claimCharges['total_charge'];
                        $p_total += getLedgerPaymentAmount($claimCharges['insuranceid']);
                    }

                    $pat_total += $c_total - $p_total;
                    ${"total_{$lowerLimit}{$upperLimit}"} += $c_total - $p_total;

                    ?>
                    <td valign="top">
                        $<?= number_format($c_total - $p_total, 2) ?>
                    </td>
                <?php
                }

                $grand_total += $pat_total;

                ?>
                <td valign="top">
                    $<?= number_format($pat_total, 2) ?>
                </td>
            </tr>
        <?php } ?>
    </tbody>
    <tfoot>
        <tr>
            <td valign="top">
                <b>Totals</b>
            </td>
            <td></td>
            <td valign="top">
                <strong><?php echo "$".number_format($total_029,2); ?></strong>
            </td>
            <td valign="top">
                <strong><?php echo "$".number_format($total_3059,2); ?></strong>
            </td>
            <td valign="top">
                <strong><?php echo "$".number_format($total_6089,2); ?></strong>
            </td>
            <td valign="top">
                <strong><?php echo "$".number_format($total_90119,2); ?></strong>
            </td>
            <td valign="top">
                <strong><?php echo "$".number_format($total_120,2); ?></strong>
            </td>
            <td valign="top">
                <strong><?php echo "$".number_format($grand_total,2); ?></strong>
            </td>
        </tr>
    </tfoot>
</table>

<?php include '../report_claim_aging_breakdown.php'; ?>

<br /><br />

<?php  include "includes/bottom.htm"; ?>