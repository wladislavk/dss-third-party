function updateiframe(w){
    //$('#sleepstudies').css('width', ((w+1)*185)+'px');
}

function show_new_study(){
    $('#new_sleep_study_but').hide();
    document.getElementById('sleepstudies').contentWindow.show_new_study();
}

function show_new_sleep_but(){
    $('#new_sleep_study_but').show();
}

function show_study_table(){
    show_new_study();
    $('#no_sleep_studies_div').hide();
    $('#sleep_studies_div').show();
}

function updatelabs(i,c,s){
    $('#sleepstudies').contents().find('.place_select').append("<option value='"+i+"'>"+c+"</option>");
  	if(s){
        $('#'+s).val(i);
  	}
    disablePopupClean();
}

function updateContactField(inField, inVal, idField, idVal){
    $('#'+inField).val(inVal);
    $('#'+idField).val(idVal);
}

$(document).ready(function(){
    $('.sleeplabstable input').change(function(){
        $(this).parents('form:first').find('td').css('background', 'rgb(173, 216, 230)');
        window.onbeforeunload = function(){
            return 'You have made changes to a Test and have not saved your changes. Click OK to leave the page, or Cancel to return and save your changes.';
        }
    })
});

