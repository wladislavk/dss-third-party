<?php
session_start();
require_once('admin/includes/config.php');
include("includes/sescheck.php");
include("includes/calendarinc.php");

if($_POST["tasksub"] == 1){

		$due_date = ($_POST['due_date']!='')?date('Y-m-d', strtotime($_POST['due_date'])):'';
		$sql = "INSERT INTO dental_task SET
				task = '".mysql_real_escape_string($_POST['task'])."',
				description = '".mysql_real_escape_string($_POST['description'])."',
				due_date = '".mysql_real_escape_string($due_date)."',
				docid = '".mysql_real_escape_string($_SESSION['docid'])."',
				responsibleid = '".mysql_real_escape_string($_SESSION['docid'])."'";
		mysql_query($sql);
		$msg = "Task Added!";
	?>
                <script type="text/javascript">
                        parent.window.location='manage_tasks.php?msg=<?=$msg;?>';
                </script>

	<?php

}

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="css/admin.css" rel="stylesheet" type="text/css" />
<script language="javascript" type="text/javascript" src="script/validation.js"></script>

<link rel="stylesheet" href="css/form.css" type="text/css" />

    <form name="notesfrm" action="<?=$_SERVER['PHP_SELF'];?>?add=1&pid=<?=$_GET['pid']?>" method="post" >
    <table width="700" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center">
        <tr>
            <td class="cat_head">
                Tasks
            </td>
        </tr>
        <tr>
                <td valign="top" class="frmhead">
                                <label>Task</label>
                                <span class="red">*</span>
				<input type="text" name="task" />
            </td>
       	</tr>
        <tr>
                <td valign="top" class="frmhead">
                                <label>Description</label>
                                <span class="red">*</span>
                                <textarea name="description"></textarea>
            </td>
        </tr>
        <tr>
                <td valign="top" class="frmhead">
                                <label>Due Date</label>
                                <span class="red">*</span>
                                <input type="text" name="due_date" id="due_date" class="calendar" />
            </td>
        </tr>
        <tr>
                <td valign="top" class="frmhead">
                                <label>Assigned To:</label>
                                <span class="red">*</span>
                                <select name="responsibleid">
					<option>No one yet</option>
				</select>
            </td>
        </tr>
	<tr>
		<td valign="top" class="frmhead">
			<input name="tasksub" value="1" type="hidden" />
			<input type="submit" class="addButton" value="Add Task" />
		</td>


     </table>
     </form>
