<? 
include "includes/top.htm";
include_once ' ../includes/constants.inc';

$v_sql = "UPDATE dental_support_tickets SET viewed=1 WHERE create_type = 1 && id = ".mysql_real_escape_string($_REQUEST['ed']);
mysql_query($v_sql);
$v_sql = "UPDATE dental_support_responses SET viewed=1 WHERE response_type = 1 AND ticket_id = ".mysql_real_escape_string($_REQUEST['ed']);
mysql_query($v_sql);

if(isset($_POST['respond'])){

  if($_POST['body']!='' || $_FILES['attachment']['tmp_name'][0]!=''){
    $s = "INSERT INTO dental_support_responses SET
	ticket_id = '".mysql_real_escape_string($_GET['ed'])."',
	responder_id='".mysql_real_escape_string($_SESSION['adminuserid'])."',
	response_type=0,
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


                for($i=0;$i < count($_FILES['attachment']['name']); $i++){
                if($_FILES['attachment']['tmp_name'][$i]!=''){
                  $extension = end(explode(".", $_FILES['attachment']["name"][$i]));
                  $attachment = "support_attachment_".$r_id."_".$_SESSION['docid']."_".rand(1000, 9999).".".$extension;
                  move_uploaded_file($_FILES['attachment']["tmp_name"][$i], "../../../../shared/q_file/" . $attachment);

                  $a_sql = "INSERT INTO dental_support_attachment SET
                                filename = '".mysql_real_escape_string($attachment)."',
                                ticket_id='".mysql_real_escape_string($_GET['ed'])."',
                                response_id='".mysql_real_escape_string($r_id)."'";
                  mysql_query($a_sql);
                }
                }

	?>
	<script type="text/javascript">
		window.location = window.location;
	</script>
	<?php
} 


$sql = "select t.*,
        CONCAT(u.first_name, ' ',u.last_name) as user,
        CONCAT(a.first_name, ' ',a.last_name) as account,
        c.name as company,
        cat.title as category 
	FROM dental_support_tickets t 
                LEFT JOIN dental_users u ON u.userid=t.userid
		LEFT JOIN dental_users a ON a.userid=t.docid
                LEFT JOIN dental_user_company uc ON uc.userid=t.docid
                LEFT JOIN companies c ON c.id=uc.companyid
                LEFT JOIN dental_support_categories cat ON cat.id = t.category_id
	 WHERE t.id = ".mysql_real_escape_string($_REQUEST['ed']);
$my = mysql_query($sql);
$t = mysql_fetch_assoc($my);
?>

<link rel="stylesheet" href="popup/popup.css" type="text/css" media="screen" />
<script src="popup/popup.js" type="text/javascript"></script>
<link rel="stylesheet" href="css/support.css" type="text/css" />
<div id="support_ticket">
<div class="page-header">
	<h2><?= $t['title']; ?>  <small>- Category: <?= $t['category']; ?>
</small></h2></div>
<h3 style="margin-left:15px;">User: <?= $t['user']; ?> - Account: <?= $t['account']; ?> - Company: <?= $t['company']; ?></h3>
<br />
<br />
    <div class="response_type_<?=($t['create_type']!='')?$t['create_type']:'1';?>">
	<?= $t['body']; ?>
      <?php if($t['attachment']){
        ?> | <a href="display_file.php?f=<?= $t['attachment']; ?>" target="_blank">View Attachment</a><?php
      } 
        $a_sql = "SELECT * FROM dental_support_attachment WHERE response_id IS NULL AND ticket_id='".mysql_real_escape_string($t['id'])."'";
        $a_q = mysql_query($a_sql);
        while($a=mysql_fetch_assoc($a_q)){
        ?> | <a href="display_file.php?f=<?= $a['filename']; ?>" target="_blank">View Attachment</a><?php
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
      if($r['attachment']){
        ?> | <a href="display_file.php?f=<?= $r['attachment']; ?>" target="_blank">View Attachment</a><?php
      }
        $a_sql = "SELECT * FROM dental_support_attachment WHERE response_id ='".mysql_real_escape_string($r['id'])."'";
        $a_q = mysql_query($a_sql);
        while($a=mysql_fetch_assoc($a_q)){
        ?> | <a href="display_file.php?f=<?= $a['filename']; ?>" target="_blank">View Attachment</a><?php
        }
    if($r['response_type']==0){
      ?> | <a href="#" onclick="loadPopup('edit_support_response.php?ed=<?= $_GET['ed']; ?>&id=<?= $r['id']; ?>'); return false;">Edit</a><?php
    } ?>
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
<h4 style="clear:both;">Respond</h4>
<form action="<?= $_SERVER['PHP_SELF']; ?>?ed=<?= $_REQUEST['ed']; ?>" method="post" enctype="multipart/form-data">
  <textarea name="body" style="width: 400px; height:100px;"></textarea><br />
  <input type="submit" name="respond" value="Submit Response"  style="float:left;" class="btn btn-primary">
  <div style=" width:300px;">
        <div id="attachments">
                                <span><input type="file" name="attachment[]" id="attachment1" class="attachment" onchange="$('#add_attachment_but').show()" style="height:auto;width:auto;" /> <a href="#" onclick="$(this).parent().remove();$('#add_attachment_but').show();return false;">Remove</a></span>

                                </div>
                                <a href="#" id="add_attachment_but" onclick="add_attachment();return false;" style="padding:3px 5px; display:none;" class="btn btn-primary">Add</a>

<div style="float:right;">
  <?php if($t['status']==DSS_TICKET_STATUS_OPEN || $t['status'] == DSS_TICKET_STATUS_REOPENED){ ?>
    <input type="checkbox" value="2" name="close" /> Mark Closed<br />
  <?php }else{ ?>
    <input type="checkbox" value="1" name="reopen" /> Reopen<br />
  <?php } ?>
  </div>
</div>
</form>
                <script type="text/javascript">
                        function add_attachment(){
                                var blank = $(".attachment").filter(function() {
    return !this.value;}).length;
                        if(blank > 0){
                          alert('Please attach another file with the "Browse" button before adding another.');
                          return false;
                        }

                                if($('.attachment').length<3){  
                                  $('#attachments').append('<span><input type="file" name="attachment[]" id="attachment1" class="attachment" style="height:auto; width:auto;" /> <a href="#" onclick="$(this).parent().remove();$(\'#add_attachment_but\').show();return false;">Remove</a></span>');
                                }
                                if($('.attachment').length==3){
                                  $('#add_attachment_but').hide();
                                }

                        }
                </script>

</div>
<div id="popupContact">
    <a id="popupContactClose"><span class="glyphicon glyphicon-remove"></span></a>
    <iframe id="aj_pop" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
</div>
<div id="backgroundPopup"></div>

<br /><br />	
<? include "includes/bottom.htm";?>
