function disable_submit (){
    $('#submit-button').css('background-color', '#999999');
    $('#submit-button').disabled = true;
    $('#submit-button-inner').replaceWith('<img src="/manage/images/DSS-ajax-animated_loading-gif.gif"></img>');
}

$(document).ready(function(){
    var api_key = <?php echo "'".$api_key."'" ?>;
    setup_autocomplete_local('payer_name', 'ins_payer_hints', 'payer_id', '', 'https://gds.eligibleapi.com/v1.5/payers.json?api_key='+api_key, 'ins_payer', '', true, false);
    $('#submit-button').on("click",null ,null , disable_submit);
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