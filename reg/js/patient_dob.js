$(document).ready(function(){
	$("#p_m_relation").change(function(){
		if ($(this).val() == "Self") {
			var dob = $("#dob").val();
			$("#ins_dob_day").val(dob.getDay());
			$("#p_m_partyfname").val($("#firstname").val());
                        $("#p_m_partymname").val($("#middlename").val());
                        $("#p_m_partylname").val($("#lastname").val());
		}
	});
	$("#s_m_relation").change(function(){
		if ($(this).val() == "Self") {
			var dob = $("#dob").val();
			$("#ins2_dob").val(dob);
                        $("#s_m_partyfname").val($("#firstname").val());
                        $("#s_m_partymname").val($("#middlename").val());
                        $("#s_m_partylname").val($("#lastname").val());
		}
	});
});
