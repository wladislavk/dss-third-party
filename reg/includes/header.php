<?php include '../manage/admin/includes/config.php'; ?>
<html>
  <head>
    <title>Dental Sleep Solutions :: Registration</title>
    <link rel="stylesheet" href="css/style.css" />
    <script type="text/javascript" src="../manage/admin/script/jquery-1.6.2.min.js"></script>
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
  <body onload="set_interval()">
    <div id="container">
	<h1>Dental Sleep Solutions</h1>
