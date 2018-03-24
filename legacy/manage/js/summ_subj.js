$(document).ready(function(){
	$('#hideshow2section2 input').change(function(){
		console.log('qwe');
		$(this).parents('form:first').find('td').css('background', 'rgb(173, 216, 230)');
			window.onbeforeunload = function(){
			return 'You have made changes to a Test and have not saved your changes. Click OK to leave the page, or Cancel to return and save your changes.';
		}
	});
	
	$('#hideshow2section2 input').change(function(){
		$(this).parents('form:first').find('td').css('background', 'rgb(173, 216, 230)');
		window.onbeforeunload = function(){
			return 'You have made changes to a Test and have not saved your changes. Click OK to leave the page, or Cancel to return and save your changes.';
		}
	})
});