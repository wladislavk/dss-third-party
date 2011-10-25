	var fff = 0;
        var selection = 1;
        var selectedUrl = '';
        var searchVal = ""; // global variable to hold the last valid search string
	function setup_autocomplete(in_field, hint, id_field, source, file){
                $('#'+in_field).keyup(function(e) {
                                var a = e.which; // ascii decimal value                                //var c = String.fromCharCode(a);
                                var listSize = $('#'+hint+' ul li').size();
                                var stringSize = $(this).val().length;
                                if ($(this).val().trim() == "") {
                                        $('#'+hint).css('display', 'none');
                                } else if ((stringSize > 1 || (listSize > 2 && stringSize > 1) || ($(this).val() == window.searchVal)) && ((a >= 39 && a <= 122 && a != 40) || a == 8)) { // (greater than apostrophe and less than z and not down arrow) or backspace
                                        $('#'+hint).css("display", "inline");
                                        sendValueRef($('#'+in_field).val(), in_field, hint, id_field, source, file);
                                        if ($(this).val() > 2) {
                                                window.searchVal = $(this).val().replace(/(\s+)?.$/, ""); // strip last character to match last positive result
                                        }
                                }
                });
	}


        function sendValueRef(partial_name, in_field, hint, id_field, source, file) {
                $('#'+id_field).val('');
                $('#'+source).val('');
                $.post(
                
                file,

                { 
                        "partial_name": partial_name 
                },
                function(data) {
                        if (data.length == 0) {
                                $('#'+hint).css('display', 'none');
                        }
                        if (data.error) {
                                alert(data.error);
                        } else {
                                $('.json_patient').remove();
                                for(i in data) {
                                        var name = data[i].name;
                                        var newLi = $('#'+hint+' ul .template')
						.clone(true)
						.removeClass('template')
						.addClass('json_patient')
						.attr("onclick", "update_referredby('"+in_field+"','"+name+"', '"+id_field+"', '"+data[i].id+"', '"+source+"', '"+data[i].source+"','"+hint+"')");
                                        template_list_ref(newLi, name)
                                              .appendTo('#'+hint+' ul')
                                            .fadeIn();
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
  $('#'+source).val(t);
  $('#'+hint).css('display', 'none');
}


                $('.autocomplete_search').click(function() {
                        if ($(this).val() == 'Type referral name' || $(this).val() == 'Type contact name') {
                                $(this).val('');
                        }
                });

function updateval(t){
  if(t.value == 'Type referral name' || t.value == 'Type contact name'){
	t.value = '';
  }
}
