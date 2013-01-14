<?php 
session_start();
require_once('admin/includes/config.php');
include("includes/sescheck.php");
include_once('admin/includes/password.php');
include('includes/general_functions.php');
?>
<script type="text/javascript" src="/manage/admin/script/jquery-1.6.2.min.js"></script>
<?php
if($_POST["staffsub"] == 1)
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
                        $p = ($_POST['producer']==1)?1:0;
                        $n = ($_POST['sign_notes']==1)?1:0;
			$ein = ($_POST['ein']==1)?1:0;
			$ssn = ($_POST['ssn']==1)?1:0;
			$ed_sql = "update dental_users set user_access=1, name = '".s_for($_POST["name"])."', email = '".s_for($_POST["email"])."', address = '".s_for($_POST["address"])."', phone = '".s_for(num($_POST["phone"]))."', status = '".s_for($_POST["status"])."', producer=".$p.", 
				npi = '".s_for($_POST["npi"])."',
                                medicare_npi = '".s_for($_POST["medicare_npi"])."',
                                tax_id_or_ssn = '".s_for($_POST["tax_id_or_ssn"])."',
                                ein = '".s_for($ein)."',
                                ssn = '".s_for($ssn)."',
                                practice = '".s_for($_POST["practice"])."',
                                city = '".s_for($_POST["city"])."',
                                state = '".s_for($_POST["state"])."',
                                zip = '".s_for($_POST["zip"])."',
				sign_notes=".$n."  where userid='".$_POST["ed"]."'";
			mysql_query($ed_sql) or die($ed_sql." | ".mysql_error());
			
			//echo $ed_sql.mysql_error();
			$msg = "Edited Successfully";
			?>
			<script type="text/javascript">
				//alert("<?=$msg;?>");
				parent.window.location='manage_staff.php?msg=<?=$msg;?>';
			</script>
			<?
			die();
		}
		else
		{

                        $salt = create_salt();
                        $password = gen_password($_POST['password'], $salt);
                        $p = ($_POST['producer']==1)?1:0;
                        $n = ($_POST['sign_notes']==1)?1:0;
                        $ein = ($_POST['ein']==1)?1:0;
                        $ssn = ($_POST['ssn']==1)?1:0;
			$ins_sql = "insert into dental_users set user_access=1, docid='".$_SESSION['userid']."', username = '".s_for($_POST["username"])."', password = '".mysql_real_escape_string($password)."', salt='".$salt."', name = '".s_for($_POST["name"])."', email = '".s_for($_POST["email"])."', address = '".s_for($_POST["address"])."', phone = '".s_for(num($_POST["phone"]))."', status = '".s_for($_POST["status"])."', producer=".$p.",
                                npi = '".s_for($_POST["npi"])."',
                                medicare_npi = '".s_for($_POST["medicare_npi"])."',
                                tax_id_or_ssn = '".s_for($_POST["tax_id_or_ssn"])."',
                                ein = '".s_for($ein)."',
                                ssn = '".s_for($ssn)."',
                                practice = '".s_for($_POST["practice"])."',
                                city = '".s_for($_POST["city"])."',
                                state = '".s_for($_POST["state"])."',
                                zip = '".s_for($_POST["zip"])."',
				sign_notes=".$n." ,adddate=now(),ip_address='".$_SERVER['REMOTE_ADDR']."'";
			mysql_query($ins_sql) or die($ins_sql.mysql_error());
			
			$msg = "Added Successfully";
			?>
			<script type="text/javascript">
				//alert("<?=$msg;?>");
				parent.window.location='manage_staff.php?msg=<?=$msg;?>';
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
		$npi = $_POST['npi'];
                $medicare_npi = $_POST['medicare_npi'];
                $tax_id_or_ssn = $_POST['tax_id_or_ssn'];
                $ein = $_POST['ein'];
                $ssn = $_POST['ssn'];
                $practice = $_POST['practice'];
                $address = $_POST['address'];
                $city = $_POST['city'];
                $state = $_POST['state'];
                $zip = $_POST['zip'];
                $phone = $_POST['phone'];
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
		$npi = st($themyarray['npi']);
                $medicare_npi = st($themyarray['medicare_npi']);
                $tax_id_or_ssn = st($themyarray['tax_id_or_ssn']);
                $ein = st($themyarray['ein']);
                $ssn = st($themyarray['ssn']);
                $practice = st($themyarray['practice']);
                $address = st($themyarray['address']);
                $city = st($themyarray['city']);
                $state = st($themyarray['state']);
                $zip = st($themyarray['zip']);
                $phone = st($themyarray['phone']);
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
    <form name="stafffrm" action="<?=$_SERVER['PHP_SELF'];?>?add=1" method="post" onSubmit="return staffabc(this)">
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
	<?php
	if($themyarray["userid"] == ''){
	?>
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
<td valign="top" class="frmhead">
                Producer
            </td>
            <td valign="top" class="frmdata">
                <input type="checkbox" <?= ($producer==1)?'checked="checked"':''; ?> value="1" id="producer" name="producer" />
            </td>
        </tr>
	<tr class="producer_field" bgcolor"#ffffff;">
	   <td colspan="2">
Fields left blank below will default to the standard billing settings for your office.
	   </td>
	</tr>
        <tr class="producer_field" bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                NPI
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="npi" value="<?=$npi;?>" class="tbox" />
            </td>
        </tr>
        <tr class="producer_field" bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                Medicare DME Number
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="medicare_npi" value="<?=$medicare_npi;?>" class="tbox" />
            </td>
        </tr>
        <tr class="producer_field" bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                Tax ID or SSN
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="tax_id_or_ssn" value="<?=$tax_id_or_ssn;?>" class="tbox" />
            </td>
        </tr>
        <tr class="producer_field" bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                EIN or SSN
            </td>
            <td valign="top" class="frmdata">
		<input type="checkbox" <?= ($ein==1)?'checked="checked"':''; ?> value="1" name="ein" /> EIN 
		<input type="checkbox" <?= ($ssn==1)?'checked="checked"':''; ?> value="1" name="ssn" /> SSN
            </td>
        </tr>
        <tr class="producer_field" bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                Practice
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="practice" value="<?=$practice;?>" class="tbox" />
            </td>
        </tr>
        <tr class="producer_field" bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                Address
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="address" class="tbox" id="address" value="<?= $address; ?>" />
                <!--<textarea name="address" class="tbox"><?=$address;?></textarea>-->
                <span class="red">*</span>
            </td>
        </tr>
        <tr class="producer_field" bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                City
            </td>
            <td valign="top" class="frmdata">
                <input id="city" type="text" value="<?php echo $city;?>" name="city" class="tbox" />
                <span class="red">*</span>
            </td>
        </tr>
        <tr class="producer_field" bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                State
            </td>
            <td valign="top" class="frmdata">
                <input id="state" type="text" value="<?php echo $state;?>" name="state" class="tbox" />
                <span class="red">*</span>
            </td>
        </tr>
        <tr class="producer_field" bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                Zip
            </td>
            <td valign="top" class="frmdata">
                <input id="zip" type="text" name="zip" value="<?php echo $zip;?>" class="tbox" />
                <span class="red">*</span>
            </td>
        </tr>
        <tr class="producer_field" bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                Phone
            </td>
            <td valign="top" class="frmdata">
                <input id="phone" type="text" name="phone" value="<?=$phone;?>" class="tbox" />
                <span class="red">*</span>
            </td>
        </tr>

<td valign="top" class="frmhead">
                Sign Progress Notes?
            </td>
            <td valign="top" class="frmdata">
                <input type="checkbox" <?= ($sign_notes==1)?'checked="checked"':''; ?> value="1" name="sign_notes" />
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
                <input type="hidden" name="staffsub" value="1" />
                <input type="hidden" name="ed" value="<?=$themyarray["userid"]?>" />
                <input type="submit" value=" <?=$but_text?> Staff" class="button" />
		<?php if($themyarray["userid"] != ''){ ?>
                    <a style="float:right;" href="manage_staff.php?delid=<?=$themyarray["userid"];?>" onclick="javascript: return confirm('Do Your Really want to Delete?.');" class="dellink" title="DELETE" target="_parent">
                                                 Delete 
                                        </a>
		<?php } ?>
            </td>
        </tr>
    </table>
    </form>
<script type="text/javascript">
  $('#producer').click(function(){
    if($(this).is(':checked')){
      $('.producer_field').show();
    }else{
      $('.producer_field').hide();
    }
  });

$(document).ready( function(){
    if($('#producer').is(':checked')){
      $('.producer_field').show();
    }else{
      $('.producer_field').hide();
    }

});
</script>
</body>
</html>
