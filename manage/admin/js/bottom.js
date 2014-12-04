jQuery(document).ready(function() {    
   //App.init(); // initlayout and core plugins
   Index.init();
   //Index.initJQVMAP(); // init index page's custom scripts
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
	//alert(addr);
	var redirUrl_path = 'extra_lock.php?id=' + userid + '&&addr=' + path_name;
	$.idleTimeout('#idle-timeout-dialog', '.modal-content button:last', {
        idleAfter: 900, // 5 seconds
        timeout: 2100000, //30 seconds to timeout
        pollingInterval: 300, // 5 seconds
        keepAliveURL: 'admin/template/demo/idletimeout_keepalive.php',
        serverResponseEquals: 'OK',
        onTimeout: function(){
            window.location = logout.php;
        },
        onIdle: function(){
            $('#idle-timeout-dialog').modal('show');
            $countdown = $('#idle-timeout-counter');

            $('#idle-timeout-dialog-keepalive').on('click', function () { 
                $('#idle-timeout-dialog').modal('hide');
            });

            $('#idle-timeout-dialog-logout').on('click', function () { 
                $('#idle-timeout-dialog').modal('hide');
                $.idleTimeout.options.onTimeout.call(this);
            });
        },
        onCountdown: function(counter){
            $countdown.html(counter); // update the counter
        }
    });     
});

jQuery(document).ready(function(){    
	var path = window.location.pathname;
	var query = window.location.search;
	var pathname = path + query;
		//alert(pathname);
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