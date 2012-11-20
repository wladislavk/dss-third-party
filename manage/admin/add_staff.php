<?php 
session_start();
require_once('includes/config.php');
include("includes/sescheck.php");
include("includes/password.php");
include("../includes/general_functions.php");
if($_POST["staffsub"] == 1)
{
	$sel_check = "select * from dental_users where username = '".s_for($_POST["username"])."' and userid <> '".s_for($_POST['ed'])."'";
	$query_check=mysql_query($sel_check);
        $sel_check2 = "select * from dental_users where email = '".s_for($_POST["email"])."' and userid <> '".s_for($_POST['ed'])."'";
        $query_check2=mysql_query($sel_check2);

        if(mysql_num_rows($query_check)>0)
        {
                $msg="Username already exist. So please give another Username.";
                ?>
                <script type="text/javascript">
                        alert("<?=$msg;?>");
                        window.location="#add";
                </script>
                <?
        }
        elseif(mysql_num_rows($query_check2)>0)
        {
                $msg="Email already exist. So please give another Email.";
                ?>
                <script type="text/javascript">
                        alert("<?=$msg;?>");
                        window.location="#add";
                </script>
                <?
        }
	else
	{
		if($_POST["ed"] != "")
		{
                        $p = ($_POST['producer']==1)?1:0;
			$n = ($_POST['sign_notes']==1)?1:0;
			$ed_sql = "update dental_users set user_access=1, docid='".$_GET['docid']."', name = '".s_for($_POST["name"])."', email = '".s_for($_POST["email"])."', address = '".s_for($_POST["address"])."', phone = '".s_for(num($_POST["phone"]))."', status = '".s_for($_POST["status"])."', producer=".$p.", sign_notes=".$n." where userid='".$_POST["ed"]."'";
			mysql_query($ed_sql) or die($ed_sql." | ".mysql_error());
			
			//echo $ed_sql.mysql_error();
			$msg = "Edited Successfully";
			?>
			<script type="text/javascript">
				//alert("<?=$msg;?>");
				parent.window.location='manage_staff.php?msg=<?=$msg;?>&docid=<?=$_GET['docid'];?>';
			</script>
			<?
			die();
		}
		else
		{
			$salt = create_salt();
                        $password = gen_password($_POST['password'], $salt);

                        $p = ($_POST['producer']==1)?1:0;
			$p = ($_POST['sign_notes']==1)?1:0;
			$ins_sql = "insert into dental_users set user_access=1, docid='".$_GET['docid']."', username = '".s_for($_POST["username"])."', password = '".mysql_real_escape_string($password)."', salt='".$salt."', name = '".s_for($_POST["name"])."', email = '".s_for($_POST["email"])."', address = '".s_for($_POST["address"])."', phone = '".s_for(num($_POST["phone"]))."', status = '".s_for($_POST["status"])."',adddate=now(),ip_address='".$_SERVER['REMOTE_ADDR']."', producer=".$p.", sign_notes=".$n;
			mysql_query($ins_sql) or die($ins_sql.mysql_error());
			
			$msg = "Added Successfully";
			?>
			<script type="text/javascript">
				//alert("<?=$msg;?>");
				parent.window.location='manage_staff.php?msg=<?=$msg;?>&docid=<?=$_GET['docid'];?>';
			</script>
			<?
			die();
		}
	}
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="css/admin.css" rel="stylesheet" type="text/css" />
<script language="javascript" type="text/javascript" src="script/validation.js"></script>
</head>
<body>

    <?
    $thesql = "select * from dental_users where userid='".$_REQUEST["ed"]."'";
	$themy = mysql_query($thesql);
	$themyarray = mysql_fetch_array($themy);
	
	if($msg != '')
	{
		$username = $_POST['username'];
		$password = $_POST['password'];
		$name = $_POST['name'];
		$email = $_POST['email'];
		$address = $_POST['address'];
		$phone = $_POST['phone'];
		$status = $_POST['status'];
                $producer = $_POST['producer'];
		$sign_notes = $_POST['sign_notes'];
	}
	else
	{
		$username = st($themyarray['username']);
		$password = st($themyarray['password']);
		$name = st($themyarray['name']);
		$email = st($themyarray['email']);
		$address = st($themyarray['address']);
		$phone = st($themyarray['phone']);
		$status = st($themyarray['status']);
                $producer = st($themyarray['producer']);
		$sign_notes = st($themyarray['sign_notes']);
		$but_text = "Add ";
	}
	
	if($themyarray["userid"] != '')
	{
		$but_text = "Edit ";
	}
	else
	{
		$but_text = "Add ";
	}
	?>
	
	<br /><br />
	
	<? if($msg != '') {?>
    <div align="center" class="red">
        <? echo $msg;?>
    </div>
    <? }?>
    <form name="stafffrm" action="<?=$_SERVER['PHP_SELF'];?>?add=1&docid=<?=$_GET['docid'];?>" method="post" onSubmit="return staffabc(this)">
    <table width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center">
        <tr>
            <td colspan="2" class="cat_head">
               <?=$but_text?> Staff 
               <? if($username <> "") {?>
               		&quot;<?=$username;?>&quot;
               <? }?>
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Username
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="username" value="<?=$username?>" class="tbox" /> 
                <span class="red">*</span>				
            </td>
        </tr>
        <?php if($themyarray["userid"] == ''){ ?> 
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                Passsword
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="password" value="<?=$password;?>" class="tbox" /> 
                <span class="red">*</span>				
            </td>
        </tr>
	<?php } ?>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                Name
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="name" value="<?=$name;?>" class="tbox" /> 
                <span class="red">*</span>				
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                Email
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="email" value="<?=$email;?>" class="tbox" /> 
                <span class="red">*</span>
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                Address
            </td>
            <td valign="top" class="frmdata">
                <textarea name="address" class="tbox"><?=$address;?></textarea>
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                Phone
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="phone" value="<?=$phone;?>" class="tbox" /> 
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                Status
            </td>
            <td valign="top" class="frmdata">
            	<select name="status" class="tbox">
                	<option value="1" <? if($status == 1) echo " selected";?>>Active</option>
                	<option value="2" <? if($status == 2) echo " selected";?>>In-Active</option>
                </select>
            </td>
        </tr>
        <tr>
<td valign="top" class="frmhead">
                Producer 
            </td>
            <td valign="top" class="frmdata">
                <input type="checkbox" <?= ($producer==1)?'checked="checked':''; ?> value="1" name="producer" /> 
            </td>
        </tr>
<td valign="top" class="frmhead">
                Sign Progress Notes? 
            </td>
            <td valign="top" class="frmdata">
                <input type="checkbox" <?= ($sign_notes==1)?'checked="checked':''; ?> value="1" name="sign_notes" />
            </td>
        </tr>

        <tr>
            <td  colspan="2" align="center">
                <span class="red">
                    * Required Fields					
                </span><br />
                <input type="hidden" name="staffsub" value="1" />
                <input type="hidden" name="ed" value="<?=$themyarray["userid"]?>" />
                <input type="submit" value=" <?=$but_text?> Staff" class="button" />
		<?php if($themyarray["userid"] != ''){ ?>
                    <a style="float:right;" href="javascript:parent.window.location='manage_staff.php?delid=<?=$themyarray["userid"];?>&docid=<?=$_GET['docid'];?>'" onclick="javascript: return confirm('Do Your Really want to Delete?.');" class="dellink" title="DELETE">
                                                Delete
                                        </a>
		<?php } ?>
            </td>
        </tr>
    </table>
    </form>
</body>
</html>
