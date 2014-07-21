<html>
<body>
<?
//include "includes/top.htm";

session_start();
require_once('admin/includes/main_include.php');
include("includes/sescheck.php");
require_once('includes/constants.inc');
?><link rel="stylesheet" href="css/ledger.css" /><?php
if($_REQUEST['dailysub'] != 1 && $_REQUEST['monthlysub'] != 1 && $_REQUEST['weeklysub'] != 1 && $_REQUEST['rangesub'] != 1 && $_GET['pid'] == '')
{?>
	<script type="text/javascript">
		window.location = 'ledger.php';
	</script>
	<?
	die();
}

if(!isset($_REQUEST['sort'])){
  $_REQUEST['sort'] = 'service_date';
  $_REQUEST['sortdir'] = 'asc';
}

if(isset($_REQUEST['start_date']) && isset($_REQUEST['end_date'])){
  $start_date = $_REQUEST['start_date'];
  $end_date = $_REQUEST['end_date'];
}elseif($_REQUEST['dailysub']){
  $start_date = date('Y-m-d', mktime(0, 0, 0, $_REQUEST['d_mm'], $_REQUEST['d_dd'], $_REQUEST['d_yy'])); 
  $end_date = date('Y-m-d', mktime(0, 0, 0, $_REQUEST['d_mm'], $_REQUEST['d_dd'], $_REQUEST['d_yy']));
}elseif($_REQUEST['weeklysub']){
  $start_date = date('Y-m-d', mktime(0, 0, 0, $_REQUEST['d_mm'], $_REQUEST['d_dd'], $_REQUEST['d_yy']));
  $end_date = date('Y-m-d', mktime(0, 0, 0, $_REQUEST['d_mm'], $_REQUEST['d_dd']+6, $_REQUEST['d_yy']));
}elseif($_REQUEST['monthlysub']){
  $start_date = date('Y-m-01', mktime(0, 0, 0, $_REQUEST['d_mm'], 1, $_REQUEST['d_yy']));
  $end_date = date('Y-m-t', mktime(0, 0, 0, $_REQUEST['d_mm'], 1, $_REQUEST['d_yy']));
}elseif($_REQUEST['rangesub']){
  $start_date = date('Y-m-d', mktime(0, 0, 0, $_REQUEST['s_d_mm'], $_REQUEST['s_d_dd'], $_REQUEST['s_d_yy']));
  $end_date = date('Y-m-d', mktime(0, 0, 0, $_REQUEST['e_d_mm'], $_REQUEST['e_d_dd'], $_REQUEST['e_d_yy']));
}else{
  $start_date = false;
  $end_date = false;
}

$rec_disp = 200;

if($_REQUEST["page"] != "")
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
$my = mysql_query($sql);
$total_rec = mysql_num_rows($my);
$no_pages = $total_rec/$rec_disp;

$sql .= " limit ".$i_val.",".$rec_disp.";";
$my=mysql_query($sql) or die(mysql_error());
$num_users=mysql_num_rows($my);

//echo $sql; 
?>


<span class="admin_head">
	Ledger Report
        <? if($_REQUEST['dailysub'] == 1)
        {?>
            (<i><?= date('m-d-Y', strtotime($start_date)); ?></i>)
        <? }

        if($_REQUEST['weeklysub'] == 1 || $_REQUEST['rangesub'] == 1)
        {?>
            (<i><?= date('m-d-Y', strtotime($start_date))?> - <?= date('m-d-Y', strtotime($end_date))?></i>)
        <? }

        if($_REQUEST['monthlysub'] == 1)
        {?>
                (<i><?= date('m-Y', strtotime($start_date)) ?></i>)
        <? }

        if($_GET['pid'] <> '')
        {?>
                (<i><?=$thename;?></i>)
        <? }?>
	Reconciliation 
</span>
<div>

<br />
<div align="center" class="red">
	<b><? echo $_GET['msg'];?></b>
</div>
<table class="ledger" width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center" >
	<tr class="tr_bg_h">
		<td valign="top" class="col_head <?= ($_REQUEST['sort'] == 'service_date')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>" width="10%">
			<a href="report_reconciliation.php?dailysub=<?=$_REQUEST['dailysub'];?>&monthlysub=<?=$_REQUEST['monthlysub'];?>&start_date=<?=$start_date;?>&end_date=<?=$end_date;?>&rangesub=<?=$_REQUEST['rangesub'];?>&weeklysub=<?=$_REQUEST['weeklysub'];?><?= (isset($_GET['pid']))?'&pid='.$_GET['pid']:'';?>&sort=service_date&sortdir=<?php echo ($_REQUEST['sort']=='service_date'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Svc Date</a>
		</td>
		<td valign="top" class="col_head <?= ($_REQUEST['sort'] == 'entry_date')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>" width="10%">
			<a href="report_reconciliation.php?dailysub=<?=$_REQUEST['dailysub'];?>&monthlysub=<?=$_REQUEST['monthlysub'];?>&start_date=<?=$start_date;?>&end_date=<?=$end_date;?>&rangesub=<?=$_REQUEST['rangesub'];?>&weeklysub=<?=$_REQUEST['weeklysub'];?><?= (isset($_GET['pid']))?'&pid='.$_GET['pid']:'';?>&sort=entry_date&sortdir=<?php echo ($_REQUEST['sort']=='entry_date'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Entry Date</a>
		</td>
		<td valign="top" class="col_head <?= ($_REQUEST['sort'] == 'patient')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>" width="10%">
			<a href="report_reconciliation.php?dailysub=<?=$_REQUEST['dailysub'];?>&monthlysub=<?=$_REQUEST['monthlysub'];?>&start_date=<?=$start_date;?>&end_date=<?=$end_date;?>&rangesub=<?=$_REQUEST['rangesub'];?>&weeklysub=<?=$_REQUEST['weeklysub'];?><?= (isset($_GET['pid']))?'&pid='.$_GET['pid']:'';?>&sort=patient&sortdir=<?php echo ($_REQUEST['sort']=='patient'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Patient</a>
		</td>
		<td valign="top" class="col_head <?= ($_REQUEST['sort'] == 'producer')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>" width="10%">
			<a href="report_reconciliation.php?dailysub=<?=$_REQUEST['dailysub'];?>&monthlysub=<?=$_REQUEST['monthlysub'];?>&start_date=<?=$start_date;?>&end_date=<?=$end_date;?>&rangesub=<?=$_REQUEST['rangesub'];?>&weeklysub=<?=$_REQUEST['weeklysub'];?><?= (isset($_GET['pid']))?'&pid='.$_GET['pid']:'';?>&sort=producer&sortdir=<?php echo ($_REQUEST['sort']=='producer'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Producer</a>
		</td>
		<td valign="top" class="col_head <?= ($_REQUEST['sort'] == 'description')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>" width="30%">
			<a href="report_reconciliation.php?dailysub=<?=$_REQUEST['dailysub'];?>&monthlysub=<?=$_REQUEST['monthlysub'];?>&start_date=<?=$start_date;?>&end_date=<?=$end_date;?>&rangesub=<?=$_REQUEST['rangesub'];?>&weeklysub=<?=$_REQUEST['weeklysub'];?><?= (isset($_GET['pid']))?'&pid='.$_GET['pid']:'';?>&sort=description&sortdir=<?php echo ($_REQUEST['sort']=='description'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Description</a>
		</td>
		<td valign="top" class="col_head <?= ($_REQUEST['sort'] == 'paid_amount')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>" width="10%">
			<a href="report_reconciliation.php?dailysub=<?=$_REQUEST['dailysub'];?>&monthlysub=<?=$_REQUEST['monthlysub'];?>&start_date=<?=$start_date;?>&end_date=<?=$end_date;?>&rangesub=<?=$_REQUEST['rangesub'];?>&weeklysub=<?=$_REQUEST['weeklysub'];?><?= (isset($_GET['pid']))?'&pid='.$_GET['pid']:'';?>&sort=paid_amount&sortdir=<?php echo ($_REQUEST['sort']=='paid_amount'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Credits</a>
		</td>
		<td valign="top" class="col_head <?= ($_REQUEST['sort'] == 'status')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>" width="5%">
			<a href="report_reconciliation.php?dailysub=<?=$_REQUEST['dailysub'];?>&monthlysub=<?=$_REQUEST['monthlysub'];?>&start_date=<?=$start_date;?>&end_date=<?=$end_date;?>&rangesub=<?=$_REQUEST['rangesub'];?>&weeklysub=<?=$_REQUEST['weeklysub'];?><?= (isset($_GET['pid']))?'&pid='.$_GET['pid']:'';?>&sort=status&sortdir=<?php echo ($_REQUEST['sort']=='status'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Ins</a>
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
		$tot_charges = 0;
		$tot_credit = 0;
		if(isset($_GET['pid'])){
		$newquery = "SELECT dl.*, dp.firstname, dp.middlename, dp.lastname, p.name FROM dental_ledger as dl INNER JOIN dental_patients as dp ON dl.patientid = dp.patientid LEFT JOIN dental_users p ON p.userid=dl.producerid WHERE  dl.docid='".$_SESSION['docid']."' AND dl.patientid = '".$_GET['pid']."'";
		}else{
    $newquery = "SELECT dl.*, dp.firstname, dp.middlename, dp.lastname, p.name FROM dental_ledger as dl INNER JOIN dental_patients as dp ON dl.patientid = dp.patientid LEFT JOIN dental_users p ON p.userid=dl.producerid WHERE  dl.docid='".$_SESSION['docid']."'";
    }
                if(isset($_GET['pid'])){
                $newquery = "SELECT * FROM dental_ledger WHERE  docid='".$_SESSION['docid']."' AND `patientid` = '".$_GET['pid']."'";
                }else{
    $newquery = "SELECT * FROM dental_ledger WHERE `docid` = '".$_SESSION['docid']."'";
    }


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
$newquery = "select 
                'ledger',
                dl.ledgerid,
                dl.service_date,
                dl.entry_date,
                CONCAT(p.first_name,' ',p.last_name) as name,
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
                concat('Note - ', p.first_name, ' ', p.last_name),
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
                '' as payer,
                '' as payment_type,
		dl.primary_claim_id
        from dental_ledger dl 
                JOIN dental_patients as pat ON dl.patientid = pat.patientid
                LEFT JOIN dental_users as p ON dl.producerid=p.userid 
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


                if($_REQUEST['dailysub'] || $_REQUEST['weeklysub'] || $_REQUEST['monthlysub'] || $_REQUEST['rangesub'])
                   //$newquery .= " AND service_date BETWEEN '".$start_date."' AND '".$end_date."'";
	
                if(isset($_REQUEST['sort'])){
                  if($_REQUEST['sort']=='patient'){
                    $newquery .= " ORDER BY lastname ".$_REQUEST['sortdir'].", dp.firstname ".$_REQUEST['sortdir'];
                  }elseif($_REQUEST['sort']=='producer'){
		    $newquery .= " ORDER BY name ".$_REQUEST['sortdir'];
                  }else{
                    $newquery .= " ORDER BY ".$_REQUEST['sort']." ".$_REQUEST['sortdir'];	
                  }
                  }
                $runquery = mysql_query($newquery);
		while($myarray = mysql_fetch_array($runquery))
		{
			if($myarray['paid_amount'] > 0){
			$pat_sql = "select * from dental_patients where patientid='".$myarray['patientid']."'";
			$pat_my = mysql_query($pat_sql);
			$pat_myarray = mysql_fetch_array($pat_my);
			
			$name = st($pat_myarray['lastname'])." ".st($pat_myarray['middlename'])." ".st($pat_myarray['firstname']);
			
			if($myarray["status"] == 1)
			{
				$tr_class = "tr_active";
			}
			else
			{
				$tr_class = "tr_inactive";
			}
			$tr_class = "tr_active";
		?>
			<tr onclick="window.location = 'manage_ledger.php?pid=<?= $myarray['patientid']; ?>'" class="clickable_row <?=$tr_class;?> <?= $myarray[0]; ?>">
				<td valign="top" width="10%">
                	<?=date('m-d-Y',strtotime(st($myarray["service_date"])));?>
				</td>
				<td valign="top" width="10%">
                	<?=date('m-d-Y',strtotime(st($myarray["entry_date"])));?>
				</td>
				<td valign="top" width="10%">
                	<?=st($name);?>
				</td>
				<td valign="top" width="10%">
                	<?=st($myarray["name"]);?>
				</td>
				<td valign="top" width="30%">
			<?php if($myarray[0]=='ledger_payment'){ ?>
				<?= $dss_trxn_payer_labels[$myarray['payer']]; ?> Payment - <?= $dss_trxn_pymt_type_labels[$myarray['payment_type']]; ?>
			<?php }else{ ?>
                	<?=st($myarray["description"]);?>
                        <?= ($myarray['primary_claim_id'])?" (".$myarray['primary_claim_id'].")":'';?>
			<?php } ?>
				</td>
				<td valign="top" align="right" width="10%">
					<? if(st($myarray["paid_amount"]) <> 0) {?>
	                	<?=number_format(st($myarray["paid_amount"]),2);?>
					<? 
						$tot_credit += st($myarray["paid_amount"]);
					}?>
					&nbsp;
				</td>
				<td valign="top" width="5%">&nbsp;
			 <? if($myarray[0] == 'ledger'){
                  echo $dss_trxn_status_labels[$myarray["status"]];
        }elseif($myarray[0] == 'claim'){
                  echo $dss_claim_status_labels[$myarray["status"]];
        }
	
					}?>       	
				</td>
			</tr>
	<? 	}
		}
	?> 
	  
		<tr>
			<td valign="top" colspan="5" align="right">
				<b>Total</b>
			</td>
		<td valign="top" align="right">
			<b>
			<?php echo "$".number_format($tot_credit,2);?>
			&nbsp;
			</b>
		</td>
		<td valign="top">&nbsp;
			
		</td>
	</tr>


</table>

