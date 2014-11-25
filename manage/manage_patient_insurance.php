<?php
include "includes/top.htm";
include "includes/similar.php";
require_once('includes/constants.inc');
?>

<link rel="stylesheet" type="text/css" href="css/manage_display_similar.css">

<?php
if(isset($_REQUEST['useid'])){
	$u = $_REQUEST['useid'];
	$pc = $_REQUEST['pcid'];

	$pcsql = "SELECT patientid, insurancetype FROM dental_patient_insurance WHERE id='".mysqli_real_escape_string($con,$pc)."'";
	$pcr = $db->getRow($pcsql);
	$psql = "UPDATE dental_patients SET ";
	switch($pcr['insurancetype']){
		case '1':
			$psql .= " p_m_ins_co ";
			break;
		case '2':
			$psql .= " s_m_ins_co ";
			break;
	}
	$psql .= " = '".$u."' WHERE patientid='".$pcr['patientid']."' OR parent_patientid='".$pcr['patientid']."'";
	$db->query($psql);

	$dsql = "DELETE FROM dental_patient_insurance WHERE id='".mysqli_real_escape_string($con,$pc)."'";
	$db->query($dsql);
?>
<script type="text/javascript">
	window.location = "manage_patient_insurance.php";
</script>
<?php
}elseif(isset($_REQUEST['createid'])){

  $s = "INSERT INTO dental_contact (
		company,
		add1,
		add2,
		city,
		state,
		zip,
		phone1,
		docid,
		contacttypeid) 
	SELECT 
		company, 
		address1,
		address2,
		city,
		state,
		zip,
		phone,
		'".mysqli_real_escape_string($con,$_SESSION['docid'])."',
		'11'
	FROM dental_patient_insurance
		WHERE id='".mysqli_real_escape_string($con,$_REQUEST['createid'])."'";

	$pc_id = $db->getInsertId($s);
	$pcsql = "SELECT patientid, insurancetype FROM dental_patient_insurance WHERE id='".mysqli_real_escape_string($con,$_REQUEST['createid'])."'";
	$pcr = $db->getRow($pcsql);
	$psql = "UPDATE dental_patients SET ";
	switch($pcr['insurancetype']){
		case '1':
			$psql .= " p_m_ins_co ";
			break;
		case '2':
			$psql .= " s_m_ins_co ";
			break;
	}
	$psql .= " = '".$pc_id."' WHERE patientid='".$pcr['patientid']."' OR parent_patientid='".$pcr['patientid']."'";
	echo $psql;
	$db->query($psql);
	$d = "DELETE FROM dental_patient_insurance where id='".mysqli_real_escape_string($con,$_REQUEST['createid'])."'";
	$db->query($d);
?>
<script type="text/javascript">
	window.location = "add_contact.php?ed=<?php echo $pc_id; ?>";
</script>
<?php
}elseif(isset($_REQUEST['delid'])){
	$pcsql = "SELECT patientid, insurancetype FROM dental_patient_insurance WHERE id='".mysqli_real_escape_string($con,$_REQUEST['delid'])."'";
	$pcr = $db->getRow($pcsql);
	$dsql = "DELETE FROM dental_patient_insurance WHERE id='".mysqli_real_escape_string($con,$_REQUEST['delid'])."'";
	$db->query($dsql);
?>  
<script type="text/javascript">
	window.location = "patient_changes.php?pid=<?php echo $pcr['patientid']; ?>";
</script>
<?php
}

$rec_disp = 20;

if(!empty($_REQUEST["page"]))
	$index_val = $_REQUEST["page"];
else
	$index_val = 0;

if(isset($_REQUEST['sort'])){
	switch($_REQUEST['sort']){
		case 'address':
			$sort = "pi.address1";
			break;
		case 'company':
			$sort = "pi.company";
			break;
		case 'phone':
			$sort = 'pi.phone';
			break;
		case 'addedby';
			$sort = "p.lastname";
			break;
		default:
			$sort = "pi.company";
			break;
	}
}else{
	$_REQUEST['sort']='company';
	$_REQUEST['sortdir']='DESC';
	$sort = "pi.company";
}
if(isset($_REQUEST['sortdir'])){
	$dir = $_REQUEST['sortdir'];
}else{
	$dir = 'DESC';
}
	
$i_val = $index_val * $rec_disp;
$sql = "SELECT pi.*, p.firstname as patfirstname, p.lastname as patlastname FROM dental_patient_insurance pi INNER JOIN dental_patients p ON pi.patientid=p.patientid 
        WHERE p.docid='".$_SESSION['docid']."' ";
$sql .= "ORDER BY ".$sort." ".$dir;
$total_rec = $db->getNumberRows($sql);
$no_pages = $total_rec/$rec_disp;

$sql .= " limit ".$i_val.",".$rec_disp;
$my = $db->getResults($sql);
?>

<link rel="stylesheet" href="admin/popup/popup.css" type="text/css" media="screen" />
<script src="admin/popup/popup.js" type="text/javascript"></script>

<span class="admin_head">
	Manage Patient Insurance 
</span>
<br />
<br />
&nbsp;

<br />
<div align="center" class="red">
	<b><?php echo (!empty($_GET['msg']) ? $_GET['msg'] : '');?></b>
</div>


<form name="sortfrm" action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
<table width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center" >
	<?php if($total_rec > $rec_disp) {?>
	<TR bgColor="#ffffff">
		<TD  align="right" colspan="15" class="bp">
			Pages:
			<?php
				 paging($no_pages,$index_val,"");
			?>
		</TD>
	</TR>
	<?php }?>
	<tr class="tr_bg_h">
		<td valign="top" class="col_head  <?php echo ($_REQUEST['sort'] == 'company')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>" width="20%">
			<a href="manage_patient_insurance.php?sort=company&sortdir=<?php echo ($_REQUEST['sort']=='name'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Company</a>
		</td>
		<td valign="top" class="col_head  <?php echo ($_REQUEST['sort'] == 'address')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>" width="25%">
			<a href="manage_patient_insurance.php?sort=address&sortdir=<?php echo ($_REQUEST['sort']=='address'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Address</a>
		</td>
		<td valign="top" class="col_head  <?php echo ($_REQUEST['sort'] == 'phone')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>" width="10%">
			<a href="manage_patient_insurance.php?sort=phone&sortdir=<?php echo ($_REQUEST['sort']=='phone'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Phone</a>
		</td>
		<td valign="top" class="col_head  <?php echo ($_REQUEST['sort'] == 'addedby')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>" width="10%">
			<a href="manage_patient_insurance.php?sort=addedby&sortdir=<?php echo ($_REQUEST['sort']=='addedby'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Added By</a>
		</td>
		<td valign="top" class="col_head  <?php echo ($_REQUEST['sort'] == 'similar')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>" width="15%">
			<a href="manage_patient_insurance.php?sort=similar&sortdir=<?php echo ($_REQUEST['sort']=='similar'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Similar Insurance</a>
		</td>
		<td valign="top" class="col_head" width="5%">
			Action
		</td>
	</tr>
	<?php if(count($my) == 0){ ?>
	<tr class="tr_bg">
		<td valign="top" class="col_head" colspan="4" align="center">
			No Records
		</td>
	</tr>
	<?php 
	}
	else
	{
		foreach ($my as $myarray) {
			$sim = similar_insurance($myarray['id']);?>
	<tr class="<?php echo (!empty($tr_class) ? $tr_class : '');?> <?php echo (!empty($myarray['viewed']))?'':'unviewed'; ?>">
		<td valign="top">
			<?php echo st($myarray["company"]);?> 
		</td>
		<td valign="top">
			<?php echo st($myarray["address1"]); ?>
			<?php echo st($myarray["address2"]); ?>
			<?php echo st($myarray["city"]); ?>,
			<?php echo st($myarray["state"]); ?>
			<?php echo st($myarray["zip"]); ?>
		</td>
		<td valign="top">
			<span class="phonemask"><?php echo st($myarray["phone"]); ?></span>
		</td>
		<td valign="top">
			<?php echo st($myarray["patfirstname"]." ".$myarray["patlastname"]); ?>
		</td>
		<td valign="top">
			<a href="#" <?php echo (count($sim))?'class="plus_count"':''; ?> onclick="$('.sim_<?php echo $myarray['id']; ?>').toggle();return false;"><?php echo count($sim); ?> <?php echo (count($sim)>0)?'(click to view)':'';?></a>
		</td>
		<td valign="top">
			<a href="#" onclick="loadPopup('view_patient_insurance.php?id=<?php echo $myarray["id"]; ?>')" class="editlink" title="EDIT">
				View
			</a> 
			<a href="http://google.com/search?q=<?php echo $myarray["company"]; ?>+<?php echo $myarray["zip"]; ?>" target="_blank" class="editlink" title="EDIT">
				Search 
			</a>
			<a href="manage_patient_insurance.php?delid=<?php echo $myarray["id"]; ?>" onclick="return confirm('Are you sure you want to delete this insurance?')" class="dellink" title="DELETE">
				Delete 
			</a>
		</td>
	</tr>
			<?php 
			if(count($sim) > 0){ 
			    foreach($sim as $s){ ?>
	<tr class="similar sim_<?php echo $myarray['id']; ?>">
		<td valign="top">
			<?php echo st($s["name"]);?>
		</td>
		<td valign="top">
			<?php echo st($s["address"]); ?>
		</td>
		<td valign="top">
			<?php echo st($s["phone"]); ?>
		</td>
		<td>
		</td>
		<td valign="top">
			<a href="manage_patient_insurance.php?useid=<?php echo $s['id']; ?>&pcid=<?php echo $myarray['id']; ?>" class="editlink">
				Use
			</a>
			<a href="#" onclick="loadPopup('add_contact.php?ed=<?php echo $s['id']; ?>')" class="editlink">
				View
			</a>
		</td>
	</tr>
				<?php
			    }
			}  
	 	}
	}?>
</table>
</form>


<div id="popupContact" style="width:750px;">
    <a id="popupContactClose"><button>X</button></a>
    <iframe id="aj_pop" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
</div>
<div id="backgroundPopup"></div>

<br /><br />	
<?php include "includes/bottom.htm";?>
