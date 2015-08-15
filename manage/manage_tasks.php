<?php namespace Ds3\Libraries\Legacy; ?><?php 
include "includes/top.htm";
include_once('includes/constants.inc');

if(isset($_GET['delid'])){
  $del_sql = "UPDATE dental_task SET status=2 WHERE id='".mysqli_real_escape_string($con,$_GET['delid'])."'";
  $db->query($del_sql);
  ?>
  <script type="text/javascript">
    window.location = "manage_tasks.php";
  </script>
  <?php
  trigger_error("Die called", E_USER_ERROR);
}

$sql = "select dt.*, CONCAT(du.first_name, ' ', du.last_name) as name, p.firstname, p.lastname from dental_task dt
        	JOIN dental_users du ON dt.responsibleid=du.userid
        	LEFT JOIN dental_patients p ON p.patientid=dt.patientid
           WHERE (dt.status = '0' OR
        	dt.status IS NULL) AND ";
if(!empty($_GET['mine']) && $_GET['mine']==1){ 
  $sql .= " dt.responsibleid='".mysqli_real_escape_string($con,$_SESSION['userid'])."' ";
}else{
  $sql .= " (du.docid='".mysqli_real_escape_string($con,$_SESSION['docid'])."' OR du.userid='".mysqli_real_escape_string($con,$_SESSION['docid'])."') ";
}

if(isset($_REQUEST['sort1']) && $_REQUEST['sort1'] != ''){
  switch($_REQUEST['sort1']){
    case 'due_date':
      $sort = "due_date";
      break;
    case 'task':
      $sort = "task";
      break;
    case 'responsible':
      $sort = 'du.name';
      break;
  }
}else{
  $_REQUEST['sort1']='name';
  $_REQUEST['sortdir1']='DESC';
  $sort = "due_date";
}
if(isset($_REQUEST['sortdir1']) && $_REQUEST['sortdir1']){
  $dir = $_REQUEST['sortdir1'];
}else{
  $dir = 'DESC';
}
  $sql .= "ORDER BY ".$sort." ".$dir;

$rec_disp = 10;

if((!empty($_REQUEST["page1"])))
  $index_val = $_REQUEST["page1"];
else
  $index_val = 0;

$i_val = $index_val * $rec_disp;

$total_rec = $db->getNumberRows($sql);
$no_pages = $total_rec/$rec_disp;

$sql .= " limit ".$i_val.",".$rec_disp;
$my = $db->getResults($sql);
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
<?php if(!empty($_GET['mine']) && $_GET['mine']==1){ ?>
  <button onclick="window.location='manage_tasks.php'" class="addButton" style="float:right; margin-right: 10px;">Show All</button>
<?php }else{ ?>
  <button onclick="window.location='manage_tasks.php?mine=1'" class="addButton" style="float:right; margin-right: 10px;">Assigned to me</button>
<?php } ?>
<br />
<div align="center" class="red">
	<b><?php echo (!empty($_GET['msg']) ? $_GET['msg'] : '');?></b>
</div>
<span id="non_cp_pages" style="float:right; margin-right:20px;">
  Pages:
  <?php paging1($no_pages,$index_val,"sort1=".(!empty($_GET['sort1']) ? $_GET['sort1'] : '')."&sortdir1=".(!empty($_GET['sortdir1']) ? $_GET['sortdir1'] : '')."&page2=".(!empty($_GET['page2']) ? $_GET['page2'] : '')."&sort2=".(!empty($_GET['sort2']) ? $_GET['sort2'] : '')."&sortdir2=".(!empty($_GET['sortdir2']) ? $_GET['sortdir2'] : ''));?>
</span>


<table id="not_completed_tasks" width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center" >
	<tr class="tr_bg_h">
		<td width="2%" class="col_head">
		</td>
    <td valign="top" class="col_head  <?php echo ($_REQUEST['sort1'] == 'task')?'arrow_'.strtolower($_REQUEST['sortdir1']):''; ?>" width="45%">
      <a href="manage_tasks.php?sort2=<?php echo (!empty($_GET['sort2']) ? $_GET['sort2'] : ''); ?>&sortdir2=<?php echo (!empty($_GET['sortdir2']) ? $_GET['sortdir2'] : ''); ?>&page2=<?php echo (!empty($_GET['page2']) ? $_GET['page2'] : ''); ?>&sort1=task&sortdir1=<?php echo ($_REQUEST['sort1']=='task'&&$_REQUEST['sortdir1']=='ASC')?'DESC':'ASC'; ?>">Task</a>
    </td>
    <td valign="top" class="col_head  <?php echo ($_REQUEST['sort1'] == 'due_date')?'arrow_'.strtolower($_REQUEST['sortdir1']):''; ?>" width="20%">
      <a href="manage_tasks.php?sort2=<?php echo (!empty($_GET['sort2']) ? $_GET['sort2'] : ''); ?>&sortdir2=<?php echo (!empty($_GET['sortdir2']) ? $_GET['sortdir2'] : ''); ?>&page2=<?php echo (!empty($_GET['page2']) ? $_GET['page2'] : ''); ?>&sort1=due_date&sortdir1=<?php echo ($_REQUEST['sort1']=='due_date'&&$_REQUEST['sortdir1']=='ASC')?'DESC':'ASC'; ?>">Due Date</a>
    </td>
    <td valign="top" class="col_head  <?php echo ($_REQUEST['sort1'] == 'responsible')?'arrow_'.strtolower($_REQUEST['sortdir1']):''; ?>" width="20%">
      <a href="manage_tasks.php?sort2=<?php echo (!empty($_GET['sort2']) ? $_GET['sort2'] : ''); ?>&sortdir2=<?php echo (!empty($_GET['sortdir2']) ? $_GET['sortdir2'] : ''); ?>&page2=<?php echo (!empty($_GET['page2']) ? $_GET['page2'] : ''); ?>&sort1=responsible&sortdir1=<?php echo ($_REQUEST['sort1']=='responsible'&&$_REQUEST['sortdir1']=='ASC')?'DESC':'ASC'; ?>">Assigned To</a>
    </td>
		<td valign="top" class="col_head" width="15%">
			Action
		</td>
	</tr>
<?php 
if(count($my) == 0){ ?>
	<tr class="tr_bg">
		<td valign="top" class="col_head" colspan="4" align="center">
			No Records
		</td>
	</tr>
<?php 
} else {
  foreach ($my as $myarray) {
		$type = '';
		$due = strtotime(date('Y-m-d',strtotime($myarray['due_date'])));
		$today = strtotime(date('Y-m-d'));
		$tomorrow = strtotime(date('Y-m-d', mktime(0, 0, 0, date("m")  , date("d")+1, date("Y"))));
		if($due < $today){
		  $type = 'expired';
		}elseif($due == $today){
      $type = 'today';
    }elseif($due == $tomorrow){
		  $type = 'tomorrow';
		}?>
	<tr class="<?php echo $type;?> task_<?php echo $myarray["id"]; ?>" id="task_<?php echo $myarray["id"]; ?>" >
		<td class="status_col"><input type="checkbox" class="task_status" value="<?php echo $myarray["id"]; ?>" />
		<td valign="top">
			<?php echo st($myarray["task"]);
    if($myarray['firstname']!='' && $myarray['lastname']!=''){
			echo ' (<a href="add_patient.php?ed='.$myarray['patientid'].'&preview=1&addtopat=1&pid='.$myarray['patientid'].'">'.$myarray['firstname'].' '. $myarray['lastname'].'</a>)';
		} ?>
		</td>
		<td class="due_date" valign="top">
			<?php if($type=='expired'){ ?>
				Overdue
			<?php }elseif($type=='today'){ ?>
				Today
			<?php }elseif($type=='tomorrow'){ ?>
        Tomorrow
      <?php }else{	
        echo date('m/d/Y', strtotime($myarray["due_date"]));?>&nbsp;
			<?php } ?>
		</td>
		<td valign="top">
			<?php echo $myarray["name"]; ?>
		</td>
		<td valign="top">
			<a href="#" onclick="loadPopup('add_task.php?id=<?php echo $myarray["id"]; ?>')" class="editlink" title="EDIT">
				Edit
			</a>
		</td>
	</tr>
<?php 	
  }
}?>
</table>
<?php
$sql = "select dt.*, CONCAT(du.first_name, ' ', du.last_name) as name, p.firstname, p.lastname from dental_task dt
          JOIN dental_users du ON dt.responsibleid=du.userid
          LEFT JOIN dental_patients p ON p.patientid=dt.patientid
          WHERE dt.status = '1' AND ";
if(!empty($_GET['mine']) && $_GET['mine']==1){
  $sql .= " dt.responsibleid='".mysqli_real_escape_string($con,$_SESSION['userid'])."' ";
}else{
  $sql .= " (du.docid='".mysqli_real_escape_string($con,$_SESSION['docid'])."' OR du.userid='".mysqli_real_escape_string($con,$_SESSION['docid'])."') ";
}

if(isset($_REQUEST['sort2']) && $_REQUEST['sort2'] != ''){
  switch($_REQUEST['sort2']){
    case 'due_date':
      $sort = "due_date";
      break;
    case 'task':
      $sort = "task";
      break;
    case 'responsible':
      $sort = 'du.name';
      break;
  }
}else{
  $_REQUEST['sort2']='name';
  $_REQUEST['sortdir2']='DESC';
  $sort = "due_date";
}
if(isset($_REQUEST['sortdir2']) && $_REQUEST['sortdir2']){
  $dir = $_REQUEST['sortdir2'];
}else{
  $dir = 'DESC';
}
$sql .= "ORDER BY ".$sort." ".$dir;

$rec_disp = 10;

if(!empty($_REQUEST["page2"]))
  $index_val = $_REQUEST["page2"];
else
  $index_val = 0;

$i_val = $index_val * $rec_disp;

$total_rec = $db->getNumberRows($sql);
$no_pages = $total_rec/$rec_disp;

$sql .= " limit ".$i_val.",".$rec_disp;
$my = $db->getResults($sql);

?>
<br />
<span class="admin_head">Completed</span>
<span id="cp_pages" style="float:right; margin-right:20px;">
  Pages:
  <?php paging2($no_pages,$index_val,"sort1=".(!empty($_GET['sort1']) ? $_GET['sort1'] : '')."&sortdir1=".(!empty($_GET['sortdir1']) ? $_GET['sortdir1'] : '')."&page1=".(!empty($_GET['page1']) ? $_GET['page1'] : '')."&sort2=".(!empty($_GET['sort2']) ? $_GET['sort2'] : '')."&sortdir2=".(!empty($_GET['sortdir2']) ? $_GET['sortdir2'] : ''));?>
</span>
<table id="completed_tasks" width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center" >
  <tr class="tr_bg_h">
    <td valign="top" class="col_head  <?php echo ($_REQUEST['sort2'] == 'task')?'arrow_'.strtolower($_REQUEST['sortdir2']):''; ?>" width="45%">
      <a href="manage_tasks.php?sort1=<?php echo (!empty($_GET['sort1']) ? $_GET['sort1'] : ''); ?>&sortdir1=<?php echo (!empty($_GET['sortdir1']) ? $_GET['sortdir1'] : ''); ?>&page1=<?php echo (!empty($_GET['page1']) ? $_GET['page1'] : ''); ?>&sort2=task&sortdir2=<?php echo ($_REQUEST['sort2']=='task'&&$_REQUEST['sortdir2']=='ASC')?'DESC':'ASC'; ?>">Task</a>
    </td>
    <td valign="top" class="col_head  <?php echo ($_REQUEST['sort2'] == 'due_date')?'arrow_'.strtolower($_REQUEST['sortdir2']):''; ?>" width="20%">
      <a href="manage_tasks.php?sort1=<?php echo (!empty($_GET['sort1']) ? $_GET['sort1'] : ''); ?>&sortdir1=<?php echo (!empty($_GET['sortdir1']) ? $_GET['sortdir1'] : ''); ?>&page1=<?php echo (!empty($_GET['page1']) ? $_GET['page1'] : ''); ?>&sort2=due_date&sortdir2=<?php echo ($_REQUEST['sort2']=='due_date'&&$_REQUEST['sortdir2']=='ASC')?'DESC':'ASC'; ?>">Due Date</a>
    </td>
    <td valign="top" class="col_head  <?php echo ($_REQUEST['sort2'] == 'responsible')?'arrow_'.strtolower($_REQUEST['sortdir2']):''; ?>" width="20%">
      <a href="manage_tasks.php?sort1=<?php echo (!empty($_GET['sort1']) ? $_GET['sort1'] : ''); ?>&sortdir1=<?php echo (!empty($_GET['sortdir1']) ? $_GET['sortdir1'] : ''); ?>&page1=<?php echo (!empty($_GET['page1']) ? $_GET['page1'] : ''); ?>&sort2=responsible&sortdir2=<?php echo ($_REQUEST['sort2']=='responsible'&&$_REQUEST['sortdir2']=='ASC')?'DESC':'ASC'; ?>">Assigned To</a>
    </td>
    <td valign="top" class="col_head" width="15%">
      Action
    </td>
  </tr>
<?php 
if(count($my) == 0){ ?>
  <tr class="tr_bg">
    <td valign="top" class="col_head" colspan="4" align="center">
      No Records
    </td>
  </tr>
<?php
} else {
  foreach ($my as $myarray) {?>
  <tr class="<?php echo (!empty($tr_class) ? $tr_class : '');?> ">
    <td valign="top">
      <?php echo st($myarray["task"]);?>&nbsp;
      <?php 
    if($myarray['firstname']!='' && $myarray['lastname']!=''){
      echo ' (<a href="add_patient.php?ed='.$myarray['patientid'].'&preview=1&addtopat=1&pid='.$myarray['patientid'].'">'.$myarray['firstname'].' '. $myarray['lastname'].'</a>)';
    } ?>
    </td>
    <td valign="top">
      <?php echo date('m/d/Y', strtotime($myarray["due_date"]));?>&nbsp;
    </td>
    <td valign="top">
      <?php echo $myarray["name"]; ?>
    </td>
    <td valign="top">
      <a href="#" onclick="loadPopup('add_task.php?id=<?php echo $myarray["id"]; ?>')" class="editlink" title="EDIT">
        Edit
      </a>
    </td>
  </tr>
<?php
  }
}?>
</table>

<div id="popupContact" style="width:750px;">
    <a id="popupContactClose"><button>X</button></a>
    <iframe id="aj_pop" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
</div>
<div id="backgroundPopup"></div>

<br /><br />	
<?php include "includes/bottom.htm";?>
