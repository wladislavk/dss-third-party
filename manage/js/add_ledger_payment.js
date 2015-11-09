var currentTime = new Date();
var month = currentTime.getMonth() + 1;
var day = currentTime.getDate();
var year = currentTime.getFullYear();

var template = '<div>' +
    '<input type="text" name="form[%uniqueId%][service_date]" id="service_date_field_%uniqueId%" ' +
        'class="calendar" value="%todayDate%" ' +
        'style="margin: 0pt 10px 0pt 0pt; float: left; width:75px;" />' +
    '<input type="text" name="form[%uniqueId%][entry_date]" ' +
        'value="%todayDate%" readonly="readonly" ' +
        'style="width:75px;margin: 0pt 10px 0pt 0pt; float: left;" />' +
    '<select id="payer_field_%uniqueId%" name="form[%uniqueId%][payer]" ' +
        'style="width:120px;margin: 0pt 10px 0pt 0pt; float: left;">' +
        '<option value="' + DSS_TRXN_PAYER_PRIMARY + '">' + dss_trxn_payer_labels_primary + '</option>' +
        '<option value="' + DSS_TRXN_PAYER_SECONDARY + '">' + dss_trxn_payer_labels_secondary + '</option>' +
        '<option value="' + DSS_TRXN_PAYER_PATIENT + '">' + dss_trxn_payer_labels_patient + '</option>' +
        '<option value="' + DSS_TRXN_PAYER_WRITEOFF + '">' + dss_trxn_payer_labels_writeoff + '</option>' +
        '<option value="' + DSS_TRXN_PAYER_DISCOUNT + '">' + dss_trxn_payer_labels_discount + '</option>' +
    '</select>' +
    '<select id="form[%uniqueId%][payment_type]" name="form[%uniqueId%][payment_type]"' +
        'style="width:120px;margin: 0pt 10px 0pt 0pt; float: left;">' +
        '<option value="' + DSS_TRXN_PYMT_CREDIT + '">' + dss_trxn_pymt_type_labels_credit + '</option>' +
        '<option value="' + DSS_TRXN_PYMT_DEBIT + '">' + dss_trxn_pymt_type_labels_debit + '</option>' +
        '<option value="' + DSS_TRXN_PYMT_CHECK + '">' + dss_trxn_pymt_type_labels_check + '</option>' +
        '<option value="' + DSS_TRXN_PYMT_CASH + '">' + dss_trxn_pymt_type_labels_cash + '</option>' +
        '<option value="' + DSS_TRXN_PYMT_WRITEOFF + '">' + dss_trxn_pymt_type_labels_writeoff + '</option>' +
        '<option value="' + DSS_TRXN_PYMT_EFT + '">' + dss_trxn_pymt_type_labels_eft + '</option>' +
    '</select>' +
    '<div style="float:right;color:#FFF; font-weight:bold;font-size:18px;">' +
        '<input type="text" id="amount_field_%uniqueId%"' +
            'class="dollar_input" name="form[%uniqueId%][amount]"' +
            'style="margin: 0; float: left; width:75px;margin-right:10px;">' +
        '<button class="remove" onclick="removeRow(%uniqueId%);return false;">X</button>' +
    '</div>' +
    '<div style="clear: both; height: 10px;"></div>';

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
    currentCount = 1;
  } else if(readCookie('tempforledgerentry') > 0) {
    currentCount = parseInt(readCookie('tempforledgerentry'), 10) + 1;
    eraseCookie('tempforledgerentry');
  }

  createCookie('tempforledgerentry', currentCount, '');

  var currentTime = new Date(),
    month = currentTime.getMonth() + 1,
    day = currentTime.getDate(),
    year = currentTime.getFullYear(),
    todayDate = month + "/" + day + "/" + year,
    uniqueId = readCookie('tempforledgerentry');

  var newDiv = $('<div />', {
      id: 'payment_' + uniqueId
  });

  newDiv.html(template.replace(/%uniqueId%/g, uniqueId).replace(/%todayDate%/g, todayDate));

  $('#FormFields').append(newDiv);
  afterUpdateFormFields();

  setupCal(uniqueId);
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

function setupCal(uniqueId)
{
  var cid = 'service_date_field_' + uniqueId;

  window["cal"+uniqueId] = Calendar.setup({
      inputField : cid,
      trigger    : cid,
      fdow	   : 0,
      align	   : "Bl////",
      onSelect   : function() { this.hide() },
      dateFormat : "%m/%d/%Y"
  });
}

function removeRow(id)
{
    $('#payment_' + id).remove();
    afterUpdateFormFields();
}

function afterUpdateFormFields () {
    var count = $('[id^=payment_]').length;

    $('#currval').val(count);

    if (count < 2) {
        $('.remove').attr('disabled', 'disabled');
    } else {
        $('.remove').removeAttr('disabled');
    }
}

$(document).ready(function(){
    appendElement();
    $('form#ledgerentryform').submit(validate);
});