<?php
namespace Ds3\Libraries\Legacy;

include_once 'admin/includes/main_include.php';
include_once 'includes/constants.inc';
include_once 'includes/claim_functions.php';
include_once 'admin/includes/claim_functions.php'; // To use cratePrimaryClaim function
include "includes/sescheck.php";
include "includes/preauth_functions.php";

if (!empty($_POST["ledgerub"]) && $_POST["ledgerub"] == 1) {
    $service_date = $_POST['service_date'];
    $entry_date = $_POST['entry_date'];
    $description = $_POST['description'];
    $amount = str_replace(',', '', $_POST['amount']);
    $paid_amount = str_replace(',', '', $_POST['paid_amount']);
    $transaction_type = $_POST['transaction_type'];
    $transaction_code = $_POST['transaction_code'];
    if (strpos($service_date, '-') === false) {
        $s_arr = explode('/', $service_date);
        $service_date = $s_arr[2]."-".$s_arr[0]."-".$s_arr[1];
    } else {
        $s_arr = explode('-', $service_date);
        $service_date = $s_arr[2]."-".$s_arr[0]."-".$s_arr[1];
    }

    if (strpos($entry_date, '-') === false) {
        $e_arr = explode('/', $entry_date);
        $entry_date = $e_arr[2]."-".$e_arr[0]."-".$e_arr[1];
    } else {
        $e_arr = explode('-', $entry_date);
        $entry_date = $e_arr[2]."-".$e_arr[0]."-".$e_arr[1];
    }

    if ($transaction_type == 'Entry') {
        $paid_amount = 0;
    }

    if ($_POST['ed'] == '') {
        $ins_sql = "insert into dental_ledger set 
            patientid = '".$db->escape( $_GET['pid'])."',
            service_date = '".$db->escape( $service_date)."',
            entry_date = '".$db->escape( $entry_date)."',
            description = '".$db->escape( $description)."',
            amount = '".$db->escape( $amount)."',
            paid_amount = '".$db->escape( $paid_amount)."',
            transaction_type = '".$db->escape( $transaction_type)."',
            userid = '".$db->escape( $_SESSION['userid'])."',
            docid = '".$db->escape( $_SESSION['docid'])."',
            transaction_code = '".$db->escape( $transaction_code)."',
            adddate = now(),
            ip_address = '".$db->escape( $_SERVER['REMOTE_ADDR'])."'";
        $db->getInsertId($ins_sql);

        $ins_sql_rec = "insert into dental_ledger_rec set 
            userid = '".$db->escape( $_SESSION['userid'])."',
            patientid = '".$db->escape( $_GET['pid'])."',
            service_date = '".$db->escape( $service_date)."',
            description = '".$db->escape( $description)."',
            amount = '".$db->escape( $amount)."',
            paid_amount = '".$db->escape( $paid_amount)."',
            transaction_code = '".$db->escape( $transaction_code)."',
            transaction_type = '".$db->escape( $transaction_type)."',
            ip_address = '".$db->escape( $_SERVER['REMOTE_ADDR'])."'";
        $db->query($ins_sql_rec);
        $msg = "Added Successfully"; ?>
        <script type="text/javascript">
            parent.window.location = 'manage_ledger.php?msg=<?php echo $msg;?>&pid=<?php echo $_GET['pid'];?>';
        </script>
        <?php
        trigger_error("Die called", E_USER_ERROR);
    } elseif (count($_POST)) {
        $pat_sql2 = "select * from dental_patients where patientid='".$db->escape( $_GET['pid'])."'";
        $pat_my2 = $db->getResults($pat_sql2);

        if ($pat_my2) {
            foreach ($pat_my2 as $pat_myarray2) {
                $pat_sql3 = $db->query("INSERT INTO dental_ledger_rec (userid, patientid, service_date, description, amount, paid_amount,transaction_code, ip_address, transaction_type) VALUES ('".$_SESSION['username']."','".(!empty($_GET['pid']) ? $_GET['pid'] : '')."','".(!empty($pat_myarray2['service_date']) ? $pat_myarray2['service_date'] : '')."','".(!empty($pat_myarray2['description']) ? $pat_myarray2['description'] : '')."','".(!empty($pat_myarray2['amount']) ? $pat_myarray2['amount'] : '')."','".(!empty($pat_myarray2['paid_amount']) ? $pat_myarray2['paid_amount'] : '')."','".(!empty($pat_myarray2['transaction_code']) ? $pat_myarray2['transaction_code'] : '')."','".(!empty($pat_myarray2['ip_address']) ? $pat_myarray2['ip_address'] : '')."', '".(!empty($pat_myarray2['transaction_type']) ? $pat_myarray2['transaction_type'] : '')."');");
                if (!$pat_sql3) {
                    echo "There was an error updating the ledger record.  Please contact your system administrator.";
                }

                $service_date = date('Y-m-d', strtotime((!empty($_POST['service_date']) ? $_POST['service_date'] : '')));
                $entry_date = date('Y-m-d', strtotime((!empty($_POST['entry_date']) ? $_POST['entry_date'] : '')));
                $transaction_type = (!empty($_POST['transaction_type']) ? $_POST['transaction_type'] : '');
                $transaction_code = (!empty($_POST['proccode']) ? $_POST['proccode'] : '');

                $tsql = "SELECT transaction_code, description from dental_transaction_code where transaction_codeid = '" . $transaction_code . "'";
                $trow = $db->getRow($tsql);

                $transaction_code = $trow['transaction_code'];
                $description = $trow['description'];
                $status = (isset($_POST['status'])) ? DSS_TRXN_PENDING : DSS_TRXN_NA;
                $amount = str_replace(',', '', $_POST['amount']);
                $paid_amount = str_replace(',', '', $_POST['paid_amount']);
                $claim_sql = "SELECT * FROM dental_ledger where ledgerid='".$_POST["ed"]."'";
                $claim_r = $db->getRow($claim_sql);

                if (($claim_r['primary_claim_id'] == '' || $claim_r['primary_claim_id'] == 0) && $status == DSS_TRXN_PENDING) {
                    $pf_sql = "SELECT producer_files FROM dental_users WHERE userid='".$db->escape($claim_r['producerid'])."'";
                    $pf = $db->getRow($pf_sql);

                    if ($pf['producer_files'] == '1') {
                        $claim_producer = $claim_r['producerid'];
                    } else {
                        $claim_producer = $_SESSION['docid'];
                    }

                    $s = "SELECT insuranceid from dental_insurance where producer='".$claim_producer."' AND patientid='".$db->escape($_GET['pid'])."' AND status='".DSS_CLAIM_PENDING."' LIMIT 1";
                    $q = $db->getResults($s);

                    $n = count($q);
                    if ($n > 0) {
                        $r = $q[0];
                        $claim_id = $r['insuranceid'];
                    } else {
                        $claim_id = ClaimFormData::createPrimaryClaim($_GET['pid'], $claim_producer);
                    }
                } else {
                    $claim_id = $claim_r['primary_claim_id'];
                }

                if ($status == DSS_TRXN_NA) {
                    $claim_id = '';
                }

                $up_sql = "update dental_ledger set
                    service_date = '".$db->escape( $service_date)."',
                    entry_date = '".$db->escape( $entry_date)."',
                    description = '".$db->escape( $description)."',
                    amount = '".$db->escape( $amount)."',
                    paid_amount = '".$db->escape( $paid_amount)."',
                    transaction_type = '".$db->escape( $transaction_type)."',
                    transaction_code = '".$db->escape( $transaction_code)."',
                    userid = '".$db->escape( $_SESSION['userid'])."',
                    status = ". $db->escape( $status).",
                    primary_claim_id='".$claim_id."'
                    where ledgerid='".$_POST["ed"]."'";
                $db->query($up_sql);

                $msg = "Edited Successfully";
                ?>
                <script type="text/javascript">
                    parent.window.location = 'manage_ledger.php?msg=<?php echo $msg;?>&pid=<?php echo $_GET['pid'];?>';
                </script>
                <?php
                trigger_error("Die called", E_USER_ERROR);
            }
        }
    }
}
$pat_sql = "select * from dental_patients where patientid='".$db->escape( $_GET['pid'])."'";

$pat_myarray = $db->getRow($pat_sql);
$name = st($pat_myarray['lastname'])." ".st($pat_myarray['middlename'])." ".st($pat_myarray['firstname']);
if ($pat_myarray['patientid'] == '') { ?>
    <script type="text/javascript">
        window.location = 'manage_patient.php';
    </script>
    <?php
    trigger_error("Die called", E_USER_ERROR);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <link href="css/admin.css?v=20160404" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="css/form.css" type="text/css" />
    <script type="text/javascript" src="/manage/admin/js/tracekit.js"></script>
    <script type="text/javascript" src="/manage/admin/js/tracekit.handler.js"></script>
    <script type="text/javascript" src="/manage/admin/script/jquery-1.6.2.min.js"></script>
    <script type="text/javascript" src="/manage/3rdParty/input_mask/jquery.maskedinput-1.3.min.js"></script>
    <script type="text/javascript" src="/manage/js/masks.js"></script>
    <script type="text/javascript" src="script/validation.js"></script>
    <?php include "includes/calendarinc.php"; ?>
    <script type="text/javascript" src="/manage/calendar1.js?v=20160328"></script>
    <script type="text/javascript" src="/manage/calendar2.js?v=20160328"></script>
    <script type="text/javascript" src="js/add_ledger.js"></script>
</head>
<body>
<?php
$sql = "select sum(amount) as amt, sum(paid_amount) as p_amt from dental_ledger where patientid='".$_REQUEST["pid"]."'";
$myarray = $db->getRow($sql);

$cur_balance = $myarray['amt'] - $myarray['p_amt'];

$thesql = "select * from dental_ledger where ledgerid='".$_REQUEST["ed"]."'";
$themyarray = $db->getRow($thesql);

$service_date = st($themyarray['service_date']);
$entry_date = st($themyarray['entry_date']);
$amount = st($themyarray['amount']);
$paid_amount = st($themyarray['paid_amount']);
$transaction_code = st($themyarray['transaction_code']);

$tsql = "SELECT type FROM dental_transaction_code WHERE docid=".$_SESSION['docid']." AND transaction_code='".$transaction_code."'";
$trow = $db->getRow($tsql);

$transaction_type = $trow['type'];
$status = ($themyarray['primary_claim_id'] != 0 && $themyarray['primary_claim_id'] != '') ? DSS_TRXN_PENDING : DSS_TRXN_NA;

if ($service_date == '') {
    $service_date = date('m/d/Y');
} else {
    $service_date = date('m/d/Y', strtotime($service_date));
}

if ($entry_date == '') {
    $entry_date = date('m/d/Y');
} else {
    $entry_date = date('m/d/Y', strtotime($entry_date));
}

if ($themyarray["userid"] != '') {
    $but_text = "Edit ";
} else {
    $but_text = "Add ";
}
?>
<br /><br />
<?php if ($msg != '') { ?>
    <div align="center" class="red">
        <?php echo $msg;?>
    </div>
<?php } ?>
<form name="ledgerfrm" action="<?php echo $_SERVER['PHP_SELF'];?>?add=1&pid=<?php echo $_GET['pid']?>" method="post" onSubmit="return addledgerabc(this)">
    <table cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center">
        <tr>
            <td colspan="2" class="cat_head">
               <?php echo $but_text?> Transaction
               -
                Patient <i><?php echo $name;?></i>
            </td>
        </tr>
        <tr>
            <td valign="top" class="frmdata" colspan="2" style="text-align:right;">
                <span class="red">
                    Current Balance:
                    <b>$<?php echo number_format($cur_balance,2);?></b>
                </span>
            </td>
        </tr>
        <tr>
            <td valign="top" class="frmhead" width="30%">
                Service Date
            </td>
            <td valign="top" class="frmdata">
                <input id="service_date" name="service_date" type="text" class="tbox calendar" value="<?php echo $service_date;?>" style="width:100px;" maxlength="255"/> (mm/dd/yyyy)
                 <script type="text/javascript">
                     var cal = new calendar2(document.getElementById('service_date'));
                 </script>
                <span class="red">*</span>
            </td>
        </tr>
        <tr>
            <td valign="top" class="frmhead">
                Entry Date
            </td>
            <td valign="top" class="frmdata">
                <input id="entry_date" name="entry_date" type="text" class="tbox" value="<?php echo $entry_date;?>" style="width:100px;" maxlength="255" readonly="readonly"/> (mm/dd/yyyy)
                <span class="red">*</span>
            </td>
        </tr>
        <tr>
            <td valign="top" class="frmhead">
                Posted By
            </td>
            <td valign="top" class="frmdata">
                <?php
                $h_sql = "SELECT h.updated_at, CONCAT(u.first_name,' ',u.last_name) doc_name,
                    CONCAT(a.first_name,' ',a.last_name) admin_name
                    FROM dental_ledger_history h 
                    LEFT JOIN dental_users u ON u.userid=h.updated_by_user
                    LEFT JOIN admin a ON a.adminid=h.updated_by_admin
                    WHERE h.ledgerid='".$db->escape( $_GET['ed'])."' ORDER BY h.updated_at ASC LIMIT 1";
                $h_r = $db->getRow($h_sql);
                if ($h_r['doc_name'] != '') {
                    echo $h_r['doc_name'];
                } elseif ($h_r['admin_name'] != '') {
                    echo $h_r['admin_name'];
                }
                echo " - ".$h_r['updated_at'];
                ?>
            </td>
        </tr>
        <tr>
            <td valign="top" class="frmhead">
                Last Updated By
            </td>
            <td valign="top" class="frmdata">
                <?php
                $h_sql = "SELECT h.updated_at, CONCAT(u.first_name,' ',u.last_name) doc_name,
                    CONCAT(a.first_name,' ',a.last_name) admin_name
                    FROM dental_ledger_history h 
                    LEFT JOIN dental_users u ON u.userid=h.updated_by_user
                    LEFT JOIN admin a ON a.adminid=h.updated_by_admin
                    WHERE h.ledgerid='".$db->escape($_GET['ed'])."' ORDER BY h.updated_at DESC LIMIT 1";
                $h_r = $db->getRow($h_sql);
                if ($h_r['doc_name'] != '') {
                    echo $h_r['doc_name'];
                } elseif ($h_r['admin_name'] != '') {
                    echo $h_r['admin_name'];
                }
                echo " - ".$h_r['updated_at'];
                ?>
            </td>
        </tr>
        <tr>
            <td valign="top" class="frmhead">
                Transaction Type
            </td>
            <td valign="top" class="frmdata">
                <select name="transaction_type" style="width:120px;margin: 0 10px 0 0; float: left;" onchange="getTransCodes(this.value,this.name)">
                    <option value="0" <?php echo ($transaction_type == '0') ? 'selected="selected"' : ''; ?>>Select Type</option>
                    <option value="1" <?php echo ($transaction_type == '1') ? 'selected="selected"' : ''; ?>>Medical Code</option>
                    <option value="2" <?php echo ($transaction_type == '2') ? 'selected="selected"' : ''; ?>>Patient Payment Code</option>
                    <option value="4" <?php echo ($transaction_type == '4') ? 'selected="selected"' : ''; ?>>Diagnostic Code</option>
                    <option value="6" <?php echo ($transaction_type == '6') ? 'selected="selected"' : ''; ?>>Adjustment Code</option>
                </select>
                <span class="red">*</span>
            </td>
        </tr>
        <tr>
            <td valign="top" class="frmhead">
                Procedure Code
            </td>
            <td valign="top" class="frmdata">
                <div id="proccode_div">
                    <?php
                        $sql="SELECT * FROM dental_transaction_code WHERE type = '".$transaction_type."' and docid=".$_SESSION['docid'];
                        $result = $db->getResults($sql);

                        echo "<select onchange='getTransCodesAmount(this.value,this.name,".$transaction_type.")' id='proccode' name='proccode'><option value='0'>Select TX Code</option>";
                        if ($result) {
                            foreach ($result as $row) {
                                $r = ($row['transaction_code'] == $transaction_code) ? 'selected="selected"' : '';
                                echo "<option ".$r." value='".$row['transaction_codeid']."'>".$row['transaction_code']." - ".$row['description']."</option>";
                            }
                        }
                        echo "</select>";
                    ?>
                </div>
                <span class="red">*</span>
            </td>
        </tr>
        <tr id="tr_amount" <?php echo ($transaction_type == 2 || $transaction_type == 3 || $transaction_type == 6) ? 'style="display:none;"' : ''?>>
            <td valign="top" class="frmhead">
                Amount
            </td>
            <td valign="top" class="frmdata">
                <span id="amount_span"><input readonly="readonly" name="amount" type="text" class="dollar_input tbox" value="<?php echo $amount; ?>"  maxlength="255"/></span>
                <span class="red">*</span>
            </td>
        </tr>
        <tr id="tr_paid_amount" <?php echo ($transaction_type != 2 && $transaction_type != 3 && $transaction_type != 6) ? 'style="display:none;"' : ''?>>
            <td valign="top" class="frmhead">
                Paid Amount
            </td>
            <td valign="top" class="frmdata">
                <input id="paid_amount" name="paid_amount" type="text"  class="dollar_input tbox" value="<?php if (isset($paid_amount)) { echo number_format($paid_amount, 2, '.', ''); } ?>"  maxlength="255"/>
                <span class="red">*</span>
            </td>
        </tr>
        <tr>
            <td valign="top" class="frmhead">
                File
            </td>
            <td valign="top" class="frmdata">
                <?php
                $errors = claim_errors($_GET['pid']);
                if (count($errors) > 0) {
                    $e_text = 'Unable to file claim: ';
                    $e_text .= implode($errors, ', '); ?>
                    <input type="checkbox" onclick="alert('<?php echo $e_text; ?>'); return false;" name="status" value="<?php echo DSS_TRXN_PENDING ?>" />
                    <?php
                } else { ?>
                    <input type="checkbox" name="status" <?php echo ($status == DSS_TRXN_PENDING) ? 'checked="checked"' : ''; ?> value="<?php echo DSS_TRXN_PENDING ?>" />
                    <?php
                } ?>
                <span class="pend"><?php echo ($status == DSS_TRXN_PENDING) ? 'Pending' : ''; ?></span>
                <input type="hidden" name="old_status" value="<?php echo $status; ?>" />
            </td>
        </tr>
        <tr>
            <td>
                <?php if (!($themyarray['status'] == DSS_CLAIM_SENT || $themyarray['status'] == DSS_CLAIM_PAID_INSURANCE)) { ?>
                    <a href="/manage/manage_ledger.php?delid=<?php echo  $_GET['ed']; ?>&amp;pid=<?php echo  $_GET['pid']; ?>" target="_parent" style="font-weight:bold;" onclick="return confirm('Do Your Really want to Delete?.');" class="dellink" title="DELETE">
                        Delete
                    </a>
                <?php } ?>
            </td>
            <td>
                <span class="red">
                    * Required Fields
                </span><br />
                <input type="hidden" name="ledgerub" value="1" />
                <input type="hidden" name="ed" value="<?php echo $_GET["ed"]?>" />
                <input type="submit" value=" <?php echo $but_text?> Transaction" style="float:right;" class="button" />
            </td>
        </tr>
    </table>
</form>
</body>
</html>
