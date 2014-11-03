$(document).ready(function() {
	$('[id^=edit]').click(function() {
		var r = confirm("Do you want to replace the image on file? This cannot be undone.");
		if (r == true) {
			var edit_id = $(this).attr('id');
			var num = edit_id.replace("edit", "");
			$('#view'+num).css("display", "none");
			$('#edit'+num).css("display", "none");
			$('#file'+num).css("display", "inline");
		}
	});

	$(':input').change(function() { 
		parent.window.onbeforeunload = confirmExit;
		parent.document.form_page1.iframestatus.value = "dirty";
	});

	$('[id^=sleepstudy]').submit(function() {
		parent.document.form_page1.iframestatus.value = "clean";
	});

	function confirmExit()
	{
		return "You have attempted to leave this page.  If you have made any changes to the fields without clicking the Save button, your changes will be lost.  Are you sure you want to exit this page?";
	}
});

function formshowhide(status, val)
{
	alert('YES');
	if(status == 'Yes' || status === true){
		document.getElementById(val).scheddate.style.display='inline';
		document.getElementById(val).sleeplabwheresched.style.display='inline';
		document.getElementById(val).completed.style.display='inline';
		document.getElementById(val).interpolation.style.display='inline';
		document.getElementById(val).labtype.style.display='inline';
		document.getElementById(val).copyreqdate.style.display='inline';
	}else if(status == 'No' || status === false){
		alert('YES');
		document.getElementById(val).scheddate.style.display='none';
		document.getElementById(val).sleeplabwheresched.style.display='none';
		document.getElementById(val).completed.style.display='none';
		document.getElementById(val).interpolation.style.display='none';
		document.getElementById(val).labtype.style.display='none';
		document.getElementById(val).copyreqdate.style.display='none';
	}
}

function popitup(url)
{
	newwindow = parent.window.open(url,'name','height=400,width=400');
	if (window.focus) {newwindow.focus()}
	return false;
}

function autoselect(selectedOption, updateCompleted)
{
	if(selectedOption.value == "No") {
		updateCompleted[0].checked = true;
	} else {
		updateCompleted[1].checked = true;
	}
}

function otherSelect(number, f)
{
	var list = document.sleepstudyadd.labtype;
	var chosenItemText = list.value;
	
	if (chosenItemText == "PSG") {
		document.getElementById('interpretation'+number+'1').style.visibility = 'hidden';
		document.getElementById('interpretation'+number+'2').style.visibility = 'hidden';
		document.getElementById('interpretation'+number+'3').style.visibility = 'hidden';
		document.getElementById('interpretation'+number+'4').style.visibility = 'hidden';
		
		if($('input:radio[name=needed]:checked').val()=="Yes"){
			f.sleeplabwheresched.style.display = "block";
		}else{
			f.sleeplabwheresched.style.display = "none";
		}
		//f.sleeplabschedhome.style.display = "none";
	} else {
		document.getElementById('interpretation'+number+'1').style.visibility = 'visible';
		document.getElementById('interpretation'+number+'2').style.visibility = 'visible';
		document.getElementById('interpretation'+number+'3').style.visibility = 'visible';
		document.getElementById('interpretation'+number+'4').style.visibility = 'visible';
	
		//f.sleeplabwheresched.style.display = "none";
		if($('input:radio[name=needed]:checked').val()=="Yes"){
			f.sleeplabsched.style.display = "block";
		}else{
			f.sleeplabsched.style.display = "none";
		}
	}
}

function showWhere(f)
{
	var id = f.formid.value;
	var sleeplabwheresched = document.getElementById('sleeplabwheresched'+id);
	var sleeplabschedhome = document.getElementById('sleeplabschedhome'+id);
	var labtype = document.getElementById('labtype'+id);
	sleeplabwheresched.style.display = "block";
}

function hideWhere(f)
{
	var id = f.formid.value;
	var sleeplabwheresched = document.getElementById('sleeplabwheresched'+id);
	var sleeplabschedhome = document.getElementById('sleeplabschedhome'+id);
	sleeplabwheresched.style.display = "none";
}