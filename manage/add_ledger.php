<?php 
session_start();
require_once('admin/includes/config.php');
require_once('includes/constants.inc');
include("includes/sescheck.php");
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
 
    $up_sql = "update dental_ledger set
    service_date = '".s_for($service_date)."',
		entry_date = '".s_for($entry_date)."',
		description = '".s_for($description)."',
		amount = '".s_for($amount)."',
		paid_amount = '".s_for($paid_amount)."',
        transaction_type = '".s_for($transaction_type)."',
		transaction_code = '".s_for($transaction_code)."',
		userid = '".s_for($_SESSION['userid'])."',
        status = ". s_for($status)."
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
parent.window.scroll(0, 0);
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
				<input id="service_date" name="service_date" type="text" class="tbox" onclick="cal.popup()" value="<?=$service_date;?>" style="width:100px;" maxlength="255"/> (mm/dd/yyyy)
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
					<option value="3" <?= ($transaction_type=='3')?'selected="selected"':''; ?>>Insurance Payment Code</option>
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
                   <?php if ($status == DSS_TRXN_PENDING) { ?>
                       <?= $dss_trxn_status_labels[DSS_TRXN_PENDING] ?>
                       <input type="hidden" name="status" value="<?= DSS_TRXN_PENDING ?>" />
                   <?php } else { ?>
                     <?php
                     if ($insinforec == '' || $rxrec == '' 
                             || $lomnrec == '' ) {
                     ?>
		                 <input type="checkbox" onclick="alert('Insurance information needs completed'); return false;" name="status" value="<?= DSS_TRXN_PENDING ?>" />
                     <?php } else { ?> 
                         <input type="checkbox" name="status" value="<?= DSS_TRXN_PENDING ?>" />
                     <?php } ?>
                   <?php } ?>
                </td>
          </tr>		
        <tr>
            <td>
              <a href="/manage/manage_ledger.php?delid=<?= $_GET['ed']; ?>&amp;pid=<?= $_GET['pid']; ?>&popup=1" style="font-weight:bold;" onclick="javascript: return confirm('Do Your Really want to Delete?.');" class="dellink" title="DELETE">
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
