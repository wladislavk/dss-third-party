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
    var $container = $('<div><ol class="breadcrumb"><li><a href="/manage/admin/home.php">Home</a></li></ol></div>'),
    $breadcrumb = $container.find('ol'),
    path = window.location.href.replace(/^.*?\/([^\/]+)$/,'$1');
    
    $('.page-sidebar-menu').find('li a[href$="' + path + '"]').parents('li').find('>a:nth-child(1)').each(function(){
        var $this = $(this);
        
        if ($this.is('[href$="#"]')) {
            $breadcrumb.append('<li/>')
                .find('li:last')
                .text($this.text().trim());
        }
        else {
            $breadcrumb.append('<li><a/></li>')
                .find('a:last')
                .text($this.text().trim())
                .attr('href',this.href);
        }
    });
    
    $breadcrumb.find('li:last').each(function(){
        var $this = $(this);
        
        $this.text($this.text());
    }).addClass('active');
    $container.insertAfter('.row');
    
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
    $('.date, .calendar').datepicker();
    $('.date, .calendar').keypress( function(){
	return false;
    });
    
    /**
     * File input
     */
    $(':file').filestyle({
        classButton: 'btn btn-primary',
        classIcon: 'glyphicon glyphicon-folder-open'
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
