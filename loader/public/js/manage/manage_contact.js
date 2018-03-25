$(document).ready(function(){
	setup_autocomplete('contact_name', 'contact_hints', 'contact', '', '/manage/contact/search');
	$('.actions').show();
});

function redirectFromJumpBox(token)
{
	var url = '/manage/contact';
	var data = $('#myjumpbox option:selected').val();
	var selectedIndex = $('#myjumpbox option:selected').index();

	if (selectedIndex == 1) {
		$(location).attr('href', url);
	} else if (selectedIndex > 1) {
		setRouteParameters(url, data, token);
	}
}