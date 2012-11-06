$(document).ready(function(){
	$("#p_m_relation").change(function(){
		if ($(this).val() == "Self") {
                        $("#ins_dob_month").val($('#dob_month').val());
			$("#ins_dob_day").val($('#dob_day').val());
                        $("#ins_dob_year").val($('#dob_year').val());
			$("#p_m_partyfname").val($("#firstname").val());
                        $("#p_m_partymname").val($("#middlename").val());
                        $("#p_m_partylname").val($("#lastname").val());
		}
	});
	$("#s_m_relation").change(function(){
		if ($(this).val() == "Self") {
			$("#ins2_dob_month").val($('#dob_month').val());
                        $("#ins2_dob_day").val($('#dob_day').val());
                        $("#ins2_dob_year").val($('#dob_year').val());
                        $("#s_m_partyfname").val($("#firstname").val());
                        $("#s_m_partymname").val($("#middlename").val());
                        $("#s_m_partylname").val($("#lastname").val());
		}
	});
});
