var hasVB = false;



if (typeof String.prototype.trim !== 'function') {
    String.prototype.trim = function() {
      return this.replace(/^\s+|\s+$/g, ''); 
    }
  }

  // Patient Search Suggestion Script
  var selection = 1;
  var selectedUrl = '';
  var searchVal = ""; // global variable to hold the last valid search string
  var local_pat_data = new Array();

  $(document).ready(function() {
    $('#patient_search').keypress(function(event) { return event.keyCode != 13; });
    $('#patient_search').keyup(function(e) {
      console.log('START = '+$('#patient_search').val()+"|"+(new Date().getTime()));

      var a = e.which; // ascii decimal value
      var listSize = $('#patient_list li').size();
      var stringSize = $(this).val().length;

      if ($(this).val().trim() == "") {
        $('#search_hints').css('display', 'none');
        $('.json_patient').remove();
        $('.create_new').remove();
        $('.initial_list').css("display", "table-row");
      } else if ((stringSize > 1 || (listSize > 2 && stringSize > 1) || ($(this).val() == window.searchVal)) && ((a >= 39 && a <= 122 && a != 40) || a == 8)) { // (greater than apostrophe and less than z and not down arrow) or backspace
        $('.initial_list').css("display", "none");
        $('#search_hints').css("display", "inline");
        sendValue($('#patient_search').val());
        if ($(this).val() > 2) {
          window.searchVal = $(this).val().replace(/(\s+)?.$/, ""); // strip last character to match last positive result
        }
      }
    });

    $(document).keyup(function(e) {
      switch (e.which) {
        case 38:
          move_selection('up');
          break;
        case 40:
          move_selection('down');
          break;
        case 13:
          if($('#search_hints').css('display') == 'inline' || $('#search_hints').css('display') == 'block'){  
            if (selectedUrl != '') {
            window.location = window.selectedUrl;
            }
          }
          break;
      }
    });

    $('#patient_search').click(function() {
      if ($(this).val() == 'Patient Search') {
        $(this).val('');
      }
    });

    $('#patient_list > li').hover(function() {
      if ($(this).data("pattype")!="no") {
        $(this).css('cursor','pointer');
      }
      window.selection = $(this).data("number");
      set_selected(window.selection);
    }, function() {
      if ($(this).data("pattype")!="no") {
        $(this).css('cursor','auto');
      }

      $('#patient_list li').removeClass('list_hover');
      window.selectedUrl = '';
    });

    $('#patient_list > li').click(function() {
        if($(this).data("pattype")=="new"){
      n = $('#patient_search').val();
      window.location = "add_patient.php?search="+n;
        }else if($(this).data("pattype")=="no"){
      //do nothing
                    }else{
      if (selectedUrl != '') {
        window.location = window.selectedUrl;
      }
      $('#patient_search').val($(this).html());
      sendValue($(this).html());
        }
    });

    $('*').click(function() {
      $('.search_hints').css('display', 'none');
    });

    $('#hideshow1').css('display', 'block');
    $('#hideshow2').css('display', 'none');
    $('#hideshow3').css('display', 'none');
    $('#hideshow4').css('display', 'none');
    $('#hideshow5').css('display', 'none');
  });



function display()
{
  document.getElementById("future_dental_det").style.display = "block"; 
}
      
function hide(id)
{
  document.getElementById("future_dental_det").style.display = "none";
}

function displaysmoke()
{
  document.getElementById("smoke").style.display = "block"; 
}

function hidesmoke(id){
  document.getElementById("smoke").style.display = "none";
}

function LinkUp() 
{
  var number = document.DropDown.DDlinks.selectedIndex;
  window.location.href = document.DropDown.DDlinks.options[number].value;
}

function toggleTB(what)
{
  if (what.checked) {
    document.patientfrm.premeddet.disabled=1
  } else {
    document.patientfrm.premeddet.disabled=0
  }
}

function jsConfirm(str)
{
  var results = (hasVB) ? vbConfirm(str) : confirm(str);

  document.getElementById('results').innerHTML = results;
}

function disableenable()
{    
  if(document.q_page1frm.bed_time_partner.options[document.q_page1frm.bed_time_partner.selectedIndex].value == 'No') { 
    document.q_page1frm.quit_breathing.disabled = true;
    document.q_page1frm.sleep_same_room.disabled = true;
  }

  if(document.q_page1frm.bed_time_partner.options[document.q_page1frm.bed_time_partner.selectedIndex].value == 'Yes') { 
    document.q_page1frm.quit_breathing.disabled = false;
    document.q_page1frm.sleep_same_room.disabled = false;
  }

  if(document.q_page1frm.bed_time_partner.options[document.q_page1frm.bed_time_partner.selectedIndex].value == 'Sometimes') { 
    document.q_page1frm.quit_breathing.disabled = false;
    document.q_page1frm.sleep_same_room.disabled = false;
  }

  if(document.q_page1frm.bed_time_partner.options[document.q_page1frm.bed_time_partner.selectedIndex].value == '') { 
    document.q_page1frm.quit_breathing.disabled = false;
    document.q_page1frm.sleep_same_room.disabled = false;
  }
}

function showMe(id)
{
  var obj = document.getElementById(id);

  if (obj.style.display=="none") { 
    obj.style.display = "block";
  } else {
    obj.style.display = "none";
  }
}

function showMe2(id)
{
  var obj = document.getElementById(id);

  if (obj.style.display=="block") { 
    obj.style.display = "none";
  } else {
    obj.style.display = "block";
  }
}

function createCookie(name,value,days)
{
  if (days) {
    var date = new Date();
          
    date.setTime(date.getTime()+(days*24*60*60*1000));
          
    var expires = "; expires="+date.toGMTString();
  } else {
    var expires = "";

    document.cookie = name+"="+value+expires+"; path=/";
  }
}
      
function readCookie(name) {
  var nameEQ = name + "=";
  var ca = document.cookie.explode(';');

        
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

function check()
{
  for (var i = 0; i < document.forms[0].elements.length; i++) {
    var element = document.forms[0].elements[i];

    switch (element.type) {
      case 'text'://textbox type
        document.forms[0].elements[i].readOnly = true;
        break;
      case 'select-one'://dropdown
        document.forms[0].elements[i].readOnly = true;
        document.forms[0].elements[i].disabled = true;
        break;
      case 'checkbox'://checkbox
        document.forms[0].elements[i].disabled = true;
        break;
      case 'radio'://radiobutton
        document.forms[0].elements[i].disabled = true;
        break;
      case 'button'://button          
        document.forms[0].elements[i].disabled = true;
        break;
      case 'submit'://button                 
        document.forms[0].elements[i].disabled = true;
        break;
      case 'textarea'://textarea
        document.forms[0].elements[i].readOnly = true;
        break;
    }
  }
}

function focusIt(dtControl)
{
  var mytext = document.getElementById(dtControl);

  setTimeout("mytext.focus();",0);
}

function validateDate(dtControl)
{
  input = document.getElementById(dtControl)
  var validformat=/^\d{1,2}\/\d{1,2}\/\d{4}$/ //Basic check for format validity
  var returnval=false

  if (!validformat.test(input.value)) {
    alert('Invalid Day, Month, or Year range detected. Please correct. Must be MM/DD/YYYY');
  } else { //Detailed check for valid date ranges
    var monthfield=input.value.explode("/")[0]
    var dayfield=input.value.explode("/")[1]
    var yearfield=input.value.explode("/")[2]
    var dayobj = new Date(yearfield, monthfield-1, dayfield)

    if ((dayobj.getMonth()+1!=monthfield)||(dayobj.getDate()!=dayfield)||(dayobj.getFullYear()!=yearfield)) {
        alert('Invalid Day, Month, or Year range detected. Please correct. Must be MM/DD/YYYY')
    } else {
        returnval=true
    }
  }
  
  if (!validformat.test(input.value)){
  //document.getElementById(dtControl).focus;
  }
  
  return returnval  
}

function validate()
{
  if (document.getElementById('service_date_ledger').value="") {
    alert('service date must be filled!');
  }  
}

function getKey(keyStroke)
{
  var t = window.event.srcElement.type;
  var keyCode = (document.layers) ? keyStroke.which : event.keyCode;
  var keyString = String.fromCharCode(keyCode).toLowerCase();
  var leftArrowKey = 37;
  var backSpaceKey = 8;
  var escKey = 27;
  
  if (t && (t =='text' || t =='textarea' || t =='file')) {
    //do not cancel the event
  } else {
    if (keyCode == backSpaceKey) {
      return false;
    }
  }
}

function popitup(url)
{
  newwindow=window.open(url,'name','height=400,width=400');
  
  if (window.focus) {
    newwindow.focus()
  }

  return false;
}

var searchBounce = 600,
  searchTimeout = 0,
  searchRequest = null;

function handleResults (data) {
  if (data.length == 0) {
    $('.json_patient').remove();
    $('.create_new').remove();
    $('.no_matches').remove();

    var newLi = $('#patient_list .template').clone(true)
      .removeClass('template')
      .addClass('no_matches')
      .data("pattype", "no");

    template_list_new(newLi, "No Matches")
      .appendTo('#patient_list')
      .fadeIn();

    var newLi = $('#patient_list .template').clone(true)
      .removeClass('template')
      .addClass('create_new')
      .data("pattype", "new");

    template_list_new(newLi, "Add patient with this name&#8230;")
      .appendTo('#patient_list')
      .fadeIn();
  } else if (data.error) {
    $('.json_patient').remove();
    $('.create_new').remove();
    $('.no_matches').remove();
    alert('Could not select patient from database');
  } else {
    $('.json_patient').remove();
    $('.create_new').remove();
    $('.no_matches').remove();

    for (i in data) {
      var newLi = $('#patient_list .template').clone(true)
        .removeClass('template')
        .addClass('json_patient')
        .data("number", parseInt(i) + 1)
        .data("patientid", data[i].patientid)
        .data("patient_info", data[i].patient_info);

      template_list(newLi, data[i])
        .appendTo('#patient_list')
        .fadeIn();
    }
  }
}

function sendValue (searchTerm) {
  if (searchTimeout) {
    clearTimeout(searchTimeout);
  }

  if (searchRequest) {
    searchRequest.abort();
    searchRequest = null;
  }

  searchTimeout = setTimeout(function(){
    searchRequest = $.ajax({
      type: "post",
      dataType: "json",
      url: "list_patients.php",
      data: { partial_name: searchTerm },
      success: handleResults,
      complete: function(){
        searchTimeout = 0;
        searchRequest = null;
      }
    });
  }, searchBounce);
}

function move_selection(direction)
{
  if ($('#patient_list > li.list_hover').size() == 0) {
    window.selection = 0;
  }

  if (direction == 'up' && window.selection != 0) {
    if (window.selection != 1) {
      window.selection--;
    }
  } else if (direction == 'down') {
    if (window.selection != ($("#patient_list li").size() -1)) {
      window.selection++;
    }
  }

  set_selected(window.selection);
}

function set_selected(menuitem)
{
  $('#patient_list li').removeClass('list_hover');
  $('#patient_list li').eq(menuitem).addClass('list_hover');
  var pid = $('#patient_list li').eq(menuitem).data("patientid");
  var patient_info = $('#patient_list li').eq(menuitem).data("patient_info");
  
  if ($('#patient_list li').eq(menuitem).data("pattype")=="new") {
    n = $('#patient_search').val();
    window.selectedUrl = "add_patient.php?search=" + n;
  } else if($('#patient_list li').eq(menuitem).data("pattype") == "no") {
     window.selectedUrl = '';
  } else {
    if (patient_info == 1) {
      window.selectedUrl = "/manage/manage_flowsheet3.php?pid=" + pid;
    } else {
      window.selectedUrl = "/manage/add_patient.php?pid=" + pid + "&ed=" + pid;
    }
  }
}

function template_list(li, patient)
{
  if(patient.middlename != null){
    var mid = patient.middlename
  } else {
    var mid = '';
  }

  li.html(patient.lastname + ", " + patient.firstname + " " + mid);

  return li;
}

function template_list_new(li, str)
{
  li.html(str);
  return li;
}

function task_function()
{
  $(document).ready(function() {
    $('#task_header').mouseover(function(){
      $('#task_list').show();
    });

    $('#task_menu').mouseleave(function(){
      $('#task_list').hide();
    })
  });
}

function areyousure(tturl)
{
  window.location = tturl;
}

function hideallblocksForFlowsheet(step)
{   
  if (step.indexOf("2") != -1 && document.getElementById('consultrow')) {
    document.getElementById('consultrow').style.display = 'none';
  }

  if (step.indexOf("3") != -1 && document.getElementById('sleepstudyrow')) {
    document.getElementById('sleepstudyrow').style.display = 'none';
  }

  if (step.indexOf("4") != -1 && document.getElementById('impressionrow')) {
    document.getElementById('impressionrow').style.display = 'none';
  }

  if (step.indexOf("5") != -1 && document.getElementById('delayingtreatmentrow')) {
    document.getElementById('delayingtreatmentrow').style.display = 'none';
  }

  if (step.indexOf("6") != -1 && document.getElementById('refusedtreatmentrow')) {
    document.getElementById('refusedtreatmentrow').style.display = 'none';
  }

  if (step.indexOf("7") != -1 && document.getElementById('devicedeliveryrow')) {
    document.getElementById('devicedeliveryrow').style.display = 'none';
  }

  if (step.indexOf("8") != -1 && document.getElementById('checkuprow')) {
    document.getElementById('checkuprow').style.display = 'none';
  }

  if (step.indexOf("9") != -1 && document.getElementById('patientnoncomprow')) {
    document.getElementById('patientnoncomprow').style.display = 'none';
  }

  if (step.indexOf("10") != -1 && document.getElementById('homesleeptestrow')) {
    document.getElementById('homesleeptestrow').style.display = 'none';
  }

  if (step.indexOf("11") != -1 && document.getElementById('starttreatmentrow')) {
    document.getElementById('starttreatmentrow').style.display = 'none';
  }

  if (step.indexOf("12") != -1 && document.getElementById('annualrecallrow')) {
    document.getElementById('annualrecallrow').style.display = 'none';
  }
} 

function hideallblocks()
{
  document.getElementById('sleepstudyrow').style.display = 'none';
  document.getElementById('impressionrow').style.display = 'none';
  document.getElementById('delayingtreatmentrow').style.display = 'none';
  document.getElementById('refusedtreatmentrow').style.display = 'none';
  document.getElementById('devicedeliveryrow').style.display = 'none';
  document.getElementById('checkuprow').style.display = 'none';
  document.getElementById('patientnoncomprow').style.display = 'none';
  document.getElementById('starttreatmentrow').style.display = 'none';
  document.getElementById('annualrecallrow').style.display = 'none';
  document.getElementById('homesleeptestrow').style.display = 'none'; 
  document.getElementById('consultrow').style.display = 'none';
 }