$(function(){
    /**
     * Ugly hack from http://stackoverflow.com/a/2196683
     */
    jQuery.expr[":"].icontains = jQuery.expr.createPseudo(function(arg) {
        return function( elem ) {
            return jQuery(elem).text().toUpperCase().indexOf(arg.toUpperCase()) >= 0;
        };
    });
    
    $('button').addClass('btn btn-primary');
    $('.button, .addButton').removeClass('button addButton').addClass('btn btn-primary');
    
    $('input[type=text]').addClass('form-control');
    $('[type=submit], [type=button]').addClass('btn btn-default');
    $('table input[type=text]').css({ width: '' }).addClass('text-center')
    
    $('select').addClass('btn btn-default');
    
    /**
     * Allow buttons to have variety
     */
    $('.btn:icontains(edit)').removeClass('btn-success').addClass('btn-primary').append('<span>&nbsp;</span><span class="glyphicon glyphicon-pencil"/>');
    $('.btn:icontains(create), .btn:icontains("add ")').removeClass('btn-default').addClass('btn-success').append('<span>&nbsp;</span><span class="glyphicon glyphicon-plus"/>');
    $('.btn:icontains(delete), .btn:icontains(remove)').removeClass('btn-default').addClass('btn-danger').append('<span>&nbsp;</span><span class="glyphicon glyphicon-remove"/>');
    
    /**
     * Main table/content
     */
    $('table:first').each(function(){
        var $this = $(this),
        tr = $this.find('>tbody>tr')
        header = tr.eq(0),
        menu = tr.eq(1),
        content = tr.eq(2),
        footer = tr.eq(3),
        navbar = $('<div class="navbar navbar-default navbar-fixed-top"><div class="container"/></div>'),
        container = $('<div class="container"/>');
        
        $this.removeAttr('align cellspacing cellpadding class').wrap('<div class="container"/>');
        $this.attr({
            border: 0,
            width: '100%'
        });
        
        header.find('td').removeClass('header_bg')
        .contents().wrapAll('<div class="well"/>')
        .eq(0).wrap('<h1/>');
        
        header.find('a').addClass('btn btn-default');
        
        footer.find('td').removeClass('bottom_bg')
        .contents().wrapAll('<div class="well text-center"/>')
    });
    $('table:not(:first)').addClass('table table-bordered');
    
    /**
     * Dropdown
     */
    $('ul.dropdown.dropdown-horizontal').each(function(){
        var $this = $(this);
        
        $this.find('ul, li').andSelf().removeAttr('class').css({
            display: '',
            visibility: ''
        });
        $this.addClass('nav nav-tabs');
        
        $this.find('>li').has('ul').addClass('dropdown');
        $this.find('li:not(.dropdown)').has('ul').addClass('dropdown-submenu');
        $this.find('ul').addClass('dropdown-menu');
        
        $this.find('li').not($this.find('li a').closest('li')).each(function(){
            var extras = '', current = $(this);
            
            if (current.parent().is($this)) {
                extras = 'data-toggle="dropdown" class="dropdown-toggle"';
            }
            
            current.contents().eq(0).wrap('<a href="#" ' + extras + '/>');
            
            if (current.parent().is($this)) {
                current.find('a:first').append('<span>&nbsp;</span><span class="caret"/>');
            }
        });
    });
    
    /**
     * Append dropdown to change skin
     */
    $('body').append('<select id="test-new-theme" class="btn btn-success pull-right"><option>Default</option><option disabled role="separator"></option></select>');
    
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