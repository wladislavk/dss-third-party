<?php include '../manage/admin/includes/config.php'; ?>
<html>
  <head>
    <title>Dental Sleep Solutions :: Registration</title>
    <link rel="stylesheet" href="css/lagu.css" />
    <link rel="stylesheet" href="lib/datatables/css/table_jui.css" type="text/css" />
    <script type="text/javascript" src="js/head.load.min.js"></script>
    <script type="text/javascript" src="js/jquery-1.6.2.min.js"></script>
    <script type="text/javascript" src="lib/datatables/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="lib/datatables/dataTables.plugins.js"></script>
    <script type="text/javascript" src="lib/fusion-charts/FusionCharts.js"></script>
        <script type="text/javascript" src="js/jquery.microaccordion.js"></script>
    <script type="text/javascript" src="js/jquery.stickyPanel.js"></script>
    <script type="text/javascript" src="js/xbreadcrumbs.js"></script>
    <script type="text/javascript" src="js/jquery.tools.min.js"></script>
    <script type="text/javascript" src="lib/jquery-validation/jquery.validate.js"></script>
    <script type="text/javascript" src="js/lagu.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
                                //lga_fusionCharts.chart_k();
                                lga_wizard.init();
                        });
        </script>

    <script type="text/javascript">
	lo_timer = '';
function set_interval()
{
lo_timer=setInterval("auto_logout()",900000);
}
function reset_interval()
{
clearInterval(lo_timer);
lo_timer=setInterval("auto_logout()",900000);
}
function auto_logout()
{
window.location = 'logout.php';

}
    </script>
  </head>
  <body class="fixed stD" onload="set_interval()">
    <!-- quick access sliding panel -->
    <div id="slide_wrapper">
        <div class="wrapper" id="slide_panel">
            <div id="slide_content">
                <span id="slide_close"><img class="round_x16_b" src="images/blank.gif" alt="" /></span>
                [content]
            </div>
        </div>
    </div>
 
    <!-- header section -->
    <div id="header">
        <div class="wrapper cf">
            <div class="logo fl">
                [logo]
            </div>
            <ul id="main_nav" class="fr">
				<li class="nav_item active lgutipL" title="Aliquam erat volutpat. Nulla tempor tincidunt scelerisque."><a href="home.php" class="main_link"><img class="img_holder" style="background-image: url(images/icons/home.png)" alt="" src="images/blank.gif"/><span>Dashboard</span></a><img class="tick tick_a" alt="" src="images/blank.gif" /></li>
				<li class="nav_item lgutipR" title="Aliquam erat volutpat. Nulla tempor tincidunt scelerisque."><a href="register.php" class="main_link"><img class="img_holder" style="background-image: url(images/icons/user2.png)" alt="" src="images/blank.gif"/><span>Registration</span></a></li>
				<li class="nav_item lgutipT" title="Aliquam erat volutpat. Nulla tempor tincidunt scelerisque."><a href="symptoms.php" class="main_link"><img class="img_holder" style="background-image: url(images/icons/clipboard.png)" alt="" src="images/blank.gif"/><span>Questionnaire</span></a></li>
			
            </ul>
        </div>
    </div>
 
    <!-- main section -->
    <div id="main">
        <div class="wrapper">
            <div class="brdrrad_a" id="main_section">
