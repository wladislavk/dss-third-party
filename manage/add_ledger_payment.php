<?php namespace Ds3\Libraries\Legacy; ?><?php
include_once('admin/includes/main_include.php');
include("includes/sescheck.php");
include_once('includes/constants.inc');

$sql = "SELECT * FROM dental_ledger_payment WHERE ledgerid='".(!empty($_GET['ed']) ? $_GET['ed'] : '')."' ;";
$payments = $db->getResults($sql);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <link  rel="stylesheet" type="text/css" href="css/admin.css?v=20160329" />
    <link  rel="stylesheet" type="text/css" href="css/form.css" />
    <script type="text/javascript">
        var DSS_TRXN_PAYER_PRIMARY = <?php echo DSS_TRXN_PAYER_PRIMARY; ?>;
        var dss_trxn_payer_labels_primary = "<?php echo $dss_trxn_payer_labels[DSS_TRXN_PAYER_PRIMARY]; ?>";

        var DSS_TRXN_PAYER_SECONDARY = <?php echo DSS_TRXN_PAYER_SECONDARY; ?>;
        var dss_trxn_payer_labels_secondary = "<?php echo $dss_trxn_payer_labels[DSS_TRXN_PAYER_SECONDARY]; ?>";

        var DSS_TRXN_PAYER_PATIENT = <?php echo DSS_TRXN_PAYER_PATIENT; ?>;
        var dss_trxn_payer_labels_patient = "<?php echo $dss_trxn_payer_labels[DSS_TRXN_PAYER_PATIENT]; ?>";

        var DSS_TRXN_PAYER_WRITEOFF = <?php echo DSS_TRXN_PAYER_WRITEOFF; ?>;
        var dss_trxn_payer_labels_writeoff = "<?php echo $dss_trxn_payer_labels[DSS_TRXN_PAYER_WRITEOFF]; ?>";

        var DSS_TRXN_PAYER_DISCOUNT = <?php echo DSS_TRXN_PAYER_DISCOUNT; ?>;
        var dss_trxn_payer_labels_discount = "<?php echo $dss_trxn_payer_labels[DSS_TRXN_PAYER_DISCOUNT]; ?>";

        var DSS_TRXN_PYMT_CREDIT = <?php echo DSS_TRXN_PYMT_CREDIT; ?>;
        var dss_trxn_pymt_type_labels_credit = "<?php echo $dss_trxn_pymt_type_labels[DSS_TRXN_PYMT_CREDIT]; ?>";

        var DSS_TRXN_PYMT_DEBIT = <?php echo DSS_TRXN_PYMT_DEBIT; ?>;
        var dss_trxn_pymt_type_labels_debit = "<?php echo $dss_trxn_pymt_type_labels[DSS_TRXN_PYMT_DEBIT]; ?>";

        var DSS_TRXN_PYMT_CHECK = <?php echo DSS_TRXN_PYMT_CHECK; ?>;
        var dss_trxn_pymt_type_labels_check = "<?php echo $dss_trxn_pymt_type_labels[DSS_TRXN_PYMT_CHECK]; ?>";

        var DSS_TRXN_PYMT_CASH = <?php echo DSS_TRXN_PYMT_CASH; ?>;
        var dss_trxn_pymt_type_labels_cash = "<?php echo $dss_trxn_pymt_type_labels[DSS_TRXN_PYMT_CASH]; ?>";

        var DSS_TRXN_PYMT_WRITEOFF = <?php echo DSS_TRXN_PYMT_WRITEOFF; ?>;
        var dss_trxn_pymt_type_labels_writeoff = "<?php echo $dss_trxn_pymt_type_labels[DSS_TRXN_PYMT_WRITEOFF]; ?>";

        var DSS_TRXN_PYMT_EFT = <?php echo DSS_TRXN_PYMT_EFT; ?>;
        var dss_trxn_pymt_type_labels_eft = "<?php echo $dss_trxn_pymt_type_labels[DSS_TRXN_PYMT_EFT]; ?>";
    </script>
    <script type="text/javascript" src="/manage/admin/script/jquery-1.6.2.min.js"></script>
    <script type="text/javascript" src="3rdParty/input_mask/jquery.maskedinput-1.3.min.js"></script>
    <script type="text/javascript" src="/manage/js/masks.js"></script>
    <?php include 'includes/calendarinc.php' ?>
    <script type="text/javascript" src="js/add_ledger_payment.js?v=<?= time() ?>"></script>
</head>

<body>
<form id="ledgerentryform" name="ledgerentryform" action="insert_ledger_payment.php" method="post">
    <div style="width:200px; margin:0 auto; text-align:center;">
        <input type="hidden" value="0" id="currval" />
    </div>
    <div style="background:#FFFFFF none repeat scroll 0 0;height:16px;margin-left:9px;margin-top:20px;width:98%; font-weight:bold;">
        <span style="margin: 0pt 10px 0pt 0pt; float: left; width:83px;">Payment Date</span>
        <span style="width:80px;margin: 0pt 10px 0pt 0pt; float: left;" >Entry Date</span>
        <span style="width:120px;margin: 0pt 10px 0pt 0pt; float: left;">Paid By</span>
        <div style="margin: 0pt 10px 0pt 0pt; float: left; width: 327px;">Payment Type</div>
        <div style="float:left;font-weight:bold;">Amount</div>
    </div>

    <?php if ($payments) {
        foreach ($payments as $p) { ?>
            <div style="margin-left:9px; margin-top: 10px; width:98%;color: #fff;">
                <span style="margin: 0 10px 0 0; float:left;width:83px;"><?php echo  date('m/d/Y', strtotime($p['payment_date'])); ?></span>
                <span style="margin: 0 10px 0 0; float:left;width:80px;"><?php echo  date('m/d/Y', strtotime($p['entry_date'])); ?></span>
                <span style="margin: 0 10px 0 0; float:left;width:120px;"><?php echo  $dss_trxn_payer_labels[$p['payer']]; ?></span>
                <span style="margin: 0 10px 0 0; float:left;width:327px;"><?php echo  $dss_trxn_pymt_type_labels[$p['payment_type']]; ?></span>
                <span style="margin: 0 10px 0 0; float:left;"><?php echo  $p['amount']; ?></span>
                <div style="clear:both"></div>
            </div>
        <?php }
    } ?>

    <div id="FormFields" style="margin: 20px 10px;"></div>
    <input type="hidden" name="ledgerid" value="<?php echo (!empty($_GET['ed']) ? $_GET['ed'] : ''); ?>">
    <input type="hidden" name="patientid" value="<?php echo (!empty($_GET['pid']) ? $_GET['pid'] : ''); ?>">
    <input type="hidden" name="producer" value="<?php echo $_SESSION['username']; ?>">
    <input type="hidden" name="userid" value="<?php echo $_SESSION['userid']; ?>">
    <input type="hidden" name="docid" value="<?php echo $_SESSION['docid']; ?>">
    <input type="hidden" name="ipaddress" value="<?php echo $_SERVER['REMOTE_ADDR']; ?>">
    <input type="hidden" name="entrycount" value="javascript::readCookie();">
    <div style="width:200px;margin-left:10px;float:left;text-align:left;">
        <input type="button" onclick="appendElement();" id="linecountbtn"  value="Add Line Item">
    </div>
    <div style="width:200px;float:right;margin-right:10px;text-align:right;" id="submitButton">
        <input type="submit" value="Submit New Payment" />
    </div>
</form>
</body>
</html>
