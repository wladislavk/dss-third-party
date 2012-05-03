<?php
session_start();
require_once('admin/includes/config.php');
include("includes/sescheck.php");
?>
  <script type="text/javascript" src="/manage/admin/script/jquery-1.6.2.min.js"></script>
<?php
include("includes/calendarinc.php");

if($_POST["taskadd"] == 1){

		$due_date = ($_POST['due_date']!='')?date('Y-m-d', strtotime($_POST['due_date'])):'';
		$sql = "INSERT INTO dental_task SET
				task = '".mysql_real_escape_string($_POST['task'])."',
				description = '".mysql_real_escape_string($_POST['description'])."',
				due_date = '".mysql_real_escape_string(date('Y-m-d', strtotime($due_date)))."',
				userid = '".mysql_real_escape_string($_SESSION['userid'])."',
				responsibleid = '".mysql_real_escape_string($_POST['responsibleid'])."'";
		mysql_query($sql);
		$msg = "Task Added!";
	?>
                <script type="text/javascript">
                        parent.window.location='manage_tasks.php?msg=<?=$msg;?>';
                </script>

	<?php

}elseif($_POST["taskedit"] == 1){

                $due_date = ($_POST['due_date']!='')?date('Y-m-d', strtotime($_POST['due_date'])):'';
                $sql = "UPDATE dental_task SET
                                task = '".mysql_real_escape_string($_POST['task'])."',
                                description = '".mysql_real_escape_string($_POST['description'])."',
                                due_date = '".mysql_real_escape_string(date('Y-m-d', strtotime($due_date)))."',
                                userid = '".mysql_real_escape_string($_SESSION['userid'])."',
                                responsibleid = '".mysql_real_escape_string($_POST['responsibleid'])."'
			WHERE id='".mysql_real_escape_string($_POST['task_id'])."'
				";
                mysql_query($sql);
                $msg = "Task Added!";
        ?>
                <script type="text/javascript">
                        parent.window.location='manage_tasks.php?msg=<?=$msg;?>';
                </script>

        <?php

}

if(isset($_GET['id'])){

$t_sql = "SELECT * from dental_task WHERE id='".mysql_real_escape_string($_GET['id'])."'";
$t_q = mysql_query($t_sql);
$task = mysql_fetch_assoc($t_q);

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
				<input type="text" name="task" value="<?= $task['task']; ?>" />
            </td>
       	</tr>
        <tr>
                <td valign="top" class="frmhead">
                                <label>Description</label>
                                <span class="red">*</span>
                                <textarea name="description"><?= $task['description']; ?></textarea>
            </td>
        </tr>
        <tr>
                <td valign="top" class="frmhead">
                                <label>Due Date</label>
                                <span class="red">*</span>
                                <input type="text" name="due_date" id="due_date" class="calendar" value="<?= date('m/d/Y', strtotime($task['due_date'])); ?>" />
            </td>
        </tr>
        <tr>
                <td valign="top" class="frmhead">
                                <label>Assigned To:</label>
                                <span class="red">*</span>
                                <select name="responsibleid">
				<?php 
					$r_sql = "SELECT * FROM dental_users
						WHERE userid='".mysql_real_escape_string($_SESSION['docid'])."' OR
							docid='".mysql_real_escape_string($_SESSION['docid'])."'";

					$r_q = mysql_query($r_sql);
					while($responsible = mysql_fetch_assoc($r_q)){ ?>
						<option value="<?= $responsible['userid']; ?>"><?= $responsible['name']; ?></option>
					<?php } ?>
				</select>
            </td>
        </tr>
	<tr>
		<td valign="top" class="frmhead">
			<?php if(isset($_GET['id'])){ ?>
				<input name="taskedit" value="1" type="hidden" />
				<input name="task_id" value="<?= $_GET['id']; ?>" type="hidden" />
			<?php }else{ ?>
                        	<input name="taskadd" value="1" type="hidden" />
			<?php } ?>
			<input type="submit" class="addButton" value="Add Task" />
		</td>


     </table>
     </form>
