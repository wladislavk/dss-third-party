function updateTeeth(teeth){
    $('.tooth_image').each( function(index){
       s = $(this).attr('src');
       $(this).attr('src', s.replace('_red', ''));
    });
    teeth = teeth.replace(/\s+/g, '');
    ts = teeth.split(',');
    console.info(teeth);
    console.info(ts);
    for(var tn in ts){
        t = ts[tn];
        console.info('[id="missing_' + t + '"]');
        $('[id="missing_' + t + '"]').attr('src', 'missing_teeth/'+t+'_red.png');
    }
}

function submit_form(){
    $('#missingfrm').submit();
}

$(document).ready(function(){
    $("input").keyup(function(){
        move_cursor(parseInt($(this).attr('tabindex'),10));
    });

    function move_cursor(p){
        if($('input[tabindex="'+(p+1)+'"]').is(":disabled")){
            move_cursor(p+1);
        }else{
            $('input[tabindex="'+(p+1)+'"]').focus();
        }
    }
    //var inputs = $(this).closest('form').find(':input');
    //inputs.eq( inputs.index(this)+ 1 ).focus();
});