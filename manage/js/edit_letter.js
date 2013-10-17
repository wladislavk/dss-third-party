function edit_letter(divid, size, family) {
  var html = $("#" + divid).html();
	if (html != '') {
		var textarea = $("<textarea />");
		textarea.val(html);
		textarea.attr('name', divid);
		textarea.attr('style','width:940px;height:335px;');
		$("#" + divid).replaceWith(textarea);
		tinyMCE.init({
			mode : "textareas",
			theme : "modern",
			menubar: false,
			toolbar1: "undo redo | italic | bullist numlist outdent indent",
			gecko_spellcheck : true,
			plugins: "paste",
			valid_elements: "b,strong,i,em,p,br",
    			valid_styles: {
        			"*": "",
    			},
			entities: "194,Acirc,34,quot,162,cent,8364,euro,163,pound,165,yen,169,copy,174,reg,8482,trade",
			setup : function(ed) {
              			ed.on('keyDown', function(e) {
					if(e.shiftKey && e.keyCode==188){
						e.preventDefault();	
						ed.execCommand('mceInsertContent', false, "≤");
					}
                                        if(e.shiftKey && e.keyCode==190){
                                                e.preventDefault();
                                                ed.execCommand('mceInsertContent', false, "≥");
                                        }
              			});
           		},
        paste_preprocess : function(pl, o) {
            o.content = o.content.replace(/&lt;/g, "≤");
	    o.content = o.content.replace(/&gt;/g, "≥");
        },
			content_css : "css/font"+size+".css?" + new Date().getTime()+",css/font"+family+".css?" + new Date().getTime(),
		});
		textarea.focus();
		$('.edit_'+divid).show();
		//$('#send_but_'+divid).hide();
	}
}



function strip_tags (str, allowed_tags) {
    // Strips HTML and PHP tags from a string  
    // 
    // version: 1006.1915
    // discuss at: http://phpjs.org/functions/strip_tags    // +   original by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +   improved by: Luke Godfrey
    // +      input by: Pul
    // +   bugfixed by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +   bugfixed by: Onno Marsman    // +      input by: Alex
    // +   bugfixed by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +      input by: Marc Palau
    // +   improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +      input by: Brett Zamir (http://brett-zamir.me)    // +   bugfixed by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +   bugfixed by: Eric Nagel
    // +      input by: Bobby Drake
    // +   bugfixed by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +   bugfixed by: Tomasz Wesolowski    // *     example 1: strip_tags('<p>Kevin</p> <b>van</b> <i>Zonneveld</i>', '<i><b>');
    // *     returns 1: 'Kevin <b>van</b> <i>Zonneveld</i>'
    // *     example 2: strip_tags('<p>Kevin <img src="someimage.png" onmouseover="someFunction()">van <i>Zonneveld</i></p>', '<p>');
    // *     returns 2: '<p>Kevin van Zonneveld</p>'
    // *     example 3: strip_tags("<a href='http://kevin.vanzonneveld.net'>Kevin van Zonneveld</a>", "<a>");    // *     returns 3: '<a href='http://kevin.vanzonneveld.net'>Kevin van Zonneveld</a>'
    // *     example 4: strip_tags('1 < 5 5 > 1');
    // *     returns 4: '1 < 5 5 > 1'
    var key = '', allowed = false;
    var matches = [];    var allowed_array = [];
    var allowed_tag = '';
    var i = 0;
    var k = '';
    var html = ''; 
    var replacer = function (search, replace, str) {
        return str.split(search).join(replace);
    };
     // Build allowes tags associative array
    if (allowed_tags) {
        allowed_array = allowed_tags.match(/([a-zA-Z0-9]+)/gi);
    }
     str += '';

    // Match tags
    matches = str.match(/(<\/?[\S][^>]*>)/gi);
     // Go through all HTML tags
    for (key in matches) {
        if (isNaN(key)) {
            // IE7 Hack
            continue;        }

        // Save HTML tag
        html = matches[key].toString();
         // Is tag not in allowed list? Remove from str!
        allowed = false;

        // Go through all allowed tags
        for (k in allowed_array) {            // Init
            allowed_tag = allowed_array[k];
            i = -1;

            if (i != 0) { i = html.toLowerCase().indexOf('<'+allowed_tag+'>');}            if (i != 0) { i = html.toLowerCase().indexOf('<'+allowed_tag+' ');}
            if (i != 0) { i = html.toLowerCase().indexOf('</'+allowed_tag)   ;}

            // Determine
            if (i == 0) {                allowed = true;
                break;
            }
        }
         if (!allowed) {
            str = replacer(html, "", str); // Custom replace. No regexing
        }
    }
     return str;
}
