<?php
namespace Ds3\Libraries\Legacy;

/*
 *  Required variables:
 *  $mark_as_viewed  {true | false}
 *  $header_class  {'admin_head' | 'page-header'}
 *  $table_style  {'width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center"' | class="table table-bordered table-hover"}
 */

$docId = intval($_SESSION['docid']);
$adminCompanyId = intval($_SESSION['admincompanyid']);

$reportId = intval($_REQUEST['report_id']);
$errorMessages = [];

$extraJoins = '';
$userAccessConditional = '1 = 0'; // Deny access by default

if (!empty($is_back_office)) {
    if (is_super($_SESSION['admin_access'])) {
        $userAccessConditional = '1 = 1';
    } elseif (is_software($_SESSION['admin_access'])) {
        $extraJoins = "JOIN dental_user_company pivot ON pivot.userid = claim.docid";
        $userAccessConditional = "pivot.companyid = '$adminCompanyId'";
    } elseif (is_billing($_SESSION['admin_access'])) {
        $extraJoins = "JOIN dental_users doctor ON doctor.userid = claim.docid";
        $userAccessConditional = "doctor.billing_company_id = '$adminCompanyId'";
    }
} else {
    $userAccessConditional = "claim.docid = '$docId'";
}

/**
 * @see DSS-437
 *
 * Retrieve all NPIs associated to member of this office
 */
$npiList = $db->getResults("SELECT npi, medicare_npi, service_npi, service_medicare_npi
    FROM dental_users
    WHERE docid = '$docId'
        OR userid = '$docId'");

$npiList = $npiList ? array_flatten($npiList) : [];
$npiList = array_filter(array_unique($npiList));

if ($npiList) {
    array_walk($npiList, function (&$each) use ($db) {
        $each = 'report.response LIKE \'%"npi":"' . $db->escape($each) . '"%\'';
    });
    $npiList = join(' OR ', $npiList);
    $orNpiConditional = "OR ($npiList)";
} else {
    $orNpiConditional = '';
}

$reportData = $db->getRow("SELECT
        report.payment_id,
        report.claimid,
        report.reference_id,
        report.response,
        report.adddate,
        report.ip_address
    FROM dental_payment_reports report
        LEFT JOIN dental_insurance claim ON claim.insuranceid = report.claimid
            $orNpiConditional
        $extraJoins
    WHERE payment_id = '$reportId'
        AND (
            $userAccessConditional
            $orNpiConditional
        )
    ");

if (!$reportData) {
    $errorMessages []= 'No Payment Report with provided ID is found';
} else if (!empty($mark_as_viewed)) {
    $db->query("UPDATE dental_payment_reports SET viewed = 1 WHERE payment_id = '$reportId'");
}

$report = @json_decode($reportData['response']);
$details = $report->details;

if (isset($report->success) && !$report->success) {
    foreach ($report->errors as $error) {
        $errorMessages []= $error->message;
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

$patient_title = $details->patient->last_name . ' ' . $details->patient->first_name . ' ' . $details->patient->middle_name;
$service_provider_title = $details->service_provider->last_name . ' ' . $details->service_provider->first_name . ' ' . $details->service_provider->middle_name;
$payee_title = $details->payee->name;

?>
<br />
<div class="<?= $header_class ?>">
    Payment Report <br/>
    <?php if (trim($patient_title)) { ?>
        Patient: <?=$patient_title?> <br/>
    <?php } ?>
    <?php if (trim($service_provider_title)) { ?>
        Service Provider: <?=$service_provider_title?><br/>
    <?php } ?>
    <?php if (trim($payee_title)) { ?>
        Payee: <?=$payee_title?>
    <?php } ?>
</div>
<br />
<br />
<?php if ($errorMessages) { ?>
    <div class="<?= $header_class ?>">
        Errors: <?= join('<br>', $errorMessages) ?>
    </div>
<?php } ?>

<table <?= $table_style ?>>
    <tr>
        <th rowspan="2" class="tr_bg_h col_head" valign="top"></th>
        <th class="tr_bg_h col_head" valign="top">Claim Reference ID</th>
        <td class="tr_active" valign="top"><?=$reportData['reference_id'];?></td>
    </tr>
    <tr>
        <th class="tr_bg_h col_head" valign="top">Report Generation Date (YYYY-MM-DD)</th>
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
        <th class="tr_bg_h col_head" valign="top">Payment Trace Number</th>
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
        <th rowspan="4" class="tr_bg_h col_head">Service Provider</th>
        <th class="tr_bg_h col_head" valign="top">First Name</th>
        <td class="tr_active" valign="top"><?=$details->service_provider->first_name;?></td>
    </tr>
    <tr>
        <th class="tr_bg_h col_head" valign="top">Last Name</th>
        <td class="tr_active" valign="top"><?=$details->service_provider->last_name;?></td>
    </tr>
    <tr>
        <th class="tr_bg_h col_head" valign="top">Middle Name</th>
        <td class="tr_active" valign="top"><<?=$details->service_provider->middle_name;?>/td>
    </tr>
    <tr>
        <th class="tr_bg_h col_head" valign="top">NPI</th>
        <td class="tr_active" valign="top"><?=$details->service_provider->npi;?></td>
    </tr>
    <tr>
        <th rowspan="14" class="tr_bg_h col_head">Claim</th>
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
        <th class="tr_bg_h col_head" valign="top">Amount Patient Responsibility</th>
        <td class="tr_active" valign="top"><?=$details->claim->amount->patient_responsibility;?></td>
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
    <?php foreach ($details->claim->service_lines as $service_line) { ?>
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
        <?php

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
    <?php } ?>
</table>
