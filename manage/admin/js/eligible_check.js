function disable_submit (){
    $('#submit-button').css('background-color', '#999999');
    $('#submit-button').disabled = true;
    $('#submit-button-inner').replaceWith('<img src="/manage/images/DSS-ajax-animated_loading-gif.gif"></img>');
}

$(document).ready(function(){
  var api_key = <?php echo "'".$api_key."'" ?>;
  setup_autocomplete_local('payer_name', 'ins_payer_hints', 'payer_id', '', 'https://gds.eligibleapi.com/v1.4/payers.json?api_key='+api_key, 'ins_payer', '', true, false);
});

function view_coverage(response){
	var coverage = new Coverage(response);
	
	if (coverage.hasError()) {
		buildError(coverage.parseError());
	} else {
		buildCoverageHTML(coverage);
	}
}