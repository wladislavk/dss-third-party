<?php namespace Ds3\Libraries\Legacy; ?><?php
  include_once '../admin/includes/main_include.php';
  include_once '../includes/constants.inc';
  include_once '../includes/claim_functions.php';
  include_once '../admin/includes/claim_functions.php';

  $pid = $_GET['pid'];
  $cid = $_GET['cid'];
  $prod = $_GET['prod'];
  $sql = "SELECT * from dental_insurance 
  		WHERE insuranceid='".mysqli_real_escape_string($con, $cid)."'";

  $r = $db->getRow($sql);

  if($r['other_insured_firstname']!='' && 
  	$r['other_insured_lastname']!='' &&
  	$r['patient_relation_other_insured']!='' &&
  	$r['other_insured_dob']!='' &&
  	$r['other_insured_sex']!='' &&
  	$r['other_insured_policy_group_feca']!='' &&
  	$r['other_insurance_type']!=''
  	){
      $id = claim_create_sec($pid, $cid, $prod, true);
?>
      <script type="text/javascript">
        parent.window.location = parent.window.location;
      </script>
<?php
    } else {
?>
      <script type="text/javascript">
        alert("Notice: Secondary Insurance was not indicated on the Primary Claim, but this patient may have Secondary Insurance benefits. If you would like to file a secondary insurance claim please verify the Secondary Insurance in the \"Pt Info\" section and return to this claim ledger item to generate a Secondary Claim.");
        parent.window.location = parent.window.location;
      </script>  
<?php } ?>
