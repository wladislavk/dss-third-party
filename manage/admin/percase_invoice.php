<? 
include "includes/top.htm";

$case_sql = "SELECT * FROM dental_ledger dl 
		JOIN dental_patients dp ON dl.patientid=dp.patientid
	WHERE 
		dl.transaction_code='E0486' AND
		dl.docid='".$_REQUEST['docid']."' AND
		dl.percase_status = '".DSS_PERCASE_PENDING."'
";
$case_q = mysql_query($case_sql);
if(isset($_POST['submit'])){
    $in_sql = "INSERT INTO dental_percase_invoice (adminid, docid, adddate, ip_address) " .
                " VALUES (".$_SESSION['adminuserid'].", ".$_POST['docid'].", NOW(), '".$_SERVER['REMOTE_ADDR']."')";
    mysql_query($in_sql);
    $invoiceid = mysql_insert_id();
  while($case = mysql_fetch_assoc($case_q)){
    $id = $case['ledgerid'];
    $up_sql = "UPDATE dental_ledger SET " .
      " percase_date = '".$_POST['service_date_'.$id]."', " .
      " percase_name = '".$_POST['name_'.$id]."', " .
      " percase_amount = '".$_POST['amount_'.$id]."', " .
      " percase_status = '".DSS_PERCASE_INVOICED."', " .
      " percase_invoice = '".$invoiceid."' " .
      " WHERE ledgerid = '".$id."'";
    mysql_query($up_sql);
  }
  ?>
  <script type="text/javascript">
    window.location = 'percase_invoice_pdf.php?invoice_id=<?= $invoiceid; ?>';
  </script>
  <?php

}

?>
<link rel="stylesheet" href="popup/popup.css" type="text/css" media="screen" />
<script src="popup/jquery-1.2.6.min.js" type="text/javascript"></script>
<script src="popup/popup.js" type="text/javascript"></script>

<span class="admin_head">
	Per-case  Invoice - <?= $doc['name']; ?>	
</span>
<br />


<div align="center" class="red">
	<b><? echo $_GET['msg'];?></b>
</div>

<form name="sortfrm" action="<?=$_SERVER['PHP_SELF']?>" method="post">
<input type="hidden" name="docid" value="<?=$_GET["docid"];?>" />
<table width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center" >
	<tr class="tr_bg_h">
		<td valign="top" class="col_head" width="20%">
			Patient Name		
		</td>
		<td valign="top" class="col_head" width="40%">
			Service Date	
		</td>
		<td valign="top" class="col_head" width="20%">
			Amount		
		</td>
	</tr>
	<? if(mysql_num_rows($case_q) == 0)
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
		while($case = mysql_fetch_array($case_q))
		{
		?>
			<tr>
				<td valign="top">
					<input type="text" name="name_<?= $case['ledgerid'] ?>" value="<?=st($case["firstname"]." ".$case["lastname"]);?>" />
				</td>
				<td valign="top">
					<input type="text" name="service_date_<?= $case['ledgerid'] ?>" value="<?=date('m/d/Y', strtotime(st($case["service_date"])));?>" />
				</td>
				<td valign="top">
         				    $<input type="text" name="amount_<?= $case['ledgerid'] ?>" value="195.00" />
				</td>
			</tr>
	<? 	}
		?>
		<tr>
			<td valign="top" class="col_head" colspan="3">&nbsp;
				
			</td>
			<td valign="top" class="col_head" colspan="2">
				<input type="submit" name="submit" value=" Create " class="button" />
			</td>
		</tr>
		<?
	}?>
</table>
</form>


<br /><br />	
<? include "includes/bottom.htm";?>
