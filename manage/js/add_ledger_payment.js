var currentTime = new Date();
var month = currentTime.getMonth() + 1;
var day = currentTime.getDate();
var year = currentTime.getFullYear();
if(month < 10){
  month = '0'+(currentTime.getMonth() + 1);  
}

if(day < 10){
  day = '0'+currentTime.getDate(); 
}

function createCookie(name,value,days)
{
  if (days) {
      var date = new Date();
      date.setTime(date.getTime() + (days*24*60*60*1000));
      var expires = "; expires=" + date.toGMTString();
  } else {
    var expires = "";
  }
  document.cookie = name + "=" + value + expires + "; path=/";
}
		
function readCookie(name)
{
  var nameEQ = name + "=";
  var ca = document.cookie.split(';');
  for(var i=0; i < ca.length; i++) {
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

function appendElement() {
  if (readCookie('tempforledgerentry') == null || readCookie('tempforledgerentry') == 0) {
    createCookie('tempforledgerentry',1,'');
    var ni = document.getElementById('FormFields');
    var numi = document.getElementById('currval');
    var num = (document.getElementById('currval').value -1)  + 2;
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
    newdiv.innerHTML = '<div><input type="text" name="form['+tempforledgerentry+'][service_date]" id="service_date_field_'+tempforledgerentry+'" class="calendar" value="'+todaysdate+'" style="margin: 0pt 10px 0pt 0pt; float: left; width:75px;" ><input type="text" name="form['+tempforledgerentry+'][entry_date]" style="width:75px;margin: 0pt 10px 0pt 0pt; float: left;" value="'+month+'/'+day+'/'+year+'" readonly="readonly">' +
                       '<select id="payer_field_'+tempforledgerentry+'" name="form['+tempforledgerentry+'][payer]" style="width:120px;margin: 0pt 10px 0pt 0pt; float: left;" ><option value="' + DSS_TRXN_PAYER_PRIMARY + '">' + dss_trxn_payer_labels_primary + '</option><option value="' + DSS_TRXN_PAYER_SECONDARY + '">' + dss_trxn_payer_labels_secondary + '<option value="' + DSS_TRXN_PAYER_PATIENT + '">' + dss_trxn_payer_labels_patient +
                       '<option value="' + DSS_TRXN_PAYER_WRITEOFF + '">' + dss_trxn_payer_labels_writeoff + '<option value="' + DSS_TRXN_PAYER_DISCOUNT + '">' + dss_trxn_payer_labels_discount + '</select><select id="form['+tempforledgerentry+'][payment_type]" name="form['+tempforledgerentry+'][payment_type]" style="width:120px;margin: 0pt 10px 0pt 0pt; float: left;" ><option value="' + DSS_TRXN_PYMT_CREDIT +
                       '">' + dss_trxn_pymt_type_labels_credit + '</option><option value="' + DSS_TRXN_PYMT_DEBIT + '">' + dss_trxn_pymt_type_labels_debit + '</option><option value="' + DSS_TRXN_PYMT_CHECK + '">' + dss_trxn_pymt_type_labels_check + '</option><option value="' + DSS_TRXN_PYMT_CASH + '">' + dss_trxn_pymt_type_labels_cash + '</option><option value="' + DSS_TRXN_PYMT_WRITEOFF +
                       '">' + dss_trxn_pymt_type_labels_writeoff + '</option></select><div style="float:right;color:#FFF; font-weight:bold;font-size:18px;"><input type="text" id="amount_field_'+tempforledgerentry+'" class="dollar_input" name="form['+tempforledgerentry+'][amount]" style="margin: 0; float: left; width:75px;margin-right:10px;"></div><div style="clear: both; height: 10px;"></div>';
    ni.appendChild(newdiv);
    setupCal(tempforledgerentry);
  } else if(readCookie('tempforledgerentry') > 0) {
    currentcplus = (parseInt(readCookie('tempforledgerentry'),10) + 1);
    eraseCookie('tempforledgerentry');
    createCookie('tempforledgerentry',currentcplus,'');
    var content = document.getElementById('FormFields').innerHTML;
    var ni = document.getElementById('FormFields');
    var numi = document.getElementById('currval');
    var num = (document.getElementById('currval').value -1) + 2;
    numi.value = num;
    var newdiv = document.createElement('div');
    var divIdName = 'innerdiv' + num;
    var tempforledgerentry = readCookie('tempforledgerentry');
    newdiv.setAttribute('id',divIdName);
    var currentTime = new Date()
    var month = currentTime.getMonth() + 1
    var day = currentTime.getDate()
    var year = currentTime.getFullYear()
    var todaysdate = month + "/" + day + "/" + year;  
    newdiv.innerHTML = '<div><input type="text" name="form['+tempforledgerentry+'][service_date]" id="service_date_field_'+tempforledgerentry+'" class="calendar" value="'+todaysdate+'" style="margin: 0pt 10px 0pt 0pt; float: left; width:75px;" ><input type="text" name="form['+tempforledgerentry+'][entry_date]" style="width:75px;margin: 0pt 10px 0pt 0pt; float: left;" value="'+month+'/'+day+'/'+year+'" readonly="readonly">' +
                       '<select id="payer_field_'+tempforledgerentry+'" name="form['+tempforledgerentry+'][payer]" style="width:120px;margin: 0pt 10px 0pt 0pt; float: left;" ><option value="' + DSS_TRXN_PAYER_PRIMARY + '">' + dss_trxn_payer_labels_primary + '</option><option value="' + DSS_TRXN_PAYER_SECONDARY + '">' + dss_trxn_payer_labels_secondary + '<option value="' + DSS_TRXN_PAYER_PATIENT + '">' + dss_trxn_payer_labels_patient +
                       '<option value="' + DSS_TRXN_PAYER_WRITEOFF + '">' + dss_trxn_payer_labels_writeoff + '<option value="' + DSS_TRXN_PAYER_DISCOUNT + '">' + dss_trxn_payer_labels_discount + '</select><select id="form['+tempforledgerentry+'][payment_type]" name="form['+tempforledgerentry+'][payment_type]" style="width:120px;margin: 0pt 10px 0pt 0pt; float: left;" ><option value="' + DSS_TRXN_PYMT_CREDIT +
                       '">' + dss_trxn_pymt_type_labels_credit + '</option><option value="' + DSS_TRXN_PYMT_DEBIT + '">' + dss_trxn_pymt_type_labels_debit + '</option><option value="' + DSS_TRXN_PYMT_CHECK + '">' + dss_trxn_pymt_type_labels_check + '</option><option value="' + DSS_TRXN_PYMT_CASH + '">' + dss_trxn_pymt_type_labels_cash + '</option><option value="' + DSS_TRXN_PYMT_WRITEOFF +
                       '">' + dss_trxn_pymt_type_labels_writeoff + '</option></select><div style="float:right;color:#FFF; font-weight:bold;font-size:18px;"><input type="text" id="amount_field_'+tempforledgerentry+'" class="dollar_input" name="form['+tempforledgerentry+'][amount]" style="margin: 0; float: left; width:75px;margin-right:10px;"></div><div style="clear: both; height: 10px;"></div>';
    ni.appendChild(newdiv);    
    setupCal(tempforledgerentry);
  }
}  

function validate()
{
  var isValid = true;
  $('input[id*=service_date]').each(function(){
    if ($(this).val() == '') {
      isValid = false;
      alert('Please enter a service date');
      return false;
    }
  });
  $('input[id*=amount]').each(function(){
    if ($(this).val() == '') {
      isValid = false;
      alert('Please enter the payment amount');
      return false;
    }
  });
  return isValid;
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
  var cid = 'service_date_field_' + tempforledgerentry;

  window["cal"+tempforledgerentry] = Calendar.setup({
      inputField : cid,
      trigger    : cid,
      fdow	   : 0,
      align	   : "Bl////",
      onSelect   : function() { this.hide() },
      dateFormat : "%m/%d/%Y"
  });
}

$(document).ready(function(){
    appendElement();
    $('form#ledgerentryform').submit(validate);
});