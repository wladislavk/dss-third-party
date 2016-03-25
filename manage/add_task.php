<?php namespace Ds3\Libraries\Legacy; ?><?php
include_once('admin/includes/main_include.php');
include("includes/sescheck.php");
?>
<script type="text/javascript" src="/manage/admin/script/jquery-1.6.2.min.js"></script>
<?php
include("includes/calendarinc.php");

if(!empty($_POST["taskadd"]) && $_POST["taskadd"] == 1){

	$due_date = (!empty($_POST['due_date']))?date('Y-m-d', strtotime($_POST['due_date'])):'';
	$sql = "INSERT INTO dental_task SET
                task = '".mysqli_real_escape_string($con,$_POST['task'])."',
                due_date = '".mysqli_real_escape_string($con,date('Y-m-d', strtotime($due_date)))."',
                userid = '".mysqli_real_escape_string($con,$_SESSION['userid'])."',
                status = '".mysqli_real_escape_string($con,(!empty($_POST['status']) ? $_POST['status'] : ''))."',
                patientid = '".mysqli_real_escape_string($con,$_POST['patientid'])."',
                responsibleid = '".mysqli_real_escape_string($con,$_POST['responsibleid'])."'";
	$db->query($sql);
	$msg = "Task Added!";
	?>
<script type="text/javascript">
    loc = parent.window.location.href;
    loc = loc.replace("#","");
    parent.window.location = loc;
</script>

<?php
}elseif(!empty($_POST["taskedit"]) && $_POST["taskedit"] == 1){

    $due_date = ($_POST['due_date']!='')?date('Y-m-d', strtotime($_POST['due_date'])):'';
    $sql = "UPDATE dental_task SET
                task = '".mysqli_real_escape_string($con,$_POST['task'])."',
                due_date = '".mysqli_real_escape_string($con,date('Y-m-d', strtotime($due_date)))."',
                userid = '".mysqli_real_escape_string($con,$_SESSION['userid'])."',
                status = '".mysqli_real_escape_string($con,$_POST['status'])."',
                responsibleid = '".mysqli_real_escape_string($con,$_POST['responsibleid'])."'
                WHERE id='".mysqli_real_escape_string($con,$_POST['task_id'])."'";
    $db->query($sql);
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
            WHERE dt.id='".mysqli_real_escape_string($con,$_GET['id'])."'";
$task = $db->getRow($t_sql);
}?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <link href="css/admin.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="css/form.css" type="text/css" />
    <script type="text/javascript" src="/manage/admin/js/tracekit.js"></script>
    <script type="text/javascript" src="/manage/admin/js/tracekit.handler.js"></script>
    <script type="text/javascript" src="admin/script/jquery-1.6.2.min.js"></script>
    <script type="text/javascript" src="script/validation.js"></script>
</head>
<body>
<form name="notesfrm" action="<?php echo $_SERVER['PHP_SELF'];?>?add=1&pid=<?php echo (!empty($_GET['pid']) ? $_GET['pid'] : '')?>" method="post" >
    <input type="hidden" name="patientid" value="<?php echo (!empty($_GET['pid']) ? $_GET['pid'] : ''); ?>" />
    <table width="700" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center">
        <tr>
            <td class="cat_head" style="font-size:20px;">
<?php
if(isset($_GET['pid'])){
    $p_sql = "SELECT firstname, lastname FROM dental_patients WHERE patientid='".mysqli_real_escape_string($con,$_GET['pid'])."'";
    $pat = $db->getRow($p_sql);
    echo "Add a task about " . $pat['firstname'] . " " . $pat['lastname']; ?>
<?php 
}else{ ?>
            	Add new task	
<?php 
    if(!empty($task['firstname']) || !empty($task['lastname'])){
		echo "(".$task['firstname']." ".$task['lastname'].")";
	}
} ?>
            </td>
        </tr>
        <tr>
            <td valign="top" class="frmhead">
                <label>Task</label>
                <span class="red">*</span>
                <input style="width:500px;" type="text" name="task" value="<?php echo (!empty($task['task']) ? $task['task'] : ''); ?>" />
            </td>
       	</tr>
        <tr>
            <td valign="top" class="frmhead">
                <label>Due Date</label>
                <span class="red">*</span>
                <input type="text" name="due_date" id="due_date" class="calendar" value="<?php echo (!empty($task['due_date']))?date('m/d/Y', strtotime($task['due_date'])):date('m/d/Y'); ?>" />
            </td>
        </tr>
        <tr>
            <td valign="top" class="frmhead">
                <label>Assigned To:</label>
                <span class="red">*</span>
                <select name="responsibleid">
<?php 
$responsibleid = (!empty($task['responsibleid']))?$task['responsibleid']:$_SESSION['userid'];
$r_sql = "SELECT * FROM dental_users
            WHERE (userid='".mysqli_real_escape_string($con,$_SESSION['docid'])."' OR
            docid='".mysqli_real_escape_string($con,$_SESSION['docid'])."') AND status=1 ";

$r_q = $db->getResults($r_sql);
foreach ($r_q as $responsible) {?>
                    <option value="<?php echo $responsible['userid']; ?>" <?php echo ($responsible['userid']==$responsibleid)?'selected="selected"':'';?>><?php echo $responsible['first_name']." ".$responsible['last_name']; ?></option>
<?php } ?>
				</select>
            </td>
        </tr>
        <tr>
            <td valign="top" class="frmhead">
                <label>Completed:</label>
                <input type="checkbox" value="1" name="status" <?php echo (!empty($task['status']) && $task['status']==1)?'checked="checked"':''; ?> />
            </td>
        </tr>
	<tr>
        <td valign="top" class="frmhead">
<?php 
if(isset($_GET['id'])){ ?>
            <input name="taskedit" value="1" type="hidden" />
            <input name="task_id" value="<?php echo $_GET['id']; ?>" type="hidden" />
            <a href="manage_tasks.php?delid=<?php echo $_GET['id']; ?>" target="_parent" style="float:right;" onclick="return confirm('Are you sure you want to delete this task?')">Delete</a>

<?php 
}else{ ?>
            <input name="taskadd" value="1" type="hidden" />
<?php 
} ?>
            <input type="submit" class="addButton" value="Add Task" />
        </td>
    </table>
</form>
</body>
</html>
