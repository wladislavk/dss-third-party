parent.window.scroll(0, 0);

function createCookie(name,value,days)
{
  if (days) {
    var date = new Date();
    date.setTime(date.getTime()+(days*24*60*60*1000));
    var expires = "; expires="+date.toGMTString();
  } else {
    var expires = "";
  }

  document.cookie = name+"="+value+expires+"; path=/";
}
		
function readCookie(name)
{
  var nameEQ = name + "=";
  var ca = document.cookie.split(';');
  for(var i=0;i < ca.length;i++) {
      var c = ca[i];
      while (c.charAt(0)==' ') c = c.substring(1,c.length);
      if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
  }

  return null;
}
          
function eraseCookie(name)
{
  createCookie(name,"",-1);
}

function hideRemove(){
  $('.remove').css('visibility','hidden');
}

function getTransCodes(str,name)
{
  if (getTransCodesValue) {
    if(str==6){
      alert('You do not have permission to post adjustments.  Please contact your office manager to resolve this issue.');
      document.getElementById('ledgerentryform')[name].selectedIndex='0';
    }
  }

  if(str == "") {
    document.getElementById("txtHint").innerHTML="";
    return;
  }
  if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp = new XMLHttpRequest();
  } else {// code for IE6, IE5
    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
  }

  xmlhttp.onreadystatechange = function() {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
      document.getElementById("proccode"+name.substr(5,1)).innerHTML=xmlhttp.responseText;
    }
  }

  var pco = name.substr(5,1);
  xmlhttp.open("GET","add_ledger_entry_process.php?q="+str+"&pco="+pco,true);
  xmlhttp.send();

  if (str == 4){
    document.getElementById("form["+name.substr(5,1)+"][amount]").style.display = "none";
  }

  if (str == 5){
    document.getElementById("form["+name.substr(5,1)+"][amount]").style.display = "none"; 
  }

  if (str == 1){
    document.getElementById("form["+name.substr(5,1)+"][amount]").style.display = "block";
  }

  if (str == 2){
    document.getElementById("form["+name.substr(5,1)+"][amount]").style.display = "block"; 
  }

  if (str == 3){
    document.getElementById("form["+name.substr(5,1)+"][amount]").style.display = "block";
  }

  if (str == 6){
    document.getElementById("form["+name.substr(5,1)+"][amount]").style.display = "block"; 
  }
}

function getTransCodesAmount(str,name,type)
{
  if (str=="") {
    document.getElementById("txtHint").innerHTML="";
    return;
  }

  if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else {// code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }

  xmlhttp.onreadystatechange = function() {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
      if(xmlhttp.responseText==0) {
        alert('This transaction code has no amount. If you want to use this code, please add your fee via Navigation -> Admin -> Transaction Code.');
        document.getElementById("form["+name.substr(5,1)+"][proccode]").selectedIndex = 0;  
        document.getElementById("amount_span"+name.substr(5,1)).innerHTML="";
      } else {
        document.getElementById("amount_span"+name.substr(5,1)).innerHTML=xmlhttp.responseText;
      }
    }
  }

  var pco = name.substr(5,1);
  xmlhttp.open("GET","add_ledger_entry_process_amount.php?t="+type+"&q="+str+"&pco="+pco,true);
  xmlhttp.send();
}

function checkCode(t)
{
  v = $('#procedure_code' + t).attr("value");
  
  if(v != 1){
    alert('Filing Error! You can file ONLY Medical Code items. Uncheck the "File" box or change Procedure Code in order to submit ledger entry.');
    return false;
  }

  return true; 
}

function updateFile(t)
{
  v = $('#procedure_code' + t).attr("value");
  
  if(v != 1){
    $('#status' + t).removeAttr("checked");
  }

}

var currentTime = new Date()
var month = currentTime.getMonth() + 1
var day = currentTime.getDate()
var year = currentTime.getFullYear()
if(month < 10) {
  month = '0' + (currentTime.getMonth() + 1);  
}

if(day < 10) {
  day = '0' + currentTime.getDate(); 
}

function appendElement()
{
  if (readCookie('tempforledgerentry') == null || readCookie('tempforledgerentry') == 0) {
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
    
    if (appendElementValue) {
      newdiv_content = '<div id="transaction_'+tempforledgerentry+'"><input type="text" name="form['+tempforledgerentry+'][service_date]" id="ledger_entry_service_date'+tempforledgerentry+'" class="calendar" value="'+todaysdate+'" style="margin: 0pt 10px 0pt 0pt; float: left; width:65px;"><input type="text" name="form['+tempforledgerentry+'][entry_date]" style="width:65px;margin: 0pt 10px 0pt 0pt; float: left;" value="'+month+'/'+day+'/'+year+'" readonly="readonly"><select style="width:120px;margin: 0pt 10px 0pt 0pt; float: left;" id="form['+tempforledgerentry+'][producer]" name="form['+tempforledgerentry+'][producer]" >' + appendElementProducerOptions + '</select><select id="form['+tempforledgerentry+'][procedure_code]" name="form['+tempforledgerentry+'][procedure_code]" style="width:120px;margin: 0pt 10px 0pt 0pt; float: left;" onchange="return getTransCodes(this.value,this.name)"><option value="0">Select Type</option><option value="1">Medical Code</option><option value="2">Patient Payment Code</option><option value="6">Adjustment Code</option></select><div id="proccode'+tempforledgerentry+'" name="proccode'+tempforledgerentry+'" style="margin: 0pt 10px 0pt 0pt; float: left; width: 120px;"><input type="text" value="Select Type First" /></div><div style="float:right;color:#FFF; font-weight:bold;font-size:18px;"><span id="amount_span'+tempforledgerentry+'"><input type="text" class="dollar_input" onkeypress="return is_dollar_input(event)" id="form['+tempforledgerentry+'][amount]" name="form['+tempforledgerentry+'][amount]" style="margin: 0; float: left; width:75px;margin-right:10px;"></span><input type="checkbox" id="form['+tempforledgerentry+'][status]" name="form['+tempforledgerentry+'][status]" onclick="alert(\'' + appendElementEText + '\'); return false;" class="file_checkbox" value="' + DSS_TRXN_PENDING + '" style="margin: 0; width:24px;"><font style="font-size:10px;">File</font><button class="remove" onclick="removeRow('+tempforledgerentry+');return false;">X</button></div></div><div style="clear: both; height: 10px;"></div>';
    } else {
      newdiv_content = '<div id="transaction_'+tempforledgerentry+'"><input type="text" name="form['+tempforledgerentry+'][service_date]" id="ledger_entry_service_date'+tempforledgerentry+'" class="calendar" value="'+todaysdate+'" style="margin: 0pt 10px 0pt 0pt; float: left; width:65px;"><input type="text" name="form['+tempforledgerentry+'][entry_date]" style="width:65px;margin: 0pt 10px 0pt 0pt; float: left;" value="'+month+'/'+day+'/'+year+'" readonly="readonly"><select style="width:120px;margin: 0pt 10px 0pt 0pt; float: left;" id="form['+tempforledgerentry+'][producer]" name="form['+tempforledgerentry+'][producer]" >' + appendElementProducerOptions + '</select><select id="procedure_code'+tempforledgerentry+'" name="form['+tempforledgerentry+'][procedure_code]" style="width:120px;margin: 0pt 10px 0pt 0pt; float: left;" onchange="return getTransCodes(this.value,this.name); updateFile('+tempforledgerentry+');"><option value="0">Select Type</option><option value="1">Medical Code</option><option value="2">Patient Payment Code</option><option value="6">Adjustment Code</option></select><div id="proccode'+tempforledgerentry+'" name="proccode'+tempforledgerentry+'" style="margin: 0pt 10px 0pt 0pt; float: left; width: 120px;"><input type="text" value="Select Type First" /></div><div style="float:right;color:#FFF; font-weight:bold;font-size:18px;"><span id="amount_span'+tempforledgerentry+'"><input type="text" id="form['+tempforledgerentry+'][amount]" class="dollar_input" onkeypress="return is_dollar_input(event)" name="form['+tempforledgerentry+'][amount]" style="margin: 0; float: left; width:75px;margin-right:10px;"></span><span><input type="checkbox" id="status'+tempforledgerentry+'" name="form['+tempforledgerentry+'][status]" value="' + DSS_TRXN_PENDING + '" style="margin: 0; width:24px;" class="file_checkbox" onclick="return checkCode('+tempforledgerentry+');"><font style="font-size:10px;">File</font></span><button class="remove" onclick="removeRow('+tempforledgerentry+');return false;">X</button></div></div><div style="clear: both; height: 10px;"></div>';
    }

    newdiv.innerHTML = newdiv_content;
    ni.appendChild(newdiv);
    setupCal(tempforledgerentry);
  } else if(readCookie('tempforledgerentry') > 0) {
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

    if (appendElementValue) {
      newdiv_content = '<div id="transaction_'+tempforledgerentry+'"><input type="text" name="form['+tempforledgerentry+'][service_date]" id="ledger_entry_service_date'+tempforledgerentry+'" class="calendar" style="margin: 0pt 10px 0pt 0pt; float: left; width:65px;"  value="'+month+'/'+day+'/'+year+'"><input type="text" name="form['+tempforledgerentry+'][entry_date]" style="width:65px;margin: 0pt 10px 0pt 0pt; float: left;" value="'+month+'/'+day+'/'+year+'" readonly="readonly"><select style="width:120px;margin: 0pt 10px 0pt 0pt; float: left;" id="form['+tempforledgerentry+'][producer]" name="form['+tempforledgerentry+'][producer]" >' + appendElementProducerOptions + '</select><select id="form['+tempforledgerentry+'][procedure_code]" name="form['+tempforledgerentry+'][procedure_code]" style="width:120px;margin: 0pt 10px 0pt 0pt; float: left;" onchange="return getTransCodes(this.value,this.name)"><option value="0">Select Type</option><option value="1">Medical Code</option><option value="2">Patient Payment Code</option><option value="6">Adjustment Code</option></select><div id="proccode'+tempforledgerentry+'" name="proccode'+tempforledgerentry+'" style="margin: 0pt 10px 0pt 0pt; float: left; width: 120px;"><input type="text" value="Select Type First" /></div><div style="float:right;color:#FFF; font-weight:bold;font-size:18px;"><span id="amount_span'+tempforledgerentry+'"><input type="text" id="form['+tempforledgerentry+'][amount]" class="dollar_input" onkeypress="return is_dollar_input(event)" name="form['+tempforledgerentry+'][amount]" style="margin: 0; float: left; width:75px;margin-right:10px;"></span><input type="checkbox" id="form['+tempforledgerentry+'][status]" name="form['+tempforledgerentry+'][status]" onclick="alert(\'' + appendElementEText + '\'); return false;" class="file_checkbox"  value="' + DSS_TRXN_PENDING + '" style="margin: 0; width:24px;"><font style="font-size:10px;">File</font><button class="remove" onclick="removeRow('+tempforledgerentry+');return false;">X</button></div></div><div style="clear: both; height: 10px;"></div>';
    } else {
      newdiv_content = '<div id="transaction_'+tempforledgerentry+'"><input type="text" name="form['+tempforledgerentry+'][service_date]" id="ledger_entry_service_date'+tempforledgerentry+'" class="calendar" style="margin: 0pt 10px 0pt 0pt; float: left; width:65px;" value="'+month+'/'+day+'/'+year+'"><input type="text" name="form['+tempforledgerentry+'][entry_date]" style="width:65px;margin: 0pt 10px 0pt 0pt; float: left;" value="'+month+'/'+day+'/'+year+'" readonly="readonly"><select style="width:120px;margin: 0pt 10px 0pt 0pt; float: left;" id="form['+tempforledgerentry+'][producer]" name="form['+tempforledgerentry+'][producer]" >' + appendElementProducerOptions + '</select><select id="procedure_code'+tempforledgerentry+'" name="form['+tempforledgerentry+'][procedure_code]" style="width:120px;margin: 0pt 10px 0pt 0pt; float: left;" onchange="return getTransCodes(this.value,this.name); updateFile('+tempforledgerentry+');"><option value="0">Select Type</option><option value="1">Medical Code</option><option value="2">Patient Payment Code</option><option value="6">Adjustment Code</option></select><div id="proccode'+tempforledgerentry+'" onchange="updateFile('+tempforledgerentry+')" name="proccode'+tempforledgerentry+'" style="margin: 0pt 10px 0pt 0pt; float: left; width: 120px;"><input type="text" value="Select Type First" /></div><div style="float:right;color:#FFF; font-weight:bold;font-size:18px;"><span id="amount_span'+tempforledgerentry+'"><input type="text" id="form['+tempforledgerentry+'][amount]" name="form['+tempforledgerentry+'][amount]" class="dollar_input" onkeypress="return is_dollar_input(event)" style="margin: 0; float: left; width:75px;margin-right:10px;"></span><input type="checkbox" id="status'+tempforledgerentry+'" name="form['+tempforledgerentry+'][status]" value="' + DSS_TRXN_PENDING + '" style="margin: 0; width:24px;" class="file_checkbox" onclick="return checkCode('+tempforledgerentry+')"><font style="font-size:10px;" >File</font><button class="remove" onclick="removeRow('+tempforledgerentry+');return false;">X</button></div></div><div style="clear: both; height: 10px;"></div>';
    }

    console.log(newdiv_content);

    newdiv.innerHTML = newdiv_content;
    ni.appendChild(newdiv);    
    setupCal(tempforledgerentry);
  }
}

function isNumber(n)
{
  return !isNaN(parseFloat(n)) && isFinite(n);
}

function validate()
{
  returnval = true;
  $('#FormFields input').each( function(){
    v = $(this).val();  
    if(v==''||v=='Select Type First'){
      if(returnval){
        alert('Blank fields! You must select a value for all ledger fields in order to submit a transaction.');
        returnval = false;
      }
    }
  });

  $('.dollar_input').each(function(){
    v = $(this).val()
    v = v.replace(',','');
    if(!isNumber(v)){
      alert('Please only enter numeric characters into amount field.');
      returnval = false;
    }
  });

  file = false;
  $('.file_checkbox').each(function(){
    if($(this).attr('checked')){
      file=true;
    }
  });

  if(file){
    if(!confirm('An insurance claim will be generated and filed. Are you sure you want to do this?')){
      returnval = false;
    }
  }

  return returnval;
}

function is_dollar_input(evt)
{
  var charCode = (evt.which) ? evt.which : evt.keyCode;
  if (charCode!=8 && charCode != 44 && charCode != 45 && charCode !=46 && (charCode < 48 || charCode > 57) )
    return false;

  return true;
}

function showsubmitbutton()
{
  document.getElementById('linecountbtn').style.display = "none";
  document.getElementById('linecount').style.display = "none";
  document.getElementById('submitbtn').style.display = "block";
  document.getElementById('submitbtn').style.cssFloat = "right";
}

function setupCal(tempforledgerentry)
{
  $('input.calendar').each(function(){
    var cid = $(this).attr("id");
    if(cid){
      Calendar.setup({
        inputField : cid,
        trigger    : cid,
        fdow       : 0,
        align      : "Bl////",
        onSelect   : function() { this.hide() },
        dateFormat : "%m/%d/%Y"
      });
    }
  });
}

function removeRow(id)
{
  $('#transaction_'+id).remove();
  var numi = document.getElementById('currval');
  var num = (document.getElementById('currval').value -1);
  numi.value = num;
  if(!(num > 1)) {
    $('.remove').css('visibility','hidden');
  }
}