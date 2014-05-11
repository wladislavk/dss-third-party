<?php 
session_start();
require_once('includes/main_include.php');
include("includes/sescheck.php");
include_once "includes/general.htm";
include_once "../includes/constants.inc";
include_once "includes/invoice_functions.php";
if(isset($_POST["enrollsub"]))
{

  $sql = "SELECT * FROM dental_users where userid='".mysql_real_escape_string($_GET['docid'])."'";
  $q = mysql_query($sql);
  $r = mysql_fetch_assoc($q);
$payer_id = substr($_POST['payer_id'],0,strpos($_POST['payer_id'], '-'));
$payer_name = substr($_POST['payer_id'],strpos($_POST['payer_id'], '-')+1);
        $t_sql = "SELECT * FROM dental_enrollment_transaction_type WHERE id='".mysql_real_escape_string($_POST['transaction_type'])."'";
        $t_q = mysql_query($t_sql);
        $t_r = mysql_fetch_assoc($t_q);
$data = array();
$data['api_key'] = "33b2e3a5-8642-1285-d573-07a22f8a15b4";
if(isset($_POST['test']) && $_POST['test'] == "1"){
  $data['test'] = "true";
}
$data['enrollment_npi'] = array(
        "payer_id" => $payer_id,
        "transaction_type" => $t_r['transaction_type'],
        "facility_name" => $_POST['facility_name'],
        "provider_name" => $_POST['provide_name'],
        "tax_id" => $_POST['tax_id'],
        "address" => $_POST['address'],
        "city" => $_POST['city'],
        "state" => $_POST['state'],
        "zip" => $_POST['zip'],
        "npi" => $_POST['npi'],
        "authorized_signer" => array(
                "first_name" => $_POST['first_name'],
                "last_name" => $_POST['last_name'],
                "contact_number" => $_POST['phone'],
                "email" => $_POST['email'],
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
        user_id = '".mysql_real_escape_string($_GET['docid'])."',
        payer_id = '".mysql_real_escape_string($payer_id)."',
        payer_name = '".mysql_real_escape_string($payer_name)."',
        reference_id = '".mysql_real_escape_string($ref_id)."',
        response='".mysql_real_escape_string($result)."',
        transaction_type_id='".mysql_real_escape_string($_POST['transaction_type'])."',
        status='0',
        adddate=now(),
        ip_address='".mysql_real_escape_string($_SERVER['REMOTE_ADDR'])."'
        ";

  mysql_query($up_sql) or die(mysql_error());
  $eid = mysql_insert_id();
  invoice_add_enrollment('2', $_SESSION['admincompanyid'], $eid);
  ?>
  <script type="text/javascript">
    parent.window.location = "manage_enrollments.php?ed=<?=$_GET['docid']; ?>";
  </script>
  <?php
  die();
}
}
?>

<?php require_once dirname(__FILE__) . '/includes/popup_top.htm'; ?>
<script type="text/javascript" src="../3rdParty/input_mask/jquery.maskedinput.min.js"></script>
	<script type="text/javascript" src="/manage/script/masks.js"></script>
 <script type="text/javascript" src="/manage/script/autocomplete.js"></script>
 <script type="text/javascript" src="/manage/script/autocomplete_local.js"></script>	
<link href="/manage/css/search-hints.css" rel="stylesheet" type="text/css">
	<? if($msg != '') {?>
    <div class="alert alert-danger text-center">
        <? echo $msg;?>
    </div>
    <? }?>
    <form name="planfrm" action="<?=$_SERVER['PHP_SELF'];?>?add=1&docid=<?=$_GET['docid'];?>" method="post" ><!--onsubmit="return check_add();">-->
    <table class="table table-bordered table-hover">
        <tr>
            <td colspan="2" class="cat_head">
               Add Enrollment
               <? if($name <> "") {?>
               		&quot;<?=$name;?>&quot;
               <? }?>
            </td>
        </tr>
  <?php $t_sql = "SELECT * FROM dental_enrollment_transaction_type ORDER BY transaction_type ASC";
        $t_q = mysql_query($t_sql);
  ?>

        <?php
                $s = "SELECT eligible_test FROM dental_users where userid='".$_GET['docid']."'";
                $q = mysql_query($s);
                $r = mysql_fetch_assoc($q);
                if($r['eligible_test']=="1"){
        ?>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Test?
            </td>
            <td valign="top" class="frmdata">
                <input type="checkbox" name="test" value="1" class="" />
            </td>
        </tr>
        <?php } ?>

        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Transaction Type
            </td>
            <td valign="top" class="frmdata">
        <select id="transaction_type" class="form-control" name="transaction_type" onchange="update_list()">
            <?php while($t = mysql_fetch_assoc($t_q)){ ?>
                <option value="<?= $t['id']; ?>"><?= $t['transaction_type']; ?> - <?= $t['description']; ?></option>
            <?php } ?>
        </select>
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Payer
            </td>
            <td valign="top" class="frmdata">
                <input type="hidden" name="payer_id" id="payer_id">
                                <input type="text" id="ins_payer_name" class="form-control" onclick="updateval(this)" autocomplete="off" name="ins_payer_name" value="Type insurance payer name" style="width:300px;" />
<br />
<div id="ins_payer_hints" class="search_hints" style="margin-top:20px; display:none;">
        <ul id="ins_payer_list" class="search_list">
                <li class="template" style="display:none"></li>
        </ul>
<script type="text/javascript">
$(document).ready(function(){
setup_autocomplete_local('ins_payer_name', 'ins_payer_hints', 'payer_id', '', 'https://eligibleapi.com/resources/payers/eligibility.json', 'ins_payer', null, null, false);
});
</script>
            </td>
        </tr>
<?php
  $sql = "SELECT * FROM dental_users where userid='".mysql_real_escape_string($_GET['docid'])."'";
  $q = mysql_query($sql);
  $r = mysql_fetch_assoc($q);
$payer_id = substr($_POST['payer_id'],0,strpos($_POST['payer_id'], '-'));
$payer_name = substr($_POST['payer_id'],strpos($_POST['payer_id'], '-')+1);
        $t_sql = "SELECT * FROM dental_enrollment_transaction_type WHERE id='".mysql_real_escape_string($_POST['transaction_type'])."'";
        $t_q = mysql_query($t_sql);
        $t_r = mysql_fetch_assoc($t_q);
?>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Facility Name
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="facility_name" value="<?=$r['practice'];?>" class="form-control validate" />          
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Provider Name
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="provider_name" value="<?=$r['first_name']." ".$r['last_name'];?>" class="form-control validate" />          
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
		Tax ID
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="tax_id" value="<?=$r['tax_id_or_ssn'];?>" class="form-control validate" />          
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
		Address
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="address" value="<?=$r['address'];?>" class="form-control validate" />
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
		City
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="city" value="<?=$r['city'];?>" class="form-control validate" />
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
		State
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="state" value="<?=$r['state'];?>" class="form-control validate" />
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
		Zip
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="zip" value="<?=$r['zip'];?>" class="form-control validate" />
            </td>
        </tr>
	<!-- new -->
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
		NPI
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="npi" value="<?=$r['npi']?>" class="moneymask form-control validate" />
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
		First Name
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="first_name" value="<?=$r['first_name'];?>" class="form-control validate" />
            </td>
        </tr>

        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
		Last Name
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="last_name" value="<?=$r['last_name'];?>" class="form-control validate" />
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
		Contact Number
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="contact_number" value="<?=$r['phone']?>" class="form-control validate" />
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
		Email
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="email" value="<?=$email?>" class="form-control validate" />
            </td>
        </tr>
        <tr>
            <td  colspan="2" align="center">
                <input type="hidden" name="enrollsub" value="1" />
                <input type="hidden" name="ed" value="<?=$themyarray["id"]?>" />
                <input type="submit" value="Add Enrollment" class="btn btn-primary">
            </td>
        </tr>
    </table>
    </form>
<script type="text/javascript">
function check_add(){
        var isValid = true;
        $('input[type="text"]').each(function() {
            if ($.trim($(this).val()) == '') {
                isValid = false;
            }
        });
        if (isValid == false){ 
	    alert('All fields are required.');
	    return false;
        }else{ 
	    return true;
	}
}
</script>
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
