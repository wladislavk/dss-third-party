function delete_segment (id) {
    var pid = getParameterByName('pid');
    if (confirm('Are you sure you want to delete this appointment?')) {
        $.ajax({
            url: "/manage/includes/delete_appt.php",
            type: "post",
            data: {
                id: id,
                pid: pid
            },
            success: function(data){
                //alert(data);
                var r = $.parseJSON(data);
                
                if (r.error) {
                    if (r.error == 'sent') {
                        //alert('Letter sent');
                    }
                }
                else {
                    $('#completed_row_'+id).remove();
                }
            },
            failure: function(data){
                //alert('fail');
            }
        });
    }
    else {
        return false;
    }
}

function update_completed_date (cid) {
    id = cid.substring(15);
    comp_date = $('#completed_date_'+id).val();
    var pid = getParameterByName('pid');
    
    $.ajax({
        url: "/manage/includes/update_appt.php",
        type: "post",
        data: {
            id: id,
            comp_date: comp_date,
            pid: pid
        },
        success: function(data){
            //alert(data);
            var r = $.parseJSON(data);
            
            if (r.error) {}
            else {}
        },
        failure: function(data){
            //alert('fail');
        }
    });
}

$(document).delegate('.delay_reason', "change", function(){
    id = $(this).attr('id').substring(13);
    reason = $(this).val();
    var pid = getParameterByName('pid');
    
    if ($('#old_delay_reason_'+id).val()=="other" && reason !="other") {
        if(!confirm('Are you sure you want to change the reason?')) {
            $(this).val($('#old_delay_reason_'+id).val());
            return false;
        }
    }
    
    $.ajax({
        url: "/manage/includes/flow_delay_reason_update.php",
        type: "post",
        data: {
            id: id,
            reason: reason,
            pid: pid
        },
        success: function(data){
            //alert(data);
            var r = $.parseJSON(data);
            
            if (r.error) {}
            else {
                if (reason == "other") {
                    $(document).find('#reason_btn'+id).show();
                    loadPopup('flowsheet_other_reason.php?ed='+id+'&pid=112&sid=5');
                }
                else {
                    $(document).find('#reason_btn'+id).hide();
                }
            }
        },
        failure: function(data){
            //alert('fail');
        }
    });
});

$(document).delegate('.noncomp_reason', "change", function () {
    id = $(this).attr('id').substring(14);
    reason = $(this).val();
    var pid = getParameterByName('pid');

    if ($('#old_noncomp_reason_' + id).val() == "other" && reason != "other") {
        if (!confirm('Are you sure you want to change the reason?')) {
            $(this).val($('#old_noncomp_reason_' + id).val());
            return false;
        }
    }
    
    $.ajax({
        url: "/manage/includes/flow_noncomp_reason_update.php",
        type: "post",
        data: {
            id: id,
            reason: reason,
            pid: pid
        },
        success: function (data) {
            //alert(data);
            var r = $.parseJSON(data);
            if (r.error) {} else {
                if (reason == "other") {
                    $(document).find('#reason_btn' + id).show();
                    loadPopup('flowsheet_other_reason.php?ed=' + id + '&pid=112&sid=5');
                } else {
                    $(document).find('#reason_btn' + id).hide();
                }

            }
        },
        failure: function (data) {
            //alert('fail');
        }
    });
});


$(document).delegate('.dentaldevice', "change", function () {
    id = $(this).attr('id').substring(13);
    device = $(this).val();
    var pid = getParameterByName('pid');

    $.ajax({
        url: "/manage/includes/flow_device_update.php",
        type: "post",
        data: {
            id: id,
            device: device,
            pid: pid
        },
        success: function (data) {
            //alert(data);
            var r = $.parseJSON(data);
            if (r.error) {} else {}
        },
        failure: function (data) {
            //alert('fail');
        }
    });
});

$(document).delegate('.study_type', "change", function () {
    id = $(this).attr('id').substring(11);
    type = $(this).val();
    var pid = getParameterByName('pid');

    $.ajax({
        url: "/manage/includes/flow_study_type_update.php",
        type: "post",
        data: {
            id: id,
            type: type,
            pid: pid
        },
        success: function (data) {
            //alert(data);
            var r = $.parseJSON(data);
            if (r.error) {} else {}
        },
        failure: function (data) {
            //alert('fail');
        }
    });
});


function getParameterByName(name) {
    name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
        results = regex.exec(location.search);
    return results == null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
}