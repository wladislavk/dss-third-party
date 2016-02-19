jQuery(document).ready(function() {    
   //Metronic.init(); // init metronic core componets
   Layout.init(); // init layout
   QuickSidebar.init() // init quick sidebar
   Index.init();   
   Index.initDashboardDaterange();
   Index.initJQVMAP(); // init index page's custom scripts
   Index.initCalendar(); // init index page's custom scripts
   Index.initCharts(); // init index page's custom scripts
   Index.initChat();
   Index.initMiniCharts();
   //Index.initIntro();
   Tasks.initDashboardWidget();
});

jQuery(document).ready(function() {    
   Metronic.init();
   UIIdleTimeout.init();
  
   var queryst = window.location.search;
   var addr = "<?php echo $address[3]; ?>";
   var path_name = addr + queryst;
   //alert(addr);
   var redirUrl_path='extra_lock.php?id=' + userid + '&&addr=' + path_name;
});

jQuery(document).ready(function(){  
   //handles sidebar and content height   
   var handleSidebarAndContentHeight = function () {
      var content = $('.page-content');
      var sidebar = $('.page-sidebar');
      var body = $('body');
      var height;

      if (body.hasClass("page-footer-fixed") === true && body.hasClass("page-sidebar-fixed") === false) {
         var available_height = Metronic.getViewPort().height - $('.page-footer').outerHeight() - $('.page-header').outerHeight();
         if (content.height() < available_height) {
            content.attr('style', 'min-height:' + available_height + 'px');
         }
      } else {
         if (body.hasClass('page-sidebar-fixed')) {
            height = _calculateFixedSidebarViewportHeight();
            if (body.hasClass('page-footer-fixed') === false) {
               height = height - $('.page-footer').outerHeight();
            }
         } else {
            var headerHeight = $('.page-header').outerHeight();
            var footerHeight = $('.page-footer').outerHeight();

            if (Metronic.getViewPort().width < 992) {
               height = Metronic.getViewPort().height - headerHeight - footerHeight;
            } else {
               height = sidebar.height() + 20;
            }

            if ($(window).width() > 1024 && (height + headerHeight + footerHeight) < Metronic.getViewPort().height) {
               height = Metronic.getViewPort().height - headerHeight - footerHeight;
            }
         }

         content.attr('style', 'min-height:' + height + 'px');
      }
   }

   //handles sidebar and content height      

   var path = window.location.pathname;
   var query = window.location.search;
   var pathname = path + query;
   //alert(pathname);
   $('.page-sidebar-menu').find('li a[href$="' + pathname + '"]').parents('li').addClass('active').each(function(){
      var $this = $(this);
      $this.parents('ul').parents('li').each(function() {     
         $(this).addClass('active');
         $(this).find('a > span.arrow').addClass('open');
         $(this).find('a > span.arrow').append('<span class="selected"></span>');
         $(this).children().find('a > span.arrow').addClass('open'); 
         handleSidebarAndContentHeight();      
      });
   });
});