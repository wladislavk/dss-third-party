<? 
require_once('includes/constants.inc');
include "includes/top.htm";

if(isset($_GET['delid'])){
$del_sql = "UPDATE dental_task SET status=2 WHERE id='".mysql_real_escape_string($_GET['delid'])."'";
mysql_query($del_sql);
}

$sql = "select dt.*, du.name, p.firstname, p.lastname from dental_task dt
	JOIN dental_users du ON dt.responsibleid=du.userid
	LEFT JOIN dental_patients p ON p.patientid=dt.patientid
   WHERE (dt.status = '0' OR
	dt.status IS NULL) AND
	(du.docid='".mysql_real_escape_string($_SESSION['docid'])."' OR du.userid='".mysql_real_escape_string($_SESSION['docid'])."')
  ORDER BY due_date ASC";
$my = mysql_query($sql);
?>

<link rel="stylesheet" href="popup/popup.css" type="text/css" media="screen" />
<link rel="stylesheet" href="css/task.css" type="text/css" media="screen" />
<script src="popup/popup.js" type="text/javascript"></script>

<span class="admin_head">
	Manage Tasks
</span>
<br />
<br />
&nbsp;
<button onclick="loadPopup('add_task.php');" class="addButton" style="float:right; margin-right: 10px;">Add Task</button>
<br />
<div align="center" class="red">
	<b><? echo $_GET['msg'];?></b>
</div>


<table width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center" >
	<tr class="tr_bg_h">
		<td width="2%" class="col_head">
		</td>
		<td valign="top" class="col_head  <?= ($_REQUEST['sort'] == 'task')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>" width="45%">
			Task
		</td>
		<td valign="top" class="col_head  <?= ($_REQUEST['sort'] == 'due_date')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>" width="20%">
			Due Date	
		</td>
                <td valign="top" class="col_head  <?= ($_REQUEST['sort'] == 'responsible')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>" width="20%">
			Assigned To
                </td>
		<td valign="top" class="col_head" width="15%">
			Action
		</td>
	</tr>
	<? if(mysql_num_rows($my) == 0)
	{ ?>
		<tr class="tr_bg">
			<td valign="top" class="col_head" colspan="4" align="center">
				No Records
			</td>
		</tr>
	<? 
	}
	else
	{
		while($myarray = mysql_fetch_array($my))
		{
			$type = '';
			$due = strtotime(date('Y-m-d',strtotime($myarray['due_date'])));
			$today = strtotime(date('Y-m-d'));
			if($due < $today){
			  $type = 'expired';
			}elseif($due == $today){
                          $type = 'today';
                        }
		?>
			<tr class="<?=$type;?> task_<?= $myarray["id"]; ?>" id="task_<?= $myarray["id"]; ?>" >
				<td class="status_col"><input type="checkbox" class="task_status" value="<?= $myarray["id"]; ?>" />
				<td valign="top">
					<?=st($myarray["task"]);?>
					<?php if($myarray['firstname']!='' && $myarray['lastname']!=''){
						echo ' (<a href="add_patient.php?ed='.$myarray['patientid'].'&preview=1&addtopat=1&pid='.$myarray['patientid'].'">'.$myarray['firstname'].' '. $myarray['lastname'].'</a>)';
					} ?>
				</td>
				<td class="due_date" valign="top">
					<?php if($type=='expired'){ ?>
						Over Due
					<?php }elseif($type=='today'){ ?>
						Today
					<?php }else{	?>	
					<?= date('m/d/Y', strtotime($myarray["due_date"]));?>&nbsp;
					<?php } ?>
				</td>
				<td valign="top">
					<?= $myarray["name"]; ?>
				</td>
				<td valign="top">
					<a href="#" onclick="loadPopup('add_task.php?id=<?= $myarray["id"]; ?>')" class="editlink" title="EDIT">
						Edit
					</a>
				</td>
			</tr>
	<? 	}
	}?>
</table>
<?php
$sql = "select dt.*, du.name from dental_task dt
        JOIN dental_users du ON dt.responsibleid=du.userid
   WHERE dt.status = '1' 
  ORDER BY due_date DESC";

$my=mysql_query($sql) or die(mysql_error());
?>
<br />
<span class="admin_head">Completed</span>
<table id="completed_tasks" width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center" >
        <tr class="tr_bg_h">
                <td valign="top" class="col_head  <?= ($_REQUEST['sort'] == 'task')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>" width="45%">
                        <a href="manage_tasks.php?sort=task&sortdir=<?php echo ($_REQUEST['sort']=='task'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Task</a>
                </td>
                <td valign="top" class="col_head  <?= ($_REQUEST['sort'] == 'due_date')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>" width="20%">
                        <a href="manage_tasks.php?sort=due_date&sortdir=<?php echo ($_REQUEST['sort']=='due_date'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Due Date</a>
                </td>
                <td valign="top" class="col_head  <?= ($_REQUEST['sort'] == 'responsible')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>" width="20%">
                        <a href="manage_tasks.php?sort=description&sortdir=<?php echo ($_REQUEST['sort']=='responsible'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Assigned To</a>
                </td>
                <td valign="top" class="col_head" width="15%">
                        Action
                </td>
        </tr>
        <? if(mysql_num_rows($my) == 0)
        { ?>
                <tr class="tr_bg">
                        <td valign="top" class="col_head" colspan="4" align="center">
                                No Records
                        </td>
                </tr>
        <?
        }
        else
        {
                while($myarray = mysql_fetch_array($my))
                {
                ?>
                        <tr class="<?=$tr_class;?> ">
                                <td valign="top">
                                        <?=st($myarray["task"]);?>&nbsp;
                                </td>
                                <td valign="top">
                                        <?= date('m/d/Y', strtotime($myarray["due_date"]));?>&nbsp;
                                </td>
                                <td valign="top">
                                        <?= $myarray["name"]; ?>
                                </td>
                                <td valign="top">
                                        <a href="#" onclick="loadPopup('add_task.php?id=<?= $myarray["id"]; ?>')" class="editlink" title="EDIT">
                                                Edit
                                        </a>
                                </td>
                        </tr>
        <?      }
        }?>
</table>


<div id="popupContact" style="width:750px;">
    <a id="popupContactClose"><button>X</button></a>
    <iframe id="aj_pop" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
</div>
<div id="backgroundPopup"></div>

<br /><br />	
<? include "includes/bottom.htm";?>
