<? 
include "includes/top.htm";



$rec_disp = 200;

if($_REQUEST["page"] != "")
	$index_val = $_REQUEST["page"];
else
	$index_val = 0;
	
$i_val = $index_val * $rec_disp;


$sql = "SELECT  "
                 . "  sum(dl.amount) as amount, sum(pay.amount) as paid_amount, "
     . "p.firstname, p.lastname, p.patientid "
     . "FROM dental_ledger dl  "
     . "JOIN dental_patients p ON p.patientid=dl.patientid "
     . "LEFT JOIN dental_ledger_payment pay on pay.ledgerid = dl.ledgerid  "
     . "WHERE dl.docid='".$_SESSION['docid']."'  "
     . "GROUP BY dl.patientid";

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
<script src="admin/popup/jquery-1.2.6.min.js" type="text/javascript"></script>
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
			Charges
		</td>
		<td valign="top" class="col_head" width="10%">
			Credits
		</td>
		<td valign="top" class="col_head" width="5%">
			Ins
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
			if($myarray['amount']>$myarray['paid_amount']){
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
				<td valign="top" width="18%">
                	<?date('m-d-Y',strtotime(st($myarray["service_date"])));?>
				</td>
				<td valign="top" width="18%">
                	<?date('m-d-Y',strtotime(st($myarray["entry_date"])));?>
				</td>
				<td valign="top" width="18%">
                	<a href="manage_ledger.php?addtopat=1&pid=<?=$myarray['patientid'];?>"><?=st($myarray['lastname'].", ".$myarray['firstname']);?></a>
				</td>
				<td valign="top" align="right" width="18%">
          <?php
          echo "$".number_format($myarray["amount"],2);
	  $tot_charges += $myarray["amount"];
          ?>

					&nbsp;
				</td>
				<td valign="top" align="right" width="18%">
					<? if(st($myarray["paid_amount"]) <> 0) {?>
	                	<?=number_format(st($myarray["paid_amount"]),2);?>
					<? 
						$tot_credit += st($myarray["paid_amount"]);
					}?>
					&nbsp;
	
				</td>
				<td valign="top" width="10%">&nbsp;
					<?php }?>       	
				</td>
			</tr>
	<? 	} }
	?> 
	  
		<tr>
			<td valign="top" colspan="3" align="right">
				<b>Daily Balance</b>
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
