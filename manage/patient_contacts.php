<?php
include_once "includes/similar.php";
?>
<style type="text/css">
.similar{ display:none; }
</style>
<?php
if(isset($_REQUEST['useid'])){
$u = $_REQUEST['useid'];
$pc = $_REQUEST['pcid'];

$pcsql = "SELECT patientid, contacttype FROM dental_patient_contacts WHERE id='".mysql_real_escape_string($pc)."'";
$pcq = mysql_query($pcsql);
$pcr = mysql_fetch_assoc($pcq);
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
mysql_query($psql);

$dsql = "DELETE FROM dental_patient_contacts WHERE id='".mysql_real_escape_string($pc)."'";
mysql_query($dsql);
?>  <script type="text/javascript">
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
  mysql_query($s); 
  $pc_id = mysql_insert_id();
$pcsql = "SELECT patientid, contacttype FROM dental_patient_contacts WHERE id='".mysql_real_escape_string($_REQUEST['createid'])."'";
$pcq = mysql_query($pcsql);
$pcr = mysql_fetch_assoc($pcq);
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
mysql_query($psql);
    $d = "DELETE FROM dental_patient_contacts where id='".mysql_real_escape_string($_REQUEST['createid'])."'";
  mysql_query($d);
  ?>
  <script type="text/javascript">
	//window.location = "add_contact.php?ed=<?= $pc_id; ?>";
  </script>
  <?php
}elseif(isset($_REQUEST['delid'])){
$dsql = "DELETE FROM dental_patient_contacts WHERE id='".mysql_real_escape_string($_REQUEST['delid'])."'";
mysql_query($dsql);
?>  <script type="text/javascript">
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
$my = mysql_query($sql);
$total_rec = mysql_num_rows($my);
$no_pages = $total_rec/$rec_disp;

$sql .= " limit ".$i_val.",".$rec_disp;
$my=mysql_query($sql) or die(mysql_error());


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
	<b><? echo $_GET['msg'];?></b>
</div>


<form name="sortfrm" action="<?=$_SERVER['PHP_SELF']?>" method="post">
<table width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center" >
	<? if($total_rec > $rec_disp) {?>
	<TR bgColor="#ffffff">
		<TD  align="right" colspan="15" class="bp">
			Pages:
			<?
				 paging($no_pages,$index_val,"");
			?>
		</TD>
	</TR>
	<? }?>
	<tr class="tr_bg_h">
		<td valign="top" class="col_head  <?= ($_REQUEST['sort'] == 'name')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>" width="20%">
			<a href="manage_patient_contacts.php?sort=name&sortdir=<?php echo ($_REQUEST['sort']=='name'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Contact Name</a>
		</td>
		<td valign="top" class="col_head  <?= ($_REQUEST['sort'] == 'address')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>" width="25%">
			<a href="manage_patient_contacts.php?sort=address&sortdir=<?php echo ($_REQUEST['sort']=='address'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Address</a>
		</td>
               <td valign="top" class="col_head  <?= ($_REQUEST['sort'] == 'phone')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>" width="10%">
                        <a href="manage_patient_contacts.php?sort=phone&sortdir=<?php echo ($_REQUEST['sort']=='phone'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Phone</a>
                </td>
               <td valign="top" class="col_head  <?= ($_REQUEST['sort'] == 'type')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>" width="10%">
                        <a href="manage_patient_contacts.php?sort=type&sortdir=<?php echo ($_REQUEST['sort']=='type'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Contact Type</a>
                </td>
		<td valign="top" class="col_head  <?= ($_REQUEST['sort'] == 'addedby')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>" width="10%">
                        <a href="manage_patient_contacts.php?sort=addedby&sortdir=<?php echo ($_REQUEST['sort']=='addedby'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Added By</a>
                </td>
                <td valign="top" class="col_head  <?= ($_REQUEST['sort'] == 'similar')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>" width="15%">
                        <a href="manage_patient_contacts.php?sort=similar&sortdir=<?php echo ($_REQUEST['sort']=='similar'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Similar Doctors</a>
                </td>
		<td valign="top" class="col_head" width="5%">
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
			$sim = similar_doctors($myarray['id']);
		?>
			<tr class="<?=$tr_class;?> <?= ($myarray['viewed'])?'':'unviewed'; ?>">
				<td valign="top">
					<?=st($myarray["firstname"]);?>&nbsp;
                    			<?=st($myarray["lastname"]);?> 
				</td>
				<td valign="top">
					<?= st($myarray["address1"]); ?>
                                        <?= st($myarray["address2"]); ?>
                                        <?= st($myarray["city"]); ?>,
                                        <?= st($myarray["state"]); ?>
                                        <?= st($myarray["zip"]); ?>
				</td>
                                <td valign="top">
					<?= st($myarray["phone"]); ?>
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
					<?= $myarray['patfirstname']." ".$myarray['patlastname']; ?>	
				</td>
				<td valign="top">
					<a href="#" <?= (count($sim))?'class="plus_count"':''; ?> onclick="$('.sim_<?= $myarray['id']; ?>').toggle();return false;"><?= count($sim); ?> <?= (count($sim)>0)?'(click to view)':'';?></a>
				</td>
				<td valign="top">
					<a href="#" onclick="loadPopup('view_patient_contact.php?id=<?= $myarray["id"]; ?>');return false;" class="editlink" title="EDIT">
					        View
					</a> 
                                        <a href="http://google.com/search?q=<?= $myarray["firstname"]; ?>+<?= $myarray["lastname"]; ?>+<?= $myarray["zip"]; ?>" target="_blank" class="editlink" title="SEARCH">
                                               Search 
                                        </a>
                                        <a href="manage_patient_contacts.php?delid=<?= $myarray["id"]; ?>" onclick="return confirm('Are you sure you want to delete this contact?')" class="dellink" title="DELETE">
                                                Delete 
                                        </a>

				</td>
			</tr>
			<?php 
			if(count($sim) > 0){ 
			    foreach($sim as $s){ ?>
				<tr class="similar sim_<?= $myarray['id']; ?>">
                                <td valign="top">
                                        <?=st($s["name"]);?>
                                </td>
                                <td valign="top">
                                        <?= st($s["address"]); ?>
                                </td>
                                <td valign="top">
                                        <?= st($s["phone"]); ?>
                                </td>
				<td>
				</td>
				<td valign="top">
					<a href="#" onclick="loadPopup('add_contact.php?ed=<?= $s['id']; ?>')" class="editlink">
                                                View
                                        </a>
					<a href="manage_patient_contacts.php?useid=<?= $s['id']; ?>&pcid=<?= $myarray['id']; ?>" class="editlink">
						Use
					</a>
				</td>
				</tr>
				<?php
			    }
			}  ?>
	<? 	}
	}?>
</table>
</form>


<br /><br />	
<?php } //END check for rows > 0 ?> 
