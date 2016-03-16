$(function(){
    /**
     * Ugly hack from http://stackoverflow.com/a/2196683
     */
    jQuery.expr[":"].icontains = jQuery.expr.createPseudo(function(arg) {
        return function( elem ) {
            return jQuery(elem).text().toUpperCase().indexOf(arg.toUpperCase()) >= 0;
        };
    });
    
    /**
     * Add breadcrumb
     */
    var $container = $('<div class="row hidden-print" style="text-transform: capitalize;">' +
            '<div class="col-md-12">' +
                '<h3 class="page-title"></h3>' +
                '<ul class="page-breadcrumb breadcrumb">' +
                    '<li>' +
                        '<i class="fa fa-home"></i>' +
                        '<a href="/manage/admin/home.php">Home</a>' +
                        '<i class="fa fa-angle-right"></i>' +
                    '</li>' +
                '</ul>' +
            '</div>' +
        '</div>'),
    $breadcrumb = $container.find('ul'),
    path = window.location.href.replace(/^.+?\/([^\/]+)$/,'$1');

    if (path.indexOf('?') >= 0) {
        path = path.substr(0, path.indexOf('?'));
    }
    
    $('.page-sidebar-menu').find('li a[href*="' + path + '"]').parents('li').find('>a:nth-child(1)').each(function(){
        var $this = $(this),
            $source = $this.find('span.title'),
            text = ($source.length ? $source : $this).text().trim().toLowerCase();
        
        if ($this.is('[href$="#"], [href^="javascript"]')) {
            $breadcrumb.append('<li><span/><i class="fa fa-angle-right"></i></li>')
                .find('span:last')
                .text(text)
        }
        else {
            $breadcrumb.append('<li><a/><i class="fa fa-angle-right"></i></li>')
                .find('a:last')
                .text(text)
                .attr('href', this.href);
        }
    });

    // Convert the last breadcrumb link into a text node, and set the title
    $breadcrumb.find('li:last').each(function(){
        var $this = $(this);
        $this.text($this.text());
        $container.find('.page-title').append($this.text());
    });
  
    $container.insertAfter('.row1');
    
    /**
     * Popup
     */
    $('[onclick*=loadPopup]').each(function(){
        var $this = $(this),
        legend = $this.text().trim(),
        click = $this.attr('onclick'),
        popup = click.replace(/(javascript: *)?loadPopup\(['"](.+?)['"]\).*/i,'$2');
        
        $this.removeAttr('onclick');
        $this.data('legend',legend);
        $this.data('popup',popup);
    })
    .off('click')
    .on('click',function(e){
        e.preventDefault();
        
        var $this = $(this),
        legend = $this.data('legend'),
        popup = $this.data('popup'),
        modal = $('#popup-window'),
        iframe = modal.find('iframe');
        
        
        iframe.attr('src',popup);
        modal.find('.modal-title').text(legend);
        modal.modal('show');
        
        return false;
    });
    
    /**
     * Datepicker
     */
    if (typeof $.fn.datepicker !== 'undefined') {
        $('.datepicker, .calendar').datepicker();
    }

    $('.datepicker, .calendar').keypress(function(){
        return false;
    });
    
    /**
     * File input
     */
    $(':file').each(function(){
        var $file = $(this),
            id = $file.attr('id'),
            $replacement;

        $file.filestyle({
            classButton: 'btn btn-primary btn-xs',
            classIcon: 'glyphicon glyphicon-folder-open',
            size: 'sm'
        });

        $replacement = $file.next('.bootstrap-filestyle');

        $replacement.find('input').removeClass('input-large').addClass('input-xs');
        $replacement.attr('id', id);
        $file.attr('id', '');

        if ($file.is(':hidden')) {
            $replacement.css('display', 'none');
        }
    });
    
    /**
     * Tooltips
     */
    $('[title]').tooltip();
    
    /**
     * Empty lists
     */
    $('ul:not(:has(li))').append('<li class="list-group-item text-center">Empty list</li>');
    
    /**
     * Remember (and navigate) tabs
     */
    if (location.hash.substr(0,1) == "#") {
        $("a[href$='#" + location.hash.substr(1) + "']").tab("show");
    }
    
    $(window).on('hashchange', function(){
        if (location.hash.substr(0,1) == "#") {
            $("a[href$='#" + location.hash.substr(1) + "']").tab("show");
        }
    });
    
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
        location.hash = '#'+$(e.target).attr('href').substr(1);
    });
    
    /**
     * Table with fixed column
     */
    $('.table-responsive table.table').each(function() {
        var $table = $(this),
        $fixedColumn = $table.clone().insertBefore($table).addClass('fixed-column');
        
        $fixedColumn.removeAttr('id');
        $fixedColumn.find('th:not(:first-child),td:not(:first-child)').remove();
        
        $fixedColumn.find('tr').each(function (i, elem) {
            $(this).height($table.find('tr:eq(' + i + ')').height());
        });
    });
    
    /**
     * Tablesorter
     */
    $('.sort_table').tablesorter();
    
    /**
     * Append dropdown to change skin
     */
    $('.container').append('<select id="test-new-theme" class="btn btn-success pull-right"><option>Default</option><option disabled role="separator"></option></select>');
    
    $.each(
        ['amelia','cerulean','cosmo','cyborg','flatly','journal','readable','simplex','slate','spacelab','united','yeti'],
        function(c,name){
            $('#test-new-theme').append('<option>' + name[0].toUpperCase() + name.substr(1) + '</option>');
        }
    );
    
    $('#test-new-theme').on('change keydown keyup',function(){
        var $this = $(this),
        theme = $this.val().toLowerCase(),
        stylesheet = $('#applied-stylesheet'),
        path = stylesheet.attr('href');
        
        path = path.replace(/bootstrap-[^\-]+-/,'bootstrap-' + theme + '-');
        stylesheet.attr('href',path);
    });
    
    $('body').removeClass('loading-new-theme');
});
