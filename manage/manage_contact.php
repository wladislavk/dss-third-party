<?php namespace Ds3\Libraries\Legacy; ?><?php 
	include "includes/top.htm";

use Illuminate\Support\Facades\Input as Input;

$contactType = Input::get('contacttype', '');
$byLetter = strtoupper(Input::get('letter', ''));
$sortBy = Input::get('sort', 'name');
$sortDir = strtoupper(Input::get('sortdir', 'asc'));

$byLetter = preg_replace('/[^a-z]+/i', '', $byLetter);
$sortBy = $sortBy ?: ($byLetter ? 'name' : '');
$sortDir = $sortDir === 'ASC' ? 'ASC' : 'DESC';

	if (!empty($_REQUEST["delid"])) {
		delete_contact_letters($_REQUEST["delid"]);
		delete_contact_from_patients($_REQUEST["delid"]);
		$del_sql = "delete from dental_contact where contactid='" . $_REQUEST["delid"] . "'";
		$db->query($del_sql);
		
		$msg= "Deleted Successfully";
?>
		<script type="text/javascript">
			window.location="<?php echo $_SERVER['PHP_SELF']?>?msg=<?php echo $msg?>";
		</script>
<?php
		trigger_error("Die called", E_USER_ERROR);
	}
?>

<?php 
	if (!empty($_REQUEST["inactiveid"])) {
	    $in_sql = "update dental_contact set status='2'  where contactid='" . $_REQUEST["inactiveid"] . "'";
	    $db->query($in_sql);
	    delete_contact_letters($_REQUEST["inactiveid"]);
	    $msg= "Set to inactive";
?>
	    <script type="text/javascript">
	        window.location="<?php echo $_SERVER['PHP_SELF']; ?>?msg=<?php echo $msg; ?>";
	    </script>
<?php
		trigger_error("Die called", E_USER_ERROR);
	}
?>

<?php
	$rec_disp = 50;

	if (!empty($_REQUEST["page"])) {
		$index_val = $_REQUEST["page"];
	} else {
		$index_val = 0;
	}
		
	$i_val = $index_val * $rec_disp;
	$contact_type_holder = $contactType;

	if (isset($contact_type_holder) && $contact_type_holder != '') {
		$sql = "select * from dental_contact dc LEFT JOIN dental_contacttype dct ON dct.contacttypeid=dc.contacttypeid where docid='" . $_SESSION['docid'] . "' and dct.contacttypeid='" . $db->escape($contact_type_holder) . "' AND merge_id IS NULL AND dc.status=1 ";
	} elseif (isset($_GET['status']) && $_GET['status'] != '') {
		$sql = "select * from dental_contact dc LEFT JOIN dental_contacttype dct ON dct.contacttypeid=dc.contacttypeid where docid='" . $_SESSION['docid'] . "' AND merge_id IS NULL AND dc.status=" . $db->escape($_GET['status']) . " ";
	} else {
		$sql = "select dc.*
	 		from dental_contact dc LEFT JOIN dental_contacttype dct ON dct.contacttypeid=dc.contacttypeid where docid='" . $_SESSION['docid'] . "' AND merge_id IS NULL AND dc.status=1 ";
	}

	if (isset($_GET['letter'])) {
	  $sql .= "AND (dc.lastname LIKE '" . $db->escape($_GET['letter']) . "%' OR
		(dc.lastname='' AND dc.company LIKE  '" . $db->escape($_GET['letter']) . "%'))";
	}

	if ($sortBy) {
		switch ($sortBy) {
		  case 'company':
		    $sql .= " ORDER BY company $sortDir, lastname ASC, firstname ASC, dct.contacttype ASC";
		    break;
		  case 'type':
		    $sql .= " ORDER BY dct.contacttype $sortDir, lastname ASC, firstname ASC, company ASC";
		    break;
		  default:
		    $sql .= " ORDER BY lastname $sortDir, firstname $sortDir, company ASC, dct.contacttype ASC";
		    break;
		}
	}

	$total_rec = $db->getNumberRows($sql);

	$no_pages = $total_rec/$rec_disp;

	$sql .= " limit " . $i_val . "," . $rec_disp;
	$my = $db->getResults($sql);
	$num_contact = count($my);

	// Select Contact Types
	$contact_types = "SELECT contacttypeid, contacttype FROM dental_contacttype;";

	$result = $db->getResults($contact_types);
	foreach ($result as $row) {
		$contact_type[$row['contacttypeid']] = $row['contacttype'];
	}
?>

	<link rel="stylesheet" href="admin/popup/popup.css" type="text/css" media="screen" />
	<link rel="stylesheet" href="css/manage.css" type="text/css" media="screen" />
	<script src="admin/popup/popup.js" type="text/javascript"></script>

	<span class="admin_head">Manage Contact</span><br /><br />&nbsp;

	<div style="margin-left:10px;margin-right:10px;">

		<?php 
			$ctype_sql = "select * from dental_contacttype where status=1 AND corporate='0' order by sortby";
			$ctype_myarray = $db->getResults($ctype_sql);
		?>
		
		<form name="jump1" style="float:left; width:350px;">
			Filter by type:
			<select name="myjumpbox" OnChange="location.href=jump1.myjumpbox.options[jump1.myjumpbox.selectedIndex].value">
		    	<option selected>Please Select...</option>
		     	<option value="manage_contact.php">Display All</option>

		      	<?php foreach ($ctype_myarray as $value): ?>
		            <option value="manage_contact.php?contacttype=<?php echo st((!empty($value['contacttypeid']) ? $value['contacttypeid'] : '')); ?>">
		               	<?php echo st($value['contacttype']); ?>
		            </option>
		        <?php endforeach ?>

		     	<option value="manage_contact.php?status=2">In-active</option>
			</select>
		</form>

		<br /><br />

	    Search Contacts:
	    <input type="text" id="contact_name" style="width:300px;" onclick="updateval(this)" autocomplete="off" name="contact_name" value="Type contact name" /><br />
	    
	    <div id="contact_hints" class="search_hints" style="display:none;">
	        <ul id="contact_list" class="search_list">
	            <li class="template" style="display:none">Doe, John S</li>
	        </ul>
		</div>

		<script src="js/manage_contact.js" type="text/javascript"></script>

		<button style="margin-right:10px; float:right;" onclick="loadPopup('add_contact.php')" class="addButton">
			Add New Contact
		</button>
		&nbsp;&nbsp;
	</div>

	<br />

	<div align="center" class="red">
		<b><?php echo (!empty($_GET['msg']) ? $_GET['msg'] : ''); ?></b>
	</div>

	<form name="sortfrm" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
		<table width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center" >
			<tr bgColor="#ffffff">
				<td colspan="2">
					<div class="letter_select">
						<?php
					  		$letters = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');
					  		foreach ($letters as $let):
					    ?>
					    	<a <?= $byLetter === $let ? 'class="selected_letter"' : '' ?> href="manage_contact.php?letter=<?= $let ?>&status=<?php echo (!empty($_GET['status']) ? $_GET['status'] : ''); ?>&sort=<?= htmlspecialchars($sortBy) ?>&sortdir=<?= $sortDir ?>&contacttype=<?= htmlspecialchars($contactType) ?>"><?php echo $let; ?></a>
						<?php
						  	endforeach;

							if (isset($_GET['letter']) && $_GET['letter'] != ''):
						?>
							<a href="manage_contact.php?status=<?php echo $_GET['status'];?>&sort=<?= htmlspecialchars($sortBy) ?>&sortdir=<?= $sortDir ?>&contacttype=<?= htmlspecialchars($contactType) ?>">Show All</a>
						<?php endif ?>
					</div>
				</td>

				<td align="right" colspan="15" class="bp">
					<?php if($total_rec > $rec_disp): ?>
						Pages:

						<?php

                        paging(
                            $no_pages,
                            $index_val,
                            'letter=' . htmlspecialchars($byLetter) .
                            '&status=' . (!empty($_GET['status']) ? $_GET['status'] : '') .
                            '&sort=' . htmlspecialchars($sortBy) .
                            '&sortdir=' . htmlspecialchars($sortDir) .
                            '&contacttype=' . htmlspecialchars($contactType)
                        );

                        ?>
					<?php endif ?>
				</td>        
			</tr>
			<tr class="tr_bg_h">
	            <td valign="top" class="col_head  <?= $sortBy === 'name' ? 'arrow_' . strtolower($sortDir) : '' ?>" width="20%">
	                <a href="manage_contact.php?<?= $byLetter ? 'letter=' . htmlspecialchars($byLetter) . '&' : '' ?>sort=name&sortdir=<?= $sortBy === 'name' && $sortDir === 'ASC' ? 'DESC' : 'ASC' ?>">Name</a>
	            </td>

	            <td valign="top" class="col_head  <?=$sortBy === 'company' ? 'arrow_' . strtolower($sortDir) : '' ?>" width="25%">
	                <a href="manage_contact.php?<?= $byLetter ? 'letter=' . htmlspecialchars($byLetter) . '&' : '' ?>sort=company&sortdir=<?= $sortBy === 'company' && $sortDir === 'ASC' ? 'DESC' : 'ASC' ?>">Company</a>
	            </td>

	            <td valign="top" class="col_head  <?= $sortBy === 'type' ? 'arrow_' . strtolower($sortDir) : '' ?>" width="25%">
	                <a href="manage_contact.php?<?= $byLetter ? 'letter=' . htmlspecialchars($byLetter) . '&' : '' ?>sort=type&sortdir=<?= $sortBy === 'type' && $sortDir === 'ASC' ? 'DESC' : 'ASC' ?>">Contact Type</a>
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

				<?php if ($num_contact == 0): ?>

					<tr class="tr_bg">
						<td valign="top" class="col_head" colspan="10" align="center">
							No Records
						</td>
					</tr>

				<?php else:

					foreach ($my as $myarray) { 
						if ($myarray["status"] == 1) {
							$tr_class = "tr_active";
						} else {
							$tr_class = "tr_inactive";
						}
						
						$name = st($myarray['lastname']) . " " . st($myarray['middlename']) . ", " . st($myarray['firstname']);
				?>

					<tr class="<?php echo $tr_class;?>">
						<td valign="top" width="20%">
							<?php echo $name;?>
						</td>

						<td valign="top" width="25%">
							<?php echo st($myarray["company"]);?>
						</td>

						<td valign="top" width="25%">
							<?php print (!empty($contact_type[$myarray["contacttypeid"]])) ? $contact_type[$myarray["contacttypeid"]] : "Contact Type Not Set"; ?>
			      		</td>

						<td valign="top" width="10%">
							<?php
							    $ref_sql = "SELECT * FROM dental_patients WHERE (parent_patientid IS NULL OR parent_patientid='') AND referred_source=2 AND referred_by='" . mysqli_real_escape_string($con,$myarray['contactid']) . "'";
							    $ref_q = $db->getResults($ref_sql);
							    $num_ref = count($ref_q);
							?>

							<?php echo ($num_ref) ? '<a href="#" onclick="$(\'#ref_pat_' . $myarray['contactid'] . '\').toggle();return false;">' . $num_ref . '</a>':''; ?>
						</td>

	                    <td valign="top" width="10%">
							<?php
							    $pat_sql = "SELECT * FROM dental_patients WHERE (parent_patientid IS NULL OR parent_patientid='') AND (docpcp='" . mysqli_real_escape_string($con,$myarray['contactid']) . "' OR docent = '" . mysqli_real_escape_string($con,$myarray['contactid']) . "' OR docsleep='" . mysqli_real_escape_string($con,$myarray['contactid']) . "' OR docdentist='" . mysqli_real_escape_string($con,$myarray['contactid']) . "' OR docmdother='" . mysqli_real_escape_string($con,$myarray['contactid']) . "' OR docmdother2 = '" . mysqli_real_escape_string($con,$myarray['contactid']) . "' OR docmdother3='" . mysqli_real_escape_string($con,$myarray['contactid']) . "')";
							    $pat_q = $db->getResults($pat_sql);
							    $num_pat = count($pat_q);
							?>
	                        
	                        <?php echo ($num_pat) ? '<a href="#" onclick="$(\'#ref_pat_' . $myarray['contactid'] . '\').toggle();return false;">' . $num_pat . '</a>' : ''; ?>
	                    </td>

						<td valign="top" width="20%">
									<div class="actions" style="display:none;">
						        <a href="#" onclick="loadPopup('view_contact.php?ed=<?php echo $myarray["contactid"];?>')" class="editlink" title="EDIT">
	                    Quick View
		                </a>
										|
										<a href="#" onclick="loadPopup('add_contact.php?ed=<?php echo $myarray["contactid"];?>')" class="editlink" title="EDIT">
											Edit 
										</a>
									</div>
						</td>
					</tr>

					<tr id="ref_pat_<?php echo  $myarray['contactid'];?>" style="display:none;">
						<td colspan="2" valign="top">
							<strong>REFERRED</strong><br />
							<?php if ($num_ref != 0){
								foreach ($ref_q as $ref){ ?>
								<a href="add_patient.php?pid=<?php echo $ref['patientid'];?>&ed=<?php echo  $ref['patientid'];?>"><?php echo  $ref['firstname'] . " " . $ref['lastname']; ?><br />
							<?php 
								} 
							} ?>
						</td>

	                    <td colspan="4" valign="top">
	                        <strong>PATIENTS</strong><br />

			                <?php if ($num_pat != 0){
			                foreach ($pat_q as $pat){ ?>
			                	<a href="add_patient.php?pid=<?php echo  $pat['patientid'];?>&ed=<?php echo  $pat['patientid'];?>"><?php echo  $pat['firstname'] . " " . $pat['lastname']; ?><br />
			                <?php }
			                } ?>
	                    </td>
					</tr>
				<?php 	}
					endif;
				?>
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
<script type="text/javascript">
  $(document).ready(function(){
    $('.actions').show();
  });
</script>
<?php include "includes/bottom.htm"; ?>
