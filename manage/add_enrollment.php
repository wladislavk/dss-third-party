<?php 
session_start();
require_once('admin/includes/main_include.php');
include("includes/sescheck.php");
//include "includes/general_functions.php";
include_once "admin/includes/general.htm";
include_once "includes/constants.inc";
//include "includes/top.htm";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="/manage/css/admin.css" rel="stylesheet" type="text/css" />
<script language="javascript" type="text/javascript" src="../script/validation.js"></script>
<!--<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>-->
  <script type="text/javascript" src="/manage/admin/script/jquery-1.6.2.min.js"></script>
    <script type="text/javascript" src="/manage/3rdParty/input_mask/jquery.maskedinput-1.3.min.js"></script>
    <script type="text/javascript" src="/manage/js/masks.js"></script>
 <script type="text/javascript" src="/manage/script/autocomplete.js"></script>
 <script type="text/javascript" src="/manage/script/autocomplete_local.js"></script>
<link rel="stylesheet" href="/manage/css/form.css" type="text/css" />
<link href="/manage/css/search-hints.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="script/wufoo.js"></script>
</head>
<body>
<br />
<?php
if(isset($_POST["enroll_but"]))
{

  $sql = "SELECT * FROM dental_users where userid='".mysql_real_escape_string($_SESSION['docid'])."'";
  $q = mysql_query($sql);
  $r = mysql_fetch_assoc($q);
$payer_id = substr($_POST['payer_id'],0,strpos($_POST['payer_id'], '-'));
$payer_name = substr($_POST['payer_id'],strpos($_POST['payer_id'], '-')+1);
	$t_sql = "SELECT * FROM dental_enrollment_transaction_type WHERE id='".mysql_real_escape_string($_POST['transaction_type'])."'";
        $t_q = mysql_query($t_sql);
	$t_r = mysql_fetch_assoc($t_q);
$data = array();
$data['api_key'] = "33b2e3a5-8642-1285-d573-07a22f8a15b4";
$data['test'] = "true";
$data['enrollment_npi'] = array(
	"payer_id" => $payer_id,
	"transaction_type" => $t_r['transaction_type'],
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
error_log($data_string);
//echo $data_string."<br /><br />";
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
$json_response = json_decode($result);

if(isset($json_response->{"error"})){
  $error = $json_response->{"error"};
  ?>
    <script type="text/javascript">
      alert("<?= $error; ?>");
    </script>
  <?php
}else{
  $ref_id = $json_response->{"enrollment_npi"}->{"id"};
  $success = $json_response->{"success"};
  $up_sql = "INSERT INTO dental_eligible_enrollment SET 
	user_id = '".mysql_real_escape_string($_SESSION['docid'])."',
        payer_id = '".mysql_real_escape_string($payer_id)."',
        payer_name = '".mysql_real_escape_string($payer_name)."',
        reference_id = '".mysql_real_escape_string($ref_id)."',
        response='".mysql_real_escape_string($result)."',
	status='0',
        adddate=now(),
        ip_address='".mysql_real_escape_string($_SERVER['REMOTE_ADDR'])."'
        ";
  mysql_query($up_sql) or die(mysql_error());
  ?>
  <script type="text/javascript">
    parent.window.location = "manage_enrollment.php";
  </script>
  <?php
  die();
}
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
  <?php $t_sql = "SELECT * FROM dental_enrollment_transaction_type ORDER BY transaction_type ASC";
        $t_q = mysql_query($t_sql);
  ?>
        <select id="transaction_type" name="transaction_type" onchange="update_list()">
            <?php while($t = mysql_fetch_assoc($t_q)){ ?>
                <option value="<?= $t['id']; ?>"><?= $t['transaction_type']; ?> - <?= $t['description']; ?></option>
            <?php } ?>
        </select>
<br />

		<input type="hidden" name="payer_id" id="payer_id">
                                <input type="text" id="ins_payer_name" onclick="updateval(this)" autocomplete="off" name="ins_payer_name" value="Type insurance payer name" style="width:300px;" />
<br />
<div id="ins_payer_hints" class="search_hints" style="margin-top:20px; display:none;">
        <ul id="ins_payer_list" class="search_list">
                <li class="template" style="display:none"></li>
        </ul>
</div>
<script type="text/javascript">
$(document).ready(function(){
setup_autocomplete_local('ins_payer_name', 'ins_payer_hints', 'payer_id', '', 'https://eligibleapi.com/resources/payers/eligibility.json', 'ins_payer');
});
</script>
<br />
                <input type="submit" value=" Enroll " name="enroll_but" class="button" />
    </form>

<script type="text/javascript">

function update_list(){
  var t = $('#transaction_type').val();
  if(t == '1'){
    setup_autocomplete_local('ins_payer_name', 'ins_payer_hints', 'payer_id', '', 'https://eligibleapi.com/resources/payers/eligibility.json', 'ins_payer');
  }else if(t == '2'){
    setup_autocomplete_local('ins_payer_name', 'ins_payer_hints', 'payer_id', '', 'https://eligibleapi.com/resources/payers/claims/payment/status.json', 'ins_payer');
  }else if(t == '4'){
    setup_autocomplete_local('ins_payer_name', 'ins_payer_hints', 'payer_id', '', 'https://eligibleapi.com/resources/payers/claims/era.json', 'ins_payer');
  }else if(t == '5'){
    setup_autocomplete_local('ins_payer_name', 'ins_payer_hints', 'payer_id', '', '', 'ins_payer');
  }else if(t == '6'){
    setup_autocomplete_local('ins_payer_name', 'ins_payer_hints', 'payer_id', '', 'https://eligibleapi.com/resources/payers/claims/dental.json', 'ins_payer');
  }else if(t == '7'){
    setup_autocomplete_local('ins_payer_name', 'ins_payer_hints', 'payer_id', '', 'https://eligibleapi.com/resources/payers/claims/institutional.json', 'ins_payer');
  }
}
</script>

</body>
</html>
