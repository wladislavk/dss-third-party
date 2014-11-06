function change_desc()
{
	var fa = $("select[name='title']").prop("selectedIndex") - 1;

	if(fa > -1) {
		$('#description').val(desc_arr[fa]);
	} else {
		$('#description').val("");
	}
}