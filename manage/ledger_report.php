<? 
include "includes/top.htm";

if($_REQUEST['dailysub'] != 1 && $_REQUEST['monthlysub'] != 1 && $_REQUEST['weeklysub'] != 1 && $_REQUEST['rangesub'] != 1 && $_GET['pid'] == '')
{?>
	<script type="text/javascript">
		window.location = 'ledger.php';
	</script>
	<?
	die();
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

<link rel="stylesheet" href="admin/popup/popup.css" type="text/css" media="screen" />
<script src="admin/popup/jquery-1.2.6.min.js" type="text/javascript"></script>
<script src="admin/popup/popup.js" type="text/javascript"></script>

<span class="admin_head">
	Ledger Report
	<? if($_REQUEST['dailysub'] == 1)
	{?>
	    (<i><?=$_REQUEST['d_mm']?>-<?=$_REQUEST['d_dd']?>-<?=$_REQUEST['d_yy']?></i>)
	<? }
        
        if($_REQUEST['weeklysub'] == 1)
        {?>
            (<i><?= date('m-d-Y', strtotime($start_date))?> - <?= date('m-d-Y', strtotime($end_date))?></i>)
        <? }
	
	if($_REQUEST['monthlysub'] == 1)
	{?>
		(<i><?=$_REQUEST['d_mm']?>-<?=$_REQUEST['d_yy']?></i>)
	<? }
	
	if($_GET['pid'] <> '')
	{?>
		(<i><?=$thename;?></i>)
	<? }?>
</span>
<div>
&nbsp;&nbsp;
<a href="ledger.php" class="editlink" title="EDIT">
	<b>&lt;&lt;Back</b></a>
</div>

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
	<button onclick="Javascript: window.location='print_ledger_report.php?dailysub=<?=$_REQUEST['dailysub'];?>&monthlysub=<?=$_REQUEST['monthlysub'];?>&start_date=<?=$start_date;?>&end_date=<?=$end_date;?>&rangesub=<?=$_REQUEST['rangesub'];?>&weeklysub=<?=$_REQUEST['weeklysub'];?><?= (isset($_GET['pid']))?'&pid='.$_GET['pid']:'';?>';" class="addButton">
		Print Ledger Report
	</button>
	&nbsp;&nbsp;
<button onclick="Javascript: window.location='export_ledger_report.php?dailysub=<?=$_REQUEST['dailysub'];?>&monthlysub=<?=$_REQUEST['monthlysub'];?>&start_date=<?=$start_date;?>&end_date=<?=$end_date;?>&rangesub=<?=$_REQUEST['rangesub'];?>&weeklysub=<?=$_REQUEST['weeklysub'];?><?= (isset($_GET['pid']))?'&pid='.$_GET['pid']:'';?>';" class="addButton">
            Export
        </button>
        &nbsp;&nbsp;

</div>

<br />
<div align="center" class="red">
	<b><? echo $_GET['msg'];?></b>
</div>
<table class="ledger" width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center" >
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
		<td valign="top" class="col_head" width="10%">
			<a href="ledger_report.php?dailysub=<?=$_REQUEST['dailysub'];?>&monthlysub=<?=$_REQUEST['monthlysub'];?>&start_date=<?=$start_date;?>&end_date=<?=$end_date;?>&rangesub=<?=$_REQUEST['rangesub'];?>&weeklysub=<?=$_REQUEST['weeklysub'];?><?= (isset($_GET['pid']))?'&pid='.$_GET['pid']:'';?>&sort=service_date">Svc Date</a>
		</td>
		<td valign="top" class="col_head" width="10%">
			<a href="ledger_report.php?dailysub=<?=$_REQUEST['dailysub'];?>&monthlysub=<?=$_REQUEST['monthlysub'];?>&start_date=<?=$start_date;?>&end_date=<?=$end_date;?>&rangesub=<?=$_REQUEST['rangesub'];?>&weeklysub=<?=$_REQUEST['weeklysub'];?><?= (isset($_GET['pid']))?'&pid='.$_GET['pid']:'';?>&sort=entry_date">Entry Date</a>
		</td>
		<td valign="top" class="col_head" width="10%">
			<a href="ledger_report.php?dailysub=<?=$_REQUEST['dailysub'];?>&monthlysub=<?=$_REQUEST['monthlysub'];?>&start_date=<?=$start_date;?>&end_date=<?=$end_date;?>&rangesub=<?=$_REQUEST['rangesub'];?>&weeklysub=<?=$_REQUEST['weeklysub'];?><?= (isset($_GET['pid']))?'&pid='.$_GET['pid']:'';?>&sort=patient">Patient</a>
		</td>
		<td valign="top" class="col_head" width="10%">
			<a href="ledger_report.php?dailysub=<?=$_REQUEST['dailysub'];?>&monthlysub=<?=$_REQUEST['monthlysub'];?>&start_date=<?=$start_date;?>&end_date=<?=$end_date;?>&rangesub=<?=$_REQUEST['rangesub'];?>&weeklysub=<?=$_REQUEST['weeklysub'];?><?= (isset($_GET['pid']))?'&pid='.$_GET['pid']:'';?>&sort=producer">Producer</a>
		</td>
		<td valign="top" class="col_head" width="30%">
			<a href="ledger_report.php?dailysub=<?=$_REQUEST['dailysub'];?>&monthlysub=<?=$_REQUEST['monthlysub'];?>&start_date=<?=$start_date;?>&end_date=<?=$end_date;?>&rangesub=<?=$_REQUEST['rangesub'];?>&weeklysub=<?=$_REQUEST['weeklysub'];?><?= (isset($_GET['pid']))?'&pid='.$_GET['pid']:'';?>&sort=description">Description</a>
		</td>
		<td valign="top" class="col_head" width="10%">
			<a href="ledger_report.php?dailysub=<?=$_REQUEST['dailysub'];?>&monthlysub=<?=$_REQUEST['monthlysub'];?>&start_date=<?=$start_date;?>&end_date=<?=$end_date;?>&rangesub=<?=$_REQUEST['rangesub'];?>&weeklysub=<?=$_REQUEST['weeklysub'];?><?= (isset($_GET['pid']))?'&pid='.$_GET['pid']:'';?>&sort=amount">Charges</a>
		</td>
		<td valign="top" class="col_head" width="10%">
			<a href="ledger_report.php?dailysub=<?=$_REQUEST['dailysub'];?>&monthlysub=<?=$_REQUEST['monthlysub'];?>&start_date=<?=$start_date;?>&end_date=<?=$end_date;?>&rangesub=<?=$_REQUEST['rangesub'];?>&weeklysub=<?=$_REQUEST['weeklysub'];?><?= (isset($_GET['pid']))?'&pid='.$_GET['pid']:'';?>&sort=paid_amount">Credits</a>
		</td>
		<td valign="top" class="col_head" width="5%">
			<a href="ledger_report.php?dailysub=<?=$_REQUEST['dailysub'];?>&monthlysub=<?=$_REQUEST['monthlysub'];?>&start_date=<?=$start_date;?>&end_date=<?=$end_date;?>&rangesub=<?=$_REQUEST['rangesub'];?>&weeklysub=<?=$_REQUEST['weeklysub'];?><?= (isset($_GET['pid']))?'&pid='.$_GET['pid']:'';?>&sort=status">Ins</a>
		</td>
	</tr>
	</table>
	<div style="overflow:auto; ">
<table width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center" style="margin-left: 10px;" >
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
		$newquery = "SELECT dl.*, dp.firstname, dp.middlename, dp.lastname FROM dental_ledger as dl INNER JOIN dental_patients as dp ON dl.patientid = dp.patientid WHERE  dl.docid='".$_SESSION['docid']."' AND `dl.patientid` = '".$_GET['pid']."'";
		}else{
    $newquery = "SELECT dl.*, dp.firstname, dp.middlename, dp.lastname FROM dental_ledger as dl INNER JOIN dental_patients as dp ON dl.patientid = dp.patientid WHERE  dl.docid='".$_SESSION['docid']."'";
    }
                if($_REQUEST['dailysub'] || $_REQUEST['weeklysub'] || $_REQUEST['monthlysub'] || $_REQUEST['rangesub'])
                   $newquery .= " AND service_date BETWEEN '".$start_date."' AND '".$end_date."'";
	
                if(isset($_REQUEST['sort'])){
                  if($_REQUEST['sort']=='patient'){
                    $newquery .= " ORDER BY dp.lastname ASC, dp.firstname ASC";
                  }else{
                    $newquery .= " ORDER BY ".$_REQUEST['sort']." ASC";	
                  }
                  }
                $runquery = mysql_query($newquery);
		while($myarray = mysql_fetch_array($runquery))
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
                	<?=st($name);?>
				</td>
				<td valign="top" width="10%">
                	<?=st($myarray["producer"]);?>
				</td>
				<td valign="top" width="30%">
                	<?=st($myarray["description"]);?>
				</td>
				<td valign="top" align="right" width="10%">
          <?php
          echo $myarray["amount"];
          $tot_charge += $myarray["amount"];
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
				
					}?>       	
				</td>
			</tr>
	<? 	}
	?> 
	  
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
				<?php echo "$".number_format($tot_charge,2); ?>
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

</table>
 </div>

<div id="popupContact" style="width:750px;">
    <a id="popupContactClose"><button>X</button></a>
    <iframe id="aj_pop" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
</div>
<div id="backgroundPopup"></div>

<br /><br />	
<? include "includes/bottom.htm";?>
