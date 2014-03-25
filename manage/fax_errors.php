<?php 
session_start();
require_once('admin/includes/main_include.php');
include("includes/sescheck.php");
//include "includes/general_functions.php";
include_once "admin/includes/general.htm";
//include "includes/top.htm";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="css/admin.css" rel="stylesheet" type="text/css" />
<script language="javascript" type="text/javascript" src="script/validation.js"></script>
<!--<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>-->
  <script type="text/javascript" src="admin/script/jquery-1.6.2.min.js"></script>
    <script type="text/javascript" src="3rdParty/input_mask/jquery.maskedinput-1.3.min.js"></script>
    <script type="text/javascript" src="js/masks.js"></script>
<link rel="stylesheet" href="css/form.css" type="text/css" />
<script type="text/javascript" src="script/wufoo.js"></script>
</head>
<body>

<script type="text/javascript" src="/manage/js/preferred_contact.js"></script>
<?php

    $thesql = "select f.*, ec.description, ec.resolution
		FROM dental_faxes f
		LEFT JOIN dental_fax_error_codes ec ON ec.error_code = f.sfax_error_code
		where f.id='".$_REQUEST["id"]."'";
	$themy = mysql_query($thesql);
	$themyarray = mysql_fetch_array($themy);
	
?>
<style type="text/css">
  .info {
  }
  .info label{
	line-height: 20px;
  	width: 150px;
	display: block;
	float: left;
	text-align: right;
	margin-right: 10px;
  }
  .info .value{
	line-height: 20px;
	width:500px;
 	display:inline-block;
  }
</style>
<div style="padding-top:10px;background: #fff; width: 98%; height:380px; margin-left: 1%;">
<div class="info">
	<label>Error:</label> <span class="value"><?= $themyarray['sfax_error_code']; ?></span>
</div>
<div class="info">
        <label>&nbsp;</label> <span class="value"><?= $themyarray['description']; ?></span>
</div>
<div class="info">
        <label>&nbsp;</label> <span class="value"><?= $themyarray['resolution']; ?></span>
</div>
<div class="info">
	<label>Sent:</label> <span class="value"><?= date('m/d/Y h:i a', strtotime($themyarray['sent_date'])); ?> </span>
</div>
<div class="info">
        <label>To:</label> <span class="value"><?= $themyarray['to_name']. " - " . format_phone($themyarray['to_number']); ?> </span>
</div>

</body>
</html>
