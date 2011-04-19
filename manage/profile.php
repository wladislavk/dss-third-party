<?php include 'includes/top.htm';

if($_POST["profilesub"] == 1)
{
	$ed_sql = "update dental_users set name = '".s_for($_POST["name"])."', email = '".s_for($_POST["email"])."', address = '".s_for($_POST["address"])."', phone = '".s_for($_POST["phone"])."' where userid='".$_POST["ed"]."'";
	mysql_query($ed_sql);
			
	//echo $ed_sql.mysql_error();
	$msg = "Edited Successfully";
	?>
	<script type="text/javascript">
		//alert("<?=$msg;?>");
		window.location="<?=$_SERVER['PHP_SELF']?>?msg=<?=$msg;?>";
	</script>
	<?
	die();
	
}


$thesql = "select * from dental_users where userid='".$_SESSION["userid"]."'";
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
}
else
{
	$username = st($themyarray['username']);
	$password = st($themyarray['password']);
	$name = st($themyarray['name']);
	$email = st($themyarray['email']);
	$address = st($themyarray['address']);
	$phone = st($themyarray['phone']);
	
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
<br />
<span class="admin_head">
	Profile
</span>
<br />
<br />

<? if($_GET['msg'] != '') {?>
    <div align="center" class="red">
        <b><? echo $_GET['msg'];?></b>
    </div>
<? }?>
<form name="profilefrm" action="<?=$_SERVER['PHP_SELF'];?>?add=1" method="post" onsubmit="return profileabc(this)">
<table width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center">
   
    <tr bgcolor="#FFFFFF" width="30%">
        <td valign="top" class="frmhead">
            Username
        </td>
        <td valign="top" class="frmdata">
            <input type="text" name="username" value="<?=$username?>" class="tbox" <? if($themyarray['userid'] <> '') echo " readonly"; ?>  /> 
            <span class="red">*</span>
        </td>
    </tr>
    <tr bgcolor="#FFFFFF">
        <td valign="top" class="frmhead">
            Password
        </td>
        <td valign="top" class="frmdata">
            <a href="Javascript:;" onClick="Javascript: window.open('change_password.php','Change Password','top=100,left=100,width=500,height=275,scrollbars=yes,directories=no,location=no,toolbar=no')" class="formtext">
                <b>CHANGE PASSWORD</b></a>
                <input type="hidden" name="password" value="<?=$themyarray['password']?>" class="tbox_2" /> 
                <input type="hidden" name="con_password" value="<?=$themyarray['password']?>" class="tbox_2" /> 
        </td>
    </tr>
    <tr bgcolor="#FFFFFF">
        <td valign="top" class="frmhead">
            Name
        </td>
        <td valign="top" class="frmdata">
            <input type="text" name="name" value="<?=$name?>" class="tbox" /> 
            <span class="red">*</span>
        </td>
    </tr>
    <tr bgcolor="#FFFFFF">
        <td valign="top" class="frmhead">
            Email
        </td>
        <td valign="top" class="frmdata">
            <input type="text" name="email" value="<?=$email?>" class="tbox" /> 
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
    <tr>
        <td colspan="2" align="center">
            <span class="red">
                * Required Fields					
            </span><br />
            <input type="hidden" name="profilesub" value="1" />
            <input type="hidden" name="ed" value="<?=$themyarray["userid"]?>" />
            <input type="submit" value=" <?=$but_text?> Profile " class="button" />
        </td>
    </tr>
</table>
</form>

<br /><br />
<? include 'includes/bottom.htm';?>