<?php 
session_start();
require_once('includes/config.php');
include("includes/sescheck.php");

if($_POST["usersub"] == 1)
{
	$sel_check = "select * from dental_users where username = '".s_for($_POST["username"])."' and userid <> '".s_for($_POST['ed'])."'";
	$query_check=mysql_query($sel_check);
	
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
	else
	{
		if($_POST["ed"] != "")
		{
			$ed_sql = "update dental_users set user_access=2,password = '".s_for($_POST["password"])."',npi = '".s_for($_POST["npi"])."', name = '".s_for($_POST["name"])."', email = '".s_for($_POST["email"])."', address = '".s_for($_POST["address"])."', city = '".s_for($_POST["city"])."', state = '".s_for($_POST["state"])."', zip = '".s_for($_POST["zip"])."', phone = '".s_for($_POST["phone"])."', status = '".s_for($_POST["status"])."' where userid='".$_POST["ed"]."'";
			mysql_query($ed_sql) or die($ed_sql." | ".mysql_error());
			
			//echo $ed_sql.mysql_error();
			$msg = "Edited Successfully";
			?>
			<script type="text/javascript">
				//alert("<?=$msg;?>");
				parent.window.location='manage_users.php?msg=<?=$msg;?>';
			</script>
			<?
			die();
		}
		else
		{
			$ins_sql = "insert into dental_users set user_access=2,username = '".s_for($_POST["username"])."',npi = '".s_for($_POST["npi"])."', password = '".s_for($_POST["password"])."', name = '".s_for($_POST["name"])."', email = '".s_for($_POST["email"])."', address = '".s_for($_POST["address"])."', city = '".s_for($_POST["city"])."', state = '".s_for($_POST["state"])."', zip = '".s_for($_POST["zip"])."', phone = '".s_for($_POST["phone"])."', status = '".s_for($_POST["status"])."',adddate=now(),ip_address='".$_SERVER['REMOTE_ADDR']."'";
			mysql_query($ins_sql) or die($ins_sql.mysql_error());
			
			$msg = "Added Successfully";
			?>
			<script type="text/javascript">
				//alert("<?=$msg;?>");
				parent.window.location='manage_users.php?msg=<?=$msg;?>';
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
		$npi = $_POST['npi'];
		$password = $_POST['password'];
		$name = $_POST['name'];
		$email = $_POST['email'];
		$address = $_POST['address'];
		$city = $_POST['city'];
		$state = $_POST['state'];
		$zip = $_POST['zip'];
		$phone = $_POST['phone'];
		$status = $_POST['status'];
	}
	else
	{
		$username = st($themyarray['username']);
		$npi = st($themyarray['npi']);
		$password = st($themyarray['password']);
		$name = st($themyarray['name']);
		$email = st($themyarray['email']);
		$address = st($themyarray['address']);
		$city = st($themyarray['city']);
		$state = st($themyarray['state']);
		$zip = st($themyarray['zip']);
		$phone = st($themyarray['phone']);
		$status = st($themyarray['status']);
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
                <input type="text" name="username" value="<?=$username?>" class="tbox" /> 
                <span class="red">*</span>				
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                NPI Number
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="npi" value="<?=$npi?>" class="tbox" /> 
                <span class="red">*</span>				
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                Passsword
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="password" value="<?=$password;?>" class="tbox" /> 
                <span class="red">*</span>				
            </td>
        </tr>
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
                <span class="red">*</span>				
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                City
            </td>
            <td valign="top" class="frmdata">
                <input type="text" value="<?php echo $city;?>" name="city" class="tbox" />
                <span class="red">*</span>				
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                State
            </td>
            <td valign="top" class="frmdata">
                <input type="text" value="<?php echo $state;?>" name="state" class="tbox" />
                <span class="red">*</span>				
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                Zip
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="zip" value="<?php echo $zip;?>" class="tbox" />
                <span class="red">*</span>				
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                Phone
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="phone" value="<?=$phone;?>" class="tbox" /> 
                <span class="red">*</span>				
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
            <td  colspan="2" align="center">
                <span class="red">
                    * Required Fields					
                </span><br />
                <input type="hidden" name="usersub" value="1" />
                <input type="hidden" name="ed" value="<?=$themyarray["userid"]?>" />
                <input type="submit" value=" <?=$but_text?> User" class="button" />
            </td>
        </tr>
    </table>
    </form>
</body>
</html>