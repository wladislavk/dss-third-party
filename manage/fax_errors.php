<?php namespace Ds3\Libraries\Legacy; ?><?php 
	include_once('admin/includes/main_include.php');
	include("includes/sescheck.php");
	include_once "admin/includes/general.htm";
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
		    $thesql = "select f.*, ec.description, ec.resolution
						FROM dental_faxes f
						LEFT JOIN dental_fax_error_codes ec ON ec.error_code = f.sfax_error_code
						where f.id='".(!empty($_REQUEST["id"]) ? $_REQUEST["id"] : '')."'";

			$themyarray = $db->getRow($thesql);

        // If the lookup table is no longer valid, use the sfax_response (API response) field
        $faxError = '';

        if ($themyarray['error_description'] && $themyarray['error_resolution']) {
            $faxError = $themyarray['error_description'] . ' - ' . $themyarray['error_resolution'];
        } else if ($themyarray['sfax_response']) {
            $apiResponse = @json_decode($themyarray['sfax_response']);

            if (!empty($apiResponse->ResultMessage)) {
                $faxError = $apiResponse->ResultMessage;
            } else if (!empty($apiResponse->RecipientFaxStatusItems[0]->ResultMessage)) {
                $faxError = $apiResponse->RecipientFaxStatusItems[0]->ResultMessage;
            } else if (!empty($apiResponse['ResultMessage'])) {
                $faxError = $apiResponse['ResultMessage'];
            }
        }

        $faxError = $faxError ?: 'Unknown error';

		?>

		<link rel="stylesheet" href="/manage/css/fax_errors.css" type="text/css" />

		<div style="padding-top:10px;background: #fff; width: 98%; height:380px; margin-left: 1%;">
			<div class="info">
				<label>Error: </label>
				<span class="value"><?php echo  $themyarray['sfax_error_code']; ?></span>
			</div>
			<div class="info">
			    <label>&nbsp; </label>
			    <span class="value"><?= htmlspecialchars($faxError) ?></span>
			</div>
			<div class="info">
			    <label>&nbsp; </label>
			    <span class="value"><?php echo  $themyarray['resolution']; ?></span>
			</div>
			<div class="info">
				<label>Sent: </label>
				<span class="value"><?php echo  date('m/d/Y h:i a', strtotime($themyarray['sent_date'])); ?> </span>
			</div>
			<div class="info">
			    <label>To: </label>
			    <span class="value"><?php echo  $themyarray['to_name']. " - " . format_phone($themyarray['to_number']); ?> </span>
			</div>
		</div>
	</body>
</html>
