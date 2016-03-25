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

function consoleLog () {
    if (typeof console !== 'undefined' && typeof console.log === 'function') {
        console.log.apply(console, arguments);
    }
}

  $(document).ready(function() {
    $('#patient_search, #pat_name').keypress(function(event) { return event.keyCode != 13; });
    $('#patient_search, #pat_name').keyup(function(e) {
      var $this = $(this);

      consoleLog('START', $this.val(), (new Date().getTime()));

      var $parent = $this.parent();
      var a = e.which; // ascii decimal value
      var listSize = $parent.find('#patient_list li, .search_list li').size();
      var stringSize = $this.val().length;

      if ($this.val().trim() == "") {
        $parent.find('.search_hints').css('display', 'none');
        $parent.find('.json_patient').remove();
        $parent.find('.create_new').remove();
        $parent.find('.initial_list').css("display", "table-row");
      } else if ((stringSize > 1 || (listSize > 2 && stringSize > 1) || ($this.val() == window.searchVal)) && ((a >= 39 && a <= 122 && a != 40) || a == 8)) { // (greater than apostrophe and less than z and not down arrow) or backspace
        $parent.find('.initial_list').css("display", "none");
        $parent.find('.search_hints').css("display", "inline");
        sendValue($this.val(), $parent.find('#patient_list, .search_list'));
        if ($this.val() > 2) {
          window.searchVal = $this.val().replace(/(\s+)?.$/, ""); // strip last character to match last positive result
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
          if ($('.search_hints').is(':visible')) {
            if (selectedUrl != '') {
              window.location = window.selectedUrl;
            }
          }
          break;
      }
    });

    $('#patient_search, #pat_name').click(function() {
      var $this = $(this);

      if ($this.val() == 'Patient Search' || $this.val() == 'Search Calendar') {
        $this.val('');
      }
    });

    $('#patient_list > li, .search_list li').hover(function() {
      var $this = $(this);

      if ($this.data("pattype") != "no") {
        $this.css('cursor','pointer');
      }
      window.selection = $this.data("number");
      set_selected(window.selection);
    }, function() {
      var $this = $(this);

      if ($this.data("pattype") != "no") {
        $this.css('cursor','auto');
      }

      $('#patient_list li, .search_list li').removeClass('list_hover');
      window.selectedUrl = '';
    });

    $('#patient_list > li, .search_list li').click(function() {
      var $this = $(this),
          $parent = $this.closest('.search_hints').parent(),
          $search = $parent.find('input[type=text]');

      if ($this.data("pattype") == "new") {
        n = $search.val();
        window.location = "add_patient.php?search="+n;
      } else if ($this.data("pattype") == "no") {
        //do nothing
      } else {
        if (selectedUrl != '') {
          window.location = window.selectedUrl;
        }

        $search.val($this.html());
        sendValue($this.html(), $parent.find('#patient_list, .search_list'));
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
  $("#future_dental_det").show(); 
}
      
function hide()
{
  $("#future_dental_det").hide();
}

function displaysmoke()
{
  $("#smoke").show(); 
}

function hidesmoke(){
  $("#smoke").hide();
}

function LinkUp() 
{
  var link = $('[name=DDlinks]').val();
  window.location.href = link;
}

function toggleTB(what)
{
  if ($(what).is(':checked')) {
    $('form[name=patientfrm] [name=premeddet]').prop('disabled', true);
  } else {
    $('form[name=patientfrm] [name=premeddet]').prop('disabled', false);
  }
}

function jsConfirm(str)
{
  var results = (hasVB) ? vbConfirm(str) : confirm(str);
  $('#results').html(results);
}

function disableenable()
{    
  if($('form[name=q_page1frm] [name=bed_time_partner]').val() == 'No') { 
    $('form[name=q_page1frm] [name=quit_breathing]').prop('disabled', true);
    $('form[name=q_page1frm] [name=sleep_same_room]').prop('disabled', true);
  }

  if($('form[name=q_page1frm] [name=bed_time_partner]').val() == 'Yes') { 
    $('form[name=q_page1frm] [name=quit_breathing]').prop('disabled', false)
    $('form[name=q_page1frm] [name=sleep_same_room]').prop('disabled', false)
  }

  if($('form[name=q_page1frm] [name=bed_time_partner]').val() == 'Sometimes') { 
    $('form[name=q_page1frm] [name=quit_breathing]').prop('disabled', false)
    $('form[name=q_page1frm] [name=sleep_same_room]').prop('disabled', false)
  }

  if($('form[name=q_page1frm] [name=bed_time_partner]').val() == '') { 
    $('form[name=q_page1frm] [name=quit_breathing]').prop('disabled', false)
    $('form[name=q_page1frm] [name=sleep_same_room]').prop('disabled', false)
  }
}

function showMe(id)
{
  $('#' + id).toggle();
}

function showMe2(id)
{
  $('#' + id).toggle();
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
  if (!(document.forms || []).length || !(document.forms[0].elements || []).length) {
    return;
  }

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
  var mytext = $('#' + dtControl);
  setTimeout(function(){ mytext.focus(); }, 0);
}

function validateDate(dtControl)
{
  var input = $('#' + dtControl),
    value = input.val() || '',
    dateFormat = input.attr('data-date-format') || 'm/d/Y',
    readableFormat = dateFormat.replace(/([mdy])/g, '$1$1').replace(/(Y)/g, '$1$1$1$1').toUpperCase(),
    regexValidator = new RegExp('^' +
      dateFormat.replace(/[md]/g, '\\d{1,2}').replace(/y/g, '\\d{2}').replace(/Y/g, '\\d{4}') +
    '$');

  if (!regexValidator.test(input.value)) {
    alert('Invalid Day, Month, or Year range detected. Please correct. Must be ' + readableFormat);
  } else if (dateFormat === 'm/d/Y') {
    var monthfield=value.explode("/")[0],
      dayfield=value.explode("/")[1],
      yearfield=value.explode("/")[2],
      dayobj = new Date(yearfield, monthfield-1, dayfield)

    if ((dayobj.getMonth()+1!=monthfield)||(dayobj.getDate()!=dayfield)||(dayobj.getFullYear()!=yearfield)) {
      alert('Invalid Day, Month, or Year range detected. Please correct. Must be ' + readableFormat);
      return false;
    }
  }
  
  return true;
}

function validate()
{
  if (document.getElementById('service_date_ledger').value="") {
    alert('service date must be filled!');
  }  
}

function getKey(keyStroke)
{
  if (!window.event || !window.event.srcElement) {
    return;
  }

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

function handleResults (data, $reference) {
  var $target = typeof $reference === 'undefined' ? $('#patient_list') : $reference;

  if (data.length == 0) {
    $('.json_patient').remove();
    $('.create_new').remove();
    $('.no_matches').remove();

    var newLi = $('#patient_list .template').clone(true)
      .removeClass('template')
      .addClass('no_matches')
      .data("pattype", "no");

    template_list_new(newLi, "No Matches")
      .appendTo($target)
      .fadeIn();

    var newLi = $('#patient_list .template').clone(true)
      .removeClass('template')
      .addClass('create_new')
      .data("pattype", "new");

    template_list_new(newLi, "Add patient with this name&#8230;")
      .appendTo($target)
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
        .appendTo($target)
        .fadeIn();
    }
  }
}

function sendValue (searchTerm, $reference) {
  var $parent = $reference.closest('.search_hints').parent();

  // Restrict ajax search to only search bars, like patient and calendar
  if (!$parent.length || !$parent.is('[id*=search]')) {
    return;
  }

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
      success: function(data){
        handleResults(data, $reference);
      },
      complete: function(){
        searchTimeout = 0;
        searchRequest = null;
      }
    });
  }, searchBounce);
}

function move_selection(direction)
{
  if ($('#patient_list:visible > li.list_hover, .search_list:visible > li.list_hover').size() == 0) {
    window.selection = 0;
  }

  if (direction == 'up' && window.selection != 0) {
    if (window.selection != 1) {
      window.selection--;
    }
  } else if (direction == 'down') {
    if (window.selection != ($("#patient_list:visible li, .search_list:visible > li").size() -1)) {
      window.selection++;
    }
  }

  set_selected(window.selection);
}

function set_selected(menuitem)
{
  var $item = $('#patient_list:visible li, .search_list:visible li').eq(menuitem),
      $parent = $item.closest('.search_hints').parent(),
      $search = $parent.find('input[type=text]'),
      pid = $item.data("patientid"),
      patient_info = $item.data("patient_info");

  $('#patient_list li, .search_list li').removeClass('list_hover');
  $item.addClass('list_hover');

  // Restrict redirection to results from search bars, like patient and calendar searches
  if (!$parent.length || !$parent.is('[id*=search]')) {
    return;
  }

  // Different target pages for calendar search and regular search
  if ($parent.is('#cal_search')) {
    window.selectedUrl = "/manage/calendar_pat.php?pid=" + pid;
  } else {
    if ($item.data("pattype") == "new") {
      n = $search.val();
      window.selectedUrl = "add_patient.php?search=" + n;
    } else if($item.data("pattype") == "no") {
      window.selectedUrl = '';
    } else {
      if (patient_info == 1) {
        window.selectedUrl = "/manage/manage_flowsheet3.php?pid=" + pid;
      } else {
        window.selectedUrl = "/manage/add_patient.php?pid=" + pid + "&ed=" + pid;
      }
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
  if (step.indexOf("2") != -1) {
    $('#consultrow').hide();
  }

  if (step.indexOf("3") != -1) {
    $('#sleepstudyrow').hide();
  }

  if (step.indexOf("4") != -1) {
    $('#impressionrow').hide();
  }

  if (step.indexOf("5") != -1) {
    $('#delayingtreatmentrow').hide();
  }

  if (step.indexOf("6") != -1) {
    $('#refusedtreatmentrow').hide();
  }

  if (step.indexOf("7") != -1) {
    $('#devicedeliveryrow').hide();
  }

  if (step.indexOf("8") != -1) {
    $('#checkuprow').hide();
  }

  if (step.indexOf("9") != -1) {
    $('#patientnoncomprow').hide();
  }

  if (step.indexOf("10") != -1) {
    $('#homesleeptestrow').hide();
  }

  if (step.indexOf("11") != -1) {
    $('#starttreatmentrow').hide();
  }

  if (step.indexOf("12") != -1) {
    $('#annualrecallrow').hide();
  }
} 

function hideallblocks()
{
  $('#sleepstudyrow, #impressionrow, #delayingtreatmentrow').hide();
  $('#refusedtreatmentrow, #devicedeliveryrow, #checkuprow').hide();
  $('#patientnoncomprow, #starttreatmentrow, #annualrecallrow').hide();
  $('#homesleeptestrow, #consultrow').hide();
}
