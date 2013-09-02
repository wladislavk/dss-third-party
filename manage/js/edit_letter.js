function edit_letter(divid, size, family) {
  var html = $("#" + divid).html();
	if (html != '') {
		var textarea = $("<textarea />");
		textarea.val(html);
		textarea.attr('name', divid);
		textarea.attr('style','width:940px;height:335px;');
		$("#" + divid).replaceWith(textarea);
		tinyMCE.init({
			mode : "textareas",
			theme : "advanced",
			theme_advanced_buttons1 : "bold,italic,underline, separator, bullist ,numlist, separator,justifyleft, justifycenter,justifyright,  justifyfull, separator,help",
			theme_advanced_buttons2 : "",
			theme_advanced_buttons3 : "",
			gecko_spellcheck : true,
			theme_advanced_toolbar_location : "top",
			theme_advanced_toolbar_align : "left",
			entities: "194,Acirc,34,quot,162,cent,8364,euro,163,pound,165,yen,169,copy,174,reg,8482,trade",
			content_css : "css/font"+size+".css,css/font"+family+".css"
		});
		textarea.focus();
		$('.edit_'+divid).show();
		//$('#send_but_'+divid).hide();
	}
}
