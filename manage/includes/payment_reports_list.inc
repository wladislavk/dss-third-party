<?php namespace Ds3\Libraries\Legacy; ?>
<style>
    .clickable_row{
        cursor: pointer;
    }
</style>
<?php
    /*
     *  Required variables:
     *  $back_office  {true | false}
     *  $header_class  {'admin_head' | 'page-header'}
     *  $table_style  {'width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center"' | class="table table-bordered table-hover"}
     *  $sql_user_filter
     *  $sql_join_section
     */

    $page_count = 30;
    $page = isset($_REQUEST['page']) ? $_REQUEST['page'] : 0;
    $from = $page * $page_count;

    $sort_by = strtolower($_REQUEST['sort']);
    $sort_by = isset($_REQUEST['sort'])  ? strtolower($_REQUEST['sort']) : 'date';
    $sort_direction = strtolower($_REQUEST['sortdir']);
    $sort_direction = (empty($sort_direction) || ($sort_direction != 'asc' && $sort_direction != 'desc')) ? 'desc' : $sort_direction;
    $sort_by_sql = '';

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
    $unviewed_url = '';
    if ($is_unviewed) {
        $sql_where = ' AND viewed != 1';
        $unviewed_url = 'unviewed=1';
    }

    $sql_count = 'SELECT count(*) as total
        FROM dental_payment_reports AS pr
        INNER JOIN dental_insurance AS i ON i.insuranceid = pr.claimid
        ' . $sql_join_section. '
        WHERE ' . $sql_user_filter
        . $sql_where;
    $total = $db->getRow($sql_count)['total'];

    $pages_quantity = $total/$page_count;

    $reports_query = 'SELECT pr.payment_id, pr.claimid, pr.reference_id, pr.response, pr.adddate, pr.ip_address, i.patientid, u.name
        FROM dental_payment_reports AS pr
        INNER JOIN dental_insurance AS i ON i.insuranceid = pr.claimid
        ' . $sql_join_section. '
        WHERE  ' . $sql_user_filter
        . $sql_where
        . ' ORDER BY ' . $sort_by_sql . '
        LIMIT ' . $from . ', '. $page_count;
    $reports_res = $db->getResults($reports_query);

    $errors_message = '';
    if (!$reports_res) {
        $errors_message = 'No Payment Reports found';
    }
?>
<br />
<div class="<?=$header_class?>">
    Payment Reports
    <select name="show" onchange="Javascript: window.location ='<?php echo $_SERVER['PHP_SELF'];?>?unviewed=' + this.value;">
        <option value="0" <?=!$is_unviewed ? ' selected' : '';?> >All</option>
        <option value="1" <?=$is_unviewed ? ' selected' : '';?> >Unviewed</option>
    </select>
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
                <? paging($pages_quantity, $page, $unviewed_url); ?>
            </td>
        </tr>
    <? endif; ?>
    <tr class="tr_bg_h">
        <? if ($back_office): ?>
            <th valign="top" class="col_head">Account</th>
        <? endif; ?>
        <th valign="top" class="col_head">Claim ID</th>
        <th valign="top" class="col_head <?=($sort_by == 'date') ? 'arrow_' . $sort_direction : '';?>">
            <a href="payment_reports_list.php?unviewed=<?=$is_unviewed ? '1' : '0';?>&sort=date&sortdir=<?=($sort_by == 'date' && $sort_direction == 'asc') ? 'desc' : 'asc'; ?>">Generation Date (YYYY-MM-DD)</a>
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
            $claim_url = 'patient_claims.php?pid=' . $report_data['patientid'];
        } else {
            $claim_url = 'view_claim.php?claimid=' . $report_data['claimid'] . '&pid=' . $report_data['patientid'];
        }
        ?>
        <tr class="tr_active">
            <? if ($back_office): ?>
                <td valign="top"><?=$report_data['name'];?></td>
            <? endif; ?>
            <td valign="top"><a href="<?=$claim_url?>"><?=$report_data['reference_id'];?></a></td>
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
                <td valign="top" class="clickable_row" data-report="<?=$report_data['payment_id'];?>"><?=$details->patient->last_name . ' ' . $details->patient->first_name . ' ' . $details->patient->middle_name;?></td>
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
