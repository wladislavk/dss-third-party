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
    if(isset($_POST['amount_monthly'])){
      $in_sql = "INSERT INTO dental_percase_invoice (adminid, docid, adddate, ip_address, monthly_fee_date, monthly_fee_amount) " .
                " VALUES (".$_SESSION['adminuserid'].", ".$_POST['docid'].", NOW(), '".$_SERVER['REMOTE_ADDR']."', CURDATE(), '".mysql_real_escape_string($_POST['amount_monthly'])."')";
    }else{
      $in_sql = "INSERT INTO dental_percase_invoice (adminid, docid, adddate, ip_address) " .
                " VALUES (".$_SESSION['adminuserid'].", ".$_POST['docid'].", NOW(), '".$_SERVER['REMOTE_ADDR']."')";
    }
    mysql_query($in_sql);
    $invoiceid = mysql_insert_id();
  while($case = mysql_fetch_assoc($case_q)){
    $id = $case['ledgerid'];
    if(isset($_POST['service_date_'.$id])){
      $up_sql = "UPDATE dental_ledger SET " .
        " percase_date = '".$_POST['service_date_'.$id]."', " .
        " percase_name = '".$_POST['name_'.$id]."', " .
        " percase_amount = '".$_POST['amount_'.$id]."', " .
        " percase_status = '".DSS_PERCASE_INVOICED."', " .
        " percase_invoice = '".$invoiceid."' " .
        " WHERE ledgerid = '".$id."'";
      mysql_query($up_sql);
    }
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
<br /><br />
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
		<td valign="top" class="col_head" width="5%">
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
?>
                        <tr id="month_row">
                                <td valign="top">
                                        MONTHLY FEE 
                                </td>
                                <td valign="top">
                                        <?=date('m/d/Y');?>
                                </td>
                                <td valign="top">
                                            $<input type="text" class="amount" name="amount_monthly" value="695.00" />
                                </td>
                                <td valign="top">
                                        <a href="#" onclick="$('#month_row').remove()">Remove</a>
                                </td>
                        </tr>
<?php
		while($case = mysql_fetch_array($case_q))
		{
		?>
			<tr id="case_row_<?= $case['ledgerid'] ?>">
				<td valign="top">
					<input type="text" name="name_<?= $case['ledgerid'] ?>" value="<?=st($case["firstname"]." ".$case["lastname"]);?>" />
				</td>
				<td valign="top">
					<input type="text" name="service_date_<?= $case['ledgerid'] ?>" value="<?=date('m/d/Y', strtotime(st($case["service_date"])));?>" />
				</td>
				<td valign="top">
         				    $<input type="text" class="amount" name="amount_<?= $case['ledgerid'] ?>" value="195.00" />
				</td>
				<td valign="top">
					<a href="#" onclick="$('#case_row_<?= $case['ledgerid'] ?>').remove()">Remove</a>
				</td>
			</tr>
	<? 	}
		?>
		<tr>
			<td valign="top" colspan="2">&nbsp;
			Total: <span id="total" style="font-weight:bold;">$<?= number_format(mysql_num_rows($case_q)*195,2); ?></span>	
			</td>
			<td valign="top" class="col_head" colspan="2">
				<input type="submit" name="submit" value=" Create " class="button" />
				<a href="manage_percase_invoice.php" style="margin-left:20px;color:#c33;">Cancel</a>
			</td>
		</tr>
		<?
	}?>
</table>
</form>
<script type="text/javascript">

$('.amount').keyup(function(){
a = 0;
  $('.amount').each(function(){
    a += Number($(this).val());
  });
a = a.toFixed(2);
$('#total').html('$'+a);
});
</script>

<br /><br />	
<? include "includes/bottom.htm";?>
