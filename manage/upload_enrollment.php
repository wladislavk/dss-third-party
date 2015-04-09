<?php 
session_start();
require_once('admin/includes/main_include.php');
include("includes/sescheck.php");
include_once "includes/constants.inc";
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
if(isset($_POST["enrollsub"]))
{

  $api_key = DSS_DEFAULT_ELIGIBLE_API_KEY;
  $api_key_sql = "SELECT eligible_api_key FROM dental_user_company LEFT JOIN companies ON dental_user_company.companyid = companies.id WHERE dental_user_company.userid = '".mysqli_real_escape_string($con, $r['userid'])."'";
  $api_key_query = mysqli_query($con, $api_key_sql);
  $api_key_result = mysqli_fetch_assoc($api_key_query);
  if($api_key_result && !empty($api_key_result['eligible_api_key'])){
    if(trim($api_key_result['eligible_api_key']) != ""){
      $api_key = $api_key_result['eligible_api_key'];
    }
  }
$data = array();
$data['test'] = "true";
$data['api_key'] = $api_key;
//$data['enrollment_npi_id'] = $_REQUEST['ed'];
$data['file'] = '@'.$_FILES['file']['tmp_name'];

//$data_string = json_encode($data);
//error_log($data_string);
$ch = curl_init('https://gds.eligibleapi.com/v1.5/enrollment_npis/'.$_REQUEST['ed'].'/original_signature_pdf');
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

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
  $ref_id = $_REQUEST['ed'];
  $download_url = $json_response->{"original_signature_pdf"}->{"download_url"};
  $up_sql = "UPDATE dental_eligible_enrollment SET
    status='".DSS_ENROLLMENT_PDF_SENT."',
    signed_download_url = '".mysqli_real_escape_string($con, $download_url)."'
    WHERE reference_id='".mysqli_real_escape_string($con, $ref_id)."'";
    mysqli_query($con, $up_sql);
  echo "<p>Your enrollment has been submitted.</p>";
  die();
}
}
?>

	<? if($msg != '') {?>
    <div class="alert alert-danger text-center">
        <? echo $msg;?>
    </div>
    <? }?>
    <form name="planfrm" action="<?=$_SERVER['PHP_SELF'];?>?add=1&docid=<?=$_GET['docid'];?>" method="post" enctype="multipart/form-data">
    <table class="table table-bordered table-hover">
        <tr>
            <td colspan="2" class="cat_head">
               Upload Enrollment
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                File
            </td>
            <td valign="top" class="frmdata">
                <input type="file" id="file" name="file" class="form-control" />          
            </td>
        </tr>
        <tr>
            <td  colspan="2" align="center">
                <input type="hidden" name="enrollsub" value="1" />
                <input type="hidden" name="ed" value="<?=$_REQUEST["id"]?>" />
                <input type="submit" value="Upload Enrollment" class="btn btn-primary">
            </td>
        </tr>
    </table>
    </form>
    
</body>
</html>
