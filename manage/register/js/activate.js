$(document).ready(function(){
    send_text("load", false, getParameterByName('id'), getParameterByName('hash'), phone);

    /* Using custom settings */    
    $("a#saas_agree_but").fancybox({
        'hideOnContentClick': true
    });
    
    $("a#hipaa_agree_but").fancybox({
        'hideOnContentClick': true
    });
});

function send_text(from, but, idGet, hashGet, phone)
{
    but.disabled = true;
    $('#text_instructions').hide('slow');
    $.ajax({
        url: 'includes/send_access_text.php',
        type: 'post',
        data: {id: idGet, hash: hashGet},
        success: function( data ) {
            var r = $.parseJSON(data);
            if (r.success) {
                if(from == "button") {
                    $('#sent_text').html("Text message sent! Please allow up to 1 minute to receive the message, then enter your access code on this page.")
                }else{ 
                    $('#sent_text').html("We sent a text message to your phone number ending in -" + phone + ".  Please enter the code we sent you.").show('slow');
                }
            } else {
                if(r.error == "cell"){
                    $('#sent_text').html("Error: Cell phone not found.").show('slow');   
                }else if(r.error == "limit"){
                    $('#sent_text').html("Error: You have exceeded the maximum number of text message access code attempts for phone number ending in -" + phone + ". Please wait one hour and try again.").show('slow');   
                }else if(r.error == "inactive"){
                    $('#sent_text').html("Error: Text feature disabled.").show('slow');   
                }else{
                    $('#sent_text').html("Error.").show('slow');
                }
            }
            but.disabled = false;
        }
    });
}

function register()
{
    var e = $('#email').val();
    var c = $('#code').val();
    var agreement = $('#agreement').is(':checked');
    if(!agreement){
        $('#sent_text').html("Error: You must agree to user and HIPAA agreements.").show('slow');
    } else {
        $.ajax({
            url: 'includes/setup_register.php',
            type: 'post',
            data: {email: e, code: c },
            success: function( data ) {
                var r = $.parseJSON(data);
                if(r.success){  
                    window.location = "register.php"; 
                } else {
                    if(r.error == "code"){
                        $('#sent_text').html("Incorrect text message code!").show('slow');   
                    } else {
                        $('#sent_text').html("Error.").show('slow');
                    }
                }
            }
        });
    }
}