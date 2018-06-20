<?php
namespace Ds3\Libraries\Legacy;

session_start();

require_once('admin/includes/main_include.php');
include("includes/sescheck.php");
require_once('includes/constants.inc');

$db = new Db();

if(isset($_GET['pid'])){
    $sql = "select * from dental_patients where docid='".$_SESSION['docid']."' AND patientid=".$_GET['pid'];
    $my = $db->getResults($sql);
    foreach ($my as $myarray) {
        $thename= $myarray['lastname'].", ".$myarray['firstname'];
        $theaddress = $myarray['add1']." ".$myarray['add2']." ".$myarray['city']." ".$myarray['state']." ".$myarray['zip'];
        $thephone = "H: ".format_phone($myarray['home_phone'])." W: ".format_phone($myarray['work_phone'])." C: ".format_phone($myarray['cell_phone']);
    }
}

$start_date = (!empty($_GET['start_date']) ? $_GET['start_date'] : '');
$end_date = (!empty($_GET['end_date']) ? $_GET['end_date'] : ''); 

if(isset($_GET['pid'])){
    $sql = "select * from dental_ledger where patientid='".$_GET['pid']."' "; 
}else{
    $sql = "select * from dental_ledger where docid='".$_SESSION['docid']."' ";
}

$sql .= " order by service_date";

$my = $db->getResults($sql);

if (!$my) {
    echo 'No Results for print';
    trigger_error('Die called', E_USER_ERROR);
}

$num_users = count($my);
?>
<html>
<head>
    <link rel="stylesheet" href="admin/popup/popup.css" type="text/css" media="screen" />
    <script src="admin/popup/popup.js" type="text/javascript"></script>
</head>
<body onload="window.print()">
<span class="admin_head">
    Ledger Report
    <?php
    if(!empty($_REQUEST['dailysub']) && $_REQUEST['dailysub'] == 1){?>
        (<i><?php echo date('m-d-Y', strtotime($_REQUEST['start_date'])); ?></i>)
    <?php
    }
    if(!empty($_REQUEST['weeklysub']) && $_REQUEST['weeklysub'] == 1){?>
        (<i><?php echo date('m-d-Y', strtotime($start_date))?> - <?php echo date('m-d-Y', strtotime($end_date))?></i>)
    <?php
    }
    if(!empty($_REQUEST['monthlysub']) && $_REQUEST['monthlysub'] == 1){?>
        (<i><?php echo date('m-Y', strtotime($_REQUEST['start_date'])) ?></i>)
    <?php
    }
    if($_GET['pid'] <> ''){?>
        (<i><?php echo $thename;?></i>)
        <br />
        <?php echo $theaddress; ?>
        <br />
        <?php echo $thephone;
    }?>
</span>
<table width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center" >
    <tr class="tr_bg_h">
        <td valign="top" class="col_head" width="10%">
            Svc Date
        </td>
        <td valign="top" class="col_head" width="10%">
            Entry Date
        </td>
        <td valign="top" class="col_head" width="10%">
            Patient
        </td>
        <td valign="top" class="col_head" width="10%">
            Producer
        </td>
        <td valign="top" class="col_head" width="30%">
            Description
        </td>
        <td valign="top" class="col_head" width="10%" style="text-align: right;">
            Charges
        </td>
        <td valign="top" class="col_head" width="10%" style="text-align: right;">
            Credits
        </td>
        <td valign="top" class="col_head" width="10%" style="text-align: right;">
            Adj.
        </td>
        <td valign="top" class="col_head" width="5%"  style="text-align: left;">
            Ins
        </td>
    </tr>
    <?php
    if($num_users == 0){ ?>
        <tr class="tr_bg">
            <td valign="top" class="col_head" colspan="10" align="center">
                No Records
            </td>
        </tr>
        <?php
    }else{
        $tot_credit = 0;
        $tot_adj = 0;
        if(isset($_GET['pid'])){
            $lpsql = " AND dl.patientid = '".$_GET['pid']."'";
        }else{
            $lpsql = "";
        }

        if($start_date){
            $l_date = " AND dl.service_date BETWEEN '".$start_date."' AND '".$end_date."'";
            $p_date = " AND dlp.payment_date BETWEEN '".$start_date."' AND '".$end_date."'";
        }else{
            $p_date = $l_date = '';
        }
        $newquery = "
            select 
                'ledger',
                dl.ledgerid,
                dl.service_date,
                dl.entry_date,
                dl.amount,
                dl.paid_amount,
                dl.status, 
                dl.description,
                CONCAT(p.first_name,' ',p.last_name) as name,
                pat.patientid,
                pat.firstname, 
                pat.lastname,
                tc.type as payer,
                '' as payment_type,
                dl.primary_claim_id
            from dental_ledger dl 
            JOIN dental_patients as pat ON dl.patientid = pat.patientid
            LEFT JOIN dental_users as p ON dl.producerid=p.userid 
            LEFT JOIN dental_transaction_code tc on tc.transaction_code = dl.transaction_code AND tc.docid='".$_SESSION['docid']."'
            where dl.docid='".$_SESSION['docid']."' ".$lpsql." 
            ".$l_date."
        UNION
            select 
                'ledger_payment',
                dlp.id,
                dlp.payment_date,
                dlp.entry_date,
                '',
                dlp.amount,
                '',
                '',
                CONCAT(p.first_name,' ',p.last_name),
                pat.patientid,
                pat.firstname,
                pat.lastname,
                dlp.payer,
                dlp.payment_type,
                ''
            from dental_ledger dl 
            JOIN dental_patients pat on dl.patientid = pat.patientid
            LEFT JOIN dental_users p ON dl.producerid=p.userid 
            LEFT JOIN dental_ledger_payment dlp on dlp.ledgerid=dl.ledgerid
            where dl.docid='".$_SESSION['docid']."' ".$lpsql."
            AND dlp.amount != 0
            ".$p_date."
        ";
        $runquery = $db->getResults($newquery);

        foreach ($runquery as $myarray) {
            $pat_sql = "select * from dental_patients where patientid='".$myarray['patientid']."'";
            $pat_myarray = $db->getRow($pat_sql);

            $name = st($pat_myarray['lastname'])." ".st($pat_myarray['middlename'])." ".st($pat_myarray['firstname']);

            $tr_class = "tr_active"; ?>
            <tr class="<?php echo $tr_class;?>">
                <td valign="top" width="10%">
                    <?php echo date('m-d-Y',strtotime(st($myarray["service_date"])));?>
                </td>
                <td valign="top" width="10%">
                    <?php echo date('m-d-Y',strtotime(st($myarray["entry_date"])));?>
                </td>
                <td valign="top" width="10%">
                    <?php echo st($name);?>
                </td>
                <td valign="top" width="10%">
                    <?php echo st($myarray["name"]);?>
                </td>
                <td valign="top" width="30%">
                <?php echo ((!empty($myarray['ledger']) && $myarray['ledger'] == 'ledger_paid'))?$dss_trxn_type_labels[$myarray['payer']]." - ":'';
                      echo $myarray["description"];
                      echo ((!empty($myarray['ledger']) && $myarray['ledger'] == 'ledger' || !empty($myarray['ledger']) && $myarray['ledger'] =='claim') && $myarray['primary_claim_id'])?"(".$myarray['primary_claim_id'].") ":'';
                      echo ((!empty($myarray['ledger']) && $myarray['ledger'] == 'ledger_payment'))?$dss_trxn_payer_labels[$myarray['payer']]." Payment - ":'';
                      echo ((!empty($myarray['ledger']) && $myarray['ledger'] == 'ledger_payment'))?$dss_trxn_pymt_type_labels[$myarray['payment_type']]." ":'';
                      echo ((!empty($myarray['ledger']) && $myarray['ledger'] == 'ledger_payment') && $myarray['primary_claim_id'])?"(".$myarray['primary_claim_id'].") ":''; ?>
                </td>
                <td valign="top" align="right" width="10%">
                    <?php
                    if (!isset($tot_charge)) {
                        $tot_charge = 0;
                    }

                    if(!empty($myarray['ledger']) && $myarray['ledger']!='claim' && $myarray['amount'] <> 0){
                        echo number_format($myarray["amount"],2);
                        $tot_charge += $myarray["amount"];
                    } ?>
                </td>
                <?php
                if((!empty($myarray['ledger']) && $myarray['ledger'] == 'ledger' && $myarray['payer']==DSS_TRXN_TYPE_ADJ)){
                    $tot_adj += st($myarray["paid_amount"]);?>
                    <td></td>
                    <?php
                } ?>
                <td valign="top" align="right" width="10%">
                    <?php
                    if(!empty($myarray['ledger']) && $myarray['ledger']!='claim') {
                        if(st($myarray["paid_amount"]) <> 0) {
                            echo number_format(st($myarray["paid_amount"]),2);
                        }
                    } ?>
                </td>
                <?php
                if(!(!empty($myarray['ledger']) && $myarray['ledger'] == 'ledger' && $myarray['payer']==DSS_TRXN_TYPE_ADJ)){
                    $tot_credit += st($myarray["paid_amount"]);?>
                    <td></td>
                    <?php
                } ?>
                <td valign="top" align="left" width="5%">
                    <?php
                    if(!empty($myarray['ledger']) && $myarray['ledger'] == 'ledger'){
                        echo trim($dss_trxn_status_labels[$myarray["status"]]);
                    }elseif(!empty($myarray['ledger']) && $myarray['ledger'] == 'claim'){
                        echo trim($dss_claim_status_labels[$myarray["status"]]);
                    }
                }   ?>
        </td>
    </tr>
<?php
}?> 

    <tr>
        <td valign="top" colspan="5" align="right">
            <b>Total</b>
        </td>
        <td valign="top" align="right">
            <b>
            <?php echo "$".number_format($tot_charge,2); ?>
            </b>
        </td>
        <td valign="top" align="right">
            <b>
            <?php echo "$".number_format($tot_credit,2);?>
            </b>
        </td>
        <td valign="top" align="right">
            <b>
            <?php echo "$".number_format($tot_adj,2);?>
            </b>
        </td>
    </tr>
    <tr>
        <td valign="top" colspan="5" align="right">
            <b>Balance</b>
        </td>
        <td valign="top" align="right">
            <b>
                <?php echo "$".number_format($tot_charge - $tot_credit - $tot_adj,2); ?>
            </b>
        </td>
        <td valign="top" align="right"> </td>
        <td valign="top"> </td>
    </tr>
</table>

<?php include 'ledger_summary_report.php'; ?>
<br /><br />
</body>
</html>
