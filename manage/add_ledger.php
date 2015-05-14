<?php namespace Ds3\Libraries\Legacy; ?><?php 
	include_once('admin/includes/main_include.php');
	include_once('includes/constants.inc');
	include_once('includes/claim_functions.php');
	include("includes/sescheck.php");
?>
	<script type="text/javascript" src="/manage/admin/script/jquery-1.6.2.min.js"></script>
	<script type="text/javascript" src="/manage/3rdParty/input_mask/jquery.maskedinput-1.3.min.js"></script>
	<script type="text/javascript" src="/manage/js/masks.js"></script>
<?php
	include("includes/calendarinc.php");
	include("includes/preauth_functions.php");

	$flowquery = "SELECT * FROM dental_flow_pg1 WHERE pid='".(!empty($_GET['pid']) ? $_GET['pid'] : '')."' LIMIT 1;";

    $flow = $db->getRow($flowquery);
    $copyreqdate = $flow['copyreqdate'];
    $referred_by = $flow['referred_by'];
    $referreddate = $flow['referreddate'];
    $thxletter = $flow['thxletter'];
    $queststartdate = $flow['queststartdate'];
    $questcompdate = $flow['questcompdate'];
    $insinforec = $flow['insinforec'];
    $rxreq = $flow['rxreq'];
    $rxrec = $flow['rxrec'];
    $lomnreq = $flow['lomnreq'];
    $lomnrec = $flow['lomnrec'];
    $contact_location = $flow['contact_location'];
    $questsendmeth = $flow['questsendmeth'];
    $questsender = $flow['questsender'];
    $refneed = $flow['refneed'];
    $refneeddate1 = $flow['refneeddate1'];
    $refneeddate2 = $flow['refneeddate2'];
    $preauth = $flow['preauth'];
    $preauth1 = $flow['preauth1'];
    $preauth2 = $flow['preauth2'];
    $insverbendate1 = $flow['insverbendate1'];

	if(!empty($_POST["ledgerub"]) && $_POST["ledgerub"] == 1) {
		$service_date = $_POST['service_date'];
		$entry_date = $_POST['entry_date'];
		$description = $_POST['description'];
		$amount = str_replace(',','',$_POST['amount']);
		$paid_amount = str_replace(',', '',$_POST['paid_amount']);
		$transaction_type = $_POST['transaction_type'];
		$transaction_code = $_POST['transaction_code'];
	    $status = (isset($_POST['status'])) ? DSS_TRXN_PENDING : DSS_TRXN_NA;
		if(strpos($service_date,'-') === false) {
			$s_arr = explode('/',$service_date);
			$service_date = $s_arr[2]."-".$s_arr[0]."-".$s_arr[1];
		} else {
			$s_arr = explode('-',$service_date);
			$service_date = $s_arr[2]."-".$s_arr[0]."-".$s_arr[1];
		}
		
		if(strpos($entry_date,'-') === false) {
			$e_arr = explode('/',$entry_date);
			$entry_date = $e_arr[2]."-".$e_arr[0]."-".$e_arr[1];
		} else {
			$e_arr = explode('-',$entry_date);
			$entry_date = $e_arr[2]."-".$e_arr[0]."-".$e_arr[1];
		}
	
		if($transaction_type == 'Entry') {
			$paid_amount = 0;
		} else {
		}
	
		if($_POST['ed'] == '') {
			$ins_sql = " insert into dental_ledger set 
			patientid = '".s_for($_GET['pid'])."',
			service_date = '".s_for($service_date)."',
			entry_date = '".s_for($entry_date)."',
			description = '".s_for($description)."',
			amount = '".s_for($amount)."',
			paid_amount = '".s_for($paid_amount)."',
			transaction_type = '".s_for($transaction_type)."',
			userid = '".s_for($_SESSION['userid'])."',
			docid = '".s_for($_SESSION['docid'])."',
			transaction_code = '".s_for($transaction_code)."',
			adddate = now(),
			ip_address = '".s_for($_SERVER['REMOTE_ADDR'])."'";
		
		$ledgerid = $db->getInsertId($ins_sql);
		// ledger_history_update($ledger_id, $_SESSION['userid'],'');		
		
		$ins_sql_rec = " insert into dental_ledger_rec set 
			userid = '".s_for($_SESSION['userid'])."',
	    	patientid = '".s_for($_GET['pid'])."',
			service_date = '".s_for($service_date)."',
			description = '".s_for($description)."',
			amount = '".s_for($amount)."',
			paid_amount = '".s_for($paid_amount)."',
			transaction_code = '".s_for($transaction_code)."',
			transaction_type = '".s_for($transaction_type)."',
			ip_address = '".s_for($_SERVER['REMOTE_ADDR'])."'";
		
		$db->query($ins_sql_rec);
		$msg = "Added Successfully";
?>
		<script type="text/javascript">
			parent.window.location = 'manage_ledger.php?msg=<?php echo $msg;?>&pid=<?php echo $_GET['pid'];?>';
		</script>
<?php
		trigger_error("Die called", E_USER_ERROR);
		} else {
		$pat_sql2 = "select * from dental_patients where patientid='".s_for($_GET['pid'])."'";
    	$pat_my2 = $db->getResults($pat_sql2);

    	if ($pat_my2) foreach ($pat_my2 as $pat_myarray2) {
		    $pat_sql3 = $db->query("INSERT INTO dental_ledger_rec (userid, patientid, service_date, description, amount, paid_amount,transaction_code, ip_address, transaction_type) VALUES ('".$_SESSION['username']."','".(!empty($_GET['pid']) ? $_GET['pid'] : '')."','".(!empty($pat_myarray2['service_date']) ? $pat_myarray2['service_date'] : '')."','".(!empty($pat_myarray2['description']) ? $pat_myarray2['description'] : '')."','".(!empty($pat_myarray2['amount']) ? $pat_myarray2['amount'] : '')."','".(!empty($pat_myarray2['paid_amount']) ? $pat_myarray2['paid_amount'] : '')."','".(!empty($pat_myarray2['transaction_code']) ? $pat_myarray2['transaction_code'] : '')."','".(!empty($pat_myarray2['ip_address']) ? $pat_myarray2['ip_address'] : '')."','".(!empty($pat_myarray2['transaction_type']) ? $pat_myarray2['transaction_type'] : '')."');");
		    if(!$pat_sql3){
		    	echo "There was an error updating the ledger record.  Please contact your system administrator.";
		    }
   
			$service_date = date('Y-m-d', strtotime((!empty($_POST['service_date']) ? $_POST['service_date'] : '')));
			$entry_date = date('Y-m-d', strtotime((!empty($_POST['entry_date']) ? $_POST['entry_date'] : '')));
			$transaction_type = (!empty($_POST['transaction_type']) ? $_POST['transaction_type'] : '');
			$transaction_code = (!empty($_POST['proccode']) ? $_POST['proccode'] : '');
			
			$tsql = "SELECT transaction_code, description from dental_transaction_code where transaction_codeid = '" . $transaction_code . "'";
			
			$trow = $db->getRow($tsql);
			$transaction_code = $trow['transaction_code'];
			$description = $trow['description'];
			$status = (isset($_POST['status'])) ? DSS_TRXN_PENDING : DSS_TRXN_NA;
			$amount = str_replace(',','',$_POST['amount']);
			$paid_amount = str_replace(',','',$_POST['paid_amount']);
			$claim_sql = "SELECT * FROM dental_ledger where ledgerid='".$_POST["ed"]."'";
			
			$claim_r = $db->getRow($claim_sql);
			if(($claim_r['primary_claim_id']=='' || $claim_r['primary_claim_id']==0) && $status==DSS_TRXN_PENDING){
				$pf_sql = "SELECT producer_files FROM dental_users WHERE userid='".mysqli_real_escape_string($con,$claim_r['producerid'])."'";
				
				$pf = $db->getRow($pf_sql);
				if($pf['producer_files'] == '1'){
					$claim_producer = $claim_r['producerid'];
				} else {
					$claim_producer = $_SESSION['docid'];
				}

				$s = "SELECT insuranceid from dental_insurance where producer='".$claim_producer."' AND patientid='".mysqli_real_escape_string($con,$_GET['pid'])."' AND status='".DSS_CLAIM_PENDING."' LIMIT 1";
				
				$q = $db->getResults($s);
				$n = count($q);
				if($n > 0){
				    $r = $q[0];
				    $claim_id = $r['insuranceid'];
				} else {
				    $claim_id = create_claim($_GET['pid'], $claim_producer);
				}
			} else {
  				$claim_id = $claim_r['primary_claim_id'];
			}

			if($status == DSS_TRXN_NA) {
			  $claim_id = '';
			}
			
			$up_sql = "update dental_ledger set
			    	   service_date = '".s_for($service_date)."',
					   entry_date = '".s_for($entry_date)."',
					   description = '".s_for($description)."',
					   amount = '".s_for($amount)."',
					   paid_amount = '".s_for($paid_amount)."',
			           transaction_type = '".s_for($transaction_type)."',
					   transaction_code = '".s_for($transaction_code)."',
					   userid = '".s_for($_SESSION['userid'])."',
			           status = ". s_for($status).",
					   primary_claim_id='".$claim_id."'
				 	   where ledgerid='".$_POST["ed"]."'";
					
			$db->query($up_sql);
			// ledger_history_update($_POST['ed'], $_SESSION['docid'], '');
			if(($claim_r['primary_claim_id']!='' && $claim_r['primary_claim_id']!=0) && $status==DSS_TRXN_NA){
			  $c_sql = "SELECT COUNT(*) as num_trxn FROM dental_ledger where primary_claim_id='".mysqli_real_escape_string($con,$claim_r['primary_claim_id'])."'";
			  
			  $c_r = $db->getRow($c_sql);
			  if($c_r['num_trxn'] == 0) {
				$del_sql = "DELETE FROM dental_insurance where insuranceid='".mysqli_real_escape_string($con,$claim_r['primary_claim_id'])."'";
				$db->query($del_sql);
			  }
			}

			$msg = "Edited Successfully";
?>
			<script type="text/javascript">
				parent.window.location = 'manage_ledger.php?msg=<?php echo $msg;?>&pid=<?php echo $_GET['pid'];?>';
			</script>
<?php
			trigger_error("Die called", E_USER_ERROR);
			}
		}
	}
	$pat_sql = "select * from dental_patients where patientid='".s_for($_GET['pid'])."'";

	$pat_myarray = $db->getRow($pat_sql);
	$name = st($pat_myarray['lastname'])." ".st($pat_myarray['middlename'])." ".st($pat_myarray['firstname']);
	if($pat_myarray['patientid'] == '') {
?>
		<script type="text/javascript">
			window.location = 'manage_patient.php';
		</script>
<?php
		trigger_error("Die called", E_USER_ERROR);
	}
?>

<script type="text/javascript" src="js/add_ledger.js"></script>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<link href="css/admin.css" rel="stylesheet" type="text/css" />
		<script language="javascript" type="text/javascript" src="script/validation.js"></script>
		<script language="JavaScript" src="calendar1.js"></script>
		<script language="JavaScript" src="calendar2.js"></script>
		<link rel="stylesheet" href="css/form.css" type="text/css" />
		<script type="text/javascript" src="script/wufoo.js"></script>
		<script type="text/javascript">
		</script>
	</head>

	<body>
    	<?php
			$sql = "select sum(amount) as amt, sum(paid_amount) as p_amt from dental_ledger where patientid='".$_REQUEST["pid"]."'";
			
			$myarray = $db->getRow($sql);
			$cur_balance = $myarray['amt'] - $myarray['p_amt'];
  			$thesql = "select * from dental_ledger where ledgerid='".$_REQUEST["ed"]."'";
			
			$themyarray = $db->getRow($thesql);
			$service_date = st($themyarray['service_date']);
			$entry_date = st($themyarray['entry_date']);
			$description = st($themyarray['description']);
			$amount = st($themyarray['amount']);
			$paid_amount = st($themyarray['paid_amount']);
        	$transaction_code = st($themyarray['transaction_code']);
        	$tsql = "SELECT type FROM dental_transaction_code WHERE docid=".$_SESSION['docid']." AND transaction_code='".$transaction_code."'"; 
        
	        $trow = $db->getRow($tsql);
	        $transaction_type = $trow['type'];
	        $status = ($themyarray['primary_claim_id']!=0 && $themyarray['primary_claim_id']!='')?DSS_TRXN_PENDING:DSS_TRXN_NA;//st($themyarray['status']);	
			$but_text = "Add ";
	
			if($service_date == '') {
				$service_date = date('m/d/Y');
			} else {
				$service_date = date('m/d/Y',strtotime($service_date));
			}
	
			if($entry_date == '') {
				$entry_date = date('m/d/Y');
			} else {
				$entry_date = date('m/d/Y',strtotime($entry_date));
			}
	
			if($transaction_type == '')
			{
				//$transaction_type = 'Entry';
			}
	
	
			if($themyarray["userid"] != '') {
				$but_text = "Edit ";
			} else {
				$but_text = "Add ";
			}
		?>
		<br /><br />
	
		<?php if($msg != '') { ?>
		    <div align="center" class="red">
		        <?php echo $msg;?>
		    </div>
	    <?php } ?>

	    <?php 
			$tcode_sql = "select * from dental_transaction_code where status=1 AND docid=".$_SESSION['docid']." order by sortby";
			
			$tcode_my = $db->getResults($tcode_sql);
			$transactionCodeStr = "";
			$descriptionStr = "";
			if ($tcode_my) foreach ($tcode_my as $tcode_myarray) {
				$transactionCodeStr .= st($tcode_myarray['transaction_codeid']) . ',';
				$descriptionStr .= st($tcode_myarray['description']) . ',';
			}
			$transactionCodeStr = trim($transactionCodeStr, ',');
			$descriptionStr = trim($descriptionStr, ',');
		?>

		<script>
			//Example of use
			//change_t_code("<?php echo $transactionCodeStr; ?>", "<?php echo $descriptionStr; ?>");
		</script>

	    <form name="ledgerfrm" action="<?php echo $_SERVER['PHP_SELF'];?>?add=1&pid=<?php echo $_GET['pid']?>" method="post" onSubmit="return addledgerabc(this)">
		    <table cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center">
		        <tr>
		            <td colspan="2" class="cat_head">
		               <?php echo $but_text?> Transaction
					   -
		    			Patient <i><?php echo $name;?></i>
		            </td>
		        </tr>
				<tr>
		        	<td valign="top" class="frmdata" colspan="2" style="text-align:right;">
						<span class="red">
							Current Balance: 
							<b>$<?php echo number_format($cur_balance,2);?></b>
						</span>
		            </td>
		        </tr>
		        <tr>
		        	<td valign="top" class="frmhead" width="30%">
						Service Date
		            </td>
		        	<td valign="top" class="frmdata">
						<input id="service_date" name="service_date" type="text" class="tbox calendar" value="<?php echo $service_date;?>" style="width:100px;" maxlength="255"/> (mm/dd/yyyy)
		                 <script type="text/javascript">
		                     var cal = new calendar2(document.getElementById('service_date'));
		                 </script>
						<span class="red">*</span>
		            </td>
		        </tr>
		        <tr>
		        	<td valign="top" class="frmhead">
						Entry Date
		            </td>
		        	<td valign="top" class="frmdata">
						<input id="entry_date" name="entry_date" type="text" class="tbox" value="<?php echo $entry_date;?>" style="width:100px;" maxlength="255" readonly="readonly"/> (mm/dd/yyyy)
						<span class="red">*</span>
		            </td>
		        </tr>
		        <tr>
		            <td valign="top" class="frmhead">
		                Posted By 
		            </td>
		            <td valign="top" class="frmdata">
						<?php
							$h_sql = "SELECT h.updated_at, CONCAT(u.first_name,' ',u.last_name) doc_name,
									  CONCAT(a.first_name,' ',a.last_name) admin_name
									  FROM dental_ledger_history h 
								 	  LEFT JOIN dental_users u ON u.userid=h.updated_by_user
									  LEFT JOIN admin a ON a.adminid=h.updated_by_admin
									  WHERE h.ledgerid='".mysqli_real_escape_string($con,$_GET['ed'])."' ORDER BY h.updated_at ASC LIMIT 1";
							
							$h_r = $db->getRow($h_sql);
							if($h_r['doc_name']!=''){
								echo $h_r['doc_name'];
							} elseif($h_r['admin_name']!='') {
								echo $h_r['admin_name'];
							}
							echo " - ".$h_r['updated_at'];
						?>
		            </td>
		        </tr>
        		<tr>
                	<td valign="top" class="frmhead">
                        Last Updated By
            		</td>
                	<td valign="top" class="frmdata">
                        <?php
                            $h_sql = "SELECT h.updated_at, CONCAT(u.first_name,' ',u.last_name) doc_name,
                                      CONCAT(a.first_name,' ',a.last_name) admin_name
                                      FROM dental_ledger_history h 
                                      LEFT JOIN dental_users u ON u.userid=h.updated_by_user
                                      LEFT JOIN admin a ON a.adminid=h.updated_by_admin
                                      WHERE h.ledgerid='".mysqli_real_escape_string($con,$_GET['ed'])."' ORDER BY h.updated_at DESC LIMIT 1";
                            
                            $h_r = $db->getRow($h_sql);
                            if($h_r['doc_name']!=''){
                            	echo $h_r['doc_name'];
                            } elseif($h_r['admin_name']!='') {
                            	echo $h_r['admin_name'];
                            }
                            echo " - ".$h_r['updated_at'];
                        ?>
            		</td>
        		</tr>
				<tr>
		        	<td valign="top" class="frmhead">
						Transaction Type
		            </td>
		        	<td valign="top" class="frmdata">
		                <select name="transaction_type" style="width:120px;margin: 0pt 10px 0pt 0pt; float: left;" onchange="getTransCodes(this.value,this.name)">
							<option value="0" <?php echo  ($transaction_type=='0')?'selected="selected"':''; ?>>Select Type</option>
							<option value="1" <?php echo  ($transaction_type=='1')?'selected="selected"':''; ?>>Medical Code</option>
							<option value="2" <?php echo  ($transaction_type=='2')?'selected="selected"':''; ?>>Patient Payment Code</option>
							<option value="4" <?php echo  ($transaction_type=='4')?'selected="selected"':''; ?>>Diagnostic Code</option>
							<option value="6" <?php echo  ($transaction_type=='6')?'selected="selected"':''; ?>>Adjustment Code</option>
		 				</select>
						<span class="red">*</span>
		            </td>
		        </tr>
				<tr>
		        	<td valign="top" class="frmhead">
						Procedure Code
		            </td>
		        	<td valign="top" class="frmdata"> 
						<div id="proccode_div">
							<?php
								$sql="SELECT * FROM dental_transaction_code WHERE type = '".$transaction_type."' and docid=".$_SESSION['docid'];
								
								$result = $db->getResults($sql);
								echo "<select onchange='getTransCodesAmount(this.value,this.name,".$transaction_type.")' id='proccode' name='proccode'><option value='0'>Select TX Code</option>";
								if ($result) foreach ($result as $row) {
								  $r = ($row['transaction_code']==$transaction_code)?'selected="selected"':'';
								  echo "<option ".$r." value='".$row['transaction_codeid']."'>".$row['transaction_code']." - ".$row['description']."</option>";
								}
								echo "</select>";
							?>
						</div>
						<span class="red">*</span>
            		</td>
        		</tr>
				<tr id="tr_amount" <?php echo  ($transaction_type==2||$transaction_type==3||$transaction_type==6)?'style="display:none;"':''?>>
		        	<td valign="top" class="frmhead">
						Amount
		            </td>
		        	<td valign="top" class="frmdata">
						<span id="amount_span"><input readonly="readonly" name="amount" type="text" class="dollar_input tbox" value="<?php echo $amount; ?>"  maxlength="255"/></span>
						<span class="red">*</span>
		            </td>
		        </tr>
				<tr id="tr_paid_amount"  <?php echo  ($transaction_type!=2&&$transaction_type!=3&&$transaction_type!=6)?'style="display:none;"':''?>>
		        	<td valign="top" class="frmhead">
						Paid Amount
		            </td>
		        	<td valign="top" class="frmdata">
						<input id="paid_amount" name="paid_amount" type="text"  class="dollar_input tbox" value="<?php if(isset($paid_amount)){ echo number_format($paid_amount,2,'.','');};?>"  maxlength="255"/>
						<span class="red">*</span>
		            </td>
		        </tr>
	          	<tr>
		            <td valign="top" class="frmhead">
		                File
		            </td>
	                <td valign="top" class="frmdata">
                    	<?php
							$errors = claim_errors($_GET['pid']);
							if(count($errors)>0) {
								$e_text = 'Unable to file claim: ';
								$e_text .= implode($errors, ', ');
                     	?>
		                 		<input type="checkbox" onclick="alert('<?php echo  $e_text; ?>'); return false;" name="status" value="<?php echo  DSS_TRXN_PENDING ?>" />
                     	<?php } else { ?> 
                         		<input type="checkbox" name="status" <?php echo  ($status == DSS_TRXN_PENDING)?'checked="checked"':''; ?> value="<?php echo  DSS_TRXN_PENDING ?>" />
                     	<?php } ?>
						<span class="pend"><?php echo  ($status == DSS_TRXN_PENDING)?'Pending':''; ?></span>
						<input type="hidden" name="old_status" value="<?php echo  $status; ?>" />
                	</td>
          		</tr>		
		        <tr>
		            <td>
		              	<a href="/manage/manage_ledger.php?delid=<?php echo  $_GET['ed']; ?>&amp;pid=<?php echo  $_GET['pid']; ?>" target="_parent" style="font-weight:bold;" onclick="javascript: return confirm('Do Your Really want to Delete?.');" class="dellink" title="DELETE">
		                    Delete 
		                </a>
		            </td>
		            <td >
		                <span class="red">
		                    * Required Fields					
		                </span><br />
		                <input type="hidden" name="ledgerub" value="1" />
		                <input type="hidden" name="ed" value="<?php echo $_GET["ed"]?>" />
		                <input type="submit" value=" <?php echo $but_text?> Transaction" style="float:right;" class="button" />
		            </td>
		        </tr>
    		</table>
    	</form>
	</body>
</html>

<?php

function create_claim($pid, $prod)
{
	$pat_sql = "select * from dental_patients where patientid='".s_for($pid)."'";

	$pat_myarray = $db->getRow($pat_sql);
	$name = st($pat_myarray['lastname'])." ".st($pat_myarray['middlename']).", ".st($pat_myarray['firstname']);
	$insurancetype = st($pat_myarray['p_m_ins_type']);
	$insured_firstname = st($pat_myarray['p_m_partyfname']);
	$insured_lastname = st($pat_myarray['p_m_partymname']);
	$insured_middle = st($pat_myarray['p_m_partylname']);
	$other_insured_firstname = st($pat_myarray['s_m_partyfname']);
	$other_insured_lastname = st($pat_myarray['s_m_partymname']);
	$other_insured_middle = st($pat_myarray['s_m_partylname']);
	$insured_id_number = st($pat_myarray['p_m_ins_id']);
	$insured_dob = st($pat_myarray['ins_dob']);
	$p_m_ins_ass = st($pat_myarray['p_m_ins_ass']);
	$other_insured_dob = st($pat_myarray['ins2_dob']);
	$insured_insurance_plan = st($pat_myarray['p_m_ins_plan']);
	$other_insured_insurance_plan = st($pat_myarray['s_m_ins_plan']);
	$insured_policy_group_feca = st($pat_myarray['p_m_ins_grp']);
	$other_insured_policy_group_feca = st($pat_myarray['s_m_ins_grp']);
	$referredby = st($pat_myarray['referred_by']);
	$referred_source = st($pat_myarray['referred_source']);
	$docid = $pat_myarray['docid'];
	$insured_sex = $pat_myarray['gender'];
	$patient_firstname = $pat_myarray['firstname'];
	$patient_lastname = $pat_myarray['lastname'];
	$patient_middle = $pat_myarray['middlename'];
	$patient_address = $pat_myarray['add1'];
	$patient_city = $pat_myarray['city'];
	$patient_state = $pat_myarray['state'];
	$patient_zip = $pat_myarray['zip'];
	$patient_dob = $pat_myarray['dob'];

    if($pat_myarray['p_m_ins_ass'] == 'Yes') {
        $insured_signature = 1;
    }

    $patient_signature = 1;
    $signature_physician = "Signature on File";
    $patient_signed_date = date('m/d/Y', strtotime($pat_myarray['adddate']));
    $physician_signed_date = date('m/d/Y');
    $patient_phone_code = split_phone($pat_myarray['home_phone'], true);
    $patient_phone = split_phone($pat_myarray['home_phone'], false);
    $insured_phone_code = split_phone($pat_myarray['home_phone'], true);
    $insured_phone = split_phone($pat_myarray['home_phone'], false);
    $patient_status = $pat_myarray['marital_status'];
    $insured_id_number = $pat_myarray['p_m_ins_id'];
    $insured_firstname = $pat_myarray['p_d_party'];
    $insured_address = $pat_myarray['add1'];
    $insured_city = $pat_myarray['city'];
    $insured_state = $pat_myarray['state'];
    $insured_zip = $pat_myarray['zip'];
    $insured_dob = $pat_myarray['ins_dob'];
    $patient_relation_insured = $pat_myarray['p_m_relation'];
    $insured_employer_school_name = $pat_myarray['employer'];
    $insured_policy_group_feca = $pat_myarray['group_number'];
    $insured_insurance_plan = $pat_myarray['plan_name'];
    $p_m_eligible_payer_id = $pat_myarray['p_m_eligible_payer_id'];
    $p_m_eligible_payer_name = $pat_myarray['p_m_eligible_payer_name'];

	$sleepstudies = "SELECT ss.diagnosis FROM dental_summ_sleeplab ss                                 
                     JOIN dental_patients p on ss.patiendid=p.patientid                        
                	 WHERE                                 
                     (p.p_m_ins_type!='1' OR ((ss.diagnosising_doc IS NOT NULL && ss.diagnosising_doc != '') AND (ss.diagnosising_npi IS NOT NULL && ss.diagnosising_npi != ''))) AND 
                     (ss.diagnosis IS NOT NULL && ss.diagnosis != '') AND 
                     ss.completed = 'Yes' AND ss.filename IS NOT NULL AND ss.patiendid = '".$pid."';";

	$d = $db->getRow($sleepstudies);
	$diagnosis_1 = $d['diagnosis'];
	$sleepstudies = "SELECT ss.diagnosising_doc, diagnosising_npi FROM dental_summ_sleeplab ss                                 
                     JOIN dental_patients p on ss.patiendid=p.patientid                        
                	 WHERE                                 
                     (p.p_m_ins_type!='1' OR ((ss.diagnosising_doc IS NOT NULL && ss.diagnosising_doc != '') AND (ss.diagnosising_npi IS NOT NULL && ss.diagnosising_npi != ''))) AND 
                     (ss.diagnosis IS NOT NULL && ss.diagnosis != '') AND 
                     ss.completed = 'Yes' AND ss.filename IS NOT NULL AND ss.patiendid = '".$pid."';";

	$d = $db->getRow($sleepstudies);                                                             
	$diagnosising_doc = $d['diagnosising_doc'];
	$diagnosising_npi = $d['diagnosising_npi'];
	$field_17a = $diagnosising_doc;
	$field_17b = $diagnosising_npi;
	$accept_assignmentnew = st($pat_myarray['p_m_ins_ass']);

	if ($dent_rows <= 0) {
	    $accept_assignment = $accept_assignmentnew;
	}
	// If claim doesn't yet have a preauth number, try to load it
	// from the patient's most recently completed preauth.
	if (empty($prior_authorization_number)) {
	    $sql = "SELECT "
	         . "  * "
	         . "FROM "
	         . "  dental_insurance_preauth "
	         . "WHERE "
	         . "  patient_id = '" . $_GET['pid'] . "' "
	         . "  AND status = " . DSS_PREAUTH_COMPLETE . " "
	         . "ORDER BY "
	         . "  date_completed desc "
	         . "LIMIT 1";

	    $my = $db->getResults($sql);
	    $num_rows = count($my);

	    if ($num_rows > 0) {
	        $myarray = $my[0];
	        $prior_authorization_number = $myarray['pre_auth_num'];
	    }
	}
    
    $ins_sql = " insert into dental_insurance set 
                patientid = '".s_for($pid)."',
                pica1 = '".s_for($pica1)."',
                pica2 = '".s_for($pica2)."',
                pica3 = '".s_for($pica3)."',
                insurance_type = '".s_for($insurancetype)."',
                insured_id_number = '".s_for($insured_id_number)."',
                patient_lastname = '".s_for($patient_lastname)."',
                patient_firstname = '".s_for($patient_firstname)."',
                patient_middle = '".s_for($patient_middle)."',
                patient_dob = '".s_for($patient_dob)."',
                patient_sex = '".s_for($patient_sex)."',
                insured_firstname = '".s_for($insured_firstname)."',
                insured_lastname = '".s_for($insured_lastname)."',
                insured_middle = '".s_for($insured_middle)."',
                patient_address = '".s_for($patient_address)."',
                patient_relation_insured = '".s_for($patient_relation_insured)."',
                insured_address = '".s_for($insured_address)."',
                patient_city = '".s_for($patient_city)."',
                patient_state = '".s_for($patient_state)."',
                patient_status = '".s_for($patient_status_arr)."',
                insured_city = '".s_for($insured_city)."',
                insured_state = '".s_for($insured_state)."',
                patient_zip = '".s_for($patient_zip)."',
                patient_phone_code = '".s_for($patient_phone_code)."',
                patient_phone = '".s_for($patient_phone)."',
                insured_zip = '".s_for($insured_zip)."',
                insured_phone_code = '".s_for($insured_phone_code)."',
                insured_phone = '".s_for($insured_phone)."',
                other_insured_firstname = '".s_for($other_insured_firstname)."',
                other_insured_lastname = '".s_for($other_insured_lastname)."',
                other_insured_middle = '".s_for($other_insured_middle)."',
                employment = '".s_for($employment)."',
                auto_accident = '".s_for($auto_accident)."',
                auto_accident_place = '".s_for($auto_accident_place)."',
                other_accident = '".s_for($other_accident)."',
                insured_policy_group_feca = '".s_for($insured_policy_group_feca)."',
                other_insured_policy_group_feca = '".s_for($other_insured_policy_group_feca)."',
                insured_dob = '".s_for($insured_dob)."',
                insured_sex = '".s_for($insured_sex)."',
                other_insured_dob = '".s_for($other_insured_dob)."',
                other_insured_sex = '".s_for($other_insured_sex)."',
                insured_employer_school_name = '".s_for($insured_employer_school_name)."',
                other_insured_employer_school_name = '".s_for($other_insured_employer_school_name)."',
                insured_insurance_plan = '".s_for($insured_insurance_plan)."',
                other_insured_insurance_plan = '".s_for($other_insured_insurance_plan)."',
                reserved_local_use = '".s_for($reserved_local_use)."',
                another_plan = '".s_for($another_plan)."',
                patient_signature = '".$patient_signature."',
                patient_signed_date = '".s_for($patient_signed_date)."',
                insured_signature = '".s_for($insured_signature)."',
                date_current = '".s_for($date_current)."',
                date_same_illness = '".s_for($date_same_illness)."',
                unable_date_from = '".s_for($unable_date_from)."',
                unable_date_to = '".s_for($unable_date_to)."',
                referring_provider = '".s_for($referring_provider)."',
                field_17a_dd = '".s_for($field_17a_dd)."',
                field_17a = '".s_for($field_17a)."',
                field_17b = '".s_for($field_17b)."',
                hospitalization_date_from = '".s_for($hospitalization_date_from)."',
                hospitalization_date_to = '".s_for($hospitalization_date_to)."',
                reserved_local_use1 = '".s_for($reserved_local_use1)."',
                outside_lab = '".s_for($outside_lab)."',
                s_charges = '".s_for($s_charges)."',
                diagnosis_1 = '".s_for($diagnosis_1)."',
                diagnosis_2 = '".s_for($diagnosis_2)."',
                diagnosis_3 = '".s_for($diagnosis_3)."',
                diagnosis_4 = '".s_for($diagnosis_4)."',
                medicaid_resubmission_code = '".s_for($medicaid_resubmission_code)."',
                original_ref_no = '".s_for($original_ref_no)."',
                prior_authorization_number = '".s_for($prior_authorization_number)."',
                service_date1_from = '".s_for($service_date1_from)."',
                service_date1_to = '".s_for($service_date1_to)."',
                place_of_service1 = '".s_for($place_of_service1)."',
                emg1 = '".s_for($emg1)."',
                cpt_hcpcs1 = '".s_for($cpt_hcpcs1)."',
                modifier1_1 = '".s_for($modifier1_1)."',
                modifier1_2 = '".s_for($modifier1_2)."',
                modifier1_3 = '".s_for($modifier1_3)."',
                modifier1_4 = '".s_for($modifier1_4)."',
                diagnosis_pointer1 = '".s_for($diagnosis_pointer1)."',
                s_charges1_1 = '".s_for($s_charges1_1)."',
                s_charges1_2 = '".s_for($s_charges1_2)."',
                days_or_units1 = '".s_for($days_or_units1)."',
                epsdt_family_plan1 = '".s_for($epsdt_family_plan1)."',
                id_qua1 = '".s_for($id_qua1)."',
                rendering_provider_id1 = '".s_for($rendering_provider_id1)."',
                service_date2_from = '".s_for($service_date2_from)."',
                service_date2_to = '".s_for($service_date2_to)."',
                place_of_service2 = '".s_for($place_of_service2)."',
                emg2 = '".s_for($emg2)."',
                cpt_hcpcs2 = '".s_for($cpt_hcpcs2)."',
                modifier2_1 = '".s_for($modifier2_1)."',
                modifier2_2 = '".s_for($modifier2_2)."',
                modifier2_3 = '".s_for($modifier2_3)."',
                modifier2_4 = '".s_for($modifier2_4)."',
                diagnosis_pointer2 = '".s_for($diagnosis_pointer2)."',
                s_charges2_1 = '".s_for($s_charges2_1)."',
                s_charges2_2 = '".s_for($s_charges2_2)."',
                days_or_units2 = '".s_for($days_or_units2)."',
                epsdt_family_plan2 = '".s_for($epsdt_family_plan2)."',
                id_qua2 = '".s_for($id_qua2)."',
                rendering_provider_id2 = '".s_for($rendering_provider_id2)."',
                service_date3_from = '".s_for($service_date3_from)."',
                service_date3_to = '".s_for($service_date3_to)."',
                place_of_service3 = '".s_for($place_of_service3)."',
                emg3 = '".s_for($emg3)."',
                cpt_hcpcs3 = '".s_for($cpt_hcpcs3)."',
                modifier3_1 = '".s_for($modifier3_1)."',
                modifier3_2 = '".s_for($modifier3_2)."',
                modifier3_3 = '".s_for($modifier3_3)."',
                modifier3_4 = '".s_for($modifier3_4)."',
                diagnosis_pointer3 = '".s_for($diagnosis_pointer3)."',
                s_charges3_1 = '".s_for($s_charges3_1)."',
                s_charges3_2 = '".s_for($s_charges3_2)."',
                days_or_units3 = '".s_for($days_or_units3)."',
                epsdt_family_plan3 = '".s_for($epsdt_family_plan3)."',
                id_qua3 = '".s_for($id_qua3)."',
                rendering_provider_id3 = '".s_for($rendering_provider_id3)."',
                service_date4_from = '".s_for($service_date4_from)."',
                service_date4_to = '".s_for($service_date4_to)."',
                place_of_service4 = '".s_for($place_of_service4)."',
                emg4 = '".s_for($emg4)."',
                cpt_hcpcs4 = '".s_for($cpt_hcpcs4)."',
                modifier4_1 = '".s_for($modifier4_1)."',
                modifier4_2 = '".s_for($modifier4_2)."',
                modifier4_3 = '".s_for($modifier4_3)."',
                modifier4_4 = '".s_for($modifier4_4)."',
                diagnosis_pointer4 = '".s_for($diagnosis_pointer4)."',
                s_charges4_1 = '".s_for($s_charges4_1)."',
                s_charges4_2 = '".s_for($s_charges4_2)."',
                days_or_units4 = '".s_for($days_or_units4)."',
                epsdt_family_plan4 = '".s_for($epsdt_family_plan4)."',
                id_qua4 = '".s_for($id_qua4)."',
                rendering_provider_id4 = '".s_for($rendering_provider_id4)."',
                service_date5_from = '".s_for($service_date5_from)."',
                service_date5_to = '".s_for($service_date5_to)."',
                place_of_service5 = '".s_for($place_of_service5)."',
                emg5 = '".s_for($emg5)."',
                cpt_hcpcs5 = '".s_for($cpt_hcpcs5)."',
                modifier5_1 = '".s_for($modifier5_1)."',
                modifier5_2 = '".s_for($modifier5_2)."',
                modifier5_3 = '".s_for($modifier5_3)."',
                modifier5_4 = '".s_for($modifier5_4)."',
                diagnosis_pointer5 = '".s_for($diagnosis_pointer5)."',
                s_charges5_1 = '".s_for($s_charges5_1)."',
                s_charges5_2 = '".s_for($s_charges5_2)."',
                days_or_units5 = '".s_for($days_or_units5)."',
                epsdt_family_plan5 = '".s_for($epsdt_family_plan5)."',
                id_qua5 = '".s_for($id_qua5)."',
                rendering_provider_id5 = '".s_for($rendering_provider_id5)."',
                service_date6_from = '".s_for($service_date6_from)."',
                service_date6_to = '".s_for($service_date6_to)."',
                place_of_service6 = '".s_for($place_of_service6)."',
                emg6 = '".s_for($emg6)."',
                cpt_hcpcs6 = '".s_for($cpt_hcpcs6)."',
                modifier6_1 = '".s_for($modifier6_1)."',
                modifier6_2 = '".s_for($modifier6_2)."',
                modifier6_3 = '".s_for($modifier6_3)."',
                modifier6_4 = '".s_for($modifier6_4)."',
                diagnosis_pointer6 = '".s_for($diagnosis_pointer6)."',
                s_charges6_1 = '".s_for($s_charges6_1)."',
                s_charges6_2 = '".s_for($s_charges6_2)."',
                days_or_units6 = '".s_for($days_or_units6)."',
                epsdt_family_plan6 = '".s_for($epsdt_family_plan6)."',
                id_qua6 = '".s_for($id_qua6)."',
                rendering_provider_id6 = '".s_for($rendering_provider_id6)."',
                federal_tax_id_number = '".s_for($federal_tax_id_number)."',
                ssn = '".s_for($ssn)."',
                ein = '".s_for($ein)."',
                patient_account_no = '".s_for($patient_account_no)."',
                accept_assignment = '".s_for($accept_assignment)."',
                total_charge = '".s_for($total_charge)."',
                amount_paid = '".s_for($amount_paid)."',
                balance_due = '".s_for($balance_due)."',
                signature_physician = '".s_for($signature_physician)."',
                physician_signed_date = '".s_for($physician_signed_date)."',
                service_facility_info_name = '".s_for($service_facility_info_name)."',
                service_facility_info_address = '".s_for($service_facility_info_address)."',
                service_facility_info_city = '".s_for($service_facility_info_city)."',
                service_info_a = '".s_for($service_info_a)."',
                service_info_dd = '".s_for($service_info_dd)."',
                service_info_b_other = '".s_for($service_info_b_other)."',
                billing_provider_phone_code = '".s_for($billing_provider_phone_code)."',
                billing_provider_phone = '".s_for($billing_provider_phone)."',
                billing_provider_name = '".s_for($billing_provider_name)."',
                billing_provider_address = '".s_for($billing_provider_address)."',
                billing_provider_city = '".s_for($billing_provider_city)."',
                billing_provider_a = '".s_for($billing_provider_a)."',
                billing_provider_dd = '".s_for($billing_provider_dd)."',
                billing_provider_b_other = '".s_for($billing_provider_b_other)."',
                p_m_eligible_payer_id = '".mysqli_real_escape_string($con,$p_m_eligible_payer_id)."',
                p_m_eligible_payer_name = '".mysqli_real_escape_string($con,$p_m_eligible_payer_name)."',
                status = '".s_for(DSS_CLAIM_PENDING)."',
                userid = '".s_for($_SESSION['userid'])."',
                docid = '".s_for($_SESSION['docid'])."',
                producer = '".s_for($prod)."',
                adddate = now(),
                ip_address = '".s_for($_SERVER['REMOTE_ADDR'])."'";

        $primary_claim_id = $db->getInsertId($ins_sql);

        return $primary_claim_id;
}

?>