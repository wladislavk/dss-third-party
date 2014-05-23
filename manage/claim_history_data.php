<link rel="stylesheet" href="css/ledger.css" />
<?php
$sql = "SELECT * FROM dental_claim_electronic WHERE claimid='".mysql_real_escape_string($_GET['cid'])."' ORDER BY adddate DESC";
$my = mysql_query($sql);
$total_rec = mysql_num_rows($my);

$my=mysql_query($sql) or die(mysql_error());
$num_users=mysql_num_rows($my);

$csql = "SELECT * FROM dental_insurance i WHERE i.insuranceid = ".mysql_real_escape_string($_GET['cid']);
$cq = mysql_query($csql);
$claim = mysql_fetch_assoc($cq);
?>

<span class="admin_head">
	Claim History
</span>

<br />

<?php
  while($r = mysql_fetch_assoc($my)){
	?><div style="margin-left:20px; border:solid 1px #99c; width:80%; margin-top:20px; padding:0 20px;">
                <?php
		  if($r['reference_id']!=''){
                        $w_sql = "SELECT * FROM dental_eligible_response WHERE reference_id='".mysql_real_escape_string($r['reference_id'])."' ORDER BY adddate DESC";
                        $w_q = mysql_query($w_sql);
                        while($w_r = mysql_fetch_assoc($w_q)){
                          ?><h3><?= $w_r['event_type']; ?> on
                <?= $w_r['adddate']; ?></h3>
<?php $p = json_decode($w_r['response']); ?>
                                <p>Category: <?= $p->{"details"}->{"codes"}->{"category_code"}; ?> - <?= $p->{"details"}->{"codes"}->{"category_label"}; ?><br />
                                Status: <?= $p->{"details"}->{"codes"}->{"status_code"}; ?> - <?= $p->{"details"}->{"codes"}->{"status_label"}; ?>
                                </p>

                                <p><?= $w_r['response']; ?></p>
                        <?php
                        }
		  }
                        ?>

		<h3>Claim Electronically filed on
    		<?= $r['adddate']; ?></h3>
			<?php
 			$d = json_decode($r['response']);
			$success = $d->{"success"};
			if($success=="true"){
				?><p><strong>Success Response:</strong><br /><?php
			}else{
                                ?><p><strong>Error Response:</strong><br /><?php
                                        $errors = $d->{"errors"}->{"messages"};
                                        foreach($errors as $error){
                                          echo $error."<br />";
                                        }
			}
			?>
		<?= $r['response'];?></p>
	</div><?php
  }
?>




<span class="admin_head">
        Claim Version History
</span>
<?php
  $sql = "SELECT * FROM dental_insurance_history WHERE insuranceid='".mysql_real_escape_string($_GET['cid'])."'";
  $q = mysql_query($sql) or die(mysql_error());
  while($r = mysql_fetch_assoc($q)){
 ?><div style="margin-left:20px; border:solid 1px #99c; width:80%; margin-top:20px; padding:0 20px;">
                <?php
    print_r($r);
    ?></div><?php

  }
?>




<div id="popupContact" style="width:750px;">
    <a id="popupContactClose"><button>X</button></a>
    <iframe id="aj_pop" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
</div>
<div id="backgroundPopup"></div>

<br /><br />	
