<?php 
session_start();
require_once('includes/config.php');
include("includes/sescheck.php");
include_once('includes/password.php');
if($_POST["adminsub"] == 1)
{
	$sel_check = "select * from admin where username = '".s_for($_POST["username"])."' and adminid <> '".s_for($_POST['ed'])."'";
	$query_check=mysql_query($sel_check);
        $sel_check2 = "select * from admin where email = '".s_for($_POST["email"])."' and adminid <> '".s_for($_POST['ed'])."'";
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
			$ed_sql = "update admin set 
				username = '".s_for($_POST["username"])."',
				admin_access='".s_for($_POST['admin_access'])."',
				name = '".s_for($_POST["name"])."', 
				email = '".s_for($_POST["email"])."' 
			where adminid='".$_POST["ed"]."'";
			mysql_query($ed_sql) or die($ed_sql." | ".mysql_error());
			
			//echo $ed_sql.mysql_error();
			$msg = "Edited Successfully";
			?>
			<script type="text/javascript">
				//alert("<?=$msg;?>");
				parent.window.location='manage_admin.php?msg=<?=$msg;?>';
			</script>
			<?
			die();
		}
		else
		{

			$salt = create_salt();
			$password = gen_password($_POST['password'], $salt);

			$ins_sql = "insert into admin SET
				username = '".s_for($_POST["username"])."',
				admin_access = '".s_for($_POST['admin_access'])."', 
				password = '".mysql_real_escape_string($password)."', 
				salt = '".$salt."',
				name = '".s_for($_POST["name"])."', 
				email = '".s_for($_POST["email"])."', 
				adddate=now(),
				ip_address='".$_SERVER['REMOTE_ADDR']."'";
			mysql_query($ins_sql) or die($ins_sql.mysql_error());

			$msg = "Added Successfully";
			?>
			<script type="text/javascript">
				//alert("<?=$msg;?>");
				parent.window.location='manage_admin.php?msg=<?=$msg;?>';
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
    $thesql = "select * from admin where adminid='".$_REQUEST["ed"]."'";
	$themy = mysql_query($thesql);
	$themyarray = mysql_fetch_array($themy);
	
	if($msg != '')
	{
		$username = $_POST['username'];
		$admin_access = $_POST['admin_access'];
		$password = $_POST['password'];
		$name = $_POST['name'];
		$email = $_POST['email'];
	}
	else
	{
		$username = st($themyarray['username']);
		$admin_access = st($themyarray['admin_access']);
		$password = st($themyarray['password']);
		$name = st($themyarray['name']);
		$email = st($themyarray['email']);
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
    <form name="userfrm" action="<?=$_SERVER['PHP_SELF'];?>?add=1" method="post" onSubmit="return userabc(this)">
    <table width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center">
        <tr>
            <td colspan="2" class="cat_head">
               <?=$but_text?> User 
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
                <input id="username" type="text" name="username" value="<?=$username?>" class="tbox" /> 
                <span class="red">*</span>				
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Access Level
            </td>
            <td valign="top" class="frmdata">
                <select id="admin_access" name="admin_access">
		  <option value="2" <?= ($admin_access==2)?'selected="selected"':''; ?>>2 - Basic User</option>
		  <option value="1" <?= ($admin_access==1)?'selected="selected"':''; ?>>1 - Super User</option>
		</select>
                <span class="red">*</span>
            </td>
        </tr>
	<?php if(!isset($_REQUEST['ed'])){ ?>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                Password
            </td>
            <td valign="top" class="frmdata">
                <input id="password" type="password" name="password" value="<?=$password;?>" class="tbox" />
                <span class="red">*</span>				
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                Re-type Password
            </td>
            <td valign="top" class="frmdata">
                <input id="password2" type="password" name="password2" value="<?=$password;?>" class="tbox" />
                <span class="red">*</span>
            </td>
        </tr>
	<?php } ?>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                Name
            </td>
            <td valign="top" class="frmdata">
                <input id="name" type="text" name="name" value="<?=$name;?>" class="tbox" /> 
                <span class="red">*</span>				
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                Email
            </td>
            <td valign="top" class="frmdata">
                <input id="email" type="text" name="email" value="<?=$email;?>" class="tbox" /> 
                <span class="red">*</span>				
            </td>
        </tr>
        <tr>
            <td  colspan="2" align="center">
                <span class="red">
                    * Required Fields					
                </span><br />
                <input type="hidden" name="adminsub" value="1" />
                <input type="hidden" name="ed" value="<?=$themyarray["adminid"]?>" />
                <input type="submit" value=" <?=$but_text?> Admin" class="button" />
            </td>
        </tr>
    </table>
    </form>
</body>
</html>
