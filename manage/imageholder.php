<html>

<head>
<!-- Load the Cloud Zoom CSS file -->
  <link href="css/cloud-zoom.css" rel="stylesheet" type="text/css" />
  
  <!-- You can load the jQuery library from the Google Content Network.
  Probably better than from your own server. -->
<!--  <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>-->
    <script type="text/javascript" src="admin/script/jquery-1.6.2.min.js"></script>

  <!-- Load the Cloud Zoom JavaScript file -->
  <script type="text/JavaScript" src="js/cloud-zoom.1.0.2.min.js"></script>
</head>

<body>

<?php
$image = $_GET['image'];
$folder = $_GET['folder'];
if (empty($folder)) {
	$folder = 'q_file';
}

echo "<a href='".$folder."/".$image."' class='cloud-zoom'><img height='250' src='".$folder."/".$image."' /></a><br /><img height='500' src='".$folder."/".$image."' />";


?>
</body>

</html>
