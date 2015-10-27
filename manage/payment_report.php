<?php namespace Ds3\Libraries\Legacy; ?>
<?php include 'includes/top.htm';?>
<?php
    $docid = $_SESSION['docid'];
    $report_id = $_REQUEST['report_id'];

    $report_query = "SELECT payment_id, claimid, reference_id, response, adddate, ip_address
         FROM dental_payment_reports
         WHERE payment_id = " . mysqli_real_escape_string($con, $report_id);
    $report_data = $db->getRow($report_query);

    if (!$report_data) {
        print "MYSQL ERROR:" . mysqli_errno($con).": ".mysqli_errno($con)."<br/>"."Error selecting payment report from the database.";
    } else {
        $update_query ='UPDATE dental_payment_reports SET viewed = 1 WHERE payment_id = ' . mysqli_real_escape_string($con, $report_id);
        $db->query($update_query);
    }

    $report = json_decode($report_data['response']);
    $details = $report->details;

    if (isset($report->success) && !$report->success) {
        $errors_message = '';
        foreach ($report->errors as $error) {
            $errors_message .= $error->message . '<br/>';
        }
    }

    $payer_address = $details->payer->address->zip . ' ' . $details->payer->address->state . ' ' . $details->payer->address->street_line_1 . ' ' . $details->payer->address->street_line_2;
    $payee_address = $details->payee->address->zip . ' ' . $details->payee->address->state . ' ' . $details->payee->address->street_line_1 . ' ' . $details->payee->address->street_line_2;
    $payee_additional_ids = '';
    foreach ($details->payee->additional_ids as $additional_id) {
        $payee_additional_ids .= $additional_id->value . ' ' . $additional_id->type_code . ' ' . $additional_id->type_label . '<br/>';
    }
    $claim_status = implode(' ', $details->claim->status);
    $claim_rendering_provider_ids = implode(' ', $details->claim->rendering_provider_ids);
    $claim_moa_codes = implode(' ', $details->claim->moa_codes);

    $payer_contacts = '';
    foreach ($details->payer->contacts as $contact) {
        $payer_contacts .= $contact->department_code . ' ' . $contact->name . ' ' . $contact->department_label . '<br/>';
        foreach ($contact->details as $contact_detail) {
            $payer_contacts .= '&emsp;' . $contact_detail->type_code . ' ' . $contact_detail->type_label . ': ' . $contact_detail->value . '<br/>';
        }
        $payer_contacts .= '<br/>';
    }

    $financials_credit = '';
    if (isset($details->financials->credit)) {
        $financials_credit = $details->financials->credit ? 'Credit' : 'Debit';
    } elseif (isset($details->financials->debit)) {
        $financials_credit = $details->financials->debit ? 'Debit' : 'Credit';
    }
?>
<br />
<span class="admin_head">
	Payment Report
</span>
<br />
<br />
<? if($errors_message): ?>
    <span class="admin_head">
        Errors: <?=$errors_message?>
    </span>
<? endif; ?>

<table width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center">
    <tr>
        <th rowspan="2" class="tr_bg_h col_head" valign="top"></th>
        <th class="tr_bg_h col_head" valign="top">Claim Reference ID</th>
        <td class="tr_active" valign="top"><?=$report_data['reference_id'];;?></td>
    </tr>
    <tr>
        <th class="tr_bg_h col_head" valign="top">Report generation date</th>
        <td class="tr_active" valign="top"><?=$details->effective_date;?></td>
    </tr>
    <tr>
        <th rowspan="4" class="tr_bg_h col_head">Payer</th>
        <th class="tr_bg_h col_head" valign="top">Name</th>
        <td class="tr_active" valign="top"><?=$details->payer->name;?></td>
    </tr>
    <tr>
        <th class="tr_bg_h col_head" valign="top">ID</th>
        <td class="tr_active" valign="top"><?=$details->payer->id;?></td>
    </tr>
    <tr>
        <th class="tr_bg_h col_head" valign="top">Address</th>
        <td class="tr_active" valign="top"><?=$payer_address?></td>
    </tr>
    <tr>
        <th class="tr_bg_h col_head">Contact Details</th>
        <td class="tr_active" valign="top"><?=$payer_contacts?></td>
    </tr>
    <tr>
        <th rowspan="7" class="tr_bg_h col_head">Financials</th>
        <th class="tr_bg_h col_head" valign="top">Transaction Type</th>
        <td class="tr_active" valign="top"><?=$details->financials->type_code . ' ' . $details->financials->type_label;?></td>
    </tr>
    <tr>
        <th class="tr_bg_h col_head" valign="top">Total Payment Amount</th>
        <td class="tr_active" valign="top"><?=$details->financials->total_payment_amount; unset($details->financials->total_payment_amount);?></td>
    </tr>
    <tr>
        <th class="tr_bg_h col_head" valign="top">Debit/ Credit</th>
        <td class="tr_active" valign="top"><?=$financials_credit?></td>
    </tr>
    <tr>
        <th class="tr_bg_h col_head" valign="top">Payment Method</th>
        <td class="tr_active" valign="top"><?=$details->financials->payment_method_code . ' ' . $details->financials->payment_method_label;?></td>
    </tr>
    <tr>
        <th class="tr_bg_h col_head" valign="top">Payment Format</th>
        <td class="tr_active" valign="top"><?=$details->financials->payment_format_code . ' ' . $details->financials->payment_format_label;?></td>
    </tr>
    <tr>
        <th class="tr_bg_h col_head" valign="top">Payment Date</th>
        <td class="tr_active" valign="top"><?=$details->financials->payment_date;?></td>
    </tr>
    <tr>
        <th class="tr_bg_h col_head" valign="top">Payment Trance Number</th>
        <td class="tr_active" valign="top"><?=$details->financials->payment_trace_number;?></td>
    </tr>
    <tr>
        <th rowspan="5" class="tr_bg_h col_head">Financials Sender</th>
        <th class="tr_bg_h col_head" valign="top">DFI Qualifier</th>
        <td class="tr_active" valign="top"><?=$details->financials->sender->dfi_id_qualifier;?></td>
    </tr>
    <tr>
        <th class="tr_bg_h col_head" valign="top">DFI Label</th>
        <td class="tr_active" valign="top"><?=$details->financials->sender->dfi_id_qualifier_label;?></td>
    </tr>
    <tr>
        <th class="tr_bg_h col_head" valign="top">DFI ID</th>
        <td class="tr_active" valign="top"><?=$details->financials->sender->dfi_id;?></td>
    </tr>
    <tr>
        <th class="tr_bg_h col_head" valign="top">Account Number</th>
        <td class="tr_active" valign="top"><?=$details->financials->sender->account_number;?></td>
    </tr>
    <tr>
        <th class="tr_bg_h col_head" valign="top">Originating Company ID</th>
        <td class="tr_active" valign="top"><?=$details->financials->sender->id;?></td>
    </tr>
    <tr>
        <th rowspan="4" class="tr_bg_h col_head">Financials Receiver</th>
        <th class="tr_bg_h col_head" valign="top">DFI Qualifier</th>
        <td class="tr_active" valign="top"><?=$details->financials->receiver->dfi_id_qualifier;?></td>
    </tr>
    <tr>
        <th class="tr_bg_h col_head" valign="top">DFI Label</th>
        <td class="tr_active" valign="top"><?=$details->financials->receiver->dfi_id_qualifier_label;?></td>
    </tr>
    <tr>
        <th class="tr_bg_h col_head" valign="top">DFI ID</th>
        <td class="tr_active" valign="top"><?=$details->financials->receiver->dfi_id;?></td>
    </tr>
    <tr>
        <th class="tr_bg_h col_head" valign="top">Account Number</th>
        <td class="tr_active" valign="top"><?=$details->financials->receiver->account_number;?></td>
    </tr>
    <tr>
        <th rowspan="4" class="tr_bg_h col_head">Payee</th>
        <th class="tr_bg_h col_head" valign="top">Name</th>
        <td class="tr_active" valign="top"><?=$details->payee->name;?></td>
    </tr>
    <tr>
        <th class="tr_bg_h col_head" valign="top">NPI</th>
        <td class="tr_active" valign="top"><?=$details->payee->npi;?></td>
    </tr>
    <tr>
        <th class="tr_bg_h col_head" valign="top">Address</th>
        <td class="tr_active" valign="top"><?=$payee_address?></td>
    </tr>
    <tr>
        <th class="tr_bg_h col_head" valign="top">Additional IDs</th>
        <td class="tr_active" valign="top"><?=$payee_additional_ids?></td>
    </tr>
    <tr>
        <th rowspan="4" class="tr_bg_h col_head">Patient</th>
        <th class="tr_bg_h col_head" valign="top">First Name</th>
        <td class="tr_active" valign="top"><?=$details->patient->first_name;?></td>
    </tr>
    <tr>
        <th class="tr_bg_h col_head" valign="top">Last Name</th>
        <td class="tr_active" valign="top"><?=$details->patient->last_name;?></td>
    </tr>
    <tr>
        <th class="tr_bg_h col_head" valign="top">Middle Name</th>
        <td class="tr_active" valign="top"><<?=$details->patient->middle_name;?>/td>
    </tr>
    <tr>
        <th class="tr_bg_h col_head" valign="top">ID</th>
        <td class="tr_active" valign="top"><?=$details->patient->id;?></td>
    </tr>
    <tr>
        <th rowspan="13" class="tr_bg_h col_head">Claim</th>
        <th class="tr_bg_h col_head" valign="top">Control Number</th>
        <td class="tr_active" valign="top"><?=$details->claim->control_number;?></td>
    </tr>
    <tr>
        <th class="tr_bg_h col_head" valign="top">Received Date</th>
        <td class="tr_active" valign="top"><?=$details->claim->received_date;?></td>
    </tr>
    <tr>
        <th class="tr_bg_h col_head" valign="top">Filing Indicator Type</th>
        <td class="tr_active" valign="top"><?=$details->claim->filing_indicator_type;?></td>
    </tr>
    <tr>
        <th class="tr_bg_h col_head" valign="top">Filing Indicator Label</th>
        <td class="tr_active" valign="top"><?=$details->claim->filing_indicator_label;?></td>
    </tr>
    <tr>
        <th class="tr_bg_h col_head" valign="top">Place of Service</th>
        <td class="tr_active" valign="top"><?=$details->claim->place_of_service;?></td>
    </tr>
    <tr>
        <th class="tr_bg_h col_head" valign="top">Frequency</th>
        <td class="tr_active" valign="top"><?=$details->claim->frequency;?></td>
    </tr>
    <tr>
        <th class="tr_bg_h col_head" valign="top">Responsibility Sequence</th>
        <td class="tr_active" valign="top"><?=$details->claim->responsibility_sequence;?></td>
    </tr>
    <tr>
        <th class="tr_bg_h col_head" valign="top">Status</th>
        <td class="tr_active" valign="top"><?=$claim_status?></td>
    <tr>
        <th class="tr_bg_h col_head" valign="top">Amount Billed</th>
        <td class="tr_active" valign="top"><?=$details->claim->amount->billed;?></td>
    </tr>
    <tr>
        <th class="tr_bg_h col_head" valign="top">Amount Paid</th>
        <td class="tr_active" valign="top"><?=$details->claim->amount->paid;?></td>
    </tr>
    <tr>
        <th class="tr_bg_h col_head" valign="top">Rendering Provider ID</th>
        <td class="tr_active" valign="top"><?=$claim_rendering_provider_ids?></td>
    </tr>
    <tr>
        <th class="tr_bg_h col_head" valign="top">MOA Codes</th>
        <td class="tr_active" valign="top"><?=$claim_moa_codes?></td>
    </tr>
    <tr>
        <th class="tr_bg_h col_head" valign="top">Allowed Amount</th>
        <td class="tr_active" valign="top"><?=$details->claim->allowed_amount;?></td>
    </tr>

    <? foreach ($details->claim->service_lines as $service_line): ?>
        <tr>
            <th rowspan="12" class="tr_bg_h col_head">Service Lines</th>
            <th class="tr_bg_h col_head" valign="top">Procedure Qualifier</th>
            <td class="tr_active" valign="top"><?=$service_line->procedure_qualifier;?></td>
        </tr>
        <tr>
            <th class="tr_bg_h col_head" valign="top">Procedure Code</th>
            <td class="tr_active" valign="top"><?=$service_line->procedure_code;?></td>
        </tr>
        <tr>
            <th class="tr_bg_h col_head" valign="top">Procedure Modifiers</th>
            <td class="tr_active" valign="top"><?=implode(' ', $service_line->procedure_modifiers);?></td>
        </tr>
        <tr>
            <th class="tr_bg_h col_head" valign="top">Revenue Code</th>
            <td class="tr_active" valign="top"><?=$service_line->revenue_code;?></td>
        </tr>
        <tr>
            <th class="tr_bg_h col_head" valign="top">Service Start</th>
            <td class="tr_active" valign="top"><?=$service_line->service_start;?></td>
        </tr>
        <tr>
            <th class="tr_bg_h col_head" valign="top">Service End</th>
            <td class="tr_active" valign="top"><?=$service_line->service_end;?></td>
        </tr>
        <tr>
            <th class="tr_bg_h col_head" valign="top">Amount Billed</th>
            <td class="tr_active" valign="top"><?=$service_line->amount->billed;?></td>
        </tr>
        <tr>
            <th class="tr_bg_h col_head" valign="top">Amount Paid</th>
            <td class="tr_active" valign="top"><?=$service_line->amount->paid;?></td>
        </tr>
        <tr>
            <th class="tr_bg_h col_head" valign="top">Quantity Billed</th>
            <td class="tr_active" valign="top"><?=$service_line->quantity->billed;?></td>
        </tr>
        <tr>
            <th class="tr_bg_h col_head" valign="top">Quantity Paid</th>
            <td class="tr_active" valign="top"><?=$service_line->quantity->paid;?></td>
        </tr>
        <tr>
            <th class="tr_bg_h col_head" valign="top">Allowed Amount</th>
            <td class="tr_active" valign="top"><?=$service_line->allowed_amount;?></td>
        </tr>

        <?
        $adjustments = '';
        foreach ($service_line->adjustments as $adjustment) {
            $adjustments .= 'Type: ' . $adjustment->type_code . ' ' . $adjustment->type_label . '<br/>';
            $adjustments .= '&emsp;Reason: ' . $adjustment->reason_code . ' ' . $adjustment->reason_label . '<br/>';
            $adjustments .= '&emsp;Amount: ' . $adjustment->amount . ' Quantity: ' . $adjustment->quantity . '<br/><br/>';
        }
        ?>
        <tr>
            <th class="tr_bg_h col_head">Adjustments</th>
            <td class="tr_active" valign="top"><?=$adjustments?></td>
        </tr>
    <? endforeach; ?>
</table>

<?php  include 'includes/bottom.htm';?>
