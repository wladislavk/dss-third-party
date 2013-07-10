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

$vob_sql = "SELECT * FROM dental_insurance_preauth p
                JOIN dental_patients dp ON p.patient_id=dp.patientid
        WHERE 
                p.doc_id='".$_REQUEST['docid']."' AND
                p.invoice_status = '".DSS_PERCASE_PENDING."'
";
$vob_q = mysql_query($vob_sql);

$fax_sql = "SELECT count(*) as total_faxes, MIN(sent_date) as start_date, MAX(sent_date) as end_date FROM dental_faxes f
        WHERE 
                f.docid='".$_REQUEST['docid']."' AND
                f.status = '0'
";
$fax_q = mysql_query($fax_sql);
$fax = mysql_fetch_assoc($fax_q);

if(isset($_POST['submit'])){
    if(isset($_POST['amount_monthly'])){
      $in_sql = "INSERT INTO dental_percase_invoice (adminid, docid, adddate, ip_address, monthly_fee_date, monthly_fee_amount) " .
                " VALUES (".$_SESSION['adminuserid'].", ".$_POST['docid'].", NOW(), '".$_SERVER['REMOTE_ADDR']."', '".mysql_real_escape_string(date('Y-m-d', strtotime($_POST['monthly_date'])))."', '".mysql_real_escape_string($_POST['amount_monthly'])."')";
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
        " percase_date = '".date('Y-m-d', strtotime($_POST['service_date_'.$id]))."', " .
        " percase_name = '".mysql_real_escape_string($_POST['name_'.$id])."', " .
        " percase_amount = '".mysql_real_escape_string($_POST['amount_'.$id])."', " .
        " percase_status = '".DSS_PERCASE_INVOICED."', " .
        " percase_invoice = '".$invoiceid."' " .
        " WHERE ledgerid = '".$id."'";
      mysql_query($up_sql);
    }
  }

  while($vob = mysql_fetch_assoc($vob_q)){
    $id = $vob['id'];
    if(isset($_POST['vob_date_completed_'.$id])){
      $up_sql = "UPDATE dental_insurance_preauth SET " .
        " invoice_date = '".date('Y-m-d', strtotime($_POST['vob_date_completed_'.$id]))."', " .
        " invoice_amount = '".mysql_real_escape_string($_POST['vob_amount_'.$id])."', " .
        " invoice_status = '".DSS_PERCASE_INVOICED."', " .
        " invoice_id = '".$invoiceid."' " .
        " WHERE id = '".$id."'";
      mysql_query($up_sql);
    }
  }


  if(isset($_POST['fax_desc'])){
    $fax_start_date = ($_POST['fax_start_date'])?date('Y-m-d', strtotime($_POST['fax_start_date'])):''; 
    $fax_end_date = ($_POST['fax_end_date'])?date('Y-m-d', strtotime($_POST['fax_end_date'])):'';

    $in_sql = "INSERT INTO dental_fax_invoice SET
                invoice_id = '".mysql_real_escape_string($invoiceid)."',
		description = '".mysql_real_escape_string($_POST['fax_desc'])."',
                start_date = '".mysql_real_escape_string($fax_start_date)."',
                end_date = '".mysql_real_escape_string($fax_end_date)."',
                amount = '".mysql_real_escape_string($_POST['fax_amount'])."',
		adddate = now(),
		ip_address = '".$_SERVER['REMOTE_ADDR']."'";
    mysql_query($in_sql);
    $fax_invoice_id = mysql_insert_id();

    $up_sql = "UPDATE dental_faxes SET
		status = '1',
		fax_invoice_id = '".$fax_invoice_id."' 
		WHERE status='0' AND docid='".mysql_real_escape_string($_REQUEST['docid'])."'";
    mysql_query($up_sql);
  }

  $num_extra = $_POST['extra_total'];
  for($i=1;$i<=$num_extra;$i++){
    if(isset($_POST['extra_name_'.$i])){
	$name = $_POST['extra_name_'.$i];
        $service_date = $_POST['extra_service_date_'.$i];
	$service_date = ($service_date!='')?date('Y-m-d', strtotime($service_date)):'';
	$amount = $_POST['extra_amount_'.$i];
	$sql = "INSERT INTO dental_percase_invoice_extra SET" .
        " percase_date = '".$service_date."', " .
        " percase_name = '".$name."', " .
        " percase_amount = '".$amount."', " .
        " percase_status = '".DSS_PERCASE_INVOICED."', " .
        " percase_invoice = '".$invoiceid."', " .
	" adddate = NOW(), " .
  	" ip_address = '".$_SERVER['REMOTE_ADDR']."'";
	echo $sql;
      mysql_query($sql);
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
<?php
  $doc_sql = "SELECT c.monthly_fee, c.fax_fee, u.name, u.user_type
		FROM dental_users u
		JOIN dental_user_company uc ON uc.userid = u.userid
		JOIN companies c ON uc.companyid = c.id
		WHERE u.userid='".mysql_real_escape_string($_REQUEST['docid'])."'";
  $doc_q = mysql_query($doc_sql);
  $doc = mysql_fetch_assoc($doc_q);


?>
<span class="admin_head">
	Invoicing - <?= $doc['name']; ?>	
</span>
<br />


<div align="center" class="red">
	<b><? echo $_GET['msg'];?></b>
</div>
<br /><br />
<form name="sortfrm" action="<?=$_SERVER['PHP_SELF']?>" method="post">
<input type="hidden" name="docid" value="<?=$_GET["docid"];?>" />
<table id="invoice_table" width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center" >
	<tr class="tr_bg_h">
		<td valign="top" class="col_head" width="20%">
			Patient Name		
		</td>
		<td valign="top" class="col_head" width="40%">
			Service Date	
		</td>
                <td valign="top" class="col_head" width="10%">
                </td>
		<td valign="top" class="col_head" width="20%">
			Amount		
		</td>
	</tr>
                        <tr id="month_row">
                                <td valign="top">
                                        MONTHLY FEE 
                                </td>
                                <td valign="top">
                                        <input type="text" name="monthly_date" value="<?=date('m/d/Y');?>" />
                                </td>
                                <td valign="top">
                                        <a href="#" onclick="$('#month_row').remove(); calcTotal();">Remove</a>
                                </td>
                                <td valign="top">
                                            $<input type="text" class="amount" name="amount_monthly" value="<?= $doc['monthly_fee']; ?>" />
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
                                        <a href="#" onclick="$('#case_row_<?= $case['ledgerid'] ?>').remove(); calcTotal();">Remove</a>
                                </td>
				<td valign="top">
         				    $<input type="text" class="amount" name="amount_<?= $case['ledgerid'] ?>" value="195.00" />
				</td>
			</tr>
	<? 	}
		?>

<?php
	if($doc['user_type']==DSS_USER_TYPE_SOFTWARE){
                while($vob = mysql_fetch_array($vob_q))
                {
                ?>
                        <tr id="vob_row_<?= $vob['id'] ?>">
                                <td valign="top">
					Insurance Verification Services – <?= $vob['patient_firstname']." ".$vob['patient_lastname']; ?> 
                                </td>
                                <td valign="top">
                                        <input type="text" name="vob_date_completed_<?= $vob['id'] ?>" value="<?=date('m/d/Y', strtotime(st($vob["date_completed"])));?>" />
                                </td>
                                <td valign="top">
                                        <a href="#" onclick="$('#vob_row_<?= $vob['id'] ?>').remove(); calcTotal();">Remove</a>
                                </td>
                                <td valign="top">
                                            $<input type="text" class="amount" name="vob_amount_<?= $vob['id'] ?>" value="<?= $vob['invoice_amount']; ?>" />
                                </td>
                        </tr>
        <?      }
	}


			if($fax['total_faxes'] > 0){
                ?>
                        <tr id="fax_row">
                                <td valign="top">
                                        <input type="text" name="fax_desc" value="Faxes – <?= $fax['total_faxes']." at $".$doc['fax_fee']." each "; ?>" style="width:100%;" />
                                </td>
                                <td valign="top">
                                        <input type="text" name="fax_start_date" value="<?=date('m/d/Y', strtotime(st($fax["start_date"])));?>" />
to
                                        <input type="text" name="fax_end_date" value="<?=date('m/d/Y', strtotime(st($fax["end_date"])));?>" />
                                </td>
                                <td valign="top">
                                        <a href="#" onclick="$('#fax_row').remove(); calcTotal();">Remove</a>
                                </td>
                                <td valign="top">
                                            $<input type="text" class="amount" name="fax_amount" value="<?= $fax['total_faxes']*$doc['fax_fee']; ?>" />
                                </td>
                        </tr>
		<?php } ?>

		<tr id="total_row">
			<td valign="top" colspan="2">&nbsp;
			Total: <span id="total" style="font-weight:bold;">$<?= number_format((mysql_num_rows($case_q)*195)+695,2); ?></span>	
			<input type="hidden" name="extra_total" id="extra_total" value="0" />
			</td>
                        <td>
                                <a href="#" onclick="add_row()" style="padding:3px 5px;" class="button">Add Entry</a>
                        </td>

			<td valign="top" class="col_head">
				<input type="submit" name="submit" value=" Create Invoice " class="button" />
				<a href="manage_percase_invoice.php" style="margin-left:20px;color:#c33;">Cancel</a>
			</td>
		</tr>
</table>
</form>
<script type="text/javascript">

var row_count = 1;
function add_row(){

var row = '<tr id="extra_row_'+row_count+'">';
row += '<td valign="top">';
row += '<input type="text" name="extra_name_'+row_count+'" value="" />';
row += '</td><td valign="top">';
row += '<input type="text" name="extra_service_date_'+row_count+'" value="<?=date('m/d/Y');?>" />';
row += '</td><td valign="top">';
row += '<a href="#" onclick="$(\'#extra_row_'+row_count+'\').remove(); calcTotal();">Remove</a>';
row += '</td><td valign="top">';
row += '$<input type="text" class="amount" name="extra_amount_'+row_count+'" value="195.00" />';
row += '</td></tr>';


$('#extra_total').val(row_count);

$(row).insertBefore('#total_row');

row_count++;
setupAmount();
calcTotal();
}

function calcTotal(){
a = 0;
  $('.amount').each(function(){
    a += Number($(this).val());
  });
a = a.toFixed(2);
$('#total').html('$'+a);
}

function setupAmount(){
$('.amount').keyup(function(){
  calcTotal();
});
}

setupAmount();
calcTotal();
</script>

<br /><br />	
<? include "includes/bottom.htm";?>
