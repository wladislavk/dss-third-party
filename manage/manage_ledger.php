<? 
include "includes/top.htm";

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
		window.location="<?=$_SERVER['PHP_SELF']?>?msg=<?=$msg?>&pid=<?=$_GET['pid'];?>";
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

$rec_disp = 200;

if($_REQUEST["page"] != "")
	$index_val = $_REQUEST["page"];
else
	$index_val = 0;
	
$i_val = $index_val * $rec_disp;
$sql = "select * from dental_ledger where docid='".$_SESSION['docid']."' and patientid='".s_for($_GET['pid'])."' order by service_date";
$my = mysql_query($sql);
$total_rec = mysql_num_rows($my);
$no_pages = $total_rec/$rec_disp;

$sql .= " limit ".$i_val.",".$rec_disp;
$my=mysql_query($sql) or die(mysql_error());
$num_users=mysql_num_rows($my);

?>

<link rel="stylesheet" href="admin/popup/popup.css" type="text/css" media="screen" />
<script src="admin/popup/jquery-1.2.6.min.js" type="text/javascript"></script>
<script src="admin/popup/popup.js" type="text/javascript"></script>

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

<div align="right">
<button onclick="Javascript: window.location='print_ledger_report.php?<?= (isset($_GET['pid']))?'pid='.$_GET['pid']:'';?>';" class="addButton">
                Print Ledger
        </button>
	&nbsp;&nbsp;&nbsp;&nbsp;
	
	<button onclick="Javascript: loadPopup('add_ledger_entry.php?pid=<?=$_GET['pid'];?>');" class="addButton">
		Add New Transaction
	</button>
	&nbsp;&nbsp;
        <button onclick="Javascript: window.location = 'ledger.php?pid=<?=$_GET['pid'];?>'" class="addButton">
               Reports 
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
		<td valign="top" class="col_head" width="10%">
			Svc Date
		</td>
		<td valign="top" class="col_head" width="10%">
			Entry Date
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
			Balance
		</td>
		<td valign="top" class="col_head" width="5%">
			Ins
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
		$cur_bal = 0;
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
		?>
			<tr class="<?=$tr_class;?>">
				<td valign="top">
                	<?=date('m-d-Y',strtotime(st($myarray["service_date"])));?>
				</td>
				<td valign="top">
                	<?=date('m-d-Y',strtotime(st($myarray["entry_date"])));?>
				</td>

				<td valign="top">
                	<?=st($myarray["description"]);?>
				</td>
				<td valign="top" align="right">
					<? if(st($myarray["amount"]) <> 0) {?>
	                	<?=number_format(st($myarray["amount"]),2);?>
					<? 
						$cur_bal += st($myarray["amount"]);
					}?>
					&nbsp;
				</td>
				<td valign="top" align="right">
					<? if(st($myarray["paid_amount"]) <> 0) {?>
	                	<?=number_format(st($myarray["paid_amount"]),2);?>
					<? 
						$cur_bal -= st($myarray["paid_amount"]);
					}?>
					&nbsp;
				</td>
				<td valign="top" align="right">
					<?=number_format(st($cur_bal),2);?>
                	&nbsp;
				</td>
				<td valign="top">
          <?php
          
          if($myarray["status"] == '0'){echo "Pend.";}
          if($myarray["status"] == '1'){echo "Sent ";}
          if($myarray["status"] == '2'){echo "Filed";}
          
          ?>       	
				</td>
				<td valign="top">
					<a href="Javascript:;" onclick="Javascript: loadPopup('add_ledger.php?ed=<?=$myarray["ledgerid"];?>&pid=<?=$_GET['pid'];?>');" class="editlink" title="EDIT">
						Edit 
					</a>
                    
                    <a href="<?=$_SERVER['PHP_SELF']?>?delid=<?=$myarray["ledgerid"];?>&pid=<?=$_GET['pid'];?>" onclick="javascript: return confirm('Do Your Really want to Delete?.');" class="dellink" title="DELETE">
						 Delete 
					</a>
				</td>
			</tr>
	<? 	}
	}?>
  
  <tr>
      <td colspan="8">
          <center><button class="addButton" onclick="Javascript: loadPopup('view_ledger_record.php?pid=<?php echo $_GET['pid']; ?>');">
		View Ledger Records
	</button></center>
      </td>
  </tr> 
</table>
 

<div id="popupContact" style="width:750px;">
    <a id="popupContactClose"><button>X</button></a>
    <iframe id="aj_pop" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
</div>
<div id="backgroundPopup"></div>

<br /><br />	
<? include "includes/bottom.htm";?>
