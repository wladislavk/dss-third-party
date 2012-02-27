<?php session_start();
  if(!isset($_SESSION['pid'])){
    ?><script type="text/javascript">window.location = "login.php";</script><?php
    die();
  }

include 'includes/header.php';
?>
<link rel="stylesheet" href="css/register.css" />
<script type="text/javascript" src="js/register.js"></script>
<script type="text/javascript" src="../manage/js/patient_dob.js"></script>
<script type="text/javascript" src="js/autocomplete.js"></script>
        <script type="text/javascript">
                $(document).ready(function(){
                                //lga_fusionCharts.chart_k();
                                lga_wizard.init();
                        });
        </script>

<?php
  $sql = "SELECT * from dental_patients WHERE parent_patientid='".mysql_real_escape_string($_SESSION['pid'])."'";
  $q = mysql_query($sql);
  if(mysql_num_rows($q) > 0){
      $p = mysql_fetch_assoc($q);
  }else{
      $sql = "SELECT * from dental_patients WHERE patientid='".mysql_real_escape_string($_SESSION['pid'])."'";
      $q = mysql_query($sql);
      $p = mysql_fetch_assoc($q);
  }
?>
				<div id="content_wrapper">
					<div id="main_content" class="cf">

						<h2 class="sepH_c">Patient Registration</h2>
	<form action="register.php" id="register_form" method="post">
		<input type="hidden" id="patientid" name="patientid" value="<?= $_SESSION['pid']; ?>" />
							<ul id="status" class="cf">
								<li class="active"><span class="large">1. Contact Information</span></li>
								<li><span class="large">2. Personal Information</span></li>
								<li><span class="large">3. Insurance</span></li>
								<li><span class="large">4. 2nd Insurance</span></li>
								<li><span class="large">5. Employer</span></li>
								<li><span class="large">6. Contacts</span></li>
							</ul>
							<div id="register" class="wizard" style="height:1400px;">
								<div class="items formEl_a">
									<div class="page">
										<div class="pageInside">
											<div class="cf">
												<div class="dp25">
													<h3 class="sepH_a">Welcome!</h3>
													<p class="s_color small">Please accurately complete the information on the following pages. This will save you time at your next Dental Sleep Solutions appointment, and allow you to avoid completing additional forms later.  All information you input here is securely stored using the latest encryption technology that meets or exceeds HIPAA medical privacy standards, and you can access and update your information anytime.  We take your privacy seriously, and we never share your information without your consent.  We're excited to see you at your next visit!</p>
												</div>
												<div class="dp75">
													<div>
														<div id="welcome_errors" class="form_errors" style="display:none"></div>
		<div class="sepH_b third">
			<label class="lbl_a"><strong>1.</strong> First Name <span class="req">*</span></label>
			<input class="inpt_a validate" type="text" name="firstname" id="firstname" value="<?= $p['firstname']; ?>" />
		</div>
                <div class="sepH_b third">
                        <label class="lbl_a"><strong>2.</strong> Middle Init</label>
			<input class="inpt_a" type="text" maxlength="1" name="middlename" id="middlename" value="<?= $p['middlename']; ?>" />
		</div>
		<div class="sepH_b third">
                        <label class="lbl_a"><strong>3.</strong> Last Name <span class="req">*</span></label>
			<input class="inpt_a validate" type="text" name="lastname" id="lastname" value="<?= $p['lastname']; ?>" />
		</div>
                <div class="sepH_b clear">
                        <label class="lbl_a"><strong>4.</strong> Email:</label><input class="inpt_a validate" type="text" id="email" name="email" value="<?= $p['email']; ?>" />
                </div>
                <div class="sepH_b third">
                        <label class="lbl_a"><strong>5.</strong> Home Phone:</label><input class="inpt_a" type="text" id="home_phone" name="home_phone" value="<?= $p['home_phone']; ?>" />
                </div>
                <div class="sepH_b third">
                        <label class="lbl_a"><strong>6.</strong> Work Phone:</label><input class="inpt_a" type="text" id="work_phone" name="work_phone" value="<?= $p['work_phone']; ?>" />
                </div>
                <div class="sepH_b third">
                        <label class="lbl_a"><strong>7.</strong> Cell Phone:</label><input class="inpt_a validate" type="text" id="cell_phone" name="cell_phone" value="<?= $p['cell_phone']; ?>" />
                </div>
                <div class="sepH_b clear">
                        <label class="lbl_a"><strong>8.</strong> Address 1:</label><input class="inpt_a validate" type="text" name="add1" value="<?= $p['add1']; ?>" />
                </div>
                <div class="sepH_b">
                        <label class="lbl_a"><strong>9.</strong> Address 2:</label><input class="inpt_a" type="text" name="add2" value="<?= $p['add2']; ?>" />
                </div>
                <div class="sepH_b third">
                        <label class="lbl_a"><strong>10.</strong> City:</label><input class="inpt_a validate" type="text" name="city" value="<?= $p['city']; ?>" />
                </div>
                <div class="sepH_b third">
			<?php $s = $p['state']; ?>
                        <label class="lbl_a"><strong>11.</strong> State:</label>
	<select  data-placeholder="Choose a state..." style="width:200px;" class="chzn-select validate" id="state" name="state">
                                <option value=""></option>
                                <option <?= ($s=='AK')?'selected="selected"':'' ?> value="AK">AK - Alaska</option>
                                <option <?= ($s=='AL')?'selected="selected"':'' ?> value="AL">AL - Alabama</option>
                                <option <?= ($s=='AR')?'selected="selected"':'' ?> value="AR">AR - Arkansas</option>
                                <option <?= ($s=='AZ')?'selected="selected"':'' ?> value="AZ">AZ - Arizona</option>
                                <option <?= ($s=='CA')?'selected="selected"':'' ?> value="CA">CA - California</option>
                                <option <?= ($s=='CO')?'selected="selected"':'' ?> value="CO">CO - Colorado</option>
                                <option <?= ($s=='CT')?'selected="selected"':'' ?> value="CT">CT - Connecticut</option>
                                <option <?= ($s=='DC')?'selected="selected"':'' ?> value="DC">DC - District of Columbia</option>
                                <option <?= ($s=='DE')?'selected="selected"':'' ?> value="DE">DE - Delaware</option>
                                <option <?= ($s=='FL')?'selected="selected"':'' ?> value="FL">FL - Florida</option>
                                <option <?= ($s=='GA')?'selected="selected"':'' ?> value="GA">GA - Georgia</option>
                                <option <?= ($s=='HI')?'selected="selected"':'' ?> value="HI">HI - Hawaii</option>
                                <option <?= ($s=='IA')?'selected="selected"':'' ?> value="IA">IA - Iowa</option>
                                <option <?= ($s=='ID')?'selected="selected"':'' ?> value="ID">ID - Idaho</option>
                                <option <?= ($s=='IL')?'selected="selected"':'' ?> value="IL">IL - Illinois</option>
                                <option <?= ($s=='IN')?'selected="selected"':'' ?> value="IN">IN - Indiana</option>
                                <option <?= ($s=='KS')?'selected="selected"':'' ?> value="KS">KS - Kansas</option>
                                <option <?= ($s=='KY')?'selected="selected"':'' ?> value="KY">KY - Kentucky</option>
                                <option <?= ($s=='LA')?'selected="selected"':'' ?> value="LA">LA - Louisiana</option>
                                <option <?= ($s=='MA')?'selected="selected"':'' ?> value="MA">MA - Massachusetts</option>
                                <option <?= ($s=='MD')?'selected="selected"':'' ?> value="MD">MD - Maryland</option>
                                <option <?= ($s=='ME')?'selected="selected"':'' ?> value="ME">ME - Maine</option>
                                <option <?= ($s=='MI')?'selected="selected"':'' ?> value="MI">MI - Michigan</option>
                                <option <?= ($s=='MN')?'selected="selected"':'' ?> value="MN">MN - Minnesota</option>
                                <option <?= ($s=='MO')?'selected="selected"':'' ?> value="MO">MO - Missouri</option>
                                <option <?= ($s=='MS')?'selected="selected"':'' ?> value="MS">MS - Mississippi</option>
                                <option <?= ($s=='MT')?'selected="selected"':'' ?> value="MT">MT - Montana</option>
                                <option <?= ($s=='NC')?'selected="selected"':'' ?> value="NC">NC - North Carolina</option>
                                <option <?= ($s=='ND')?'selected="selected"':'' ?> value="ND">ND - North Dakota</option>
                                <option <?= ($s=='NE')?'selected="selected"':'' ?> value="NE">NE - Nebraska</option>
                                <option <?= ($s=='NH')?'selected="selected"':'' ?> value="NH">NH - New Hampshire</option>
                                <option <?= ($s=='NJ')?'selected="selected"':'' ?> value="NJ">NJ - New Jersey</option>
                                <option <?= ($s=='NM')?'selected="selected"':'' ?> value="NM">NM - New Mexico</option>
                                <option <?= ($s=='NV')?'selected="selected"':'' ?> value="NV">NV - Nevada</option>
                                <option <?= ($s=='NY')?'selected="selected"':'' ?> value="NY">NY - New York</option>
                                <option <?= ($s=='OH')?'selected="selected"':'' ?> value="OH">OH - Ohio</option>
                                <option <?= ($s=='OK')?'selected="selected"':'' ?> value="OK">OK - Oklahoma</option>
                                <option <?= ($s=='OR')?'selected="selected"':'' ?> value="OR">OR - Oregon</option>
                                <option <?= ($s=='PA')?'selected="selected"':'' ?> value="PA">PA - Pennsylvania</option>
                                <option <?= ($s=='RI')?'selected="selected"':'' ?> value="RI">RI - Rhode Island</option>
                                <option <?= ($s=='SC')?'selected="selected"':'' ?> value="SC">SC - South Carolina</option>
                                <option <?= ($s=='SD')?'selected="selected"':'' ?> value="SD">SD - South Dakota</option>
                                <option <?= ($s=='TN')?'selected="selected"':'' ?> value="TN">TN - Tennessee</option>
                                <option <?= ($s=='TX')?'selected="selected"':'' ?> value="TX">TX - Texas</option>
                                <option <?= ($s=='UT')?'selected="selected"':'' ?> value="UT">UT - Utah</option>
                                <option <?= ($s=='VA')?'selected="selected"':'' ?> value="VA">VA - Virginia</option>
                                <option <?= ($s=='VT')?'selected="selected"':'' ?> value="VT">VT - Vermont</option>
                                <option <?= ($s=='WA')?'selected="selected"':'' ?> value="WA">WA - Washington</option>
                                <option <?= ($s=='WI')?'selected="selected"':'' ?> value="WI">WI - Wisconsin</option>
                                <option <?= ($s=='WV')?'selected="selected"':'' ?> value="WV">WV - West Virginia</option>
                                <option <?= ($s=='WY')?'selected="selected"':'' ?> value="WY">WY - Wyoming</option>
                        </select>

                </div>
                <div class="sepH_b third">
                        <label class="lbl_a"><strong>12.</strong> Zip:</label><input class="inpt_a " type="text" name="zip" value="<?= $p['zip']; ?>" />
                </div>
														<div class="cf">
															<a href="javascript:void(0)" class="fl prev btn btn_a">&laquo; Back</a>
<a href="javascript:void(0)" class="fr next btn btn_d">Proceed &raquo;</a>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>

									<div class="page">
                                                                                <div class="pageInside">
                                                                                        <div class="cf">
                                                                                                <div class="dp25">
                                                                                                        <h3 class="sepH_a">Personal Information</h3>
                                                                                                        <p class="s_color small">This information helps us verify your insurance coverage and allows us to contact someone you designate in the event of an emergency.</p>
                                                                                                </div>
                                                                                                <div class="dp75">
                                                                                                        <div>
                                                                                                                <div class="form_errors" style="display:none"></div>
                <div class="sepH_b half" id="dob_div">
                        <label class="lbl_a"><strong>1.</strong> Birthday:</label>
				<?php
					$dob_month = date('m', strtotime($p['dob']));
                                        $dob_day = date('j', strtotime($p['dob']));
                                        $dob_year = date('Y', strtotime($p['dob']));
				?>
                                <select class="validate" id="dob_month" name="dob_month">
                                        <option value=''>Month</option>
                                        <?php
                                                for($i=1;$i<=12;$i++){ ?>
                                                        <option <?= (($dob_month==$i)?'selected="selected"':''); ?> value="<?= $i; ?>"><?= $i; ?></option>
                                                <?php }
                                        ?>
                                </select>
                                <select class="validate" id="dob_day" name="dob_day">
                                        <option value=''>Day</option>
                                        <?php
                                                for($i=1;$i<=31;$i++){ ?> 
                                                     <option <?= (($dob_day==$i)?'selected="selected"':''); ?> value="<?= $i; ?>"><?= $i; ?></option>
                                                <?php }                                        
                                        ?>
                                </select>
                                <select class="validate" id="dob_year" name="dob_year">
                                        <option value=''>Year</option>
                                        <?php               
                                        for($i=(date('Y'))-12;$i>=1915;$i--){ ?>                                                                                                                
						<option <?= (($dob_year==$i)?'selected="selected"':''); ?> value="<?= $i; ?>"><?= $i; ?></option>                                 
                                        <?php }  
                                        ?>
                                </select>

		</div>
                <div class="sepH_b half">
                        <label class="lbl_a"><strong>2.</strong> Gender:</label><select class="inpt_a validate" name="gender">
				<option value=''>Select</option>
				<option value="Male" <?= ($p['gender']=="Male")?'selected="selected"':'';?>>Male</option>
                                <option value="Female" <?= ($p['gender']=="Female")?'selected="selected"':'';?>>Female</option>
				</select>
                </div>
                <div class="sepH_b clear half">
                        <label class="lbl_a"><strong>3.</strong> Marital Status:</label><select class="inpt_a" name="marital_status">
                                <option>Select</option>
                                <option value="Married" <?= ($p['marital_status']=="Married")?'selected="selected"':'';?>>Married</option>
                                <option value="Single" <?= ($p['marital_status']=="Single")?'selected="selected"':'';?>>Single</option>
                                <option value="Life Partner" <?= ($p['marital_status']=="Life Partner")?'selected="selected"':'';?>>Life Partner</option>
                                </select>
                </div>
                <div class="sepH_b half">
                        <label class="lbl_a"><strong>4.</strong> Spouse/Partner Name:</label><input class="inpt_a" type="text" name="partner_name" value="<?= $p['partner_name']; ?>" />
                </div>
                <div class="sepH_b clear">
                        <label class="lbl_a"><strong>5.</strong> Social Security #:</label><input class="inpt_a validate" type="text" name="ssn" value="<?= $p['ssn']; ?>" />
                </div>
                <div class="sepH_b">
                        <label class="lbl_a"><strong>6.</strong> Patient Notes:</label><textarea class="inpt_a" name="patient_notes"><?= $p['patient_notes']; ?></textarea>
                </div>
                <div class="sepH_b">
                        <label class="lbl_a"><strong>7.</strong> Prefered Method of Contact:</label><select class="inpt_a validate" name="preferredcontact">
                                <option value="paper" <?= ($p['preferredcontact']=="paper")?'selected="selected"':'';?>>Paper Mail</option>
                                <option value="email" <?= ($p['preferredcontact']=="email")?'selected="selected"':'';?>>Email</option>
                                </select>
                </div>
                <div class="sepH_b third">
                        <label class="lbl_a"><strong>8.</strong> Emergency Contact Name:</label><input class="inpt_a" type="text" name="emergency_name" value="<?= $p['emergency_name']; ?>" />
                </div>
                <div class="sepH_b third">
                        <label class="lbl_a"><strong>9.</strong> Emergency Contact Relationship:</label><input class="inpt_a" type="text" name="emergency_relationship" value="<?= $p['emergency_relationship']; ?>" />
                </div>
                <div class="sepH_b third">
                        <label class="lbl_a"><strong>10.</strong> Emergency Contact Number:</label><input class="inpt_a" type="text" name="emergency_number" value="<?= $p['emergency_number']; ?>" />
		</div>
                                                                                                                <div class="cf">
															<a href="javascript:void(0)" class="fl prev btn btn_a">&laquo; Back</a>

<a href="javascript:void(0)" class="fr next btn btn_d">Proceed &raquo;</a>
                                                                                                                </div>
                                                                                                        </div>
                                                                                                </div>
                                                                                        </div>
                                                                                </div>
                                                                        </div>


                                                                        <div class="page">
                                                                                <div class="pageInside">
                                                                                        <div class="cf">
                                                                                                <div class="dp25">
                                                                                                        <h3 class="sepH_a">Medical Insurance</h3>
                                                                                                        <p class="s_color small">Please complete all fields on this page to allow Dental Sleep Solutions to verify your medical insurance coverage.  Failure to accurately complete these fields may result in insurance delays and even denial of coverage.  Refer to your medical insurance card for this information.</p>
                                                                                                </div>
                                                                                                <div class="dp75">
                                                                                                        <div>
                                                                                                                <div class="form_errors" style="display:none"></div>
 
                <div class="sepH_b clear">
                        <label class="lbl_a"><strong>1.</strong> Do you have Medicare Insurance</label>
				<input type="radio" name="p_m_ins_type" value="1" <?= ($p['p_m_ins_type'] == '1')?'checked="checked"':'';?> /> Yes
				<input type="radio" name="p_m_ins_type" class="validate" value="" <?= ($p['p_m_ins_type'] != '1')?'checked="checked"':'';?> /> No
                </div>
                <div class="sepH_b">
                        <label id='p_m_ins_description' class="lbl_a">Please complete the information below for the PRIMARY INSURED PARTY listed on your <?= ($p['p_m_ins_type'] == '1')?'MEDICARE ':'';?>insurance card.</label>
                </div>
                <div class="sepH_b">
                        <label class="lbl_a"><strong>2.</strong> Your relationship to primary insured:</label><select class="inpt_a validate" id="p_m_relation" name="p_m_relation" class="field text addr tbox" style="width:200px;">
                                                                        <option value="" <? if($p['p_m_relation'] == '') echo " selected";?>>None</option>
                                                                        <option value="Self" <? if($p['p_m_relation'] == 'Self') echo " selected";?>>Self</option>      
                                            				<option value="Spouse" <? if($p['p_m_relation'] == 'Spouse') echo " selected";?>>Spouse</option>
                                                                        <option value="Child" <? if($p['p_m_relation'] == 'Child') echo " selected";?>>Child</option>
                                                                        <option value="Other" <? if($p['p_m_relation'] == 'Other') echo " selected";?>>Other</option>
                                                                </select>
                </div>
                <div class="sepH_b third">
                        <label class="lbl_a"><strong>3.</strong> First Name:</label><input class="inpt_a validate" id="p_m_partyfname" name="p_m_partyfname" type="text" value="<?=$p['p_m_partyfname']?>" maxlength="255" />
		</div>
                <div class="sepH_b third">
                        <label class="lbl_a"><strong>4.</strong> Middle Name:</label><input class="inpt_a" id="p_m_partymname" name="p_m_partymname" type="text" value="<?=$p['p_m_partymname']?>" maxlength="255" />
		</div>
                <div class="sepH_b third">
                        <label class="lbl_a"><strong>5.</strong> Last Name:</label><input class="inpt_a validate" id="p_m_partylname" name="p_m_partylname" type="text" value="<?=$p['p_m_partylname']?>" maxlength="255" />
                </div>
                <div class="sepH_b clear" id="ins_dob_div">
                        <label class="lbl_a"><strong>6.</strong> Date of Birth:</label>
                                <?php
                                        $ins_dob_month = date('m', strtotime($p['ins_dob']));
                                        $ins_dob_day = date('j', strtotime($p['ins_dob']));
                                        $ins_dob_year = date('Y', strtotime($p['ins_dob']));
                                ?>
                                <select id="ins_dob_month" name="ins_dob_month" class="validate">
                                        <option value=''>Month</option>
                                        <?php
                                                for($i=1;$i<=12;$i++){ ?>
                                                        <option <?= (($ins_dob_month==$i)?'selected="selected"':''); ?> value="<?= $i; ?>"><?= $i; ?></option>
                                                <?php }
                                        ?>
                                </select>
                                <select id="ins_dob_day" name="ins_dob_day" class="validate">
                                        <option value=''>Day</option>
                                        <?php
                                                for($i=1;$i<=31;$i++){ ?>
                                                     <option <?= (($ins_dob_day==$i)?'selected="selected"':''); ?> value="<?= $i; ?>"><?= $i; ?></option>
                                                <?php }
                                        ?>
                                </select>
                                <select id="ins_dob_year" name="ins_dob_year" class="validate">
                                        <option value=''>Year</option>
                                        <?php
                                        for($i=(date('Y'))-12;$i>=1915;$i--){ ?>                                                                                                    
                                                <option <?= (($ins_dob_year==$i)?'selected="selected"':''); ?> value="<?= $i; ?>"><?= $i; ?></option>
                                        <?php }
                                        ?>
                                </select>

       	  	</div>
			<?php
				$p_m_sql = "SELECT * FROM dental_patient_insurance WHERE insurancetype='1' AND patientid='".mysql_real_escape_string($_SESSION['pid'])."'";
				$p_m_q = mysql_query($p_m_sql);
				$p_m_r = mysql_fetch_assoc($p_m_q);
                                if(mysql_num_rows($p_m_q)=='0'){
                                        $p_m_sql = "SELECT c.* FROM dental_contact c inner join dental_patients p on p.p_m_ins_co=c.contactid WHERE p.patientid='".mysql_real_escape_string($_SESSION['pid'])."'";
                                        $p_m_q = mysql_query($p_m_sql);
                                        $p_m_r = mysql_fetch_assoc($p_m_q);
                                }

			?>
			<input type="hidden" name="p_m_patient_insuranceid" value="<?= $p_m_r['id']; ?>" />
                <div class="sepH_b">
                        <label class="lbl_a"><strong>7a.</strong> Insurance Company</label>
			<input class="inpt_a validate" id="p_m_ins_company" name="p_m_ins_company" type="text" value="<?= $p_m_r['company']; ?>" />
           	</div>
                <div class="sepH_b half">
                        <label class="lbl_a"><strong>7b.</strong> Address 1</label>
                        <input class="inpt_a" id="p_m_ins_address1" name="p_m_ins_address1" type="text" value="<?= $p_m_r['address1']; ?>" />
                </div>
                <div class="sepH_b half">
                        <label class="lbl_a"><strong>7c.</strong> Address 2</label>
                        <input class="inpt_a" id="p_m_ins_address2" name="p_m_ins_address2" type="text" value="<?= $p_m_r['address2']; ?>" />
                </div>
                <div class="sepH_b third">
                        <label class="lbl_a"><strong>7d.</strong> City</label>
                        <input class="inpt_a" id="p_m_ins_city" name="p_m_ins_city" type="text" value="<?= $p_m_r['city']; ?>" />
                </div>
                <div class="sepH_b third">
                        <label class="lbl_a"><strong>7e.</strong> State</label>
                        <input class="inpt_a" id="p_m_ins_state" name="p_m_ins_state" type="text" value="<?= $p_m_r['state']; ?>" />
                </div>
                <div class="sepH_b third">
                        <label class="lbl_a"><strong>7f.</strong> Zip</label>
                        <input class="inpt_a" id="p_m_ins_zip" name="p_m_ins_zip" type="text" value="<?= $p_m_r['zip']; ?>" />
                </div>
                <div class="sepH_b third">
                        <label class="lbl_a"><strong>7g.</strong> Phone</label>
                        <input class="inpt_a" id="p_m_ins_phone" name="p_m_ins_phone" type="text" value="<?= $p_m_r['phone']; ?>" />
                </div>
                <div class="sepH_b third">
                        <label class="lbl_a"><strong>7h.</strong> Fax</label>
                        <input class="inpt_a" id="p_m_ins_fax" name="p_m_ins_fax" type="text" value="<?= $p_m_r['fax']; ?>" />
                </div>
                <div class="sepH_b third">
                        <label class="lbl_a"><strong>7i.</strong> Email</label>
                        <input class="inpt_a" id="p_m_ins_email" name="p_m_ins_email" type="text" value="<?= $p_m_r['email']; ?>" />
                </div>

                <div class="sepH_b third">
                        <label class="lbl_a"><strong>8.</strong> Insurance ID.</label><input class="inpt_a validate" id="p_m_party" name="p_m_ins_id" type="text" class="field text addr tbox" value="<?=$p['p_m_ins_id']?>" maxlength="255" />
                </div>
                <div class="sepH_b third">
                        <label class="lbl_a"><strong>9.</strong> Group #</label><input class="inpt_a validate" id="p_m_ins_grp" name="p_m_ins_grp" type="text" class="field text addr tbox" value="<?=$p['p_m_ins_grp']?>" maxlength="255" />
                </div>
                <div class="sepH_b third">
                        <label class="lbl_a"><strong>10.</strong> Plan Name</label><input class="inpt_a validate" id="p_m_ins_plan" name="p_m_ins_plan" type="text" value="<?=$p['p_m_ins_plan']?>" maxlength="255" />
<br />
                </div>
		<div class="sepH_b clear">
			<label class="lbl_a"><strong>11.</strong> Do you have secondary insurance?</label>
			<input class="validate" onclick="updateNext('Yes');" type="radio" name="has_s_m_ins" <?= ($p['has_s_m_ins']=="Ydes")?'checked="checked"':''; ?> value="Yes" />Yes 
			<input onclick="updateNext('No');" type="radio" id="has_s_m_ins_no" name="has_s_m_ins" <?= ($p['has_s_m_ins']=="No")?'checked="checked"':''; ?> value="No" />No</span>
		</div>
                                                                                                                <div class="cf">
															<a href="javascript:void(0)" class="fl prev btn btn_a">&laquo; Back</a>
<?php if($p['has_s_m_ins']=="No"){ ?>
<a href="javascript:void(0)" id="insNext2" class="fr next2 btn btn_d">Proceed &raquo;</a>
<a href="javascript:void(0)" id="insNext" class="fr next btn btn_d" style="display:none">Proceed &raquo;</a>
<?php }else{ ?>
<a href="javascript:void(0)" id="insNext" class="fr next btn btn_d">Proceed &raquo;</a>
<a href="javascript:void(0)" id="insNext2" class="fr next2 btn btn_d" style="display:none">Proceed &raquo;</a>
<?php } ?>
                                                                                                                </div>
                                                                                                        </div>
                                                                                                </div>
                                                                                        </div>
                                                                                </div>
                                                                        </div>

                                                                        <div class="page">
                                                                                <div class="pageInside">
                                                                                        <div class="cf">
                                                                                                <div class="dp25">
                                                                                                        <h3 class="sepH_a">Secondary Insurance</h3>
                                                                                                        <p class="s_color small">Do you have additional insurance in addition to primary insurance coverage?  If so, please accurately complete all fields on this page to help Dental Sleep Solutions maximize your potential insurance coverage.  Refer to your medical insurance card for this information.</p>
                                                                                                </div>
                                                                                                <div class="dp75">
                                                                                                        <div>
                                                                                                                <div class="form_errors" style="display:none"></div>

                <div class="sepH_b">
                        <label class="lbl_a">Please complete the information below for the PRIMARY INSURED PARTY listed on your SECONDARY insurance card.</label>
                </div>
                <div class="sepH_b">
                        <label class="lbl_a"><strong>1.</strong> Your relationship to primary insured:</label><select class="inpt_a validate" id="s_m_relation" name="s_m_relation" >
                                                                        <option value="" <? if($p['s_m_relation'] == '') echo " selected";?>>None</option>
                                                                        <option value="Self" <? if($p['s_m_relation'] == 'Self') echo " selected";?>>Self</option>
                                                                        <option value="Spouse" <? if($p['s_m_relation'] == 'Spouse') echo " selected";?>>Spouse</option>
                                                                        <option value="Child" <? if($p['s_m_relation'] == 'Child') echo " selected";?>>Child</option>
                                                                        <option value="Other" <? if($p['s_m_relation'] == 'Other') echo " selected";?>>Other</option>
                                                                </select>
                </div>
                <div class="sepH_b third">
                        <label class="lbl_a"><strong>2.</strong> First Name:</label><input class="inpt_a validate" id="s_m_partyfname" name="s_m_partyfname" type="text" value="<?=$p['s_m_partyfname']?>" maxlength="255" />
                </div>
                <div class="sepH_b third">
                        <label class="lbl_a"><strong>3.</strong> Middle Name:</label><input class="inpt_a" id="s_m_partymname" name="s_m_partymname" type="text" value="<?=$p['s_m_partymname']?>" maxlength="255" />
                </div>
                <div class="sepH_b third">
                        <label class="lbl_a"><strong>4.</strong> Last Name:</label><input class="inpt_a validate" id="s_m_partylname" name="s_m_partylname" type="text" value="<?=$p['s_m_partylname']?>" maxlength="255" />
                </div>
                <div class="sepH_b clear" id="ins2_dob_div">
                        <label class="lbl_a"><strong>5.</strong> Date of Birth:</label>
                                <?php
                                        $ins2_dob_month = date('m', strtotime($p['ins2_dob']));
                                        $ins2_dob_day = date('j', strtotime($p['ins2_dob']));
                                        $ins2_dob_year = date('Y', strtotime($p['ins2_dob']));
                                ?>
                                <select name="ins2_dob_month" id="ins2_dob_month" class="validate">
                                        <option value=''>Month</option>
                                        <?php
                                                for($i=1;$i<=12;$i++){ ?>
                                                        <option <?= (($ins2_dob_month==$i)?'selected="selected"':''); ?> value="<?= $i; ?>"><?= $i; ?></option>
                                                <?php }
                                        ?>
                                </select>
                                <select name="ins2_dob_day" id="ins2_dob_day" class="validate">
                                        <option value=''>Day</option>
                                        <?php
                                                for($i=1;$i<=31;$i++){ ?>
                                                     <option <?= (($ins2_dob_day==$i)?'selected="selected"':''); ?> value="<?= $i; ?>"><?= $i; ?></option>
                                                <?php }
                                        ?>
                                </select>
                                <select name="ins2_dob_year" id="ins2_dob_year" class="validate">
                                        <option value=''>Year</option>
                                        <?php
                                        for($i=(date('Y'))-12;$i>=1915;$i--){ ?>                                                                                                    
                                                <option <?= (($ins2_dob_year==$i)?'selected="selected"':''); ?> value="<?= $i; ?>"><?= $i; ?></option>
                                        <?php }
                                        ?>
                                </select>

                </div>
                        <?php
                                $s_m_sql = "SELECT * FROM dental_patient_insurance WHERE insurancetype='2' AND patientid='".mysql_real_escape_string($_SESSION['pid'])."'";
                                $s_m_q = mysql_query($s_m_sql);
                                $s_m_r = mysql_fetch_assoc($s_m_q);
				if(mysql_num_rows($s_m_q)=='0'){
					$s_m_sql = "SELECT c.* FROM dental_contact c inner join dental_patients p on p.s_m_ins_co=c.contactid WHERE p.patientid='".mysql_real_escape_string($_SESSION['pid'])."'";
					$s_m_q = mysql_query($s_m_sql);
					$s_m_r = mysql_fetch_assoc($s_m_q);
				}
                        ?>
                        <input type="hidden" name="s_m_patient_insuranceid" value="<?= $s_m_r['id']; ?>" />
                <div class="sepH_b">
                        <label class="lbl_a"><strong>6a.</strong> Insurance Company</label>
                        <input class="inpt_a validate" id="s_m_ins_company" name="s_m_ins_company" type="text" value="<?= $s_m_r['company']; ?>" />
                </div>
                <div class="sepH_b half">
                        <label class="lbl_a"><strong>6b.</strong> Address 1</label>
                        <input class="inpt_a" id="s_m_ins_address1" name="s_m_ins_address1" type="text" value="<?= $s_m_r['address1']; ?>" />
                </div>
                <div class="sepH_b half">
                        <label class="lbl_a"><strong>6c.</strong> Address 2</label>
                        <input class="inpt_a" id="s_m_ins_address2" name="s_m_ins_address2" type="text" value="<?= $s_m_r['address2']; ?>" />
                </div>
                <div class="sepH_b third">
                        <label class="lbl_a"><strong>6d.</strong> City</label>
                        <input class="inpt_a" id="s_m_ins_city" name="s_m_ins_city" type="text" value="<?= $s_m_r['city']; ?>" />
                </div>
                <div class="sepH_b third">
                        <label class="lbl_a"><strong>6e.</strong> State</label>
                        <input class="inpt_a" id="s_m_ins_state" name="s_m_ins_state" type="text" value="<?= $s_m_r['state']; ?>" />
                </div>
                <div class="sepH_b third">
                        <label class="lbl_a"><strong>6f.</strong> Zip</label>
                        <input class="inpt_a" id="s_m_ins_zip" name="s_m_ins_zip" type="text" value="<?= $s_m_r['zip']; ?>" />
                </div>
                <div class="sepH_b third">
                        <label class="lbl_a"><strong>6g.</strong> Phone</label>
                        <input class="inpt_a" id="s_m_ins_phone" name="s_m_ins_phone" type="text" value="<?= $s_m_r['phone']; ?>" />
                </div>
                <div class="sepH_b third">
                        <label class="lbl_a"><strong>6h.</strong> Fax</label>
                        <input class="inpt_a" id="s_m_ins_fax" name="s_m_ins_fax" type="text" value="<?= $s_m_r['fax']; ?>" />
                </div>
                <div class="sepH_b third">
                        <label class="lbl_a"><strong>6i.</strong> Email</label>
                        <input class="inpt_a" id="s_m_ins_email" name="s_m_ins_email" type="text" value="<?= $s_m_r['email']; ?>" />     
                </div>
                <div class="sepH_b third">
                        <label class="lbl_a"><strong>7.</strong> Insurance ID.</label><input class="inpt_a validate" id="s_m_party" name="s_m_ins_id" type="text" value="<?=$p['s_m_ins_id']?>" maxlength="255" />
                </div>
                <div class="sepH_b third">
                        <label class="lbl_a"><strong>8.</strong> Group #</label><input class="inpt_a validate" id="s_m_ins_grp" name="s_m_ins_grp" type="text" value="<?=$p['s_m_ins_grp']?>" maxlength="255" />
                </div>
                <div class="sepH_b third">
                        <label class="lbl_a"><strong>9.</strong> Plan Name</label><input class="inpt_a validate" id="s_m_ins_plan" name="s_m_ins_plan" type="text" value="<?=$p['s_m_ins_plan']?>" maxlength="255" />
                </div>
                                                                                                                <div class="cf">
															<a href="javascript:void(0)" class="fl prev btn btn_a">&laquo; Back</a>

<a href="javascript:void(0)" id="insNext" class="fr next btn btn_d">Proceed &raquo;</a>
                                                                                                                </div>
                                                                                                        </div>
                                                                                                </div>
                                                                                        </div>
                                                                                </div>
                                                                        </div>



                                                                        <div class="page">
                                                                                <div class="pageInside">
                                                                                        <div class="cf">
                                                                                                <div class="dp25">
                                                                                                        <h3 class="sepH_a">Employer Information</h3>
                                                                                                        <p class="s_color small">Please provide your employer information.</p>
                                                                                                </div>
                                                                                                <div class="dp75">
                                                                                                        <div>
                                                                                                                <div class="form_errors" style="display:none"></div>


                <div class="sepH_b">
                        <label class="lbl_a"><strong>1.</strong> Employer:</label><input class="inpt_a" id="employer" name="employer" type="text" value="<?php echo $p['employer']; ?>" maxlength="255"/>
                </div>
                <div class="sepH_b">
                        <label class="lbl_a"><strong>2.</strong> Address 1:</label><input class="inpt_a" id="emp_add1" name="emp_add1" type="text" value="<?=$p['emp_add1']?>" maxlength="255"/>
                </div>
                <div class="sepH_b">
                        <label class="lbl_a"><strong>3.</strong> Address 2:</label><input class="inpt_a" id="emp_add2" name="emp_add2" type="text" value="<?=$p['emp_add2']?>" maxlength="255" />
                </div>
                <div class="sepH_b third">
                        <label class="lbl_a"><strong>4.</strong> City:</label><input class="inpt_a" id="emp_city" name="emp_city" type="text" value="<?=$p['emp_city']?>" maxlength="255" />
                </div>
                <div class="sepH_b third">
			<?php $s = $p['emp_state']; ?>
                        <label class="lbl_a"><strong>5.</strong> State:</label>
			<select  data-placeholder="Choose a state..." class="chzn-select" id="emp_state" name="emp_state">
                                <option value=""></option>
                                <option <?= ($s=='AK')?'selected="selected"':'' ?> value="AK">AK - Alaska</option>
                                <option <?= ($s=='AL')?'selected="selected"':'' ?> value="AL">AL - Alabama</option>
                                <option <?= ($s=='AR')?'selected="selected"':'' ?> value="AR">AR - Arkansas</option>
                                <option <?= ($s=='AZ')?'selected="selected"':'' ?> value="AZ">AZ - Arizona</option>
                                <option <?= ($s=='CA')?'selected="selected"':'' ?> value="CA">CA - California</option>
                                <option <?= ($s=='CO')?'selected="selected"':'' ?> value="CO">CO - Colorado</option>
                                <option <?= ($s=='CT')?'selected="selected"':'' ?> value="CT">CT - Connecticut</option>
                                <option <?= ($s=='DC')?'selected="selected"':'' ?> value="DC">DC - District of Columbia</option>
                                <option <?= ($s=='DE')?'selected="selected"':'' ?> value="DE">DE - Delaware</option>
                                <option <?= ($s=='FL')?'selected="selected"':'' ?> value="FL">FL - Florida</option>
                                <option <?= ($s=='GA')?'selected="selected"':'' ?> value="GA">GA - Georgia</option>
                                <option <?= ($s=='HI')?'selected="selected"':'' ?> value="HI">HI - Hawaii</option>
                                <option <?= ($s=='IA')?'selected="selected"':'' ?> value="IA">IA - Iowa</option>
                                <option <?= ($s=='ID')?'selected="selected"':'' ?> value="ID">ID - Idaho</option>
                                <option <?= ($s=='IL')?'selected="selected"':'' ?> value="IL">IL - Illinois</option>
                                <option <?= ($s=='IN')?'selected="selected"':'' ?> value="IN">IN - Indiana</option>
                                <option <?= ($s=='KS')?'selected="selected"':'' ?> value="KS">KS - Kansas</option>
                                <option <?= ($s=='KY')?'selected="selected"':'' ?> value="KY">KY - Kentucky</option>
                                <option <?= ($s=='LA')?'selected="selected"':'' ?> value="LA">LA - Louisiana</option>
                                <option <?= ($s=='MA')?'selected="selected"':'' ?> value="MA">MA - Massachusetts</option>
                                <option <?= ($s=='MD')?'selected="selected"':'' ?> value="MD">MD - Maryland</option>
                                <option <?= ($s=='ME')?'selected="selected"':'' ?> value="ME">ME - Maine</option>
                                <option <?= ($s=='MI')?'selected="selected"':'' ?> value="MI">MI - Michigan</option>
                                <option <?= ($s=='MN')?'selected="selected"':'' ?> value="MN">MN - Minnesota</option>
                                <option <?= ($s=='MO')?'selected="selected"':'' ?> value="MO">MO - Missouri</option>
                                <option <?= ($s=='MS')?'selected="selected"':'' ?> value="MS">MS - Mississippi</option>
                                <option <?= ($s=='MT')?'selected="selected"':'' ?> value="MT">MT - Montana</option>
                                <option <?= ($s=='NC')?'selected="selected"':'' ?> value="NC">NC - North Carolina</option>
                                <option <?= ($s=='ND')?'selected="selected"':'' ?> value="ND">ND - North Dakota</option>
                                <option <?= ($s=='NE')?'selected="selected"':'' ?> value="NE">NE - Nebraska</option>
                                <option <?= ($s=='NH')?'selected="selected"':'' ?> value="NH">NH - New Hampshire</option>
                                <option <?= ($s=='NJ')?'selected="selected"':'' ?> value="NJ">NJ - New Jersey</option>
                                <option <?= ($s=='NM')?'selected="selected"':'' ?> value="NM">NM - New Mexico</option>
                                <option <?= ($s=='NV')?'selected="selected"':'' ?> value="NV">NV - Nevada</option>
                                <option <?= ($s=='NY')?'selected="selected"':'' ?> value="NY">NY - New York</option>
                                <option <?= ($s=='OH')?'selected="selected"':'' ?> value="OH">OH - Ohio</option>
                                <option <?= ($s=='OK')?'selected="selected"':'' ?> value="OK">OK - Oklahoma</option>
                                <option <?= ($s=='OR')?'selected="selected"':'' ?> value="OR">OR - Oregon</option>
                                <option <?= ($s=='PA')?'selected="selected"':'' ?> value="PA">PA - Pennsylvania</option>
                                <option <?= ($s=='RI')?'selected="selected"':'' ?> value="RI">RI - Rhode Island</option>
                                <option <?= ($s=='SC')?'selected="selected"':'' ?> value="SC">SC - South Carolina</option>
                                <option <?= ($s=='SD')?'selected="selected"':'' ?> value="SD">SD - South Dakota</option>
                                <option <?= ($s=='TN')?'selected="selected"':'' ?> value="TN">TN - Tennessee</option>
                                <option <?= ($s=='TX')?'selected="selected"':'' ?> value="TX">TX - Texas</option>
                                <option <?= ($s=='UT')?'selected="selected"':'' ?> value="UT">UT - Utah</option>
                                <option <?= ($s=='VA')?'selected="selected"':'' ?> value="VA">VA - Virginia</option>
                                <option <?= ($s=='VT')?'selected="selected"':'' ?> value="VT">VT - Vermont</option>
                                <option <?= ($s=='WA')?'selected="selected"':'' ?> value="WA">WA - Washington</option>
                                <option <?= ($s=='WI')?'selected="selected"':'' ?> value="WI">WI - Wisconsin</option>
                                <option <?= ($s=='WV')?'selected="selected"':'' ?> value="WV">WV - West Virginia</option>
                                <option <?= ($s=='WY')?'selected="selected"':'' ?> value="WY">WY - Wyoming</option>
			</select>


                </div>
                <div class="sepH_b third">
                        <label class="lbl_a"><strong>6.</strong> Zip Code:</label><input class="inpt_a" id="emp_zip" name="emp_zip" type="text" value="<?=$p['emp_zip']?>" maxlength="255" />
                </div>
                <div class="sepH_b clear half">
                        <label class="lbl_a"><strong>7.</strong> Phone:</label><input class="inpt_a" id="emp_phone" name="emp_phone" type="text" value="<?=$p['emp_phone']?>" maxlength="255" />
                </div>
                <div class="sepH_b half">
                        <label class="lbl_a"><strong>8.</strong> Fax:</label><input class="inpt_a" id="emp_fax" name="emp_fax" type="text" value="<?=$p['emp_fax']?>"   maxlength="255" />
		</div>

                                                                                                                <div class="cf">
			<a href="javascript:void(0)" id="insPrev" class="fl prev btn btn_a" <?= ($p['has_s_m_ins']=="No")?'style="display:none;"':''; ?>>&laquo; Back</a>
			<a href="javascript:void(0)" id="insPrev2" class="fl prev2 btn btn_a" <?= ($p['has_s_m_ins']=="No")?'':'style="display:none;"'; ?>>&laquo; Back</a>

<a href="javascript:void(0)" id="insNext" class="fr next btn btn_d">Proceed &raquo;</a>
                                                                                                                </div>
                                                                                                        </div>
                                                                                                </div>
                                                                                        </div>
                                                                                </div>
                                                                        </div>
                                                                        <div class="page">
                                                                                <div class="pageInside">
                                                                                        <div class="cf">
                                                                                                <div class="dp25">
                                                                                                        <h3 class="sepH_a">Medical Contacts</h3>
                                                                                                        <p class="s_color small">Dental Sleep Solutions cares about providing the best possible treatment to you.  We regularly contact your other medical providers to make them aware of your progress throughout treatment.  This helps ensure all your medical providers coordinate care to maximize the effectiveness of your treatment.  Please list your other healthcare providers here.</p>
                                                                                                </div>
                                                                                                <div class="dp75">
                                                                                                        <div>
                                                                                                                <div class="form_errors" style="display:none"></div>
<?php 
$types = array(DSS_PATIENT_CONTACT_SLEEP, DSS_PATIENT_CONTACT_PRIMARY, DSS_PATIENT_CONTACT_DENTIST, DSS_PATIENT_CONTACT_ENT, DSS_PATIENT_CONTACT_OTHER);
foreach($types as $t){
                switch($t){
                        case '1':
                                $cid = $p['docsleep'];
                                break;
                        case '2':
                                $cid = $p['docpcp'];
                                break;
                        case '3':
                                $cid = $p['docdentist'];
                                break;
                        case '4':
                                $cid = $p['docent'];
                                break;
                        case '5':
                                $cid = $p['docmdother'];
                                break;
			default:
				$cid = 0;
				break;

                }
		$pcnum = 0;
		if($cid == 0){
			$pcsql = "SELECT * from dental_patient_contacts WHERE contacttype='".$t."' AND patientid='".mysql_real_escape_string($_SESSION['pid'])."'";
			$pcq = mysql_query($pcsql);
			$pc = mysql_fetch_assoc($pcq);
			$pcnum = mysql_num_rows($pcq);
		}

                                $csql = "SELECT firstname, lastname FROM dental_contact WHERE contactid='".$cid."'";
                                $cq = mysql_query($csql);
				$cr = mysql_fetch_assoc($cq);
                                $cname = $cr['firstname']. " ".$cr['lastname'];
?>
		<h5 class="clear"><?= $dss_patient_contact_labels[$t]; ?></h5>
                                        <div id="pc_<?= $t; ?>_person" <?= ($pcnum!=0)?'style="display:none;"':''; ?>>
			<label class="lbl_a"><strong>1.</strong> Name:</label>
			

                                        <input type="text" class="inpt_a dr" id="pc_<?= $t; ?>_name" onclick="updateval(this)" autocomplete="off" name="pc_<?= $t; ?>_name" value="<?= ($cname!=' ')?$cname:'Type doctor name'; ?>" style="width:300px;" />
<br />
        <div id="pc_<?= $t; ?>_hints" class="search_hints" style="margin-top:20px; display:none;">
                <ul id="pc_<?= $t; ?>_list" class="search_list">
                        <li class="template" style="display:none">Doe, John S</li>
                </ul>
        </div><script type="text/javascript">
$(document).ready(function(){
  setup_autocomplete('pc_<?= $t; ?>_name', 'pc_<?= $t; ?>_hints', 'pc_<?= $t; ?>_referred_by', 'pc_<?= $t; ?>_referred_source', 'list_referrers.php', '<?= $t; ?>');
});
</script>

                            </div>
        <input type="hidden" id="pc_<?= $t; ?>_contactid" name="pc_<?= $t; ?>_contactid" value="<?= $cid; ?>" /> 
	<input type="hidden" id="pc_<?= $t; ?>_patient_contactid" name="pc_<?= $t; ?>_patient_contactid" value="<?= $pc['id']; ?>" />
	<div id="pc_<?= $t; ?>_input_div" <?= ($pcnum>0)?'':'style="display:none;"'; ?>>
		<div class="sepHb half">
                        <label class="lbl_a"><strong>1.</strong> First Name:</label><input class="inpt_a" id="pc_<?= $t; ?>_firstname" name="pc_<?= $t; ?>_firstname" type="text" value="<?=$pc['firstname']?>"   maxlength="100" />
                </div>
                <div class="sepH_b half">
                        <label class="lbl_a"><strong>2.</strong> Last Name:</label><input class="inpt_a" id="pc_<?= $t; ?>_lastname" name="pc_<?= $t; ?>_lastname" type="text" value="<?=$pc['lastname']?>"   maxlength="100" />
                </div>
                <div class="sepH_b half">
                        <label class="lbl_a"><strong>3.</strong> Address 1:</label><input class="inpt_a" id="pc_<?= $t; ?>_address1" name="pc_<?= $t; ?>_address1" type="text" value="<?=$pc['address1']?>"   maxlength="100" />
                </div>
                <div class="sepH_b half">
                        <label class="lbl_a"><strong>4.</strong> Address 2:</label><input class="inpt_a" id="pc_<?= $t; ?>_address2" name="pc_<?= $t; ?>_address2" type="text" value="<?=$pc['address2']?>"   maxlength="100" />
                </div>
                <div class="sepH_b third">
                        <label class="lbl_a"><strong>5.</strong> City:</label><input class="inpt_a" id="pc_<?= $t; ?>_city" name="pc_<?= $t; ?>_city" type="text" value="<?=$pc['city']?>"   maxlength="100" />
                </div>
                <div class="sepH_b third">
                        <label class="lbl_a"><strong>6.</strong> State:</label><input class="inpt_a" id="pc_<?= $t; ?>_state" name="pc_<?= $t; ?>_state" type="text" value="<?=$pc['state']?>"   maxlength="100" />
                </div>
                <div class="sepH_b third">
                        <label class="lbl_a"><strong>7.</strong> Zip:</label><input class="inpt_a" id="pc_<?= $t; ?>_zip" name="pc_<?= $t; ?>_zip" type="text" value="<?=$pc['zip']?>"   maxlength="100" />
                </div>
                <div class="sepH_b half clear">
                        <label class="lbl_a"><strong>8.</strong> Phone:</label><input class="inpt_a" id="pc_<?= $t; ?>_phone" name="pc_<?= $t; ?>_phone" type="text" value="<?=$pc['phone']?>"   maxlength="100" />
                </div>
                <div class="sepH_b half">
                        <button onclick="cancel('<?= $t; ?>'); return false;" class="fl btn btn_a">Cancel</button>
                </div>
	</div>

<?php } ?>
                                                                                                                <div class="cf">
															<a href="javascript:void(0)" class="fl prev btn btn_a">&laquo; Back</a>
                                                                                                                        <button type="submit" name="update" class="fr next btn btn_d">Submit &raquo;</button>
                                                                                                                </div>
                                                                                                        </div>
                                                                                                </div>
                                                                                        </div>
                                                                                </div>
                                                                        </div>
<div class="page">
										<div class="pageInside">
											<div class="last sepH_c">
												<h3 class="sepH_b">Congratulations!</h3>
												<p  class="sepH_b">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer diam quam, lobortis eget ornare sit amet, sollicitudin at sapien. Suspendisse nec lectus ut arcu mattis mattis vel ut mi. Donec congue tincidunt sollicitudin. Phasellus varius euismod nisl, at blandit nibh suscipit suscipit. Morbi quis nisl sem. Praesent malesuada leo enim. Praesent est lectus, commodo at accumsan varius, bibendum ac nisi. Nulla eu erat sit amet enim consequat condimentum. Nam nulla neque, sagittis ut fringilla sed, vestibulum sit amet libero.</p>
												<pre id="form_summary"></pre>
											</div>

											<div class="cf">
												<a href="javascript:void(0)" class="fl prev btn btn_a">&laquo; Back</a>
												<a href="symptoms.php" class="fr btn btn_d">Start Questionnaire</a>
											</div>
										</div>
									</div>
								</div>
			</div></div>
	</form>  
<div style="clear:both;"></div>
<script type="text/javascript">
$(document).ready(function(){
$(".chzn-select").chosen({no_results_text: "No results matched"});
});

function cancel(n){
  $('#pc_'+n+'_input_div').hide();
  $('#pc_'+n+'_person').show();
  $('#pc_'+n+'_input_div input').val('');
}


</script>
<?php include 'includes/footer.php'; ?>
