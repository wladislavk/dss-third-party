$(document).ready(function(){
	$("[id^=sleeplabwheresched]").change(function(){
		if ($(this).val() == "add new sleeplab") {
			alert("Test.");
			//loadPopup("add_sleeplab.php");
		}
	});
});
