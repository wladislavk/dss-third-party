function edit_letter(divid) {
  var html = $("#" + divid).html();
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
    theme_advanced_toolbar_align : "left"
  });
  textarea.focus();
}
