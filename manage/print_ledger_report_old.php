<?php namespace Ds3\Legacy; ?><? 
include "admin/includes/main_include.php";

if($_POST['dailysub'] != 1 && $_POST['monthlysub'] != 1 && $_POST['weeklysub'] != 1 && $_POST['rangesub'] != 1 && $_GET['pid'] == '')
{?>
	<script type="text/javascript">
		window.location = 'ledger.php';
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
$sql = "select * from dental_ledger where docid='".$_SESSION['docid']."' ";
if($_GET['dailysub'] == 1)
{
	$src_date = $_GET['d_yy']."-".$_GET['d_mm']."-".$_GET['d_dd'];
	$sql .= " and service_date='".s_for($src_date)."' ";
}

if($_GET['monthlysub'] == 1)
{
	$sql .= " and month(service_date)='".s_for($_GET['d_mm'])."' and year(service_date)='".s_for($_GET['d_yy'])."' ";
}

if($_GET['pid'] <> '')
{
	$sql .= " and patientid='".s_for($_GET['pid'])."' ";
	
	$thepat_sql = "select * from dental_patients where patientid='".$_GET['pid']."'";
	$thepat_my = mysql_query($thepat_sql);
	$thepat_myarray = mysql_fetch_array($thepat_my);
	
	$thename = st($thepat_myarray['lastname'])." ".st($thepat_myarray['middlename'])." ".st($thepat_myarray['firstname']);
}

$sql .= " order by service_date";
$my = mysql_query($sql);
$total_rec = mysql_num_rows($my);
$no_pages = $total_rec/$rec_disp;

$sql .= " limit ".$i_val.",".$rec_disp;
$my=mysql_query($sql) or die(mysql_error());
$num_users=mysql_num_rows($my);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta name="keywords" content="<?=st($page_myarray['keywords']);?>" />
<title><?=$sitename;?> | <?=$name;?> - Ledger Card</title>
<link href="css/admin.css" rel="stylesheet" type="text/css" />
<script language="javascript" type="text/javascript" src="script/validation.js"></script>
</head>
<body onLoad="window.print(); parent.disablePopup1();">
<table width="780" border="0" bgcolor="#929B70" cellpadding="1" cellspacing="1" align="center">
  <tr bgcolor="#FFFFFF">
    <td colspan="2" > 

<span class="admin_head">
	Ledger Report
	<? if($_GET['dailysub'] == 1)
	{?>
	    (<i><?=$_GET['d_mm']?>-<?=$_GET['d_dd']?>-<?=$_GET['d_yy']?></i>)
	<? 
	}
	
	if($_GET['monthysub'] == 1)
	{?>
		(<i><?=$_GET['d_mm']?>-<?=$_GET['d_yy']?></i>)
	<? 
	}
	
	if($_GET['pid'] <> '')
	{?>
		(<i><?=$thename;?></i>)
	<? }?>
</span>

<br />

<br />
<div align="center" class="red">
	<b><? echo $_GET['msg'];?></b>
</div>

<table width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center" border="1" >
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
		<td valign="top" class="col_head" width="5%">
			Ins
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
		$newquery = "SELECT * FROM dental_ledger WHERE `patientid` = '".$_GET['pid']."'";
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
				<td valign="top">
                	<?=date('m-d-Y',strtotime(st($myarray["service_date"])));?>
				</td>
				<td valign="top">
                	<?=date('m-d-Y',strtotime(st($myarray["entry_date"])));?>
				</td>
				<td valign="top">
                	<?=st($name);?>
				</td>
				<td valign="top">
                	<?=st($myarray["producer"]);?>
				</td>
				<td valign="top">
                	<?=st($myarray["description"]);?>
				</td>
				<td valign="top" align="right">
					<?php
          echo $myarray["amount"];
          ?>
					<? 
						$tot_charges += st($myarray["amount"]);
					}?>
					&nbsp;
				</td>
				<td valign="top" align="right">
					<? if(st($myarray["paid_amount"]) <> 0) {?>
	                	<?=number_format(st($myarray["paid_amount"]),2);?>
					<? 
						$tot_credit += st($myarray["paid_amount"]);
					}?>
					&nbsp;
				</td>
				<td valign="top">&nbsp;
          <? if($myarray["status"] == 1){
	           echo "Sent";
	          }elseif($myarray["status"] == 2){
             echo "Filed";
            }else{
             echo "Pend";
            }
            ?>       	
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
                  $ledgerquery = "SELECT * FROM dental_ledger WHERE `patientid` =16 AND `transaction_type` = 'Charge'";
                  $ledgerres = mysql_query($ledgerquery);
                  $myarray = mysql_fetch_array($ledgerres);
                  $ledgerquery2 = "SELECT * FROM dental_ledger WHERE `patientid` =16 and `transaction_type`='Credit'";
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
				<?php echo "$".number_format($cur_bal,2); ?>
				&nbsp;
				</b>
			</td>
			<td valign="top" align="right">
				<b>
				<?php echo "$".number_format($cur_bal2,2);?>
				&nbsp;
				</b>
			</td>
			<td valign="top">&nbsp;
				
			</td>
		</tr>

</table>

<br /><br />	

</td>
</tr>
</table>
</body>
</html>
