$(document).ready(function(){
    $('#notecontent input').change(function(){
        window.onbeforeunload = function() { 
            return 'You have made changes to Notes/Personal and have not saved your changes. Click OK to leave the page, or Cancel to return and save your changes.';
        }
    });

    $('#rom_form input').change(function(){
        window.onbeforeunload = function() { 
            return 'You have made changes to ROM data and have not saved your changes. Click OK to leave the page, or Cancel to return and save your changes.';
        }
    });
});

$('#dental_device').change( function(){
    var val = $('#dental_device').val();
    var pid = getParameterByName('pid');
    alert('change');
    $.ajax({
        url: "includes/summ_device_update.php",
        type: "post",
        data: {device: val, pid: pid},
        success: function(data){
            //alert(data);
            var r = $.parseJSON(data);
            if(r.error){
            }else{
            }
        },
        failure: function(data){
            //alert('fail');
        }
    });
});


function update_dental_device_date(){
    var val = $('#dental_device_date').val();
    var pid = getParameterByName('pid');
    $.ajax({
        url: "includes/summ_device_date_update.php",
        type: "post",
        data: {device_date: val, pid: pid},
        success: function(data){
            //alert(data);
            var r = $.parseJSON(data);
            if(r.error){
            }else{
            }
        },
        failure: function(data){
            //alert('fail');
        }
    });
}