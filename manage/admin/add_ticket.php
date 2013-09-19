<?php 
session_start();
require_once('includes/main_include.php');
include("includes/sescheck.php");
include "../includes/general_functions.php";
include_once "includes/general.htm";
//include "includes/top.htm";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="css/admin.css" rel="stylesheet" type="text/css" />
  <script type="text/javascript" src="script/jquery-1.6.2.min.js"></script>
<script language="javascript" type="text/javascript" src="script/validation.js"></script>
<!--<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>-->
    <script type="text/javascript" src="../3rdParty/input_mask/jquery.maskedinput-1.3.min.js"></script>
    <script type="text/javascript" src="../js/masks.js"></script>
<script type="text/javascript" src="script/wufoo.js"></script>
</head>
<body>

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
				adddate=now(),ip_address='".$_SERVER['REMOTE_ADDR']."'";
		mysql_query($ins_sql) or die($ins_sql.mysql_error());
		$t_id = mysql_insert_id();

		if($_FILES['attachment']['tmp_name']!=''){
                  $extension = end(explode(".", $_FILES["attachment"]["name"]));
		  $attachment = "support_attachment_".$t_id."_".$_SESSION['docid'].".".$extension;
                  move_uploaded_file($_FILES["attachment"]["tmp_name"], "../q_file/" . $attachment);

		  $a_sql = "UPDATE dental_support_tickets SET
				attachment = '".mysql_real_escape_string($attachment)."'
				where id=".mysql_real_escape_string($t_id);
		  mysql_query($a_sql);
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
<br /><br />
    <?

		$title = $_POST['title'];
		$category_id = $_POST['category_id'];
		$body = $_POST['body'];
		$but_text = "Add ";
	
	 if($msg != '') {?>
    <div align="center" class="red">
        <? echo $msg;?>
    </div>
    <? }?>

    <form name="contactfrm" action="<?=$_SERVER['PHP_SELF'];?>" method="post" style="width:99%;" enctype="multipart/form-data" onsubmit="return adminticketabc(this)">
    <table width="99%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center" style="margin-left: 11px;">
        <tr>
            <td colspan="2" class="cat_head">
		Add Support Ticket
            </td>
        </tr>
        <tr>
                <td valign="top" class="frmhead">Account</td>
		<td valign="top" class="frmdata">
                                <select id="docid" name="docid" class="field text addr tbox" >
                                <option value="">Select an account</option>
                                    <? 
					$c_sql = "SELECT * FROM dental_users WHERE status=1 AND docid=0 ORDER BY last_name ASC, first_name ASC;";
					$c_q = mysql_query($c_sql);
					while($c_r = mysql_fetch_array($c_q)){
                  ?>

                  <option value="<?=st($c_r['userid']);?>">

                                                <?=st($c_r['first_name']);?> <?=$c_r['last_name']; ?>
                                        </option>
                                    <? }?>
                                </select>
            </td>
        </tr>
        <tr>
                <td valign="top" class="frmhead">User</td>
                <td valign="top" class="frmdata">		
                                <select id="userid" name="userid" class="field text addr tbox">
                                <option value="">Select an account </option>
                                </select>
            </td>
        </tr>
        <tr>
                <td valign="top" class="frmhead">Category</td>
                <td valign="top" class="frmdata">
                                <select id="category_id" name="category_id" class="field text addr tbox">
                                <option value="">Select a category</option>
                                    <?
                                        $c_sql = "SELECT * FROM dental_support_categories WHERE status=0 ORDER BY title ASC;";
                                        $c_q = mysql_query($c_sql);
                                        while($c_r = mysql_fetch_array($c_q)){
                  ?>

                  <option <?php if($category_id == $c_r['id']){ echo " selected='selected'";} ?> value="<?=st($c_r['id']);?>">

                                                <?=st($c_r['title']);?>
                                        </option>
                                    <? }?>
                                </select>
            </td>
        </tr>
        <tr class="content">
        	<td valign="top" class="frmhead">Title</td>
                <td valign="top" class="frmdata">
                                <input id="title" name="title" type="text" class="field text addr tbox" value="<?=$title?>" tabindex="2" maxlength="255" />
            </td>
        </tr>
         <tr> 
        	<td valign="top" class="frmhead">Message</td>
                <td valign="top" class="frmdata">
                            	<textarea name="body" id="body" class="field text addr tbox" tabindex="21" style="width:100%; height:150px;"><?=$body?></textarea>
            </td>
        </tr>
                <tr>
                <td valign="top" class="frmhead">Attachment</td>
                <td valign="top" class="frmdata">
                                <input type="file" name="attachment" id="attachment" class="field text addr tbox" />
            </td>
        </tr> 
        <tr class="content physician insurance other">
            <td  colspan="2" align="center">
                <span class="red">
                    * Required Fields					
                </span><br />
                <input type="hidden" name="ticketsub" value="1" />
                <input type="submit" value=" <?=$but_text?> Ticket" class="button" />
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
</script>

      </div>

</body>
</html>
