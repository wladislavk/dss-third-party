<link rel="stylesheet" href="css/ledger.css" />
<?php
$sql = "SELECT n.*,
        CASE
          WHEN n.create_type='0'
            THEN CONCAT (a.first_name, ' ', a.last_name)
          ELSE
            CONCAT (u.first_name, ' ', u.last_name)
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

<span class="admin_head" >
	Claim Notes 
</span>
<a href="#" onclick="loadPopup('add_claim_note.php?claim_id=<?=$_GET['claimid'];?>&pid=<?=$_GET['pid'];?>');return false;" class="button">Add Note</a>
<br />
<br />
<?php
  while($r = mysql_fetch_assoc($my)){
	?>
   <div class="fullwidth" style="padding:2px;display:block; border:solid 1px #000;">
     <?= $r['note']; ?>

    <div class="sub"><?= $r['creator_name']; ?> on <?= $r['adddate']; ?></div>
   <?php
	if($r['create_type']=='1' && $r['creator_id']==$_SESSION['userid']){ ?>
    <a href="#" onclick="loadPopup('add_claim_note.php?claim_id=<?=$_GET['claimid'];?>&pid=<?=$_GET['pid'];?>&nid=<?=$r['id'];?>');return false;" class="button">Edit Note</a>
	<?php } ?>
  </div>


	<?php
  }
?>


<div id="popupContact" style="width:750px;">
    <a id="popupContactClose"><button>X</button></a>
    <iframe id="aj_pop" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
</div>
<div id="backgroundPopup"></div>

<br /><br />	
