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
});