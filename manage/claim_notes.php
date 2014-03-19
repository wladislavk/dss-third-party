<link rel="stylesheet" href="admin/css/support.css" />
<?php
$c_sql = "SELECT CONCAT(p.firstname,' ', p.lastname) pat_name, CONCAT(u.first_name, ' ',u.last_name) doc_name 
		FROM dental_insurance i
		JOIN dental_patients p ON i.patientid=p.patientid
		JOIN dental_users u ON u.userid=p.docid";
$c_q = mysql_query($c_sql) or die(mysql_error());
$c = mysql_fetch_assoc($c_q);

$sql = "SELECT n.*,
        CASE
          WHEN n.create_type='0'
            THEN CONCAT(a.first_name, ' ', a.last_name)
          ELSE
            CONCAT(u.first_name, ' ', u.last_name)
          END as creator_name
         FROM dental_claim_notes n 
        left join dental_users u ON n.creator_id = u.userid
        left join admin a ON n.creator_id = a.adminid
        where n.claim_id='".mysql_real_escape_string($_GET['claimid'])."'";

$my = mysql_query($sql);
$total_rec = mysql_num_rows($my);

$my=mysql_query($sql) or die(mysql_error());
$num_users=mysql_num_rows($my);

?>
<div class="fullwidth">
<span class="admin_head" >
	Claim Notes <?= $c['pat_name']; ?>
</span>
<a href="#" onclick="loadPopup('add_claim_note.php?claim_id=<?=$_GET['claimid'];?>&pid=<?=$_GET['pid'];?>');return false;" class="button" style="float:right;">Add Note</a>
<br />
<br />
<?php
  while($r = mysql_fetch_assoc($my)){
	?>
   <div class="response_type_<?= $r['create_type']; ?>" >
     <?= $r['note']; ?>

    <div class="sub"><?= $r['creator_name']; ?> on <?= $r['adddate']; ?></div>
   <?php
	if($r['create_type']=='1' && $r['creator_id']==$_SESSION['userid']){ ?>
<br />
    <a href="#" onclick="loadPopup('add_claim_note.php?claim_id=<?=$_GET['claimid'];?>&pid=<?=$_GET['pid'];?>&nid=<?=$r['id'];?>');return false;" class="button">Edit Note</a>
	<?php } ?>
  </div>


	<?php
  }
?>
<div style="clear:both;"></div>
</div>

<div id="popupContact" style="width:750px;">
    <a id="popupContactClose"><button>X</button></a>
    <iframe id="aj_pop" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
</div>
<div id="backgroundPopup"></div>

<br /><br />	
