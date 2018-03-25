function disable_submit (){
    $('#submit-button').css('background-color', '#999999');
    $('#submit-button').prop("disabled",true);
    $('#submit-button-inner').replaceWith('<img id="submit-button-inner" src="/manage/images/DSS-ajax-animated_loading-gif.gif"></img>');

}

function enable_submit (){
    $('#submit-button').css('background-color', '#428bca');
    $('#submit-button').prop("disabled",false);
    $('#submit-button-inner').replaceWith('<div id="submit-button-inner">Submit</div>');
}

function disable_submit_medicare(){
    $('#member_id').val('MEDICARE-'+$('#member_id').val());
    $('#submit-button-medicare').css('background-color', '#999999');
    $('#submit-button-medicare').prop("disabled",true);
    $('#submit-button-medicare-inner').replaceWith('<img id="submit-button-medicare-inner" src="/manage/images/DSS-ajax-animated_loading-gif.gif"></img>');
}

function enable_submit_medicare(){
    $('#member_id').val($('#member_id').val().replace('MEDICARE-',''));
    $('#submit-button-medicare').css('background-color', '#428bca');
    $('#submit-button-medicare').prop("disabled",false);
    $('#submit-button-medicare-inner').replaceWith('<div id="submit-button-medicare-inner">Medicare Check</div>');
}

$(document).ready(function(){
  var api_key = typeof eligibleApiKey === 'undefined' ? 'NotSet' : eligibleApiKey;
  setup_autocomplete_local('payer_name', 'ins_payer_hints', 'payer_id', '', 'https://gds.eligibleapi.com/v1.5/payers.json?api_key='+api_key, 'ins_payer', '', true, false);
  $('.form-coverage').on("submit", disable_submit);
  $('#submit-button-medicare').on("click", disable_submit_medicare);
});

function view_coverage(response){
    enable_submit();
    enable_submit_medicare();
	var coverage = new Coverage(response);
	
	if (coverage.hasError()) {
		buildError(coverage.parseError());
	} else {
		buildCoverageHTML(coverage);
	}
}