<?php 
session_start();
require_once('admin/includes/config.php');
require_once('includes/constants.inc');
include("includes/sescheck.php");
include("includes/calendarinc.php");
include("includes/preauth_functions.php");
$flowquery = "SELECT * FROM dental_flow_pg1 WHERE pid='".$_GET['pid']."' LIMIT 1;";
$flowresult = mysql_query($flowquery);
    $flow = mysql_fetch_array($flowresult);
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

if($_POST["ledgerub"] == 1)
{
	$service_date = $_POST['service_date'];
	$entry_date = $_POST['entry_date'];
	$description = $_POST['description'];
	$amount = $_POST['amount'];
	$paid_amount = $_POST['paid_amount'];
	$transaction_type = $_POST['transaction_type'];
	$transaction_code = $_POST['transaction_code'];
    $status = (isset($_POST['status'])) ? DSS_TRXN_PENDING : DSS_TRXN_NA;

	if(strpos($service_date,'-') === false)
	{
		$s_arr = explode('/',$service_date);
		$service_date = $s_arr[2]."-".$s_arr[0]."-".$s_arr[1];
	}
	else
	{
		$s_arr = explode('-',$service_date);
		$service_date = $s_arr[2]."-".$s_arr[0]."-".$s_arr[1];
	}
	
	if(strpos($entry_date,'-') === false)
	{
		$e_arr = explode('/',$entry_date);
		$entry_date = $e_arr[2]."-".$e_arr[0]."-".$e_arr[1];
	}
	else
	{
		$e_arr = explode('-',$entry_date);
		$entry_date = $e_arr[2]."-".$e_arr[0]."-".$e_arr[1];
	}
	
	if($transaction_type == 'Entry')
	{
		$paid_amount = 0;
	}
	else
	{
	}
	
	if($_POST['ed'] == '')
	{
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
		
		mysql_query($ins_sql) or die($ins_sql." | ".mysql_error());
		
		
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
		
		mysql_query($ins_sql_rec) or die($ins_sql." | ".mysql_error());
		
		$msg = "Added Successfully";
		?>
		<script type="text/javascript">
			//alert("<?=$msg;?>");
			parent.window.location='manage_ledger.php?msg=<?=$msg;?>&pid=<?=$_GET['pid'];?>';
		</script>
		<?
		die();
	}
	else
	{
		
		$pat_sql2 = "select * from dental_patients where patientid='".s_for($_GET['pid'])."'";
    $pat_my2 = mysql_query($pat_sql2);
    while($pat_myarray2 = mysql_fetch_array($pat_my2)){ 
    
    $pat_sql3 = mysql_query("INSERT INTO dental_ledger_rec (userid, patientid, service_date, description, amount, paid_amount,transaction_code, ip_address, transaction_type) VALUES ('".$_SESSION['username']."','".$_GET['pid']."','".$pat_myarray2['service_date']."','".$pat_myarray2['description']."','".$pat_myarray2['amount']."','".$pat_myarray2['paid_amount']."','".$pat_myarray2['transaction_code']."','".$pat_myarray2['ip_address']."','".$pat_myarray2['transaction_type']."');");
    if(!$pat_sql3){
     echo "There was an error updating the ledger record.  Please contact your system administrator.";
    }
   
        $service_date = date('Y-m-d', strtotime($_POST['service_date']));
        $entry_date = date('Y-m-d', strtotime($_POST['entry_date']));
        $transaction_type = $_POST['transaction_type'];
        $transaction_code = $_POST['proccode'];
        $tsql = "SELECT transaction_code, description from dental_transaction_code where transaction_codeid=".$transaction_code;
        $tmy = mysql_query($tsql);
        $trow = mysql_fetch_row($tmy);
        $transaction_code = $trow[0];
        $description = $trow[1];
        $status = (isset($_POST['status'])) ? DSS_TRXN_PENDING : DSS_TRXN_NA;
        $amount = $_POST['amount'];
        $paid_amount = $_POST['paid_amount'];

$claim_sql = "SELECT * FROM dental_ledger where ledgerid='".$_POST["ed"]."'";
$claim_q = mysql_query($claim_sql);
$claim_r = mysql_fetch_assoc($claim_r);
if($claim_r['primary_claim_id']=='' && $status==DSS_TRXN_PENDING){
  $s = "SELECT insuranceid from dental_insurance where patientid='".mysql_real_escape_string($_POST['patientid'])."' AND status='".DSS_CLAIM_PENDING."' LIMIT 1";
  $q = mysql_query($s);
  $n = mysql_num_rows($q);
  if($n > 0){
        $r = mysql_fetch_assoc($q);
        $claim_id = $r['insuranceid'];
  }else{
        $claim_id = create_claim($_POST['patientid']);
  }
}else{
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
		
		mysql_query($up_sql) or die($up_sql." | ".mysql_error());
		
		$msg = "Edited Successfully";
		?>
		<script type="text/javascript">
			//alert("<?=$msg;?>");
			parent.window.location='manage_ledger.php?msg=<?=$msg;?>&pid=<?=$_GET['pid'];?>';
		</script>
		<?
		die();
	}
}
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
?>
<script type="text/javascript">
function getTransCodes(str,name)
{
if (str=="")
  {
  document.getElementById("txtHint").innerHTML="";
  return;
  }
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("proccode_div").innerHTML=xmlhttp.responseText;
    }
  }
  var pco = name.substr(5,1);
  xmlhttp.open("GET","add_ledger_entry_process_edit.php?q="+str+"&pco="+pco,true);
  xmlhttp.send();
  if (str==2||str==3){
  document.getElementById("tr_amount").style.display = "none";
  document.getElementById("tr_paid_amount").style.display = "table-row";

  }else{
    document.getElementById("tr_amount").style.display = "table-row";
    document.getElementById("tr_paid_amount").style.display = "none";
  }
}

function getTransCodesAmount(str,name,type,fid)
{
if (str=="")
  {
  document.getElementById("txtHint").innerHTML="";
  return;
  }
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("amount_span"+fid).innerHTML=xmlhttp.responseText;
    }
  }
  var pco = name.substr(5,1);
  xmlhttp.open("GET","add_ledger_entry_process_amount_edit.php?id="+fid+"&t="+type+"&q="+str+"&pco="+pco,true);
  xmlhttp.send();
}

</script>
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
//parent.window.scroll(0, 0);
</script>
</head>
<body>

    <?
	$sql = "select sum(amount) as amt, sum(paid_amount) as p_amt from dental_ledger where patientid='".$_REQUEST["pid"]."'";
	$my = mysql_query($sql);
	$myarray = mysql_fetch_array($my);
	$cur_balance = $myarray['amt'] - $myarray['p_amt'];
	
  $thesql = "select * from dental_ledger where ledgerid='".$_REQUEST["ed"]."'";
	$themy = mysql_query($thesql);
	$themyarray = mysql_fetch_array($themy);
	
	$service_date = st($themyarray['service_date']);
	$entry_date = st($themyarray['entry_date']);
	$description = st($themyarray['description']);
	$amount = st($themyarray['amount']);
	$paid_amount = st($themyarray['paid_amount']);
        $transaction_code = st($themyarray['transaction_code']);
        $tsql = "SELECT type FROM dental_transaction_code WHERE docid=".$_SESSION['docid']." AND transaction_code='".$transaction_code."'"; 
        $tmy = mysql_query($tsql);
        $trow = mysql_fetch_row($tmy);
        $transaction_type = $trow[0];
        $status = st($themyarray['status']);	
	$but_text = "Add ";
	
	if($service_date == '')
	{
		$service_date = date('m/d/Y');
	}
	else
	{
		$service_date = date('m/d/Y',strtotime($service_date));
	}
	
	if($entry_date == '')
	{
		$entry_date = date('m/d/Y');
	}
	else
	{
		$entry_date = date('m/d/Y',strtotime($entry_date));
	}
	
	if($transaction_type == '')
	{
		//$transaction_type = 'Entry';
	}
	
	
	if($themyarray["userid"] != '')
	{
		$but_text = "Edit ";
	}
	else
	{
		$but_text = "Add ";
	}
	?>
	
	<br /><br />
	
	<? if($msg != '') {?>
    <div align="center" class="red">
        <? echo $msg;?>
    </div>
    <? }?>
	<script type="text/javascript">
		function change_t()
		{
			fa = document.ledgerfrm;
			
			if(fa.transaction_type.value == "Payment")
			{
				document.getElementById("tr_paid_amount").style.display = '';
				
			}
			else
			{
				document.getElementById("tr_paid_amount").style.display = 'none';
				
			}
		}
		
		function change_t_code()
		{
			fa = document.ledgerfrm;
			
			<? 
			$tcode_sql = "select * from dental_transaction_code where status=1 AND docid=".$_SESSION['docid']." order by sortby";
			$tcode_my = mysql_query($tcode_sql) or die($tcode_sql ." | ".mysql_error());
			
			while($tcode_myarray = mysql_fetch_array($tcode_my))
			{
			?>
			if(fa.transaction_code.value == '<?=st($tcode_myarray['transaction_codeid'])?>')
			{
				fa.description.value = '<?=st($tcode_myarray['description'])?>';
			}
			<?
			}
			?>
		}
	</script>
    <form name="ledgerfrm" action="<?=$_SERVER['PHP_SELF'];?>?add=1&pid=<?=$_GET['pid']?>" method="post" onSubmit="return ledgerabc(this)">
    <table cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center">
        <tr>
            <td colspan="2" class="cat_head">
               <?=$but_text?> Transaction
			   -
    			Patient <i><?=$name;?></i>
            </td>
        </tr>
		<tr>
        	<td valign="top" class="frmdata" colspan="2" style="text-align:right;">
				<span class="red">
					Current Balance: 
					<b>$<?=number_format($cur_balance,2);?></b>
				</span>
            </td>
        </tr>
        <tr>
        	<td valign="top" class="frmhead" width="30%">
				Service Date
            </td>
        	<td valign="top" class="frmdata">
				<input id="service_date" name="service_date" type="text" class="tbox calendar" value="<?=$service_date;?>" style="width:100px;" maxlength="255"/> (mm/dd/yyyy)
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
				<input id="entry_date" name="entry_date" type="text" class="tbox" value="<?=$entry_date;?>" style="width:100px;" maxlength="255" readonly="readonly"/> (mm/dd/yyyy)
				<span class="red">*</span>
            </td>
        </tr>
		<tr>
        	<td valign="top" class="frmhead">
				Transaction Type
            </td>
        	<td valign="top" class="frmdata">
                                <select name="procedure_code" style="width:120px;margin: 0pt 10px 0pt 0pt; float: left;" onchange="getTransCodes(this.value,this.name)">
					<option value="0" <?= ($transaction_type=='0')?'selected="selected"':''; ?>>Select Type</option>
					<option value="1" <?= ($transaction_type=='1')?'selected="selected"':''; ?>>Medical Code</option>
					<option value="2" <?= ($transaction_type=='2')?'selected="selected"':''; ?>>Patient Payment Code</option>
					<!--<option value="3" <?= ($transaction_type=='3')?'selected="selected"':''; ?>>Insurance Payment Code</option>-->
					<option value="4" <?= ($transaction_type=='4')?'selected="selected"':''; ?>>Diagnostic Code</option>
					<option value="6" <?= ($transaction_type=='6')?'selected="selected"':''; ?>>Adjustment Code</option>
 				</select>
				<!-- <select name="transaction_type" class="tbox" onChange="change_t();">
					<option value="Credit" <? if($transaction_type == 'Credit') echo " selected";?>>Credit</option>
					<option value="Charge" <? if($transaction_type == 'Charge') echo " selected";?>>Charge</option>
					<option value="None" <? if($transaction_type == 'None') echo " selected";?>>None</option>
					<option value="Debit-Prod Adj" <? if($transaction_type == 'Debit-Prod Adj') echo " selected";?>>Debit-Prod Adj</option>
					<option value="Credit-Coll Adj" <? if($transaction_type == 'Credit-Coll Adj') echo " selected";?>>Credit-Coll Adj</option>
				</select> --> 
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

$result = mysql_query($sql);


echo "<select onchange='getTransCodesAmount(this.value,this.name,".$transaction_type.")' id='proccode' name='proccode'><option>Select TX Code</option>";
while($row = mysql_fetch_array($result))
  {
  $r = ($row['transaction_code']==$transaction_code)?'selected="selected"':'';
  echo "<option ".$r." value='".$row['transaction_codeid']."'>".$row['transaction_code']." - ".$row['description']."</option>";
  }

echo "</select>";
?>


</div>
                                  <!--
                                  <select name="transaction_code" class="tbox" onChange="change_t_code();">
					<option value=""></option> 
					<?
					$tcode_sql = "select * from dental_transaction_code where status=1 AND docid=".$_SESSION['docid']." order by sortby";
					$tcode_my = mysql_query($tcode_sql) or die($tcode_sql ." | ".mysql_error());
	
					while($tcode_myarray = mysql_fetch_array($tcode_my))
					{?>
						<option value="<?=st($tcode_myarray['transaction_code']);?>" <? if($transaction_code == st($tcode_myarray['transaction_code'])) echo " selected";?>>
							<?=st($tcode_myarray['transaction_code'])." - ".$tcode_myarray['description'];?>
						</option>
					<?
					}?>
				</select>
				-->
				
				<span class="red">*</span>
            </td>
        </tr>
		<tr id="tr_amount" <?= ($transaction_type==2||$transaction_type==3)?'style="display:none;"':''?>>
        	<td valign="top" class="frmhead">
				Amount
            </td>
        	<td valign="top" class="frmdata">
				<span id="amount_span"><input readonly="readonly" name="amount" type="text" class="tbox" value="<?php echo $amount; ?>"  maxlength="255"/></span>
				<span class="red">*</span>
            </td>
        </tr>
		<tr id="tr_paid_amount"  <?= ($transaction_type!=2&&$transaction_type!=3)?'style="display:none;"':''?>>
        	<td valign="top" class="frmhead">
				Paid Amount
            </td>
        	<td valign="top" class="frmdata">
				<input id="paid_amount" name="paid_amount" type="text" class="tbox" value="<?php if(isset($paid_amount)){ echo number_format($paid_amount,2);};?>"  maxlength="255"/>
				<span class="red">*</span>
            </td>
        </tr>
          <tr>
             <td valign="top" class="frmhead">
                              File
             </td>
                <td valign="top" class="frmdata">
                   <?php /*if ($status == DSS_TRXN_PENDING) { ?>
                       <?= $dss_trxn_status_labels[DSS_TRXN_PENDING] ?>
                       <input type="hidden" name="status" value="<?= DSS_TRXN_PENDING ?>" />
                   <?php } else { */ ?>
                     <?php
$errors = claim_errors($_GET['pid']);
if(count($errors)>0){
$e_text = 'Unable to file claim: ';
$e_text .= implode($errors, ', ');

                     ?>
		                 <input type="checkbox" onclick="alert('<?= $e_text; ?>'); return false;" name="status" value="<?= DSS_TRXN_PENDING ?>" />
                     <?php } else { ?> 
                         <input type="checkbox" name="status" <?= ($status == DSS_TRXN_PENDING)?'checked="checked"':''; ?> value="<?= DSS_TRXN_PENDING ?>" />
                     <?php } ?>
                   <?php // } ?>
			<span class="pend"><?= ($status == DSS_TRXN_PENDING)?'Pending':''; ?></span>
                </td>
          </tr>		
        <tr>
            <td>
              <a href="/manage/manage_ledger.php?delid=<?= $_GET['ed']; ?>&amp;pid=<?= $_GET['pid']; ?>" target="_parent" style="font-weight:bold;" onclick="javascript: return confirm('Do Your Really want to Delete?.');" class="dellink" title="DELETE">
                                                 Delete 
                                        </a>
 
            </td>
            <td >
                <span class="red">
                    * Required Fields					
                </span><br />
                <input type="hidden" name="ledgerub" value="1" />
                <input type="hidden" name="ed" value="<?php echo $_GET["ed"]?>" />
                <input type="submit" value=" <?=$but_text?> Transaction" style="float:right;" class="button" />
            </td>
        </tr>
    </table>
    </form>
	<script type="text/javascript">
		change_t()
	</script> 
	
	
	
</body>
</html>


<?php

function create_claim($pid){
             $pat_sql = "select * from dental_patients where patientid='".s_for($pid)."'";
             $pat_my = mysql_query($pat_sql);
             $pat_myarray = mysql_fetch_array($pat_my);
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
       if($pat_myarray['p_m_ins_ass']=='Yes'){
          $insured_signature = 1;
        }
        $patient_signature = 1;
        $signature_physician = "Signature on File";
        $patient_signed_date = date('m/d/Y', strtotime($pat_myarray['adddate']));
        $physician_signed_date = date('m/d/Y');
        $patient_phone_code = format_phone($pat_myarray['home_phone'], true);
        $patient_phone = format_phone($pat_myarray['home_phone'], false);
        $insured_phone_code = format_phone($pat_myarray['home_phone'], true);
        $insured_phone = format_phone($pat_myarray['home_phone'], false);
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
$sleepstudies = "SELECT ss.diagnosis FROM dental_summ_sleeplab ss                                 
                        JOIN dental_patients p on ss.patiendid=p.patientid                        
                WHERE                                 
                        (p.p_m_ins_type!='1' OR ((ss.diagnosising_doc IS NOT NULL && ss.diagnosising_doc != '') AND (ss.diagnosising_npi IS NOT NULL && ss.diagnosising_npi != ''))) AND 
                        (ss.diagnosis IS NOT NULL && ss.diagnosis != '') AND 
                        ss.completed = 'Yes' AND ss.filename IS NOT NULL AND ss.patiendid = '".$pid."';";

  $result = mysql_query($sleepstudies);
  $d = mysql_fetch_assoc($result);
  $diagnosis_1 = $d['diagnosis'];

$sleepstudies = "SELECT ss.diagnosising_doc, diagnosising_npi FROM dental_summ_sleeplab ss                                 
                        JOIN dental_patients p on ss.patiendid=p.patientid                        
                WHERE                                 
                        (p.p_m_ins_type!='1' OR ((ss.diagnosising_doc IS NOT NULL && ss.diagnosising_doc != '') AND (ss.diagnosising_npi IS NOT NULL && ss.diagnosising_npi != ''))) AND 
                        (ss.diagnosis IS NOT NULL && ss.diagnosis != '') AND 
                        ss.completed = 'Yes' AND ss.filename IS NOT NULL AND ss.patiendid = '".$pid."';";

  $result = mysql_query($sleepstudies);
  $d = mysql_fetch_assoc($result);
                                                                    
  $diagnosising_doc = $d['diagnosising_doc'];
  $diagnosising_npi = $d['diagnosising_npi'];

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
    $my = mysql_query($sql);
    $num_rows = mysql_num_rows($my);

    if ($num_rows > 0) {
        $myarray = mysql_fetch_array($my);
        $prior_authorization_number = $myarray['pre_auth_num'];
    }
}
                $ins_sql = " insert into dental_insurance set 
                patientid = '".s_for($pid)."',
                pica1 = '".s_for($pica1)."',
                pica2 = '".s_for($pica2)."',
                pica3 = '".s_for($pica3)."',
                insurance_type = '".s_for($insurance_type_arr)."',
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
                status = '".s_for(DSS_CLAIM_PENDING)."',
                userid = '".s_for($_SESSION['userid'])."',
                docid = '".s_for($_SESSION['docid'])."',
                adddate = now(),
                ip_address = '".s_for($_SERVER['REMOTE_ADDR'])."'";
                mysql_query($ins_sql) or die($ins_sql." | ".mysql_error());

        $primary_claim_id = mysql_insert_id();

        return $primary_claim_id;
}


function format_phone($num, $a){
        $num = ereg_replace("[^0-9]", "", $num);
        preg_match('/([0-1]*)(.*)/',$num, $m);
        $num = $m[2];
  if($a){
        return substr($num, 0, 3);
  }else{
        return substr($num,3);
  }
  return $num;
}


?>

