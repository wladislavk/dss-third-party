<?php namespace Ds3\Libraries\Legacy; ?>
<?php include 'includes/top.htm';?>
<?php
    $docid = $_SESSION['docid'];
    $page_count = 30;
    $page = isset($_REQUEST['page']) ? $_REQUEST['page'] : 0;
    $is_unviewed = isset($_REQUEST['unviewed']) ? true : false;

    $from = $page * $page_count;


    $sql_where = '';
    $unviewed_url = '';
    if ($is_unviewed) {
        $sql_where = ' WHERE viewed != 1';
        $unviewed_url = 'unviewed=1';
    }
    $sql_count = 'SELECT count(*) as total FROM dental_payment_reports' . $sql_where;
    $total = $db->getRow($sql_count)['total'];

    $pages_quantity = $total/$page_count;

    $reports_query = "SELECT payment_id, claimid, reference_id, response, adddate, ip_address
        FROM dental_payment_reports
        " . $sql_where . "
        ORDER BY adddate DESC
        LIMIT " . $from . ", ". $page_count;
    $reports_res = $db->getResults($reports_query);

    if (!$reports_res) {
        print "MYSQL ERROR:" . mysqli_errno($con).": ".mysqli_errno($con)."<br/>"."Error selecting payment reports from the database.";
    }
?>
<br />
<span class="admin_head">
    <?=$is_unviewed ? 'Unviewed': 'All';?> Payment Reports.
</span>
<span>
    <a href="payment_reports_list.php<?=$is_unviewed ? '' : '?unviewed=1';?>">Switch to <?=$is_unviewed ? 'All': 'Unviewed';?></a>
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
            <td valign="top"><?=$report->reference_id;?></td>
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
        </tr>
    <? endforeach; ?>
</table>
<?php  include 'includes/bottom.htm';?>
