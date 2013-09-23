<? 
include "includes/top.htm";
?>

<a href="support.php" style="float:right; margin-right:20px;" class="button">Return to support</a>
<?php
$v_sql = "UPDATE dental_support_tickets SET viewed=1 WHERE create_type = 0 && id = ".mysql_real_escape_string($_REQUEST['ed']);
mysql_query($v_sql);
$v_sql = "UPDATE dental_support_responses SET viewed=1 WHERE response_type = 0 && ticket_id = ".mysql_real_escape_string($_REQUEST['ed']);
mysql_query($v_sql);
if(isset($_POST['respond'])){
  if($_POST['body']!='' || $_FILES['attachment']['tmp_name']!=''){
    $s = "INSERT INTO dental_support_responses SET
	ticket_id = '".mysql_real_escape_string($_GET['ed'])."',
	responder_id='".mysql_real_escape_string($_SESSION['userid'])."',
	response_type=1,
	body = '".mysql_real_escape_string($_POST['body'])."',
	adddate = now(),
	ip_address = '".mysql_real_escape_string($_SERVER['REMOTE_ADDR'])."'
		";
    mysql_query($s);
    $r_id = mysql_insert_id();
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

                if($_FILES['attachment']['tmp_name']!=''){
                  $extension = end(explode(".", $_FILES["attachment"]["name"]));
                  $attachment = "support_response_attachment_".$r_id."_".$_GET['ed'].".".$extension;
                  move_uploaded_file($_FILES["attachment"]["tmp_name"], "q_file/" . $attachment);

                  $a_sql = "UPDATE dental_support_responses SET
                                attachment = '".mysql_real_escape_string($attachment)."'
                                where id=".mysql_real_escape_string($r_id);
                  mysql_query($a_sql);
                }
        ?>
        <script type="text/javascript">
                window.location = window.location;
        </script>
        <?php

} 


$sql = "select t.*
	FROM dental_support_tickets t 
	 WHERE t.id = ".mysql_real_escape_string($_REQUEST['ed']);
$my = mysql_query($sql);
$t = mysql_fetch_assoc($my);
?>

<link rel="stylesheet" href="popup/popup.css" type="text/css" media="screen" />
<script src="popup/jquery-1.2.6.min.js" type="text/javascript"></script>
<script src="popup/popup.js" type="text/javascript"></script>
<link rel="stylesheet" href="admin/css/support.css" type="text/css" />
<div style="width:96%; margin:0 auto;">
<div id="support_ticket">
<span class="admin_head">
	<?= $t['title']; ?>
</span>
<br />
<br />
    <div class="response_type_<?= $t['create_type']; ?>">
	<?= $t['body']; ?>
    <?php
      if($t['attachment']!=''){
        ?> | <a href="./q_file/<?= $t['attachment']; ?>">View Attachment</a><?php
      }
    ?>
    <div class="info">
      <?php
        if($t['create_type']=='0'){
          $u_sql = "SELECT username name FROM admin WHERE adminid='".mysql_real_escape_string($t['creator_id'])."'";
          $u_q = mysql_query($u_sql);
          $u_r = mysql_fetch_assoc($u_q);
          ?>Support - <?= $u_r['name'];
        }elseif($t['create_type']=='1'){
          $u_sql = "SELECT name FROM dental_users WHERE userid='".mysql_real_escape_string($t['creator_id'])."'";
          $u_q = mysql_query($u_sql);
          $u_r = mysql_fetch_assoc($u_q);
          echo $u_r['name'];
        }

      ?>
      <?= date('m/d/Y h:i:s a', strtotime($t['adddate'])); ?>
    </div>
    </div>
</div>

<div id="support_responses">
<?php
  $r_sql = "SELECT r.* FROM dental_support_responses r
		WHERE ticket_id = '".mysql_real_escape_string($_REQUEST['ed'])."'";
  $r_q = mysql_query($r_sql);
  while($r = mysql_fetch_assoc($r_q)){
    ?>
    <div class="response_type_<?= $r['response_type']; ?>">
    <?php
    echo $r['body'];
	?>
    <?php
      if($r['attachment']!=''){
        ?> | <a href="./q_file/<?= $r['attachment']; ?>">View Attachment</a><?php
      }
    ?>
    <div class="info">
      <?php
        if($r['response_type']=='0'){
          $u_sql = "SELECT username name FROM admin WHERE adminid='".mysql_real_escape_string($r['responder_id'])."'";
          $u_q = mysql_query($u_sql);
          $u_r = mysql_fetch_assoc($u_q);
          ?>Support - <?= $u_r['name']; 
        }elseif($r['response_type']=='1'){
          $u_sql = "SELECT name FROM dental_users WHERE userid='".mysql_real_escape_string($r['responder_id'])."'";
          $u_q = mysql_query($u_sql);
          $u_r = mysql_fetch_assoc($u_q);
          echo $u_r['name'];
        }
        
      ?>
      <?= date('m/d/Y h:i:s a', strtotime($r['adddate'])); ?>
    </div> 
</div><?php
  }

?>
<div style="clear:both;"></div>
</div>

<div id="respond">
<h4>Respond</h4>
<form action="<?= $_SERVER['PHP_SELF']; ?>?ed=<?= $_REQUEST['ed']; ?>" method="post"  enctype="multipart/form-data">
  <textarea name="body" style="width: 400px; height:100px;"></textarea><br />
  <input type="submit" name="respond" value="Submit Response" style="float:left;"/>
<div style="float:left; width:300px;">
<input type="file" name="attachment" id="attachment"  style="float:right" class="field text addr tbox" />
  <div style="float:right;">
  <?php if($t['status']==DSS_TICKET_STATUS_OPEN || $t['status'] == DSS_TICKET_STATUS_REOPENED){ ?>
    <input type="checkbox" value="2" name="close" /> Close Ticket<br />
  <?php }else{ ?>
    <input type="checkbox" value="1" name="reopen" /> Reopen Ticket<br />
  <?php } ?>
  </div>
</div>
</form>
</div>
</div>
<div id="popupContact">
    <a id="popupContactClose"><button>X</button></a>
    <iframe id="aj_pop" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
</div>
<div id="backgroundPopup"></div>

<br /><br />	
<? include "includes/bottom.htm";?>
