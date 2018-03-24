$(document).ready(function(){
	$("[id^=sleeplab]").change(function(){
		if ($(this).val() == "add new sleeplab") {
			//alert("Test.");
			//loadPopup("add_sleeplab.php");
			parent.window.location="/manage/add_sleeplab.php";
		}
	});
});
