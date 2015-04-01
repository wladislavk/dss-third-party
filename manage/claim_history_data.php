<link rel="stylesheet" href="css/ledger.css" />
<?php
  $sql = "SELECT * FROM dental_claim_electronic WHERE claimid='".mysqli_real_escape_string($con,(!empty($_GET['cid']) ? $_GET['cid'] : ''))."' ORDER BY adddate DESC";
  $my = $db->getResults($sql);
  $total_rec = count($my);
  $num_users = $total_rec;

  $csql = "SELECT * FROM dental_insurance i WHERE i.insuranceid = ".mysqli_real_escape_string($con,(!empty($_GET['cid']) ? $_GET['cid'] : ''));
  $claim = $db->getRow($csql);
?>

<span class="admin_head">
	Claim History
</span>

<br />

<?php if ($my) foreach ($my as $r) { ?>
  <div style="margin-left:20px; border:solid 1px #99c; width:80%; margin-top:20px; padding:0 20px;">
    <?php
		  if($r['reference_id']!='') {
        $w_sql = "SELECT * FROM dental_eligible_response WHERE reference_id='".mysqli_real_escape_string($con,$r['reference_id'])."' ORDER BY adddate DESC";
        $w_q = $db->getResults($w_sql);
        foreach ($w_q as $w_r) {
    ?>
          <h3>
            <?php echo $w_r['event_type']; ?> on
                <?php echo $w_r['adddate']; ?>
          </h3>
          <?php $p = json_decode($w_r['response']); ?>
          <p>Category: <?php echo  $p->{"details"}->{"codes"}->{"category_code"}; ?> - <?php echo  $p->{"details"}->{"codes"}->{"category_label"}; ?><br />
          Status: <?php echo  $p->{"details"}->{"codes"}->{"status_code"}; ?> - <?php echo  $p->{"details"}->{"codes"}->{"status_label"}; ?>
          </p>
    <?php
        }
		  }
    ?>

		<h3>Claim Electronically filed on <?php echo  $r['adddate']; ?></h3>
		<?php
 			$d = json_decode($r['response']);
      if (!empty($d)) {
        $success = $d->{"success"}; 
      } else {
        $success = '';
      }
			
			if ($success == "true"){
		?>
        <p><strong>Success Response:</strong><br />
    <?php
			} else {
    ?>
        <p><strong>Error Response:</strong><br />
          <?php
              if (!empty($errors)) {
                $errors = $d->{"errors"};
              } else {
                $errors = array();
              }
              
              foreach($errors as $error){
                echo $error->{"message"}."<br />";
              }
      			}
      		?>
		    </p>
	</div>
<?php
  }
?>

<span class="admin_head">
  Claim Version History
</span>

<?php
  $sql = "SELECT * FROM dental_insurance_history WHERE insuranceid='".mysqli_real_escape_string($con,(!empty($_GET['cid']) ? $_GET['cid'] : ''))."'";
  $q = $db->getResults($sql);
  if ($q) foreach($q as $r) {
?>
    <div style="margin-left:20px; border:solid 1px #99c; width:80%; margin-top:20px; padding:0 20px;">
    	<?php echo  $r['updated_at']; ?> - Claim Status = <?php echo  $dss_claim_status_labels[$r['status']];?> - 
    	<?php
        $u_sql = "SELECT first_name, last_name from dental_users where userid='".$r['updated_by_user']."'";
    		$u_r = $db->getRow($u_sql);
    		echo $u_r['first_name']." ".$u_r['last_name'];
    		
        $u_sql = "SELECT first_name, last_name from admin where adminid='".$r['updated_by_admin']."'";
        $u_r = $db->getRow($u_sql);
        echo $u_r['first_name']." ".$u_r['last_name']
      ?>
	    <a href="#" onclick="$('#cvh_<?php echo $r['id']; ?>').toggle(); return false;">Expand</a>
    	<div id="cvh_<?php echo $r['id']; ?>" style="display:none;">
    		<br />
          <?php print_r($r); ?>
    	</div>
	  </div>
<?php
  }
?>

<div id="popupContact" style="width:750px;">
  <a id="popupContactClose">
    <button>X</button>
  </a>
  <iframe id="aj_pop" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
</div>
<div id="backgroundPopup"></div>

<br /><br />	
