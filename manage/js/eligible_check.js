function disable_submit (){
    console.log("disabled");
    $('#submit-button').css('background-color', '#999999');
    $('#submit-button').prop("disabled",true);
    $('#submit-button-inner').replaceWith('<img id="submit-button-inner" src="/manage/images/DSS-ajax-animated_loading-gif.gif"></img>');

}

function enable_submit (){
    console.log("enabled");
    $('#submit-button').css('background-color', '#428bca');
    $('#submit-button').prop("disabled",false);
    $('#submit-button-inner').replaceWith('<div id="submit-button-inner">Submit</div>');
}

$(document).ready(function(){
    var api_key = <?php echo "'".$api_key."'" ?>;
    setup_autocomplete_local('payer_name', 'ins_payer_hints', 'payer_id', '', 'https://gds.eligibleapi.com/v1.5/payers.json?api_key='+api_key, 'ins_payer', '', true, false);
    $('.form-coverage').bind("submit", disable_submit);
});

function autoResize(id){
    var newheight;
    var newwidth;

    document.getElementById(id).height= (newheight) + "px";

    if(document.getElementById){
        newheight=document.getElementById(id).contentWindow.document .body.scrollHeight;
        newwidth=document.getElementById(id).contentWindow.document .body.scrollWidth;
    }

    document.getElementById(id).height= (newheight) + "px";
    document.getElementById(id).width= (newwidth) + "px";
}

function view_coverage(response){
    enable_submit();
	var coverage = new Coverage(response);

	if (coverage.hasError()) {
		buildError(coverage.parseError());
	} else {
		buildCoverageHTML(coverage);
	}
}