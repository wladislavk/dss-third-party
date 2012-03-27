<? 
require_once('includes/constants.inc');
include "includes/top.htm";
include "includes/similar.php";
?>
<style type="text/css">
.similar{ display:none; }
</style>
<?php
if(isset($_REQUEST['useid'])){
$u = $_REQUEST['useid'];
$pc = $_REQUEST['pcid'];

$pcsql = "SELECT patientid, insurancetype FROM dental_patient_insurance WHERE id='".mysql_real_escape_string($pc)."'";
$pcq = mysql_query($pcsql);
$pcr = mysql_fetch_assoc($pcq);
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
mysql_query($psql);

$dsql = "DELETE FROM dental_patient_insurance WHERE id='".mysql_real_escape_string($pc)."'";
mysql_query($dsql);
?>  <script type="text/javascript">
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
		'".mysql_real_escape_string($_SESSION['docid'])."',
		'11'
	FROM dental_patient_insurance
		WHERE id='".mysql_real_escape_string($_REQUEST['createid'])."'";
  mysql_query($s); 
  $pc_id = mysql_insert_id();
$pcsql = "SELECT patientid, insurancetype FROM dental_patient_insurance WHERE id='".mysql_real_escape_string($_REQUEST['createid'])."'";
$pcq = mysql_query($pcsql);
$pcr = mysql_fetch_assoc($pcq);
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
mysql_query($psql);
    $d = "DELETE FROM dental_patient_insurance where id='".mysql_real_escape_string($_REQUEST['createid'])."'";
  mysql_query($d);
  ?>
  <script type="text/javascript">
	window.location = "add_contact.php?ed=<?= $pc_id; ?>";
  </script>
  <?php
}elseif(isset($_REQUEST['delid'])){
$dsql = "DELETE FROM dental_patient_insurance WHERE id='".mysql_real_escape_string($_REQUEST['delid'])."'";
mysql_query($dsql);
?>  <script type="text/javascript">
        window.location = "manage_patient_insurance.php";
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
    case 'company':
	$sort = "pi.company";
	break;
    case 'phone':
	$sort = 'pc.phone';
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
$sql = "SELECT pi.* FROM dental_patient_insurance pi INNER JOIN dental_patients p ON pi.patientid=p.patientid ";
  $sql .= "ORDER BY ".$sort." ".$dir;
$my = mysql_query($sql);
$total_rec = mysql_num_rows($my);
$no_pages = $total_rec/$rec_disp;

$sql .= " limit ".$i_val.",".$rec_disp;
$my=mysql_query($sql) or die(mysql_error());

?>

<link rel="stylesheet" href="popup/popup.css" type="text/css" media="screen" />
<script src="popup/jquery-1.2.6.min.js" type="text/javascript"></script>
<script src="popup/popup.js" type="text/javascript"></script>

<span class="admin_head">
	Manage Patient Insurance 
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
		<td valign="top" class="col_head  <?= ($_REQUEST['sort'] == 'company')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>" width="25%">
			<a href="manage_patient_insurance.php?sort=company&sortdir=<?php echo ($_REQUEST['sort']=='name'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Company</a>
		</td>
		<td valign="top" class="col_head  <?= ($_REQUEST['sort'] == 'address')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>" width="45%">
			<a href="manage_patient_insurance.php?sort=address&sortdir=<?php echo ($_REQUEST['sort']=='address'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Address</a>
		</td>
               <td valign="top" class="col_head  <?= ($_REQUEST['sort'] == 'phone')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>" width="15%">
                        <a href="manage_patient_insurance.php?sort=phone&sortdir=<?php echo ($_REQUEST['sort']=='phone'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Phone</a>
                </td>
                <td valign="top" class="col_head  <?= ($_REQUEST['sort'] == 'similar')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>" width="45%">
                        <a href="manage_patient_insurance.php?sort=similar&sortdir=<?php echo ($_REQUEST['sort']=='similar'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Similar Insurance</a>
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
			$sim = similar_insurance($myarray['id']);
		?>
			<tr class="<?=$tr_class;?> <?= ($myarray['viewed'])?'':'unviewed'; ?>">
				<td valign="top">
                    			<?=st($myarray["company"]);?> 
				</td>
				<td valign="top">
					<?= st($myarray["address1"]); ?>
                                        <?= st($myarray["address2"]); ?>
                                        <?= st($myarray["city"]); ?>,
                                        <?= st($myarray["state"]); ?>
                                        <?= st($myarray["zip"]); ?>
				</td>
                                <td valign="top">
					<span class="phonemask"><?= st($myarray["phone"]); ?></span>
                                </td>
				<td valign="top">
					<a href="#" onclick="$('.sim_<?= $myarray['id']; ?>').toggle();return false;"><?= count($sim); ?></a>
				</td>
				<td valign="top">
					<a href="#" onclick="loadPopup('view_patient_insurance.php?id=<?= $myarray["id"]; ?>')" class="editlink" title="EDIT">
					        View
					</a> 
                                        <a href="http://google.com/search?q=<?= $myarray["company"]; ?>+<?= $myarray["zip"]; ?>" target="_blank" class="editlink" title="EDIT">
                                               Confirm 
                                        </a>
                                        <a href="manage_patient_insurance.php?delid=<?= $myarray["id"]; ?>" onclick="return confirm('Are you sure you want to delete this insurance?')" class="dellink" title="DELETE">
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
					<a href="manage_patient_insurance.php?useid=<?= $s['id']; ?>&pcid=<?= $myarray['id']; ?>" class="editlink">
						Use
					</a>
                                        <a href="add_contact.php?ed=<?= $s['id']; ?>" class="editlink">
                                                View
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


<div id="popupContact" style="width:750px;">
    <a id="popupContactClose"><button>X</button></a>
    <iframe id="aj_pop" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
</div>
<div id="backgroundPopup"></div>

<br /><br />	
<? include "includes/bottom.htm";?>
