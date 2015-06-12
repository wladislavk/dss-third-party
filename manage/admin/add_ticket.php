<?php namespace Ds3\Libraries\Legacy; ?><?php 

include_once 'includes/main_include.php';
include_once 'includes/sescheck.php';
include_once '../includes/general_functions.php';
include_once 'includes/general.htm';
//include "includes/top.htm";
?>

<?php require_once dirname(__FILE__) . '/includes/popup_top.htm'; ?>

<script type="text/javascript" src="/manage/js/preferred_contact.js"></script>
<?php
if(!empty($_POST["ticketsub"]) && $_POST["ticketsub"] == 1)
{
    $c_sql = "SELECT companyid FROM admin_company where adminid='".$_SESSION['adminuserid']."'";
    $c_q = mysqli_query($con,$c_sql);
    $c = mysqli_fetch_assoc($c_q);
		$ins_sql = "insert into dental_support_tickets set 
				title = '".mysqli_real_escape_string($con,$_POST['title'])."',
				category_id = '".mysqli_real_escape_string($con,$_POST['category_id'])."',
				body = '".mysqli_real_escape_string($con,$_POST['body'])."',
				userid = '".mysqli_real_escape_string($con,$_POST['userid'])."',
				docid = '".mysqli_real_escape_string($con,$_POST['docid'])."',
				create_type = '0',
                company_id = '".$c['companyid']."',
				creator_id = '".mysqli_real_escape_string($con,$_SESSION['adminuserid'])."',
				adddate=now(),ip_address='".$_SERVER['REMOTE_ADDR']."'";
		mysqli_query($con,$ins_sql);
		$t_id = mysqli_insert_id($con);


                for($i=0;$i < count(!empty($_FILES['attachment']) ? $_FILES['attachment']['name'] : null); $i++){
                if($_FILES['attachment']['tmp_name'][$i]!=''){
                  $extension = preg_replace('/^.*[.]([^.]+)$/', '$1', ($_FILES['attachment']["name"][$i]));
                  $attachment = "support_attachment_".$t_id."_".$_SESSION['docid']."_".rand(1000, 9999).".".$extension;
                  move_uploaded_file($_FILES['attachment']["tmp_name"][$i], "../../../../shared/q_file/" . $attachment);

                  $a_sql = "INSERT INTO dental_support_attachment SET
                                filename = '".mysqli_real_escape_string($con,$attachment)."',
                                ticket_id=".mysqli_real_escape_string($con,$t_id);
                  mysqli_query($con,$a_sql);
                }
                }


		$info_sql = "SELECT u.* FROM dental_users u WHERE userid='".mysqli_real_escape_string($con,(!empty($_SESSION['userid']) ? $_SESSION['userid'] : ''))."'";
		$info_q = mysqli_query($con,$info_sql);
		$info_r = mysqli_fetch_assoc($info_q);
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
			//alert("<?php echo $msg;?>");
			alert('Thank you for your submission! We will respond promptly to you inquiry.');
			parent.window.location='manage_support_tickets.php?msg=<?php echo $msg;?>';
		</script>
		<?
		
		trigger_error("Die called", E_USER_ERROR);
	
}

?>
    <div class="col-md-6 col-md-offset-3">
        <?php if (isset($_GET['msg'])) { ?>
        <div class="alert alert-danger text-center">
            <strong><?php echo  $_GET['msg'] ?></strong>
        </div>
        <?php } ?>
        
        <?php if (!empty($msg)) { ?>
        <div class="alert alert-success text-center">
            <?php echo  $msg ?>
        </div>
        <?php } ?>
        
        <div class="page-header">
            <h1>
                Add Support Ticket
            </h1>
        </div>
        <form name="contactfrm" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post" style="width:99%;" enctype="multipart/form-data" onsubmit="return adminticketabc(this)" class="form-horizontal">
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
                        $c_q = mysqli_query($con,$c_sql);
                        
                        while ($c_r = mysqli_fetch_array($c_q)) { ?>
                        <option value="<?php echo  st($c_r['userid']) ?>"><?php echo  st("$c_r[first_name] $c_r[last_name]") ?></option>
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
                        $c_q = mysqli_query($con,$c_sql);
                        
                        while ($c_r = mysqli_fetch_array($c_q)) { ?>
                        <option <?php if(!empty($category_id) && $category_id == $c_r['id']){ echo " selected='selected'";} ?> value="<?php echo st($c_r['id']);?>"><?php echo st($c_r['title']);?></option>
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
                    <input type="text" name="title" id="title" class="form-control" placeholder="Title of the ticket" value="<?php echo  (!empty($title) ? $title : ''); ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="body" class="col-md-3 control-label">Message</label>
                <div class="col-md-9">
                    <textarea name="body" id="body" class="form-control" placeholder="Description of the ticket"><?php echo  (!empty($body) ? $body : ''); ?></textarea>
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
