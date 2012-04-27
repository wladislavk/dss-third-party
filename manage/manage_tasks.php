<? 
require_once('includes/constants.inc');
include "includes/top.htm";


$sql = "select * from dental_task WHERE
docid = ".$_SESSION['docid']." ";
if(isset($_GET['status'])){
  $sql .= " AND status = '".mysql_real_escape_string($_GET['status'])."' ";
}
  $sql .= "ORDER BY due_date DESC";
$my = mysql_query($sql);
$total_rec = mysql_num_rows($my);

$my=mysql_query($sql) or die(mysql_error());

?>

<link rel="stylesheet" href="popup/popup.css" type="text/css" media="screen" />
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


<form name="sortfrm" action="<?=$_SERVER['PHP_SELF']?>" method="post">
<table width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center" >
	<tr class="tr_bg_h">
		<td valign="top" class="col_head  <?= ($_REQUEST['sort'] == 'task')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>" width="15%">
			<a href="manage_tasks.php?sort=task&sortdir=<?php echo ($_REQUEST['sort']=='task'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Task</a>
		</td>
		<td valign="top" class="col_head  <?= ($_REQUEST['sort'] == 'description')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>" width="35%">
			<a href="manage_tasks.php?sort=description&sortdir=<?php echo ($_REQUEST['sort']=='description'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Description</a>
		</td>
		<td valign="top" class="col_head  <?= ($_REQUEST['sort'] == 'due_date')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>" width="35%">
			<a href="manage_tasks.php?sort=due_date&sortdir=<?php echo ($_REQUEST['sort']=='due_date'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Due Date</a>	
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
					<?=st(substr($myarray["description"],0, 30));?>&nbsp;
                    <?=st($myarray["lastname"]);?> 
				</td>
				<td valign="top">
					<?= date('m/d/Y', strtotime($myarray["due_date"]));?>&nbsp;
				</td>
				<td valign="top">
					<a href="add_task.php?id=<?= $myarray["id"]; ?>" class="editlink" title="EDIT">
						View (still need implemented)
					</a>
				</td>
			</tr>
	<? 	}
	}?>
</table>
</form>


<div id="popupContact" style="width:750px;">
    <a id="popupContactClose"><button>X</button></a>
    <iframe id="aj_pop" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
</div>
<div id="backgroundPopup"></div>

<br /><br />	
<? include "includes/bottom.htm";?>
