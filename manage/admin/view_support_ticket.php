<?php 
include "includes/top.htm";
include_once '../includes/constants.inc';

$v_sql = "UPDATE dental_support_tickets SET viewed=1 WHERE create_type = 1 && id = ".mysqli_real_escape_string($con,$_REQUEST['ed']);
mysqli_query($con,$v_sql);
$v_sql = "UPDATE dental_support_responses SET viewed=1 WHERE response_type = 1 AND ticket_id = ".mysqli_real_escape_string($con,$_REQUEST['ed']);
mysqli_query($con,$v_sql);

if(isset($_POST['respond'])){

  if($_POST['body']!='' || $_FILES['attachment']['tmp_name'][0]!=''){
    $s = "INSERT INTO dental_support_responses SET
	ticket_id = '".mysqli_real_escape_string($con,$_GET['ed'])."',
	responder_id='".mysqli_real_escape_string($con,$_SESSION['adminuserid'])."',
	response_type=0,
	body = '".mysqli_real_escape_string($con,$_POST['body'])."',
	adddate = now(),
	ip_address = '".mysqli_real_escape_string($con,$_SERVER['REMOTE_ADDR'])."'
		";
    mysqli_query($con,$s);
    $r_id = mysqli_insert_id($con);
  }

  if(!empty($_POST['close']) && $_POST['close']==2){
    $s = "UPDATE dental_support_tickets SET
		status='2'
		WHERE id = '".mysqli_real_escape_string($con,$_GET['ed'])."'";
    mysqli_query($con,$s);
  }

  if(!empty($_POST['reopen']) && $_POST['reopen']==1){
    $s = "UPDATE dental_support_tickets SET
                status='1'
                WHERE id = '".mysqli_real_escape_string($con,$_GET['ed'])."'";
    mysqli_query($con,$s);
  } 


                for($i=0;$i < count($_FILES['attachment']['name']); $i++){
                if($_FILES['attachment']['tmp_name'][$i]!=''){
                  $extension = preg_replace('/^.*[.]([^.]+)$/', '$1', ($_FILES['attachment']["name"][$i]));
                  $attachment = "support_attachment_".$r_id."_".$_SESSION['docid']."_".rand(1000, 9999).".".$extension;
                  move_uploaded_file($_FILES['attachment']["tmp_name"][$i], "../../../../shared/q_file/" . $attachment);

                  $a_sql = "INSERT INTO dental_support_attachment SET
                                filename = '".mysqli_real_escape_string($con,$attachment)."',
                                ticket_id='".mysqli_real_escape_string($con,$_GET['ed'])."',
                                response_id='".mysqli_real_escape_string($con,$r_id)."'";
                  mysqli_query($con,$a_sql);
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
	 WHERE t.id = ".mysqli_real_escape_string($con,$_REQUEST['ed']);
$my = mysqli_query($con,$sql);
$t = mysqli_fetch_assoc($my);
?>

<link rel="stylesheet" href="popup/popup.css" type="text/css" media="screen" />
<script src="popup/popup.js" type="text/javascript"></script>
<link rel="stylesheet" href="css/support.css" type="text/css" />
<div id="support_ticket">
<div class="page-header">
	<h2><?php echo  $t['title']; ?>  <small>- Category: <?php echo  $t['category']; ?>
</small></h2></div>
<h3 style="margin-left:15px;">User: <?php echo  $t['user']; ?> - Account: <?php echo  $t['account']; ?> - Company: <?php echo  $t['company']; ?></h3>
<br />
<br />
    <div class="panel <?php echo ($t['create_type']==0)?"panel-info":"panel-success";?>">
	<div class="panel-heading">
      <?php
        if($t['create_type']=='0'){
          $u_sql = "SELECT username name FROM admin WHERE adminid='".mysqli_real_escape_string($con,$t['creator_id'])."'";
          $u_q = mysqli_query($con,$u_sql);
          $u_r = mysqli_fetch_assoc($u_q);
          ?>Support - <?php echo  $u_r['name'];
        }elseif($t['create_type']=='1'){
          $u_sql = "SELECT name FROM dental_users WHERE userid='".mysqli_real_escape_string($con,$t['creator_id'])."'";
          $u_q = mysqli_query($con,$u_sql);
          $u_r = mysqli_fetch_assoc($u_q);
          echo $u_r['name'];
        }

      ?>
      <?php echo  date('m/d/Y h:i:s a', strtotime($t['adddate'])); ?>
    </div>
     <div class="panel-body">
	<?php echo  $t['body']; ?>
      <?php if($t['attachment']){
        ?> | <a href="display_file.php?f=<?php echo  $t['attachment']; ?>" target="_blank">View Attachment</a><?php
      } 
        $a_sql = "SELECT * FROM dental_support_attachment WHERE response_id IS NULL AND ticket_id='".mysqli_real_escape_string($con,$t['id'])."'";
        $a_q = mysqli_query($con,$a_sql);
        while($a=mysqli_fetch_assoc($a_q)){
        ?> | <a href="display_file.php?f=<?php echo  $a['filename']; ?>" target="_blank">View Attachment</a><?php
        }

	?>
    </div>
</div>
<div id="support_responses">
<?php
  $r_sql = "SELECT r.* FROM dental_support_responses r
		WHERE ticket_id = '".mysqli_real_escape_string($con,$_REQUEST['ed'])."'";
  $r_q = mysqli_query($con,$r_sql);
  while($r = mysqli_fetch_assoc($r_q)){
    ?>
    <div class="panel <?php echo  ($r['response_type']==0)?"panel-info":"panel-success"; ?>">
	<div class="panel-heading">
      <?php
        if($r['response_type']=='0'){
          $u_sql = "SELECT username name FROM admin WHERE adminid='".mysqli_real_escape_string($con,$r['responder_id'])."'";
          $u_q = mysqli_query($con,$u_sql);
          $u_r = mysqli_fetch_assoc($u_q);
          ?>Support - <?php echo  $u_r['name'];
        }elseif($r['response_type']=='1'){
          $u_sql = "SELECT name FROM dental_users WHERE userid='".mysqli_real_escape_string($con,$r['responder_id'])."'";
          $u_q = mysqli_query($con,$u_sql);
          $u_r = mysqli_fetch_assoc($u_q);
          echo $u_r['name'];
        }

      ?>
      <?php echo  date('m/d/Y h:i:s a', strtotime($r['adddate'])); ?>
    </div>
    <div class="panel-body">
    <?php
    echo $r['body'];
      if($r['attachment']){
        ?> | <a href="display_file.php?f=<?php echo  $r['attachment']; ?>" target="_blank">View Attachment</a><?php
      }
        $a_sql = "SELECT * FROM dental_support_attachment WHERE response_id ='".mysqli_real_escape_string($con,$r['id'])."'";
        $a_q = mysqli_query($con,$a_sql);
        while($a=mysqli_fetch_assoc($a_q)){
        ?> | <a href="display_file.php?f=<?php echo  $a['filename']; ?>" target="_blank">View Attachment</a><?php
        }
    if($r['response_type']==0){
      ?> | <a href="#" onclick="loadPopup('edit_support_response.php?ed=<?php echo  $_GET['ed']; ?>&id=<?php echo  $r['id']; ?>'); return false;">Edit</a><?php
    } ?>
    </div>  
    </div><?php
  }

?>
<div style="clear:both;"></div>
</div>
<div id="respond">
<h4 style="clear:both;">Respond</h4>
<form action="<?php echo  $_SERVER['PHP_SELF']; ?>?ed=<?php echo  $_REQUEST['ed']; ?>" method="post" enctype="multipart/form-data">
  <textarea id="body" name="body" style="width: 400px; height:100px;"></textarea><br />
  <input type="submit" name="respond" value="Submit Response"  style="float:left;" class="btn btn-primary">
  <a href="#" onclick="mark_unread(); return false;" class="pull-right btn btn-primary">Mark Unread</a>
  <div style=" width:300px;" class="clearfix">
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
	function mark_unread(){
	  var check = false;
	  if($('#body').val()!=''){
	    check = true;
	  }
	  $(".attachment").each( function(){
	    if($(this).val()!=''){
	      check = true; 
	    }
	  });
	  if(check){
	    if(!confirm("You have added items to this ticket but have not submitted your response. Click 'Cancel' to stay on the page and submit your response, or click 'OK' to leave without saving.")){
              return false;
            }
	  }
	  window.location = "manage_support_tickets.php?rid=<?php echo  $_REQUEST['ed']; ?>";
	}
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
<?php include "includes/bottom.htm";?>
