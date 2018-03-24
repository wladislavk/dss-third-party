<?php namespace Ds3\Libraries\Legacy; ?><?php
	$pcont_qry = "SELECT * FROM dental_pcont LEFT JOIN dental_contact ON dental_pcont.contact_id = dental_contact.contactid WHERE dental_pcont.patient_id=".(!empty($_GET['ed']) ? $_GET['ed'] : '')." UNION SELECT * FROM dental_pcont RIGHT JOIN dental_contact ON dental_pcont.contact_id = dental_contact.contactid WHERE dental_pcont.patient_id=".(!empty($_GET['ed']) ? $_GET['ed'] : '');

	$pcont_array = $db->getResults($pcont_qry);
?>

<table>
	<?php 
		if(isset($_GET['ed'])){
			if ($pcont_array) foreach ($pcont_array as $pcont_l){
	?>
			<tr>
				<td>
	<?php
				if ($pcont_l['contacttypeid'] != '0') {
					$type_check = "SELECT contacttype FROM dental_contacttype WHERE contacttypeid=".$pcont_l['contacttypeid'];
					
					$type_array = $db->getRow($type_check);
					$currentcontact_type = $type_array['contacttype'];
				} else {
					$currentcontact_type = "Type Not Set";
				}

				echo "<a href=\"add_contact.php?ed=".$pcont_l['contactid']."\">".$pcont_l['firstname']." ".$pcont_l['lastname']." - ". $currentcontact_type ."</a><br />";
	?>
				</td>
			</tr>
	<?php 
 			}
 		}
	?>
	<tr>
		<td>
		<hr />
		<input class="button" style="width:150px;" type="submit" name="add_contact_but" value="Add Contact to Patient" />
		<!--<a href="Javascript:;" class="addButton" onclick="Javascript: scroll(0,0);loadPopup('add_patient_to.php?ed=<?php echo $_GET['ed']; ?>');">
				Add Contact to Patient
			</a>-->

		</td>
	</tr>
 </table>
