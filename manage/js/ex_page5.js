edited = false;

$(document).ready(function() {
	$(':input:not(#patient_search)').change(function() { 
		edited = true;
	});

	$('#ex_page5frm').submit(function() {
		window.onbeforeunload = null;
	});
});

function setDefaults()
{
	$('#topcb select').val(0).attr('selected', 'selected');
}

function confirmExit()
{
	return "You have attempted to leave this page.  If you have made any changes to the fields without clicking the Save button, your changes will be lost.  Are you sure you want to exit this page?";
}

function chk_normal()
{
	fa = document.ex_page5frm;
	
	if(fa.range_normal.checked) {
		fa.i_opening_from.disabled = true;
		fa.protrusion_from.disabled = true;
		fa.protrusion_to.disabled = true;
		fa.protrusion_equal.disabled = true;
		fa.l_lateral_from.disabled = true;
		fa.r_lateral_from.disabled = true;
		fa.deviation_from.disabled = true;
		fa.deflection_from.disabled = true;
		fa.deviation_r_l.disabled = true;
		fa.deflection_r_l.disabled = true;
	} else {
		fa.i_opening_from.disabled = false;
		fa.protrusion_from.disabled = false;
		fa.protrusion_to.disabled = false;
		fa.protrusion_equal.disabled = false;
		fa.l_lateral_from.disabled = false;
		fa.r_lateral_from.disabled = false;
		fa.deviation_from.disabled = false;
		fa.deflection_from.disabled = false;
		fa.deviation_r_l.disabled = false;
		fa.deflection_r_l.disabled = false;
	}
}

function updateProtrusion()
{
	pval = Math.abs($('#protrusion_to').val() - $('#protrusion_from').val());
	$('#protrusion_equal').val(pval);
}

function check_georges(f)
{
	var to = f.protrusion_to.value;
	var from = f.protrusion_from.value;
	
	if(to != ''  && from != ''){
		alert("This number will be updated automatically when you adjust the 'George Scale' values.");
	}
}