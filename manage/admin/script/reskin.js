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
    $('table:not(:first)').addClass('table table-bordered');
    
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