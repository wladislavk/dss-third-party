<? 
include "includes/top.htm";
if(isset($_POST['respond'])){

  $s = "INSERT INTO dental_support_responses SET
	ticket_id = '".mysql_real_escape_string($_GET['ed'])."',
	responder_id='".mysql_real_escape_string($_SESSION['userid'])."',
	response_type=1,
	body = '".mysql_real_escape_string($_POST['body'])."',
	adddate = now(),
	ip_address = '".mysql_real_escape_string($_SERVER['REMOTE_ADDR'])."'
		";
  mysql_query($s);
 
} 


$sql = "select t.* FROM dental_support_tickets t 
	 WHERE t.id = ".mysql_real_escape_string($_REQUEST['ed']);
$my = mysql_query($sql);
$t = mysql_fetch_assoc($my);
?>

<link rel="stylesheet" href="popup/popup.css" type="text/css" media="screen" />
<script src="popup/jquery-1.2.6.min.js" type="text/javascript"></script>
<script src="popup/popup.js" type="text/javascript"></script>
<div style="width:96%; margin:0 auto;">
<span class="admin_head">
	<?= $t['title']; ?>
</span>
<br />
<br />

<?= $t['body']; ?>


<?php
  $r_sql = "SELECT r.* FROM dental_support_responses r
		WHERE ticket_id = '".mysql_real_escape_string($_REQUEST['ed'])."'";
  $r_q = mysql_query($r_sql);
  while($r = mysql_fetch_assoc($r_q)){
    ?><br /><br /><?php
    echo $r['body'];
  }

?>
<h4>Respond</h4>
<form action="<?= $_SERVER['PHP_SELF']; ?>?ed=<?= $_REQUEST['ed']; ?>" method="post">
  <textarea name="body" style="width: 400px; height:100px;"></textarea><br />
  <input type="submit" name="respond" value="Sumbit Response" /> 
</form>
</div>
<div id="popupContact">
    <a id="popupContactClose"><button>X</button></a>
    <iframe id="aj_pop" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
</div>
<div id="backgroundPopup"></div>

<br /><br />	
<? include "includes/bottom.htm";?>
