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
                if(r.error){
                }else{
                    //window.location.reload();
                }
        },
        failure: function(data){
            //alert('fail');
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
                if(r.error){
                }else{
                    //window.location.reload();
                }
        },
        failure: function(data){
            //alert('fail');
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

//use "?filter="+v+"&sort1=<?php echo  $_GET['sort1']; ?>&dir1=<?php echo $_GET['dir1']; ?>&sort2=<?php echo  $_GET['sort2']; ?>&dir2=<?php echo  $_GET['dir2']; ?>" for variable page 
function updateClaims(page)
{
    window.location = page;
}