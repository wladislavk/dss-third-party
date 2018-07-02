<?php
namespace Ds3\Libraries\Legacy;

include_once 'admin/includes/main_include.php';
include_once 'includes/constants.inc';
include_once 'includes/preauth_functions.php';
include "includes/sescheck.php";

$db = new Db();

$producer_options = '';
$p_sql = "SELECT * FROM dental_users WHERE userid=".$_SESSION['docid']." OR (docid=".$_SESSION['docid']." AND producer=1)";
$p_query = $db->getResults($p_sql);

if ($p_query) {
    foreach ($p_query as $p) {
        $producer_options .= '<option value="'.$p['userid'].'" '.(($p['userid'] == $_SESSION['userid']) ? 'selected="selected"' : '').'>'.$p['first_name'].' '.$p['last_name'].'</option>';
    }
}
$producer_options .= "";

$pla_sql = "SELECT post_ledger_adjustments FROM dental_users where userid='".$_SESSION['userid']."'";
$pla = $db->getRow($pla_sql);

$getTransCodesValue = 0;

if ($pla['post_ledger_adjustments'] != '1' && $_SESSION['docid'] != $_SESSION['userid']) {
    $getTransCodesValue = 1;
}

$errors = claim_errors($_GET['pid']);
$appendElementValue = 0;

if (count($errors) > 0) {
    $e_text = 'Unable to file claim: ';
    $e_text .= implode($errors, ', ');
    $appendElementValue = 1;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <link rel="stylesheet" type="text/css" href="css/admin.css?v=20160404" />
    <link rel="stylesheet" type="text/css" href="css/form.css" />
    <script type="text/javascript" src="/manage/admin/js/tracekit.js"></script>
    <script type="text/javascript" src="/manage/admin/js/tracekit.handler.js"></script>
    <script type="text/javascript" src="/manage/admin/script/jquery-1.6.2.min.js"></script>
    <script type="text/javascript" src="js/add_ledger_entry.js"></script>
    <script type="text/javascript" src="/manage/calendar1.js?v=20160328"></script>
    <script type="text/javascript" src="/manage/calendar2.js?v=20160328"></script>
    <?php include "includes/calendarinc.php"; ?>
    <script type="text/javascript">
        var getTransCodesValue = <?= json_encode($getTransCodesValue) ?>;
        var appendElementValue = <?= json_encode($appendElementValue) ?>;
        var appendElementEText = <?= json_encode($e_text) ?>;
        var appendElementProducerOptions = <?= json_encode($producer_options) ?>;
        var DSS_TRXN_PENDING = <?php echo DSS_TRXN_PENDING; ?>;
    </script>
</head>
<body onload="hideRemove();appendElement();">
<form id="ledgerentryform" name="ledgerentryform" action="insert_ledger_entries.php" method="POST" onsubmit="return validate()">
    <div style="width:200px; margin:0 auto; text-align:center;">
        <input type="hidden" value="0" id="currval" />
    </div>
    <div id="form_div" >
        <div style="background:#FFFFFF none repeat scroll 0 0;height:16px;margin-left:9px;margin-top:20px;width:98%; font-weight:bold;">
            <span style="margin: 0 10px 0 0; float: left; width:83px;">Service Date</span>
            <span style="width:80px;margin: 0 10px 0 0; float: left;" >Entry Date</span>
            <span style="width:120px;margin: 0 10px 0 0; float: left;">Producer</span>
            <span style="width:120px;margin: 0 10px 0 0; float: left;">Procedure Code</span>
            <div style="margin: 0 10px 0 0; float: left; width: 127px;">Transaction Code</div>
            <div style="float:left;font-weight:bold;">Amount</div>
        </div>
        <div id="FormFields" style="margin: 20px 10px;"></div>
        <input type="hidden" name="patientid" value="<?php echo $_GET['pid']; ?>">
        <input type="hidden" name="userid" value="<?php echo $_SESSION['userid']; ?>">
        <input type="hidden" name="docid" value="<?php echo $_SESSION['docid']; ?>">
        <input type="hidden" name="ipaddress" value="<?php echo $_SERVER['REMOTE_ADDR']; ?>">
        <input type="hidden" name="entrycount" value="javascript::readCookie();">
        <div style="width:200px;float:left;margin-left:10px;text-align:left;">
            <input type="button" onclick="appendElement();$('.remove').css('visibility','visible');" id="linecountbtn"  value="+ Add Line Item">
        </div>
        <div style="width:200px;margin-right:10px;float:right;text-align:right;" id="submitButton">
            <input type="submit" value="Submit Transactions" />
        </div>
    </div>
</form>
</body>
</html> 
