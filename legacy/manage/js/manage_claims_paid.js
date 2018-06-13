$('.mailed_chk').click( function(){
    lid = $(this).val();
    c = $(this).is(':checked');
    type = 'pri';
    $.ajax({
        url: "includes/claim_mail.php",
        type: "post",
        data: {lid: lid, mailed: c, type:type},
        success: function(data){
                var r = $.parseJSON(data);
        },
        failure: function(data){
        }
    });
});

$('.sec_mailed_chk').click( function(){
    lid = $(this).val();
    c = $(this).is(':checked');
    type = 'sec';
    $.ajax({
        url: "includes/claim_mail.php",
        type: "post",
        data: {lid: lid, mailed: c, type:type},
        success: function(data){
                var r = $.parseJSON(data);
        },
        failure: function(data){
        }
    });
});

$('document').ready( function(){
    var v = filter;
    if(v == '100'){
        $('.claim').show();
    }else if(v == DSS_CLAIM_PENDING){
        $('.claim').hide();
        $('.status_' + DSS_CLAIM_PENDING).show();
        $('.status_' + DSS_CLAIM_SEC_PENDING).show();
    }else if(v == DSS_CLAIM_PAID_INSURANCE){
        $('.claim').hide();
        $('.status_' + DSS_CLAIM_PAID_INSURANCE).show();
        $('.status_' + DSS_CLAIM_PAID_SEC_INSURANCE).show();
        $('.status_' + DSS_CLAIM_PAID_PATIENT).show();
    }else if(v == DSS_CLAIM_SENT){
        $('.claim').hide();
        $('.status_' + DSS_CLAIM_SENT).show();
        $('.status_' + DSS_CLAIM_SEC_SENT).show();
    }else if(v == DSS_CLAIM_DISPUTE){
        $('.claim').hide();
        $('.status_' + DSS_CLAIM_DISPUTE).show();
        $('.status_' + DSS_CLAIM_SEC_DISPUTE).show();
    }else if(v == DSS_CLAIM_REJECTED){
        $('.claim').hide();
        $('.status_' + DSS_CLAIM_REJECTED).show();
    }
});

function updateClaims(page)
{
    window.location = page;
}