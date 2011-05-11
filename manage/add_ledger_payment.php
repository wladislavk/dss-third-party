<?php
session_start();
require_once('admin/includes/config.php');
include("includes/sescheck.php");
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
newdiv.innerHTML = '<div><input type="text" name="form['+tempforledgerentry+'][service_date]" id="ledger_entry_service_date" value="'+todaysdate+'" style="margin: 0pt 10px 0pt 0pt; float: left; width:75px;" onclick="cal'+tempforledgerentry+'.popup();"><input type="text" name="form['+tempforledgerentry+'][entry_date]" style="width:75px;margin: 0pt 10px 0pt 0pt; float: left;" value="'+month+'/'+day+'/'+year+'" readonly="readonly"><select id="form['+tempforledgerentry+'][payer]" name="form['+tempforledgerentry+'][payer]" style="width:120px;margin: 0pt 10px 0pt 0pt; float: left;" ><option value="0">Select Payer</option><option value="Primary Insurance">Primary Insurance</option><option value="Secondary Insurance">Secondary Insurance</option><option value="Patient">Patient</option></select><select id="form['+tempforledgerentry+'][payment_type]" name="form['+tempforledgerentry+'][payment_type]" style="width:120px;margin: 0pt 10px 0pt 0pt; float: left;" ><option value="0">Select Payment Type</option><option value="Credit Card">Credit Card</option><option value="Debit">Debit</option><option value="Check">Check</option><option value="Cash">Cash</option></select><div style="float:right;color:#FFF; font-weight:bold;font-size:18px;"><input type="text" id="form['+tempforledgerentry+'][amount]" name="form['+tempforledgerentry+'][amount]" style="margin: 0; float: left; width:75px;margin-right:10px;"></div><div style="clear: both; height: 10px;"></div>';
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
      newdiv.innerHTML = '<div><input type="text" name="form['+tempforledgerentry+'][service_date]" id="ledger_entry_service_date" style="margin: 0pt 10px 0pt 0pt; float: left; width:75px;" onclick="cal'+tempforledgerentry+'.popup();" value="'+month+'/'+day+'/'+year+'"><input type="text" name="form['+tempforledgerentry+'][entry_date]" style="width:75px;margin: 0pt 10px 0pt 0pt; float: left;" value="'+month+'/'+day+'/'+year+'" readonly="readonly"><select id="form['+tempforledgerentry+'][procedure_code]" name="form['+tempforledgerentry+'][procedure_code]" style="width:120px;margin: 0pt 10px 0pt 0pt; float: left;" onchange="getTransCodes(this.value,this.name)"><option value="0">Select Type</option><option value="1">Medical Code</option><option value="2">Patient Payment Code</option><option value="3">Insurance Payment Code</option><option value="4">Diagnostic Code</option><option value="6">Adjustment Code</option></select><div id="proccode'+tempforledgerentry+'" name="proccode'+tempforledgerentry+'" style="margin: 0pt 10px 0pt 0pt; float: left; width: 230px;"><input type="text" value="Select Type First" /></div><div style="float:right;color:#FFF; font-weight:bold;font-size:18px;"><span id="amount_span'+tempforledgerentry+'"><input type="text" id="form['+tempforledgerentry+'][amount]" name="form['+tempforledgerentry+'][amount]" style="margin: 0; float: left; width:75px;margin-right:10px;"></span><input type="checkbox" id="form['+tempforledgerentry+'][status]" name="form['+tempforledgerentry+'][status]" onclick="alert(\'Insurance information needs completed\'); return false;"  value="1" style="margin: 0; float: right; width:24px;"><font style="font-size:10px;">File</font></div></div><div style="clear: both; height: 10px;"></div>';
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
<div id="FormFields" style="margin: 20px 10px;"></div>

<input type="hidden" name="ledgerid" value="<?php echo $_GET['ed']; ?>">
<input type="hidden" name="patientid" value="<?php echo $_GET['pid']; ?>">
<input type="hidden" name="producer" value="<?php echo $_SESSION['username']; ?>">
<input type="hidden" name="userid" value="<?php echo $_SESSION['userid']; ?>">
<input type="hidden" name="docid" value="<?php echo $_SESSION['docid']; ?>">
<input type="hidden" name="ipaddress" value="<?php echo $_SERVER['REMOTE_ADDR']; ?>">
<input type="hidden" name="entrycount" value="javascript::readCookie();">
<div style="width:200px;float:left;margin-left:10px;text-align:left;" id="submitButton"><input type="submit" onclick="validate(<?php $_COOKIE['tempforledgerentry']; ?>)" value="Submit New Transactions" /></div>
<div style="width:200px;margin-right:10px;float:right;text-align:right;"><input type="button" onclick="appendElement();" id="linecountbtn"  value="Add Line Item"></div>
</form>
<script type="text/javascript">
function setupCal(tempforledgerentry){
window["cal"+tempforledgerentry] = new calendar2(document.forms['ledgerentryform'].elements['form['+tempforledgerentry+'][service_date]']);
}
</script>
</body>
</html> 
