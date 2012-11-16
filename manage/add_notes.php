<?php 
session_start();
?>
<script type="text/javascript" src="/manage/admin/script/jquery-1.6.2.min.js"></script>
<?php
require_once('admin/includes/config.php');
include("includes/sescheck.php");
include("includes/calendarinc.php");
include_once('admin/includes/password.php');


        $sign_sql = "SELECT sign_notes FROM dental_users where userid='".mysql_real_escape_string($_SESSION['userid'])."'";
        $sign_q = mysql_query($sign_sql);
        $sign_r = mysql_fetch_assoc($sign_q);
        $user_sign = $sign_r['sign_notes'];


if($_POST["notesub"] == 1)
{
	$notes = $_POST['notes'];
   	$procedure_date = ($_POST['procedure_date']!='')?date('Y-m-d', strtotime($_POST['procedure_date'])):'';	
	$editor_initials = $_POST['editor_initials'];


	if($_POST['ed'] == '')
	{
		$ins_sql = " insert into dental_notes set 
		patientid = '".s_for($_GET['pid'])."',
		notes = '".s_for($notes)."',
		editor_initials = '".s_for($editor_initials)."',
		procedure_date = '".s_for($procedure_date)."',
		userid = '".s_for($_SESSION['userid'])."',
		docid = '".s_for($_SESSION['docid'])."',";
		if(isset($_POST['sign']) && ($_SESSION['docid']==$_SESSION['userid'] || $user_sign==1)){
		  $ins_sql .= "
			signed_id='".s_for($_SESSION['userid'])."',
			signed_on=now(),
			";
		}elseif(isset($_POST['signstaff'])){
		        $salt_sql = "SELECT salt FROM dental_users WHERE username='".mysql_real_escape_string($_POST['username'])."'";
        		$salt_q = mysql_query($salt_sql);
        		$salt_row = mysql_fetch_assoc($salt_q);

        		$pass = gen_password($_POST['password'], $salt_row['salt']);

        		$check_sql = "SELECT userid, username, name, user_access, docid FROM dental_users where username='".mysql_real_escape_string($_POST['username'])."' and password='".$pass."' and status=1";
        		$check_my = mysql_query($check_sql);

        		if(mysql_num_rows($check_my) == 1)
        		{
				$check_myarray = mysql_fetch_array($check_my);
				$ins_sql .= "
                        	signed_id='".s_for($check_myarray['userid'])."',
                        	signed_on=now(),
                        	";
				?>
                                <script type="text/javascript">
                                        alert("Progress Note SIGNED and saved successfully.");
                                </script>
                                <?php
			}else{
				?>
				<script type="text/javascript">
					alert("Credential invalid - unable to SIGN note. Changes to note has been successfully saved, but note is UNSIGNED.");
				</script>	
				<?php
			}
		}
		$ins_sql .= "
		adddate = now(),
		ip_address = '".s_for($_SERVER['REMOTE_ADDR'])."'";
		
		mysql_query($ins_sql) or die($ins_sql." | ".mysql_error());
	 	$id = mysql_insert_id();
		mysql_query("UPDATE dental_notes SET parentid='".$id."' WHERE notesid='".$id."'");	
		$msg = "Added Successfully";
		?>
		<script type="text/javascript">
			//alert("<?=$msg;?>");
			parent.window.location='dss_summ.php?msg=<?=$msg;?>&pid=<?=$_GET['pid'];?>&addtopat=1';
		</script>
		<?
		die();
	}
	else
	{
		$p_q = mysql_query("select parentid FROM dental_notes WHERE notesid='".$_POST["ed"]."'");
		$p_r = mysql_fetch_assoc($p_q);
		$parentid = $p_r['parentid'];
		$ins_sql = " insert into dental_notes set 
                patientid = '".s_for($_GET['pid'])."',
                notes = '".s_for($notes)."',
                editor_initials = '".s_for($editor_initials)."',
                procedure_date = '".s_for($procedure_date)."',
                userid = '".s_for($_SESSION['userid'])."',
                docid = '".s_for($_SESSION['docid'])."',";
                if(isset($_POST['sign']) && ($_SESSION['docid']==$_SESSION['userid'] || $user_sign==1)){
                  $ins_sql .= "
                        signed_id='".s_for($_SESSION['userid'])."',
                        signed_on=now(),
                        ";
                }elseif(isset($_POST['signstaff'])){
                        $salt_sql = "SELECT salt FROM dental_users WHERE username='".mysql_real_escape_string($_POST['username'])."'";
                        $salt_q = mysql_query($salt_sql);
                        $salt_row = mysql_fetch_assoc($salt_q);

                        $pass = gen_password($_POST['password'], $salt_row['salt']);

                        $check_sql = "SELECT userid, username, name, user_access, docid FROM dental_users where username='".mysql_real_escape_string($_POST['username'])."' and password='".$pass."' and status=1";
                        $check_my = mysql_query($check_sql);

                        if(mysql_num_rows($check_my) == 1)
                        {
                                $check_myarray = mysql_fetch_array($check_my);
                                $ins_sql .= "
                                signed_id='".s_for($check_myarray['userid'])."',
                                signed_on=now(),
                                ";
                        }else{
                                ?>
                                <script type="text/javascript">
                                        alert("Unable to sign note due to invalid credentials. Updated note has been saved.");
                                </script>
                                <?php
                        }
                }

                $ins_sql .= "
		parentid='".$parentid."',
                adddate = now(),
                ip_address = '".s_for($_SERVER['REMOTE_ADDR'])."'";

		$up_sql = "update dental_notes set 
		patientid = '".s_for($_GET['pid'])."',
		notes = '".s_for($notes)."',
		editor_initials = '".s_for($editor_initials)."',
		procedure_date = '".s_for($procedure_date)."',
		edited = 1,";
                if(isset($_POST['sign']) && $_SESSION['docid']==$_SESSION['userid']){
                  $up_sql .= "
                        signed_id='".s_for($_SESSION['userid'])."',
                        signed_on=now(),
                        ";
                }
                $up_sql .= "
		userid = '".s_for($_SESSION['userid'])."'
	 	where notesid='".$_POST["ed"]."'";
		
		mysql_query($ins_sql) or die($ins_sql." | ".mysql_error());
		
		$msg = "Edited Successfully";
		?>
		<script type="text/javascript">
			//alert("<?=$msg;?>");
			parent.window.location='dss_summ.php?msg=<?=$msg;?>&pid=<?=$_GET['pid'];?>&addtopat=1';
		</script>
		<?
		die();
	}
}
$sql = "select * from dental_custom where docid='".$_SESSION['docid']."' order by Title";
$my = mysql_query($sql);
$total_rec = mysql_num_rows($my);

$pat_sql = "select * from dental_patients where patientid='".s_for($_GET['pid'])."'";
$pat_my = mysql_query($pat_sql);
$pat_myarray = mysql_fetch_array($pat_my);

$name = st($pat_myarray['lastname'])." ".st($pat_myarray['middlename'])." ".st($pat_myarray['firstname']);

if($pat_myarray['patientid'] == '')
{
	?>
	<script type="text/javascript">
		window.location = 'manage_patient.php';
	</script>
	<?
	die();
}
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
                        //$my = mysql_query($sql);
                        while($myarray = mysql_fetch_array($my))
                        {?>
                                title_arr[<?=$i;?>] = "<?=st(addslashes($myarray['title']));?>";
                                desc_arr[<?=$i;?>] = "<?=st(trim( preg_replace( '/\n\r|\r\n/','%n%',addslashes($myarray['description']))));?>";
                        <?
                                $i++;
                        }?>
                        document.getElementById("notes").value = desc_arr[fa].replace(/\%n\%/g,'\r\n');
                }
                else
                {
                        document.getElementById("notes").value = "";
                }
        }
        
</script>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="css/admin.css" rel="stylesheet" type="text/css" />
<script language="javascript" type="text/javascript" src="script/validation.js"></script>

<link rel="stylesheet" href="css/form.css" type="text/css" />
<script type="text/javascript" src="script/wufoo.js"></script>
</head>
<body>
<script language="JavaScript" src="calendar1.js"></script>
<script language="JavaScript" src="calendar2.js"></script>
    <?
	
    $thesql = "select n.*, u.name added_name from dental_notes n
	LEFT JOIN dental_users u on u.userid=n.userid
	where notesid='".$_REQUEST["ed"]."'";
	$themy = mysql_query($thesql);
	$themyarray = mysql_fetch_array($themy);
	
	$notes = st($themyarray['notes']);
	$editor_initials = st($themyarray['editor_initials']);
	$procedure_date = ($themyarray['procedure_date']!='')?date('m/d/Y', strtotime($themyarray['procedure_date'])):'';
	
	$but_unsigned_text = "Save and keep UNSIGNED";
	$but_signed_text = "Save Progress Note and SIGN";
	
	if($themyarray["userid"] != '')
	{
        	$but_unsigned_text = "Save changes and keep UNSIGNED";
        	$but_signed_text = "Save changes and SIGN";
	}
	else
	{
		$but_unsigned_text = "Save and keep UNSIGNED";
        	$but_signed_text = "Save Progress Note and SIGN";
		$procedure_date = date('m/d/Y');
	}
	?>
	
	
	<? if($msg != '') {?>
    <div align="center" class="red">
        <? echo $msg;?>
    </div>
    <? } ?>
	
    <form name="notesfrm" action="<?=$_SERVER['PHP_SELF'];?>?add=1&pid=<?=$_GET['pid']?>" method="post" onSubmit="return notesabc(this)">
    <table width="700" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center">
        <tr>
            <td colspan="2" class="cat_head" style="font-size:16px;">
               	<?=$but_text?> Progress Notes
			   	-
   				Patient <i><?=$name;?></i>

		Entry Date: <?= date('m/d/Y', strtotime($procedure_date)); ?>
            </td>
        </tr>
        <tr>
        	<td valign="top" colspan="2" class="frmhead">
				Text Templates
				<span class="red">*</span>
            <select name="title" class="tbox" onChange="change_desc(this.value)">
                <option value="">Select</option>
                <?
                                $j=0;
                                $my = mysql_query($sql);
                                while($myarray = mysql_fetch_array($my))
                                { ?>
                                        <option value="<?=$j;?>">
                        <?=st($myarray['title']);?>
                    </option>
                                <?
                                        $j++;
                                }?>
            </select>
		<span style="float:right;">
		<?php
		$r_sql = "SELECT n.parentid, u.name FROM dental_notes n LEFT JOIN dental_users u ON n.userid=u.userid
			WHERE parentid=(select parentid from dental_notes where notesid='".mysql_real_escape_string($_REQUEST['ed'])."')
			AND notesid != '".mysql_real_escape_string($_REQUEST['ed'])."'";
		$r_q = mysql_query($r_sql);
		$num_r = mysql_num_rows($r_q);
		$r = mysql_fetch_assoc($r_q);
		if($num_r == 1){
		  ?>Last Edited By: <?
			echo $r['name'];
		}elseif($num_r > 1){
		  ?><a href="note_revisions.php?nid=<?=$r['parentid'];?>">View Revisions</a><?php
		}
		?></span>
            </td>
		</tr>
		<tr>
        	<td colspan="2" valign="top" class="frmdata">
				<textarea id="notes" name="notes" class="tbox" style="width:100%; height:190px;"><?=$notes;?></textarea>
            </td>
        </tr>
        
        <tr>
        	<td valign="top" class="frmdata">
				Editor Initials: <input type="text" name="editor_initials" value="<?=$editor_initials ?>" maxlength="3" />
            </td>
        	<td class="frmdata">
				Procedure Date: <span class="red">*</span> <input type="text" id="procedure_date" name="procedure_date" value="<?=$procedure_date ?>" class="calendar" />
				Added by: 
				<?php
					if(isset($_REQUEST['ed'])){
						echo $themyarray["added_name"];
					}else{
						$s = "SELECT name from dental_users where userid='".mysql_real_escape_string($_SESSION['userid'])."'";
						$q = mysql_query($s);
						$r = mysql_fetch_assoc($q);
						echo $r['name'];
					}
				?>
            </td>
        </tr>
        
        
        <tr>
            <td  colspan="2" align="center">
                <span class="red">
                    * Required Fields					
                </span><br />
                <input type="hidden" name="notesub" value="1" />
                <input type="hidden" name="ed" value="<?=$themyarray["notesid"]?>" />
		<div id="submit_buttons">
                <input type="submit" name="<?= ($_SESSION['docid'] == $_SESSION['userid'])?'unsign':'unsign_staff'; ?>" value=" <?=$but_unsigned_text?>" class="button" />
		<?php 
		  if($_SESSION['docid'] == $_SESSION['userid'] || $user_sign==1){ ?>
		<input type="submit"  style="margin-left: 20px;" name="sign" value=" <?=$but_signed_text?>" class="button" />
		<?php }else{ ?>
			<input type="button" onclick="staff_sign();return false;" style="margin-left: 20px;" name="sign" value=" <?=$but_signed_text?>" class="button" />		
		<? } ?>
		</div>
<a href="#" onclick="delete_note();return false;" style="float:left;">Delete</a>
<p style="font-size:9px; text-align:left; margin-left:70px;">NOTE: For a Progress Note to be legally valid it must be SIGNED. SIGNED means that the note is stored permanently and can no longer be edited. If you wish to make future edits to a Progress Note then select UNSIGNED, but it will not become a legal part of the Patient's chart until SIGNED.</p>
		<?php if($_SESSION['docid'] != $_SESSION['userid']){ ?>
			<div id="cred_div" style="display:none;">
				<p>To SIGN this progress note an authorized user must enter credentials and click "Save changes and SIGN".<br />To save note without signing click "Save changes and keep UNSIGNED".</p>
				Authorized User: <input type="text" name="username" /><br />
				Password: <input type="password" name="password" /><br />
				<input type="submit" value=" <?=$but_unsigned_text?>" class="button" />
				<input type="submit" style="margin-left: 20px;" name="signstaff" value=" <?=$but_signed_text?>" class="button" />

			</div>
		<?php } ?>
            </td>
        </tr>
    </table>
    </form>
	  <script language="JavaScript">
	   function delete_note(){
		if(confirm('Progress Note will be deleted, are you sure?')){
		  parent.window.location = "dss_summ.php?pid=<?= $themyarray['patientid'];?>&del_note=<?= ($themyarray['parentid']!='')?$themyarray['parentid']:$themyarray['notesid']; ?>"
		}
	   }
	   function staff_sign(){
		<?php
			$doc_sql = "SELECT name from dental_users WHERE userid='".mysql_real_escape_string($_SESSION['docid'])."'";
			$doc_q = mysql_query($doc_sql);
			$doc_r = mysql_fetch_assoc($doc_q);
		?>
		if(confirm("Your account does not have sufficient privileges to SIGN progress notes. The users in your office who can legally SIGN this progress note are: <?= $doc_r['name']; ?>. Please ask one of these authorized users to enter their credentials below - by doing so they will legally SIGN this progress note. If you do not wish to SIGN this progress note, simply click \"Save and Keep UNSIGNED\"")){
			$('#submit_buttons').hide();
			$('#cred_div').show();
		}
	   }	
	   var cal72 = new calendar2(document.forms['notesfrm'].elements['procedure_date']);

    </script>
</body>
</html>
