edited = false;

$(document).ready(function() {
	$(':input:not(#patient_search)').change(function() { 
		edited = true;
		//window.onbeforeunload = confirmExit;
	});
	$('#q_page2frm').submit(function() {
		window.onbeforeunload = null;
	});
	$('#q_page2frm').bind('reset', function() {
    var $form = $(this);
    setTimeout(function(){
      $form.find(':radio:checked').change();
      $('.surgery-row.new-row').remove()
      $('.surgery-row.original-row').show()
        .find('.surgery-deleted')
        .val(0)
    }, 0)
  })
});

function confirmExit()
{
	return "You have attempted to leave this page.  If you have made any changes to the fields without clicking the Save button, your changes will be lost.  Are you sure you want to exit this page?";
}

function chk_poly()
{
	fa = $('form[name=q_page2frm]');

	if(fa.find('[name=polysomnographic]:eq(0)').is(':checked')) {
		$('.poly_options').show();
	} else {
		$('.poly_options').hide();
	}
}

function other_chk1()
{ 	
	fa = $('form[name=q_page2frm]');
	if(fa.find('[name=other_chk]').is(':checked')) {
		fa.find('[name=other_therapy]').prop('disabled', false);
	} else {
		fa.find('[name=other_therapy]').prop('disabled', true);
	}
}

function chk_cpap_other()
{
	if($('#cpap_other').attr('checked')){
		$('.cpap_other_text').show();
	} else {
		$('.cpap_other_text').hide();
	}

}

function chk_dd()
{       
    fa = $('form[name=q_page2frm]');
    if(fa.find('[name=dd_wearing]:eq(0)').is(':checked') || fa.find('[name=dd_prev]:eq(0)').is(':checked')) {
        $('.dd_options').show();
    } else {
		$('.dd_options').hide();
	}
}

function chk_s()
{       
    fa = $('form[name=q_page2frm]');
    if(fa.find('[name=surgery]:eq(0)').is(':checked')) {
        $('.s_options').show();
    } else {
        $('.s_options').hide();
    }
}

function chk_cpap()
{ 	
	fa = $('form[name=q_page2frm]');
	chk_l = $('[name="intolerance[]"]').length;
	if(fa.find('[name=cpap]:eq(1)').is(':checked')) {
		$('.cpap_options').hide();
		$('.cpap_options2').hide();
	} else {
		$('.cpap_options').show();
		if(fa.find('[name=cur_cpap]:eq(0)').is(':checked')) {
		    $('.cpap_options2').show();
		} else {
		    $('.cpap_options2').hide();
		}
	}
}

function q_page2abc(fa)
{
    var errorMsg = '';
	fa = $(fa);

	if (trim(fa.find('[name=sleep_study_on]').val()) != '') {
		if (
			is_date(trim(fa.find('[name=sleep_study_on]').val())) == -1 ||
			is_date(trim(fa.find('[name=sleep_study_on]').val())) == false
		) {
			errorMsg += "- Invalid Date Format, Valid Format : (mm/dd/YYYY);\n";
			fa.find('[name=sleep_study_on]').focus();
		}
	}
	
	if ($('#polysomnographic_yes').is(':checked') && fa.find('[name=confirmed_diagnosis]').val() < 1) {
	    errorMsg += "- Missing Confirmed Diagnosis\n";
	}

	if (errorMsg != '') {
	    alert(errorMsg);
	}
	
	return (errorMsg == '');
}

function addSurgery () {
  var $newRows = $('tr.surgery-row.new-row')
  var $lastRow = $('tr.surgery-row:last')
  var $date = $lastRow.find('input.surgery-date')
  var $surgeon = $lastRow.find('input.surgery-surgeon')
  var $surgery = $lastRow.find('input.surgery-surgery')
  var rows = $newRows.length
  var template =
    '<tr class="surgery-row new-row" id="new-surgery-{id}">' +
      '<td>' +
        '<input type="text" class="surgery-date"  name="new_surgeries[{id}][date]" />' +
      '</td>' +
      '<td>' +
        '<input type="text" class="surgery-surgeon" name="new_surgeries[{id}][surgeon]" />' +
      '</td>' +
      '<td>' +
        '<input type="text" class="surgery-surgery" name="new_surgeries[{id}][surgery]" />' +
      '</td>' +
      '<td>' +
        '<input type="button" value="Delete" onclick="deleteSurgery(\'new-surgery-{id}\'); return false;" />' +
      '</td>' +
    '</tr>'
  var $newRow = $(template.replace(/\{id\}/g, rows))

  $newRow.find('.surgery-date').val($date.val())
  $newRow.find('.surgery-surgeon').val($surgeon.val())
  $newRow.find('.surgery-surgery').val($surgery.val())

  $date.val('')
  $surgeon.val('')
  $surgery.val('')

  $newRow.insertBefore($lastRow)
}

function deleteSurgery (id) {
  var $row = $('#' + id)
  if ($row.is('.original-row')) {
    $row.find('.surgery-deleted')
      .val(1)
    $row.hide()
    return
  }
  $row.remove()
}
