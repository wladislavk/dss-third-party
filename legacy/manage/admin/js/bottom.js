jQuery(document).ready(function() {    
   Index.init();
   Index.initCalendar(); // init index page's custom scripts
   Index.initCharts(); // init index page's custom scripts
   Index.initChat();
   Index.initMiniCharts();
   Index.initDashboardDaterange();
   Index.initIntro();
   Tasks.initDashboardWidget();
});

jQuery(document).ready(function() {    
	App.init();
	UIIdleTimeout.init();

	var queryst = window.location.search;
	var addr = "<?php echo $address[3]; ?>";
	var path_name = addr + queryst;
	var redirUrl_path = 'extra_lock.php?id=' + userid + '&&addr=' + path_name;
});

jQuery(document).ready(function(){    
	var path = window.location.pathname;
	var query = window.location.search;
	var pathname = path + query;
	$('.page-sidebar-menu').find('li a[href$="' + pathname + '"]').parents('li').addClass('active').each(function(){
        var $this = $(this);
      	$this.parents('ul').parents('li').each(function(){
		   $(this).addClass('active');
		   $(this).find('a > span.arrow').addClass('open');
		   $(this).find('a > span.arrow').append('<span class="selected"></span>');
		   $(this).children().find('a > span.arrow').addClass('open');
		});
	});
});