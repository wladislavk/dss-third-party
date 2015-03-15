<?php namespace Ds3\Legacy; ?><link rel="stylesheet" href="admin/css/support.css" />

<?php
  $c_sql = "SELECT CONCAT(p.firstname,' ', p.lastname) pat_name, CONCAT(u.first_name, ' ',u.last_name) doc_name 
        		FROM dental_insurance i
        		JOIN dental_patients p ON i.patientid=p.patientid
        		JOIN dental_users u ON u.userid=p.docid
        		WHERE p.patientid='".mysqli_real_escape_string($con,(!empty($_GET['pid']) ? $_GET['pid'] : ''))."'";
  $c = $db->getRow($c_sql);

  $sql = "SELECT n.*, CASE WHEN n.create_type='0' THEN CONCAT(a.first_name, ' ', a.last_name)
            ELSE CONCAT(u.first_name, ' ', u.last_name) END as creator_name
          FROM dental_claim_notes n left join dental_users u ON n.creator_id = u.userid
          left join admin a ON n.creator_id = a.adminid where n.claim_id='".mysqli_real_escape_string($con,(!empty($_GET['claimid']) ? $_GET['claimid'] : ''))."'";

  $my = $db->getResults($sql);
  $total_rec = count($my);

  $num_users = $total_rec
?>

<div class="fullwidth">
  <span class="admin_head" >
  	Claim Notes <?php echo $c['pat_name']; ?>
  </span>
  <a href="#" onclick="loadPopup('add_claim_note.php?claim_id=<?php echo (!empty($_GET['claimid']) ? $_GET['claimid'] : '');?>&pid=<?php echo (!empty($_GET['pid']) ? $_GET['pid'] : '');?>');return false;" class="button" style="float:right;">Add Note</a>
  <br /><br />

  <?php if ($my) foreach ($my as $r) { ?>
          <div class="response_type_<?php echo  $r['create_type']; ?>" >
            <?php echo $r['note']; ?>
            <div class="sub"><?php echo  $r['creator_name']; ?> on <?php echo  $r['adddate']; ?></div>
            <?php if($r['create_type'] == '1' && $r['creator_id'] == $_SESSION['userid']) { ?>
              <br />
              <a href="#" onclick="loadPopup('add_claim_note.php?claim_id=<?php echo (!empty($_GET['claimid']) ? $_GET['claimid'] : '');?>&pid=<?php echo (!empty($_GET['pid']) ? $_GET['pid'] : '');?>&nid=<?php echo $r['id'];?>');return false;" class="button">Edit Note</a>
      	    <?php } ?>
          </div>
  <?php } ?>

  <div style="clear:both;"></div>
</div>

<div id="popupContact" style="width:750px;">
  <a id="popupContactClose">
    <button>X</button>
  </a>
  <iframe id="aj_pop" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
</div>
<div id="backgroundPopup"></div>

<br /><br />	
