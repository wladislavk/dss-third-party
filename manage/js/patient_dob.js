$(document).ready(function(){
	$("#p_m_relation").change(function(){
		if ($(this).val() == "Self") {
			var dob = $("#dob").val();
			$("#ins_dob").val(dob);
		}
	});
	$("#s_m_relation").change(function(){
		if ($(this).val() == "Self") {
			var dob = $("#dob").val();
			$("#ins2_dob").val(dob);
		}
	});
});
