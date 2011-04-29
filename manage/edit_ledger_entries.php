<?php
session_start();
require_once('admin/includes/config.php');
include("includes/sescheck.php");
$ids = $_GET['ids'];
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
function getTransCodes(str,name, id)
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
    document.getElementById("proccode"+id).innerHTML=xmlhttp.responseText;
    }
  }
  var pco = name.substr(5,1);
  xmlhttp.open("GET","add_ledger_entry_process.php?q="+str+"&pco="+pco+"&id="+id,true);
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

function getTransCodesAmount(str,name,type, id)
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
    document.getElementById("amount_span"+id).innerHTML=xmlhttp.responseText;
    }
  }
  var pco = name.substr(5,1);
  xmlhttp.open("GET","add_ledger_entry_process_amount.php?t="+type+"&q="+str+"&pco="+pco,true);
  xmlhttp.send();
}


</script>

<script type="text/javascript">
  
      //newdiv.innerHTML = '<div><input type="text" name="form['+tempforledgerentry+'][service_date]" id="ledger_entry_service_date" value="'+todaysdate+'" style="margin: 0pt 10px 0pt 0pt; float: left; width:75px;" onclick="cal'+tempforledgerentry+'.popup();"><input type="text" name="form['+tempforledgerentry+'][entry_date]" style="width:75px;margin: 0pt 10px 0pt 0pt; float: left;" value="'+month+'/'+day+'/'+year+'" readonly="readonly"><select id="form['+tempforledgerentry+'][procedure_code]" name="form['+tempforledgerentry+'][procedure_code]" style="width:120px;margin: 0pt 10px 0pt 0pt; float: left;" onchange="getTransCodes(this.value,this.name)"><option value="0">Select Type</option><option value="1">Medical Code</option><option value="2">Patient Payment Code</option><option value="3">Insurance Payment Code</option><option value="4">Diagnostic Code</option><option value="6">Adjustment Code</option></select><div id="proccode'+tempforledgerentry+'" name="proccode'+tempforledgerentry+'" style="margin: 0pt 10px 0pt 0pt; float: left; width: 230px;"><input type="text" value="Select Type First" /></div><div style="float:right;color:#FFF; font-weight:bold;font-size:18px;"><span id="amount_span'+tempforledgerentry+'"><input type="text" id="form['+tempforledgerentry+'][amount]" name="form['+tempforledgerentry+'][amount]" style="margin: 0; float: left; width:75px;margin-right:10px;"></span><input type="checkbox" id="form['+tempforledgerentry+'][status]" name="form['+tempforledgerentry+'][status]" value="1" style="margin: 0; float: right; width:24px;"><font style="font-size:10px;">File</font></div></div><div style="clear: both; height: 10px;"></div><script type="text/javascript">var cal'+tempforledgerentry+' = new calendar2(document.forms[\'ledgerentryform\'].elements[\'form['+tempforledgerentry+'][service_date]\']);<\/script>';
      //ni.appendChild(newdiv);
  
</script>
  <script type="text/javascript">
function validate(){
if(document.getElementById('ledger_entry_service_date').value = ''){
  alert('Please enter a service date');
}
</script>

</head>
<body >




<link rel="stylesheet" href="css/form.css" type="text/css" />

<script language="JavaScript" src="calendar1.js"></script>
<script language="JavaScript" src="calendar2.js"></script>
<form id="ledgerentryform" name="ledgerentryform" action="update_ledger_entries.php" method="POST" >

 
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
<div style="background:#FFFFFF none repeat scroll 0 0;height:16px;margin-left:9px;margin-top:20px;width:98%; font-weight:bold;"><span style="margin: 0pt 10px 0pt 0pt; float: left; width:83px;">Service Date</span><span style="width:80px;margin: 0pt 10px 0pt 0pt; float: left;" >Entry Date</span><span style="width:120px;margin: 0pt 10px 0pt 0pt; float: left;">Procedure Code</span><div style="margin: 0pt 10px 0pt 0pt; float: left; width: 327px;">Transaction Code</div><div style="float:left;font-weight:bold;">Amount</div></div>
<div id="FormFields" style="margin: 20px 10px;">

<?php

$sql = "SELECT * FROM dental_ledger where ledgerid IN (".$ids.")";
$q = mysql_query($sql);
while($a = mysql_fetch_array($q)){
$sd = ($a['service_date']!='')?date('m/d/Y', strtotime($a['service_date'])):'';
$ed = ($a['entry_date']!='')?date('m/d/Y', strtotime($a['entry_date'])):'';

?>
<div>
<input type="hidden" name="form[<?= $a['ledgerid']; ?>][ledgerid]" value="<?= $a['ledgerid']; ?>" />
<input type="text" name="form[<?= $a['ledgerid']; ?>][service_date]" id="ledger_entry_service_date" value="<?= $sd; ?>" style="margin: 0pt 10px 0pt 0pt; float: left; width:75px;" onclick="cal<?= $a['ledgerid']; ?>.popup();">
<input type="text" name="form[<?= $a['ledgerid']; ?>][entry_date]" style="width:75px;margin: 0pt 10px 0pt 0pt; float: left;" value="<?= $ed; ?>" readonly="readonly">
       <?php $tsql = "SELECT type from dental_transaction_code where transaction_code=".$a['transaction_code']." AND docid=".$_SESSION['docid'];
        $tmy = mysql_query($tsql);
        $trow = mysql_fetch_row($tmy);
        $transaction_type = $trow[0];
       
        switch($transaction_type){
           case '1':
              ?>       
              Medical Code
              <?php
              break;
           case '2':    
              ?>
             Patient Payment Code 
              <?php
              break;
           case '3':    
              ?>
              Insurance Payment Code 
              <?php
              break;
           case '4':    
              ?>
              Diagnostic Code 
              <?php
              break;
           case '6':    
              ?>
              Adjustment Code 
              <?php
              break;
       }

echo $a['transaction_code'];
?>
<div style="float:right;color:#fff;">

<?= $a['amount']; ?>
</span>
<input type="checkbox" <?= ($a['status'])?'checked="checked"':''; ?>id="form[<?= $a['ledgerid']; ?>][status]" name="form[<?= $a['ledgerid']; ?>][status]" value="1" style="margin: 0; float: right; width:24px;">
<font style="font-size:10px;">File</font>
</div></div>
<div style="clear: both; height: 10px;"></div>
<?php
}

?>
</div>

<input type="hidden" name="ids" value="<?= $ids; ?>">
<input type="hidden" name="patientid" value="<?php echo $_GET['pid']; ?>">
<input type="hidden" name="producer" value="<?php echo $_SESSION['username']; ?>">
<input type="hidden" name="userid" value="<?php echo $_SESSION['userid']; ?>">
<input type="hidden" name="docid" value="<?php echo $_SESSION['docid']; ?>">
<input type="hidden" name="ipaddress" value="<?php echo $_SERVER['REMOTE_ADDR']; ?>">
<div style="width:200px;float:left;margin-left:10px;text-align:left;" id="submitButton"><input type="submit" value="Update Transactions" /></div>
</form>

<script type="text/javascript">
</script>               
</body>
</html> 
