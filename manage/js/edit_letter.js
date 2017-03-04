function edit_letter (divid, size, family) {
    var $source = $("#" + divid),
        $clone = $source.clone(),
        html = '';

    $clone.find('.br-marker').remove();
    $clone.find('.preview-page-break, .preview-bottom-margin').remove();
    $clone.find('.preview-inner-wrapper').find(':first').unwrap().unwrap();

    $clone.find('.preview-placeholder').attr('contenteditable', false);

    html = $clone.html();
    $clone.remove();

    if (html == '') {
        return;
    }

    var textarea = $("<textarea />");
    textarea.attr('id', [divid, 'textarea'].join('-'));

    if ($source.is('.preview-letter')) {
        $source.removeClass('show-hidden show-placeholders');
        $source.find('.preview-wrapper').hide().after(textarea);
        $source.find('.preview-bottom-margin, .preview-page-break').hide();
        $(['#preview-tools-', divid].join('')).hide();
    } else {
        $("#" + divid).replaceWith(textarea);
    }

    textarea.val(html);
    textarea.attr('name', divid);

    if (typeof pageSize === 'undefined') {
        textarea.attr('style','width:940px;height:335px;');
    } else {
        textarea.attr('style', ['width:100%;height:', pageSize.height, 'mm;width:', pageSize.width, 'mm;'].join(''));
    }

    setup_tinymce(size, family, $source.closest('.single-letter'));

    textarea.focus();

    $('.edit_'+divid).show();
    $('#edit_but_'+divid).hide();
    $('#cancel_edit_but_'+divid).show();
}

function hide_edit_letter (divid) {
    var $source = $("#" + divid);

    $source.attr('class', $source.data('initial-class'));
    $source.find(['textarea[name="', divid, '"], .mce-tinymce'].join('')).remove();
    $source.find('.preview-wrapper, .preview-bottom-margin, .preview-page-break').show();

    var $placeholders = $source.closest('.single-letter').find('.preview-toggle-placeholders');

    if ($source.is('.show-placeholders')) {
        $placeholders.text('Hide variables');
    } else {
        $placeholders.text('Show variables');
    }

    $(['#preview-tools-', divid].join('')).show();
    $('.edit_'+divid).hide();
    $('#edit_but_'+divid).show();
    $('#cancel_edit_but_'+divid).hide();
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
            continue;
        }

        // Save HTML tag
        html = matches[key].toString();
        // Is tag not in allowed list? Remove from str!
        allowed = false;

        // Go through all allowed tags
        for (k in allowed_array) {            // Init
            allowed_tag = allowed_array[k];
            i = -1;

            if (i != 0) { i = html.toLowerCase().indexOf('<' + allowed_tag + '>'); }
            if (i != 0) { i = html.toLowerCase().indexOf('<' + allowed_tag + ' '); }
            if (i != 0) { i = html.toLowerCase().indexOf('</' + allowed_tag); }

            // Determine
            if (i == 0) {
                allowed = true;
                break;
            }
        }

        if (!allowed) {
            str = replacer(html, "", str); // Custom replace. No regexing
        }
    }

    return str;
}

function setup_tinymce (size, family, $reference) {
    var now = (new Date()).getTime();

    var init = {
        mode: "textareas",
        theme: "modern",
        menubar: false,
        toolbar1: "undo redo | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | table",
        gecko_spellcheck : true,
        plugins: "paste, save, table",
        valid_elements: "table,tbody,thead,tr,td[width|colspan|style],img[src|width|height|align],th,b,strong,i,em,p,br,ul,li,ol",
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
        paste_preprocess: function(pl, o) {
            o.content = o.content.replace(/&lt;/g, "≤");
            o.content = o.content.replace(/&gt;/g, "≥");
        },
        content_css: [
            "css/font" + size + ".css?" + now,
            "css/font" + family + ".css?" + now
        ].join(',')
    };

    if (typeof pageMargins !== 'undefined') {
        init.content_style = ['body { margin: 0 ', pageMargins.right, 'mm 0 ', pageMargins.left, 'mm; }'].join('');
    }

    if (typeof $reference === 'object') {
        /**
         * Reset font properties each time the edition window is opened
         *
         * @see DSS-527
         */
        // size = $reference.find('[name^=font_size]').val();
        // family = $reference.find('[name^=font_family]').val();

        init.mode = 'exact';
        init.elements = $reference.find('textarea').attr('id');
        init.plugins = init.plugins.replace(/table/, 'table_modified');
        init.toolbar1 = init.toolbar1.replace(/italic +\|/, 'italic underline strikethrough |');
        init.table_alignment_option = false;

        init.valid_elements = ['@[style|border|class|title|contenteditable],mark,u,del', init.valid_elements].join(',');
        delete init.valid_styles;

        init.content_css = [
            "css/font-default.css?" + now,
            "css/font-size-" + size + ".css?" + now,
            "css/font-family-" + family + ".css?" + now
        ].join(',');
        /**
         * Enable use of <u> for underlined elements
         * http://stackoverflow.com/a/21308684/208067
         *
         * @see DSS-527
         */
        init.inline_styles = false;
        init.formats = {
            underline: { inline: 'u', exact: true },
            strikethrough: { inline: 'del' }
        };

        /**
         * Enable styles in non editable elements
         */
        init.setup = function (editor) {
            editor.on('BeforeExecCommand', function (e) {
                var $nonEditable = $reference.find('iframe')
                    .contents().find('body [contenteditable], body .non-editable');

                $nonEditable.addClass('non-editable').attr('contenteditable', 'true');
                setTimeout(function(){ $nonEditable.attr('contenteditable', 'false'); }, 500);
            });
        };
    }

    tinyMCE.init(init);
}

$(document).ready(function(){
    var $hidden = $('.preview-toggle-hidden'),
        $placeholders = $('.preview-toggle-placeholders'),
        $fontSize = $('[name^=font_size]'),
        $fontFamily = $('[name^=font_family]');

    function replaceClass ($this, match, replacement) {
        var classes = $this.attr('class');
        $this.attr('class', classes.replace(match, replacement));
    }

    function replaceLink ($reference, match, replacement) {
        $reference.find('iframe').contents().find('link').each(function(){
            var $this = $(this),
                $clone, href;

            if (!$this.attr('href').match(match)) {
                return;
            }

            $clone = $this.clone();
            href = $clone.attr('href');

            $clone.attr('href', href.replace(match, replacement));

            $clone.insertAfter($this);
            $this.remove();
        });
    }

    $hidden.removeAttr('onclick');
    $hidden.click(function (e) {
        var $this = $(this),
            $preview = $this.closest('.single-letter').find('.preview-letter');

        e.preventDefault();
        $preview.toggleClass('show-hidden');

        if ($preview.is('.show-hidden')) {
            $preview.find('br').before('<span class="br-marker"></span>');
        } else {
            $preview.find('.br-marker').remove();
        }

        return false;
    });

    $placeholders.removeAttr('onclick');
    $placeholders.click(function (e) {
        var $this = $(this),
            $preview = $this.closest('.single-letter').find('.preview-letter');

        e.preventDefault();
        $preview.toggleClass('show-placeholders');

        if ($preview.is('.show-placeholders')) {
            $this.text('Hide variables');
        } else {
            $this.text('Show variables');
        }

        return false;
    });

    $fontSize.removeAttr('onchange');
    $fontSize.change(function(){
        var $this = $(this),
            $container = $this.closest('.single-letter'),
            $preview = $container.find('.preview-letter'),
            $mce = $container.find('.mce-tinymce.mce-container');

        replaceClass($preview, /preview-size-[^\s]*/g, ['preview-size', $this.val()].join('-'));
        replaceLink($mce, /font-size-[^\.]*/g, ['font-size', $this.val()].join('-'));
    });

    $fontFamily.removeAttr('onchange');
    $fontFamily.change(function(){
        var $this = $(this),
            $container = $this.closest('.single-letter'),
            $preview = $container.find('.preview-letter'),
            $mce = $container.find('.mce-tinymce.mce-container');

        replaceClass($preview, /preview-font-[^\s]*/g, ['preview-font', $this.val()].join('-'));
        replaceLink($mce, /font-family-[^\.]*/g, ['font-family', $this.val()].join('-'));
    });
});
