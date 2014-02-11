<? 
include "includes/top.htm";



$rec_disp = 200;

if($_REQUEST["page"] != "")
	$index_val = $_REQUEST["page"];
else
	$index_val = 0;
	
$i_val = $index_val * $rec_disp;


$sql = "select dl.*, p.name from dental_ledger AS dl LEFT JOIN dental_users as p ON dl.producerid=p.userid where dl.docid='".$_SESSION['docid']."'";
        if($_POST['dailysub'] != 1 && $_POST['monthlysub'] != 1){ 
$sql = "
select 
		'ledger',
		dl.ledgerid,
		dl.service_date,
		dl.entry_date,
		dl.amount,
		dl.paid_amount,
		dl.status, 
		dl.description,
		p.name, 
		pat.patientid,
		pat.firstname, 
		pat.lastname,
		'' as payer,
		'' as payment_type
	from dental_ledger dl 
		JOIN dental_patients as pat ON dl.patientid = pat.patientid
		LEFT JOIN dental_users as p ON dl.producerid=p.userid 
	where dl.docid='".$_SESSION['docid']."' 
	AND dl.service_date=CURDATE()
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
                p.name,
		pat.patientid,
                pat.firstname,
		pat.lastname,
                dlp.payer,
                dlp.payment_type
        from dental_ledger dl 
		JOIN dental_patients pat on dl.patientid = pat.patientid
                LEFT JOIN dental_users p ON dl.producerid=p.userid 
                LEFT JOIN dental_ledger_payment dlp on dlp.ledgerid=dl.ledgerid
                        where dl.docid='".$_SESSION['docid']."' 
                        AND dlp.amount != 0
			AND dlp.payment_date=CURDATE()
";

        }

if(!isset($_REQUEST['sort'])){
  $_REQUEST['sort'] = 'service_date';
  $_REQUEST['sortdir'] = 'desc';
} 

if(isset($_REQUEST['sort'])){
  if($_REQUEST['sort']=='producer'){
    $sql .= " ORDER BY name ".$_REQUEST['sortdir'];
  }elseif($_REQUEST['sort']=='patient'){
    $sql .= " ORDER BY pat.lastname ".$_REQUEST['sortdir'];
  }elseif($_REQUEST['sort']=='producer'){
    $sql .= " ORDER BY name ".$_REQUEST['sortdir'];
  }elseif($_REQUEST['sort']=='producer'){
    $sql .= " ORDER BY name ".$_REQUEST['sortdir'];
  }else{
    $sql .= " ORDER BY ".$_REQUEST['sort']." ".$_REQUEST['sortdir'];
  }
}
$my = mysql_query($sql);

/*
$sql .= " order by service_date";

$total_rec = mysql_num_rows($my);
$no_pages = $total_rec/$rec_disp;
*/

$num_users=mysql_num_rows($my);

//echo $sql; 
?>

<link rel="stylesheet" href="admin/popup/popup.css" type="text/css" media="screen" />
<script src="admin/popup/popup.js" type="text/javascript"></script>

<span class="admin_head">
	Today's Ledger Report
	<? if($_POST['dailysub'] == 1)
	{?>
	    (<i><?=$_POST['d_mm']?>-<?=$_POST['d_dd']?>-<?=$_POST['d_yy']?></i>)
	<? }
	
	if($_POST['monthlysub'] == 1)
	{?>
		(<i><?=$_POST['d_mm']?>-<?=$_POST['d_yy']?></i>)
	<? }
	
	if($_GET['pid'] <> '')
	{?>
		(<i><?=$thename;?></i>)
	<? }?>

	<?php if($_POST['dailysub'] != 1 && $_POST['monthlysub'] != 1){ ?>
	   (<i><?= date('m/d/Y'); ?></i>)
	<?php } ?>

</span>

<br />
<style>
#contentMain tr:hover{
background:#cccccc;
}

#contentMain td:hover{
background:#999999;
}
</style>
<div align="right">
        <a href="report_claim_aging.php" class="addButton">
                Claim Aging
        </a>
&nbsp;&nbsp;&nbsp;&nbsp;
	<a href="print_ledger_reportfull.php?dailysub=<?=$_POST['dailysub'];?>&monthlysub=<?=$_POST['monthlysub'];?>&d_mm=<?=$_POST['d_mm'];?>&d_dd=<?=$_POST['d_dd'];?>&d_yy=<?=$_POST['d_yy'];?>&pid=<?=$_GET['pid'];?>" target="_blank" class="addButton">
		Print Ledger
	</a>
        &nbsp;&nbsp;&nbsp;&nbsp;
<button onclick="Javascript:window.location='ledger.php';" class="addButton"> 
                Other Reports
        </button>
        &nbsp;&nbsp;&nbsp;&nbsp;
<button onclick="Javascript:window.location='unpaid_patient.php';" class="addButton">
               Unpaid Pt. 
        </button>

        &nbsp;&nbsp;
</div>

<br />
<div align="center" class="red">
	<b><? echo $_GET['msg'];?></b>
</div>
<table width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center" >
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
		<td valign="top" class="col_head <?= ($_REQUEST['sort'] == 'service_date')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>" width="10%">
			<a href="ledger_reportfull.php?sort=service_date&sortdir=<?php echo ($_REQUEST['sort']=='service_date'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Svc Date</a>
		</td>
		<td valign="top" class="col_head  <?= ($_REQUEST['sort'] == 'entry_date')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>" width="10%">
			<a href="ledger_reportfull.php?sort=entry_date&sortdir=<?php echo ($_REQUEST['sort']=='entry_date'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Entry Date
		</td>
		<td valign="top" class="col_head <?= ($_REQUEST['sort'] == 'patient')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>" width="10%">
			<a href="ledger_reportfull.php?sort=patient&sortdir=<?php echo ($_REQUEST['sort']=='patient'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Patient
		</td>
		<td valign="top" class="col_head <?= ($_REQUEST['sort'] == 'producer')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>" width="10%">
			<a href="ledger_reportfull.php?sort=producer&sortdir=<?php echo ($_REQUEST['sort']=='producer'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Producer
		</td>
		<td valign="top" class="col_head <?= ($_REQUEST['sort'] == 'description')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>" width="30%">
			<a href="ledger_reportfull.php?sort=description&sortdir=<?php echo ($_REQUEST['sort']=='description'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Description
		</td>
		<td valign="top" class="col_head <?= ($_REQUEST['sort'] == 'amount')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>" width="10%">
			<a href="ledger_reportfull.php?sort=amount&sortdir=<?php echo ($_REQUEST['sort']=='amount'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Charges
		</td>
		<td valign="top" class="col_head <?= ($_REQUEST['sort'] == 'paid_amount')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>" width="10%">
			<a href="ledger_reportfull.php?sort=credits&sortdir=<?php echo ($_REQUEST['sort']=='paid_amount'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Credits
		</td>
		<td valign="top" class="col_head <?= ($_REQUEST['sort'] == 'status')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>" width="5%">
			<a href="ledger_reportfull.php?sort=status&sortdir=<?php echo ($_REQUEST['sort']=='status'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Ins</a>
		</td>
	</tr>
	</table>
	<div style="overflow:auto; height:400px; overflow-x:hidden; overflow-y:scroll;">
<table width="100%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center" style="margin-left: 10px;" >
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
		
		while($myarray = mysql_fetch_array($my))
		{
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
			<tr class="<?=$tr_class;?>">
				<td valign="top" width="10%">
                	<?=date('m-d-Y',strtotime(st($myarray["service_date"])));?>
				</td>
				<td valign="top" width="10%">
                	<?=date('m-d-Y',strtotime(st($myarray["entry_date"])));?>
				</td>
				<td valign="top" width="10%">
                	<a href="manage_ledger.php?pid=<?= $myarray['patientid']; ?>&addtopat=1"><?=st($myarray['lastname'].", ".$myarray['firstname']);?></a>
				</td>
				<td valign="top" width="10%">
                	<?=st($myarray['name']);?>
				</td>
				<td valign="top" width="30%">
<?= (($myarray[0] == 'ledger_payment'))?$dss_trxn_payer_labels[$myarray['payer']]." Payment - ":''; ?>
                        <?= (($myarray[0] == 'ledger_payment'))?$dss_trxn_pymt_type_labels[$myarray['payment_type']]." ":''; ?>
                	<?= (($myarray[0] == 'ledger'))?$myarray["description"]:'';?>
				</td>
				<td valign="top" align="right" width="10%">
          <?php
	if($myarray[0] == 'ledger'){
	  if($myarray["amount"] <> 0){
          echo number_format($myarray["amount"],2);
	  $tot_charges += $myarray["amount"];
	  }
	}
          ?>

					&nbsp;
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
         <? if($myarray["status"] == 1){
	           echo "Sent";
	          }elseif($myarray["status"] == 2){
             echo "Filed";
            }else{
             echo "Pend";
            }
				
						//$tot_credit += st($myarray["paid_amount"]);
					}?>       	
				</td>
			</tr>
	<? 	}
	?> 
	  
		<tr>
			<td valign="top" colspan="5" align="right">
				<b>Totals</b>
			</td>
			<td valign="top" align="right">
			
			<?php
			            if(isset($_GET['pid'])){
                  $ledgerquery = "SELECT * FROM dental_ledger WHERE `patientid` =".$_GET['pid']." AND `transaction_type` = 'Charge'";
                  }else{
                  $ledgerquery = "SELECT * FROM dental_ledger WHERE `docid` =".$_SESSION['docid']." AND `transaction_type` = 'Charge'";
                  }
                  $ledgerres = mysql_query($ledgerquery);
                  $myarray = mysql_fetch_array($ledgerres);
                  if(isset($_GET['pid'])){
                  $ledgerquery2 = "SELECT * FROM dental_ledger WHERE `patientid` =".$_GET['pid']." and `transaction_type`='Credit'";
                  }else{
                  $ledgerquery2 = "SELECT * FROM dental_ledger WHERE `docid` =".$_SESSION['docid']." and `transaction_type`='Credit'";
                  }
                  $ledgerres2 = mysql_query($ledgerquery2);
                  $myarray2 = mysql_fetch_array($ledgerres2);
                  if(st($myarray["amount"]) <> 0) {
          						$cur_bal += st($myarray["amount"]);
          					}
          					
          					$i = 0;
                    
          						if($i < mysql_num_rows($ledgerres2)){
                        $cur_bal2 = $myarray2['paid_amount'];
                      }
                      $i++;
          			
                    $cur_balfinal = $cur_bal - $cur_bal2;
                    ?>
                    
                    
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
			<td valign="top">&nbsp;
				
			</td>
		</tr>
		<tr>
                        <td valign="top" colspan="5" align="right">
                                <b>Balance</b>
                        </td>
			<td align="right">
				<b>                                <b>
                                <?php echo "$".number_format(($tot_charges - $tot_credit),2);?>
                                &nbsp;
                                </b>
			</td>
			<td colspan="2">
			</td>
		</tr>
</table>
 </div>

<div id="popupContact" style="width:750px;">
    <a id="popupContactClose"><button>X</button></a>
    <iframe id="aj_pop" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
</div>
<div id="backgroundPopup"></div>

<br /><br />	
<? include "includes/bottom.htm";?>
