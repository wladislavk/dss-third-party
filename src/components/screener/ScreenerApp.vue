<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
    <title>Dental Sleep Solutions :: Screener</title>
    <script type="text/javascript" src="../reg/lib/fancybox/jquery.easing-1.3.pack.js"></script>
    <script type="text/javascript" src="../reg/lib/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
    <script type="text/javascript" src="../manage/3rdParty/input_mask/jquery.maskedinput-1.3.min.js"></script>
    <script type="text/javascript" src="script/screener_masks.js"></script>
    <link rel="stylesheet" href="css/lagu.css" />
    <link rel="stylesheet" href="css/screener.css" />
    <link rel="stylesheet" href="../manage/admin/css/jquery-ui-1.8.22.custom.css" />
    <link rel="stylesheet" href="../reg/lib/fancybox/jquery.fancybox-1.3.4.css" type="text/css" />
    <!--[if IE]>
    <link rel="stylesheet" type="text/css" href="css/style_ie.css" />
    <![endif]-->
</head>
<body class="fixed">
<div id="header" >
    <div class="wrapper cf">
        <div class="logo fl">
            <h1>Dental Sleep Solutions</h1>
        </div>
        <ul id="main_nav" class="fr">
            <li class="nav_item lgutipT" title="start over" style="display:none;" id="restart_nav">
                <a href="index.php" class="main_link" onclick="return confirm('Are you sure? All current progress will be lost.');">
                    <img class="img_holder" style="background-image: url(images/images/icons/refresh.png)" alt="" src="images/blank.gif"/>
                    <span>Reset and Start Over</span>
                </a>
            </li>
            <li class="nav_item lgutipT" title="Log Out">
                <a href="logout.php" onclick="return confirm('Are you sure you want to logout?')" class="main_link">
                    <img class="img_holder" style="background-image: url(images/icons/locked2.png)" alt="" src="images/blank.gif"/>
                    <span>Log Out</span>
                </a>
            </li>
        </ul>
    </div>
</div>
<div id="main">
    <div class="wrapper cf">
        <div class="cf brdrrad_a" id="main_section">
            <router-view></router-view>
            <div style="clear:both;"></div>
        </div>
    </div>

    <!-- footer section -->
    <div id="footer">
        <div class="wrapper">
            <span class="fr">Copyright Dental Sleep Solutions {{ currentYear }}</span>
        </div>
    </div>
</div>
</body>
</html>
