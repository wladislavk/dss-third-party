<? 
include "includes/top.htm";
include_once ' ../includes/constants.inc';
if(isset($_POST['respond'])){

  if($_POST['body']!=''){
    $s = "INSERT INTO dental_support_responses SET
	ticket_id = '".mysql_real_escape_string($_GET['ed'])."',
	responder_id='".mysql_real_escape_string($_SESSION['adminuserid'])."',
	response_type=0,
	body = '".mysql_real_escape_string($_POST['body'])."',
	adddate = now(),
	ip_address = '".mysql_real_escape_string($_SERVER['REMOTE_ADDR'])."'
		";
    mysql_query($s);
  }

  if($_POST['close']==2){
    $s = "UPDATE dental_support_tickets SET
		status='2'
		WHERE id = '".mysql_real_escape_string($_GET['ed'])."'";
    mysql_query($s);
  }

  if($_POST['reopen']==1){
    $s = "UPDATE dental_support_tickets SET
                status='1'
                WHERE id = '".mysql_real_escape_string($_GET['ed'])."'";
    mysql_query($s);
  } 
} 


$sql = "select t.* FROM dental_support_tickets t 
	 WHERE t.id = ".mysql_real_escape_string($_REQUEST['ed']);
$my = mysql_query($sql);
$t = mysql_fetch_assoc($my);
?>

<link rel="stylesheet" href="popup/popup.css" type="text/css" media="screen" />
<script src="popup/jquery-1.2.6.min.js" type="text/javascript"></script>
<script src="popup/popup.js" type="text/javascript"></script>
<link rel="stylesheet" href="css/support.css" type="text/css" />
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
    ?>
    <div class="response_type_<?= $r['response_type']; ?>">
    <?php
    echo $r['body'];
    if($r['response_type']==0){
      ?> | <a href="#" onclick="loadPopup('edit_support_response.php?ed=<?= $_GET['ed']; ?>&id=<?= $r['id']; ?>'); return false;">Edit</a><?php
    }
    ?></div><?php
  }

?>
<h4 style="clear:both;">Respond</h4>
<form action="<?= $_SERVER['PHP_SELF']; ?>?ed=<?= $_REQUEST['ed']; ?>" method="post">
  <textarea name="body" style="width: 400px; height:100px;"></textarea><br />
  <?php if($t['status']==DSS_TICKET_STATUS_OPEN || $t['status'] == DSS_TICKET_STATUS_REOPENED){ ?>
    <input type="checkbox" value="2" name="close" /> Close<br />
  <?php }else{ ?>
    TICKET IS CLOSED <input type="checkbox" value="1" name="reopen" /> Reopen<br />
  <?php } ?>
  <input type="submit" name="respond" value="Submit Response" /> 
</form>

<div id="popupContact">
    <a id="popupContactClose"><button>X</button></a>
    <iframe id="aj_pop" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
</div>
<div id="backgroundPopup"></div>

<br /><br />	
<? include "includes/bottom.htm";?>
