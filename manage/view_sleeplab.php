<?php namespace Ds3\Libraries\Legacy; ?><?php 
include_once('admin/includes/main_include.php');
include("includes/sescheck.php");
include_once "admin/includes/general.htm";
//include "includes/top.htm";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<link href="css/admin.css" rel="stylesheet" type="text/css" />
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

$thesql = "select s.* from dental_sleeplab s 
			where s.sleeplabid='".(!empty($_REQUEST["ed"]) ? $_REQUEST["ed"] : '')."'";
$themyarray = $db->getRow($thesql);

$salutation = st($themyarray['salutation']);
$firstname = st($themyarray['firstname']);
$middlename = st($themyarray['middlename']);
$lastname = st($themyarray['lastname']);
$company = st($themyarray['company']);
$contacttype = st((!empty($themyarray['contacttype']) ? $themyarray['contacttype'] : ''));
$add1 = st($themyarray['add1']);
$add2 = st($themyarray['add2']);
$city = st($themyarray['city']);
$state = st($themyarray['state']);
$zip = st($themyarray['zip']);
$phone1 = st($themyarray['phone1']);
$phone2 = st($themyarray['phone2']);
$fax = st($themyarray['fax']);
$email = st($themyarray['email']);
$national_provider_id = st((!empty($themyarray['national_provider_id']) ? $themyarray['national_provider_id'] : ''));
$qualifier = st((!empty($themyarray['qualifier']) ? $themyarray['qualifier'] : ''));
$qualifierid = st((!empty($themyarray['qualifierid']) ? $themyarray['qualifierid'] : ''));
$greeting = st($themyarray['greeting']);
$sincerely = st($themyarray['sincerely']);
$contacttypeid = st((!empty($themyarray['contacttypeid']) ? $themyarray['contacttypeid'] : ''));
$notes = st($themyarray['notes']);
$preferredcontact = st((!empty($themyarray['preferredcontact']) ? $themyarray['preferredcontact'] : ''));
$name = st($themyarray['firstname'])." ".st($themyarray['middlename'])." ".st($themyarray['lastname']);
$status = st($themyarray['status']);

?>

<link rel="stylesheet" href="css/quick_view.css" type="text/css" media="screen" />

<div style="padding-top:10px;background: #fff; width: 98%; height:380px; margin-left: 1%;">
	<div class="info">
		<label>Name:</label> <span class="value"><?php echo $salutation." ".$firstname." ".$middlename." ".$lastname; ?></span>
	</div>
	<div class="info">
		<label>Company:</label> <span class="value"><?php echo $company; ?> </span>
	</div>
	<div class="info">
	<label>Address:</label> <span class="value"><?php echo $add1; ?></span>
	</div>
	<div class="info">
		<label>&nbsp;</label> <span class="value"><?php echo $add2; ?></span>
	</div>
	<div class="info">
	        <label>&nbsp;</label> <span class="value"><?php echo $city." ".$state." ".$zip; ?></span>
	</div>
	<div class="info">
	        <label>Phone:</label> <span class="value"><?php echo format_phone($phone1); ?></span>
	</div>
	<div class="info">
	        <label>Phone 2:</label> <span class="value"><?php echo format_phone($phone2); ?></span>
	</div>
	<div class="info">
	        <label>Fax:</label> <span class="value"><?php echo format_phone($fax); ?></span>
	</div>
	<div class="info">
	        <label>Email:</label> <span class="value"><?php echo $email; ?></span>
	</div>
	<div class="info">
	        <label>Notes:</label> <span class="value"><?php echo $notes; ?></span>
	</div>
	<a href="add_sleeplab.php?ed=<?php echo (!empty($_REQUEST['ed']) ? $_REQUEST['ed'] : '');?>" style="margin-right:10px;float:right;">Edit</a>
</div>

</body>
</html>
