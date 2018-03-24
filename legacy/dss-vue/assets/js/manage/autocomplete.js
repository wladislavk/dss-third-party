	var fff = 0;
        var selectionref = 1;
        var selectedrefUrl = '';
        var searchrefVal = ""; // global variable to hold the last valid search string
	function setup_autocomplete(in_field, hint, id_field, source, file, hinttype, pid){
                $('#'+in_field).keyup(function(e) {
				$('#'+id_field).val('');
				if(source!=''){
                		  $('#'+source).val('');
				}
                                var a = e.which; // ascii decimal value                                //var c = String.fromCharCode(a);
                                var listSize = $('#'+hint+' ul li').size();
                                var stringSize = $(this).val().length;
                                if ($(this).val().trim() == "") {
                                        $('#'+hint).css('display', 'none');
                                } else if ((stringSize > 1 || (listSize > 2 && stringSize > 1) || ($(this).val() == window.searchVal)) && ((a >= 39 && a <= 122 && a != 40) || a == 8)) { // (greater than apostrophe and less than z and not down arrow) or backspace
                                        $('#'+hint).css("display", "inline");
                                        sendValueRef($('#'+in_field).val(), in_field, hint, id_field, source, file, hinttype, pid);
                                        if ($(this).val() > 2) {
                                                window.searchVal = $(this).val().replace(/(\s+)?.$/, ""); // strip last character to match last positive result
                                        }
                                }
                });
	}


        function sendValueRef(partial_name, in_field, hint, id_field, source, file, hinttype, pid) {
                $.post(
                
                file,

                { 
                        "partial_name": partial_name 
                },
                function(data) {
                        if (data.length == 0) {
                                $('.json_patient').remove();
                                $('.create_new').remove();
                                $('.no_matches').remove();
                                //$('#search_hints').css('display', 'none');
                               var newLi = $('#'+hint+' ul .template').clone(true).removeClass('template').addClass('no_matches');
                                        template_list_ref(newLi, "No Matches")
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
                                        template_list_ref(newLi, "Add "+label+" with this name&#8230;")
                                                .appendTo('#'+hint+' ul')
                                                .fadeIn();
				}

                        }else{
                        if (data.error) {
                                alert(data.error);
                        } else {
                                $('.json_patient').remove();
                                $('.create_new').remove();
                                $('.no_matches').remove();
                                for(i in data) {
                                        var name = data[i].name;
				    if(in_field=="contact_name"){
                                        var newLi = $('#'+hint+' ul .template')
                                                .clone(true)
                                                .removeClass('template')
                                                .addClass('json_patient')
                                                .data('rowid', data[i].id)
                                                .data('rowsource', data[i].id)
                                                .attr("onclick", "loadPopup('view_contact.php?ed="+data[i].id+"')"
);
				    }else{
                                        var newLi = $('#'+hint+' ul .template')
						.clone(true)
						.removeClass('template')
						.addClass('json_patient')
						.data('rowid', data[i].id)
						.data('rowsource', data[i].id)
						.attr("onclick", "update_referredby('"+in_field+"','"+(name.replace(/'/g, "\\'"))+"', '"+id_field+"', '"+data[i].id+"', '"+source+"', '"+data[i].source+"','"+hint+"')");
				    }
                                        template_list_ref(newLi, name)
                                              .appendTo('#'+hint+' ul')
                                            .fadeIn();
                                }
			    }
                        }
                },

                "json"
                );
        }



        function template_list_ref(li, val) {
                li.html(val);
                return li;
        }
function update_referredby(in_field, name, id_field, id, source, t, hint){
  $('#'+in_field).val(name);
  $('#'+id_field).val(id);
  if(source != ''){
    $('#'+source).val(t);
  }
  $('#'+hint).css('display', 'none');
}


                $('.autocomplete_search').click(function() {
                        if ($(this).val() == 'Type referral name' || $(this).val() == 'Type contact name' || $(this).val() == 'Type insurance payer name') {
                                $(this).val('');
                        }
                });

function updateval(t){
  if(t.value == 'Type referral name' || t.value == 'Type contact name' ||  t.value == 'Type patient name' || t.value == 'Type insurance payer name' || t.value == 'Search Calendar'){
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
					//alert('');
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

function getParameterByName(name) {
    name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
        results = regex.exec(location.search);
    return results == null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
}