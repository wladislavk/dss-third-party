<?php 
session_start();
?>
<script type="text/javascript" src="/manage/admin/script/jquery-1.6.2.min.js"></script>
<?php
require_once('admin/includes/config.php');
include("includes/sescheck.php");
include("includes/calendarinc.php");
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
		if(isset($_POST['sign']) && $_SESSION['docid']==$_SESSION['userid']){
		  $ins_sql .= "
			signed_id='".s_for($_SESSION['userid'])."',
			signed_on=now(),
			";
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
			parent.window.location='manage_progress_notes.php?msg=<?=$msg;?>&pid=<?=$_GET['pid'];?>';
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
                if(isset($_POST['sign']) && $_SESSION['docid']==$_SESSION['userid']){
                  $ins_sql .= "
                        signed_id='".s_for($_SESSION['userid'])."',
                        signed_on=now(),
                        ";
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
			parent.window.location='manage_progress_notes.php?msg=<?=$msg;?>&pid=<?=$_GET['pid'];?>';
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
	
	$but_text = "Add ";
	
	if($themyarray["userid"] != '')
	{
		$but_text = "Edit ";
	}
	else
	{
		$but_text = "Add ";
		$procedure_date = date('m/d/Y');
	}
	?>
	
	<br /><br />
	
	<? if($msg != '') {?>
    <div align="center" class="red">
        <? echo $msg;?>
    </div>
    <? } ?>
	
    <form name="notesfrm" action="<?=$_SERVER['PHP_SELF'];?>?add=1&pid=<?=$_GET['pid']?>" method="post" onSubmit="return notesabc(this)">
    <table width="700" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center">
        <tr>
            <td colspan="2" class="cat_head">
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
				<textarea id="notes" name="notes" class="tbox" style="width:100%; height:200px;"><?=$notes;?></textarea>
            </td>
        </tr>
        
        <tr>
        	<td valign="top" class="frmdata">
				Editor Initials: <input type="text" name="editor_initials" value="<?=$editor_initials ?>" maxlength="3" />
            </td>
        	<td valign="top" class="frmdata">
				Procedure Date: <input type="text" id="procedure_date" name="procedure_date" value="<?=$procedure_date ?>" class="calendar" />
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
                <input type="submit" value=" <?=$but_text?> Progress Notes" class="button" />
		<?php 
		  if($_SESSION['docid'] == $_SESSION['userid']){ ?>
		<input type="submit" name="sign" value=" <?=$but_text?> Sign and Close" class="button" />
		<?php } ?>
            </td>
        </tr>
    </table>
    </form>
	  <script language="JavaScript">
	
	   var cal72 = new calendar2(document.forms['notesfrm'].elements['procedure_date']);

    </script>
</body>
</html>
