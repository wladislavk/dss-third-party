<?php namespace Ds3\Libraries\Legacy; ?>
<?php include 'includes/top.htm';?>
<?php
    $docid = $_SESSION['docid'];
    $page_count = 30;
    $page = isset($_REQUEST['page']) ? $_REQUEST['page'] : 0;
    $from = $page * $page_count;

    $is_unviewed = false;
    if (isset($_REQUEST['unviewed'])) {
        $is_unviewed = $_REQUEST['unviewed'] == '1' ? true : false;
    }

    $sql_where = '';
    $unviewed_url = '';
    if ($is_unviewed) {
        $sql_where = ' AND viewed != 1';
        $unviewed_url = 'unviewed=1';
    }
    $sql_count = 'SELECT count(*) as total
        FROM dental_payment_reports AS pr
        INNER JOIN dental_insurance AS i ON i.insuranceid = pr.claimid
        WHERE i.docid = ' . $docid
        . $sql_where;
    $total = $db->getRow($sql_count)['total'];

    $pages_quantity = $total/$page_count;

    $reports_query = 'SELECT pr.payment_id, pr.claimid, pr.reference_id, pr.response, pr.adddate, pr.ip_address
        FROM dental_payment_reports AS pr
        INNER JOIN dental_insurance AS i ON i.insuranceid = pr.claimid
        WHERE i.docid = ' . $docid
        . $sql_where
        . ' ORDER BY adddate DESC
        LIMIT ' . $from . ', '. $page_count;
    $reports_res = $db->getResults($reports_query);

    if (!$reports_res) {
        print "MYSQL ERROR:" . mysqli_errno($con).": ".mysqli_errno($con)."<br/>"."Error selecting payment reports from the database.";
    }
?>
<br />
<span class="admin_head">
    Payment Reports
    <select name="show" onchange="Javascript: window.location ='<?php echo $_SERVER['PHP_SELF'];?>?unviewed=' + this.value;">
        <option value="0" <?=!$is_unviewed ? ' selected' : '';?> >All</option>
        <option value="1" <?=$is_unviewed ? ' selected' : '';?> >Unviewed</option>
    </select>
</span>
<br />
<br />
<table width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center">
    <? if($total > $page_count): ?>
        <tr bgColor="#ffffff">
            <td  align="right" colspan="15" class="bp">
                Pages:
                <? paging($pages_quantity, $page, $unviewed_url); ?>
            </td>
        </tr>
    <? endif; ?>
    <tr class="tr_bg_h">
        <th valign="top" class="col_head">Claim ID</th>
        <th valign="top" class="col_head">Generation Date</th>
        <th valign="top" class="col_head">Payer</th>
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
        ?>
        <tr onclick="window.location='/manage/payment_report.php?report_id=<?=$report_data['payment_id'];?>'" class="tr_active clickable_row">
            <td valign="top"><?=$report_data['reference_id'];?></td>
            <? if (isset($report->success) && !$report->success): ?>
                <?
                $errors_message = '';
                foreach ($report->errors as $error) {
                    $errors_message .= $error->message . '<br/>';
                }
                ?>
                <td colspan="10">Errors: <?=$errors_message?></td>
            <? else: ?>
                <td valign="top"><?=$details->effective_date;?></td>
                <td valign="top"><?=$details->payer->name;?></td>
                <td valign="top"><?=$details->financials->type_code . ' ' . $details->financials->type_label;?></td>
                <td valign="top"><?=$details->financials->total_payment_amount;?></td>
                <td valign="top"><?=$details->financials->credit ? 'Credit' : 'Debit';?></td>
                <td valign="top"><?=$details->financials->payment_method_code . ' ' . $details->financials->payment_method_label;?></td>
                <td valign="top"><?=$details->financials->payment_date;?></td>
                <td valign="top"><?=implode(' ', $details->claim->status);?></td>
                <td valign="top"><?=$details->claim->amount->billed;?></td>
                <td valign="top"><?=$details->claim->amount->paid;?></td>
            <? endif; ?>
        </tr>
    <? endforeach; ?>
</table>
<?php  include 'includes/bottom.htm';?>
