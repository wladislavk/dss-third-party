$(document).ready(function(){
	setup_autocomplete_local('payer_name', 'ins_payer_hints', 'payer_id', '', 'https://eligibleapi.com/resources/payers/eligibility.json', 'ins_payer', '', true, false);
});

function view_coverage(response){
	var coverage = new Coverage(response);
	
	if (coverage.hasError()) {
		buildError(coverage.parseError());
	} else {
		buildCoverageHTML(coverage);
	}
}