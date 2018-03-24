function getTransCodes(str,name)
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

  xmlhttp.onreadystatechange = function()
  {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
      document.getElementById("proccode_div").innerHTML=xmlhttp.responseText;
    }
  }

  var pco = name.substr(5,1);
  xmlhttp.open("GET","add_ledger_entry_process_edit.php?q="+str+"&pco="+pco,true);
  xmlhttp.send();
  if (str==2||str==3||str==6){
    document.getElementById("tr_amount").style.display = "none";
    document.getElementById("tr_paid_amount").style.display = "table-row";
  } else {
    document.getElementById("tr_amount").style.display = "table-row";
    document.getElementById("tr_paid_amount").style.display = "none";
  }
}

function getTransCodesAmount(str,name,type,fid)
{
  if (str == "") {
    document.getElementById("txtHint").innerHTML = "";
    return;
  }

  if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp = new XMLHttpRequest();
  } else {// code for IE6, IE5
    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
  }

  xmlhttp.onreadystatechange=function()
  {
    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
      document.getElementById("amount_span").innerHTML = xmlhttp.responseText;
    }
  }

  var pco = name.substr(5,1);
  xmlhttp.open("GET","add_ledger_entry_process_amount_edit.php?id=" + fid + "&t=" + type + "&q=" + str + "&pco=" + pco,true);
  xmlhttp.send();
}

function change_t()
{
  fa = document.ledgerfrm;
  if(fa.transaction_type.value == "6") {
    document.getElementById("tr_paid_amount").style.display = ''; 
  } else {
    document.getElementById("tr_paid_amount").style.display = 'none';
  }
}

function is_dollar_input(evt)
{
  var charCode = (evt.which) ? evt.which : event.keyCode;
  if (charCode != 44 && charCode != 45 && charCode !=46 && (charCode < 48 || charCode > 57) )
    return false;

  return true;
}

function change_t_code(transactionCodeStr, descriptionStr)
{
  var transactionCodeArray = transactionCodeStr.split(',');
  var descriptionArray = descriptionStr.split(',');
  var fa = document.ledgerfrm;
          
  for (var i = 0; i < transactionCodeArray.length; i++) {
    if(fa.transaction_code.value == transactionCodeArray[i])
    {
      fa.description.value = descriptionArray[i];
    }
  }
}