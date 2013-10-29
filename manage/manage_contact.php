<? 
include "includes/top.htm";

if($_REQUEST["delid"] != "")
{

	delete_contact_letters($_REQUEST["delid"]);
	delete_contact_from_patients($_REQUEST["delid"]);
	$del_sql = "delete from dental_contact where contactid='".$_REQUEST["delid"]."'";
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

if($_REQUEST["inactiveid"] != "")
{


        $in_sql = "update dental_contact set status='2'  where contactid='".$_REQUEST["inactiveid"]."'";
        mysql_query($in_sql);
        delete_contact_letters($_REQUEST["inactiveid"]);
        $msg= "Set to inactive";
        ?>
        <script type="text/javascript">
                //alert("Deleted Successfully");
                window.location="<?=$_SERVER['PHP_SELF']?>?msg=<?=$msg?>";
        </script>
        <?
        die();
}

$rec_disp = 50;

if($_REQUEST["page"] != "")
	$index_val = $_REQUEST["page"];
else
	$index_val = 0;
	
$i_val = $index_val * $rec_disp;
$contact_type_holder = $_GET['contacttype'];
if(isset($contact_type_holder) && $contact_type_holder != ''){
$sql = "select * from dental_contact dc LEFT JOIN dental_contacttype dct ON dct.contacttypeid=dc.contacttypeid where docid='".$_SESSION['docid']."' and dct.contacttypeid='" . $contact_type_holder . "' AND merge_id IS NULL AND dc.status=1 ";
}elseif(isset($_GET['status']) && $_GET['status'] != ''){
$sql = "select * from dental_contact dc LEFT JOIN dental_contacttype dct ON dct.contacttypeid=dc.contacttypeid where docid='".$_SESSION['docid']."' AND merge_id IS NULL AND dc.status=".mysql_real_escape_string($_GET['status'])." ";
}else{
$sql = "select dc.*
 from dental_contact dc LEFT JOIN dental_contacttype dct ON dct.contacttypeid=dc.contacttypeid where docid='".$_SESSION['docid']."' AND merge_id IS NULL AND dc.status=1 ";
}
if(isset($_GET['letter'])){
  $sql .= "AND (dc.lastname LIKE '".mysql_real_escape_string($_GET['letter'])."%' OR
	(dc.lastname='' AND dc.company LIKE  '".mysql_real_escape_string($_GET['letter'])."%'))";
}
switch($_GET['sort']){
  case 'company':
    $sql .= " ORDER BY company ".$_GET['sortdir'];
    break;
  case 'type':
    $sql .= " ORDER BY dct.contacttype ".$_GET['sortdir'];
    break;
  default:
    $sql .= " ORDER BY lastname ".$_GET['sortdir'].", firstname ".$_GET['sortdir'];
    break;
}
$my = mysql_query($sql);
$total_rec = mysql_num_rows($my);
$no_pages = $total_rec/$rec_disp;

$sql .= " limit ".$i_val.",".$rec_disp;
$my=mysql_query($sql) or die(mysql_error());
$num_contact=mysql_num_rows($my);

// Select Contact Types
$contact_types = "SELECT contacttypeid, contacttype FROM dental_contacttype;";
$result = mysql_query($contact_types);
while ($row = mysql_fetch_assoc($result)) {
	$contact_type[$row['contacttypeid']] = $row['contacttype'];
}
?>

<link rel="stylesheet" href="admin/popup/popup.css" type="text/css" media="screen" />
<script src="admin/popup/popup.js" type="text/javascript"></script>

<span class="admin_head">
	Manage Contact
</span>
<br />
<br />
&nbsp;

<div style="margin-left:10px;margin-right:10px;">
<?php 
$ctype_sql = "select * from dental_contacttype where status=1 order by sortby";
$ctype_my = mysql_query($ctype_sql);
?>
<style>
#contentMain tr:hover{
background:#cccccc;
}

#contentMain td:hover{
background:#999999;
}
</style>
<form name="jump1" style="float:left; width:350px;">
Filter by type: <select name="myjumpbox"
 OnChange="location.href=jump1.myjumpbox.options[selectedIndex].value">
     <option selected>Please Select...</option>
     <option value="manage_contact.php">Display All</option>
      <? while($ctype_myarray = mysql_fetch_array($ctype_my))
									{?>
                                    	<option value="manage_contact.php?contacttype=<?=st($ctype_myarray['contacttypeid']);?>">
                                        	<?=st($ctype_myarray['contacttype']);?>
                                        </option>
                    <?php } ?>
     <option value="manage_contact.php?status=2">In-active</option>
</select>
</form>
<br /><br />
             Search Contacts: <input type="text" id="contact_name" style="width:300px;" onclick="updateval(this)" autocomplete="off" name="contact_name" value="Type contact name" />
<br />        <div id="contact_hints" class="search_hints" style="display:none;">
                <ul id="contact_list" class="search_list">
                        <li class="template" style="display:none">Doe, John S</li>
                </ul>
		</div>
<script type="text/javascript">
$(document).ready(function(){
  setup_autocomplete('contact_name', 'contact_hints', 'contact', '', 'list_contacts_and_companies.php');
});
</script>



	<button style="margin-right:10px; float:right;" onclick="loadPopup('add_contact.php')" class="addButton">
		Add New Contact
	</button>
	&nbsp;&nbsp;
</div>
<br />
<div align="center" class="red">
	<b><? echo $_GET['msg'];?></b>
</div>
<form name="sortfrm" action="<?=$_SERVER['PHP_SELF']?>" method="post">
<table width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center" >
	<TR bgColor="#ffffff">
<td colspan="2">
<div class="letter_select">
<?php
  $letters = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');
  foreach($letters as $let){
        ?><a <?= ($_GET['letter']==$let)?'class="selected_letter"':''; ?> href="manage_contact.php?letter=<?=$let;?>&status=<?=$_GET['status'];?>&sort=<?=$_GET['sort'];?>&sortdir=<?=$_GET['sortdir'];?>&contacttype=<?= $_GET['contacttype'];?>"><?=$let;?></a>
<?php
  }
if(isset($_GET['letter']) && $_GET['letter'] != ''){
?><a href="manage_contact.php?status=<?=$_GET['status'];?>&sort=<?=$_GET['sort'];?>&sortdir=<?=$_GET['sortdir'];?>&contacttype=<?= $_GET['contacttype'];?>">Show All</a>
<?php } ?>
</div>
</td>
		<TD  align="right" colspan="15" class="bp">
<? if($total_rec > $rec_disp) {?>
			Pages:
			<?
				 paging($no_pages,$index_val,"letter=".$_GET['letter']."&status=".$_GET['status']."&sort=".$_GET['sort']."&sortdir=".$_GET['sortdir']."&contacttype=".$_GET['contacttype']);
}
			?>
		</TD>        
	</TR>
	<tr class="tr_bg_h">
                <td valign="top" class="col_head  <?= ($_REQUEST['sort'] == 'name')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>" width="20%">
                        <a href="manage_contact.php?sort=name&sortdir=<?php echo ($_REQUEST['sort']=='name'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Name</a>
                </td>
                <td valign="top" class="col_head  <?= ($_REQUEST['sort'] == 'company')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>" width="25%">
                        <a href="manage_contact.php?sort=company&sortdir=<?php echo ($_REQUEST['sort']=='company'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Company</a>
                </td>
                <td valign="top" class="col_head  <?= ($_REQUEST['sort'] == 'type')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>" width="25%">
                        <a href="manage_contact.php?sort=type&sortdir=<?php echo ($_REQUEST['sort']=='type'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Contact Type</a>
                </td>
		<td valign="top" class="col_head" width="10%">
			Referrer
		</td>
                <td valign="top" class="col_head" width="10%">
                        Patients
                </td>
		<td valign="top" class="col_head" width="20%">
			Action
		</td>
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
			
			$name = st($myarray['lastname'])." ".st($myarray['middlename']).", ".st($myarray['firstname']);
		?>
			<tr class="<?=$tr_class;?>">
				<td valign="top" width="20%">
					<?=$name;?>
				</td>
				<td valign="top" width="25%">
					<?=st($myarray["company"]);?>
				</td>
				<td valign="top" width="25%">
				<?php print ($contact_type[$myarray["contacttypeid"]]) ? $contact_type[$myarray["contacttypeid"]] : "Contact Type Not Set"; ?>
				<?php /*
				<?php if($myarray["contacttypeid"] == '6'){echo "Attorney";} ?>
				<?php if($myarray["contacttypeid"] == '7'){echo "Consult";} ?>
				<?php if($myarray["contacttypeid"] == '8'){echo "Guardian";} ?>
				<?php if($myarray["contacttypeid"] == '9'){echo "Hospital";} ?>
				<?php if($myarray["contacttypeid"] == '10'){echo "Independent Medical Exam";} ?>
				<?php if($myarray["contacttypeid"] == '11'){echo "Insurance";} ?>
				<?php if($myarray["contacttypeid"] == '13'){echo "Parent";} ?>
				<?php if($myarray["contacttypeid"] == '14'){echo "Patient";} ?>
				<?php if($myarray["contacttypeid"] == '15'){echo "Provider";} ?>
				<?php if($myarray["contacttypeid"] == '16'){echo "Recall";} ?>
				<?php if($myarray["contacttypeid"] == '17'){echo "Referred From";} ?>
				<?php if($myarray["contacttypeid"] == '18'){echo "Refered To";} ?>
				<?php if($myarray["contacttypeid"] == '19'){echo "Unknown";} ?>
				<?php if($myarray["contacttypeid"] == '12'){echo "Other";} ?>
				<?php if($myarray["contacttypeid"] == '0'){echo "Type Not Set";} ?>
				*/ ?>
	      </td>
				<td valign="top" width="10%">
<?php
       	$ref_sql = "SELECT * FROM dental_patients WHERE (parent_patientid IS NULL OR parent_patientid='') AND referred_source=2 AND referred_by='".mysql_real_escape_string($myarray['contactid'])."'";
       	$ref_q = mysql_query($ref_sql);
       	$num_ref = mysql_num_rows($ref_q);
                //(SELECT COUNT(*) FROM dental_patients WHERE docpcp=dc.contactid OR docent = dc.contactid OR docsleep=) as patients,
?>
				<?= ($num_ref)?'<a href="#" onclick="$(\'#ref_pat_'.$myarray['contactid'].'\').toggle();return false;">'.$num_ref.'</a>':''; ?>
				</td>
                                <td valign="top" width="10%">
<?php
        $pat_sql = "SELECT * FROM dental_patients WHERE (parent_patientid IS NULL OR parent_patientid='') AND (docpcp='".mysql_real_escape_string($myarray['contactid'])."' OR docent = '".mysql_real_escape_string($myarray['contactid'])."' OR docsleep='".mysql_real_escape_string($myarray['contactid'])."' OR docdentist='".mysql_real_escape_string($myarray['contactid'])."' OR docmdother='".mysql_real_escape_string($myarray['contactid'])."' OR docmdother2 = '".mysql_real_escape_string($myarray['contactid'])."' OR docmdother3='".mysql_real_escape_string($myarray['contactid'])."')";
        $pat_q = mysql_query($pat_sql);
        $num_pat = mysql_num_rows($pat_q);
                //(SELECT COUNT(*) FROM dental_patients WHERE docpcp=dc.contactid OR docent = dc.contactid OR docsleep=) as patients,
?>
                                <?= ($num_pat)?'<a href="#" onclick="$(\'#ref_pat_'.$myarray['contactid'].'\').toggle();return false;">'.$num_pat.'</a>':''; ?>
                                </td>
				<td valign="top" width="20%">
				        <a href="#" onclick="loadPopup('view_contact.php?ed=<?=$myarray["contactid"];?>')" class="editlink" title="EDIT">
                                                Quick View
                                        </a>
					|
					<a href="#" onclick="loadPopup('add_contact.php?ed=<?=$myarray["contactid"];?>')" class="editlink" title="EDIT">
						Edit 
					</a>
                    
				</td>
			</tr>
			<tr id="ref_pat_<?= $myarray['contactid'];?>" style="display:none;">
				<td colspan="2" valign="top">
			<strong>REFERRED</strong><br />
		<?php
			while($ref = mysql_fetch_assoc($ref_q)){
				?><a href="add_patient.php?pid=<?= $ref['patientid'];?>&ed=<?= $ref['patientid'];?>"><?= $ref['firstname']." ".$ref['lastname']; ?><br /><?php
			
			}
		?>
				</td>
                                <td colspan="4" valign="top">
                        <strong>PATIENTS</strong><br />
                <?php
                        while($pat = mysql_fetch_assoc($pat_q)){
                                ?><a href="add_patient.php?pid=<?= $pat['patientid'];?>&ed=<?= $pat['patientid'];?>"><?= $pat['firstname']." ".$pat['lastname']; ?><br /><?php
                        
                        }
                ?>
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
<div id="popupRefer" style="height:550px; width:750px;">
    <a id="popupReferClose"><button>X</button></a>
    <iframe id="aj_ref" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
</div>
<div id="backgroundPopupRef"></div>
<br /><br />	
<? include "includes/bottom.htm";?>
