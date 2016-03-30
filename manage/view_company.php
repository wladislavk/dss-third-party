<?php namespace Ds3\Libraries\Legacy; ?><?php 
session_start();
require_once('admin/includes/main_include.php');
include("includes/sescheck.php");
include_once "admin/includes/general.htm";
//include "includes/top.htm";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <link href="css/admin.css?v=20160329" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="/manage/admin/js/tracekit.js"></script>
    <script type="text/javascript" src="/manage/admin/js/tracekit.handler.js"></script>
    <script type="text/javascript" src="admin/script/jquery-1.6.2.min.js"></script>
    <script type="text/javascript" src="script/validation.js"></script>
    <script type="text/javascript" src="3rdParty/input_mask/jquery.maskedinput-1.3.min.js"></script>
    <script type="text/javascript" src="js/masks.js"></script>
<link rel="stylesheet" href="css/form.css" type="text/css" />
</head>
<body>

<script type="text/javascript" src="/manage/js/preferred_contact.js"></script>
<?php

    $thesql = "select c.* from companies c 
		where c.id='".$_REQUEST["id"]."'";
	$themy = mysqli_query($con, $thesql);
	$themyarray = mysqli_fetch_array($themy);
	
		$name = st($themyarray['name']);
		$add1 = st($themyarray['add1']);
		$add2 = st($themyarray['add2']);
		$city = st($themyarray['city']);
		$state = st($themyarray['state']);
		$zip = st($themyarray['zip']);
		$phone = st($themyarray['phone']);
		$fax = st($themyarray['fax']);
		$email = st($themyarray['email']);
		$contact_person = st($themyarray['contact_person']);
		$shipping_label = st($themyarray['shipping_label']);
		$turnaround_time = st($themyarray['turnaround_time']);
	
?>
<style type="text/css">
  .info {
	height: 20px;
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
  }
</style>
<div style="padding-top:10px;background: #fff; width: 98%; height:380px; margin-left: 1%;">
<div class="info">
	<label>Name:</label> <span class="value"><?= $name; ?></span>
</div>
<div class="info">
	<label>Contact Person:</label> <span class="value"><?= $contact_person; ?> </span>
</div>
<div class="info">
<label>Address:</label> <span class="value"><?= $add1; ?></span>
</div>
<div class="info">
	<label>&nbsp;</label> <span class="value"><?= $add2; ?></span>
</div>
<div class="info">
        <label>&nbsp;</label> <span class="value"><?= $city." ".$state." ".$zip; ?></span>
</div>
<div class="info">
        <label>Phone:</label> <span class="value"><?= format_phone($phone); ?></span>
</div>
<div class="info">
        <label>Fax:</label> <span class="value"><?= format_phone($fax); ?></span>
</div>
<div class="info">
        <label>Email:</label> <span class="value"><?= $email; ?></span>
</div>
<div class="info">
        <label>Turnaround Time:</label> <span class="value"><?= $turnaround_time; ?> Days</span>
</div>
</div>

</body>
</html>
