<?php
namespace Ds3\Libraries\Legacy;

require_once __DIR__ . '/includes/top.htm';

$db = new Db();

$docId = (int)$_SESSION['docid'];
$invoice_id = (int)array_get($_REQUEST, 'invoice_id', 0);
$invoice_sql = "SELECT i.*, u.name
    FROM dental_percase_invoice i
    JOIN dental_users u ON u.userid = i.docid
    WHERE i.id = '$invoice_id'";
$invoice = $db->getRow($invoice_sql);

$case_sql = "
        SELECT
            percase_name,
            percase_date,
            '' as end_date,
            percase_amount,
            ledgerid
        FROM dental_ledger dl
        JOIN dental_patients dp ON dl.patientid = dp.patientid
        WHERE dl.transaction_code = 'E0486'
        AND dl.docid = '$docId'
        AND dl.percase_invoice = '$invoice_id'
    UNION
        SELECT
            percase_name,
            percase_date,
            '',
            percase_amount,
            insuranceid
        FROM dental_insurance i
        WHERE  i.percase_invoice = '$invoice_id'
    UNION
        SELECT
            percase_name,
            percase_date,
            '',
            percase_amount,
            id
        FROM dental_claim_electronic e
        WHERE e.percase_invoice = '$invoice_id'
    UNION
        SELECT
            percase_name,
            percase_date,
            '',
            percase_amount,
            id
        FROM dental_percase_invoice_extra dl
        WHERE dl.percase_invoice = '$invoice_id'
    UNION
        SELECT
            CONCAT('Insurance Verification Services – ', patient_firstname, ' ', patient_lastname),
            invoice_date,
            '',
            invoice_amount,
            id
        FROM dental_insurance_preauth
        WHERE invoice_id = '$invoice_id'
    UNION
        SELECT
            description,
            start_date,
            end_date,
            amount,
            id
        FROM dental_fax_invoice
        WHERE invoice_id = '$invoice_id'
    UNION
        SELECT
            description,
            start_date,
            end_date,
            amount,
            id
        FROM dental_eligibility_invoice
        WHERE invoice_id = '$invoice_id'
    UNION
        SELECT
            description,
            start_date,
            end_date,
            amount,
            id
        FROM dental_enrollment_invoice
        WHERE invoice_id = '$invoice_id'
    UNION
        SELECT
            new_fee_desc,
            new_fee_date,
            '',
            new_fee_amount,
            patientid
        FROM dental_patients
        WHERE new_fee_invoice_id = '$invoice_id'
";
$case_q = $db->getResults($case_sql);
?>
<link rel="stylesheet" href="/manage/admin/popup/popup.css" type="text/css" media="screen" />
<script src="/manage/admin/popup/popup.js" type="text/javascript"></script>
<span class="admin_head">
    Invoice <?php echo $invoice['id']; ?>
</span>
<br />
<div align="center" class="red">
    <b><?php echo (!empty($_GET['msg']) ? $_GET['msg'] : '');?></b>
</div>
<br /><br />
<form name="sortfrm" action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
    <input type="hidden" name="docid" value="<?php echo (!empty($_GET["docid"]) ? $_GET["docid"] : '');?>" />
    <table id="invoice_table" width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center" >
        <tr class="tr_bg_h">
            <td valign="top" class="col_head" width="40%">
                Patient Name
            </td>
            <td valign="top" class="col_head" width="40%">
                Service Date
            </td>
            <td valign="top" class="col_head" width="20%">
                Amount
            </td>
        </tr>
        <?php
        if ($invoice['monthly_fee_amount'] != 0) { ?>
            <tr id="month_row">
                <td valign="top">
                    MONTHLY FEE
                </td>
                <td valign="top">
                    <?php echo date('m/d/Y', strtotime($invoice['monthly_fee_date']));?>
                </td>
                <td valign="top">
                    $<?php echo  $invoice['monthly_fee_amount']; ?>
                </td>
            </tr>
            <?php
        }
        if ($case_q) {
            foreach ($case_q as $case) { ?>
                <tr id="case_row_<?php echo (!empty($case['ledgerid']) ? $case['ledgerid'] : '') ?>">
                    <td valign="top">
                        <?php echo st($case["percase_name"]);?>
                    </td>
                    <td valign="top">
                        <?php echo date('m/d/Y', strtotime(st($case["percase_date"])));?>
                    </td>
                    <td valign="top">
                        $<?php echo number_format($case['percase_amount'],2); ?>
                    </td>
                </tr>
                <?php
            }
        }

        $total_sql = "SELECT sum(percase_amount) AS case_total FROM ($case_sql) t1";
        $case_total = $db->getRow($total_sql);

        if (empty($case_total)) {
           $case_total['case_total'] = 0;
           $invoice['monthly_fee_amount'] = 0;
        }
        ?>
        <tr id="total_row">
            <td valign="top" colspan="2">&nbsp;
                Total: <span id="total" style="font-weight:bold;">$<?php echo number_format(($case_total['case_total'] + $invoice['monthly_fee_amount']), 2); ?></span>
                <input type="hidden" name="extra_total" id="extra_total" value="0" />
            </td>
            <td></td>
            <td valign="top" class="col_head"></td>
        </tr>
    </table>
</form>

<script type="text/javascript">
    var date = <?php echo date('m/d/Y'); ?>;
</script>
<script type="text/javascript" src="/manage/js/invoice_history_view.js"></script>

<br /><br />
<?php include "includes/bottom.htm"; ?>
