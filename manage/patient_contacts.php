<?php
include_once "includes/similar.php";
?>
<link rel="stylesheet" type="text/css" href="css/manage_display_similar.css">
<?php
if(isset($_REQUEST['useid'])){
	$u = $_REQUEST['useid'];
	$pc = $_REQUEST['pcid'];

	$pcsql = "SELECT patientid, contacttype FROM dental_patient_contacts WHERE id='".mysql_real_escape_string($pc)."'";
	$pcr = $db->getRow($pcsql);
	$psql = "UPDATE dental_patients SET ";
	switch($pcr['contacttype']){
		case '1':
			$psql .= " docsleep ";
			break;
		case '2':
			$psql .= " docpcp ";
			break;
		case '3':
			$psql .= " docdentist ";
			break;
		case '4':
			$psql .= " docent ";
			break;
		case '5':
			$psql .= " docmdother ";
			break;
	}
	$psql .= " = '".$u."' WHERE patientid='".$pcr['patientid']."' OR parent_patientid='".$pcr['patientid']."'";
	$db->query($psql);

	$dsql = "DELETE FROM dental_patient_contacts WHERE id='".mysql_real_escape_string($pc)."'";
	$db->query($dsql);
?>
<script type="text/javascript">
	window.location = "manage_patient_contacts.php";
</script>
<?php
}elseif(isset($_REQUEST['createid'])){

	$s = "INSERT INTO dental_contact (
			firstname,
			lastname,
			add1,
			add2,
			city,
			state,
			zip,
			phone1,
			docid) 
		SELECT 
			firstname, 
			lastname, 
			address1,
			address2,
			city,
			state,
			zip,
			phone,
			'".mysql_real_escape_string($_SESSION['docid'])."'
		FROM dental_patient_contacts
			WHERE id='".mysql_real_escape_string($_REQUEST['createid'])."'";

	$pc_id = $db->getInsertId($s);
	$pcsql = "SELECT patientid, contacttype FROM dental_patient_contacts WHERE id='".mysql_real_escape_string($_REQUEST['createid'])."'";
	$pcr = $db->getRow($pcsql);
	$psql = "UPDATE dental_patients SET ";
	switch($pcr['contacttype']){
		case '1':
			$psql .= " docsleep ";
			break;
		case '2':
			$psql .= " docpcp ";
			break;
		case '3':
			$psql .= " docdentist ";
			break;
		case '4':
			$psql .= " docent ";
			break;
		case '5':
			$psql .= " docmdother ";
			break;
	}
	$psql .= " = '".$pc_id."' WHERE patientid='".$pcr['patientid']."' OR parent_patientid='".$pcr['patientid']."'";
	$db->query($psql);
	$d = "DELETE FROM dental_patient_contacts where id='".mysql_real_escape_string($_REQUEST['createid'])."'";
	$db->query($d);
?>
<script type="text/javascript">
	//window.location = "add_contact.php?ed=<?php echo $pc_id; ?>";
</script>
<?php
}elseif(isset($_REQUEST['delid'])){
	$dsql = "DELETE FROM dental_patient_contacts WHERE id='".mysql_real_escape_string($_REQUEST['delid'])."'";
	$db->query($dsql);
?>
<script type="text/javascript">
	window.location = "manage_patient_contacts.php";
</script>
<?php
}

$rec_disp = 20;

if($_REQUEST["page"] != "")
	$index_val = $_REQUEST["page"];
else
	$index_val = 0;

if(isset($_REQUEST['sort'])){
	switch($_REQUEST['sort']){
		case 'address':
			$sort = "pc.address1";
			break;
		case 'name':
			$sort = "pc.lastname";
			break;
		case 'phone':
			$sort = 'pc.phone';
			break;
	}
}else{
	$_REQUEST['sort']='name';
	$_REQUEST['sortdir']='DESC';
	$sort = "pc.lastname";
}
if(isset($_REQUEST['sortdir'])){
	$dir = $_REQUEST['sortdir'];
}else{
	$dir = 'DESC';
}
	
$i_val = $index_val * $rec_disp;
$sql = "SELECT pc.id, pc.contacttype, pc.firstname, pc.lastname, pc.address1, pc.address2, pc.city, pc.state, pc.zip, pc.phone,
	p.firstname as patfirstname, p.lastname as patlastname
	FROM dental_patient_contacts pc 
	INNER JOIN dental_patients p ON pc.patientid=p.patientid
	WHERE p.docid='".$_SESSION['docid']."' AND
                p.patientid='".mysql_real_escape_string($_GET['pid'])."'";
$sql .= "ORDER BY ".$sort." ".$dir;
$total_rec = $db->getNumberRows($sql);
$no_pages = $total_rec/$rec_disp;

$sql .= " limit ".$i_val.",".$rec_disp;
$my = $db->getResults($sql);

if($total_rec > 0){
	if(isset($num_changes)){
		$num_changes += $total_rec;
	}
?>


<span class="admin_head">
	Manage Patient Contacts
</span>
<br />
<br />
&nbsp;

<br />
<div align="center" class="red">
	<b><?php echo $_GET['msg'];?></b>
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
		<td valign="top" class="col_head  <?php echo ($_REQUEST['sort'] == 'name')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>" width="20%">
			<a href="manage_patient_contacts.php?sort=name&sortdir=<?php echo ($_REQUEST['sort']=='name'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Contact Name</a>
		</td>
		<td valign="top" class="col_head  <?php echo ($_REQUEST['sort'] == 'address')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>" width="25%">
			<a href="manage_patient_contacts.php?sort=address&sortdir=<?php echo ($_REQUEST['sort']=='address'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Address</a>
		</td>
		<td valign="top" class="col_head  <?php echo ($_REQUEST['sort'] == 'phone')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>" width="10%">
			<a href="manage_patient_contacts.php?sort=phone&sortdir=<?php echo ($_REQUEST['sort']=='phone'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Phone</a>
		</td>
		<td valign="top" class="col_head  <?php echo ($_REQUEST['sort'] == 'type')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>" width="10%">
			<a href="manage_patient_contacts.php?sort=type&sortdir=<?php echo ($_REQUEST['sort']=='type'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Contact Type</a>
		</td>
		<td valign="top" class="col_head  <?php echo ($_REQUEST['sort'] == 'addedby')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>" width="10%">
			<a href="manage_patient_contacts.php?sort=addedby&sortdir=<?php echo ($_REQUEST['sort']=='addedby'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Added By</a>
		</td>
		<td valign="top" class="col_head  <?php echo ($_REQUEST['sort'] == 'similar')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>" width="15%">
			<a href="manage_patient_contacts.php?sort=similar&sortdir=<?php echo ($_REQUEST['sort']=='similar'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Similar Doctors</a>
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
			$sim = similar_doctors($myarray['id']);?>
	<tr class="<?php echo $tr_class;?> <?php echo ($myarray['viewed'])?'':'unviewed'; ?>">
		<td valign="top">
			<?php echo st($myarray["firstname"]);?>&nbsp;
			<?php echo st($myarray["lastname"]);?> 
		</td>
		<td valign="top">
			<?php echo st($myarray["address1"]); ?>
			<?php echo st($myarray["address2"]); ?>
			<?php echo st($myarray["city"]); ?>,
			<?php echo st($myarray["state"]); ?>
			<?php echo st($myarray["zip"]); ?>
		</td>
		<td valign="top">
			<?php echo st($myarray["phone"]); ?>
		</td>
		<td valign="top">
		<?php
			switch($myarray['contacttype']){
				case '1':
					echo "Sleep MD";
					break;
				case '2':
					echo "Primary Care MD";
					break;
				case '3':
					echo "Dentist";
					break;
				case '4':
					echo "ENT";
					break;
				default:
					echo "Unknown";
					break;
			}
		?>
		</td>
		<td valign="top">
			<?php echo $myarray['patfirstname']." ".$myarray['patlastname']; ?>	
		</td>
		<td valign="top">
			<a href="#" <?php echo (count($sim))?'class="plus_count"':''; ?> onclick="$('.sim_<?php echo $myarray['id']; ?>').toggle();return false;"><?php echo count($sim); ?> <?php echo (count($sim)>0)?'(click to view)':'';?></a>
		</td>
		<td valign="top">
			<a href="#" onclick="loadPopup('view_patient_contact.php?id=<?php echo $myarray["id"]; ?>');return false;" class="editlink" title="EDIT">
				View
			</a> 
			<a href="http://google.com/search?q=<?php echo $myarray["firstname"]; ?>+<?php echo $myarray["lastname"]; ?>+<?php echo $myarray["zip"]; ?>" target="_blank" class="editlink" title="SEARCH">
				Search 
			</a>
			<a href="manage_patient_contacts.php?delid=<?php echo $myarray["id"]; ?>" onclick="return confirm('Are you sure you want to delete this contact?')" class="dellink" title="DELETE">
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
			<a href="#" onclick="loadPopup('add_contact.php?ed=<?php echo $s['id']; ?>')" class="editlink">
			View
			</a>
			<a href="manage_patient_contacts.php?useid=<?php echo $s['id']; ?>&pcid=<?php echo $myarray['id']; ?>" class="editlink">
			Use
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


<br /><br />	
<?php } //END check for rows > 0 ?> 
