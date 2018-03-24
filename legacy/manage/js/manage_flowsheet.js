function t_type()
{
	fa = document.flowsheetfrm;
	
	if(fa.select_type.value == 'Need ambulatory sleep study') {
		document.getElementById("beginning_section").style.display = "none";
		document.getElementById("ambulatory_section").style.display = "";
		document.getElementById("psg_section").style.display = "none";
		document.getElementById("not_patient_section").style.display = "none";
	} else if(fa.select_type.value == 'Need PSG sleep study') {
		document.getElementById("beginning_section").style.display = "none";
		document.getElementById("ambulatory_section").style.display = "none";
		document.getElementById("psg_section").style.display = "";
		document.getElementById("not_patient_section").style.display = "none";
	} else if(fa.select_type.value == 'Patient not doing device') {
		document.getElementById("beginning_section").style.display = "none";
		document.getElementById("ambulatory_section").style.display = "none";
		document.getElementById("psg_section").style.display = "none";
		document.getElementById("not_patient_section").style.display = "";
	} else {
		document.getElementById("beginning_section").style.display = "";
		document.getElementById("ambulatory_section").style.display = "none";
		document.getElementById("psg_section").style.display = "none";
		document.getElementById("not_patient_section").style.display = "none";
	}
}

function t_type1()
{
	fa = document.flowsheetfrm;
	
	if(fa.select_type1.value == 'Need PSG sleep study') {
		document.getElementById("beginning_section").style.display = "none";
		document.getElementById("ambulatory_section").style.display = "none";
		document.getElementById("psg_section").style.display = "";
		document.getElementById("not_patient_section").style.display = "none";
	}

	if(fa.select_type1.value == 'Patient not doing device') {
		document.getElementById("beginning_section").style.display = "none";
		document.getElementById("ambulatory_section").style.display = "none";
		document.getElementById("psg_section").style.display = "none";
		document.getElementById("not_patient_section").style.display = "";
	}

	if(fa.select_type1.value == 'Beginning Treatment') {
		document.getElementById("beginning_section").style.display = "";
		document.getElementById("ambulatory_section").style.display = "none";
		document.getElementById("psg_section").style.display = "none";
		document.getElementById("not_patient_section").style.display = "none";
	}
}

function pt_1()
{
	fa = document.flowsheetfrm;
	
	if(fa.pt_not_ss.checked) {
		document.getElementById("ss_date_requested").disabled = true;
		document.getElementById("ss_date_requested1").style.display = 'none';
		document.getElementById("ss_date_received").disabled = true;
		document.getElementById("ss_date_received1").style.display = 'none';
	} else {
		document.getElementById("ss_date_requested").disabled = false;
		document.getElementById("ss_date_requested1").style.display = '';
		document.getElementById("ss_date_received").disabled = false;
		document.getElementById("ss_date_received1").style.display = '';
	}
}