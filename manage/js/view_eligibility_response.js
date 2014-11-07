$(document).ready(function() {
	var coverage = new Coverage(response);
	
	if (coverage.hasError()) {
		buildError(coverage.parseError());
	} else {
		buildCoverageHTML(coverage);
	}
});