<?php 
if(!isset($_GET['print'])){
	include "includes/top.htm";
}else{
//include "includes/top.htm";

	session_start();
	require_once('admin/includes/main_include.php');
	include("includes/sescheck.php");
	require_once('includes/constants.inc');
	require_once('admin/includes/access.php');

?>
<html>
<body>
<?php
}

$rec_disp = 200;

if($_REQUEST["page"] != "")
	$index_val = $_REQUEST["page"];
else
	$index_val = 0;
	
$i_val = $index_val * $rec_disp;


$sql = "SELECT  "
	 . "  sum(dl.amount) as amount, sum(dl.paid_amount) as paid_amount, "
     . " a.amount as adjusted_amount, "
     . "p.firstname, p.lastname, p.patientid "
     . "FROM dental_ledger dl  "
     . "JOIN dental_patients p ON p.patientid=dl.patientid "
     . " LEFT JOIN dental_transaction_code tc on tc.transaction_code = dl.transaction_code AND tc.docid='".$_SESSION['docid']."' "
     . " LEFT JOIN (SELECT patientid, SUM(paid_amount) amount FROM dental_ledger group by patientid) a ON a.patientid=dl.patientid "
     . "WHERE dl.docid='".$_SESSION['docid']."'  "
     . " AND tc.type!='".mysql_real_escape_string(DSS_TRXN_TYPE_ADJ)."' "
     . "GROUP BY dl.patientid";
$my = $db->getResults($sql);
/*
$sql .= " order by service_date";

$total_rec = mysql_num_rows($my);
$no_pages = $total_rec/$rec_disp;
*/

$num_users = count($my);

//echo $sql; 
?>

<link rel="stylesheet" href="admin/popup/popup.css" type="text/css" media="screen" />
<link rel="stylesheet" href="css/manage.css" type="text/css" media="screen" />
<script src="admin/popup/popup.js" type="text/javascript"></script>

<span class="admin_head">
	Unpaid Patient Report
   (<i><?php echo date('m/d/Y'); ?></i>)
</span>
<div align="right">
	<button onclick="Javascript:window.location='ledger_reportfull.php';" class="addButton">
       Daily Ledger
    </button>
	&nbsp;&nbsp;
	<button onclick="window.location='unpaid_patient.php?print';" class="addButton">
		Print
	</button>
    &nbsp;&nbsp;
</div>
<br />
<br />
<div align="center" class="red">
	<b><?php echo $_GET['msg'];?></b>
</div>
<table width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center" >
	<?php if($total_rec > $rec_disp) {?>
	<TR bgColor="#ffffff">
		<TD  align="right" colspan="15" class="bp">
			Pages:
			<?php paging($no_pages,$index_val,""); ?>
		</TD>        
	</TR>
	<?php }?>
	<tr class="tr_bg_h">
		<td valign="top" class="col_head">
			Patient
		</td>
		<td valign="top" class="col_head" width="10%">
			Current	
		</td>	
		<td valign="top" class="col_head" width="10%">
			30 Days
		</td>	
		<td valign="top" class="col_head" width="10%">
			60 Days	
		</td>	
		<td valign="top" class="col_head" width="10%">
			90 Days	
		</td>	
		<td valign="top" class="col_head" width="10%">
			Charges
		</td>
		<td valign="top" class="col_head">
			Credits
		</td>
		<td valign="top" class="col_head">
			Adjustments	
		</td>
		<td valign="top" class="col_head">
			Pt. Balance	
		</td>
	</tr>
	<?php if($num_users == 0){ ?>
	<tr class="tr_bg">
		<td valign="top" class="col_head" colspan="10" align="center">
			No Records
		</td>
	</tr>
	<?php 
	} else {
		$tot_charges = 0;
		$tot_credit = 0;
		$tot_adjusted = 0;
		$charges_cur = 0;
		$charges_30 = 0;
		$charges_60 = 0;
		$charges_90 = 0;
		foreach ($my as $myarray) {
			$pay_sql = "SELECT  "
	                 . "  sum(pay.amount) as paid_amount "
				     . "FROM dental_ledger dl  "
				     . "JOIN dental_patients p ON p.patientid=dl.patientid "
				     . "LEFT JOIN dental_ledger_payment pay on pay.ledgerid = dl.ledgerid  "
				     . "WHERE dl.docid='".$_SESSION['docid']."' "
				     . "AND p.patientid='".$myarray['patientid']."' "
				     . "GROUP BY dl.patientid";

			$pay_r = $db->getRow($pay_sql);
			$paid_amount = $myarray['paid_amount']+$pay_r['paid_amount'];
			if(round($myarray['amount'],2)!=round($paid_amount,2)){
				$pat_sql = "select * from dental_patients where patientid='".$myarray['patientid']."'";
				$pat_myarray = $db->getRow($pat_sql);
				
				$name = st($pat_myarray['lastname'])." ".st($pat_myarray['middlename'])." ".st($pat_myarray['firstname']);
				
				if($myarray["status"] == 1){
					$tr_class = "tr_active";
				} else {
					$tr_class = "tr_inactive";
				}
				$tr_class = "tr_active";?>
	<tr class="<?php echo $tr_class;?>">
		<td valign="top">
			<a href="manage_ledger.php?addtopat=1&pid=<?php echo $myarray['patientid'];?>"><?php echo st($myarray['lastname'].", ".$myarray['firstname']);?> (Click to View)</a>
		</td>
		<td valign="top" width="18%">
			<a href="manage_ledger.php?addtopat=1&pid=<?php echo $myarray['patientid'];?>"><?php echo st($myarray['lastname'].", ".$myarray['firstname']);?></a>
		</td>
		<td>
<?php 
				$seg_sql = "SELECT "
					     . "  sum(dl.amount) as amount, sum(dl.paid_amount) as paid_amount, "
					     . "p.firstname, p.lastname, p.patientid "
					     . "FROM dental_ledger dl  "
					     . "JOIN dental_patients p ON p.patientid=dl.patientid "
					     . "WHERE dl.docid='".$_SESSION['docid']."'  "
					     . "AND p.patientid='".$myarray['patientid']."' "
					     . "AND dl.service_date > DATE_SUB(NOW(), INTERVAL 30 day) "
					     . "GROUP BY dl.patientid";
				$seq_r = $db->getRow($seg_sql);
				echo "$".number_format($seq_r['amount'],2);
				$charges_cur += $seq_r['amount'];?>
		</td>
		<td>
<?php 
				$seg_sql = "SELECT "
		                 . "  sum(dl.amount) as amount, sum(dl.paid_amount) as paid_amount, "
					     . "p.firstname, p.lastname, p.patientid "
					     . "FROM dental_ledger dl  "
					     . "JOIN dental_patients p ON p.patientid=dl.patientid "
					     . "WHERE dl.docid='".$_SESSION['docid']."'  "
					     . "AND p.patientid='".$myarray['patientid']."' "
					     . "AND dl.service_date <= DATE_SUB(NOW(), INTERVAL 30 day) "
					     . "AND dl.service_date > DATE_SUB(NOW(), INTERVAL 60 day) "
					     . "GROUP BY dl.patientid";
                $seq_r = $db->getRow($seg_sql);
                echo "$".number_format($seq_r['amount'],2);
				$charges_30 += $seq_r['amount'];?>
		</td>
		<td>
<?php 
				$seg_sql = "SELECT "
					     . "  sum(dl.amount) as amount, sum(dl.paid_amount) as paid_amount, "
					     . "p.firstname, p.lastname, p.patientid "
					     . "FROM dental_ledger dl  "
					     . "JOIN dental_patients p ON p.patientid=dl.patientid "
					     . "WHERE dl.docid='".$_SESSION['docid']."'  "
					     . "AND p.patientid='".$myarray['patientid']."' "
					     . "AND dl.service_date <= DATE_SUB(NOW(), INTERVAL 60 day) "
					     . "AND dl.service_date > DATE_SUB(NOW(), INTERVAL 90 day) "
					     . "GROUP BY dl.patientid";
                $seq_r = $db->getRow($seg_sql);
                echo "$".number_format($seq_r['amount'],2);
				$charges_60 += $seq_r['amount'];?>	
		</td>
		<td>
<?php 
				$seg_sql = "SELECT "
					     . "  sum(dl.amount) as amount, sum(dl.paid_amount) as paid_amount, "
					     . "p.firstname, p.lastname, p.patientid "
					     . "FROM dental_ledger dl  "
					     . "JOIN dental_patients p ON p.patientid=dl.patientid "
					     . "WHERE dl.docid='".$_SESSION['docid']."'  "
					     . "AND p.patientid='".$myarray['patientid']."' "
					     . "AND dl.service_date < DATE_SUB(NOW(), INTERVAL 90 day) "
					     . "GROUP BY dl.patientid";
                $seq_r = $db->getRow($seg_sql);
                echo "$".number_format($seq_r['amount'],2);
				$charges_90 += $seq_r['amount'];?>	
		</td>
		<td valign="top" align="right" width="18%">
<?php
				echo "$".number_format($myarray["amount"],2);
				$tot_charges += $myarray["amount"];?>
			&nbsp;
		</td>
		<td valign="top" align="right">
<?php 
				if(st($paid_amount) <> 0) {
					echo number_format(st($paid_amount),2);
					$tot_credit += st($paid_amount);
				}?>
			&nbsp;
		</td>
		<td valign="top" align="right">
<?php 
				if(st($myarray['adjusted_amount']) <> 0) {
					echo number_format(st($myarray['adjusted_amount']),2);
					$tot_adjusted += st($myarray['adjusted_amount']);
				}?>
		</td>
		<td valign="top">
			&nbsp;
<?php 
				if($myarray["amount"]>$paid_amount){
					echo number_format(($myarray["amount"]-$paid_amount),2);
				}elseif($myarray["amount"]<$paid_amount){ ?>
			<span style="color:#070;">(<?php echo number_format((abs($myarray["amount"]-$paid_amount-$myarray['adjusted_amount'])),2); ?>)</span>
<?php 
				}?>
		</td>
	</tr>
	<?php 	} 
		} 
	}?>  
	<tr>
		<td valign="top" align="right">
			<b>Totals</b>
		</td>
        <td valign="top" align="right">
            <b>
				<?php echo "$".number_format($charges_cur,2); ?>
	            &nbsp;
            </b>
        </td>
		<td valign="top" align="right">
			<b>
				<?php echo "$".number_format($charges_30,2);?>
	            &nbsp;
            </b>
        </td>
		<td valign="top" align="right">
			<b>
				<?php echo "$".number_format($charges_60,2); ?>
	            &nbsp;
            </b>
        </td>
		<td valign="top" align="right">
			<b>
				<?php echo "$".number_format($charges_90,2);?>
	            &nbsp;
            </b>
        </td>
		<td valign="top" align="right">     
			<b>
				<?php echo "$".number_format($tot_charges,2); ?>
				&nbsp;
			</b>
		</td>
		<td valign="top" align="right">
			<b>
				<?php echo "$".number_format($tot_credit,2);?>
				&nbsp;
			</b>
		</td>
		<td valign="top" align="right">
			<b>
				<?php echo "$".number_format($tot_adjusted,2);?>
				&nbsp;
			</b>
		</td>
		<td valign="top">
			&nbsp;
		</td>
	</tr>
    <tr>
        <td valign="top" colspan="7" align="right">
            <b>Balance</b>
        </td>
        <td align="right">
            <b>
                <?php echo "$".number_format(($tot_charges - $tot_credit - $tot_adjusted),2);?>
                &nbsp;
            </b>
        </td>
        <td colspan="2">
        </td>
    </tr>
</table>

<div id="popupContact" style="width:750px;">
    <a id="popupContactClose"><button>X</button></a>
    <iframe id="aj_pop" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
</div>
<div id="backgroundPopup"></div>

<br /><br />	
<?php if(!isset($_GET['print'])){
	include "includes/bottom.htm";
} ?>
