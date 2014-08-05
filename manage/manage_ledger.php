<?php
include "includes/top.htm";
require_once('includes/dental_patient_summary.php');
require_once('includes/patient_info.php');
if ($patient_info) {

$sql = "SELECT  "
		 . "  dl.amount, sum(pay.amount) as paid_amount "
     . "FROM dental_ledger dl  "
     . "LEFT JOIN dental_ledger_payment pay on pay.ledgerid = dl.ledgerid  "
     . "WHERE dl.docid='".$_SESSION['docid']."' AND dl.patientid='".s_for($_GET['pid'])."'  "
     . "GROUP BY dl.ledgerid";
$result = mysql_query($sql);
$ledger_balance = 0;
while ($row = mysql_fetch_array($result)) {
  $ledger_balance -= $row['amount'];
  $ledger_balance += $row['paid_amount'];
}
update_patient_summary($_GET['pid'], 'ledger', $ledger_balance);

?>
<link rel="stylesheet" href="css/ledger.css" />
<?php
if(!isset($_GET['sort'])){
  $_GET['sort'] = 'service_date';
  $_GET['sortdir'] = 'desc';
}

if($_REQUEST["delid"] != "")
{
  $pat_sql2 = "select * from dental_patients where patientid='".s_for($_GET['pid'])."'";
  $pat_my2 = mysql_query($pat_sql2);
  while($pat_myarray2 = mysql_fetch_array($pat_my2)){ 
  
  $pat_sql3 = mysql_query("INSERT INTO dental_ledger_rec (userid, patientid, service_date, description, amount, paid_amount,transaction_code, ip_address, transaction_type) VALUES ('".$_SESSION['username']."','".$_GET['pid']."','".$pat_myarray2['service_date']."','".$pat_myarray2['description']."','".$pat_myarray2['amount']."','".$pat_myarray2['paid_amount']."','".$pat_myarray2['transaction_code']."','".$pat_myarray2['ip_address']."','".$pat_myarray2['transaction_type']."');");
  if(!$pat_sql3){
   echo "There was an error updating the ledger record.  Please contact your system administrator.";
  }
  
  }  
  
	$del_sql = "delete from dental_ledger where ledgerid='".$_REQUEST["delid"]."'";
	mysql_query($del_sql);
	
	$msg= "Deleted Successfully";
	?>
	<script type="text/javascript">
		//alert("Deleted Successfully");
                <?php if($_GET['popup']==1){ ?>
                  parent.window.location.reload();
                <?php }else{ ?>
		  window.location="<?=$_SERVER['PHP_SELF']?>?msg=<?=$msg?>&pid=<?=$_GET['pid'];?>";
                <?php } ?>
	</script>
	<?
	die();
}
if(isset($_REQUEST["delstatementid"]) && $_REQUEST["delstatementid"] != "")
{
  $sql = "DELETE FROM dental_ledger_statement WHERE id='".mysql_real_escape_string($_REQUEST['delstatementid'])."' AND patientid='".mysql_real_escape_string($_REQUEST['pid'])."'";
  mysql_query($sql);
	  $msg = "Deleted Successfully";
          ?>
        <script type="text/javascript">
                  window.location="<?=$_SERVER['PHP_SELF']?>?msg=<?=$msg?>&pid=<?=$_GET['pid'];?>";
        </script>
        <?
        die();
}
if($_REQUEST["delclaimid"] != "")
{
	$sql = "SELECT * FROM dental_insurance where insuranceid='".$_REQUEST["delclaimid"]."' AND status = ".DSS_CLAIM_PENDING;
	$q = mysql_query($sql);
	if(mysql_num_rows($q)>0){
         $del_sql = "delete from dental_insurance where insuranceid='".$_REQUEST["delclaimid"]."' AND status = ".DSS_CLAIM_PENDING;
         if(mysql_query($del_sql)){

	  $up_sql = "UPDATE dental_ledger set primary_claim_id=NULL, status='".DSS_TRXN_NA."' WHERE primary_claim_id='".$_REQUEST["delclaimid"]."'";
          mysql_query($up_sql);

          $msg= "Deleted Successfully";
         }else{
          $msg = "Error deleting.";
         }
	}
        ?>
        <script type="text/javascript">
                //alert("Deleted Successfully");
                <?php if($_GET['popup']==1){ ?>
                  parent.window.location.reload();
                <?php }else{ ?>
                  window.location="<?=$_SERVER['PHP_SELF']?>?msg=<?=$msg?>&pid=<?=$_GET['pid'];?>";
                <?php } ?>
        </script>
        <?
        die();
	
}

if($_REQUEST["delnoteid"] != "")
{

	$sql = "DELETE FROM dental_ledger_note WHERE id='".mysql_real_escape_string($_REQUEST['delnoteid'])."' AND patientid='".mysql_real_escape_string($_REQUEST['pid'])."'";
        $q = mysql_query($sql);
         if($q){

          $msg= "Deleted Successfully";
         }else{
          $msg = "Error deleting.";
        }
        ?>
        <script type="text/javascript">
                //alert("Deleted Successfully");
                <?php if($_GET['popup']==1){ ?>
                  parent.window.location.reload();
                <?php }else{ ?>
                  window.location="<?=$_SERVER['PHP_SELF']?>?msg=<?=$msg?>&pid=<?=$_GET['pid'];?>";
                <?php } ?>
        </script>
        <?
        die();

}


$pat_sql = "select * from dental_patients where patientid='".s_for($_GET['pid'])."'";
$pat_my = mysql_query($pat_sql);
$pat_myarray = mysql_fetch_array($pat_my); 

$name = st($pat_myarray['lastname'])." ".st($pat_myarray['middlename'])." ".st($pat_myarray['firstname']);

if($pat_myarray['patientid'] == '')
{
	?>
	<script type="text/javascript">
		window.location = 'manage_patient.php';
	</script>
	<?
	die();
}

$rec_disp = 2000;

if($_REQUEST["page"] != "")
	$index_val = $_REQUEST["page"];
else
	$index_val = 0;
	
$i_val = $index_val * $rec_disp;
if($_GET['openclaims']==1){
$sql = "        select
                'claim',
                i.insuranceid as ledgerid,
                i.adddate as service_date,
                i.adddate as entry_date,
                'Claim' as name,
                'Insurance Claim' as description,
                (select sum(dl2.amount) FROM dental_ledger dl2
                                INNER JOIN dental_insurance i2 on dl2.primary_claim_id=i2.insuranceid
                                where i2.insuranceid=i.insuranceid) as amount,
                sum(pay.amount) as paid_amount,
                i.status,
                i.insuranceid as primary_claim_id
        from dental_insurance i
                LEFT JOIN dental_ledger dl ON dl.primary_claim_id=i.insuranceid
                LEFT JOIN dental_ledger_payment pay on dl.ledgerid=pay.ledgerid
                where i.patientid='".s_for($_GET['pid'])."'
		AND i.status NOT IN (".DSS_CLAIM_PAID_INSURANCE.", ".DSS_CLAIM_PAID_SEC_INSURANCE.", ".DSS_CLAIM_PAID_PATIENT.")
        GROUP BY i.insuranceid
";



}else{

$sql = "select 
                'ledger',
		dl.ledgerid,
		dl.service_date,
            	dl.entry_date,
		CONCAT(p.first_name,' ',p.last_name) as name,
 		dl.description,
		dl.amount,
		'' as paid_amount,
		di.status,
		dl.primary_claim_id,
		'' as payer,
		'' as payment_type,
		di.status as claim_status,
		'' as filename,
                '' as num_notes,
                '' as num_fo_notes
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
                CONCAT(p.first_name,' ',p.last_name),
                '',
                '',
                dlp.amount,
                '',
                dl.primary_claim_id,
		dlp.payer,
		dlp.payment_type,
		'',
		'',
                '',
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
                CONCAT(p.first_name,' ',p.last_name),
                dl.description,
                dl.amount,
                dl.paid_amount,
                dl.status,
                dl.primary_claim_id,
		tc.type,
		'',
		'',
                '',
                '',
                ''	
        from dental_ledger dl 
                LEFT JOIN dental_users p ON dl.producerid=p.userid 
                LEFT JOIN dental_ledger_payment pay on pay.ledgerid=dl.ledgerid
		LEFT JOIN dental_transaction_code tc on tc.transaction_code = dl.transaction_code AND tc.docid='".$_SESSION['docid']."'
                        where dl.docid='".$_SESSION['docid']."' and dl.patientid='".s_for($_GET['pid'])."' 
			AND (dl.paid_amount IS NOT NULL AND dl.paid_amount != 0)
  UNION
   	select 
		'note',
		n.id,
		n.service_date,
		n.entry_date,
		concat('Note - ', p.first_name,' ',p.last_name),
		n.note,
		'',
		'',
	 	n.private,
		'',
		'',
		'',
		'',
                '',
                '',
                ''	
	from dental_ledger_note n
		JOIN dental_users p on n.producerid=p.userid
			where n.patientid='".s_for($_GET['pid'])."'       
  UNION
        select 
                'statement',
                s.id,
                s.service_date,
                s.entry_date,
		CONCAT(p.first_name,' ',p.last_name),
                'Ledger statement created (Click to view)',
		'',               
                '',
                '',
                '',
                '',
                '',
                '',
		s.filename,
                '',
                ''
        from dental_ledger_statement s
                JOIN dental_users p on s.producerid=p.userid
                        where s.patientid='".s_for($_GET['pid'])."'
  UNION
        select 
                'note',
                n.id,
                n.service_date,
                n.entry_date,
                concat('Note - Backoffice ID - ', p.adminid),
                n.note,
                '',
                '',
                n.private,
                '',
                '',
                '',
                '',
                '',
		'',
		''      
        from dental_ledger_note n
                JOIN admin p on n.admin_producerid=p.adminid
                        where n.patientid='".s_for($_GET['pid'])."'       

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
		'',
                '',
     		(SELECT count(*) FROM dental_claim_notes where claim_id=i.insuranceid), 
     		(SELECT count(*) FROM dental_claim_notes where claim_id=i.insuranceid AND create_type='1') 
	from dental_insurance i
		LEFT JOIN dental_ledger dl ON dl.primary_claim_id=i.insuranceid
		LEFT JOIN dental_ledger_payment pay on dl.ledgerid=pay.ledgerid
		where i.patientid='".s_for($_GET['pid'])."'
	GROUP BY i.insuranceid

";
}
if(isset($_REQUEST['sort'])){
  if($_REQUEST['sort']=='producer'){
    $sql .= " ORDER BY name ".$_REQUEST['sortdir']; 
  }else{
    $sql .= " ORDER BY ".$_REQUEST['sort']." ".$_REQUEST['sortdir'];
  }
}

$my = mysql_query($sql);
$total_rec = mysql_num_rows($my);
$no_pages = $total_rec/$rec_disp;

$sql .= " limit ".$i_val.",".$rec_disp;
$my=mysql_query($sql) or die(mysql_error());
$num_users=mysql_num_rows($my);

?>
<!--
<link rel="stylesheet" href="admin/popup/popup.css" type="text/css" media="screen" />
<script src="admin/popup/popup.js" type="text/javascript"></script>
-->
<span class="admin_head">
	Ledger Card
</span>

&nbsp;&nbsp;&nbsp;
<?=$name;?>
<? if(st($pat_myarray['add1']) <> '') {?>
	<br />
	&nbsp;&nbsp;&nbsp;
	<?=st($pat_myarray['add1']);?>	
<? }?>

<? if(st($pat_myarray['add2']) <> '') {?>
	<br />
	&nbsp;&nbsp;&nbsp;
	<?=st($pat_myarray['add2']);?>	
<? }?>

&nbsp;&nbsp;&nbsp;
<?=st($pat_myarray['city']);?>	

&nbsp;&nbsp;&nbsp;
<?=st($pat_myarray['state']);?>	

&nbsp;&nbsp;&nbsp;
<?=st($pat_myarray['zip']);?>	

<br />
&nbsp;&nbsp;&nbsp;
D: <?=st($pat_myarray['work_phone']);?>

&nbsp;&nbsp;&nbsp;
H: <?=st($pat_myarray['home_phone']);?>

<br />
&nbsp;&nbsp;&nbsp;
W1: <?=st($pat_myarray['cell_phone']);?>



<br />

<script type="text/javascript">
function concat_checked(ids){
var s = '';
var first = true;
for(var i = 0; i < ids.length; i++){
if(ids[i].checked) {
if(first){
first=false;
}else{
s+=',';
}
s += ids[i].value;
}
}
return s;
}

</script>
<div align="right">
<? if($_GET['openclaims']==1){
?>
<button onclick="Javascript: window.location='manage_ledger.php?<?= 'pid='.$_GET['pid'];?>';" class="addButton">
               View All 
        </button>
<?php
}else{
?>
<button onclick="Javascript: window.location='manage_ledger.php?openclaims=1&<?= 'pid='.$_GET['pid'];?>';" class="addButton">
               Claims Outstanding 
        </button>
<?php } ?>	&nbsp;&nbsp;
        <button onclick="Javascript: window.open('print_ledger_report.php?<?= (isset($_GET['pid']))?'pid='.$_GET['pid']:'';?>')" class="addButton">
                Print Ledger
        </button>
&nbsp;&nbsp;
	
	<button onclick="Javascript: loadPopup('add_ledger_entry.php?pid=<?=$_GET['pid'];?>');" class="addButton">
		Add New Transaction
	</button>
	&nbsp;&nbsp;
        <button onclick="Javascript: loadPopup('add_ledger_note.php?pid=<?=$_GET['pid'];?>');" class="addButton">
                Add Note 
        </button>
        &nbsp;&nbsp;
        <button onclick="Javascript: window.open('ledger_statement.php?pid=<?=$_GET['pid'];?>')" class="addButton">
               Create Statement 
        </button>
        &nbsp;&nbsp;


</div>

<br />
<div align="center" class="red">
	<b><? echo $_GET['msg'];?></b>
</div>

<form name="edit_mult_form" id="edit_mult_form" />
<table  class="ledger" width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center" >
	<? if($total_rec > $rec_disp) {?>
	<TR bgColor="#ffffff">
		<TD  align="right" colspan="15" class="bp">
			Pages:
			<?
				 paging($no_pages,$index_val,"");
			?>
		</TD>        
	</TR>
	<? }?>
	<tr class="tr_bg_h">
		<td valign="top" class="col_head  <?= ($_REQUEST['sort'] == 'service_date')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>" width="10%">
			<a href="manage_ledger.php?pid=<?= $_GET['pid'] ?>&sort=service_date&sortdir=<?php echo ($_REQUEST['sort']=='service_date'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Svc Date</a>
		</td>
		<td valign="top" class="col_head <?= ($_REQUEST['sort'] == 'entry_date')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>" width="10%">
			<a href="manage_ledger.php?pid=<?= $_GET['pid'] ?>&sort=entry_date&sortdir=<?php echo ($_REQUEST['sort']=='entry_date'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Entry Date</a>
		</td>
                <td valign="top" class="col_head  <?= ($_REQUEST['sort'] == 'producer')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>" width="30%">
                        <a href="manage_ledger.php?pid=<?= $_GET['pid'] ?>&sort=producer&sortdir=<?php echo ($_REQUEST['sort']=='producer'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Producer</a>
                </td>

		<td valign="top" class="col_head  <?= ($_REQUEST['sort'] == 'description')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>" width="30%">
			<a href="manage_ledger.php?pid=<?= $_GET['pid'] ?>&sort=description&sortdir=<?php echo ($_REQUEST['sort']=='description'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Description</a>
		</td>
		<td valign="top" class="col_head <?= ($_REQUEST['sort'] == 'amount')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>" width="10%">
			<a href="manage_ledger.php?pid=<?= $_GET['pid'] ?>&sort=amount&sortdir=<?php echo ($_REQUEST['sort']=='amount'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Charges</a>
		</td>
		<td valign="top" class="col_head <?= ($_REQUEST['sort'] == 'paid_amount')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>" width="10%">
			<a href="manage_ledger.php?pid=<?= $_GET['pid'] ?>&sort=paid_amount&sortdir=<?php echo ($_REQUEST['sort']=='paid_amount'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Credits</a>
		</td>
                <td valign="top" class="col_head <?= ($_REQUEST['sort'] == 'paid_amount')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>" width="10%">
                      <a href="manage_ledger.php?pid=<?= $_GET['pid'] ?>&sort=paid_amount&sortdir=<?php echo ($_REQUEST['sort']=='paid_amount'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Adjustments</a>
                </td>
		<td valign="top" class="col_head" width="10%">
			Balance
		</td>
		<td valign="top" class="col_head <?= ($_REQUEST['sort'] == 'status')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>" width="5%">
			<a href="manage_ledger.php?pid=<?= $_GET['pid'] ?>&sort=status&sortdir=<?php echo ($_REQUEST['sort']=='status'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Ins</a>
		</td>
		
		<td valign="top" class="col_head" width="20%">
			History
		</td>
		<td valign="top" class="col_head" width="20%">
			Action
		</td>
	</tr>

	<? if(mysql_num_rows($my) == 0)
	{ ?>
		<tr class="tr_bg">
			<td valign="top" class="col_head" colspan="10" align="center">
				No Records
			</td>
		</tr>
	<? 
	}
	else
	{

		if($_GET['sortdir']=='DESC'){
		  $cur_bal = $cur_cha = $cur_pay = $cur_adj = 0;
		  $my2 = mysql_query($sql);
		  while($myarray = mysql_fetch_array($my2)){
                                               if($myarray[0]!='claim'){
                                                $cur_bal += st($myarray["amount"]);
                                                }
                                                if($myarray[0]!='claim'){
                                                $cur_bal -= st($myarray["paid_amount"]);
                                                }
 			$orig_bal = $cur_bal;

		  }
		  
		}else{
		  $cur_bal = $cur_cha = $cur_pay = $cur_adj = 0;
		}
		$last_sd = '';
		$last_ed = '';
		while($myarray = mysql_fetch_array($my))
		{
			if($myarray["status"] == 1)
			{
				$tr_class = "tr_active";
			}
			else
			{
				$tr_class = "tr_inactive";
			}
			$tr_class = "tr_active";
                        if($myarray[0] == 'claim'){ $tr_class .= ' clickable_row status_'.$myarray['status']; }
			if($myarray[0] == 'ledger' && $myarray['primary_claim_id']!='' && $myarray['primary_claim_id']!='0'){ $tr_class .= ' claimed'; }
			if($myarray[0] == 'ledger' && !$myarray['primary_claim_id'] && $myarray['status'] == DSS_TRXN_PENDING){ $tr_class .= ' claimless clickable_row'; }
			if($myarray[0] == 'statement' && $myarray['filename']!=''){ $tr_class .= ' statement clickable_row'; }
			if($myarray['status'] == 3 || $myarray['status'] == 5 || $myarray['status'] == 9){ $tr_class .= ' completed'; }
		?>
			<tr 
			<?php if($myarray[0]=="claim"){ echo 'onclick="window.location=\'view_claim.php?claimid='.$myarray['ledgerid'].'&pid='.$_GET['pid'].'\'"'; } ?>
			<?php if($myarray['filename']!=""){ echo 'onclick="window.location=\''.$myarray['filename'].'\'"'; } ?>
			class="<?=$tr_class;?> <?= $myarray[0]; ?>">
				<td valign="top"
				<?php if($myarray[0]=='ledger' && !$myarray['primary_claim_id'] && $myarray['status'] == DSS_TRXN_PENDING){ echo 'onclick="window.location=\'manage_insurance.php?pid='.$_GET['pid'].'&addtopat=1\'"'; } ?>
				>
					<?php if($myarray["service_date"]!=$last_sd){
						$last_sd = $myarray["service_date"];
       					      	echo date('m-d-Y',strtotime(st($myarray["service_date"])));
                                        } ?>
				</td>
				<td valign="top"
                                <?php if($myarray[0]=='ledger' && !$myarray['primary_claim_id'] && $myarray['status'] == DSS_TRXN_PENDING){ echo 'onclick="window.location=\'manage_insurance.php?pid='.$_GET['pid'].'&addtopat=1\'"'; } ?>
                                >
					<?php if($myarray["entry_date"]!=$last_ed){
                                                $last_ed = $myarray["entry_date"];
                                                echo date('m-d-Y',strtotime(st($myarray["entry_date"])));
                                        } ?>
				</td>
                                <td valign="top"
                                <?php if($myarray[0]=='ledger' && !$myarray['primary_claim_id'] && $myarray['status'] == DSS_TRXN_PENDING){ echo 'onclick="window.location=\'manage_insurance.php?pid='.$_GET['pid'].'&addtopat=1\'"'; } ?>
                                >
                        <?=st($myarray["name"]);?>
                                </td>

				<td valign="top"
                                <?php if($myarray[0]=='ledger' && !$myarray['primary_claim_id'] && $myarray['status'] == DSS_TRXN_PENDING){ echo 'onclick="window.location=\'manage_insurance.php?pid='.$_GET['pid'].'&addtopat=1\'"'; } ?>
                                >
			<?= ($myarray[0] == 'note' && $myarray['status']==1)?"(P) ":''; ?>
                        <?= (($myarray[0] == 'ledger_paid'))?$dss_trxn_type_labels[$myarray['payer']]." - ":''; ?>
                	<?= $myarray["description"]; ?>
			<?= (($myarray[0] == 'ledger' || $myarray[0] =='claim') && $myarray['primary_claim_id'])?"(".$myarray['primary_claim_id'].") ":''; ?>
			<?= (($myarray[0] =='claim') && $myarray['num_notes'] > 0)?" - Notes (".$myarray['num_notes'].") ":''; ?>
			<?= ($myarray[0]=='ledger' && !$myarray['primary_claim_id'] && $myarray['status'] == DSS_TRXN_PENDING)?' (Click to file)':''; ?>
			<?= (($myarray[0] == 'ledger_payment'))?$dss_trxn_payer_labels[$myarray['payer']]." Payment - ":''; ?>
			<?= (($myarray[0] == 'ledger_payment'))?$dss_trxn_pymt_type_labels[$myarray['payment_type']]." ":''; ?>
			<?= (($myarray[0] == 'ledger_payment') && $myarray['primary_claim_id'])?"(".$myarray['primary_claim_id'].") ":''; ?>
				</td>

				<td valign="top" align="right"
                                <?php if($myarray[0]=='ledger' && !$myarray['primary_claim_id'] && $myarray['status'] == DSS_TRXN_PENDING){ echo 'onclick="window.location=\'manage_insurance.php?pid='.$_GET['pid'].'&addtopat=1\'"'; } ?>
                                >
					<? if(st($myarray["amount"]) <> 0 && $myarray[0]!='claim') {?>
	                	<?=number_format(st($myarray["amount"]),2);?>
					<? 
					 	if($myarray[0]!='claim'){
						if($_GET['sortdir']=='DESC'){
						  $cur_bal -= st($myarray["amount"]);
						}else{
						  $cur_bal += st($myarray["amount"]);
						}
						$cur_cha += st($myarray["amount"]);	
						}
					}?>
					&nbsp;
				</td>
				<?php if($myarray[0] == 'ledger_paid' && $myarray['payer']==DSS_TRXN_TYPE_ADJ){ ?>
				<td></td>
					<?php
                                                if($myarray[0]!='claim'){
                                                if($_GET['sortdir']=='DESC'){
                                                  $cur_bal += st($myarray["paid_amount"]);
                                                }else{
                                                  $cur_bal -= st($myarray["paid_amount"]);
                                                }
                                                $cur_adj += st($myarray["paid_amount"]);
                                                }
					?>
				<?php } ?>
				<td valign="top" align="right"
                                <?php if($myarray[0]=='ledger' && !$myarray['primary_claim_id'] && $myarray['status'] == DSS_TRXN_PENDING){ echo 'onclick="window.location=\'manage_insurance.php?pid='.$_GET['pid'].'&addtopat=1\'"'; } ?>
                                >
					<? if(st($myarray["paid_amount"]) <> 0 && $myarray[0]!='claim') {?>
	                	<?=number_format(st($myarray["paid_amount"]),2);?>
					<? 
					}?>
					&nbsp;
				</td>
                                <?php if(!($myarray[0] == 'ledger_paid' && $myarray['payer']==DSS_TRXN_TYPE_ADJ)){ ?>
						<?php
                                                if($myarray[0]!='claim'){
                                                if($_GET['sortdir']=='DESC'){
                                                  $cur_bal += st($myarray["paid_amount"]);
                                                }else{
                                                  $cur_bal -= st($myarray["paid_amount"]);
                                                }
                                                $cur_pay += st($myarray["paid_amount"]);
                                                }
						?>
                                <td></td>
                                <?php } ?>
				<td valign="top" align="right"
                                <?php if($myarray[0]=='ledger' && !$myarray['primary_claim_id'] && $myarray['status'] == DSS_TRXN_PENDING){ echo 'onclick="window.location=\'manage_insurance.php?pid='.$_GET['pid'].'&addtopat=1\'"'; } ?>
                                >
					<?php if($myarray[0]=='ledger' || $myarray[0] == 'ledger_paid' || $myarray[0] == 'ledger_paid' || $myarray[0] == 'ledger_payment'){
					if($_GET['sort']=='service_date' || $_GET['sort']=='entry_date'){
					 $show_bal = $cur_bal;
					 if($_GET['sortdir']=='DESC'){
					   $show_bal += $myarray['amount']-$myarray['paid_amount'];
					 }
					 echo number_format(st($show_bal),2);
					}else{ ?>
						N/A
                	&nbsp;
				<?php 
					}
					} ?>
				</td>
				<td valign="top"
                                <?php if($myarray[0]=='ledger' && !$myarray['primary_claim_id'] && $myarray['status'] == DSS_TRXN_PENDING){ echo 'onclick="window.location=\'manage_insurance.php?pid='.$_GET['pid'].'&addtopat=1\'"'; } ?>
                                >
          <?php
		if($myarray[0] == 'ledger_paid'){
	          	echo $dss_trxn_status_labels[$myarray["status"]]; 
		}elseif($myarray[0]=='claim' || $myarray[0] == 'ledger'){
			echo $dss_claim_status_labels[$myarray["status"]];
		}
          //if($myarray["status"] == '0'){echo "Pend.";}
          //if($myarray["status"] == '1'){echo "Sent ";}
          //if($myarray["status"] == '2'){echo "Filed";}
          
          ?>       	
				</td>
				<td valign="top">
					<?php if( $myarray[0] == 'ledger' || $myarray[0] == 'ledger_payment'){ ?>
						<a href="#" onclick="$('.history_<?= $myarray['ledgerid']; ?>').toggle();return false;">View</a>
					<?php } ?>
				</td>
				<td valign="top">
                                   <?php if(($myarray[0]=='ledger'&&($myarray['claim_status']!=DSS_CLAIM_SENT&&$myarray['claim_status']!=DSS_CLAIM_SEC_SENT))||$myarray[0] == 'ledger_paid'){ ?>
					<a href="Javascript:;" 
  <?php
    $pla_sql = "SELECT edit_ledger_entries FROM dental_users where userid='".$_SESSION['userid']."'";
    $pla_q = mysql_query($pla_sql);
    $pla = mysql_fetch_assoc($pla_q);
    if($pla['edit_ledger_entries'] != '1' && $_SESSION['docid']!=$_SESSION['userid']){
  ?>
                                                onclick="alert('You do not have permission to edit ledger entries.  Please contact your office manager to resolve this issue.');" 
  <? }else{ ?>
						onclick="Javascript: loadPopup('add_ledger.php?ed=<?=$myarray["ledgerid"];?>&pid=<?=$_GET['pid'];?>');" 
  <?php } ?>
							class="editlink" title="EDIT">
						Edit 
					</a>
 			
                   		<?php if($myarray['primary_claim_id']!=0 && $myarray['primary_claim_id']!=''){ ?> 
                                           <a href="view_claim.php?claimid=<?= $myarray['primary_claim_id']; ?>&pid=<?=$_GET['pid'];?>" class="editlink" title="PAYMENT">
                                                 Pay 
                                        </a>
				<?php }else{ ?>
                                           <a href="Javascript:;" onclick="javascript: loadPopup('add_ledger_payment.php?ed=<?=$myarray["ledgerid"];?>&pid=<?=$_GET['pid'];?>');" class="editlink" title="PAYMENT">
                                                 Pay 
                                        </a>
				<?php } ?>

                                  <?php }elseif($myarray[0]=='note'){ ?>
 
					<a href="Javascript:;" onclick="javascript: loadPopup('edit_ledger_note.php?ed=<?=$myarray["ledgerid"];?>&pid=<?=$_GET['pid'];?>');" class="editlink" title="EDIT">
                                                Edit 
                                        </a>
                                  <?php }elseif($myarray[0]=='claim'){ ?>
					<?php if($myarray['status']!=DSS_CLAIM_SENT && $myarray['status']!=DSS_CLAIM_SEC_SENT && $myarray['status']!=DSS_CLAIM_PAID_INSURANCE && $myarray['status']!=DSS_CLAIM_PAID_PATIENT && $myarray['status']!=DSS_CLAIM_PAID_SEC_INSURANCE ){ ?>
<a href="insurance.php?insid=<?=$myarray["ledgerid"];?>&pid=<?=$_GET['pid'];?>" class="editlink" title="EDIT">
                                                Edit 
                                        </a>
					<?php } ?>
                                    <?php if($myarray['status']==DSS_CLAIM_PENDING){ ?>
                    <a href="<?=$_SERVER['PHP_SELF']?>?delclaimid=<?=$myarray["ledgerid"];?>&pid=<?=$_GET['pid'];?>" onclick="javascript: return confirm('Do Your Really want to Delete?.');" class="dellink" title="DELETE">
                                                 Delete 
                                        </a>
					<?php } ?>
                                   <?php }elseif($myarray[0]=='ledger_payment'){ ?>
                                           <a href="Javascript:;" onclick="javascript: loadPopup('edit_ledger_payment.php?ed=<?=$myarray["ledgerid"];?>&pid=<?=$_GET['pid'];?>');" class="editlink" title="PAYMENT">
                                                 Edit 
                                        </a>

  				<?php }elseif($myarray[0]=='statement'){ ?>
                    <a href="<?=$_SERVER['PHP_SELF']?>?delstatementid=<?=$myarray["ledgerid"];?>&pid=<?=$_GET['pid'];?>" onclick="javascript: return confirm('Do Your Really want to Delete?.');" class="dellink" title="DELETE">
                                                 Delete 
                                        </a>

				<?php } ?>
				</td>
			</tr>
					<?php if( $myarray[0] == 'ledger'){ ?>
			<tr class="history_<?= $myarray['ledgerid']; ?>" style="display:none;">
                                <td>Updated At</td>
                                <td>Service Date</td>
                                <td>Producer</td>
                                <td>Description</td>
                                <td>Charges</td>
                                <td>Credits</td>
                                <td>Update By</td>
                        </tr>

		<?php
			$h_sql = "select 
                'ledger',
                dl.ledgerid,
                dl.service_date,
                dl.entry_date,
                CONCAT(p.first_name,' ',p.last_name) as name,
                dl.description,
                dl.amount,
                di.status,
                dl.primary_claim_id,
                di.status as claim_status,
		dl.updated_at,
		CONCAT(u.first_name,' ',u.last_name) as updated_user,
		CONCAT(a.first_name,' ',a.last_name) as updated_admin
        from dental_ledger_history dl 
                LEFT JOIN dental_users p ON dl.producerid=p.userid 
                LEFT JOIN dental_ledger_payment pay on pay.ledgerid=dl.ledgerid
                LEFT JOIN dental_insurance di on di.insuranceid = dl.primary_claim_id
		LEFT JOIN dental_users u ON u.userid=dl.updated_by_user
		LEFT JOIN admin a ON a.adminid=dl.updated_by_admin
                        where dl.docid='".$_SESSION['docid']."' and dl.patientid='".s_for($_GET['pid'])."' 
                        and (dl.paid_amount IS NULL || dl.paid_amount = 0)
                AND dl.ledgerid = '".mysql_real_escape_string($myarray['ledgerid'])."'
		ORDER BY dl.updated_at ASC
		";
			$h_q = mysql_query($h_sql);
			while($h_r = mysql_fetch_assoc($h_q)){
		?>	
			<tr class="history_<?= $myarray['ledgerid']; ?>" style="display:none;">
				<td><?= $h_r['updated_at']; ?></td>
				<td><?= $h_r['service_date']; ?></td>
				<td><?= $h_r['name']; ?></td>
				<td><?= $h_r['description']; ?></td>
				<td><?= $h_r['amount']; ?></td>
				<td><?= $h_r['paid_amount']; ?></td>
				<td><?= $h_r['updated_user']; ?><?= $h_r['updated_admin']; ?></td>
			</tr>
		<?php } ?>
	<? 	}elseif(($myarray[0] == 'ledger_payment')){ 
			?>
                        <tr class="history_<?= $myarray['ledgerid']; ?>" style="display:none;">
                                <td>Updated At</td>
                                <td>Service Date</td>
                                <td>Producer</td>
                                <td>Description</td>
                                <td>Charges</td>
                                <td>Credits</td>
                                <td>Update By</td>
                        </tr>
			<?php	
			$h_sql = "select 
                'ledger_payment',
                dlp.id,
                dlp.payment_date service_date,
                dlp.entry_date,
                CONCAT(p.first_name,' ',p.last_name) name,
                dlp.amount,
                dl.primary_claim_id,
                dlp.payer,
                dlp.payment_type,
                dlp.updated_at,
                CONCAT(u.first_name,' ',u.last_name) as updated_user,
                CONCAT(a.first_name,' ',a.last_name) as updated_admin
from dental_ledger dl 
                LEFT JOIN dental_users p ON dl.producerid=p.userid 
                JOIN dental_ledger_payment_history dlp on dlp.ledgerid=dl.ledgerid
 LEFT JOIN dental_users u ON u.userid=dlp.updated_by_user
                LEFT JOIN admin a ON a.adminid=dlp.updated_by_admin

                        where dl.docid='".$_SESSION['docid']."' and dl.patientid='".s_for($_GET['pid'])."' 
                        AND dlp.amount != 0
			AND dlp.paymentid='".$myarray['ledgerid']."'
";
                        $h_q = mysql_query($h_sql) or die(mysql_error());
                        while($h_r = mysql_fetch_assoc($h_q)){
                ?>
                        <tr class="history_<?= $myarray['ledgerid']; ?>" style="display:none;">
                                <td><?= $h_r['updated_at']; ?></td>
                                <td><?= $h_r['service_date']; ?></td>
                                <td><?= $h_r['name']; ?></td>
                                <td>
                        <?= $dss_trxn_payer_labels[$myarray['payer']]." Payment - "; ?>
                        <?= $dss_trxn_pymt_type_labels[$myarray['payment_type']]." "; ?>
                        <?= ($myarray['primary_claim_id'])?"(".$myarray['primary_claim_id'].") ":''; ?>

				</td>
                                <td></td>
                                <td><?= $h_r['amount']; ?></td>
                                <td><?= $h_r['updated_user']; ?><?= $h_r['updated_admin']; ?></td>
                        </tr>
                <?php } 

		}
		}
	}?>
<tr class="tr_bg_h" style="color:#fff; font-weight: bold">
<td></td>  
<td></td>
<td></td>
<td style="color:#fff;" >Totals</td>
<td style="color:#fff;">Charges</td>
<td style="color:#fff;">Credits</td>
<td style="color:#fff;">Adjustments</td>
<td style="color:#fff;">Balance</td>
<td></td>
<td></td>
<td></td>
</tr>
<tr class="tr_bg_h" style="color:#fff; font-weight: bold">
<td></td>
<td></td>
<td></td>
<td></td>
<td style="color:#fff;"><?php echo number_format(st($cur_cha),2); ?></td>
<td style="color:#fff;"><?php echo number_format(st($cur_pay),2); ?></td>
<td style="color:#fff;"><?php echo number_format(st($cur_adj),2); ?></td>
<?php if($_GET['sortdir']=='DESC'){ ?>
<td style="color:#fff;"><?php echo number_format(st($orig_bal),2); ?></td>
<?php }else{ ?>
<td style="color:#fff;"><?php echo number_format(st($cur_bal),2); ?></td>
<?php } ?>
<td></td>
<td></td>
<td></td>
</tr>
  <tr>
      <td colspan="8">
          <center><button class="addButton" onclick="Javascript: loadPopup('view_ledger_record.php?pid=<?php echo $_GET['pid']; ?>');return false;">
		View Ledger Records
	</button></center>
      </td>
  </tr> 
</table>
</form> 



<?php include 'ledger_summary.php'; ?>




<div id="popupContact" style="width:750px;">
    <a id="popupContactClose"><button>X</button></a>
    <iframe id="aj_pop" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
</div>
<div id="backgroundPopup"></div>

<br /><br />	

<?php

} else {  // end pt info check
	print "<div style=\"width: 65%; margin: auto;\">Patient Information Incomplete -- Please complete the required fields in Patient Info section to enable this page.</div>";
}

?>

<? include "includes/bottom.htm";?>
