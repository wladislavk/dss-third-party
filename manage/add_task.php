<?php
session_start();
require_once('admin/includes/main_include.php');
include("includes/sescheck.php");
?>
  <script type="text/javascript" src="/manage/admin/script/jquery-1.6.2.min.js"></script>
<?php
include("includes/calendarinc.php");

if($_POST["taskadd"] == 1){

		$due_date = ($_POST['due_date']!='')?date('Y-m-d', strtotime($_POST['due_date'])):'';
		$sql = "INSERT INTO dental_task SET
				task = '".mysql_real_escape_string($_POST['task'])."',
				due_date = '".mysql_real_escape_string(date('Y-m-d', strtotime($due_date)))."',
				userid = '".mysql_real_escape_string($_SESSION['userid'])."',
                                status = '".mysql_real_escape_string($_POST['status'])."',
				patientid = '".mysql_real_escape_string($_POST['patientid'])."',
				responsibleid = '".mysql_real_escape_string($_POST['responsibleid'])."'";
		mysql_query($sql);
		$msg = "Task Added!";
	?>
                <script type="text/javascript">
                        loc = parent.window.location.href;
                        loc = loc.replace("#","");
                        parent.window.location = loc;
                </script>

	<?php

}elseif($_POST["taskedit"] == 1){

                $due_date = ($_POST['due_date']!='')?date('Y-m-d', strtotime($_POST['due_date'])):'';
                $sql = "UPDATE dental_task SET
                                task = '".mysql_real_escape_string($_POST['task'])."',
                                due_date = '".mysql_real_escape_string(date('Y-m-d', strtotime($due_date)))."',
                                userid = '".mysql_real_escape_string($_SESSION['userid'])."',
				status = '".mysql_real_escape_string($_POST['status'])."',
                                responsibleid = '".mysql_real_escape_string($_POST['responsibleid'])."'
			WHERE id='".mysql_real_escape_string($_POST['task_id'])."'
				";
                mysql_query($sql);
                $msg = "Task Added!";
        ?>
                <script type="text/javascript">
			loc = parent.window.location.href;
			loc = loc.replace("#","");
			parent.window.location = loc;
                </script>

        <?php

}

if(isset($_GET['id'])){

$t_sql = "SELECT dt.*, p.firstname, p.lastname from dental_task dt 
	LEFT JOIN dental_patients p ON p.patientid=dt.patientid
WHERE dt.id='".mysql_real_escape_string($_GET['id'])."'";
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
    <input type="hidden" name="patientid" value="<?= $_GET['pid']; ?>" />
    <table width="700" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center">
        <tr>
            <td class="cat_head" style="font-size:20px;">
		<?php
		if(isset($_GET['pid'])){
			$p_sql = "SELECT firstname, lastname FROM dental_patients WHERE patientid='".mysql_real_escape_string($_GET['pid'])."'";
			$p_q = mysql_query($p_sql);
			$pat = mysql_fetch_assoc($p_q); ?>
			Add a task about <?= $pat['firstname'] . " " . $pat['lastname']; ?>
		<?php }else{ ?>
                	Add new task	
			<?php if($task['firstname']!='' || $task['lastname']!=''){
					echo "(".$task['firstname']." ".$task['lastname'].")";
				}
			?>
		<?php } ?>
            </td>
        </tr>
        <tr>
                <td valign="top" class="frmhead">
                                <label>Task</label>
                                <span class="red">*</span>
				<input style="width:500px;" type="text" name="task" value="<?= $task['task']; ?>" />
            </td>
       	</tr>
        <tr>
                <td valign="top" class="frmhead">
                                <label>Due Date</label>
                                <span class="red">*</span>
                                <input type="text" name="due_date" id="due_date" class="calendar" value="<?= ($task['due_date'])?date('m/d/Y', strtotime($task['due_date'])):date('m/d/Y'); ?>" />
            </td>
        </tr>
        <tr>
                <td valign="top" class="frmhead">
                                <label>Assigned To:</label>
                                <span class="red">*</span>
                                <select name="responsibleid">
				<?php 
					$responsibleid = ($task['responsibleid'])?$task['responsibleid']:$_SESSION['userid'];
					$r_sql = "SELECT * FROM dental_users
						WHERE (userid='".mysql_real_escape_string($_SESSION['docid'])."' OR
							docid='".mysql_real_escape_string($_SESSION['docid'])."') AND status=1 ";

					$r_q = mysql_query($r_sql);
					while($responsible = mysql_fetch_assoc($r_q)){ ?>
						<option value="<?= $responsible['userid']; ?>" <?= ($responsible['userid']==$responsibleid)?'selected="selected"':'';?>><?= $responsible['first_name']." ".$responsible['last_name']; ?></option>
					<?php } ?>
				</select>
            </td>
        </tr>
        <tr>
                <td valign="top" class="frmhead">
                                <label>Completed:</label>
                                <input type="checkbox" value="1" name="status" <?= ($task['status']==1)?'checked="checked"':''; ?> />
            </td>
        </tr>
	<tr>
		<td valign="top" class="frmhead">
			<?php if(isset($_GET['id'])){ ?>
				<input name="taskedit" value="1" type="hidden" />
				<input name="task_id" value="<?= $_GET['id']; ?>" type="hidden" />
	                        <a href="manage_tasks.php?delid=<?= $_GET['id']; ?>" target="_parent" style="float:right;" onclick="return confirm('Are you sure you want to delete this task?')">Delete</a>

			<?php }else{ ?>
                        	<input name="taskadd" value="1" type="hidden" />
			<?php } ?>
			<input type="submit" class="addButton" value="Add Task" />
		</td>


     </table>
     </form>
