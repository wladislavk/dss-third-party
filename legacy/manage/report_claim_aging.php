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
require_once __DIR__ . '/admin/includes/ledger-functions.php';

$docId = intval($_SESSION['docid']);
$my = ledgerBalance($docId, [], true);

$patientIds = $my ? array_pluck($my, 'patientid') : [];

$totals = [];
$balances = array_fill_keys($patientIds, []);

for ($lowerLimit = 0; $lowerLimit <= 120; $lowerLimit += 30) {
    $upperLimit = $lowerLimit == 120 ? '' : $lowerLimit + 29;

    $mailingDateConditional = mailingDateConditional([$lowerLimit, $upperLimit], 'report');
    $currentBalance = ledgerBalance($docId, $patientIds, true, [$mailingDateConditional]);

    foreach ($currentBalance as $each) {
        $balances [$each['patientid']] [$lowerLimit]= $each['balance'];
    }

    $totals [$lowerLimit]= array_sum(array_pluck($balances, $lowerLimit));
}

$grandTotal = array_sum($totals);

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

        foreach($my as $r) {
            $patientId = $r['patientid'];
            $patientTotal = $r['balance'];

            ?>
            <tr>
                <td valign="top">
                    <a href="manage_ledger.php?pid=<?= $r['patientid'] ?>&amp;addtopat=1">
                        <?= e($r['firstname'] . ' ' . $r['lastname']) ?>
                    </a>
                </td>
                <?php for ($lowerLimit = 0; $lowerLimit <= 120; $lowerLimit += 30) {
                    $currentBalance = array_get($balances, "$patientId.$lowerLimit");
                    ?>
                    <td valign="top">
                        <?php if ($currentBalance) { ?>
                            <a href="manage_ledger.php?pid=<?= $r['patientid'] ?>&amp;addtopat=1">
                                $<?= number_format($currentBalance, 2) ?>
                            </a>
                        <?php } else { ?>
                            $<?= number_format($currentBalance, 2) ?>
                        <?php } ?>
                    </td>
                    <?php
                }

                ?>
                <td valign="top">
                    $<?= number_format($patientTotal, 2) ?>
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
                <strong><?php echo "$".number_format($totals[0], 2); ?></strong>
            </td>
            <td valign="top">
                <strong><?php echo "$".number_format($totals[30], 2); ?></strong>
            </td>
            <td valign="top">
                <strong><?php echo "$".number_format($totals[60], 2); ?></strong>
            </td>
            <td valign="top">
                <strong><?php echo "$".number_format($totals[90], 2); ?></strong>
            </td>
            <td valign="top">
                <strong><?php echo "$".number_format($totals[120], 2); ?></strong>
            </td>
            <td valign="top">
                <strong><?php echo "$".number_format($grandTotal, 2); ?></strong>
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
