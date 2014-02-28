<?php 
session_start();
require_once 'includes/main_include.php';
include_once 'includes/sescheck.php';
include_once '../includes/general_functions.php';
include_once 'includes/general.htm';
//include "includes/top.htm";
?>

<?php require_once dirname(__FILE__) . '/includes/popup_top.htm'; ?>

<script type="text/javascript" src="/manage/js/preferred_contact.js"></script>
<?php
if($_POST["ticketsub"] == 1)
{



		$ins_sql = "insert into dental_support_tickets set 
				title = '".mysql_real_escape_string($_POST['title'])."',
				category_id = '".mysql_real_escape_string($_POST['category_id'])."',
				body = '".mysql_real_escape_string($_POST['body'])."',
				userid = '".mysql_real_escape_string($_POST['userid'])."',
				docid = '".mysql_real_escape_string($_POST['docid'])."',
				create_type = '0',
				creator_id = '".mysql_real_escape_string($_SESSION['adminuserid'])."',
				adddate=now(),ip_address='".$_SERVER['REMOTE_ADDR']."'";
		mysql_query($ins_sql) or die($ins_sql.mysql_error());
		$t_id = mysql_insert_id();


                for($i=0;$i < count($_FILES['attachment']['name']); $i++){
                if($_FILES['attachment']['tmp_name'][$i]!=''){
                  $extension = end(explode(".", $_FILES['attachment']["name"][$i]));
                  $attachment = "support_attachment_".$t_id."_".$_SESSION['docid']."_".rand(1000, 9999).".".$extension;
                  move_uploaded_file($_FILES['attachment']["tmp_name"][$i], "../q_file/" . $attachment);

                  $a_sql = "INSERT INTO dental_support_attachment SET
                                filename = '".mysql_real_escape_string($attachment)."',
                                ticket_id=".mysql_real_escape_string($t_id);
                  mysql_query($a_sql);
                }
                }


		$info_sql = "SELECT u.* FROM dental_users u WHERE userid='".mysql_real_escape_string($_SESSION['userid'])."'";
		$info_q = mysql_query($info_sql);
		$info_r = mysql_fetch_assoc($info_q);
		$e = $info_r['email'];

		$m = "Support ticket has been opened. Please go to http://dentalsleepsolutions.com/manage to view.";

		$headers = 'From: Dental Sleep Solutions <support@dentalsleepsolutions.com>' . "\r\n" .
                    'Content-type: text/html' ."\r\n" .
                    'Reply-To: support@dentalsleepsolutions.com' . "\r\n" .
                     'X-Mailer: PHP/' . phpversion();

                $subject = "Support Ticket Opened";
                mail($e, $subject, $m, $headers);

		?>
		<script type="text/javascript">
			//alert("<?=$msg;?>");
			alert('Thank you for your submission! We will respond promptly to you inquiry.');
			parent.window.location='manage_support_tickets.php?msg=<?=$msg;?>';
		</script>
		<?
		
		die();
	
}

?>
    <div class="col-md-6 col-md-offset-3">
        <?php if (isset($_GET['msg'])) { ?>
        <div class="alert alert-danger text-center">
            <strong><?= $_GET['msg'] ?></strong>
        </div>
        <?php } ?>
        
        <?php if ($msg != '') { ?>
        <div class="alert alert-success text-center">
            <?= $msg ?>
        </div>
        <?php } ?>
        
        <div class="page-header">
            <h1>
                Add Support Ticket
            </h1>
        </div>
        <form name="contactfrm" action="<?=$_SERVER['PHP_SELF'];?>" method="post" style="width:99%;" enctype="multipart/form-data" onsubmit="return adminticketabc(this)" class="form-horizontal">
            <div class="page-header">
                <strong>Account details</strong>
            </div>
            <div class="form-group">
                <label for="docid" class="col-md-3 control-label">Account</label>
                <div class="col-md-9">
                    <select name="docid" id="docid" class="form-control">
                        <option value="">Select an account</option>
                        <?php
                        
                        $c_sql = "SELECT * FROM dental_users WHERE status=1 AND docid=0 ORDER BY last_name ASC, first_name ASC;";
                        $c_q = mysql_query($c_sql);
                        
                        while ($c_r = mysql_fetch_array($c_q)) { ?>
                        <option value="<?= st($c_r['userid']) ?>"><?= st("$c_r[first_name] $c_r[last_name]") ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="userid" class="col-md-3 control-label">User</label>
                <div class="col-md-9">
                    <select name="userid" id="userid" class="form-control">
                        <option value="">Select an account</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="category_id" class="col-md-3 control-label">Category</label>
                <div class="col-md-9">
                    <select name="category_id" id="category_id" class="form-control">
                        <option value="">Select a category</option>
                        <?php
                        
                        $c_sql = "SELECT * FROM dental_support_categories WHERE status=0 ORDER BY title ASC;";
                        $c_q = mysql_query($c_sql);
                        
                        while ($c_r = mysql_fetch_array($c_q)) { ?>
                        <option <?php if($category_id == $c_r['id']){ echo " selected='selected'";} ?> value="<?=st($c_r['id']);?>"><?=st($c_r['title']);?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            
            <div class="page-header">
                <strong>Ticket details</strong>
            </div>
            <div class="form-group">
                <label for="title" class="col-md-3 control-label">Title</label>
                <div class="col-md-9">
                    <input type="text" name="title" id="title" class="form-control" placeholder="Title of the ticket" value="<?= $title ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="body" class="col-md-3 control-label">Message</label>
                <div class="col-md-9">
                    <textarea name="body" id="body" class="form-control" placeholder="Description of the ticket"><?= $body ?></textarea>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-3 control-label">Attachments</label>
                <div class="col-md-9">
                    <ul class="list-group" id="attachments">
                        <li class="list-group-item">
                            <input type="file" name="attachment[]" id="attachment1" class="attachment btn btn-default col-md-10" onclick="$('#add_attachment_but').show();">
                            <a href="#" onclick="$(this).parent().remove();$('#add_attachment_but').show();return false;" class="btn btn-danger">
                                <span class="glyphicon glyphicon-remove"></span>
                            </a>
                        </li>
                    </ul>
                    <a href="#" id="add_attachment_but" onclick="add_attachment();return false;" style="display:none;" class="btn btn-success">
                        Add
                        <span class="glyphicon glyphicon-plus"></span>
                    </a>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-9 col-md-offset-3">
                    <input type="hidden" name="ticketsub" value="1">
                    <input type="submit" value="Add Ticket" class="btn btn-primary">
                </div>
            </div>
        </form>
    </div>
    <script type="text/javascript">
    $('#docid').change(function(){ 
        v = $(this).val();
        
        $.ajax({
            url: '/manage/admin/includes/account_users.php',
            data: {account:v},
            success: function(data){
                var r = $.parseJSON(data);
                
                if (r.options) {
                    $('#userid').html(r.options);      
                }
            }
        });
    });
    
    var template = $('#attachments').html();
    
    function add_attachment(){
        var blank = $(".attachment").filter(function(){
            return !this.value;
        }).length;
        
        if (blank > 0) {
            alert('Please attach another file with the "Browse" button before adding another.');
            return false;
        }

        if ($('.attachment').length < 5) {
            $('#attachments').append(template);
        }
        
        if ($('.attachment').length >= 5) {
            $('#add_attachment_but').hide();
        }
    }
    </script>
</body>
</html>
