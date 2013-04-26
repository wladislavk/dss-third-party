<?php 
session_start();
require_once('admin/includes/config.php');
include("includes/sescheck.php");
include "includes/general_functions.php";
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

    $psql = "select * from dental_contacttype WHERE physician=1";
    $pq = mysql_query($psql);
    $physician_array = array();
    while($pr = mysql_fetch_assoc($pq)){
      array_push($physician_array, $pr['contacttypeid']);
    }
    $physician_types = implode(',', $physician_array);

    $thesql = "select c.*, ct.contacttype from dental_contact c 
		LEFT JOIN dental_contacttype ct ON ct.contacttypeid = c.contacttypeid
		where c.contactid='".$_REQUEST["ed"]."'";
	$themy = mysql_query($thesql);
	$themyarray = mysql_fetch_array($themy);
	
		$salutation = st($themyarray['salutation']);
		$firstname = st($themyarray['firstname']);
		$middlename = st($themyarray['middlename']);
		$lastname = st($themyarray['lastname']);
		$company = st($themyarray['company']);
		$contacttype = st($themyarray['contacttype']);
		$add1 = st($themyarray['add1']);
		$add2 = st($themyarray['add2']);
		$city = st($themyarray['city']);
		$state = st($themyarray['state']);
		$zip = st($themyarray['zip']);
		$phone1 = st($themyarray['phone1']);
		$phone2 = st($themyarray['phone2']);
		$fax = st($themyarray['fax']);
		$email = st($themyarray['email']);
		$national_provider_id = st($themyarray['national_provider_id']);
		$qualifier = st($themyarray['qualifier']);
		$qualifierid = st($themyarray['qualifierid']);
		$greeting = st($themyarray['greeting']);
		$sincerely = st($themyarray['sincerely']);
		$contacttypeid = st($themyarray['contacttypeid']);
		$notes = st($themyarray['notes']);
		$preferredcontact = st($themyarray['preferredcontact']);
		$name = st($themyarray['firstname'])." ".st($themyarray['middlename'])." ".st($themyarray['lastname']);
		$status = st($themyarray['status']);
	
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
	<label>Name:</label> <span class="value"><?= $salutation." ".$firstname." ".$middlename." ".$lastname; ?></span>
</div>
<div class="info">
	<label>Company:</label> <span class="value"><?= $company; ?> </span>
</div>
<div class="info">
        <label>Contact Type:</label> <span class="value"><?= $contacttype; ?> </span>
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
        <label>Phone:</label> <span class="value"><?= $phone1; ?></span>
</div>
<div class="info">
        <label>Phone 2:</label> <span class="value"><?= $phone2; ?></span>
</div>
<div class="info">
        <label>Fax:</label> <span class="value"><?= $fax; ?></span>
</div>
<div class="info">
        <label>Email:</label> <span class="value"><?= $email; ?></span>
</div>
<div class="info">
        <label>Notes:</label> <span class="value"><?= $notes; ?></span>
</div>
<a href="add_contact.php?ed=<?= $_REQUEST['ed'];?>" style="margin-right:10px;float:right;">Edit</a>
</div>

</body>
</html>
