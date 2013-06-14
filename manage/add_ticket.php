<?php 
session_start();
require_once('admin/includes/config.php');
include("includes/sescheck.php");
include "includes/general_functions.php";
include_once "admin/includes/general.htm";
//include "includes/top.htm";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="css/admin.css" rel="stylesheet" type="text/css" />
<script language="javascript" type="text/javascript" src="script/validation.js"></script>
<!--<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>-->
  <script type="text/javascript" src="admin/script/jquery-1.6.2.min.js"></script>
    <script type="text/javascript" src="3rdParty/input_mask/jquery.maskedinput-1.3.min.js"></script>
    <script type="text/javascript" src="js/masks.js"></script>
<link rel="stylesheet" href="css/form.css" type="text/css" />
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
				userid = '".mysql_real_escape_string($_SESSION['userid'])."',
				docid = '".mysql_real_escape_string($_SESSION['docid'])."',
				adddate=now(),ip_address='".$_SERVER['REMOTE_ADDR']."'";
		mysql_query($ins_sql) or die($ins_sql.mysql_error());
		$t_id = mysql_insert_id();

		if($_FILES['attachment']){
                  $extension = end(explode(".", $_FILES["attachment"]["name"]));
		  $attachment = "support_attachment_".$t_id."_".$_SESSION['docid'].".".$extension;
                  move_uploaded_file($_FILES["attachment"]["tmp_name"], "q_file/" . $attachment);

		  $a_sql = "UPDATE dental_support_tickets SET
				attachment = '".mysql_real_escape_string($attachment)."'
				where id=".mysql_real_escape_string($t_id);
		  mysql_query($a_sql);
		}
		$u_sql = "SELECT a.* FROM admin a 
				JOIN dental_support_category_admin ca ON ca.adminid=a.adminid
				WHERE ca.category_id = '".mysql_real_escape_string($_POST['category_id'])."'";
		$u_q = mysql_query($u_sql);
		$admins = array();
		while($u_r = mysql_fetch_assoc($u_q)){
                  array_push($admins, $u_r['email']);
		}

		$info_sql = "SELECT u.* FROM dental_users u WHERE userid='".mysql_real_escape_string($_SESSION['userid'])."'";
		$info_q = mysql_query($info_sql);
		$info_r = mysql_fetch_assoc($info_q);


		$html = "Support ticket has been opened by ".$info_r['name'].".";

		$headers = 'From: Dental Sleep Solutions <support@dentalsleepsolutions.com>' . "\r\n" .
                    'Content-type: text/html' ."\r\n" .
                    'Reply-To: support@dentalsleepsolutions.com' . "\r\n" .
                     'X-Mailer: PHP/' . phpversion();

                $subject = "Support Ticket Opened";
		$e = implode(',', $admins);
                mail($e, $subject, $m, $headers);

		?>
		<script type="text/javascript">
			//alert("<?=$msg;?>");
			alert('Thank you for your submission! We will respond promptly to you inquiry.');
			parent.window.location='support.php?msg=<?=$msg;?>';
		</script>
		<?
		
		die();
	
}

?>
<?php /*
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="css/admin.css" rel="stylesheet" type="text/css" />
<script language="javascript" type="text/javascript" src="script/validation.js"></script>

<link rel="stylesheet" href="css/form.css" type="text/css" />
<script type="text/javascript" src="script/wufoo.js"></script>
</head>
<body width="98%"> */ ?>
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

    <form name="contactfrm" action="<?=$_SERVER['PHP_SELF'];?>" method="post" style="width:99%;" enctype="multipart/form-data">
    <table width="99%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center" style="margin-left: 11px;">
        <tr>
            <td colspan="2" class="cat_head">
		Add Support Ticket
            </td>
        </tr>
        <tr>
                <td valign="top" colspan="2" class="frmhead">
                <ul>
                        <li id="foli8" class="complex">
                        <div>
                            <span>
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

                                <label for="contacttype">Category</label>
                            </span>
                        </div>
                    </li>
                                </ul>
            </td>
        </tr>
        <tr class="content">
        	<td valign="top" colspan="2" class="frmhead">
				<ul>        
                    <li id="foli8" class="complex">	
                        <div>
                        	<span>
                                <input id="title" name="title" type="text" class="field text addr tbox" value="<?=$title?>" tabindex="2" maxlength="255" />
                                <label for="firstname">Title</label>
                            </span>
                       </div>   
                    </li>
                </ul>
            </td>
        </tr>
         <tr class="content physician insurance other"> 
        	<td valign="top" colspan="2" class="frmhead">
            	<ul>
            		<li id="foli8" class="complex">	
                    	 <label class="desc" id="title0" for="Field0">
                            Message:
                        </label>
                        <div>
                            <span class="full">
                            	<textarea name="body" id="body" class="field text addr tbox" tabindex="21" style="width:600px; height:150px;"><?=$body?></textarea>
                            </span>
                        </div>
                    </li>
				</ul>
            </td>
        </tr>
                <tr class="content physician insurance other">
                <td valign="top" colspan="2" class="frmhead">
                <ul>
                        <li id="foli8" class="complex">
                         <label class="desc" id="title0" for="Field0">
                            Attachment:
                        </label>
                        <div>
                            <span class="full">
                                <input type="file" name="attachment" id="attachment" class="field text addr tbox" />
                            </span>
                        </div>
                    </li>
                                </ul>
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
  $('#google_link').click(function(){ 
	$('#google_link').attr('href', 'http://google.com/search?q='+$('#firstname').val()+'+'+$('#lastname').val()+'+'+$('#company').val()+'+'+$('#add1').val()+'+'+$('#city').val()+'+'+$('#state').val()+'+'+$('#zip').val());
  });
</script>

      </div>
<!--<div style="margin:0 auto;background:url(images/dss_05.png) no-repeat top left;width:980px; height:28px;"> </div>
  </td>
</tr>-->
<!-- Stick Footer Section Here -->
<!--</table>-->
<!--<div id="popupContact" style="width:750px;">
    <a id="popupContactClose"><button>X</button></a>
    <iframe id="aj_pop" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
</div>
<div id="backgroundPopup"></div>
-->
<script type="text/javascript">
var cal1 = new calendar2(document.getElementById('ins_dob'));
</script>
<script type="text/javascript">
var cal2 = new calendar2(document.getElementById('ins2_dob'));
</script>
<script type="text/javascript">
var cal3 = new calendar2(document.getElementById('dob'));
</script>
<script type="text/javascript" src="script/contact.js"></script>

</body>
</html>
