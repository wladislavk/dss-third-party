<?php 
session_start();
require_once('admin/includes/config.php');
include("includes/sescheck.php");
include("includes/calendarinc.php");
if($_POST["notesub"] == 1)
{
	$notes = $_POST['notes'];
	
	if($_POST['ed'] == '')
	{
		$ins_sql = " insert into dental_notes set 
		patientid = '".s_for($_GET['pid'])."',
		notes = '".s_for($notes)."',
		editor_initials = '".s_for($editor_initials)."',
		procedure_date = '".s_for($procedure_date)."',
		userid = '".s_for($_SESSION['userid'])."',
		docid = '".s_for($_SESSION['docid'])."',
		adddate = now(),
		ip_address = '".s_for($_SERVER['REMOTE_ADDR'])."'";
		
		mysql_query($ins_sql) or die($ins_sql." | ".mysql_error());
		
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
		$up_sql = "update dental_notes set 
		patientid = '".s_for($_GET['pid'])."',
		notes = '".s_for($notes)."',
		editor_initials = '".s_for($editor_initials)."',
		procedure_date = '".s_for($procedure_date)."',
		edited = 1,
		userid = '".s_for($_SESSION['userid'])."'
	 	where notesid='".$_POST["ed"]."'";
		
		mysql_query($up_sql) or die($up_sql." | ".mysql_error());
		
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
                                desc_arr[<?=$i;?>] = "<?=st(trim( preg_replace( '/\n\r|\r\n/',' ',addslashes($myarray['description']))));?>";
                        <?
                                $i++;
                        }?>
                        document.getElementById("notes").value = desc_arr[fa];
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
	
    $thesql = "select * from dental_notes where notesid='".$_REQUEST["ed"]."'";
	$themy = mysql_query($thesql);
	$themyarray = mysql_fetch_array($themy);
	
	$notes = st($themyarray['notes']);
	$editor_initials = st($themyarray['editor_initials']);
	$procedure_date = st($themyarray['procedure_date']);
	
	$but_text = "Add ";
	
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
	
    <form name="notesfrm" action="<?=$_SERVER['PHP_SELF'];?>?add=1&pid=<?=$_GET['pid']?>" method="post" onSubmit="return notesabc(this)">
    <table width="700" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center">
        <tr>
            <td colspan="2" class="cat_head">
               	<?=$but_text?> Progress Notes
			   	-
   				Patient <i><?=$name;?></i>
            </td>
        </tr>
        <tr>
        	<td valign="top" class="frmhead">
				Progress Note
				<span class="red">*</span>
            <select name="title" class="tbox" onChange="change_desc(this.value)">
                <option value="">Select</option>
                <?
                                $j=0;
                                $my = mysql_query($sql);
                                while($myarray = mysql_fetch_array($my))
                                {?>
                                        <option value="<?=$j;?>">
                        <?=st($myarray['title']);?>
                    </option>
                                <?
                                        $j++;
                                }?>
            </select>

            </td>
		</tr>
		<tr>
        	<td valign="top" class="frmdata">
				<textarea id="notes" name="notes" class="tbox" style="width:100%; height:200px;"><?=$notes;?></textarea>
            </td>
        </tr>
        
        <tr>
        	<td valign="top" class="frmdata">
				Editor Initials: <input type="text" name="editor_initials" value="<?=$editor_initials ?>" maxlength="3" />
            </td>
        </tr>
        <tr>
        	<td valign="top" class="frmdata">
				Procedure Date: <input type="text" name="procedure_date" value="<?=$procedure_date ?>" class="calendar" />
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
            </td>
        </tr>
    </table>
    </form>
	  <script language="JavaScript">
	
	   var cal72 = new calendar2(document.forms['notesfrm'].elements['procedure_date']);

    </script>
</body>
</html>
