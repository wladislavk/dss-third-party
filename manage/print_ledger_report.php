<?php
//include "includes/top.htm";

session_start();
require_once('admin/includes/main_include.php');
include("includes/sescheck.php");
require_once('includes/constants.inc');
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

$rec_disp = 200;

if(!empty($_REQUEST["page"]))
	$index_val = $_REQUEST["page"];
else
	$index_val = 0;
	
$i_val = $index_val * $rec_disp;

if(isset($_GET['pid'])){
    $sql = "select * from dental_ledger where patientid='".$_GET['pid']."' "; 
}else{
    $sql = "select * from dental_ledger where docid='".$_SESSION['docid']."' ";
}

$sql .= " order by service_date";
$total_rec = $db->getNumberRows($sql);
$no_pages = $total_rec/$rec_disp;

$my = $db->getResults($sql) or die('No Results for print');
$num_users = count($my);
//echo $sql; 
?>

<html>
<body>
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
		<td valign="top" class="col_head" width="10%">
			Charges
		</td>
		<td valign="top" class="col_head" width="10%">
			Credits
		</td>
        <td valign="top" class="col_head" width="10%">
            Adj.
        </td>
		<td valign="top" class="col_head" width="5%">
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
    $tot_charges = 0;
    $tot_credit = 0;
    $tot_adj = 0;
    if(isset($_GET['pid'])){
        $lpsql = " AND dl.patientid = '".$_GET['pid']."'"; 
        $npsql = " AND n.patientid = '".$_GET['pid']."'";   
        $ipsql = " AND i.patientid = '".$_GET['pid']."'";   
    }else{
        $ipsql = $lpsql = $npsql= "";
    }

    if($start_date){
        $l_date = " AND dl.service_date BETWEEN '".$start_date."' AND '".$end_date."'";
        $n_date = " AND n.entry_date BETWEEN '".$start_date."' AND '".$end_date."'";
        $i_date = " AND i.adddate  BETWEEN '".$start_date."' AND '".$end_date."'"; 
        $p_date = " AND dlp.payment_date BETWEEN '".$start_date."' AND '".$end_date."'";
        $newquery .= " AND service_date BETWEEN '".$start_date."' AND '".$end_date."'";
    }else{
        $p_date = $i_date = $n_date = $l_date = '';
    }
/*
$newquery = "select 
                'ledger',
                dl.ledgerid,
                dl.service_date,
                dl.entry_date,
                p.name,
                dl.description,
                dl.amount,
                '' as paid_amount,
                dl.status,
                dl.primary_claim_id,
                '' as payer,
                '' as payment_type,
                di.status as claim_status
        from dental_ledger dl 
                LEFT JOIN dental_users p ON dl.producerid=p.userid 
                LEFT JOIN dental_ledger_payment pay on pay.ledgerid=dl.ledgerid
                LEFT JOIN dental_insurance di on di.insuranceid = dl.primary_claim_id
                        where dl.docid='".$_SESSION['docid']."' and dl.patientid='".s_for($_GET['pid'])."' 
                        and (dl.paid_amount IS NULL || dl.paid_amount = 0)
                GROUP BY dl.ledgerid
 UNION
        select 
                'ledger_payment',
                dlp.id,
                dlp.payment_date,
                dlp.entry_date,
                p.name,
                '',
                '',
                dlp.amount,
                '',
                dl.primary_claim_id,
                dlp.payer,
                dlp.payment_type,
                ''
        from dental_ledger dl 
                LEFT JOIN dental_users p ON dl.producerid=p.userid 
                LEFT JOIN dental_ledger_payment dlp on dlp.ledgerid=dl.ledgerid
                        where dl.docid='".$_SESSION['docid']."' and dl.patientid='".s_for($_GET['pid'])."' 
                        AND dlp.amount != 0
  UNION
        select 
                'ledger_paid',
                dl.ledgerid,
                dl.service_date,
                dl.entry_date,
                p.name,
                dl.description,
                dl.amount,
                dl.paid_amount,
                dl.status,
                dl.primary_claim_id,
                tc.type,
                '',
                ''      
        from dental_ledger dl 
                LEFT JOIN dental_users p ON dl.producerid=p.userid 
                LEFT JOIN dental_ledger_payment pay on pay.ledgerid=dl.ledgerid
                LEFT JOIN dental_transaction_code tc on tc.transaction_code = dl.transaction_code
                        where dl.docid='".$_SESSION['docid']."' and dl.patientid='".s_for($_GET['pid'])."' 
                        AND (dl.paid_amount IS NOT NULL AND dl.paid_amount != 0)
  UNION
        select 
                'note',
                n.id,
                n.service_date,
                n.entry_date,
                concat('Note - ', p.name),
                n.note,
                '',
                '',
                n.private,
                '',
                '',
                '',
                ''      
        from dental_ledger_note n
                LEFT JOIN dental_users p on n.producerid=p.userid
                        where (n.private IS NULL or n.private=0) AND n.patientid='".s_for($_GET['pid'])."'       
  UNION
        select
                'claim',
                i.insuranceid,
                i.adddate,
                i.adddate,
                'Claim',
                'Insurance Claim',
                (select sum(dl2.amount) FROM dental_ledger dl2
                                INNER JOIN dental_insurance i2 on dl2.primary_claim_id=i2.insuranceid
                                where i2.insuranceid=i.insuranceid),
                sum(pay.amount),
                i.status,
                i.insuranceid,
                '',
                '',
                ''
        from dental_insurance i
                LEFT JOIN dental_ledger dl ON dl.primary_claim_id=i.insuranceid
                LEFT JOIN dental_ledger_payment pay on dl.ledgerid=pay.ledgerid
                where i.patientid='".s_for($_GET['pid'])."'
        GROUP BY i.insuranceid
ORDER BY service_date DESC
";


$newqueryid = "select 
                'ledger',
                dl.ledgerid,
                dl.service_date,
                dl.entry_date,
                p.name,
                dl.description,
                dl.amount,
                sum(pay.amount) as paid_amount,
                dl.status,
		dl.patientid,
                dl.primary_claim_id
        from dental_ledger dl 
                LEFT JOIN dental_users p ON dl.producerid=p.userid 
                LEFT JOIN dental_ledger_payment pay on pay.ledgerid=dl.ledgerid
                       where dl.docid='".$_SESSION['docid']."' ".$lpsql." ".$l_date." 
                GROUP BY dl.ledgerid
  UNION
        select 
                'note',
                n.id,
                n.service_date,
                n.entry_date,
                concat('Note - ', p.name),
                n.note,
                '',
                '',
                n.private,
		n.patientid,
                ''      
        from dental_ledger_note n
                LEFT JOIN dental_users p on n.producerid=p.userid
                       where n.docid='".$_SESSION['docid']."' AND (n.private IS NULL or n.private=0) ".$npsql." ".$n_date." 
  UNION
        select
                'claim',
                i.insuranceid,
                i.adddate,
                i.adddate,
                'Claim',
                'Insurance Claim',
                (select sum(dl2.amount) FROM dental_ledger dl2
                                INNER JOIN dental_insurance i2 on dl2.primary_claim_id=i2.insuranceid
                                where i2.insuranceid=i.insuranceid),
                sum(pay.amount),
                i.status,
                i.patientid,
                ''
        from dental_insurance i
                LEFT JOIN dental_ledger dl ON dl.primary_claim_id=i.insuranceid
                LEFT JOIN dental_ledger_payment pay on dl.ledgerid=pay.ledgerid
                      where i.docid='".$_SESSION['docid']."' ".$ipsql." ".$i_date." 
        GROUP BY i.insuranceid
";
*/
    if(isset($_GET['pid'])){
        $newquery = "SELECT * FROM dental_ledger WHERE  docid='".$_SESSION['docid']."' AND `patientid` = '".$_GET['pid']."'";
    }else{
        $newquery = "SELECT * FROM dental_ledger WHERE `docid` = '".$_SESSION['docid']."'";
    }
    if($start_date)
        $newquery .= " AND service_date BETWEEN '".$start_date."' AND '".$end_date."'";

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
    	
    	if($myarray["status"] == 1){
    		$tr_class = "tr_active";
    	}else{
    		$tr_class = "tr_inactive";
    	}
    	$tr_class = "tr_active";?>
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
        <?php echo ((!empty($myarray[0]) && $myarray[0] == 'ledger_paid'))?$dss_trxn_type_labels[$myarray['payer']]." - ":'';
              echo $myarray["description"];
              echo ((!empty($myarray[0]) && $myarray[0] == 'ledger' || !empty($myarray[0]) && $myarray[0] =='claim') && $myarray['primary_claim_id'])?"(".$myarray['primary_claim_id'].") ":'';
              echo ((!empty($myarray[0]) && $myarray[0] == 'ledger_payment'))?$dss_trxn_payer_labels[$myarray['payer']]." Payment - ":'';
              echo ((!empty($myarray[0]) && $myarray[0] == 'ledger_payment'))?$dss_trxn_pymt_type_labels[$myarray['payment_type']]." ":'';
              echo ((!empty($myarray[0]) && $myarray[0] == 'ledger_payment') && $myarray['primary_claim_id'])?"(".$myarray['primary_claim_id'].") ":''; ?>
        </td>
        <td valign="top" align="right" width="10%">
<?php
        if (!isset($tot_charge)) {
            $tot_charge = 0;
        }

        if(!empty($myarray[0]) && $myarray[0]!='claim' && $myarray['amount'] <> 0){
            echo number_format($myarray["amount"],2);
            $tot_charge += $myarray["amount"];
        }?>

        	&nbsp;
    	</td>
<?php 
        if((!empty($myarray[0]) && $myarray[0] == 'ledger' && $myarray['payer']==DSS_TRXN_TYPE_ADJ)){ 
			$tot_adj += st($myarray["paid_amount"]);?>
        <td></td>
<?php 
        } ?>
		<td valign="top" align="right" width="10%">
<?php
        if(!empty($myarray[0]) && $myarray[0]!='claim') {
            if(st($myarray["paid_amount"]) <> 0) {
                echo number_format(st($myarray["paid_amount"]),2); 
			}
		} ?>
    		&nbsp;
		</td>
<?php 
        if(!(!empty($myarray[0]) && $myarray[0] == 'ledger' && $myarray['payer']==DSS_TRXN_TYPE_ADJ)){ 
			$tot_credit += st($myarray["paid_amount"]);?>
        <td></td>
<?php 
        } ?>
		<td valign="top" width="5%">&nbsp;
<?php 
        if(!empty($myarray[0]) && $myarray[0] == 'ledger'){
            echo $dss_trxn_status_labels[$myarray["status"]];
        }elseif(!empty($myarray[0]) && $myarray[0] == 'claim'){
            echo $dss_claim_status_labels[$myarray["status"]];
        }
    }?>       	
		</td>
	</tr>
<?php 	
}?> 

    <tr>
    	<td valign="top" colspan="5" align="right">
    		<b>Total</b>
    	</td>
    	<td valign="top" align="right">
<?php
if(isset($_GET['pid'])){
    $ledgerquery = "SELECT * FROM dental_ledger WHERE `patientid` =".$_GET['pid']." AND `transaction_type` = 'Charge'";
}else{
    $ledgerquery = "SELECT * FROM dental_ledger WHERE `docid` =".$_SESSION['docid']." AND `transaction_type` = 'Charge'";
}
$myarray = $db->getRow($ledgerquery);

if(isset($_GET['pid'])){
    $ledgerquery2 = "SELECT * FROM dental_ledger WHERE `patientid` =".$_GET['pid']." and `transaction_type`='Credit'";
}else{
    $ledgerquery2 = "SELECT * FROM dental_ledger WHERE `docid` =".$_SESSION['docid']." and `transaction_type`='Credit'";
}
$myarray2 = $db->getRow($ledgerquery2);

if (!isset($cur_bal)) {
    $cur_bal = 0;
}

if(st($myarray["amount"]) <> 0) {
    $cur_bal += st($myarray["amount"]);
}

if(!empty($ledgerres2)){
    $cur_bal2 = $myarray2['paid_amount'];
}

if (!isset($cur_bal2)) {
    $cur_bal2 = 0;
}

$cur_balfinal = $cur_bal - $cur_bal2;?>

            <b>
            <?php echo "$".number_format($tot_charge,2); ?>
            &nbsp;
            </b>
        </td>
        <td valign="top">
            <b>
            <?php echo "$".number_format($tot_credit,2);?>
            &nbsp;
            </b>
        </td>
        <td valign="top">&nbsp;
            <b>
            <?php echo "$".number_format($tot_adj,2);?>
            &nbsp;
            </b>	
        </td>
    </tr>
</table>

<?php include 'ledger_summary_report.php'; ?>
</div>
<br /><br />	
</body>
</html>
