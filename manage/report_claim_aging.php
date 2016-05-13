<?php
namespace Ds3\Libraries\Legacy;

$is_front_office = true;
$is_back_office = false;

if (!isset($_GET['print'])) {
    require_once __DIR__ . '/includes/top.htm';
} else {
    $office_type = DSS_OFFICE_TYPE_FRONT;
}

require_once __DIR__ . '/admin/includes/report-claim-functions.php';

$sql = "SELECT p.firstname, p.lastname, p.patientid
    FROM dental_patients p
    WHERE p.docid = '{$_SESSION['docid']}'
        AND (
            SELECT (
                SUM(
                    COALESCE(
                        (
                            SELECT SUM(dl.amount) AS paid_amount
                            FROM dental_ledger dl
                            WHERE dl.primary_claim_id = i.insuranceid
                        ), 0
                    )
                )
                -
                SUM(
                    COALESCE(
                        (
                            SELECT SUM(dlp.amount) AS paid_amount
                            FROM dental_ledger dl
                                LEFT JOIN dental_ledger_payment dlp ON dlp.ledgerid = dl.ledgerid
                            WHERE dl.primary_claim_id = i.insuranceid
                        ), 0
                    )
                )
            )
            FROM dental_insurance i
            WHERE i.patientid = p.patientid
                AND i.mailed_date IS NOT NULL
        ) > 0
    ORDER BY p.lastname ASC, p.firstname ASC";

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
                Patient Name
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
                    <a href="manage_ledger.php?pid=<?= $r['patientid'] ?>&amp;addtopat=1">
                        <?= e($r['firstname'] . ' ' . $r['lastname']) ?>
                    </a>
                </td>
                <?php

                for ($lowerLimit=0; $lowerLimit<=120; $lowerLimit+=30) {
                    $c_total = $p_total = 0;
                    $upperLimit = $lowerLimit == 120 ? '' : $lowerLimit + 29;

                    $claimCharges = [];
                    $claimChargesResults = getClaimChargesResults([$lowerLimit, $upperLimit], $r['patientid']);

                    foreach ($claimChargesResults as $claimCharges) {
                        $c_total += $claimCharges['total_charge'];
                    }

                    if ($claimCharges) {
                        $p_total = getLedgerPaymentAmount($claimCharges['insuranceid']);
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
