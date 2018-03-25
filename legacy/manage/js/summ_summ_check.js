function check_georges(f){
    var to = f.ir_min.value;
    var from = f.ir_max.value;
    if(to != ''  && from != ''){
        alert("This number will be updated automatically when you adjust the 'George Scale' values.");
    }
}

function checkIncisal(){
    min = Number($('#ir_min').val());
    max = Number($('#ir_max').val());
    range = (max-min);
    $('#ir_range').val(range);
    pos = Number($('#i_pos').val());
    dist = Math.abs(pos-min); 
    perc = (dist/range)
    $('#initial_device_titration_equal_h').val(Math.round(dist));
    $('#i_perc').val(Math.round(perc*100));
    if(min != '' && max != ''){
        if((range)<0){
            alert('Minimum must be less than maximum');
            $('#ir_min').focus();
            return false;
        }
        if(pos<min || pos>max){
            alert('Incisal Position value must be between minimum and maximum range.');
            $('#i_pos').focus();
            return false;
        }
    }
    return true;
}

$('document').ready( function(){
    //checkIncisal();
    calcIncisal();
})

function calcIncisal(){
    min = Number($('#ir_min').val());
    max = Number($('#ir_max').val());
    range = (max-min);
    $('#ir_range').val(range);
    pos = Number($('#i_pos').val());
    dist = Math.abs(pos-min); 
    perc = (dist/range)
    $('#initial_device_titration_equal_h').val(Math.round(dist));
    $('#i_perc').val(Math.round(perc*100));
}