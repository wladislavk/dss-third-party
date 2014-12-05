<?php 
session_start();
require_once('includes/main_include.php');
include("includes/sescheck.php");
//include "../includes/general_functions.php";
include_once "includes/general.htm";
//include "includes/top.htm";
?>
<?php require_once dirname(__FILE__) . '/includes/popup_top.htm'; ?>

<script type="text/javascript" src="/manage/js/preferred_contact.js"></script>
<?php
if(!empty($_POST["notesub"]) && $_POST["notesub"] == 1)
{
  if($_POST['nid']==''){



		$ins_sql = "insert into dental_claim_notes set 
				claim_id = '".mysql_real_escape_string($_POST['claim_id'])."',
				note = '".mysql_real_escape_string($_POST['note'])."',
				create_type = '0',
				creator_id = '".mysql_real_escape_string($_SESSION['adminuserid'])."',
				adddate=now(),ip_address='".$_SERVER['REMOTE_ADDR']."'";
		mysqli_query($con,$ins_sql) or die($ins_sql.mysql_error());
		$n_id = mysql_insert_id();

                for($i=0;$i < count($_FILES['attachment']['name']); $i++){
                if($_FILES['attachment']['tmp_name'][$i]!=''){
                  $extension = end(explode(".", $_FILES['attachment']["name"][$i]));
                  $attachment = "claim_note_attachment_".$n_id."_".$_SESSION['adminuserid']."_".rand(1000, 9999).".".$extension;
                  move_uploaded_file($_FILES['attachment']["tmp_name"][$i], "../../../../shared/q_file/" . $attachment);

                  $a_sql = "INSERT INTO dental_claim_note_attachment SET
                                filename = '".mysql_real_escape_string($attachment)."',
                                note_id=".mysql_real_escape_string($n_id);
                  mysqli_query($con,$a_sql);
                }
                }


		?>
		<script type="text/javascript">
			<?php if(isset($_POST['close']) && $_POST['close']==1){ ?>
			  parent.window.location='claim_payments_advanced.php?id=<?php echo  $_POST['claim_id'];?>&pid=<?php echo  $_POST['pid']; ?>&close=1';
			<?php }else{ ?>
			  parent.window.location='claim_notes.php?id=<?php echo  $_POST['claim_id'];?>&pid=<?php echo  $_POST['pid']; ?>&msg=<?php echo $msg;?>';
			<?php } ?>
		</script>
		<?
		
		die();
  }else{
                $up_sql = "update dental_claim_notes set 
                                note = '".mysql_real_escape_string($_POST['note'])."'
                                WHERE id='".mysql_real_escape_string($_POST['nid'])."'";
                mysqli_query($con,$up_sql) or die($up_sql.mysql_error());
		$n_id = $_POST['nid'];
                for($i=0;$i < count($_FILES['attachment']['name']); $i++){
                if($_FILES['attachment']['tmp_name'][$i]!=''){
                  $extension = end(explode(".", $_FILES['attachment']["name"][$i]));
                  $attachment = "claim_note_attachment_".$n_id."_".$_SESSION['adminuserid']."_".rand(1000, 9999).".".$extension;
                  move_uploaded_file($_FILES['attachment']["tmp_name"][$i], "../../../../shared/q_file/" . $attachment);

                  $a_sql = "INSERT INTO dental_claim_note_attachment SET
                                filename = '".mysql_real_escape_string($attachment)."',
                                note_id=".mysql_real_escape_string($n_id);
                  mysqli_query($con,$a_sql);
                }
                }

                ?>
                <script type="text/javascript">
			<?php if(isset($_POST['close']) && $_POST['close']==1){ ?>
			  parent.window.location='claim_payments_advanced.php?id=<?php echo  $_POST['claim_id'];?>&pid=<?php echo  $_POST['pid']; ?>&close=1';
			<?php }else{ ?>
                          parent.window.location='claim_notes.php?id=<?php echo  $_POST['claim_id'];?>&pid=<?php echo  $_POST['pid']; ?>&msg=<?php echo $msg;?>';
			<?php } ?>
                </script>
                <?

                die();
  }
}


$sql = "select * from dental_claim_text WHERE default_text=1 OR companyid = '".mysqli_real_escape_string($con, $_SESSION['admincompanyid'])."' order by Title";
$my = mysqli_query($con,$sql);

?>
<script type="text/javascript">
        function change_desc(fa)
        {
                if(fa != '')
                {
                        var title_arr = new Array();
                        var desc_arr = new Array();
                        
                        <? $i=0;
                        //$sql = "select * from dental_custom where docid='".$_SESSION['docid']."' order by Title";
                        //$my = mysqli_query($con,$sql);
                        while($myarray = mysql_fetch_array($my))
                        {?>
                                title_arr[<?php echo $i;?>] = "<?php echo st(addslashes($myarray['title']));?>";
                                desc_arr[<?php echo $i;?>] = "<?php echo st(trim( preg_replace( '/\n\r|\r\n/','%n%',addslashes($myarray['description']))));?>";
                        <?
                                $i++;                        }?>
                        document.getElementById("note").value = desc_arr[fa].replace(/\%n\%/g,'\r\n').replace(/&amp;/g,'&');;
                }
                else                {
                        document.getElementById("note").value = "";
                }
        }
        
</script>

    <?

        if(isset($_GET['nid'])){
                $s = "SELECT * FROM dental_claim_notes WHERE id='".$_GET['nid']."'";
                $q = mysqli_query($con,$s);
                $r = mysql_fetch_assoc($q);
                $note = $r['note'];
        }else{
                $note = '';
        }

		$but_text = "Add ";
	
	 if(!empty($msg)) {?>
    <div align="center" class="red">
        <? echo $msg;?>
    </div>
    <? }?>
        <div class="page-header">
            <h1>
                Add Claim Note 
            </h1>
        </div>

    <form name="contactfrm" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post" style="width:99%;" enctype="multipart/form-data" onsubmit="return adminclaimnoteabc(this)">

	<div class="form-group">
                <label for="docid" class="col-md-3 control-label">Text Templates</label>
                <div class="col-md-9">
            <select name="title" class="form-control" onChange="change_desc(this.value)">
                <option value="">Select</option>
                <?
                                $j=0;
                                $my = mysqli_query($con,$sql);
                                while($myarray = mysql_fetch_array($my))
                                { ?>
                                        <option value="<?php echo $j;?>">
                        <?php echo st($myarray['title']);?>
                    </option>
                                <?
                                        $j++;
                                }?>
            </select>
	   	</div>
	</div>
            <div class="form-group">
                <label for="body" class="col-md-3 control-label">Note</label>
                <div class="col-md-9">
                            	<textarea name="note" id="note" placeholder="Claim Text" class="form-control"><?php echo $note?></textarea>
		</div>
	</div>
            <div class="form-group">
                <label for="body" class="col-md-3 control-label">Make Payment/Close Claim</label>
                <div class="col-md-9">
			<input type="checkbox" onclick="$('#close_note').toggle(500);" name="close" value="1" />
                </div>
                <div id="close_note" class="col-md-9" style="display:none;">
			After submitting this note you will be prompted to enter the final claim details on the next page.	
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
                <input type="hidden" name="notesub" value="1" />
		<input type="hidden" name="claim_id" value="<?php echo  $_REQUEST['claim_id']; ?>" />
		<input type="hidden" name="pid" value="<?php echo  $_REQUEST['pid']; ?>" />
		<input type="hidden" name="nid" value="<?php echo  (!empty($_REQUEST['nid']) ? $_REQUEST['nid'] : ''); ?>" />
                <input type="submit" value=" <?php echo $but_text?> Note" class="btn btn-primary" />
            </td>
        </tr>
    </table>
    </form>

<script type="text/javascript">
  $('#docid').change(function(){ 
	v = $(this).val();
	$.ajax({
		url: 'includes/account_users.php',
		data: {account:v},
		success: function(data){
			var r = $.parseJSON(data);
                        if(r.options){
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

      </div>

</body>
</html>
