$(document).ready(function(){
	$("#preferredcontact").change(function(){
		if ($(this).val() == "email" && $("#email").val() == "") {
			alert("You must enter an email address to use email as the preferred contact method.");
			$("#email").focus();
		}
		else if ($(this).val() == "fax" && $("#fax").val() == "") {
			alert("You must enter a fax number to use email as the preferred contact method.");
			$("#fax").focus();
		}
	});
});
