<?php session_start();
  if(!isset($_SESSION['pid'])){
    ?><script type="text/javascript">window.location = "login.php";</script><?php
    die();
  }

include 'includes/header.php';

  if(isset($_POST['update'])){

	$sql = "UPDATE dental_patients set
		firstname = '".mysql_real_escape_string($_POST['firstname'])."',
		middlename= '".mysql_real_escape_string($_POST['middlename'])."',
                lastname= '".mysql_real_escape_string($_POST['lastname'])."',
                email= '".mysql_real_escape_string($_POST['email'])."',
                home_phone = '".mysql_real_escape_string($_POST['home_phone'])."',
                work_phone = '".mysql_real_escape_string($_POST['work_phone'])."',
                cell_phone = '".mysql_real_escape_string($_POST['cell_phone'])."',
                add1 = '".mysql_real_escape_string($_POST['add1'])."',
                add2 = '".mysql_real_escape_string($_POST['add2'])."',
                city = '".mysql_real_escape_string($_POST['city'])."',
                state = '".mysql_real_escape_string($_POST['state'])."',
                zip = '".mysql_real_escape_string($_POST['zip'])."',
                dob = '".mysql_real_escape_string($_POST['dob'])."',
                gender = '".mysql_real_escape_string($_POST['gender'])."',
                marital_status = '".mysql_real_escape_string($_POST['marital_status'])."',
                partner_name = '".mysql_real_escape_string($_POST['partner_name'])."',
                ssn = '".mysql_real_escape_string($_POST['ssn'])."',
                patient_notes = '".mysql_real_escape_string($_POST['patient_notes'])."',
                preferredcontact = '".mysql_real_escape_string($_POST['preferredcontact'])."',
                emergency_name = '".mysql_real_escape_string($_POST['emergency_name'])."',
                emergency_relationship = '".mysql_real_escape_string($_POST['emergency_relationship'])."',
                emergency_number = '".mysql_real_escape_string($_POST['emergency_number'])."',
                p_m_relation = '".mysql_real_escape_string($_POST['p_m_relation'])."',
                p_m_partyfname = '".mysql_real_escape_string($_POST['p_m_partyfname'])."',
                p_m_partymname = '".mysql_real_escape_string($_POST['p_m_partymname'])."',
                p_m_partylname = '".mysql_real_escape_string($_POST['p_m_partylname'])."',
                ins_dob = '".mysql_real_escape_string($_POST['ins_dob'])."',
                p_m_ins_co = '".mysql_real_escape_string($_POST['p_m_ins_co'])."',
                p_m_ins_id = '".mysql_real_escape_string($_POST['p_m_ins_id'])."',
                p_m_ins_grp = '".mysql_real_escape_string($_POST['p_m_ins_grp'])."',
                p_m_ins_plan = '".mysql_real_escape_string($_POST['p_m_ins_plan'])."',
                p_m_ins_type = '".mysql_real_escape_string($_POST['p_m_ins_type'])."',
                p_m_ins_ass = '".mysql_real_escape_string($_POST['p_m_ins_ass'])."',
		has_s_m_ins = '".mysql_real_escape_string($_POST['has_s_m_ins'])."',
                s_m_relation = '".mysql_real_escape_string($_POST['s_m_relation'])."',
                s_m_partyfname = '".mysql_real_escape_string($_POST['s_m_partyfname'])."',
                s_m_partymname = '".mysql_real_escape_string($_POST['s_m_partymname'])."',
                s_m_partylname = '".mysql_real_escape_string($_POST['s_m_partylname'])."',
                ins2_dob = '".mysql_real_escape_string($_POST['ins2_dob'])."',
                s_m_ins_co = '".mysql_real_escape_string($_POST['s_m_ins_co'])."',
                s_m_ins_id = '".mysql_real_escape_string($_POST['s_m_ins_id'])."',
                s_m_ins_grp = '".mysql_real_escape_string($_POST['s_m_ins_grp'])."',
                s_m_ins_plan = '".mysql_real_escape_string($_POST['s_m_ins_plan'])."',
                s_m_ins_type = '".mysql_real_escape_string($_POST['s_m_ins_type'])."',
                s_m_ins_ass = '".mysql_real_escape_string($_POST['s_m_ins_ass'])."',
                employer = '".mysql_real_escape_string($_POST['employer'])."',
                emp_add1 = '".mysql_real_escape_string($_POST['emp_add1'])."',
                emp_add2 = '".mysql_real_escape_string($_POST['emp_add2'])."',
                emp_city = '".mysql_real_escape_string($_POST['emp_city'])."',
                emp_state = '".mysql_real_escape_string($_POST['emp_state'])."',
                emp_zip = '".mysql_real_escape_string($_POST['emp_zip'])."',
                emp_phone = '".mysql_real_escape_string($_POST['emp_phone'])."',
                emp_fax = '".mysql_real_escape_string($_POST['emp_fax'])."',
		registered = '1'
		WHERE patientid='".mysql_real_escape_string($_SESSION['pid'])."'
		";
	mysql_query($sql);
	//                 = '".mysql_real_escape_string($_POST[''])."',
	?>
	<script type="text/javascript">
	  window.location = "home.php";
	</script>
	<?php
  }

  $sql = "SELECT * from dental_patients WHERE patientid='".mysql_real_escape_string($_SESSION['pid'])."'";
  $q = mysql_query($sql);
  $p = mysql_fetch_assoc($q);
?>

<style type="text/css">
label{display:block; padding:2px 5px 0 0; width: 120px; text-align:right; float:left; clear:both;}
input, select, textarea{float:left; }
input[type=radio]{float:none;}
input[type=text]{ width: 250px; }
h4{ clear:both; }
.hidden{display:none;}
</style>
<script type="text/javascript">
function showSect(s){
	if(s==4 && $('#has_s_m_ins_no').attr('checked')=="checked"){ s=5; }
	$('.sect').css('display', 'none');
	$('#sect'+s).css('display', 'block');
}

$('document').ready( function(){
  //showSect(4);
});

</script>
      <h2>Patient Registration</h2>

	<form action="register.php" method="post">
		<div id="sect1" class="sect">
		<h3>Contact information</h3>
		<label>First Name:</label><input type="text" name="firstname" value="<?= $p['firstname']; ?>" />
                <label>Middle Init:</label><input type="text" maxlength="1" name="middlename" value="<?= $p['middlename']; ?>" />
		<label>Last Name:</label><input type="text" name="lastname" value="<?= $p['lastname']; ?>" />
                <label>Email:</label><input type="text" name="email" value="<?= $p['email']; ?>" />
                <label>Home Phone:</label><input type="text" name="home_phone" value="<?= $p['home_phone']; ?>" />
                <label>Work Phone:</label><input type="text" name="work_phone" value="<?= $p['work_phone']; ?>" />
                <label>Cell Phone:</label><input type="text" name="cell_phone" value="<?= $p['cell_phone']; ?>" />
                <label>Address 1:</label><input type="text" name="add1" value="<?= $p['add1']; ?>" />
                <label>Address 2:</label><input type="text" name="add2" value="<?= $p['add2']; ?>" />
                <label>City:</label><input type="text" name="city" value="<?= $p['city']; ?>" />
                <label>State:</label><input type="text" name="state" value="<?= $p['state']; ?>" />
                <label>Zip:</label><input type="text" name="zip" value="<?= $p['zip']; ?>" />


		<label></label><input type="button" value="Next" onclick="showSect(2)" />
		</div>

		<div id="sect2" class="sect hidden">
		<h3>Personal Information</h3>
                <label>Birthday:</label><input type="text" name="dob" value="<?= $p['dob']; ?>" />
                <label>Gender:</label><select name="gender">
				<option>Select</option>
				<option value="Male" <?= ($p['gender']=="Male")?'selected="selected"':'';?>>Male</option>
                                <option value="Female" <?= ($p['gender']=="Female")?'selected="selected"':'';?>>Female</option>
				</select>
                <label>Marital Status:</label><select name="marital_status">
                                <option>Select</option>
                                <option value="Married" <?= ($p['marital_status']=="Married")?'selected="selected"':'';?>>Married</option>
                                <option value="Single" <?= ($p['marital_status']=="Single")?'selected="selected"':'';?>>Single</option>
                                <option value="Life Partner" <?= ($p['marital_status']=="Life Partner")?'selected="selected"':'';?>>Life Partner</option>
                                </select>
                <label>Partner Name:</label><input type="text" name="partner_name" value="<?= $p['partner_name']; ?>" />
                <label>Social Security #:</label><input type="text" name="ssn" value="<?= $p['ssn']; ?>" />
                <label>Patient Notes:</label><textarea name="patient_notes"><?= $p['patient_notes']; ?></textarea>
                <label>Prefered Method of Contact:</label><select name="preferredcontact">
                                <option value="paper" <?= ($p['preferredcontact']=="paper")?'selected="selected"':'';?>>Paper Mail</option>
                                <option value="email" <?= ($p['preferredcontact']=="email")?'selected="selected"':'';?>>Email</option>
                                </select>
		<h4>In Case of Emergency</h4>
                <label>Name:</label><input type="text" name="emergency_name" value="<?= $p['emergency_name']; ?>" />
                <label>Relationship:</label><input type="text" name="emergency_relationship" value="<?= $p['emergency_relationship']; ?>" />
                <label>Number:</label><input type="text" name="emergency_number" value="<?= $p['emergency_number']; ?>" />

		<label></label><input type="button" value="Next" onclick="showSect(3)" />
		</div>
		<!--
		<label>:</label><input type="text" name="" value="<?= $p['']; ?>" />
-->

		<div id="sect3" class="sect hidden">
		<h3>Insurance</h3>
                <label>Relationship to primary insured:</label><select id="p_m_relation" name="p_m_relation" class="field text addr tbox" style="width:200px;">
                                                                        <option value="" <? if($p['p_m_relation'] == '') echo " selected";?>>None</option>
                                                                        <option value="Self" <? if($p['p_m_relation'] == 'Self') echo " selected";?>>Self</option>      
                                            				<option value="Spouse" <? if($p['p_m_relation'] == 'Spouse') echo " selected";?>>Spouse</option>
                                                                        <option value="Child" <? if($p['p_m_relation'] == 'Child') echo " selected";?>>Child</option>
                                                                        <option value="Other" <? if($p['p_m_relation'] == 'Other') echo " selected";?>>Other</option>
                                                                </select>
                <label>First Name:</label><input id="p_m_partyfname" name="p_m_partyfname" type="text" value="<?=$p['p_m_partyfname']?>" maxlength="255" />
		<label>Middle Name:</label><input id="p_m_partymname" name="p_m_partymname" type="text" value="<?=$p['p_m_partymname']?>" maxlength="255" />
		<label>Last Name:</label><input id="p_m_partylname" name="p_m_partylname" type="text" value="<?=$p['p_m_partylname']?>" maxlength="255" />
                <label>Date of Birth:</label><input id="ins_dob" name="ins_dob" type="text" value="<?=$p['ins_dob']?>" maxlength="255" />
<br />
       	  	<label>Insurance Company</label><select id="p_m_ins_co" name="p_m_ins_co" class="field text addr tbox" maxlength="255" />
                                                <option value="">Select Insurance Company</option>
			<?php
                            $ins_contact_qry = "SELECT * FROM `dental_contact` WHERE contacttypeid = '11' AND docid='".$_SESSION['docid']."'";
                            $ins_contact_qry_run = mysql_query($ins_contact_qry);
                            while($ins_contact_res = mysql_fetch_array($ins_contact_qry_run)){
                            ?>
                                <option value="<?php echo $ins_contact_res['contactid']; ?>" <?php if($p['p_m_ins_co'] == $ins_contact_res['contactid']){echo "selected=\"selected\"";} ?>><?php echo $ins_contact_res['company']; ?></option>
                                
                                <?php } ?>
                                </select>
           	<label>Insurance ID.</label><input id="p_m_party" name="p_m_ins_id" type="text" class="field text addr tbox" value="<?=$p['p_m_ins_id']?>" maxlength="255" />
                <label>Group #</label><input id="p_m_ins_grp" name="p_m_ins_grp" type="text" class="field text addr tbox" value="<?=$p['p_m_ins_grp']?>" maxlength="255" />
                <label>Plan Name</label><input id="p_m_ins_plan" name="p_m_ins_plan" type="text" class="field text addr tbox" value="<?=$p['p_m_ins_plan']?>" maxlength="255" />
<br />
                <label>Insurance Type</label><select id="p_m_ins_type" name="p_m_ins_type" class="field text addr tbox" maxlength="255" style="width:200px;" />
                                     <option>Select Type</option>
                                     <option value="1" <?php if($p['p_m_ins_type'] == '1'){ echo " selected='selected'";} ?>>Medicare</option>
                                     <option value="2" <?php if($p['p_m_ins_type'] == '2'){ echo " selected='selected'";} ?>>Medicaid</option>
                                     <option value="3" <?php if($p['p_m_ins_type'] == '3'){ echo " selected='selected'";} ?>>Tricare Champus</option>
                                     <option value="4" <?php if($p['p_m_ins_type'] == '4'){ echo " selected='selected'";} ?>>Champ VA</option>
                                     <option value="5" <?php if($p['p_m_ins_type'] == '5'){ echo " selected='selected'";} ?>>Group Health Plan</option>
                                     <option value="6" <?php if($p['p_m_ins_type'] == '6'){ echo " selected='selected'";} ?>>FECA BLKLUNG</option>
                                     <option value="7" <?php if($p['p_m_ins_type'] == '7'){ echo " selected='selected'";} ?>>Other</option>
                                </select>
		<span style="clear:both;display:block;float:left">Does patient have secondary insurance?<input type="radio" name="has_s_m_ins" <?= ($p['has_s_m_ins']=="Yes")?'checked="checked"':''; ?> value="Yes" />Yes <input type="radio" id="has_s_m_ins_no" name="has_s_m_ins" <?= ($p['has_s_m_ins']=="No")?'checked="checked"':''; ?> value="No" />No</span>
		<label></label><input type="button" onclick="showSect(4)" value="Next" />
		</div>
		<div class="sect hidden" id="sect4">
                <h3>Secondary Insurance</h3>  
                <label>Relationship to primary insured:</label><select id="s_m_relation" name="s_m_relation" class="field text addr tbox" style="width:200px;">
                                                                        <option value="" <? if($p['s_m_relation'] == '') echo " selected";?>>None</option>
                                                                        <option value="Self" <? if($p['s_m_relation'] == 'Self') echo " selected";?>>Self</option>
                                                                        <option value="Spouse" <? if($p['s_m_relation'] == 'Spouse') echo " selected";?>>Spouse</option>
                                                                        <option value="Child" <? if($p['s_m_relation'] == 'Child') echo " selected";?>>Child</option>
                                                                        <option value="Other" <? if($p['s_m_relation'] == 'Other') echo " selected";?>>Other</option>
                                                                </select>
                <label>First Name:</label><input id="s_m_partyfname" name="s_m_partyfname" type="text" value="<?=$p['s_m_partyfname']?>" maxlength="255" />
                <label>Middle Name:</label><input id="s_m_partymname" name="s_m_partymname" type="text" value="<?=$p['s_m_partymname']?>" maxlength="255" />
                <label>Last Name:</label><input id="s_m_partylname" name="s_m_partylname" type="text" value="<?=$p['s_m_partylname']?>" maxlength="255" />
                <label>Date of Birth:</label><input id="ins2_dob" name="ins2_dob" type="text" value="<?=$p['ins2_dob']?>" maxlength="255" />
<br />
                <label>Insurance Company</label><select id="s_m_ins_co" name="s_m_ins_co" class="field text addr tbox" maxlength="255" />
                                                <option value="">Select Insurance Company</option>
                        <?php
                            $ins_contact_qry = "SELECT * FROM `dental_contact` WHERE contacttypeid = '11' AND docid='".$_SESSION['docid']."'";
                            $ins_contact_qry_run = mysql_query($ins_contact_qry);                            while($ins_contact_res = mysql_fetch_array($ins_contact_qry_run)){
                            ?>
                                <option value="<?php echo $ins_contact_res['contactid']; ?>" <?php if($p['p_m_ins_co'] == $ins_contact_res['contactid']){echo "selected=\"selected\"";} ?>><?php echo $ins_contact_res['company']; ?></option>

                                <?php } ?>
                                </select>
                <label>Insurance ID.</label><input id="s_m_party" name="s_m_ins_id" type="text" class="field text addr tbox" value="<?=$p['s_m_ins_id']?>" maxlength="255" />
                <label>Group #</label><input id="s_m_ins_grp" name="s_m_ins_grp" type="text" class="field text addr tbox" value="<?=$p['s_m_ins_grp']?>" maxlength="255" />
                <label>Plan Name</label><input id="s_m_ins_plan" name="s_m_ins_plan" type="text" class="field text addr tbox" value="<?=$p['s_m_ins_plan']?>" maxlength="255" />
<br />
                <label>Insurance Type</label><select id="s_m_ins_type" name="s_m_ins_type" class="field text addr tbox" maxlength="255" style="width:200px;" />
                                     <option>Select Type</option>
                                     <option value="1" <?php if($p['s_m_ins_type'] == '1'){ echo " selected='selected'";} ?>>Medicare</option>
                                     <option value="2" <?php if($p['s_m_ins_type'] == '2'){ echo " selected='selected'";} ?>>Medicaid</option>
                                     <option value="3" <?php if($p['s_m_ins_type'] == '3'){ echo " selected='selected'";} ?>>Tricare Champus</option>
                                     <option value="4" <?php if($p['s_m_ins_type'] == '4'){ echo " selected='selected'";} ?>>Champ VA</option>
                                     <option value="5" <?php if($p['s_m_ins_type'] == '5'){ echo " selected='selected'";} ?>>Group Health Plan</option>
                                     <option value="6" <?php if($p['s_m_ins_type'] == '6'){ echo " selected='selected'";} ?>>FECA BLKLUNG</option>
                                     <option value="7" <?php if($p['s_m_ins_type'] == '7'){ echo " selected='selected'";} ?>>Other</option>
                                </select>
                <label></label><input type="button" onclick="showSect(5)" value="Next" />
		</div>
		<div class="sect hidden" id="sect5">
		<h3>Employer</h3>


                <label>Employer:</label><input id="employer" name="employer" type="text" class="field text addr tbox" value="<?php echo $p['employer']; ?>" style="width:525px;"  maxlength="255"/>
                <label>Address 1:</label><input id="emp_add1" name="emp_add1" type="text" class="field text addr tbox" value="<?=$p['emp_add1']?>" style="width:325px;"  maxlength="255"/>
                <label>Address 2:</label><input id="emp_add2" name="emp_add2" type="text" class="field text addr tbox" value="<?=$p['emp_add2']?>" style="width:325px;" maxlength="255" />
                <label>City:</label><input id="emp_city" name="emp_city" type="text" class="field text addr tbox" value="<?=$p['emp_city']?>" style="width:200px;" maxlength="255" />
                <label>State:</label><input id="emp_state" name="emp_state" type="text" class="field text addr tbox" value="<?=$p['emp_state']?>"  style="width:80px;" maxlength="255" />
                <label>Zip Code:</label><input id="emp_zip" name="emp_zip" type="text" class="field text addr tbox" value="<?=$p['emp_zip']?>" style="width:80px;" maxlength="255" />
                <label>Phone:</label><input id="emp_phone" name="emp_phone" type="text" class="field text addr tbox" value="<?=$p['emp_phone']?>"  style="width:120px;" maxlength="255" />
                <label>Fax:</label><input id="emp_fax" name="emp_fax" type="text" class="field text addr tbox" value="<?=$p['emp_fax']?>"  style="width:120px;" maxlength="255" />


		                <label></label><input type="button" onclick="showSect(6)" value="Next" />
                </div>
                <div class="sect hidden" id="sect6">
		<h3>Contacts</h3>
		<label></label>
		<input type="submit" name="update" value="Update" />
		</div>
	</form>  

<?php include 'includes/footer.php'; ?>
