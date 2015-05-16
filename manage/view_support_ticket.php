<?php 
include "includes/top.htm";
?>

<a href="support.php" style="float:right; margin-right:20px;" class="button">Return to support</a>

<?php
$v_sql = "UPDATE dental_support_tickets SET viewed=1 WHERE create_type = 0 && id = '".mysqli_real_escape_string($con,(!empty($_REQUEST['ed']) ? $_REQUEST['ed'] : '')) . "'";
$db->query($v_sql);
$v_sql = "UPDATE dental_support_responses SET viewed=1 WHERE response_type = 0 && ticket_id = '".mysqli_real_escape_string($con,(!empty($_REQUEST['ed']) ? $_REQUEST['ed'] : '')) . "'";
$db->query($v_sql);
if(isset($_POST['respond'])){
  if($_POST['body']!='' || $_FILES['attachment']['name'][0]!=''){
    $s = "INSERT INTO dental_support_responses SET
          	ticket_id = '".mysqli_real_escape_string($con,$_GET['ed'])."',
          	responder_id='".mysqli_real_escape_string($con,$_SESSION['userid'])."',
          	response_type=1,
          	body = '".mysqli_real_escape_string($con,$_POST['body'])."',
          	adddate = now(),
          	ip_address = '".mysqli_real_escape_string($con,$_SERVER['REMOTE_ADDR'])."'
        		";
    $r_id = $db->getInsertId($s);
  }

  if(!empty($_POST['close']) && $_POST['close']==2){
    $s = "UPDATE dental_support_tickets SET
            status='2'
            WHERE id = '".mysqli_real_escape_string($con,$_GET['ed'])."'";
    $db->query($s);
  }

  if(!empty($_GET['ed'])) {
    $closedTickers = "SELECT * FROM dental_support_tickets WHERE id = '".mysqli_real_escape_string($con,$_GET['ed'])."' AND status=2";
    $countTicket = $db->getNumberRows($closedTickers);
  } else {
    $countTicket = 0;
  }

  if($countTicket && $_POST['reopen']==1){
    $s = "UPDATE dental_support_tickets SET
            status='1'
            WHERE id = '".mysqli_real_escape_string($con,$_GET['ed'])."'";
    $db->query($s);?>
<script type="text/javascript">
  alert("This ticket was closed and has now been reopened. We will respond promptly to your inquiry. Thank you!");
</script>
	<?php
  }

  for($i=0;$i < count($_FILES['attachment']['name']); $i++){
    if($_FILES['attachment']['tmp_name'][$i]!=''){
      $extension = preg_replace('/^.*[.]([^.]+)$/', '$1', ($_FILES['attachment']["name"][$i]));
      $attachment = "support_attachment_".$r_id."_".$_SESSION['docid']."_".rand(1000, 9999).".".$extension;
      move_uploaded_file($_FILES['attachment']["tmp_name"][$i], '../../../shared/q_file/' . $attachment);

      $a_sql = "INSERT INTO dental_support_attachment SET
                  filename = '".mysqli_real_escape_string($con,$attachment)."',
                  ticket_id='".mysqli_real_escape_string($con,$_GET['ed'])."',
                  response_id='".mysqli_real_escape_string($con,$r_id)."'";
      $db->query($a_sql);
    }
  }?>
<script type="text/javascript">
  window.location = window.location;
</script>
<?php
} 

$sql = "SELECT t.*, (SELECT name FROM companies WHERE companies.id=t.company_id LIMIT 1) AS company_name
          FROM dental_support_tickets t 
          WHERE t.id = ".mysqli_real_escape_string($con,(!empty($_REQUEST['ed']) ? $_REQUEST['ed'] : ''));
$t = $db->getRow($sql);
$company_name = "Dental Sleep Solutions";
if (!empty($t['company_name'])){
  $company_name = $t['company_name'];
}
?>

<link rel="stylesheet" href="popup/popup.css" type="text/css" media="screen" />
<script src="popup/popup.js" type="text/javascript"></script>
<link rel="stylesheet" href="admin/css/support.css" type="text/css" />
<div style="width:96%; margin:0 auto;">
  <div id="support_ticket">
    <span class="admin_head">
    	<?php echo (!empty($t['title']) ? $t['title'] : '')." - ".$company_name; ?>
    </span>
    <br />
    <br />
    <div class="response_type_<?php echo (!empty($t['create_type']) ? $t['create_type'] : ''); ?>">
      <?php echo (!empty($t['body']) ? $t['body'] : '');
if(!empty($t['attachment'])){?>
      | <a href="display_file.php?f=<?php echo $t['attachment']; ?>" target="_blank">View Attachment</a>
<?php
}
$a_sql = "SELECT * FROM dental_support_attachment WHERE response_id IS NULL AND ticket_id='".mysqli_real_escape_string($con,(!empty($t['id']) ? $t['id'] : ''))."'";
$a_q = $db->getResults($a_sql);
if ($a_q)
foreach ($a_q as $a) {?>
      | <a href="display_file.php?f=<?php echo $a['filename']; ?>" target="_blank">View Attachment</a>
<?php
}?>
      <div class="info">
<?php
if(empty($t['create_type'])){
  $u_sql = "SELECT username name FROM admin WHERE adminid='".mysqli_real_escape_string($con,(!empty($t['creator_id']) ? $t['creator_id'] : ''))."'";
  $u_r = $db->getRow($u_sql);
  echo 'Support - ' . $u_r['name'];
}elseif($t['create_type']=='1'){
  $u_sql = "SELECT name FROM dental_users WHERE userid='".mysqli_real_escape_string($con,(!empty($t['creator_id']) ? $t['creator_id'] : ''))."'";
  $u_r = $db->getRow($u_sql);
  echo $u_r['name'];
}

echo date('m/d/Y h:i:s a', strtotime((!empty($t['adddate']) ? $t['adddate'] : ''))); ?>
      </div>
    </div>
  </div>

  <div id="support_responses">
<?php
$r_sql = "SELECT r.* FROM dental_support_responses r
            WHERE ticket_id = '".mysqli_real_escape_string($con,(!empty($_REQUEST['ed']) ? $_REQUEST['ed'] : ''))."'";
$r_q = $db->getResults($r_sql);
if ($r_q)
foreach ($r_q as $r) {?>
    <div class="response_type_<?php echo $r['response_type']; ?>">
<?php
  echo $r['body'];
  if($r['attachment']!=''){?> 
      | <a href="display_file.php?f=<?php echo $r['attachment']; ?>" target="_blank">View Attachment</a>
<?php
  }
  $a_sql = "SELECT * FROM dental_support_attachment WHERE response_id ='".mysqli_real_escape_string($con,$r['id'])."'";
  $a_q = $db->getResults($a_sql);
  foreach ($a_q as $a) {?> 
      | <a href="display_file.php?f=<?php echo $a['filename']; ?>" target="_blank">View Attachment</a>
<?php
  }?>
      <div class="info">
<?php
  if($r['response_type']=='0'){
    $u_sql = "SELECT username name FROM admin WHERE adminid='".mysqli_real_escape_string($con,$r['responder_id'])."'";
    $u_r = $db->getRow($u_sql);
    echo 'Support - ' . $u_r['name']; 
  }elseif($r['response_type']=='1'){
    $u_sql = "SELECT name FROM dental_users WHERE userid='".mysqli_real_escape_string($con,$r['responder_id'])."'";
    $u_r = $db->getRow($u_sql);
    echo $u_r['name'];
  }
  echo date('m/d/Y h:i:s a', strtotime($r['adddate'])); ?>
      </div> 
    </div>
<?php
}?>
    <div style="clear:both;"></div>
  </div>

  <div id="respond">
    <h4>Respond</h4>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>?ed=<?php echo (!empty($_REQUEST['ed']) ? $_REQUEST['ed'] : ''); ?>" method="post"  enctype="multipart/form-data">
      <textarea name="body" style="width: 400px; height:100px;"></textarea><br />
      <input type="submit" name="respond" value="Submit Response" style="float:left;"/>
      <div style="width:300px;">
        <div id="attachments">
          <span><input type="file" name="attachment[]" id="attachment1" class="addattachment" onchange="$('#add_attachment_but').show();" style="height:auto;width:auto;" /> <a href="#" onclick="$(this).parent().remove();$('#add_attachment_but').show();return false;">Remove</a></span>
        </div>
        <a href="#" id="add_attachment_but" onclick="add_attachment();return false;" style="display:none;" class="button">Add Additional</a>
        <div style="float:right;">
<?php 
if(!empty($t['status']) && ($t['status']==DSS_TICKET_STATUS_OPEN || $t['status'] == DSS_TICKET_STATUS_REOPENED)){ ?>
          <input type="checkbox" value="2" name="close" /> Close Ticket<br />
<?php 
}else{ ?>
          <input type="hidden" value="1" name="reopen" />
<?php 
} ?>
        </div>
      </div>
    </form>
  </div>
</div>
<div id="popupContact">
  <a id="popupContactClose"><button>X</button></a>
  <iframe id="aj_pop" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
</div>
<script src="js/view_support_ticket.js" type="text/javascript"></script>
<div id="backgroundPopup"></div>

<br /><br />	
<?php include "includes/bottom.htm";?>
