$(document).ready(function(){
	$("[id^=sleeplab]").change(function(){
		if ($(this).val() == "add new sleeplab") {
			parent.window.location="/manage/add_sleeplab.php";
		}
	});
});
