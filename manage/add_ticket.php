<?php namespace Ds3\Legacy; ?><?php 
include_once('admin/includes/main_include.php');
include("includes/sescheck.php");
//include "includes/general_functions.php";
include_once "admin/includes/general.htm";
include_once 'includes/constants.inc';
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
if(!empty($_POST["ticketsub"]) && $_POST["ticketsub"] == 1){
	$ins_sql = "insert into dental_support_tickets set 
                    title = '".mysqli_real_escape_string($con, $_POST['title'])."',
                    category_id = '".mysqli_real_escape_string($con, $_POST['category_id'])."',
                    company_id = '".mysqli_real_escape_string($con, $_POST['company_id'])."',
                    body = '".mysqli_real_escape_string($con, $_POST['body'])."',
                    userid = '".mysqli_real_escape_string($con, $_SESSION['userid'])."',
                    docid = '".mysqli_real_escape_string($con, $_SESSION['docid'])."',
                    create_type = '1',
                    creator_id = '".mysqli_real_escape_string($con, $_SESSION['userid'])."',
                    adddate=now(),ip_address='".$_SERVER['REMOTE_ADDR']."'";

	$t_id = $db->getInsertId($ins_sql);

	for($i=0;$i < count($_FILES['attachment']['name']); $i++){
    	if($_FILES['attachment']['tmp_name'][$i]!='' && $_FILES['attachment']['size'][$i] <= DSS_IMAGE_MAX_SIZE){
            $extension = end(explode(".", $_FILES['attachment']["name"][$i]));
            $attachment = "support_attachment_".$t_id."_".$_SESSION['docid']."_".rand(1000, 9999).".".$extension;
            move_uploaded_file($_FILES['attachment']["tmp_name"][$i], "../../../shared/q_file/" . $attachment);
	
            $a_sql = "INSERT INTO dental_support_attachment SET
                        filename = '".mysqli_real_escape_string($con, $attachment)."',
                        ticket_id=".mysqli_real_escape_string($con, $t_id);
            $db->query($a_sql);
        }
	}

	$u_sql = "SELECT a.* FROM admin a 
                JOIN dental_support_category_admin ca ON ca.adminid=a.adminid
                WHERE ca.category_id = '".mysqli_real_escape_string($con, $_POST['category_id'])."'";
	$u_q = $db->getResults($u_sql);
	$admins = array();
    if ($u_q) {
        foreach ($u_q as $u_r) {
            array_push($admins, $u_r['email']);
        }
    }

	$info_sql = "SELECT u.* FROM dental_users u WHERE userid='".mysqli_real_escape_string($con, $_SESSION['userid'])."'";
	$info_r = $db->getRow($info_sql);

	$html = "Support ticket has been opened by ".$info_r['name'].".";

	$headers = 'From: Dental Sleep Solutions <support@dentalsleepsolutions.com>' . "\r\n" .
                'Content-type: text/html' ."\r\n" .
                'Reply-To: support@dentalsleepsolutions.com' . "\r\n" .
                 'X-Mailer: PHP/' . phpversion();

    $subject = "Support Ticket Opened";
    $e = implode(',', $admins);
    mail($e, $subject, $m, $headers);?>
<script type="text/javascript">
	//alert("<?php echo $msg;?>");
	alert('Thank you for your submission! We will respond promptly to you inquiry.');
	parent.window.location='support.php?msg=<?php echo $msg;?>';
</script>
<?php
	die();
}
/*
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
<?php

$title = (!empty($_POST['title']) ? $_POST['title'] : '');
$category_id = (!empty($_POST['category_id']) ? $_POST['category_id'] : '');
$company_id = (!empty($_POST['company_id']) ? $_POST['company_id'] : '');
$body = (!empty($_POST['body']) ? $_POST['body'] : '');
$but_text = "Add ";
	
if(!empty($msg)) {?>
<div align="center" class="red">
<?php echo $msg;?>
</div>
<?php 
}?>

<form name="contactfrm" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post" style="width:99%;" enctype="multipart/form-data" onsubmit="return ticketabc(this)">
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
<?php 
    $c_sql = "SELECT * FROM dental_support_categories WHERE status=0 ORDER BY title ASC;";
    $c_q = $db->getResults($c_sql);
    foreach ($c_q as $c_r) {?>
                                    <option <?php if($category_id == $c_r['id']){ echo " selected='selected'";} ?> value="<?php echo st($c_r['id']);?>">
                                        <?php echo st($c_r['title']);?>
                                    </option>
<?php 
}?>
                                </select>
                                <label for="contacttype">Category</label>
                            </span>
                        </div>
                    </li>
                </ul>
            </td>
        </tr>
        <tr>
            <td valign="top" colspan="2" class="frmhead">
                <ul>
                    <li id="foli8" class="complex">
                        <div>
                            <span>
                            <select id="company_id" name="company_id" class="field text addr tbox">
                                <option value="0">Dental Sleep Solutions</option>
<?php
$c_sql = "SELECT c.* FROM companies c
            JOIN dental_users u ON u.billing_company_id=c.id
            WHERE c.use_support=1 
            AND u.userid='".mysqli_real_escape_string($con, $_SESSION['docid'])."'
            ORDER BY c.name ASC;";
$c_q = $db->getResults($c_sql);
if ($c_q) 
foreach ($c_q as $c_r) {?>
                                <option <?php if($company_id == $c_r['id']){ echo " selected='selected'";} ?> value="<?php echo st($c_r['id']);?>">
                                    <?php echo st($c_r['name']);?>
                                </option>
<?php 
}?>
                            </select>
                            <label for="contacttype">Send To</label>
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
                                <input id="title" name="title" type="text" class="field text addr tbox" value="<?php echo $title?>" tabindex="2" maxlength="255" />
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
                                <textarea name="body" id="body" class="field text addr tbox" tabindex="21" style="width:600px; height:150px;"><?php echo $body?></textarea>
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
                                <div id="attachments">
                                    <span class="fullwidth"><input type="file" name="attachment[]" id="attachment1" class="attachment field text addr tbox" onchange="$('#add_attachment_but').show();" style="width:auto;" /> <a href="#" onclick="$(this).parent().remove();$('#add_attachment_but').show();return false;">Remove</a></span>
                                </div>
                                <a href="#" id="add_attachment_but" onclick="add_attachment();return false;" style="display:none;" class="button">Add Additional</a>
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
                <input type="submit" value=" <?php echo $but_text?> Ticket" class="button" />
            </td>
        </tr>
    </table>
</form>

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
<script type="text/javascript" src="script/contact.js"></script>
<script type="text/javascript" src="js/add_ticket.js"></script>

</body>
</html>
