$(function(){
    $('body').append('<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>');
    
    var interval = setInterval(function(){
        if ($().jquery !== '1.10.2') {
            return;
        }
        
        clearInterval(interval);
        
        // http://getbootstrap.com/dist/css/bootstrap.min.css
        // http://www.bootstrapcdn.com/twitter-bootstrap/2.3.2/css/bootstrap-combined.min.css
        
        /**
         * Ugly hack from http://stackoverflow.com/a/2196683
         */
        jQuery.expr[":"].icontains = jQuery.expr.createPseudo(function(arg) {
            return function( elem ) {
                return jQuery(elem).text().toUpperCase().indexOf(arg.toUpperCase()) >= 0;
            };
        });
        
        $('body').append('<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css">');
        $('body').append('<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap-theme.min.css">');
        $('body').append('<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>');
        
        /**
         * Hacky hack to have submenus with bootstrap >= 3.0 
         */
        $('body').append('<style type="text/css">.dropdown-submenu{position:relative;}.dropdown-submenu>.dropdown-menu{top:0;left:100%;margin-top:-6px;margin-left:-1px;-webkit-border-radius:0 6px 6px 6px;-moz-border-radius:0 6px 6px 6px;border-radius:0 6px 6px 6px;}.dropdown-submenu:hover>.dropdown-menu{display:block;}.dropdown-submenu>a:after{display:block;content:" ";float:right;width:0;height:0;border-color:transparent;border-style:solid;border-width:5px 0 5px 5px;border-left-color:#cccccc;margin-top:5px;margin-right:-10px;}.dropdown-submenu:hover>a:after{border-left-color:#ffffff;}.dropdown-submenu.pull-left{float:none;}.dropdown-submenu.pull-left>.dropdown-menu{left:-100%;margin-left:10px;-webkit-border-radius:6px 0 6px 6px;-moz-border-radius:6px 0 6px 6px;border-radius:6px 0 6px 6px;}</style>');
        
        $('button').addClass('btn btn-primary');
        $('input[type=text]').addClass('form-control');
        $('[type=submit], [type=button]').addClass('btn btn-default');
        $('select').addClass('btn btn-default');
        $('.notification.good_count').addClass('alert-info').removeClass('good_count')
        .find('.label').removeClass('label');
        $('.notification.bad_count').addClass('alert-danger').removeClass('bad_count')
        .find('.label').removeClass('label');
        $('.task_menu.index_task').addClass('panel panel-default');
        $('.button, .addButton').removeClass('button addButton').addClass('btn btn-primary');
        $('.home_third').removeClass('home_third first second third').addClass('col-md-4');
        $('#not_show_all').addClass('btn').append('<span>&nbsp;</span><span class="glyphicon glyphicon-chevron-down"/>');
        $('#not_show_active').addClass('btn').append('<span>&nbsp;</span><span class="glyphicon glyphicon-chevron-up"/>');
        
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
    },200);
});