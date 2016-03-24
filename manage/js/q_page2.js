edited = false;

$(document).ready(function() {
	$(':input:not(#patient_search)').change(function() { 
		edited = true;
		//window.onbeforeunload = confirmExit;
	});
	$('#q_page2frm').submit(function() {
		window.onbeforeunload = null;
	});
});

function confirmExit()
{
	return "You have attempted to leave this page.  If you have made any changes to the fields without clicking the Save button, your changes will be lost.  Are you sure you want to exit this page?";
}

function chk_poly()
{ 	
	fa = document.q_page2frm;
	if(fa.polysomnographic[0].checked) {
		$('.poly_options').show();
	} else {
		$('.poly_options').hide();
	}
}

function other_chk1()
{ 	
	fa = $('[name=q_page2frm]');
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
    fa = document.q_page2frm;
    if(fa.dd_wearing[0].checked || fa.dd_prev[0].checked) {
        $('.dd_options').show();
    } else {
		$('.dd_options').hide();
	}
}

function chk_s()
{       
    fa = document.q_page2frm;
    if(fa.surgery[0].checked) {
        $('.s_options').show();
    } else {
        $('.s_options').hide();
    }
}

function chk_cpap()
{ 	
	fa = document.q_page2frm;
	chk_l = document.getElementsByName('intolerance[]').length;
	if(fa.cpap[1].checked) {
		$('.cpap_options').hide();
		$('.cpap_options2').hide();
	} else {
		$('.cpap_options').show();
		if(fa.cur_cpap[0].checked) {
		    $('.cpap_options2').show();
		} else {
		    $('.cpap_options2').hide();
		}
	}
}

function q_page2abc(fa)
{
    var errorMsg = '';
	if (trim(fa.sleep_study_on.value) != '') { 
		if (is_date(trim(fa.sleep_study_on.value)) == -1 ||  is_date(trim(fa.sleep_study_on.value)) == false) {
			errorMsg += "- Invalid Date Format, Valid Format : (mm/dd/YYYY);\n";
			fa.sleep_study_on.focus();
		}
	}
	
	if (document.getElementById('polysomnographic_yes').checked && trim(fa.confirmed_diagnosis.selectedIndex) < 1) {
	    errorMsg += "- Missing Confirmed Diagnosis\n";
	}

	if (errorMsg != '') {
	    alert(errorMsg);
	}
	
	return (errorMsg == '');
}

function add_surgery()
{
	n = $('#num_surgery').attr('value');
	$('#surgery_table').append('<tr id="surgery_row_'+n+'"><td><input type="hidden" id="surgery_id_'+n+'" name="surgery_id_'+n+'" value="0" /><input type="text" id="surgery_date_'+n+'" name="surgery_date_'+n+'" /></td><td><input type="text" id="surgeon_'+n+'" name="surgeon_'+n+'" /></td><td><input type="text" id="surgery_'+n+'" name="surgery_'+n+'" /></td><td><input type="button" name="delete_'+n+'" value="Delete" onclick="delete_surgery(\''+n+'\'); return false;" /></td></tr>');				
	$('#num_surgery').attr('value', (parseInt(n,10)+1));
}

function delete_surgery(n)
{
	$('#surgery_date_'+n).val('');
	$('#surgeon_'+n).val('');
	$('#surgery_'+n).val('');
	$('#surgery_row_'+n).hide();
}