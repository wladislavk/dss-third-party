<?php namespace Ds3\Legacy; ?><?php session_start();
  if(!isset($_SESSION['pid'])){
    ?><script type="text/javascript">window.location = "login.php";</script><?php
    die();
  }

include 'includes/header.php';
include 'includes/completed.php';
?>
<link rel="stylesheet" href="css/register.css" />
<!--[if IE]>
        <link rel="stylesheet" type="text/css" href="css/register_ie.css" />
<![endif]-->
<script type="text/javascript" src="js/register.js"></script>
<script type="text/javascript" src="js/patient_dob.js"></script>
<script type="text/javascript" src="js/autocomplete.js"></script>
<script type="text/javascript" src="js/register_masks.js"></script>
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

						<h2 class="sepH_c">Step-by-Step Patient Registration </h2>
	<form action="register.php" name="register_form" id="register_form" method="post">
		<input type="hidden" id="last_reg_sect" name="last_reg_sect" value="<?= $p['last_reg_sect']; ?>" />
		<input type="hidden" id="patientid" name="patientid" value="<?= $_SESSION['pid']; ?>" />
							<ul id="status" class="cf">
							<?php $pagenum = 1; ?>
							<?php if(!$p['registered']){ ?>
								<li class="active"><span class="large"><?= $pagenum++; ?>. Welcome</span></li>
							<?php } ?>
								<li <?= (!$p['registered'])?'':'class="active"'; ?>><span class="large"><?= $pagenum++; ?>. Contact Info</span></li>
								<li><span class="large"><?= $pagenum++; ?>. Personal Info</span></li>
								<li><span class="large"><?= $pagenum++; ?>. Insurance</span></li>
								<li><span class="large"><?= $pagenum++; ?>. 2nd Insurance</span></li>
								<li><span class="large"><?= $pagenum++; ?>. Employer</span></li>
								<li><span class="large"><?= $pagenum++; ?>. Contacts</span></li>
							</ul>
							<div id="register" class="wizard" style="height:1400px;">
								<div class="items formEl_a">
                                                        <?php if(!$p['registered']){ ?>
                                                                        <div class="page">
                                                                                <div class="pageInside">
                                                                                        <div class="cf">
                                                                                                <div class="dp100">
                                                                                                        <h3 class="sepH_a">Welcome!</h3>
                                                                                                        <p>Please accurately complete the information on the following pages. This will save you time at your next appointment, and allow you to avoid completing additional forms later. All information you input here is securely stored using the latest encryption technology that meets or exceeds HIPAA medical privacy standards, and you can access and update your information anytime.  We take your privacy seriously, and we never share your information without your consent.  We're excited to see you at your next visit!</p>
<br />
                                                                                                                <div class="cf">
<a href="javascript:void(0)" class="fr next btn btn_d">Proceed &raquo;</a>
                                                                                                                </div>

	                                                                                                </div>
												</div>
											</div>
										</div>
																						
<?php } ?>

									<div class="page">
										<div class="pageInside">
											<div class="cf">
												<div class="dp25">
													<h3 class="sepH_a">Welcome!</h3>
													<p class="s_color small">Please accurately complete the information on the following pages. This will save you time at your next appointment, and allow you to avoid completing additional forms later. All information you input here is securely stored using the latest encryption technology that meets or exceeds HIPAA medical privacy standards, and you can access and update your information anytime.  We take your privacy seriously, and we never share your information without your consent.  We're excited to see you at your next visit!</p>
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
		<div class="sepH_b third clear">
                        <label class="lbl_a"><strong>4.</strong> Preferred Name</label>
                        <input class="inpt_a" type="text" name="preferred_name" id="preferred_name" value="<?= $p['preferred_name']; ?>" />
                </div>
                <div class="sepH_b half">
			<input class="inpt_a validate" type="hidden" id="oldemail" name="oldemail" value="<?= $p['email']; ?>" />
                        <label class="lbl_a"><strong>5.</strong> Email:</label><input class="inpt_a validate" type="text" id="email" name="email" value="<?= $p['email']; ?>" />
                </div>
                <div class="sepH_b third">
                        <label class="lbl_a"><strong>6.</strong> Home Phone:</label><input class="inpt_a phonemask" type="text" id="home_phone" name="home_phone" value="<?= $p['home_phone']; ?>" />
                </div>
                <div class="sepH_b third">
                        <label class="lbl_a"><strong>7.</strong> Work Phone:</label><input class="inpt_a extphonemask" type="text" id="work_phone" name="work_phone" value="<?= $p['work_phone']; ?>" />
                </div>
                <div class="sepH_b third">
                        <label class="lbl_a"><strong>8.</strong> Cell Phone:</label><input class="inpt_a validate phonemask" type="text" id="cell_phone" name="cell_phone" value="<?= $p['cell_phone']; ?>" />
                </div>
                <div class="sepH_b clear">
                        <label class="lbl_a"><strong>9.</strong> Address 1:</label><input class="inpt_a validate" type="text" name="add1" value="<?= $p['add1']; ?>" />
                </div>
                <div class="sepH_b">
                        <label class="lbl_a"><strong>10.</strong> Address 2:</label><input class="inpt_a" type="text" name="add2" value="<?= $p['add2']; ?>" />
                </div>
                <div class="sepH_b third">
                        <label class="lbl_a"><strong>11.</strong> City:</label><input class="inpt_a validate" type="text" name="city" value="<?= $p['city']; ?>" />
                </div>
                <div class="sepH_b third">
			<?php $s = $p['state']; ?>
                        <label class="lbl_a"><strong>12.</strong> State:</label>
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
                        <label class="lbl_a"><strong>13.</strong> Zip:</label><input class="inpt_a validate" type="text" name="zip" value="<?= $p['zip']; ?>" />
                </div>
														<div class="cf">
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
					if($p['dob']!=''){
						$dob_month = date('m', strtotime($p['dob']));
                                        	$dob_day = date('j', strtotime($p['dob']));
                                        	$dob_year = date('Y', strtotime($p['dob']));
					}else{
						$dob_month = '';
                                                $dob_day = '';
                                                $dob_year = '';
					}
				?>
                                <select class="validate" id="dob_month" name="dob_month">
                                        <option <?= ($dob_month=='')?'selected="selected"':''; ?> value=''>Month</option>
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
                                        for($i=(date('Y'))-10;$i>=1902;$i--){ ?>                                                                                                                
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
                        <label class="lbl_a"><strong>3.</strong> Marital Status:</label><select class="inpt_a validate" name="marital_status">
                                <option value=''>Select</option>
                                <option value="Married" <?= ($p['marital_status']=="Married")?'selected="selected"':'';?>>Married</option>
                                <option value="Single" <?= ($p['marital_status']=="Single")?'selected="selected"':'';?>>Single</option>
                                <option value="Life Partner" <?= ($p['marital_status']=="Life Partner")?'selected="selected"':'';?>>Life Partner</option>
				<option value="Minor" <?= ($p['marital_status']=="Minor")?'selected="selected"':'';?>>Minor</option>
                                </select>
                </div>
                <div class="sepH_b half">
                        <label class="lbl_a"><strong>4.</strong> Spouse/Partner Name:</label><input class="inpt_a" type="text" name="partner_name" value="<?= $p['partner_name']; ?>" />
                </div>
                <div class="sepH_b half clear">
                        <label class="lbl_a"><strong>5.</strong> Social Security #:</label><input class="inpt_a validate ssnmask" type="text" name="ssn" value="<?= $p['ssn']; ?>" />
                </div>
                <div class="sepH_b half">
                        <label class="lbl_a"><strong>6.</strong> Prefered Method of Contact:</label><select class="inpt_a validate" name="preferredcontact">
                                <option value="paper" <?= ($p['preferredcontact']=="paper")?'selected="selected"':'';?>>Paper Mail</option>
                                <option value="email" <?= ($p['preferredcontact']=="email")?'selected="selected"':'';?>>Email</option>
                                </select>
                </div>
                <script type="text/javascript">
                                function cal_bmi()
                                {
                                        fa = document.register_form;
                                        if(fa.feet.value != 0 && fa.inches.value != -1 && fa.weight.value != 0)
                                        {
                                                var inc = (parseInt(fa.feet.value) * 12) + parseInt(fa.inches.value);
                                                //alert(inc);
                                                
                                                var inc_sqr = parseInt(inc) * parseInt(inc);
                                                var wei = parseInt(fa.weight.value) * 703;
                                                var bmi = parseInt(wei) / parseInt(inc_sqr);
                                                
                                                //alert("BMI " + bmi.toFixed(2));
                                                fa.bmi.value = bmi.toFixed(1);
                                        }
                                        else
                                        {
                                                fa.bmi.value = '';
                                        }
                                }
                        </script>
        <div class="sepH_b fifth">
                <label class="lbl_a">Feet</label>
                            <select name="feet" id="feet" class="inpt_a" tabindex="5" onchange="cal_bmi();" >
                                <option value="0">Feet</option>
                                <? for($i=1;$i<9;$i++)
                                                                {
                                                                ?>
                                                                        <option value="<?=$i?>" <? if($p['feet'] == $i) echo " selected";?>><?=$i?></option>
                                                                <?
                                                                }?>
                            </select>
        </div>
        <div class="sepH_b fifth">
                <label class="lbl_a">Inches</label>
                <select name="inches" id="inches" class="inpt_a" tabindex="6" onchange="cal_bmi();">
                                <option value="-1">Inches</option>
                                <? for($i=0;$i<12;$i++)
                                                                {
                                                                ?>
                                                                        <option value="<?=$i?>" <? if($p['inches']!='' && $p['inches'] == $i) echo " selected";?>><?=$i?></option>
                                                                <?
                                                                }?>
                            </select>
        </div>
        <div class="sepH_b fifth">
                <label class="lbl_a">Weight</label>
                <select name="weight" id="weight" class="inpt_a" tabindex="7" onchange="cal_bmi();">
                                <option value="0">Weight</option>
                                <? for($i=80;$i<=500;$i++)
                                                                {
                                                                ?>
                                                                        <option value="<?=$i?>" <? if($p['weight'] == $i) echo " selected";?>><?=$i?></option>
                                                                <?
                                                                }?>
                            </select>
        </div>
        <div class="sepH_b fifth">
                <label class="lbl_a">BMI</label>
                <input id="bmi" name="bmi" type="text" class="inpt_a" value="<?=$p['bmi']?>" tabindex="8" maxlength="255" readonly="readonly" />
        </div>

                <div class="sepH_b third clear">
                        <label class="lbl_a"><strong>7.</strong> Emergency Contact Name:</label><input class="inpt_a" type="text" name="emergency_name" value="<?= $p['emergency_name']; ?>" />
                </div>
                <div class="sepH_b third">
                        <label class="lbl_a"><strong>8.</strong> Emergency Contact Relationship:</label><input class="inpt_a" type="text" name="emergency_relationship" value="<?= $p['emergency_relationship']; ?>" />
                </div>
                <div class="sepH_b third">
                        <label class="lbl_a"><strong>9.</strong> Emergency Contact Number:</label><input class="inpt_a  extphonemask" type="text" name="emergency_number" value="<?= $p['emergency_number']; ?>" />
		</div>
                <div class="sepH_b clear">
                        <label class="lbl_a"><strong>10.</strong> Do you have medical insurance?</label>
			<?php
			  if($p['has_p_m_ins']=='' && $p['p_m_ins_co']!=''){
			    $p['has_p_m_ins'] = "Yes";
			  }
			?>
                        <input class="validate" onclick="updateNext('Yes', 1);" type="radio" name="has_p_m_ins" <?= ($p['has_p_m_ins']=="Yes")?'checked="checked"':''; ?> value="Yes" />Yes
                        <input onclick="updateNext('No', 1);" type="radio" id="has_p_m_ins_no" name="has_p_m_ins" <?= ($p['has_p_m_ins']=="No")?'checked="checked"':''; ?> value="No" />No</span>
                </div>
                                                                                                                <div class="cf">
															<a href="javascript:void(0)" class="fl prev btn btn_a">&laquo; Back</a>
<a href="javascript:void(0)" id="ins1Next1" class="fr next btn btn_d" <?= ($p['has_p_m_ins']=="No")?'style="display:none;"':'';?>>Proceed &raquo;</a>
<a href="javascript:void(0)" id="ins1Next3" class="fr next3 btn btn_d" <?= ($p['has_p_m_ins']!="No")?'style="display:none;"':'';?>>Proceed &raquo;</a>
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
                                                                                                        <p class="s_color small">Please complete all fields on this page to allow us to verify your medical insurance coverage.  Failure to accurately complete these fields may result in insurance delays and even denial of coverage.  Refer to your medical insurance card for this information.</p>
                                                                                                </div>
                                                                                                <div class="dp75">
                                                                                                        <div>
                                                                                                                <div class="form_errors" style="display:none"></div>
 
                <div class="sepH_b clear">
                        <label class="lbl_a"><strong>1.</strong> Do you have Medicare?</label>
				<input type="radio" name="p_m_ins_type" id="p_m_ins_type_1" value="1" <?= ($p['p_m_ins_type'] == '1')?'checked="checked"':'';?> /> Yes
				<input type="radio" name="p_m_ins_type" class="validate" value="7" <?= ($p['p_m_ins_type'] != '' && $p['p_m_ins_type'] != 'Select Type' && $p['p_m_ins_type'] != '1')?'checked="checked"':'';?> /> No
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
                        <label class="lbl_a"><strong>3.</strong> Insured First Name:</label><input class="inpt_a validate" id="p_m_partyfname" name="p_m_partyfname" type="text" value="<?=$p['p_m_partyfname']?>" maxlength="255" />
		</div>
                <div class="sepH_b third">
                        <label class="lbl_a"><strong>4.</strong> Insured Middle Name:</label><input class="inpt_a" id="p_m_partymname" name="p_m_partymname" type="text" value="<?=$p['p_m_partymname']?>" maxlength="255" />
		</div>
                <div class="sepH_b third">
                        <label class="lbl_a"><strong>5.</strong> Insured Last Name:</label><input class="inpt_a validate" id="p_m_partylname" name="p_m_partylname" type="text" value="<?=$p['p_m_partylname']?>" maxlength="255" />
                </div>
                <div class="sepH_b half clear" id="ins_dob_div">
                        <label class="lbl_a"><strong>6a.</strong> Insured Date of Birth:</label>
                                <?php
					if($p['ins_dob']!=''){
                                        	$ins_dob_month = date('m', strtotime($p['ins_dob']));
                                        	$ins_dob_day = date('j', strtotime($p['ins_dob']));
                                        	$ins_dob_year = date('Y', strtotime($p['ins_dob']));
					}else{
						$ins_dob_month = '';
                                                $ins_dob_day = '';
                                                $ins_dob_year = '';
					}
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
                                        $p_m_sql = "SELECT c.company, c.add1 as address1, c.add2 as address2, c.city, c.state, c.zip, c.phone1 as phone, c.fax, c.email FROM dental_contact c inner join dental_patients p on p.p_m_ins_co=c.contactid WHERE p.patientid='".mysql_real_escape_string($_SESSION['pid'])."'";
                                        $p_m_q = mysql_query($p_m_sql);
                                        $p_m_r = mysql_fetch_assoc($p_m_q);
                                }

			?>
                <div class="sepH_b half">
                        <label class="lbl_a"><strong>6b.</strong> Insured Gender</label><select class="inpt_a validate" name="p_m_gender">
                                <option value=''>Select</option>
                                <option value="Male" <?= ($p['p_m_gender']=="Male")?'selected="selected"':'';?>>Male</option>
                                <option value="Female" <?= ($p['p_m_gender']=="Female")?'selected="selected"':'';?>>Female</option>
                                </select>
                </div>
			<input type="hidden" id="p_m_patient_insuranceid" name="p_m_patient_insuranceid" value="<?= $p_m_r['id']; ?>" />
                <div class="sepH_b clear">
                        <label class="lbl_a"><strong>7a.</strong> Insurance Company</label>
			<input class="inpt_a validate" id="p_m_ins_company" name="p_m_ins_company" type="text" value="<?= $p_m_r['company']; ?>" />
           	</div>
                <div class="sepH_b half">
                        <label class="lbl_a"><strong>7b.</strong> Address 1</label>
                        <input class="inpt_a validate" id="p_m_ins_address1" name="p_m_ins_address1" type="text" value="<?= $p_m_r['address1']; ?>" />
                </div>
                <div class="sepH_b half">
                        <label class="lbl_a"><strong>7c.</strong> Address 2</label>
                        <input class="inpt_a" id="p_m_ins_address2" name="p_m_ins_address2" type="text" value="<?= $p_m_r['address2']; ?>" />
                </div>
                <div class="sepH_b third clear">
                        <label class="lbl_a"><strong>7d.</strong> City</label>
                        <input class="inpt_a validate" id="p_m_ins_city" name="p_m_ins_city" type="text" value="<?= $p_m_r['city']; ?>" />
                </div>
                <div class="sepH_b third">
                        <label class="lbl_a"><strong>7e.</strong> State</label>
                        <input class="inpt_a validate" id="p_m_ins_state" name="p_m_ins_state" type="text" value="<?= $p_m_r['state']; ?>" />
                </div>
                <div class="sepH_b third">
                        <label class="lbl_a"><strong>7f.</strong> Zip</label>
                        <input class="inpt_a validate" id="p_m_ins_zip" name="p_m_ins_zip" type="text" value="<?= $p_m_r['zip']; ?>" />
                </div>
                <div class="sepH_b third">
                        <label class="lbl_a"><strong>7g.</strong> Phone</label>
                        <input class="inpt_a extphonemask validate" id="p_m_ins_phone" name="p_m_ins_phone" type="text" value="<?= $p_m_r['phone']; ?>" />
                </div>
                <div class="sepH_b third">
                        <label class="lbl_a"><strong>7h.</strong> Fax</label>
                        <input class="inpt_a phonemask" id="p_m_ins_fax" name="p_m_ins_fax" type="text" value="<?= $p_m_r['fax']; ?>" />
                </div>
                <div class="sepH_b third">
                        <label class="lbl_a"><strong>7i.</strong> Email</label>
                        <input class="inpt_a" id="p_m_ins_email" name="p_m_ins_email" type="text" value="<?= $p_m_r['email']; ?>" />
                </div>

                <div class="sepH_b third clear">
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
			<label class="lbl_a"><strong>11.</strong> Do you have secondary medical insurance?</label>
			<input class="validate" onclick="updateNext('Yes', 2);" type="radio" name="has_s_m_ins" <?= ($p['has_s_m_ins']=="Yes")?'checked="checked"':''; ?> value="Yes" />Yes 
			<input onclick="updateNext('No', 2);" type="radio" id="has_s_m_ins_no" name="has_s_m_ins" <?= ($p['has_s_m_ins']=="No")?'checked="checked"':''; ?> value="No" />No</span>
		</div>
                                                                                                                <div class="cf">
															<a href="javascript:void(0)" class="fl prev btn btn_a">&laquo; Back</a>
<a href="javascript:void(0)" id="ins2Next1" class="fr next btn btn_d" <?=($p['has_s_m_ins']=="No")?'style="display:none;"':'';?>>Proceed &raquo;</a>
<a href="javascript:void(0)" id="ins2Next2" class="fr next2 btn btn_d" <?=($p['has_s_m_ins']!="No")?'style="display:none;"':'';?> >Proceed &raquo;</a>
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
                                                                                                        <p class="s_color small">Do you have additional insurance in addition to primary insurance coverage?  If so, please accurately complete all fields on this page to help us maximize your potential insurance coverage.  Refer to your medical insurance card for this information.</p>
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
                        <label class="lbl_a"><strong>2.</strong> Insured First Name:</label><input class="inpt_a validate" id="s_m_partyfname" name="s_m_partyfname" type="text" value="<?=$p['s_m_partyfname']?>" maxlength="255" />
                </div>
                <div class="sepH_b third">
                        <label class="lbl_a"><strong>3.</strong> Insured Middle Name:</label><input class="inpt_a" id="s_m_partymname" name="s_m_partymname" type="text" value="<?=$p['s_m_partymname']?>" maxlength="255" />
                </div>
                <div class="sepH_b third">
                        <label class="lbl_a"><strong>4.</strong> Insured Last Name:</label><input class="inpt_a validate" id="s_m_partylname" name="s_m_partylname" type="text" value="<?=$p['s_m_partylname']?>" maxlength="255" />
                </div>
                <div class="sepH_b clear half" id="ins2_dob_div">
                        <label class="lbl_a"><strong>5a.</strong> Insured Date of Birth:</label>
                                <?php
					if($p['ins2_dob']){
                                        	$ins2_dob_month = date('m', strtotime($p['ins2_dob']));
                                        	$ins2_dob_day = date('j', strtotime($p['ins2_dob']));
                                        	$ins2_dob_year = date('Y', strtotime($p['ins2_dob']));
					}else{
						$ins2_dob_month = '';
                                                $ins2_dob_day = '';
                                                $ins2_dob_year = '';
					}
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
					$s_m_sql = "SELECT c.company, c.add1 as address1, c.add2 as address2, c.city, c.state, c.zip, c.phone1 as phone, c.fax, c.email FROM dental_contact c inner join dental_patients p on p.s_m_ins_co=c.contactid WHERE p.patientid='".mysql_real_escape_string($_SESSION['pid'])."'";
					$s_m_q = mysql_query($s_m_sql);
					$s_m_r = mysql_fetch_assoc($s_m_q);
				}
                        ?>
                        <input type="hidden" id="s_m_patient_insuranceid" name="s_m_patient_insuranceid" value="<?= $s_m_r['id']; ?>" />
                <div class="sepH_b half">
                        <label class="lbl_a"><strong>5b.</strong> Insured Gender</label><select class="inpt_a validate" name="s_m_gender">
                                <option value=''>Select</option>
                                <option value="Male" <?= ($p['s_m_gender']=="Male")?'selected="selected"':'';?>>Male</option>
                                <option value="Female" <?= ($p['s_m_gender']=="Female")?'selected="selected"':'';?>>Female</option>
                                </select>
		</div>
                <div class="sepH_b clear">
                        <label class="lbl_a"><strong>6a.</strong> Insurance Company</label>
                        <input class="inpt_a validate" id="s_m_ins_company" name="s_m_ins_company" type="text" value="<?= $s_m_r['company']; ?>" />
                </div>
                <div class="sepH_b half">
                        <label class="lbl_a"><strong>6b.</strong> Address 1</label>
                        <input class="inpt_a validate" id="s_m_ins_address1" name="s_m_ins_address1" type="text" value="<?= $s_m_r['address1']; ?>" />
                </div>
                <div class="sepH_b half">
                        <label class="lbl_a"><strong>6c.</strong> Address 2</label>
                        <input class="inpt_a" id="s_m_ins_address2" name="s_m_ins_address2" type="text" value="<?= $s_m_r['address2']; ?>" />
                </div>
                <div class="sepH_b third clear">
                        <label class="lbl_a"><strong>6d.</strong> City</label>
                        <input class="inpt_a validate" id="s_m_ins_city" name="s_m_ins_city" type="text" value="<?= $s_m_r['city']; ?>" />
                </div>
                <div class="sepH_b third">
                        <label class="lbl_a"><strong>6e.</strong> State</label>
                        <input class="inpt_a validate" id="s_m_ins_state" name="s_m_ins_state" type="text" value="<?= $s_m_r['state']; ?>" />
                </div>
                <div class="sepH_b third">
                        <label class="lbl_a"><strong>6f.</strong> Zip</label>
                        <input class="inpt_a validate" id="s_m_ins_zip" name="s_m_ins_zip" type="text" value="<?= $s_m_r['zip']; ?>" />
                </div>
                <div class="sepH_b third">
                        <label class="lbl_a"><strong>6g.</strong> Phone</label>
                        <input class="inpt_a extphonemask validate" i="s_m_ins_phone" name="s_m_ins_phone" type="text" value="<?= $s_m_r['phone']; ?>" />
                </div>
                <div class="sepH_b third">
                        <label class="lbl_a"><strong>6h.</strong> Fax</label>
                        <input class="inpt_a phonemask" id="s_m_ins_fax" name="s_m_ins_fax" type="text" value="<?= $s_m_r['fax']; ?>" />
                </div>
                <div class="sepH_b third">
                        <label class="lbl_a"><strong>6i.</strong> Email</label>
                        <input class="inpt_a" id="s_m_ins_email" name="s_m_ins_email" type="text" value="<?= $s_m_r['email']; ?>" />     
                </div>
                <div class="sepH_b third clear">
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
                        <label class="lbl_a"><strong>7.</strong> Phone:</label><input class="inpt_a extphonemask" id="emp_phone" name="emp_phone" type="text" value="<?=$p['emp_phone']?>" maxlength="255" />
                </div>
                <div class="sepH_b half">
                        <label class="lbl_a"><strong>8.</strong> Fax:</label><input class="inpt_a phonemask" id="emp_fax" name="emp_fax" type="text" value="<?=$p['emp_fax']?>"   maxlength="255" />
		</div>

                                                                                                                <div class="cf">
	<? if($p['has_p_m_ins']=="No"){
		$showPrev = "prev3";
	}else{
	  if($p['has_s_m_ins']=="No"){
		$showPrev = "prev2";
	  }else{
		$showPrev = "prev1";
	  }
	}
	?>
			<a href="javascript:void(0)" id="insPrev1" class="fl prev btn btn_a" <?= ($showPrev!='prev1')?'style="display:none;"':''; ?>>&laquo; Back</a>
                        <a href="javascript:void(0)" id="insPrev2" class="fl prev2 btn btn_a" <?= ($showPrev!='prev2')?'style="display:none;"':''; ?>>&laquo; Back</a>
                        <a href="javascript:void(0)" id="insPrev3" class="fl prev3 btn btn_a" <?= ($showPrev!='prev3')?'style="display:none;"':''; ?>>&laquo; Back</a>

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
                                                                                                        <h3 class="sepH_a">Medical Contacts</h3>
                                                                                                        <p class="s_color small">We care about providing the best possible treatment to you.  We regularly contact your other medical providers to make them aware of your progress throughout treatment.  This helps ensure all your medical providers coordinate care to maximize the effectiveness of your treatment.  Please list your other healthcare providers here.</p>
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
                        <label class="lbl_a"><strong>8.</strong> Phone:</label><input class="inpt_a extphonemask" id="pc_<?= $t; ?>_phone" name="pc_<?= $t; ?>_phone" type="text" value="<?=$pc['phone']?>"   maxlength="100" />
                </div>
                <div class="sepH_b clear">
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
												<p  class="sepH_b">Thank you for completing your new patient information!  Your responses have been securely stored.</p>
 <?php
                                                                                                if(!$questionnaire_completed){
                                                                                                ?>

												<p class="sepH_b">Please click the 'Start Questionnaire' button below to answer a few questions about your medical history so we can better treat you.  After completing the Questionnaire, you will be ready for your next visit!</p>
<?php } ?>
											</div>

											<div class="cf">
												<a href="javascript:void(0)" class="fl prev btn btn_a">&laquo; Back</a>
												<?php
												if(!$questionnaire_completed){
												?>
												<a href="symptoms.php" class="fr btn btn_d">Start Questionnaire</a>
												<?php }else{
                                                                                                ?>
                                                                                                <a href="index.php" class="fr btn btn_d">View Dashboard</a>
                                                                                                <?php } ?>
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
