<?php 
session_start();
require_once('admin/includes/main_include.php');
include("includes/sescheck.php");
include "includes/general_functions.php";
include_once "admin/includes/general.htm";
include_once "includes/constants.inc";
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

<?php
if(isset($_POST["enroll_but"]))
{

echo "safdsaf";
  $sql = "SELECT * FROM dental_users where userid='".mysql_real_escape_string($_SESSION['docid'])."'";
  $q = mysql_query($sql);
  $r = mysql_fetch_assoc($q);
$data = array();
$data['api_key'] = "33b2e3a5-8642-1285-d573-07a22f8a15b4";
$data['enrollment_npi'] = array(
	"payer_id" => $_POST['payer_id'],
	"transaction_type" => '835',
	"facility_name" => $r['practice'],
	"provider_name" => $r['first_name'].' '.$r['last_name'],
	"tax_id" => $r['tax_id_or_ssn'],
	"address" => $r['address'],
	"city" => $r['city'],
	"state" => $r['state'],
	"zip" => $r['zip'],
	"npi" => $r['npi'],
	"authorized_signer" => array(
		"first_name" => $r['first_name'],
		"last_name" => $r['last_name'],
		"contact_number" => $r['phone'],
		"email" => $r['email'],
		"signature" => array("coordinates" => $r['signature_json'])
		)
	);


$data_string = json_encode($data);

echo $data_string."<br /><br />";
//$ch = curl_init('https://v1.eligibleapi.net/claim/submit.json?api_key=33b2e3a5-8642-1285-d573-07a22f8a15b4');                                                                      
$ch = curl_init('https://gds.eligibleapi.com/v1.3/enrollment_npis');
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json',
    'Content-Length: ' . strlen($data_string))
);

$result = curl_exec($ch);
echo $result;



}

?>
<?php /*
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="css/admin.css" rel="stylesheet" type="text/css" />
<script language="javascript" type="text/javascript" src="script/validation.js"></script>

<link rel="stylesheet" href="css/form.css" type="text/css" />
<script type="text/javascript" src="script/wufoo.js"></script>
</head>
<body width="98%"> */ ?>


    <form name="contactfrm" action="<?=$_SERVER['PHP_SELF'];?>" method="post">

		<input type="text" name="payer_id">

                <input type="submit" value=" Enroll " name="enroll_but" class="button" />
    </form>


</body>
</html>
