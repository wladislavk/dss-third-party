function view_coverage(response){
  var coverage = new Coverage(response);
  if (coverage.hasError()) {
    buildError(coverage.parseError());
  } else {
    buildCoverageHTML(coverage);
  }
}

$('document').ready(function(){
  setup_autocomplete_local('payer_name', 'ins_payer_hints', 'payer_id', '', 'https://eligibleapi.com/resources/payers/eligibility.json', 'ins_payer', '', true, false);
  $('#test_no, #test_yes').click(function(){
    parent.autoResize('eligible');
  });
});