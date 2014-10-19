<?php 
  include_once('admin/includes/main_include.php');
  include("includes/sescheck.php");
  include_once "admin/includes/general.htm";
  include_once "includes/constants.inc";
  include_once "admin/includes/invoice_functions.php";
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
    if(isset($_POST["enroll_but"])) {
      $sql = "SELECT * FROM dental_users where userid='".mysql_real_escape_string($_SESSION['docid'])."'";
      
      $r = $db->getRow($sql);
      $payer_id = substr($_POST['payer_id'],0,strpos($_POST['payer_id'], '-'));
      $payer_name = substr($_POST['payer_id'],strpos($_POST['payer_id'], '-')+1);
    	$t_sql = "SELECT * FROM dental_enrollment_transaction_type WHERE id='".mysql_real_escape_string($_POST['transaction_type'])."' AND status=1";
      
    	$t_r = $db->getRow($t_sql);
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
          alert("<?php echo  $error; ?>");
        </script>
    <?php } else {
      $ref_id = $json_response->{"enrollment_npi"}->{"id"};
      $success = $json_response->{"success"};
      $up_sql = "INSERT INTO dental_eligible_enrollment SET 
                user_id = '".mysql_real_escape_string($_SESSION['docid'])."',
                payer_id = '".mysql_real_escape_string($payer_id)."',
                payer_name = '".mysql_real_escape_string($payer_name)."',
                npi = '".mysql_real_escape_string($_POST['npi'])."',
                reference_id = '".mysql_real_escape_string($ref_id)."',
                response='".mysql_real_escape_string($result)."',
              	transaction_type_id='".mysql_real_escape_string($_POST['transaction_type'])."',
              	status='0',
              	facility_name = '".mysql_real_escape_string($_POST['facility_name'])."',
              	provider_name = '".mysql_real_escape_string($_POST['provider_name'])."',
              	tax_id = '".mysql_real_escape_string($_POST['tax_id'])."',
              	address = '".mysql_real_escape_string($_POST['address'])."',
              	city = '".mysql_real_escape_string($_POST['city'])."',
              	state = '".mysql_real_escape_string($_POST['state'])."',
              	zip = '".mysql_real_escape_string($_POST['zip'])."',
              	first_name = '".mysql_real_escape_string($_POST['first_name'])."',
              	last_name = '".mysql_real_escape_string($_POST['last_name'])."',
              	contact_number = '".mysql_real_escape_string($_POST['contact_number'])."',
              	email = '".mysql_real_escape_string($_POST['email'])."',
                adddate=now(),
                ip_address='".mysql_real_escape_string($_SERVER['REMOTE_ADDR'])."'
                ";

      $eid = $db->getInsertId($up_sql);
      invoice_add_enrollment('1', $_SESSION['docid'], $eid);
    ?>
      <script type="text/javascript">
        parent.window.location = "manage_enrollment.php";
      </script>
    <?php
      die();
    }
  }
?>

  <link href="css/add_enrollment.css" rel="stylesheet" type="text/css" />

  <form name="contactfrm" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
    <?php
      $t_sql = "SELECT * FROM dental_enrollment_transaction_type WHERE status=1 ORDER BY transaction_type ASC";
      
      $t_q = $db->getResults($t_sql);

  		$s = "SELECT eligible_test FROM dental_users where userid='".$_SESSION['docid']."'";
  		$r = $db->getRow($s);
  		if($r['eligible_test']=="1") {
	  ?>
      <div>
        <label style="color:#fff;">Test?</label> <input type="checkbox" value="1" name="test" />
      </div>
	  <?php } ?>
    <div style="clear:both;">
    	<label style="color:#fff;">Enroll Type</label>
      <select id="transaction_type" name="transaction_type" onchange="update_list()">
          <?php if ($t_q) foreach ($t_q as $t) { ?>
              <option value="<?php echo  $t['id']; ?>"><?php echo  $t['transaction_type']; ?> - <?php echo  $t['description']; ?></option>
          <?php } ?>
      </select>
    </div>
    <div style="clear:both;">
    	<label style="color:#fff;">Insurance Co</label>
    	<input type="hidden" name="payer_id" id="payer_id">
      <input type="text" id="ins_payer_name" onclick="updateval(this)" autocomplete="off" name="ins_payer_name" value="Type insurance payer name" style="width:300px;" />
      <br />
      <div id="ins_payer_hints" class="search_hints" style="margin-top:20px; display:none;">
        <ul id="ins_payer_list" class="search_list">
          <li class="template" style="display:none"></li>
        </ul>
      </div>
    </div>

    <script type="text/javascript" src="js/add_enrollment.js"></script>

    <?php
      $sql = "SELECT * FROM dental_users WHERE (docid='".$_SESSION['docid']."' OR userid='".$_SESSION['docid']."') AND npi !='' AND (producer=1 OR docid=0) ORDER BY docid ASC";
      
      $q = $db->getResults($sql);
      $payer_id = substr($_POST['payer_id'],0,strpos($_POST['payer_id'], '-'));
      $payer_name = substr($_POST['payer_id'],strpos($_POST['payer_id'], '-')+1);
      $t_sql = "SELECT * FROM dental_enrollment_transaction_type WHERE id='".mysql_real_escape_string($_POST['transaction_type'])."' AND status=1";
      
      $t_r = $db->getRow($t_sql);
    ?>

    <div>
    	<label style="color:#fff;">NPI to Enroll</label>
            <select id="provider_select" name="provider_select">
              <?php if ($q) foreach ($q as $r) { ?>
                <?php
                  $us_sql = "SELECT * FROM dental_user_signatures where user_id='".mysql_real_escape_string($_SESSION['docid'])."'";
                  
                  $signature = $db->getNumberRows($us_sql);
                ?>
                <?php if($r['docid']==0){
                  $snpi = $r['service_npi'];
      		        $sjson ='{"facility_name":"'.$r['practice'].'","provider_name":"'.$r['first_name'].' '.$r['last_name'].'", "tax_id":"'.$r['tax_id_or_ssn'].'", "address":"'.$r['address'].'","city":"'.$r['city'].'","state":"'.$r['state'].'","zip":"'.$r['zip'].'","npi":"'.$r['npi'].'","first_name":"'.$r['first_name'].'","last_name":"'.$r['last_name'].'","contact_number":"'.$r['phone'].'","email":"'.$r['email'].'","signature":"'.$signature.'"}';
                }
      		      $json ='{"facility_name":"'.$r['practice'].'","provider_name":"'.$r['first_name'].' '.$r['last_name'].'", "tax_id":"'.$r['tax_id_or_ssn'].'", "address":"'.$r['address'].'","city":"'.$r['city'].'","state":"'.$r['state'].'","zip":"'.$r['zip'].'","npi":"'.$r['npi'].'","first_name":"'.$r['first_name'].'","last_name":"'.$r['last_name'].'","contact_number":"'.$r['phone'].'","email":"'.$r['email'].'","signature":"'.$signature.'"}';
              ?>
                <option value='<?php echo  $json; ?>'><?php echo  $r['npi']; ?> - <?php echo  $r['first_name']." ".$r['last_name']; ?></option>
              <?php } ?>
              <?php if($snpi != '') { ?>
                <option value='<?php echo  $sjson; ?>'><?php echo  $snpi; ?> - Service Facility</option>
              <?php } ?>
            </select>
    </div>
    <div style="clear:both;">
    	<label style="color:#fff;">Facility Name</label>
    	<input type="text" id="facility_name" name="facility_name" value="<?php echo  $r['practice']; ?>" readonly="readonly" />
    </div>
    <div>
      <label>Provider Name</label> 
	    <input type="text" id="provider_name" name="provider_name" value="<?php echo $r['first_name'].' '.$r['last_name']; ?>" readonly="readonly" />
    </div>
    <div>
      <label>Tax ID</label>
    	<input type="text" id="tax_id" name="tax_id" value="<?php echo  $r['tax_id_or_ssn']; ?>" readonly="readonly" />
    </div>
    <div>
      <label>Address</label>
    	<input type="text" id="address" name="address" value="<?php echo  $r['address']; ?>" readonly="readonly" />
    <div>
    <div>
      <label>City</label>
    	<input type="text" id="city" name="city" value="<?php echo  $r['city']; ?>" readonly="readonly" />
    </div>
    <div>
      <label>State</label>
    	<input type="text" id="state" name="state" value="<?php echo  $r['state']; ?>" readonly="readonly" />
    </div>
    <div>
      <label>Zip</label>
    	<input type="text" id="zip" name="zip" value="<?php echo  $r['zip']; ?>" readonly="readonly" />
    </div>
    <div>
      <label>NPI</label>
    	<input type="text" id="npi" name="npi" value="<?php echo  $r['npi']; ?>" readonly="readonly" />
    </div>
    <div>
      <label>First Name</label>
    	<input type="text" id="first_name" name="first_name" value="<?php echo  $r['first_name']; ?>" readonly="readonly" />
    </div>
    <div>
      <label>Last Name</label>
    	<input type="text" id="last_name" name="last_name" value="<?php echo  $r['last_name']; ?>" readonly="readonly" />
    </div>
    <div>
      <label>Contact Number</label>
    	<input type="text" id="contact_number" name="contact_number" value="<?php echo  $r['phone']; ?>" readonly="readonly" />
    </div>
    <div>
      <label>Email</label>
    	<input type="text" id="email" name="email" value="<?php echo  $r['email']; ?>" readonly="readonly" />
    </div>
    <input type="submit" value=" Enroll " name="enroll_but" class="button" />
  </form>
</body>
</html>