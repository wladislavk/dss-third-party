var fff = 0;
var selectionref = 1;
var selectedrefUrl = '';
var searchrefVal = ""; // global variable to hold the last valid search string

var autoCompleteRequest = null;

function cancelAutoCompleteRequest () {
    if (autoCompleteRequest) {
        autoCompleteRequest.abort();
        autoCompleteRequest = null;
    }
}

function setup_autocomplete(in_field, hint, id_field, source, file, cid){
    $('#'+in_field).keyup(debounceCall(function(e) {
        var $this = $(this);

        $('#'+id_field).val('');
        $('#'+source).val('');
        var a = e.which; // ascii decimal value                                //var c = String.fromCharCode(a);
        var listSize = $('#'+hint+' ul li').size();
        var val = $this.val();
        var lowerVal = val.toLowerCase();
        //var trimVal = lowerVal.trim();
        var trimVal = $.trim(lowerVal);
        if(trimVal.indexOf('dr. ')==0 || trimVal.indexOf('dr ')==0){ val = val.substr(val.indexOf(' ', lowerVal.indexOf('Dr'))); }
        var stringSize = val.length;
        if ($.trim(val) == "") {
            $('#'+hint).css('display', 'none');
        } else if ((stringSize > 1 || (listSize > 2 && stringSize > 1) || (val == window.searchVal)) && ((a >= 39 && a <= 122 && a != 40) || a == 8)) { // (greater than apostrophe and less than z and not down arrow) or backspace
            $('#'+hint).css("display", "inline");
            sendValueRef(val, in_field, hint, id_field, source, file, cid);
            if (val > 2) {
                //window.searchVal = $(this).val().replace(/(\s+)?.$/, ""); // strip last character to match last positive result
            }
        }
    }, { onTick: cancelAutoCompleteRequest }));
}


function sendValueRef(partial_name, in_field, hint, id_field, source, file, cid) {
    autoCompleteRequest = $.post(
        file,
        {
            "partial_name": partial_name
        },
        function(data) {
            if (data.length == 0) {
                $('.json_patient').remove();
            }
            else if (data.error) {
                alert(data.error);
            } else {
                $('.json_patient').remove();
                for(i in data) {
                    var name = data[i].fname + " " + data[i].lname;
                    var newLi = $('#'+hint+' ul .template')
                        .clone(true)
                        .removeClass('template')
                        .addClass('json_patient')
                        .addClass('cur_ref')
                        .data('rowid', data[i].id)
                        .data('rowsource', data[i].id)
                        .data('rowname', name);
                    template_list_ref(newLi, name, data[i].add1+" "+data[i].add2+" "+data[i].city+" "+data[i].state+" "+data[i].zip+" - "+data[i].phone)
                        .appendTo('#'+hint+' ul')
                        .fadeIn();
                }
            }
            var newLi = $('#'+hint+' ul .template')
                .clone(true)
                .removeClass('template')
                .addClass('json_patient')
                .addClass('contact_add');
            template_list_ref(newLi, "Don't see your doctor? Click here.", '')
                .appendTo('#'+hint+' ul')
                .fadeIn();

            $('.cur_ref').click(function(){
                id = $(this).data('rowid');
                name = $(this).data('rowname');
                update_referredby(id, hint, cid, name);
            });
            $('.contact_add').click(function() {
                show_referredby(cid, partial_name);

                var $this = $(this),
                    $container = $this.closest('.dp75'),
                    $wrapper = $container.closest('#register');

                if (!$container.length || !$wrapper.length) {
                    return;
                }

                $container.css({
                    height: $wrapper.outerHeight(),
                    'overflow-y': 'auto'
                });

                $container.find('.cf').css({
                    'clear': 'both',
                    padding: '15px 0'
                });
            });
        },
        "json"
    ).complete(function(){ autoCompleteRequest = null; });
}

function template_list_ref(li, val, val2) {
    li.html(val+"<span>"+val2+"</span>");
    return li;
}

function show_referredby(cid, n){
    $('#pc_'+cid+'_input_div').show();
    $('#pc_'+cid+'_person').hide();
    var s = n.indexOf(' ');
    if(s > 0){
        var fn = n.substr(0,s);
        var ln = n.substr(s+1);
    }else{
        var fn = n;
        var ln = '';
    }
    $('#pc_'+cid+'_firstname').val(fn);
    $('#pc_'+cid+'_lastname').val(ln);
    $('#pc_'+cid+'_contactid').val('');
}

function update_referredby(contactid, hint, cid, name){
    $('#pc_'+cid+'_contactid').val(contactid);
    $('#'+hint).css('display', 'none');
    $('#pc_'+cid+'_name').val(name);
}

$('.autocomplete_search').click(function() {
    if ($(this).val() == 'Type doctor name' || $(this).val() == 'Type contact name') {
        $(this).val('');
    }
});

function updateval(t){
    if(t.value == 'Type doctor name' || t.value == 'Type contact name'){
        t.value = '';
    }
}
/*
 $(document).keyup(function(e) {
 switch (e.which) {
 case 38:
 move_selectionref('up');
 break;
 case 40:
 move_selectionref('down');
 break;
 case 13:
 break;
 }
 });

 function move_selectionref(direction) {
 if ($('#referredby_list > li.list_hover').size() == 0) {
 window.selectionref = 0;
 }
 if (direction == 'up' && window.selectionref != 0) {
 if (window.selectionref != 1) {
 window.selectionref--;
 }
 } else if (direction == 'down') {
 if (window.selectionref != ($("#referredby_list li").size() -1)) {
 window.selectionref++;
 }
 }
 set_selectedref(window.selectionref);
 }
 function set_selectedref(menuitem) {
 $('#referredby_list li').removeClass('list_hover');
 $('#referredby_list li').eq(menuitem).addClass('list_hover');
 var rowid = $('#referred_list li').eq(menuitem).data("rowid");
 var rowsource = $('#referred_list li').eq(menuitem).data("rowsource");
 var rowname = $('#referred_list li').eq(menuitem).data("rowname");
 $('#referred_name').val(rowname);
 }
 */
