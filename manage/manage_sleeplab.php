<? 
include "includes/top.htm";

if($_REQUEST["delid"] != "")
{
	$del_sql = "delete from dental_sleeplab where sleeplabid='".$_REQUEST["delid"]."'";
	mysql_query($del_sql);
	
	$msg= "Deleted Successfully";
	?>
	<script type="text/javascript">
		//alert("Deleted Successfully");
		window.location="<?=$_SERVER['PHP_SELF']?>?msg=<?=$msg?>";
	</script>
	<?
	die();
}

$rec_disp = 20;

if($_REQUEST["page"] != "")
	$index_val = $_REQUEST["page"];
else
	$index_val = 0;


if(isset($_REQUEST['sort']) && $_REQUEST['sort'] != ''){
  switch($_REQUEST['sort']){
    case 'lab':
        $sort = "company";
        break;
    case 'name':
        $sort = "lastname";
        break;
  }
}else{
  $_REQUEST['sort']='company';
  $_REQUEST['sortdir']='ASC';
  $sort = "company";
}
if(isset($_REQUEST['sortdir']) && $_REQUEST['sortdir']){
  $dir = $_REQUEST['sortdir'];
}else{
  $dir = 'DESC';
}

	
$i_val = $index_val * $rec_disp;
$sql = "select * from dental_sleeplab where docid='".$_SESSION['docid']."' ";
if(isset($_GET['letter'])){
  $sql .= " AND company like '".mysql_real_escape_string($_GET['letter'])."%' ";
}
  $sql .= "ORDER BY ".$sort." ".$dir;

$my = mysql_query($sql);
$total_rec = mysql_num_rows($my);
$no_pages = $total_rec/$rec_disp;

$sql .= " limit ".$i_val.",".$rec_disp;
$my=mysql_query($sql) or die(mysql_error());
$num_sleeplab=mysql_num_rows($my);
?>

<link rel="stylesheet" href="admin/popup/popup.css" type="text/css" media="screen" />
<script src="admin/popup/popup.js" type="text/javascript"></script>

<span class="admin_head">
	Manage Sleep Lab
</span>
<br />
<br />
&nbsp;

<div align="right">
	<button onclick="Javascript: loadPopup('add_sleeplab.php');" class="addButton">
		Add New Sleep Lab
	</button>
	&nbsp;&nbsp;
</div>
<div class="letter_select">
<?php
  $letters = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');
  foreach($letters as $let){
        ?><a href="manage_sleeplab.php?letter=<?=$let;?>&sort=<?=$_GET['sort'];?>&sortdir=<?=$_GET['sortdir'];?>"><?=$let;?></a>
<?php
  }
?>
</div>
<br />
<div align="center" class="red">
	<b><? echo $_GET['msg'];?></b>
</div>

<form name="sortfrm" action="<?=$_SERVER['PHP_SELF']?>" method="post">
<table width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center" >
	<? if($total_rec > $rec_disp) {?>
	<TR bgColor="#ffffff">
		<TD  align="right" colspan="15" class="bp">
			Pages:
			<?
				 paging($no_pages,$index_val,"letter=".$_GET['letter']."&sort=".$_GET['sort']."&sortdir=".$_GET['sortdir']);
			?>
		</TD>        
	</TR>
	<? }?>
	<tr class="tr_bg_h">
                <td valign="top" class="col_head  <?= ($_REQUEST['sort'] == 'lab')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>" width="30%">
                        <a href="manage_sleeplab.php?sort=lab&sortdir=<?php echo ($_REQUEST['sort']=='lab'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Lab Name</a>
		</td>
                <td valign="top" class="col_head  <?= ($_REQUEST['sort'] == 'name')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>" width="40%">
                        <a href="manage_sleeplab.php?sort=name&sortdir=<?php echo ($_REQUEST['sort']=='name'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Name</a>
		</td>
		<td valign="top" class="col_head" width="10%">
			# Patients
		</td>
		<td valign="top" class="col_head" width="20%">
			Action
		</td>
	</tr>
	<? if(mysql_num_rows($my) == 0)
	{ ?>
		<tr class="tr_bg">
			<td valign="top" class="col_head" colspan="10" align="center">
				No Records
			</td>
		</tr>
	<? 
	}
	else
	{
		while($myarray = mysql_fetch_array($my))
		{
			if($myarray["status"] == 1)
			{
				$tr_class = "tr_active";
			}
			else
			{
				$tr_class = "tr_inactive";
			}
			
			$name = st($myarray['salutation'])." ".st($myarray['firstname'])." ".st($myarray['middlename'])." ".st($myarray['lastname']);
		?>
			<tr class="<?=$tr_class;?>">
				<td valign="top">
					<?=st($myarray["company"]);?>
				</td>
				<td valign="top">
					<?=$name;?>
				</td>
				<td valign="top">
					<?php
					$pat_sql = "SELECT p.* FROM dental_patients p
							INNER JOIN dental_summ_sleeplab s ON s.patiendid=p.patientid
							WHERE s.place = '".mysql_real_escape_string($myarray['sleeplabid'])."' GROUP BY p.patientid";
					$pat_q = mysql_query($pat_sql);
					?><a href="#" onclick="$('#pat_<?=$myarray["sleeplabid"];?>').toggle();return false;"><?= mysql_num_rows($pat_q); ?></a>
				</td>
				<td valign="top">
	                                        <a href="#" onclick="loadPopup('view_sleeplab.php?ed=<?=$myarray["sleeplabid"];?>')" class="editlink" title="EDIT">
                                                Quick View
                                        </a>	
					|
					<a href="Javascript:;"  onclick="Javascript: loadPopup('add_sleeplab.php?ed=<?=$myarray["sleeplabid"];?>');" class="editlink" title="EDIT">
						Edit 
					</a>
				</td>
			</tr>
			<tr id="pat_<?=$myarray["sleeplabid"];?>" style="display:none;">
			<td colspan="4">
				<h3>Patients</h3>
			<?php while($pat_r = mysql_fetch_assoc($pat_q)){ ?>
				<br /><a href="dss_summ.php?sect=sleep&pid=<?= $pat_r['patientid']; ?>"><?= $pat_r['firstname']." ".$pat_r['lastname']; ?></a>
			<?php } ?>
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
