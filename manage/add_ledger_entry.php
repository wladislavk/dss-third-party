<?php
session_start();
require_once('admin/includes/config.php');
require_once('includes/constants.inc');
require_once('includes/preauth_functions.php');
include("includes/sescheck.php");
$flowquery = "SELECT * FROM dental_flow_pg1 WHERE pid='".$_GET['pid']."' LIMIT 1;";
$flowresult = mysql_query($flowquery);
if(mysql_num_rows($flowresult) <= 0){
$message = "There is no started flowsheet for the current patient.";
}else{
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
    $insverbendate2 = $flow['insverbendate2'];
}

$producer_options = '';
$p_sql = "SELECT * FROM dental_users WHERE userid=".$_SESSION['docid']." OR (docid=".$_SESSION['docid']." AND producer=1)";
$p_query = mysql_query($p_sql);
while($p = mysql_fetch_array($p_query)){
$producer_options .= '<option value="'.$p['userid'].'">'.$p['name'].'</option>';
}
$producer_options .= "";

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="css/admin.css" rel="stylesheet" type="text/css" />


<head>

<script type="text/javascript">

parent.window.scroll(0, 0);

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
    document.getElementById("proccode"+name.substr(5,1)).innerHTML=xmlhttp.responseText;
    }
  }
  var pco = name.substr(5,1);
  xmlhttp.open("GET","add_ledger_entry_process.php?q="+str+"&pco="+pco,true);
  xmlhttp.send();
  if (str==4){
  document.getElementById("form["+name.substr(5,1)+"][amount]").style.display = "none";
  }
  if (str==5){
  document.getElementById("form["+name.substr(5,1)+"][amount]").style.display = "none"; 
  }
  if (str==1){
  document.getElementById("form["+name.substr(5,1)+"][amount]").style.display = "block";
  }
  if (str==2){
  document.getElementById("form["+name.substr(5,1)+"][amount]").style.display = "block"; 
  }
  if (str==3){
  document.getElementById("form["+name.substr(5,1)+"][amount]").style.display = "block";
  }
  if (str==6){
  document.getElementById("form["+name.substr(5,1)+"][amount]").style.display = "block"; 
  }
}

function getTransCodesAmount(str,name,type)
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
    document.getElementById("amount_span"+name.substr(5,1)).innerHTML=xmlhttp.responseText;
    }
  }
  var pco = name.substr(5,1);
  xmlhttp.open("GET","add_ledger_entry_process_amount.php?t="+type+"&q="+str+"&pco="+pco,true);
  xmlhttp.send();
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
<?php 
$errors = claim_errors($_GET['pid']);
if(count($errors)>0){
$e_text = 'Unable to file claim: ';
$e_text .= implode($errors, ', ');
?>
newdiv.innerHTML = '<div><input type="text" name="form['+tempforledgerentry+'][service_date]" id="ledger_entry_service_date" value="'+todaysdate+'" style="margin: 0pt 10px 0pt 0pt; float: left; width:75px;" onclick="cal'+tempforledgerentry+'.popup();"><input type="text" name="form['+tempforledgerentry+'][entry_date]" style="width:75px;margin: 0pt 10px 0pt 0pt; float: left;" value="'+month+'/'+day+'/'+year+'" readonly="readonly"><select style="width:120px;margin: 0pt 10px 0pt 0pt; float: left;" id="form['+tempforledgerentry+'][producer]" name="form['+tempforledgerentry+'][producer]" ><?= $producer_options; ?></select><select id="form['+tempforledgerentry+'][procedure_code]" name="form['+tempforledgerentry+'][procedure_code]" style="width:120px;margin: 0pt 10px 0pt 0pt; float: left;" onchange="getTransCodes(this.value,this.name)"><option value="0">Select Type</option><option value="1">Medical Code</option><option value="2">Patient Payment Code</option><option value="3">Insurance Payment Code</option><option value="4">Diagnostic Code</option><option value="6">Adjustment Code</option></select><div id="proccode'+tempforledgerentry+'" name="proccode'+tempforledgerentry+'" style="margin: 0pt 10px 0pt 0pt; float: left; width: 130px;"><input type="text" value="Select Type First" /></div><div style="float:right;color:#FFF; font-weight:bold;font-size:18px;"><span id="amount_span'+tempforledgerentry+'"><input type="text" id="form['+tempforledgerentry+'][amount]" name="form['+tempforledgerentry+'][amount]" style="margin: 0; float: left; width:75px;margin-right:10px;"></span><input type="checkbox" id="form['+tempforledgerentry+'][status]" name="form['+tempforledgerentry+'][status]" onclick="alert(\'<?= $e_text; ?>\'); return false;" value="<?= DSS_TRXN_PENDING ?>" style="margin: 0; float: right; width:24px;"><font style="font-size:10px;">File</font></div></div><div style="clear: both; height: 10px;"></div>';
<?php 
    }else{
?>
      newdiv.innerHTML = '<div><input type="text" name="form['+tempforledgerentry+'][service_date]" id="ledger_entry_service_date" value="'+todaysdate+'" style="margin: 0pt 10px 0pt 0pt; float: left; width:75px;" onclick="cal'+tempforledgerentry+'.popup();"><input type="text" name="form['+tempforledgerentry+'][entry_date]" style="width:75px;margin: 0pt 10px 0pt 0pt; float: left;" value="'+month+'/'+day+'/'+year+'" readonly="readonly"><select style="width:120px;margin: 0pt 10px 0pt 0pt; float: left;" id="form['+tempforledgerentry+'][producer]" name="form['+tempforledgerentry+'][producer]" ><?= $producer_options; ?></select><select id="form['+tempforledgerentry+'][procedure_code]" name="form['+tempforledgerentry+'][procedure_code]" style="width:120px;margin: 0pt 10px 0pt 0pt; float: left;" onchange="getTransCodes(this.value,this.name)"><option value="0">Select Type</option><option value="1">Medical Code</option><option value="2">Patient Payment Code</option><option value="3">Insurance Payment Code</option><option value="4">Diagnostic Code</option><option value="6">Adjustment Code</option></select><div id="proccode'+tempforledgerentry+'" name="proccode'+tempforledgerentry+'" style="margin: 0pt 10px 0pt 0pt; float: left; width: 130px;"><input type="text" value="Select Type First" /></div><div style="float:right;color:#FFF; font-weight:bold;font-size:18px;"><span id="amount_span'+tempforledgerentry+'"><input type="text" id="form['+tempforledgerentry+'][amount]" name="form['+tempforledgerentry+'][amount]" style="margin: 0; float: left; width:75px;margin-right:10px;"></span><input type="checkbox" id="form['+tempforledgerentry+'][status]" name="form['+tempforledgerentry+'][status]" value="<?= DSS_TRXN_PENDING ?>" style="margin: 0; float: right; width:24px;"><font style="font-size:10px;">File</font></div></div><div style="clear: both; height: 10px;"></div>';
<?php } ?>
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
<?php
$errors = claim_errors($_GET['pid']);
if(count($errors)>0){
$e_text = 'Unable to file claim: ';
$e_text .= implode($errors, ', ');
?>

      newdiv.innerHTML = '<div><input type="text" name="form['+tempforledgerentry+'][service_date]" id="ledger_entry_service_date" style="margin: 0pt 10px 0pt 0pt; float: left; width:75px;" onclick="cal'+tempforledgerentry+'.popup();" value="'+month+'/'+day+'/'+year+'"><input type="text" name="form['+tempforledgerentry+'][entry_date]" style="width:75px;margin: 0pt 10px 0pt 0pt; float: left;" value="'+month+'/'+day+'/'+year+'" readonly="readonly"><select style="width:120px;margin: 0pt 10px 0pt 0pt; float: left;" id="form['+tempforledgerentry+'][producer]" name="form['+tempforledgerentry+'][producer]" ><?= $producer_options; ?></select><select id="form['+tempforledgerentry+'][procedure_code]" name="form['+tempforledgerentry+'][procedure_code]" style="width:120px;margin: 0pt 10px 0pt 0pt; float: left;" onchange="getTransCodes(this.value,this.name)"><option value="0">Select Type</option><option value="1">Medical Code</option><option value="2">Patient Payment Code</option><option value="3">Insurance Payment Code</option><option value="4">Diagnostic Code</option><option value="6">Adjustment Code</option></select><div id="proccode'+tempforledgerentry+'" name="proccode'+tempforledgerentry+'" style="margin: 0pt 10px 0pt 0pt; float: left; width: 130px;"><input type="text" value="Select Type First" /></div><div style="float:right;color:#FFF; font-weight:bold;font-size:18px;"><span id="amount_span'+tempforledgerentry+'"><input type="text" id="form['+tempforledgerentry+'][amount]" name="form['+tempforledgerentry+'][amount]" style="margin: 0; float: left; width:75px;margin-right:10px;"></span><input type="checkbox" id="form['+tempforledgerentry+'][status]" name="form['+tempforledgerentry+'][status]" onclick="alert(\'<?= $e_text; ?>\'); return false;"  value="<?= DSS_TRXN_PENDING ?>" style="margin: 0; float: right; width:24px;"><font style="font-size:10px;">File</font></div></div><div style="clear: both; height: 10px;"></div>';
<?php }else{ ?>
      newdiv.innerHTML = '<div><input type="text" name="form['+tempforledgerentry+'][service_date]" id="ledger_entry_service_date" style="margin: 0pt 10px 0pt 0pt; float: left; width:75px;" onclick="cal'+tempforledgerentry+'.popup();" value="'+month+'/'+day+'/'+year+'"><input type="text" name="form['+tempforledgerentry+'][entry_date]" style="width:75px;margin: 0pt 10px 0pt 0pt; float: left;" value="'+month+'/'+day+'/'+year+'" readonly="readonly"><select style="width:120px;margin: 0pt 10px 0pt 0pt; float: left;" id="form['+tempforledgerentry+'][producer]" name="form['+tempforledgerentry+'][producer]" ><?= $producer_options; ?></select><select id="form['+tempforledgerentry+'][procedure_code]" name="form['+tempforledgerentry+'][procedure_code]" style="width:120px;margin: 0pt 10px 0pt 0pt; float: left;" onchange="getTransCodes(this.value,this.name)"><option value="0">Select Type</option><option value="1">Medical Code</option><option value="2">Patient Payment Code</option><option value="3">Insurance Payment Code</option><option value="4">Diagnostic Code</option><option value="6">Adjustment Code</option></select><div id="proccode'+tempforledgerentry+'" name="proccode'+tempforledgerentry+'" style="margin: 0pt 10px 0pt 0pt; float: left; width: 130px;"><input type="text" value="Select Type First" /></div><div style="float:right;color:#FFF; font-weight:bold;font-size:18px;"><span id="amount_span'+tempforledgerentry+'"><input type="text" id="form['+tempforledgerentry+'][amount]" name="form['+tempforledgerentry+'][amount]" style="margin: 0; float: left; width:75px;margin-right:10px;"></span><input type="checkbox" id="form['+tempforledgerentry+'][status]" name="form['+tempforledgerentry+'][status]" value="<?= DSS_TRXN_PENDING ?>" style="margin: 0; float: right; width:24px;"><font style="font-size:10px;">File</font></div></div><div style="clear: both; height: 10px;"></div>';
<?php } ?>
      ni.appendChild(newdiv);    
      setupCal(tempforledgerentry);
    }
  }  
  
</script>
  <script type="text/javascript">
function validate(f){
  if(<?= ($_SESSION['user_access']==2)?1:0;?>){
    return true;
  }else{
    if(f.username.value=='' || f.password.value==''){  
      alert('Please enter a username and password.');
      return false;
    }else{
      return true;
    }
  }
}
</script>

</head>
<body onload="appendElement();">



<link rel="stylesheet" href="css/form.css" type="text/css" />

<script language="JavaScript" src="calendar1.js"></script>
<script language="JavaScript" src="calendar2.js"></script>
<form id="ledgerentryform" name="ledgerentryform" action="insert_ledger_entries.php" method="POST" onsubmit="return validate(this);">

 
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
<div id="form_div" >
<div style="background:#FFFFFF none repeat scroll 0 0;height:16px;margin-left:9px;margin-top:20px;width:98%; font-weight:bold;"><span style="margin: 0pt 10px 0pt 0pt; float: left; width:83px;">Service Date</span><span style="width:80px;margin: 0pt 10px 0pt 0pt; float: left;" >Entry Date</span><span style="width:120px;margin: 0pt 10px 0pt 0pt; float: left;">Producer</span><span style="width:120px;margin: 0pt 10px 0pt 0pt; float: left;">Procedure Code</span><div style="margin: 0pt 10px 0pt 0pt; float: left; width: 207px;">Transaction Code</div><div style="float:left;font-weight:bold;">Amount</div></div>
<div id="FormFields" style="margin: 20px 10px;"></div>

<input type="hidden" name="patientid" value="<?php echo $_GET['pid']; ?>">
<input type="hidden" name="userid" value="<?php echo $_SESSION['userid']; ?>">
<input type="hidden" name="docid" value="<?php echo $_SESSION['docid']; ?>">
<input type="hidden" name="ipaddress" value="<?php echo $_SERVER['REMOTE_ADDR']; ?>">
<input type="hidden" name="entrycount" value="javascript::readCookie();">
<?php if($_SESSION['user_access']!=DSS_USER_TYPE_ADMIN){ ?>
<div id="auth_div" style="padding-left: 10px; color:#fff;">
<p>You are not authorized to complete this transaction. Please have an authorized user enter their credentials.</p>
Username: <input type="text" name="username" />
Password: <input type="password" name="password" />
</div>
<?php } ?>
<div style="width:200px;float:left;margin-left:10px;text-align:left;"><input type="button" onclick="appendElement();" id="linecountbtn"  value="Add Line Item"></div>
<div style="width:200px;margin-right:10px;float:right;text-align:right;" id="submitButton"><input type="submit" value="Submit Transactions" /></div>

</div>
</form>
<script type="text/javascript">
function setupCal(tempforledgerentry){
window["cal"+tempforledgerentry] = new calendar2(document.forms['ledgerentryform'].elements['form['+tempforledgerentry+'][service_date]']);
}
</script>
</body>
</html> 
