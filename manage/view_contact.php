<?php namespace Ds3\Libraries\Legacy; ?><?php 
include_once('admin/includes/main_include.php');
include("includes/sescheck.php");
//include "includes/general_functions.php";
include_once "admin/includes/general.htm";
//include "includes/top.htm";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <link rel="stylesheet" type="text/css" href="css/admin.css?v=20160329" />
    <link rel="stylesheet" type="text/css" href="css/form.css" />
    <script type="text/javascript" src="/manage/admin/script/jquery-1.6.2.min.js"></script>
    <script type="text/javascript" src="/manage/admin/script/jquery-ui-1.8.22.custom.min.js"></script>
    <script type="text/javascript" src="3rdParty/input_mask/jquery.maskedinput-1.3.min.js"></script>
    <script type="text/javascript" src="/manage/admin/js/tracekit.js"></script>
    <script type="text/javascript" src="/manage/admin/js/tracekit.handler.js"></script>
    <script type="text/javascript" src="script/validation.js"></script>
    <script type="text/javascript" src="admin/script/jquery-1.6.2.min.js"></script>
    <script type="text/javascript" src="3rdParty/input_mask/jquery.maskedinput-1.3.min.js"></script>
    <script type="text/javascript" src="js/masks.js"></script>
</head>
<body>

<script type="text/javascript" src="/manage/js/preferred_contact.js"></script>
<?php
$psql = "select * from dental_contacttype WHERE physician=1";
$pq = $db->getResults($psql);
$physician_array = array();
if ($pq) foreach ($pq as $pr) {
  array_push($physician_array, $pr['contacttypeid']);
}
$physician_types = implode(',', $physician_array);

$thesql = "select c.*, ct.contacttype from dental_contact c 
			LEFT JOIN dental_contacttype ct ON ct.contacttypeid = c.contacttypeid
			where c.contactid='".(!empty($_REQUEST["ed"]) ? $_REQUEST["ed"] : '')."'";
$themyarray = $db->getRow($thesql);

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

<link rel="stylesheet" href="css/quick_view.css" type="text/css" media="screen" />

<div style="padding-top:10px;background: #fff; width: 98%; height:380px; margin-left: 1%;">
	<div class="info">
		<label>Name:</label> <span class="value"><?php echo $salutation." ".$firstname." ".$middlename." ".$lastname; ?></span>
	</div>
	<div class="info">
		<label>Company:</label> <span class="value"><?php echo $company; ?> </span>
	</div>
	<div class="info">
        <label>Contact Type:</label> <span class="value"><?php echo $contacttype; ?> </span>
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
	<?php
if($themyarray['corporate']=='1'){ ?>
	<a href="view_fcontact.php?ed=<?php echo $_REQUEST['ed'];?>" style="margin-right:10px;float:right;">View Full</a>
<?php 
}else{ ?>
	<a href="add_contact.php?ed=<?php echo (!empty($_REQUEST['ed']) ? $_REQUEST['ed'] : '');?>" style="margin-right:10px;float:right;">Edit</a>
<?php 
} ?>
</div>

</body>
</html>
