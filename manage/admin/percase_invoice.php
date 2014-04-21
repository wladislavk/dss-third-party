<? 
include "includes/top.htm";
include '../includes/calendarinc.php';
$case_sql = "SELECT * FROM dental_ledger dl 
		JOIN dental_patients dp ON dl.patientid=dp.patientid
	WHERE 
		dl.transaction_code='E0486' AND
		dl.docid='".$_REQUEST['docid']."' AND
		dl.percase_status = '".DSS_PERCASE_PENDING."'
";
$case_q = mysql_query($case_sql);

$efile_sql = "SELECT dp.firstname, dp.lastname, e.id, e.adddate FROM 
		dental_claim_electronic e
		JOIN dental_insurance i ON i.insuranceid=e.claimid
                JOIN dental_patients dp ON i.patientid=dp.patientid
        WHERE 
                i.docid='".$_REQUEST['docid']."' 
";
$efile_q = mysql_query($efile_sql);


$vob_sql = "SELECT * FROM dental_insurance_preauth p
                JOIN dental_patients dp ON p.patient_id=dp.patientid
        WHERE 
                p.doc_id='".$_REQUEST['docid']."' AND
                p.status = '".DSS_PREAUTH_COMPLETE."' AND
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


$ec_sql = "SELECT count(*) as total_ec, MIN(adddate) as start_date, MAX(adddate) as end_date FROM dental_eligibility e
        WHERE 
                e.userid='".$_REQUEST['docid']."'
";
$ec_q = mysql_query($ec_sql);
$ec = mysql_fetch_assoc($ec_q);

$enroll_sql = "SELECT count(*) as total_enrollments, MIN(adddate) as start_date, MAX(adddate) as end_date FROM dental_eligible_enrollment e
        WHERE 
                e.user_id='".$_REQUEST['docid']."'
";
$enroll_q = mysql_query($enroll_sql);
$enroll = mysql_fetch_assoc($enroll_q);

if(isset($_POST['submit'])){
    if(isset($_POST['amount_monthly'])){
      $in_sql = "INSERT INTO dental_percase_invoice (adminid, docid, adddate, ip_address, due_date, monthly_fee_date, monthly_fee_amount) " .
                " VALUES (".$_SESSION['adminuserid'].", ".$_POST['docid'].", NOW(), '".$_SERVER['REMOTE_ADDR']."', '".mysql_real_escape_string(date('Y-m-d', strtotime($_POST['due_date'])))."', '".mysql_real_escape_string(date('Y-m-d', strtotime($_POST['monthly_date'])))."', '".mysql_real_escape_string($_POST['amount_monthly'])."')";
    }else{
      $in_sql = "INSERT INTO dental_percase_invoice (adminid, docid, due_date, adddate, ip_address) " .
                " VALUES (".$_SESSION['adminuserid'].", ".$_POST['docid'].", '".mysql_real_escape_string(date('Y-m-d', strtotime($_POST['due_date'])))."', NOW(), '".$_SERVER['REMOTE_ADDR']."')";
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

  while($efile = mysql_fetch_assoc($efile_q)){
    $id = $efile['id'];
    if(isset($_POST['adddate_'.$id])){
      $up_sql = "UPDATE dental_claim_electronic SET " .
        " percase_date = '".date('Y-m-d', strtotime($_POST['adddate_'.$id]))."', " .
        " percase_name = '".mysql_real_escape_string($_POST['name_'.$id])."', " .
        " percase_amount = '".mysql_real_escape_string($_POST['amount_'.$id])."', " .
        " percase_status = '".DSS_PERCASE_INVOICED."', " .
        " percase_invoice = '".$invoiceid."' " .
        " WHERE id = '".$id."'";
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

    $up_sql = "UPDATE dental_faxes SET
		status = '1',
		fax_invoice_id = '".$fax_invoice_id."' 
		WHERE status='0' AND docid='".mysql_real_escape_string($_REQUEST['docid'])."'";
    mysql_query($up_sql);
  }


  if(isset($_POST['free_ec_desc'])){
    $ec_start_date = ($_POST['free_ec_start_date'])?date('Y-m-d', strtotime($_POST['ec_start_date'])):'';
    $ec_end_date = ($_POST['free_ec_end_date'])?date('Y-m-d', strtotime($_POST['ec_end_date'])):'';

    $in_sql = "INSERT INTO dental_eligibility_invoice SET
                invoice_id = '".mysql_real_escape_string($invoiceid)."',
                description = '".mysql_real_escape_string($_POST['free_ec_desc'])."',
                start_date = '".mysql_real_escape_string($free_ec_start_date)."',
                end_date = '".mysql_real_escape_string($free_ec_end_date)."',
                amount = '".mysql_real_escape_string($_POST['free_ec_amount'])."',
                adddate = now(),
                ip_address = '".$_SERVER['REMOTE_ADDR']."'";
    mysql_query($in_sql);
    $ec_invoice_id = mysql_insert_id();

    $up_sql = "UPDATE dental_eligibility SET
                eligibility_invoice_id = '".$ec_invoice_id."' 
                WHERE eligibility_invoice_id IS NULL AND userid='".mysql_real_escape_string($_REQUEST['docid'])."'";
    mysql_query($up_sql);
  }

  if(isset($_POST['ec_desc'])){
    $ec_start_date = ($_POST['ec_start_date'])?date('Y-m-d', strtotime($_POST['ec_start_date'])):'';
    $ec_end_date = ($_POST['ec_end_date'])?date('Y-m-d', strtotime($_POST['ec_end_date'])):'';

    $in_sql = "INSERT INTO dental_eligibility_invoice SET
                invoice_id = '".mysql_real_escape_string($invoiceid)."',
                description = '".mysql_real_escape_string($_POST['ec_desc'])."',
                start_date = '".mysql_real_escape_string($ec_start_date)."',
                end_date = '".mysql_real_escape_string($ec_end_date)."',
                amount = '".mysql_real_escape_string($_POST['ec_amount'])."',
                adddate = now(),
                ip_address = '".$_SERVER['REMOTE_ADDR']."'";
    mysql_query($in_sql);
    $ec_invoice_id = mysql_insert_id();

    $up_sql = "UPDATE dental_eligibility SET
                eligibility_invoice_id = '".$ec_invoice_id."' 
                WHERE eligibility_invoice_id IS NULL AND userid='".mysql_real_escape_string($_REQUEST['docid'])."'";
    mysql_query($up_sql);
  }





  if(isset($_POST['free_enrollment_desc'])){
    $enrollment_start_date = ($_POST['free_enrollment_start_date'])?date('Y-m-d', strtotime($_POST['free_enrollment_start_date'])):'';
    $enrollment_end_date = ($_POST['free_enrollment_end_date'])?date('Y-m-d', strtotime($_POST['free_enrollment_end_date'])):'';

    $in_sql = "INSERT INTO dental_enrollment_invoice SET
                invoice_id = '".mysql_real_escape_string($invoiceid)."',
                description = '".mysql_real_escape_string($_POST['free_enrollment_desc'])."',
                start_date = '".mysql_real_escape_string($free_enrollment_start_date)."',
                end_date = '".mysql_real_escape_string($free_enrollment_end_date)."',
                amount = '".mysql_real_escape_string($_POST['free_enrollment_amount'])."',
                adddate = now(),
                ip_address = '".$_SERVER['REMOTE_ADDR']."'";
    mysql_query($in_sql);
    $enrollment_invoice_id = mysql_insert_id();

    $up_sql = "UPDATE dental_eligible_enrollment SET
                fax_invoice_id = '".$enrollment_invoice_id."' 
                WHERE enrollment_invoice_id IS NULL AND user_id='".mysql_real_escape_string($_REQUEST['docid'])."'";
    mysql_query($up_sql);
  }

  if(isset($_POST['enrollment_desc'])){
    $enrollment_start_date = ($_POST['enrollment_start_date'])?date('Y-m-d', strtotime($_POST['enrollment_start_date'])):'';
    $enrollment_end_date = ($_POST['enrollment_end_date'])?date('Y-m-d', strtotime($_POST['enrollment_end_date'])):'';

    $in_sql = "INSERT INTO dental_enrollment_invoice SET
                invoice_id = '".mysql_real_escape_string($invoiceid)."',
                description = '".mysql_real_escape_string($_POST['enrollment_desc'])."',
                start_date = '".mysql_real_escape_string($enrollment_start_date)."',
                end_date = '".mysql_real_escape_string($enrollment_end_date)."',
                amount = '".mysql_real_escape_string($_POST['enrollment_amount'])."',
                adddate = now(),
                ip_address = '".$_SERVER['REMOTE_ADDR']."'";
    mysql_query($in_sql);
    $enrollment_invoice_id = mysql_insert_id();

    $up_sql = "UPDATE dental_eligible_enrollment SET
                enrollment_invoice_id = '".$enrollment_invoice_id."' 
                WHERE enrollment_invoice_id is NULL AND user_id='".mysql_real_escape_string($_REQUEST['docid'])."'";
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
<script src="popup/popup.js" type="text/javascript"></script>
<?php
  $doc_sql = "SELECT p.monthly_fee, p.fax_fee, p.free_fax, p.claim_fee, p.free_claim, p.eligibility_fee, p.free_eligibility, p.enrollment_fee, p.free_enrollment, vob_fee, free_vob, concat(u.first_name,' ',u.last_name) name, u.user_type
		FROM dental_users u
		JOIN dental_user_company uc ON uc.userid = u.userid
		JOIN companies c ON uc.companyid = c.id
 		JOIN dental_plans p ON p.id = u.plan_id
		WHERE u.userid='".mysql_real_escape_string($_REQUEST['docid'])."'";
  $doc_q = mysql_query($doc_sql);
if(mysql_num_rows($doc_q) == 0){
  //If no plan get company fees
  $doc_sql = "SELECT c.monthly_fee, c.fax_fee, c.free_fax, concat(u.first_name,' ',u.last_name) name, u.user_type
                FROM dental_users u
                JOIN dental_user_company uc ON uc.userid = u.userid
                JOIN companies c ON uc.companyid = c.id
                WHERE u.userid='".mysql_real_escape_string($_REQUEST['docid'])."'";
  $doc_q = mysql_query($doc_sql);

}
  $doc = mysql_fetch_assoc($doc_q);


?>	
<div class="page-header">
	<h2>Invoicing <small>- <?= $doc['name']; ?>	
</small></h2></div>
<br />


<div align="center" class="red">
	<b><? echo $_GET['msg'];?></b>
</div>
<br /><br />
<form name="sortfrm" action="<?=$_SERVER['PHP_SELF']?>" method="post">
<input type="hidden" name="docid" value="<?=$_GET["docid"];?>" />
<div class="input-group date pull-right">
Invoice Due Date: 
<input type="text" name="due_date" id="due_date" class="form-control text-center" value="<?=  date('m/d/Y', strtotime("+7 day")); ?>" />
			    <span class="input-group-addon">
                                <i class="glyphicon glyphicon-calendar"></i>
                            </span>
</div>
<div class="clearfix"></div>
<table id="invoice_table" class="table table-bordered table-hover">
	<tr>
		<th width="20%">
			Patient Name		
		</th>
		<th width="40%">
			Service Date	
		</th>
                <th width="10%">
                </th>
		<th width="20%">
			Amount		
		</th>
	</tr>
                        <tr id="month_row">
                                <td valign="top">
                                        MONTHLY FEE 
                                </td>
                                <td valign="top">
					<div class="input-group date">
                                        <input type="text" id="monthly_date" name="monthly_date" class="form-control text-center" value="<?=date('m/d/Y');?>" />
                            <span class="input-group-addon">
                                <i class="glyphicon glyphicon-calendar"></i>
                            </span>
                        </div>
                                </td>
                                <td valign="top">
                                        <a href="#" onclick="$('#month_row').remove(); calcTotal();" class="btn btn-danger">
                                            Remove
                                            <span class="glyphicon glyphicon-remove"></span>
                                        </a>
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
					<div class="input-group date">
					<input type="text" class="form-control text-center" name="service_date_<?= $case['ledgerid'] ?>" value="<?=date('m/d/Y', strtotime(st($case["service_date"])));?>" />
                            <span class="input-group-addon">
                                <i class="glyphicon glyphicon-calendar"></i>
                            </span>
                        </div>
				</td>
                                <td valign="top">
                                        <a href="#" onclick="$('#case_row_<?= $case['ledgerid'] ?>').remove(); calcTotal();" class="btn btn-danger">
                                            Remove
                                            <span class="glyphicon glyphicon-remove"></span>
                                        </a>
                                </td>
				<td valign="top">
         				    $<input type="text" class="amount" name="amount_<?= $case['ledgerid'] ?>" value="195.00" />
				</td>
			</tr>
	<? 	}
		?>



<?php
///// E File
                while($efile = mysql_fetch_array($efile_q))
                {
                ?>
                        <tr id="efile_row_<?= $efile['id'] ?>">
                                <td valign="top">
                                        <input type="text" name="name_<?= $efile['id'] ?>" value="E-File: <?=st($efile["firstname"]." ".$efile["lastname"]);?>" />
                                </td>
                                <td valign="top">
                                        <div class="input-group date">
                                        <input type="text" class="form-control text-center" name="adddate_<?= $efile['id'] ?>" value="<?=date('m/d/Y', strtotime(st($efile["adddate"])));?>" />
                            <span class="input-group-addon">
                                <i class="glyphicon glyphicon-calendar"></i>
                            </span>
                        </div>
                                </td>
                                <td valign="top">
                                        <a href="#" onclick="$('#efile_row_<?= $efile['id'] ?>').remove(); calcTotal();" class="btn btn-danger">
                                            Remove
                                            <span class="glyphicon glyphicon-remove"></span>
                                        </a>
                                </td>
                                <td valign="top">
                                            $<input type="text" class="amount" name="amount_<?= $efile['id'] ?>" value="<?= $doc['claim_fee']; ?>" />
                                </td>
                        </tr>
        <?      }
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
					<div class="input-group date">
                                        <input type="text" class="form-control text-center" name="vob_date_completed_<?= $vob['id'] ?>" value="<?=date('m/d/Y', strtotime(st($vob["date_completed"])));?>" />
                            <span class="input-group-addon">
                                <i class="glyphicon glyphicon-calendar"></i>
                            </span>
                        </div>
                                </td>
                                <td valign="top">
                                        <a href="#" onclick="$('#vob_row_<?= $vob['id'] ?>').remove(); calcTotal();" class="btn btn-danger">
                                            Remove
                                            <span class="glyphicon glyphicon-remove"></span>
                                        </a>
                                </td>
                                <td valign="top">
                                            $<input type="text" class="amount" name="vob_amount_<?= $vob['id'] ?>" value="<?= $doc['vob_fee']; ?>" />
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
					<div class="input-group date"> 
                                        <input type="text" class="form-control text-center" name="free_fax_start_date" value="<?=date('m/d/Y', strtotime(st($fax["start_date"])));?>" />
                            <span class="input-group-addon">
                                <i class="glyphicon glyphicon-calendar"></i>
                            </span>
					</div>
<div class="text-center">to</div>
				<div class="input-group date">
                                        <input type="text" class="form-control text-center" name="free_fax_end_date" value="<?=date('m/d/Y', strtotime(st($fax["end_date"])));?>" />
                            <span class="input-group-addon">
                                <i class="glyphicon glyphicon-calendar"></i>
                            </span>
                        </div>
                                </td>
                                <td valign="top">
                                        <a href="#" onclick="$('#free_fax_row').remove(); calcTotal();" class="btn btn-danger">
                                            Remove
                                            <span class="glyphicon glyphicon-remove"></span>
                                        </a>
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
                                        <a href="#" onclick="$('#fax_row').remove(); calcTotal();" class="btn btn-danger">
                                            Remove
                                            <span class="glyphicon glyphicon-remove"></span>
                                        </a>
                                </td>
                                <td valign="top">
                                            $<input type="text" class="amount" name="fax_amount" value="<?= $bill_faxes*$doc['fax_fee']; ?>" />
                                </td>
                        </tr>
			<?php } ?>
		<?php } ?>

<?php
                        if($ec['total_ec'] > 0){
                        $bill_ec = intval($ec['total_ec']) - intval($doc['free_eligibility']);
                        if($doc['free_eligibility'] > $ec['total_ec']){
                          $free_ec = $ec['total_ec'];
                        }else{
                          $free_ec = $doc['free_eligibility'];
                        } ?>
                        <tr id="free_ec_row">
                                <td valign="top">
                                        <input type="text" name="free_ec_desc" value="Free Eligibility – <?= $free_ec." at $0.00 each "; ?>" style="width:100%;" />
                                </td>
                                <td valign="top">
                                        <div class="input-group date">
                                        <input type="text" class="form-control text-center" name="free_ec_start_date" value="<?=date('m/d/Y', strtotime(st($ec["start_date"])));?>" />
                            <span class="input-group-addon">
                                <i class="glyphicon glyphicon-calendar"></i>
                            </span>
                                        </div>
<div class="text-center">to</div>
                                <div class="input-group date">
                                        <input type="text" class="form-control text-center" name="free_ec_end_date" value="<?=date('m/d/Y', strtotime(st($ec["end_date"])));?>" />
                            <span class="input-group-addon">
                                <i class="glyphicon glyphicon-calendar"></i>
                            </span>
                        </div>
                                </td>
                                <td valign="top">
                                        <a href="#" onclick="$('#free_ec_row').remove(); calcTotal();" class="btn btn-danger">
                                            Remove
                                            <span class="glyphicon glyphicon-remove"></span>
                                        </a>
                                </td>
                                <td valign="top">
                                            $<input type="text" class="amount" name="free_ec_amount" value="0.00" />
                                </td>
                        </tr>

                <?php
                        if($bill_ec > 0){
                ?>
                        <tr id="ec_row">
                                <td valign="top">
                                        <input type="text" name="ec_desc" value="Eligibility Checks – <?= $bill_ec." at $".$doc['eligibility_fee']." each "; ?>" style="width:100%;" />
                                </td>
                                <td valign="top">
				<div class="input-group date">	
                                        <input type="text" class="form-control text-center" name="ec_start_date" value="<?=date('m/d/Y', strtotime(st($ec["start_date"])));?>" />
                            <span class="input-group-addon">
                                <i class="glyphicon glyphicon-calendar"></i>
                            </span>
                        </div>
<div class="text-center">to</div>
				<div class="input-group date">
                                        <input type="text" class="form-control text-center" name="ec_end_date" value="<?=date('m/d/Y', strtotime(st($ec["end_date"])));?>" />
                            <span class="input-group-addon">
                                <i class="glyphicon glyphicon-calendar"></i>
                            </span>
                        </div>
                                </td>
                                <td valign="top">
                                        <a href="#" onclick="$('#ec_row').remove(); calcTotal();" class="btn btn-danger">
                                            Remove
                                            <span class="glyphicon glyphicon-remove"></span>
                                        </a>
                                </td>
                                <td valign="top">
                                            $<input type="text" class="amount" name="ec_amount" value="<?= $bill_ec*$doc['eligibility_fee']; ?>" />
                                </td>
                        </tr>
                        <?php } ?>
                <?php } ?>


<?php
                        if($enroll['total_enrollments'] > 0){
                        $bill_en = intval($enroll['total_enrollments']) - intval($doc['free_enrollments']);
                        if($doc['free_enrollments'] > $enroll['total_enrollments']){
                          $free_en = $enroll['total_enrollments'];
                        }else{
                          $free_en = $doc['free_enrollments'];
                        } ?>
                        <tr id="free_enrollment_row">
                                <td valign="top">
                                        <input type="text" name="free_enrollment_desc" value="Free Enrollments – <?= $free_en." at $0.00 each "; ?>" style="width:100%;" />
                                </td>
                                <td valign="top">
                                        <div class="input-group date">
                                        <input type="text" class="form-control text-center" name="free_enrollment_start_date" value="<?=date('m/d/Y', strtotime(st($enroll["start_date"])));?>" />
                            <span class="input-group-addon">
                                <i class="glyphicon glyphicon-calendar"></i>
                            </span>
                                        </div>
<div class="text-center">to</div>
                                <div class="input-group date">
                                        <input type="text" class="form-control text-center" name="free_enrollment_end_date" value="<?=date('m/d/Y', strtotime(st($enroll["end_date"])));?>" />
                            <span class="input-group-addon">
                                <i class="glyphicon glyphicon-calendar"></i>
                            </span>
                        </div>
                                </td>
                                <td valign="top">
                                        <a href="#" onclick="$('#free_enrollment_row').remove(); calcTotal();" class="btn btn-danger">
                                            Remove
                                            <span class="glyphicon glyphicon-remove"></span>
                                        </a>
                                </td>
                                <td valign="top">
                                            $<input type="text" class="amount" name="free_enrollment_amount" value="0.00" />
                                </td>
                        </tr>


                <?php
                        if($bill_en > 0){
                ?>
                        <tr id="enrollment_row">
                                <td valign="top">
                                        <input type="text" name="enrollment_desc" value="Enrollments – <?= $bill_en." at $".$doc['enrollment_fee']." each "; ?>" style="width:100%;" />
                                </td>
                                <td valign="top">
				<div class="input-group date">
                                        <input type="text" class="form-control text-center" name="enrollment_start_date" value="<?=date('m/d/Y', strtotime(st($enroll["start_date"])));?>" />
                            <span class="input-group-addon">
                                <i class="glyphicon glyphicon-calendar"></i>
                            </span>
                        </div>
<div class="text-center">to</div>
				<div class="input-group date">
                                        <input type="text" class="form-control text-center" name="enrollment_end_date" value="<?=date('m/d/Y', strtotime(st($enroll["end_date"])));?>" />
			    <span class="input-group-addon">
                                <i class="glyphicon glyphicon-calendar"></i>
                            </span>
                        </div>
                                </td>
                                <td valign="top">
                                        <a href="#" onclick="$('#enrollment_row').remove(); calcTotal();" class="btn btn-danger">
                                            Remove
                                            <span class="glyphicon glyphicon-remove"></span>
                                        </a>
                                </td>
                                <td valign="top">
                                            $<input type="text" class="amount" name="enrollment_amount" value="<?= $bill_en*$doc['enrollment_fee']; ?>" />
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
                                <a href="#" onclick="add_row()" class="btn btn-primary">
                                    Add Entry
                                    <span class="glyphicon glyphicon-plus"></span>
                                </a>
                        </td>

			<td valign="top" class="col_head">
				<input type="submit" name="submit" value="Create Invoice" class="btn btn-primary">
				<a href="manage_percase_invoice.php" class="btn btn-danger">
                    Cancel
                    <span class="glyphicon glyphicon-remove"></span>
                </a>
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
row += '<a href="#" onclick="$(\'#extra_row_'+row_count+'\').remove(); calcTotal();" class="btn btn-danger">Remove <span class="glyphicon glyphicon-remove"></span></a>';
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
