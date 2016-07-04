<?php
namespace Ds3\Libraries\Legacy;

require_once __DIR__ . '/../admin/includes/access.php';

?>
<style>
    .clickable_row{
        cursor: pointer;
    }
</style>
<?php

$docId = intval($_SESSION['docid']);
$franchiseeId = intval($_REQUEST['fid']);

$page_count = 30;
$page = isset($_REQUEST['page']) ? $_REQUEST['page'] : 0;
$from = $page * $page_count;

$sort_by = strtolower($_REQUEST['sort']);
$sort_by = isset($_REQUEST['sort'])  ? strtolower($_REQUEST['sort']) : 'date';
$sort_direction = strtolower($_REQUEST['sortdir']);
$sort_direction = (empty($sort_direction) || ($sort_direction != 'asc' && $sort_direction != 'desc')) ? 'desc' : $sort_direction;
$sort_by_sql = '';

$npiList = [];

switch ($sort_by) {
    case 'date':
        $sort_by_sql = ' pr.adddate ' . $sort_direction;
        break;
    default:
        $sort_by_sql = ' pr.adddate ' . $sort_direction;
        break;
}

$is_unviewed = false;

if (isset($_REQUEST['unviewed'])) {
    $is_unviewed = $_REQUEST['unviewed'] == '1' ? true : false;
}

$sql_where = '';

if ($is_unviewed) {
    $sql_where = ' AND viewed != 1';
}

/**
 * @see DSS-437
 *
 * Retrieve all NPIs associated to member of this office
 */
if (empty($back_office)) {
    $franchiseeId = $docId;
}

if ($franchiseeId) {
    $sql_user_filter = "i.docid = '$franchiseeId'";
    $npiList = $db->getResults("SELECT npi, medicare_npi, service_npi, service_medicare_npi
        FROM dental_users
        WHERE docid = '$franchiseeId'
            OR userid = '$franchiseeId'");

    $npiList = $npiList ? array_flatten($npiList) : [];
    $npiList = array_filter(array_unique($npiList));
}

if ($npiList) {
    array_walk($npiList, function (&$each) use ($db) {
        $each = 'pr.response LIKE \'%"npi":"' . $db->escape($each) . '"%\'';
    });
    $npiList = join(' OR ', $npiList);
    $orNpiConditional = "OR ($npiList)";
} else {
    $orNpiConditional = '';
}

$sql_count = "SELECT COUNT(payment_id) AS total
    FROM dental_payment_reports AS pr
        INNER JOIN dental_insurance AS i ON i.insuranceid = pr.claimid
        $sql_join_section
    WHERE ($sql_user_filter $orNpiConditional)
        $sql_where
    ";

$total = $db->getColumn($sql_count, 'total', 0);

$pages_quantity = $total/$page_count;

$reports_query = "SELECT
        pr.payment_id,
        pr.claimid,
        pr.reference_id,
        pr.response,
        pr.adddate,
        pr.ip_address,
        i.patientid,
        i.docid,
        u.name,
        $sql_user_filter AS doc_matches
    FROM dental_payment_reports AS pr
        INNER JOIN dental_insurance AS i ON i.insuranceid = pr.claimid
        $sql_join_section
    WHERE ($sql_user_filter $orNpiConditional)
        $sql_where
    ORDER BY $sort_by_sql
    LIMIT $from, $page_count";
$reports_res = $db->getResults($reports_query);

$errors_message = '';

if (!$reports_res) {
    $errors_message = 'No Payment Reports found';
}

$unviewed_url = "unviewed=$is_unviewed&fid=$franchiseeId&sort=$sort_by";

?>
<br />
<div class="<?=$header_class?>">
    <form name="sortfrm" method="get">
        Payment Reports
        <select name="show">
            <option value="0" <?=!$is_unviewed ? ' selected' : '';?> >All</option>
            <option value="1" <?=$is_unviewed ? ' selected' : '';?> >Unviewed</option>
        </select>
        &nbsp;&nbsp;&nbsp;

        Account:
        <select name="fid">
            <option value="">Any</option>
            <?php

            if (is_super($_SESSION['admin_access'])) {
                $franchisees = get_franchisees();
            } elseif (is_software($_SESSION['admin_access'])) {
                $franchisees = get_software_franchisees();
            } elseif (is_billing($_SESSION['admin_access'])) {
                $franchisees = get_billing_franchisees();
            } elseif (is_hst($_SESSION['admin_access'])) {
                $franchisees = get_hst_franchisees();
            } else {
                $franchisees = [];
            }

            if ($franchisees) foreach ($franchisees as $row) {
                $selected = ($row['userid'] == $franchiseeId) ? 'selected' : ''; ?>
                <option value="<?php echo  $row['userid'] ?>" <?php echo  $selected ?>>[<?php echo  $row['userid'] ?>] <?php echo  $row['first_name'] ?> <?php echo  $row['last_name'] ?></option>
            <?php } ?>
        </select>
        &nbsp;&nbsp;&nbsp;

        <input type="hidden" name="sort" value="<?php echo $sort_by?>"/>
        <input type="hidden" name="sortdir" value="<?php echo $sort_direction?>"/>
        <input type="submit" value="Filter List" class="btn btn-primary">
        <input type="button" value="Reset" onclick="window.location='<?php echo $_SERVER['PHP_SELF']?>'" class="btn btn-primary">
    </form>
</div>
<br />
<br />
<? if($errors_message): ?>
    <div class="<?=$header_class?>">
        Errors: <?=$errors_message?>
    </div>
<? endif; ?>
<table <?=$table_style?>>
    <? if($total > $page_count): ?>
        <tr bgColor="#ffffff">
            <td  align="right" colspan="15" class="bp">
                Pages:
                <?= paging($pages_quantity, $page, "$unviewed_url&sortdir=$sort_direction"); ?>
            </td>
        </tr>
    <? endif; ?>
    <tr class="tr_bg_h">
        <? if ($back_office): ?>
            <th valign="top" class="col_head">Account</th>
        <? endif; ?>
        <th valign="top" class="col_head">Claim ID</th>
        <th valign="top" class="col_head <?=($sort_by == 'date') ? 'arrow_' . $sort_direction : '';?>">
            <a href="?<?= $unviewed_url ?>&amp;sortdir=<?= $sort_by == 'date' && $sort_direction == 'asc' ? 'desc' : 'asc' ?>">Generation Date (YYYY-MM-DD)</a>
        </th>
        <th valign="top" class="col_head">Payer</th>
        <th valign="top" class="col_head">Patient</th>
        <th valign="top" class="col_head">Transaction Type</th>
        <th valign="top" class="col_head">Total Payment Amount</th>
        <th valign="top" class="col_head">Debit/ Credit</th>
        <th valign="top" class="col_head">Payment Method</th>
        <th valign="top" class="col_head">Payment Date</th>
        <th valign="top" class="col_head">Claim Status</th>
        <th valign="top" class="col_head">Amount Billed</th>
        <th valign="top" class="col_head">Amount Paid</th>
    </tr>
    <? foreach ($reports_res as $report_data): ?>
        <?
        $report = json_decode($report_data['response']);
        $details = $report->details;

        if ($back_office) {
            $claim_url = $report_data['doc_matches'] ? 'patient_claims.php?pid=' . $report_data['patientid'] : '#';
        } else {
            $claim_url = $report_data['doc_matches'] ?
                'view_claim.php?claimid=' . $report_data['claimid'] . '&pid=' . $report_data['patientid'] : '#';
        }
        ?>
        <tr class="tr_active">
            <? if ($back_office): ?>
                <td valign="top"><?=$report_data['name'];?></td>
            <? endif; ?>
            <td valign="top"><a href="<?=$claim_url?>"><?=$report_data['reference_id'] ?: '<i>Not Set</i>' ?></a></td>
            <? if (isset($report->success) && !$report->success): ?>
                <?
                $errors_message = '';
                foreach ($report->errors as $error) {
                    $errors_message .= $error->message . '<br/>';
                }
                ?>
                <td colspan="11" class="clickable_row" data-report="<?=$report_data['payment_id'];?>">Errors: <?=$errors_message?></td>
            <? else: ?>
                <td valign="top" class="clickable_row" data-report="<?=$report_data['payment_id'];?>"><?=$details->effective_date;?></td>
                <td valign="top" class="clickable_row" data-report="<?=$report_data['payment_id'];?>"><?=$details->payer->name;?></td>
                <td valign="top" class="clickable_row" data-report="<?=$report_data['payment_id'];?>">
                    <?=
                        empty(
                            $details->patient->last_name .
                            $details->patient->first_name .
                            $details->patient->middle_name
                        ) ? '<i>Not Set</i>' :
                            $details->patient->last_name . ' ' .
                            $details->patient->first_name . ' ' .
                            $details->patient->middle_name
                    ?>
                </td>
                <td valign="top" class="clickable_row" data-report="<?=$report_data['payment_id'];?>"><?=$details->financials->type_code . ' ' . $details->financials->type_label;?></td>
                <td valign="top" class="clickable_row" data-report="<?=$report_data['payment_id'];?>"><?=$details->financials->total_payment_amount;?></td>
                <td valign="top" class="clickable_row" data-report="<?=$report_data['payment_id'];?>"><?=$details->financials->credit ? 'Credit' : 'Debit';?></td>
                <td valign="top" class="clickable_row" data-report="<?=$report_data['payment_id'];?>"><?=$details->financials->payment_method_code . ' ' . $details->financials->payment_method_label;?></td>
                <td valign="top" class="clickable_row" data-report="<?=$report_data['payment_id'];?>"><?=$details->financials->payment_date;?></td>
                <td valign="top" class="clickable_row" data-report="<?=$report_data['payment_id'];?>"><?=implode(' ', $details->claim->status);?></td>
                <td valign="top" class="clickable_row" data-report="<?=$report_data['payment_id'];?>"><?=$details->claim->amount->billed;?></td>
                <td valign="top" class="clickable_row" data-report="<?=$report_data['payment_id'];?>"><?=$details->claim->amount->paid;?></td>
            <? endif; ?>
        </tr>
    <? endforeach; ?>
</table>
<script type="text/javascript">
    $( document ).ready(function() {
        $('.clickable_row').click( function() {
            window.location = 'payment_report.php?report_id=' + $(this).data('report');
        });
    });
</script>
<?php  include 'includes/bottom.htm';?>
