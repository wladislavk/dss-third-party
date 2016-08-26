var fff = 0;
var selectionref = 1;
var selectedrefUrl = '';
var searchrefVal = ""; // global variable to hold the last valid search string
var local_data = "";

function debounceCall (call, options) {
    var timeoutId = 0;

    options = $.extend({
        timeout: 600,
        context: null,
        onTick: null
    }, options);

    return function () {
        var argumentArray = Array.prototype.slice.call(arguments, 0);

        if (timeoutId) {
            clearTimeout(timeoutId);
            timeoutId = 0;
        }

        if (options.onTick) {
            options.onTick.apply(options.context, argumentArray);
        }

        timeoutId = setTimeout(function(){
            call.apply(options.context, argumentArray);
        }, options.timeout);
    };
}

function setup_autocomplete_local (in_field, hint, id_field, source, file, hinttype, pid, id_only, check_enrollment, npi, office_type, endpoint){
    function populateLocalData (cpl) {
        local_data = [];

        for (var i=0; i<cpl.length; i++) {
            if (typeof cpl[i]['names'] === 'undefined' || cpl[i]['names'].length === 0) {
                continue;
            }

            for (var nameIndex = 0; nameIndex < cpl[i]['names'].length; nameIndex++ ) {
                if (!cpl[i]['names'][nameIndex]) {
                    continue;
                }

                local_data.push({
                    payer_id: cpl[i]['payer_id'],
                    payer_name: cpl[i]['names'][nameIndex],
                    enrollment_required: cpl[i]['enrollment_required'],
                    enrollment_mandatory_fields: cpl[i]['enrollment_mandatory_fields']
                });
            }
        }
    }

    function staticEligiblePayerSource () {
        $.getJSON('/manage/eligible_check/eligible-payers.php')
            .done(populateLocalData);
    }

    $.getJSON(file)
        .done(populateLocalData)
        .error(function(){
            if (file.match(/^https:\/\/gds\.eligibleapi\.com\/v1\.5\/payers\.json/)) {
                staticEligiblePayerSource();
            }
        });

    $('#'+in_field).keyup(debounceCall(function(e) {
        var $this = $(e.target);

        $('#'+id_field).val('');
        if(source!=''){
            $('#'+source).val('');
        }
        var a = e.which; // ascii decimal value                                //var c = String.fromCharCode(a);
        var listSize = $('#'+hint+' ul li').size();
        var stringSize = $this.val().length;
        if ($this.val().trim() == "") {
            $('#'+hint).css('display', 'none');
        } else if ((stringSize > 1 || (listSize > 2 && stringSize > 1) || ($this.val() == window.searchVal)) && ((a >= 39 && a <= 122 && a != 40) || a == 8)) { // (greater than apostrophe and less than z and not down arrow) or backspace
            $('#'+hint).css("display", "inline");
            sendValueRef_local($('#'+in_field).val(), in_field, hint, id_field, source, file, hinttype, pid, id_only, check_enrollment, npi, office_type);
            if ($this.val() > 2) {
                window.searchVal = $this.val().replace(/(\s+)?.$/, ""); // strip last character to match last positive result
            }
        }
    }));
}


function sendValueRef_local(partial_name, in_field, hint, id_field, source, file, hinttype, pid, id_only, check_enrollment, npi, office_type) {
//alert(local_data[0].payer_name);
    data = [];
    ld = []
    r = 0
    for(var i=0;i<local_data.length;i++){
        ld[i] = local_data[i].payer_name.toLowerCase().split(" ");
    }
    var pn = partial_name.toLowerCase().split(" ");

    for(var j=0;j<ld.length;j++){
        fail = 0;
        for(var k=0;k<pn.length;k++){
            ldn = ld[j];
            found = 0;
            for(var l=0;l<ldn.length;l++){
                if(ldn[l].indexOf(pn[k]) != -1){
                    found = 1;
                    break;
                }
            }

            if(found==0){
                fail = 1;
                break;
            }
        }
        if(fail == 0){


            data[r] = [];
            if(id_only){
                data[r][0] = local_data[j].payer_id.replace(/(\r\n|\n|\r)/gm,"");
            }else{
                data[r][0] = local_data[j].payer_id.replace(/(\r\n|\n|\r)/gm,"")+"-"+local_data[j].payer_name.replace(/(\r\n|\n|\r)/gm,"");
            }
            data[r][1] = local_data[j].payer_id.replace(/(\r\n|\n|\r)/gm,"")+" - "+local_data[j].payer_name.replace(/(\r\n|\n|\r)/gm,"");
            data[r][2] = local_data[j].onrollment_required;
            data[r][3] = local_data[j].enrollment_mandatory_fields;
            r++;
        }
    }


    if (data.length == 0) {
        $('.json_patient').remove();
        $('.create_new').remove();
        $('.no_matches').remove();
        //$('#search_hints').css('display', 'none');
        var newLi = $('#'+hint+' ul .template').clone(true).removeClass('template').addClass('no_matches');
        template_list_ref_local(newLi, "No Matches")
            .appendTo('#'+hint+' ul')
            .fadeIn();
        if(hinttype=='referrer'){
            var label = "referrer";
        }else if(hinttype=='contact'){
            var label = "contact";
        }else{
            var label = "person";
        }
        if(hinttype != 'eligibility' && hinttype != 'ins_payer'){
            var newLi = $('#'+hint+' ul .template').clone(true).removeClass('template').addClass('create_new')
                .attr("onclick", "loadPopupRefer('add_contact.php?addtopat="+pid+"&from=add_patient&in_field="+in_field+"&id_field="+id_field+"&search="+(partial_name.replace(/'/g, "\\'"))+"')");
            template_list_ref_local(newLi, "Add "+label+" with this name&#8230;")
                .appendTo('#'+hint+' ul')
                .fadeIn();
        }

    }else{
        $('.json_patient').remove();
        $('.create_new').remove();
        $('.no_matches').remove();
        for(i in data) {
            var name = data[i][1];
            if(in_field=="contact_name"){
                var newLi = $('#'+hint+' ul .template')
                    .clone(true)
                    .removeClass('template')
                    .addClass('json_patient')
                    .data('rowid', data[i][0])
                    .data('rowsource', data[i][0])
                    .attr("onclick", "loadPopup('view_contact.php?ed="+data[i][0]+"')"
                    );
            }else{
                var newLi = $('#'+hint+' ul .template')
                    .clone(true)
                    .removeClass('template')
                    .addClass('json_patient')
                    .data('rowid', data[i][0])
                    .data('rowsource', data[i][0])
                    .attr("onclick", "update_referredby_local('"+in_field+"','"+(name.replace(/'/g, "\\'"))+"', '"+id_field+"', '"+data[i][0]+"', '"+source+"', '"+data[i][1]+"','"+hint+"','"+data[i][2]+"', '"+check_enrollment+"', '"+npi+"','"+office_type+"', '"+data[i][3]+"')");
            }
            template_list_ref_local(newLi, name)
                .appendTo('#'+hint+' ul')
                .fadeIn();
        }
    }
}



function template_list_ref_local(li, val) {
    li.html(val);
    return li;
}
function update_referredby_local(in_field, name, id_field, id, source, t, hint, enrollment, check_enrollment, npi, office_type, enrollment_mandatory_fields){

    if(enrollment_mandatory_fields != ''){
        var emf = enrollment_mandatory_fields.split(',');
        $('.formControl').removeClass('required');
        for( var i = 0; i < emf.length; i++){
            $('#'+emf[i]).addClass('required');
            if(emf[i] == 'medicaid_id'){
                alert('Medicaid enrollment is not supported at this time. Please open a support ticket for further assistance.');
            }
        }

    }

    if(enrollment=='true' && check_enrollment=='true'){
        $.ajax({
            url: "/manage/includes/check_enrollment.php",
            type: "post",
            data: {payer: id, npi: npi},
            success: function(data){
                var r = $.parseJSON(data);
                if(r.enrolled=="yes"){
                    //Allow to be selected
                }else{
                    alert(r.message);
                    if(office_type==1){
                        window.location='manage_enrollment.php';
                    }else{
                        window.location='manage_enrollments.php?ed='+r.userid;
                    }
                }
            },
            failure: function(data){
                //alert('fail');
            }
        });
        return false;
    }


    $('#'+in_field).val(name).trigger('change');
    $('#'+id_field).val(id).trigger('change');

    if(source != ''){
        $('#'+source).val(t);
    }
    $('#'+hint).css('display', 'none');
}


$('.autocomplete_search').click(function() {
    if ($(this).val() == 'Type referral name' || $(this).val() == 'Type contact name' || $(this).val() == 'Type insurance payer name' || $(this).val() == 'TYPE INSURANCE PAYER NAME') {
        $(this).val('');
    }
});

function updateval_local(t){
    if(t.value == 'Type referral name' || t.value == 'Type contact name' || t.value == 'Type insurance payer name'){
        t.value = '';
    }
}
