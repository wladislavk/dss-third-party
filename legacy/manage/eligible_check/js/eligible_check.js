function disable_submit (){
  $('#submit-button').css('background-color', '#999999');
  $('#submit-button').prop("disabled",true);
  $('#submit-button-inner').replaceWith('<img id="submit-button-inner" src="/manage/images/DSS-ajax-animated_loading-gif.gif"></img>');

}

function disable_submit_medicare(){
  $('#submit-button-medicare').css('background-color', '#999999');
  $('#submit-button-medicare').prop("disabled",true);
  $('#submit-button-medicare-inner').replaceWith('<img id="submit-button-medicare-inner" src="/manage/images/DSS-ajax-animated_loading-gif.gif"></img>');
}

function view_coverage(response){
  var coverage = new Coverage(response);
  if (coverage.hasError()) {
    buildError(coverage.parseError());
  } else {
    buildCoverageHTML(coverage);
  }
}

$('document').ready(function(){
  var api_key = typeof eligibleApiKey === 'undefined' ? '' : eligibleApiKey;
  setup_autocomplete_local('payer_name', 'ins_payer_hints', 'payer_id', '', 'https://gds.eligibleapi.com/v1.5/payers.json?api_key='+api_key, 'ins_payer', '', true, false);
  $('#test_no, #test_yes').click(function(){
    parent.autoResize('eligible');
  });
  $('.form-coverage').bind("submit", disable_submit);
  $('#submit-button-medicare').on("click", disable_submit_medicare);
});
