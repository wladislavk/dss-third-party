<? 
include "includes/top.htm";
  require_once '../3rdParty/stripe/lib/Stripe.php';
include '../includes/calendarinc.php';

  $sql = "SELECT du.*, c.name AS company_name, c.free_fax,
                (SELECT i2.monthly_fee_date FROM dental_percase_invoice i2 WHERE i2.docid=du.userid ORDER BY i2.monthly_fee_date DESC LIMIT 1) as last_monthly_fee_date
                FROM dental_users du 
                JOIN dental_user_company uc ON uc.userid = du.userid
                JOIN companies c ON c.id=uc.companyid
                WHERE du.docid=0
AND 
                ((SELECT i2.monthly_fee_date FROM dental_percase_invoice i2 WHERE i2.docid=du.userid ORDER BY i2.monthly_fee_date DESC LIMIT 1) < DATE_SUB(now(), INTERVAL 1 MONTH) OR 
                        ((SELECT i2.monthly_fee_date FROM dental_percase_invoice i2 WHERE i2.docid=du.userid ORDER BY i2.monthly_fee_date DESC LIMIT 1) IS NULL AND du.adddate < DATE_SUB(now(), INTERVAL 1 MONTH)))
 ";
  if(isset($_GET['company']) && $_GET['company'] != ""){
    	$sql .= " AND c.id='".mysql_real_escape_string($_GET['company'])."' ";
  }
  if(isset($_GET['uid']) && $_GET['uid'] != ""){
        $sql .= " AND du.userid > '".mysql_real_escape_string($_GET['uid'])."' ";
  }
  if(isset($_GET['show']) && $_GET['show']=='all'){
   	$sql .= " ORDER BY du.userid ASC ";
  }else{
	$sql .= " AND 
                ((SELECT COUNT(*) AS num_trxn FROM dental_ledger dl 
                        JOIN dental_patients dp ON dl.patientid=dp.patientid
                        WHERE 
                                dl.transaction_code='E0486' AND
                                dl.docid=du.userid AND
                                dl.percase_status = '".DSS_PERCASE_PENDING."') != 0 OR 
                (SELECT count(*) as total_faxes FROM dental_faxes f
                        WHERE 
                f.docid='".$_REQUEST['docid']."' AND
                f.status = '0') >  c.free_fax OR
                (SELECT COUNT(*) FROM dental_insurance_preauth p
                JOIN dental_patients dp ON p.patient_id=dp.patientid
                        WHERE 
                p.doc_id='".$_REQUEST['docid']."' AND
                p.invoice_status = '".DSS_PERCASE_PENDING."') != 0
		)
		ORDER BY du.userid ASC
                ";
  }

$count_q = mysql_query($sql);
$num_docs = mysql_num_rows($count_q);

$sql .= " limit 1";
$q = mysql_query($sql) or die(mysql_error());
$count_invoices = (isset($_GET['ci']) && $_GET['ci']!='')?$_GET['ci']:$num_docs;
$count_current = (isset($_GET['cc']) && $_GET['cc']!='')?$_GET['cc']:1;
if($num_docs == 0){
  ?>
    <script type="text/javascript">
      window.location = "manage_monthly_invoice.php";
    </script>
  <?php
}
$user = mysql_fetch_assoc($q);


$case_sql = "SELECT * FROM dental_ledger dl 
		JOIN dental_patients dp ON dl.patientid=dp.patientid
	WHERE 
		dl.transaction_code='E0486' AND
		dl.docid='".$user['userid']."' AND
		dl.percase_status = '".DSS_PERCASE_PENDING."'
";
$case_q = mysql_query($case_sql);

$vob_sql = "SELECT * FROM dental_insurance_preauth p
                JOIN dental_patients dp ON p.patient_id=dp.patientid
        WHERE 
                p.doc_id='".$user['userid']."' AND
                p.invoice_status = '".DSS_PERCASE_PENDING."'
";
$vob_q = mysql_query($vob_sql);

$fax_sql = "SELECT count(*) as total_faxes, MIN(sent_date) as start_date, MAX(sent_date) as end_date FROM dental_faxes f
        WHERE 
                f.docid='".$user['userid']."' AND
                f.status = '0'
";
$fax_q = mysql_query($fax_sql);
$fax = mysql_fetch_assoc($fax_q);

if(isset($_POST['submit'])){
    if(isset($_POST['amount_monthly'])){
      $in_sql = "INSERT INTO dental_percase_invoice (adminid, docid, adddate, ip_address, monthly_fee_date, monthly_fee_amount) " .
                " VALUES (".$_SESSION['adminuserid'].", ".$_POST['docid'].", NOW(), '".$_SERVER['REMOTE_ADDR']."', '".mysql_real_escape_string(date('Y-m-d', strtotime($_POST['monthly_date'])))."', '".mysql_real_escape_string($_POST['amount_monthly'])."')";
	$total_amount = $_POST['amount_monthly'];
    }else{
      $in_sql = "INSERT INTO dental_percase_invoice (adminid, docid, adddate, ip_address) " .
                " VALUES (".$_SESSION['adminuserid'].", ".$_POST['docid'].", NOW(), '".$_SERVER['REMOTE_ADDR']."')";
	$total_amount += 0;
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
	$total_amount += $_POST['amount_'.$id];
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
	$total_amount += $_POST['vob_amount_'.$id];
    }
  }

  if(isset($_POST['free_fax_desc'])){
    $fax_start_date = ($_POST['free_fax_start_date'])?date('Y-m-d', strtotime($_POST['fax_start_date'])):'';
    $fax_end_date = ($_POST['free_fax_end_date'])?date('Y-m-d', strtotime($_POST['fax_end_date'])):'';

    $in_sql = "INSERT INTO dental_fax_invoice SET
                invoice_id = '".mysql_real_escape_string($invoiceid)."',
                description = '".mysql_real_escape_string($_POST['free_fax_desc'])."',
                start_date = '".mysql_real_escape_string($free_fax_start_date)."',
                end_date = '".mysql_real_escape_string($free_fax_end_date)."',
                amount = '".mysql_real_escape_string($_POST['free_fax_amount'])."',
                adddate = now(),
                ip_address = '".$_SERVER['REMOTE_ADDR']."'";
    mysql_query($in_sql);
    $fax_invoice_id = mysql_insert_id();
	$total_amount += $_POST['free_fax_amount'];
    $up_sql = "UPDATE dental_faxes SET
                status = '1',
                fax_invoice_id = '".$fax_invoice_id."' 
                WHERE status='0' AND docid='".mysql_real_escape_string($_REQUEST['docid'])."'";
    mysql_query($up_sql);
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
    $total_amount += $_POST['fax_amount'];

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
      $total_amount += $amount;
    }
  }


        if(isset($_GET['bill']) && $_GET['bill']=="1"){
                if($user['cc_id']!=''){
                  bill_card($user['cc_id'] ,$total_amount, $user['userid'], $invoiceid);
                }else{
		    $charge_sql = "INSERT INTO dental_charge SET
                        amount='".mysql_real_escape_string(str_replace(',','',$total_amount))."',
                        userid='".mysql_real_escape_string($user['userid'])."',
                        adminid='".mysql_real_escape_string($_SESSION['adminuserid'])."',
                        charge_date=NOW(),
                        status='2',
                        adddate=NOW(),
                        ip_address='".mysql_real_escape_string($_SERVER['REMOTE_ADDR'])."'";
        		mysql_query($charge_sql);
                     $i_sql = "UPDATE dental_percase_invoice set status=2 WHERE id='".$invoiceid."'";
                        mysql_query($i_sql);
                  ?>
                    <script type="text/javascript">
                      alert('<?= $user['first_name']." ".$user['last_name']; ?> does not have a credit card on record.');
                    </script>
                  <?php
                }

        }


  $_GET['invoice_id'] = $invoiceid;
  $redirect = false;
  include 'percase_invoice_pdf.php';
  ?>
  <script type="text/javascript">
    window.location = 'invoice_additional.php?show=<?=$_GET['show'];?>&bill=<?= $_GET['bill']; ?><?= (isset($_GET['company']) && $_GET['company'] != "")?"&company=".$_GET['company']:""; ?>&uid=<?= $user['userid']; ?>&cc=<?= ($count_current+1); ?>&ci=<?= $count_invoices; ?>';
    //window.location = 'percase_invoice_pdf.php?invoice_id=<?= $invoiceid; ?>';
  </script>
  <?php

}

?>
<link rel="stylesheet" href="popup/popup.css" type="text/css" media="screen" />
<script src="popup/jquery-1.2.6.min.js" type="text/javascript"></script>
<script src="popup/popup.js" type="text/javascript"></script>
<?php
  $doc_sql = "SELECT c.monthly_fee, c.fax_fee, c.free_fax, u.name, u.user_type
		FROM dental_users u
		JOIN dental_user_company uc ON uc.userid = u.userid
		JOIN companies c ON uc.companyid = c.id
		WHERE u.userid='".mysql_real_escape_string($user['userid'])."'";
  $doc_q = mysql_query($doc_sql);
  $doc = mysql_fetch_assoc($doc_q);

        if($user['last_monthly_fee_date']){
          $date = $user['last_monthly_fee_date'];
          $newdate = strtotime ( '+1 month' , strtotime ( $date ) ) ;
          $monthly_date = date ( 'm/d/Y' , $newdate );
        }elseif($user['registration_date']){
          $date = $user['registration_date'];
          $newdate = strtotime ( '+1 month' , strtotime ( $date ) ) ;
          $monthly_date = date ( 'm/d/Y' , $newdate );
        }elseif($user['adddate']){
          $date = $user['adddate'];
          $newdate = strtotime ( '+1 month' , strtotime ( $date ) ) ;
          $monthly_date = date ( 'm/d/Y' , $newdate );
        }else{
          $monthly_date = date('m/d/Y');
        }


?>
<span class="admin_head">
	Invoicing - <?= $doc['name']; ?>	
</span>
<br />


<div align="center" class="red">
	<b><? echo $_GET['msg'];?></b>
</div>
<br /><br />
<div style=" margin:0 10px;border: solid 1px #000;">
<h3><?= $count_current; ?> of <?= $count_invoices; ?></h3>

<form name="sortfrm" id="invoice" action="<?=$_SERVER['PHP_SELF']?>?show=<?=$_GET['show']; ?>&company=<?=$_GET['company'];?>&bill=<?=$_GET['bill'];?>&uid=<?=$_GET['uid'];?>&cc=<?= ($count_current); ?>&ci=<?= $count_invoices; ?>" method="post">
<input type="hidden" name="docid" value="<?=$user["userid"];?>" />
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
                                        <input type="text" id="monthly_date" name="monthly_date" class="calendar" value="<?=$monthly_date;?>" />
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
			$bill_faxes = intval($fax['total_faxes']) - intval($doc['free_fax']);
			if($doc['free_fax'] > $fax['total_faxes']){
			  $free_fax = $fax['total_faxes'];
			}else{
			  $free_fax = $doc['free_fax'];
			} ?>
                        <tr id="free_fax_row">
                                <td valign="top">
                                        <input type="text" name="free_fax_desc" value="Free Faxes – <?= $free_fax." at $0.00 each "; ?>" style="width:100%;" />
                                </td>
                                <td valign="top">
                                        <input type="text" name="free_fax_start_date" value="<?=date('m/d/Y', strtotime(st($fax["start_date"])));?>" />
to
                                        <input type="text" name="free_fax_end_date" value="<?=date('m/d/Y', strtotime(st($fax["end_date"])));?>" />
                                </td>
                                <td valign="top">
                                        <a href="#" onclick="$('#free_fax_row').remove(); calcTotal();">Remove</a>
                                </td>
                                <td valign="top">
                                            $<input type="text" class="amount" name="free_fax_amount" value="0.00" />
                                </td>
                        </tr>


		<?php
			if($bill_faxes > 0){
                ?>
                        <tr id="fax_row">
                                <td valign="top">
                                        <input type="text" name="fax_desc" value="Faxes – <?= $bill_faxes." at $".$doc['fax_fee']." each "; ?>" style="width:100%;" />
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
                                            $<input type="text" class="amount" name="fax_amount" value="<?= $bill_faxes*$doc['fax_fee']; ?>" />
                                </td>
                        </tr>
			<?php } ?>
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
				<a href="manage_monthly_invoice.php" style="margin-left:20px;color:#c33;">Cancel</a>
				<a href="invoice_additional.php?show=<?=$_GET['show'];?>&bill=<?= $_GET['bill']; ?><?= (isset($_GET['company']) && $_GET['company'] != "")?"&company=".$_GET['company']:""; ?>&uid=<?= $user['userid']; ?>&cc=<?= ($count_current+1); ?>&ci=<?= $count_invoices; ?>" style="margin-left:20px;color:#c33;">Skip</a>
			</td>
		</tr>
</table>
</form>
</div>
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

//START OF FEATURE TO CHECK AND MAKE SURE ITEMS HAVENT ALREADY BEEN BILLED
function check_billed(){
 f = $('#invoice').serialize();
 $.ajax({
   url: "includes/check_billed.php",
   type: "post",
   data: f,
   success: function(data){
     alert(data);
     var r = $.parseJSON(data);
     if(r.error){
     }else{
     }
   },
   failure: function(data){
     //alert('fail');
   }
 });
 return false;
}






</script>

<br /><br />	
<? include "includes/bottom.htm";?>


<?php
function bill_card($customerID, $amount, $userid, $invoiceid){
$key_sql = "SELECT stripe_secret_key FROM companies c 
                JOIN dental_user_company uc
                        ON c.id = uc.companyid
                 WHERE uc.userid='".mysql_real_escape_string($userid)."'";
$key_q = mysql_query($key_sql);
$key_r= mysql_fetch_assoc($key_q);
Stripe::setApiKey($key_r['stripe_secret_key']);
$status = 1;
try{
    $charge = Stripe_Charge::create(array(
      "amount" => $amount, # $15.00 this time
      "currency" => "usd",
      "customer" => $customerID)
    );
} catch(Stripe_CardError $e) {
  $invoice_sql = "UPDATE dental_percase_invoice SET
                        status=2
                        WHERE id='".mysql_real_escape_string($invoiceid)."'";
  mysql_query($invoice_sql);
  $status = 2;
} catch (Stripe_InvalidRequestError $e) {
  $invoice_sql = "UPDATE dental_percase_invoice SET
                        status=2
                        WHERE id='".mysql_real_escape_string($invoiceid)."'";
  mysql_query($invoice_sql);
  $status = 2;
} catch (Stripe_AuthenticationError $e) {
  $invoice_sql = "UPDATE dental_percase_invoice SET
                        status=2
                        WHERE id='".mysql_real_escape_string($invoiceid)."'";
  mysql_query($invoice_sql);
  $status = 2;
} catch (Stripe_ApiConnectionError $e) {
  $invoice_sql = "UPDATE dental_percase_invoice SET
                        status=2
                        WHERE id='".mysql_real_escape_string($invoiceid)."'";
  mysql_query($invoice_sql);
  $status = 2;
} catch (Stripe_Error $e) {
  $invoice_sql = "UPDATE dental_percase_invoice SET
                        status=2
                        WHERE id='".mysql_real_escape_string($invoiceid)."'";
  mysql_query($invoice_sql);
  $status = 2;
} catch (Exception $e) {
  $invoice_sql = "UPDATE dental_percase_invoice SET
                        status=2
                        WHERE id='".mysql_real_escape_string($invoiceid)."'";
  mysql_query($invoice_sql);
  $status = 2;
}

  $stripe_charge = $charge->id;
  $stripe_customer = $charge->customer;
  $stripe_card_fingerprint = $charge->card->fingerprint;
  $charge_sql = "INSERT INTO dental_charge SET
                        amount='".mysql_real_escape_string(str_replace(',','',$amount))."',
                        userid='".mysql_real_escape_string($userid)."',
                        adminid='".mysql_real_escape_string($_SESSION['adminuserid'])."',
                        charge_date=NOW(),
                        stripe_customer='".mysql_real_escape_string($stripe_customer)."',
                        stripe_charge='".mysql_real_escape_string($stripe_charge)."',
                        stripe_card_fingerprint='".mysql_real_escape_string($stripe_card_fingerprint)."',
			status='".mysql_real_escape_string($status)."',
                        adddate=NOW(),
                        ip_address='".mysql_real_escape_string($_SERVER['REMOTE_ADDR'])."'";
        mysql_query($charge_sql);
  if($status == 1){
  $invoice_sql = "UPDATE dental_percase_invoice SET
                        status=1
                        WHERE id='".mysql_real_escape_string($invoiceid)."'";
  mysql_query($invoice_sql);
  }
  return true;

}



