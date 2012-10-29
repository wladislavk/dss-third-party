<?php
session_start();
require_once('admin/includes/config.php');
include("includes/sescheck.php");
require_once('includes/constants.inc');
$sql = "SELECT * FROM dental_ledger_payment WHERE ledgerid='".$_GET['ed']."' ;";
$p_sql = mysql_query($sql);
$payments = mysql_fetch_array($p_sql);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="css/admin.css" rel="stylesheet" type="text/css" />


<head>

<script type="text/javascript">

function createCookie(name,value,days) {
              if (days) {
                  var date = new Date();
                  date.setTime(date.getTime()+(days*24*60*60*1000));
                  var expires = "; expires="+date.toGMTString();
              }
              else var expires = "";
              document.cookie = name+"="+value+expires+"; path=/";
          }

		
  function readCookie(name) {
              var nameEQ = name + "=";
              var ca = document.cookie.split(';');
              for(var i=0;i < ca.length;i++) {
                  var c = ca[i];
                  while (c.charAt(0)==' ') c = c.substring(1,c.length);
                  if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
              }
              return null;
  }
          
  function eraseCookie(name) {
              createCookie(name,"",-1);
  }

</script>


<script type="text/javascript">
function validate(tempforledgerentry){
if(document.getElementById("form["+tempforledgerentry+"][service_date]")  == ''){
  alert("DIE");
}
</script>  






<script type="text/javascript">
  var currentTime = new Date()
  var month = currentTime.getMonth() + 1
  var day = currentTime.getDate()
  var year = currentTime.getFullYear()
  if(month < 10){
    month = '0'+(currentTime.getMonth() + 1);  
  }
  if(day < 10){
    day = '0'+currentTime.getDate(); 
  } 
  function appendElement() {
  if (readCookie('tempforledgerentry') == null || readCookie('tempforledgerentry') == 0)
    {
      createCookie('tempforledgerentry',1,'');
      var ni = document.getElementById('FormFields');
      var numi = document.getElementById('currval');
      var num = (document.getElementById('currval').value -1)+ 2;
      numi.value = num;

        var currentTime = new Date()
        var month = currentTime.getMonth() + 1
        var day = currentTime.getDate()
        var year = currentTime.getFullYear()
        var todaysdate = month + "/" + day + "/" + year;

      
      var newdiv = document.createElement('div');
      var divIdName = 'innerdiv'+num;
      var tempforledgerentry = readCookie('tempforledgerentry');
      newdiv.setAttribute('id',divIdName);  
newdiv.innerHTML = '<div><input type="text" name="form['+tempforledgerentry+'][service_date]" id="ledger_entry_service_date" class="calendar" value="'+todaysdate+'" style="margin: 0pt 10px 0pt 0pt; float: left; width:75px;" ><input type="text" name="form['+tempforledgerentry+'][entry_date]" style="width:75px;margin: 0pt 10px 0pt 0pt; float: left;" value="'+month+'/'+day+'/'+year+'" readonly="readonly"><select id="form['+tempforledgerentry+'][payer]" name="form['+tempforledgerentry+'][payer]" style="width:120px;margin: 0pt 10px 0pt 0pt; float: left;" ><option value="<?= DSS_TRXN_PAYER_PRIMARY; ?>"><?= $dss_trxn_payer_labels[DSS_TRXN_PAYER_PRIMARY]; ?></option><option value="<?= DSS_TRXN_PAYER_SECONDARY; ?>"><?= $dss_trxn_payer_labels[DSS_TRXN_PAYER_SECONDARY]; ?><option value="<?= DSS_TRXN_PAYER_PATIENT; ?>"><?= $dss_trxn_payer_labels[DSS_TRXN_PAYER_PATIENT]; ?><option value="<?= DSS_TRXN_PAYER_WRITEOFF; ?>"><?= $dss_trxn_payer_labels[DSS_TRXN_PAYER_WRITEOFF]; ?><option value="<?= DSS_TRXN_PAYER_DISCOUNT; ?>"><?= $dss_trxn_payer_labels[DSS_TRXN_PAYER_DISCOUNT]; ?></select><select id="form['+tempforledgerentry+'][payment_type]" name="form['+tempforledgerentry+'][payment_type]" style="width:120px;margin: 0pt 10px 0pt 0pt; float: left;" ><option value="<?= DSS_TRXN_PYMT_CREDIT; ?>"><?= $dss_trxn_pymt_type_labels[DSS_TRXN_PYMT_CREDIT]; ?></option><option value="<?= DSS_TRXN_PYMT_DEBIT; ?>"><?= $dss_trxn_pymt_type_labels[DSS_TRXN_PYMT_DEBIT]; ?></option><option value="<?= DSS_TRXN_PYMT_CHECK; ?>"><?= $dss_trxn_pymt_type_labels[DSS_TRXN_PYMT_CHECK]; ?></option><option value="<?= DSS_TRXN_PYMT_CASH; ?>"><?= $dss_trxn_pymt_type_labels[DSS_TRXN_PYMT_CASH]; ?></option><option value="<?= DSS_TRXN_PYMT_WRITEOFF; ?>"><?= $dss_trxn_pymt_type_labels[DSS_TRXN_PYMT_WRITEOFF]; ?></option></select><div style="float:right;color:#FFF; font-weight:bold;font-size:18px;"><input type="text" id="form['+tempforledgerentry+'][amount]" class="dollar_input" name="form['+tempforledgerentry+'][amount]" style="margin: 0; float: left; width:75px;margin-right:10px;"></div><div style="clear: both; height: 10px;"></div>';
      ni.appendChild(newdiv);
      setupCal(tempforledgerentry);
    }else if(readCookie('tempforledgerentry') > 0){
      currentcplus = (parseInt(readCookie('tempforledgerentry'),10) + 1);
      eraseCookie('tempforledgerentry');
      createCookie('tempforledgerentry',currentcplus,'');
      var content = document.getElementById('FormFields').innerHTML;
      var ni = document.getElementById('FormFields');
      var numi = document.getElementById('currval');
      var num = (document.getElementById('currval').value -1)+ 2;
      numi.value = num;
      var newdiv = document.createElement('div');
      var divIdName = 'innerdiv'+num;
      var tempforledgerentry = readCookie('tempforledgerentry');
      newdiv.setAttribute('id',divIdName);
      var currentTime = new Date()
        var month = currentTime.getMonth() + 1
        var day = currentTime.getDate()
        var year = currentTime.getFullYear()
        var todaysdate = month + "/" + day + "/" + year;  
newdiv.innerHTML = '<div><input type="text" name="form['+tempforledgerentry+'][service_date]" id="ledger_entry_service_date" class="calendar" value="'+todaysdate+'" style="margin: 0pt 10px 0pt 0pt; float: left; width:75px;" ><input type="text" name="form['+tempforledgerentry+'][entry_date]" style="width:75px;margin: 0pt 10px 0pt 0pt; float: left;" value="'+month+'/'+day+'/'+year+'" readonly="readonly"><select id="form['+tempforledgerentry+'][payer]" name="form['+tempforledgerentry+'][payer]" style="width:120px;margin: 0pt 10px 0pt 0pt; float: left;" ><option value="<?= DSS_TRXN_PAYER_PRIMARY; ?>"><?= $dss_trxn_payer_labels[DSS_TRXN_PAYER_PRIMARY]; ?></option><option value="<?= DSS_TRXN_PAYER_SECONDARY; ?>"><?= $dss_trxn_payer_labels[DSS_TRXN_PAYER_SECONDARY]; ?><option value="<?= DSS_TRXN_PAYER_PATIENT; ?>"><?= $dss_trxn_payer_labels[DSS_TRXN_PAYER_PATIENT]; ?><option value="<?= DSS_TRXN_PAYER_WRITEOFF; ?>"><?= $dss_trxn_payer_labels[DSS_TRXN_PAYER_WRITEOFF]; ?><option value="<?= DSS_TRXN_PAYER_DISCOUNT; ?>"><?= $dss_trxn_payer_labels[DSS_TRXN_PAYER_DISCOUNT]; ?></select><select id="form['+tempforledgerentry+'][payment_type]" name="form['+tempforledgerentry+'][payment_type]" style="width:120px;margin: 0pt 10px 0pt 0pt; float: left;" ><option value="<?= DSS_TRXN_PYMT_CREDIT; ?>"><?= $dss_trxn_pymt_type_labels[DSS_TRXN_PYMT_CREDIT]; ?></option><option value="<?= DSS_TRXN_PYMT_DEBIT; ?>"><?= $dss_trxn_pymt_type_labels[DSS_TRXN_PYMT_DEBIT]; ?></option><option value="<?= DSS_TRXN_PYMT_CHECK; ?>"><?= $dss_trxn_pymt_type_labels[DSS_TRXN_PYMT_CHECK]; ?></option><option value="<?= DSS_TRXN_PYMT_CASH; ?>"><?= $dss_trxn_pymt_type_labels[DSS_TRXN_PYMT_CASH]; ?></option><option value="<?= DSS_TRXN_PYMT_WRITEOFF; ?>"><?= $dss_trxn_pymt_type_labels[DSS_TRXN_PYMT_WRITEOFF]; ?></option></select><div style="float:right;color:#FFF; font-weight:bold;font-size:18px;"><input type="text" id="form['+tempforledgerentry+'][amount]" class="dollar_input" name="form['+tempforledgerentry+'][amount]" style="margin: 0; float: left; width:75px;margin-right:10px;"></div><div style="clear: both; height: 10px;"></div>';
 
      ni.appendChild(newdiv);    
      setupCal(tempforledgerentry);
    }
  }  
  
</script>
  <script type="text/javascript">
function validate(){
if(document.getElementById('ledger_entry_service_date').value = ''){
  alert('Please enter a service date');
}
</script>

</head>
<body onload="appendElement();">




<link rel="stylesheet" href="css/form.css" type="text/css" />

<script language="JavaScript" src="calendar1.js"></script>
<script language="JavaScript" src="calendar2.js"></script>
<form id="ledgerentryform" name="ledgerentryform" action="insert_ledger_payment.php" method="POST" onsubmit="validate(<?php $_COOKIE['tempforledgerentry']; ?>);">

 
<div style="width:200px; margin:0 auto; text-align:center;">
<input type="hidden" value="0" id="currval" />
<script type="text/javascript">
function showsubmitbutton(){
document.getElementById('linecountbtn').style.display = "none";
document.getElementById('linecount').style.display = "none";
document.getElementById('submitbtn').style.display = "block";
document.getElementById('submitbtn').style.cssFloat = "right";
}
</script>

</div>
<div style="background:#FFFFFF none repeat scroll 0 0;height:16px;margin-left:9px;margin-top:20px;width:98%; font-weight:bold;"><span style="margin: 0pt 10px 0pt 0pt; float: left; width:83px;">Payment Date</span><span style="width:80px;margin: 0pt 10px 0pt 0pt; float: left;" >Entry Date</span><span style="width:120px;margin: 0pt 10px 0pt 0pt; float: left;">Paid By</span><div style="margin: 0pt 10px 0pt 0pt; float: left; width: 327px;">Payment Type</div><div style="float:left;font-weight:bold;">Amount</div></div>

<?php
$sql = "SELECT * FROM dental_ledger_payment WHERE ledgerid='".$_GET['ed']."' ;";
$p_sql = mysql_query($sql);
while($p = mysql_fetch_array($p_sql)){
?>
<div style="margin-left:9px; margin-top: 10px; width:98%;color: #fff;">
<span style="margin: 0 10px 0 0; float:left;width:83px;"><?= date('m/d/Y', strtotime($p['payment_date'])); ?></span>
<span style="margin: 0 10px 0 0; float:left;width:80px;"><?= date('m/d/Y', strtotime($p['entry_date'])); ?></span>
<span style="margin: 0 10px 0 0; float:left;width:120px;"><?= $dss_trxn_payer_labels[$p['payer']]; ?></span>
<span style="margin: 0 10px 0 0; float:left;width:327px;"><?= $dss_trxn_pymt_type_labels[$p['payment_type']]; ?></span>
<span style="margin: 0 10px 0 0; float:left;"><?= $p['amount']; ?></span>
<div style="clear:both"></div>
</div>
<?php } ?>

<div id="FormFields" style="margin: 20px 10px;"></div>

<input type="hidden" name="ledgerid" value="<?php echo $_GET['ed']; ?>">
<input type="hidden" name="patientid" value="<?php echo $_GET['pid']; ?>">
<input type="hidden" name="producer" value="<?php echo $_SESSION['username']; ?>">
<input type="hidden" name="userid" value="<?php echo $_SESSION['userid']; ?>">
<input type="hidden" name="docid" value="<?php echo $_SESSION['docid']; ?>">
<input type="hidden" name="ipaddress" value="<?php echo $_SERVER['REMOTE_ADDR']; ?>">
<input type="hidden" name="entrycount" value="javascript::readCookie();">
<div style="width:200px;margin-left:10px;float:left;text-align:left;"><input type="button" onclick="appendElement();" id="linecountbtn"  value="Add Line Item"></div>
<div style="width:200px;float:right;margin-right:10px;text-align:right;" id="submitButton"><input type="submit" onclick="validate(<?php $_COOKIE['tempforledgerentry']; ?>)" value="Submit New Payment" /></div>
</form>
<script type="text/javascript">
function setupCal(tempforledgerentry){
window["cal"+tempforledgerentry] = new calendar2(document.forms['ledgerentryform'].elements['form['+tempforledgerentry+'][service_date]']);
}
</script>
</body>
</html> 

<script type="text/javascript" src="/manage/admin/script/jquery-1.6.2.min.js"></script>
<script type="text/javascript" src="/manage/js/masks.js"></script>

