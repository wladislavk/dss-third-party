<?php
namespace Ds3\Libraries\Legacy;

$is_front_office = true;
$is_back_office = false;

if (!isset($_GET['print'])) {
    require_once __DIR__ . '/includes/top.htm';
} else {
    $office_type = DSS_OFFICE_TYPE_FRONT;
}

require_once __DIR__ . '/admin/includes/ledger-functions.php';

$docId = intval($_SESSION['userid']);
$subQueries = ledgerBalanceSubQueries('claim', 'claim');

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

$sql = "SELECT
        p.firstname,
        p.lastname,
        p.patientid,
        p.p_m_ins_co,
        p.s_m_ins_co,
        primary_insurance.company AS primary_insurance,
        secondary_insurance.company AS secondary_insurance
    FROM dental_patients p
        LEFT JOIN dental_contact primary_insurance ON primary_insurance.contactid = p.p_m_ins_co
            AND primary_insurance.merge_id IS NULL
            AND primary_insurance.docid = p.docid
        LEFT JOIN dental_contact secondary_insurance ON secondary_insurance.contactid = p.s_m_ins_co
            AND secondary_insurance.merge_id IS NULL
            AND secondary_insurance.docid = p.docid
    WHERE p.docid = '$docId'
        AND (
            SELECT SUM(
                {$subQueries['debits']}
                - {$subQueries['credits']}
                - {$subQueries['adjustments']}
            )
            FROM dental_insurance claim
            WHERE claim.patientid = p.patientid
                AND claim.mailed_date IS NOT NULL
        ) > 0
    GROUP BY $groupBy
    ORDER BY $sortBy
    ";

$my = $db->getResults($sql);

?>
<link rel="stylesheet" href="css/ledger.css" />
<link rel="stylesheet" href="admin/popup/popup.css" type="text/css" media="screen" />
<link rel="stylesheet" href="css/manage.css" type="text/css" media="screen" />
<script src="admin/popup/popup.js" type="text/javascript"></script>

<span class="admin_head">
    Claim Aging Report
</span>

<div>
    &nbsp;&nbsp;
    <a href="ledger.php" class="editlink" title="EDIT">
        <b>&lt;&lt;Back</b>
    </a>
</div>

<br /><br />

<div align="center" class="red">
    <b><?php echo isset($_GET['msg']) ? $_GET['msg'] : '';?></b>
</div>

<table class="ledger sort_table" width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center">
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
            <th valign="top" class="col_head" width="12%">
                0-29 Days
            </th>
            <th valign="top" class="col_head" width="12%">
                30-59 Days
            </th>
            <th valign="top" class="col_head" width="12%">
                60-89 Days
            </th>
            <th valign="top" class="col_head" width="12%">
                90-119 Days
            </th>
            <th valign="top" class="col_head" width="12%">
                120+
            </th>
            <th valign="top" class="col_head" width="12%">
                Total
            </th>
        </tr>
    </thead>
    <tbody>
        <?php

        $total_029 = $total_3059 = $total_6089 = $total_90119 = $total_120 = $grand_total = 0;

        foreach($my as $r) {
            $pat_total = 0;

            ?>
            <tr>
                <td valign="top">
                    <a href="manage_ledger.php?pid=<?= $r[$groupId] ?>&amp;addtopat=1">
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
                <?php

                for ($lowerLimit=0; $lowerLimit<=120; $lowerLimit+=30) {
                    $c_total = $p_total = 0;
                    $upperLimit = $lowerLimit == 120 ? '' : $lowerLimit + 29;

                    $claimChargesResults = getClaimChargesResults(
                        [$lowerLimit, $upperLimit],
                        $r[$groupId],
                        $groupName
                    );

                    foreach ($claimChargesResults as $claimCharges) {
                        $c_total += $claimCharges['total_charge'];
                        $p_total += getLedgerPaymentAmount($claimCharges['insuranceid']);
                    }

                    $pat_total += $c_total - $p_total;
                    ${"total_{$lowerLimit}{$upperLimit}"} += $c_total - $p_total;

                    ?>
                    <td valign="top">
                        <?php if (($c_total-$p_total) != 0) { ?>
                            <a href="manage_ledger.php?pid=<?= $r['patientid'] ?>&amp;addtopat=1">
                                $<?= number_format($c_total - $p_total, 2) ?>
                            </a>
                        <?php } else { ?>
                            $<?= number_format($c_total - $p_total, 2) ?>
                        <?php } ?>
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

<?php include 'report_claim_aging_breakdown.php'; ?>

<div id="popupContact" style="width:750px;">
    <a id="popupContactClose"><button>X</button></a>
    <iframe id="aj_pop" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
</div>

<div id="backgroundPopup"></div>

<br /><br />

<?php include "includes/bottom.htm";?>
