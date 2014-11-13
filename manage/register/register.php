<?php
    include 'includes/header.php';
    include '../../reg/includes/completed.php';
?>
    <link rel="stylesheet" href="css/register.css" />
    <!--[if IE]>
            <link rel="stylesheet" type="text/css" href="css/register_ie.css" />
    <![endif]-->
    <script type="text/javascript" src="js/register.js"></script>
    <script type="text/javascript" src="js/patient_dob.js"></script>
    <script type="text/javascript" src="js/autocomplete.js"></script>
    <script type="text/javascript" src="js/register_masks.js"></script>
<?php
    $sql = "SELECT * from dental_users 
		    WHERE userid='".mysqli_real_escape_string($con,$_SESSION['regid'])."' AND 
		    status='2'";

    $q = $db->getResults($sql);
    if(/*count($q) == 0*/0){
?>
        <script type="text/javascript">
            window.location = '../login.php';
        </script>
<?php
        die();
    }

    $p = $q[0];
    $c_sql = "SELECT c.id, c.name, c.stripe_publishable_key from companies c 
		      JOIN dental_user_company uc ON uc.companyid=c.id
			  WHERE uc.userid='".mysqli_real_escape_string($con,$p['userid'])."'"; 

    $c_r = $db->getRow($c_sql);
?>
	<div id="content_wrapper">
		<div id="main_content" class="cf">
            <h2 class="sepH_c">Step-by-Step User Registration</h2>
	        <form action="register.php" id="register_form" method="post">
		        <input type="hidden" id="userid" name="userid" value="<?php echo  $_SESSION['regid']; ?>" />
					<ul id="status" class="cf">
					    <?php $pagenum = 1; ?>
						<li class="active"><span class="large"><?php echo  $pagenum++; ?>. Welcome</span></li>
						<li><span class="large"><?php echo  $pagenum++; ?>. Contact Info</span></li>
						<li><span class="large"><?php echo  $pagenum++; ?>. Mailing Info</span></li>
						<li><span class="large"><?php echo  $pagenum++; ?>. Insurance Info</span></li>
						<li><span class="large"><?php echo  $pagenum++; ?>. Login Info</span></li>
					</ul>
					<div id="register" class="wizard" style="height:1400px;">
						<div class="items formEl_a">
                            <div class="page">
                                <div class="pageInside">
                                    <div class="cf">
                                        <div class="dp100">
                                            <h3 class="sepH_a">Welcome <?php echo  $p['name']; ?>!</h3>
											<p>Please accurately complete the information on the following pages in order to create your Dental Sleep Solutions software account. We're excited to work with you!</p>
                                            <br />
                                            <div class="cf">
                                                <a href="javascript:void(0)" class="fr next btn btn_dL">Proceed &raquo;</a>
                                            </div>
                                        </div>
									</div>
								</div>
							</div>													
							<div class="page">
								<div class="pageInside">
									<div class="cf">
										<div class="dp25">
											<h3 class="sepH_a">Contact Information</h3>
											<p class="s_color">Please complete these fields using the name of the dental provider and practice location <strong>exactly as they appear on your Tax Statements.</strong> These fields must be completed accurately in order to ensure accurate filing of insurance claims.</p>
										</div>
										<div class="dp75">
											<div>
												<div id="welcome_errors" class="form_errors" style="display:none"></div>
                                        		<div class="sepH_b half">
                                        			<label class="lbl_a"><strong>1.</strong> First Name <span class="req">*</span></label>
                                        			<input class="inpt_a validate" type="text" name="first_name" id="first_name" value="<?php echo  $p['first_name']; ?>" />
                                        		</div>
                                                <div class="sepH_b half">
                                                    <label class="lbl_a"><strong>2.</strong> Last Name <span class="req">*</span></label>
                                                    <input class="inpt_a validate" type="text" name="last_name" id="last_name" value="<?php echo  $p['last_name']; ?>" />
                                                </div>
                                                <div class="sepH_b half clear">
                                		            <input class="inpt_a validate" type="hidden" id="oldemail" name="oldemail" value="<?php echo  $p['email']; ?>" />
                                                    <label class="lbl_a"><strong>3.</strong> Personal Email (for DS3 account login): <span class="req">*</span></label><input class="inpt_a validate" type="text" id="email" name="email" value="<?php echo  $p['email']; ?>" />
                                                </div>
                                                <div class="sepH_b half clear">
                                                    <label class="lbl_a"><strong>4.</strong> Office Phone: <span class="req">*</span></label><input class="inpt_a validate phonemask" type="text" id="phone" name="phone" value="<?php echo  $p['phone']; ?>" />
                                                </div>
                                                <div class="sepH_b half">
                                                    <label class="lbl_a"><strong>5.</strong> Office Fax:</label><input class="inpt_a phonemask" type="text" id="fax" name="fax" value="<?php echo  $p['fax']; ?>" />
                                                </div>
                                                <div class="sepH_b half clear">
                                                    <label class="lbl_a"><strong>6.</strong> Practice Name: <span class="req">*</span></label><input class="inpt_a validate" type="text" id="practice" name="practice" value="<?php echo  $p['practice']; ?>" />
                                                </div>
                                                <div class="sepH_b half">
                                                    <label class="lbl_a"><strong>7.</strong> Practice Address: <span class="req">*</span></label><input class="inpt_a validate" type="text" id="address" name="address" value="<?php echo  $p['address']; ?>" />
                                                </div>
                                                <div class="sepH_b third clear">
                                                    <label class="lbl_a"><strong>8.</strong> Practice City: <span class="req">*</span></label><input class="inpt_a validate" type="text" id="city" name="city" value="<?php echo  $p['city']; ?>" />
                                                </div>
                                                <div class="sepH_b third">
			                                        <?php $s = $p['state']; ?>
                                                    <label class="lbl_a"><strong>9.</strong> Practice State: <span class="req">*</span></label>
	                                                <select  data-placeholder="Choose a state..." style="width:200px;" class="chzn-select validate" id="state" name="state">
                                                        <option value=""></option>
                                                        <option <?php echo  ($s=='AK')?'selected="selected"':'' ?> value="AK">AK - Alaska</option>
                                                        <option <?php echo  ($s=='AL')?'selected="selected"':'' ?> value="AL">AL - Alabama</option>
                                                        <option <?php echo  ($s=='AR')?'selected="selected"':'' ?> value="AR">AR - Arkansas</option>
                                                        <option <?php echo  ($s=='AZ')?'selected="selected"':'' ?> value="AZ">AZ - Arizona</option>
                                                        <option <?php echo  ($s=='CA')?'selected="selected"':'' ?> value="CA">CA - California</option>
                                                        <option <?php echo  ($s=='CO')?'selected="selected"':'' ?> value="CO">CO - Colorado</option>
                                                        <option <?php echo  ($s=='CT')?'selected="selected"':'' ?> value="CT">CT - Connecticut</option>
                                                        <option <?php echo  ($s=='DC')?'selected="selected"':'' ?> value="DC">DC - District of Columbia</option>
                                                        <option <?php echo  ($s=='DE')?'selected="selected"':'' ?> value="DE">DE - Delaware</option>
                                                        <option <?php echo  ($s=='FL')?'selected="selected"':'' ?> value="FL">FL - Florida</option>
                                                        <option <?php echo  ($s=='GA')?'selected="selected"':'' ?> value="GA">GA - Georgia</option>
                                                        <option <?php echo  ($s=='HI')?'selected="selected"':'' ?> value="HI">HI - Hawaii</option>
                                                        <option <?php echo  ($s=='IA')?'selected="selected"':'' ?> value="IA">IA - Iowa</option>
                                                        <option <?php echo  ($s=='ID')?'selected="selected"':'' ?> value="ID">ID - Idaho</option>
                                                        <option <?php echo  ($s=='IL')?'selected="selected"':'' ?> value="IL">IL - Illinois</option>
                                                        <option <?php echo  ($s=='IN')?'selected="selected"':'' ?> value="IN">IN - Indiana</option>
                                                        <option <?php echo  ($s=='KS')?'selected="selected"':'' ?> value="KS">KS - Kansas</option>
                                                        <option <?php echo  ($s=='KY')?'selected="selected"':'' ?> value="KY">KY - Kentucky</option>
                                                        <option <?php echo  ($s=='LA')?'selected="selected"':'' ?> value="LA">LA - Louisiana</option>
                                                        <option <?php echo  ($s=='MA')?'selected="selected"':'' ?> value="MA">MA - Massachusetts</option>
                                                        <option <?php echo  ($s=='MD')?'selected="selected"':'' ?> value="MD">MD - Maryland</option>
                                                        <option <?php echo  ($s=='ME')?'selected="selected"':'' ?> value="ME">ME - Maine</option>
                                                        <option <?php echo  ($s=='MI')?'selected="selected"':'' ?> value="MI">MI - Michigan</option>
                                                        <option <?php echo  ($s=='MN')?'selected="selected"':'' ?> value="MN">MN - Minnesota</option>
                                                        <option <?php echo  ($s=='MO')?'selected="selected"':'' ?> value="MO">MO - Missouri</option>
                                                        <option <?php echo  ($s=='MS')?'selected="selected"':'' ?> value="MS">MS - Mississippi</option>
                                                        <option <?php echo  ($s=='MT')?'selected="selected"':'' ?> value="MT">MT - Montana</option>
                                                        <option <?php echo  ($s=='NC')?'selected="selected"':'' ?> value="NC">NC - North Carolina</option>
                                                        <option <?php echo  ($s=='ND')?'selected="selected"':'' ?> value="ND">ND - North Dakota</option>
                                                        <option <?php echo  ($s=='NE')?'selected="selected"':'' ?> value="NE">NE - Nebraska</option>
                                                        <option <?php echo  ($s=='NH')?'selected="selected"':'' ?> value="NH">NH - New Hampshire</option>
                                                        <option <?php echo  ($s=='NJ')?'selected="selected"':'' ?> value="NJ">NJ - New Jersey</option>
                                                        <option <?php echo  ($s=='NM')?'selected="selected"':'' ?> value="NM">NM - New Mexico</option>
                                                        <option <?php echo  ($s=='NV')?'selected="selected"':'' ?> value="NV">NV - Nevada</option>
                                                        <option <?php echo  ($s=='NY')?'selected="selected"':'' ?> value="NY">NY - New York</option>
                                                        <option <?php echo  ($s=='OH')?'selected="selected"':'' ?> value="OH">OH - Ohio</option>
                                                        <option <?php echo  ($s=='OK')?'selected="selected"':'' ?> value="OK">OK - Oklahoma</option>
                                                        <option <?php echo  ($s=='OR')?'selected="selected"':'' ?> value="OR">OR - Oregon</option>
                                                        <option <?php echo  ($s=='PA')?'selected="selected"':'' ?> value="PA">PA - Pennsylvania</option>
                                                        <option <?php echo  ($s=='RI')?'selected="selected"':'' ?> value="RI">RI - Rhode Island</option>
                                                        <option <?php echo  ($s=='SC')?'selected="selected"':'' ?> value="SC">SC - South Carolina</option>
                                                        <option <?php echo  ($s=='SD')?'selected="selected"':'' ?> value="SD">SD - South Dakota</option>
                                                        <option <?php echo  ($s=='TN')?'selected="selected"':'' ?> value="TN">TN - Tennessee</option>
                                                        <option <?php echo  ($s=='TX')?'selected="selected"':'' ?> value="TX">TX - Texas</option>
                                                        <option <?php echo  ($s=='UT')?'selected="selected"':'' ?> value="UT">UT - Utah</option>
                                                        <option <?php echo  ($s=='VA')?'selected="selected"':'' ?> value="VA">VA - Virginia</option>
                                                        <option <?php echo  ($s=='VT')?'selected="selected"':'' ?> value="VT">VT - Vermont</option>
                                                        <option <?php echo  ($s=='WA')?'selected="selected"':'' ?> value="WA">WA - Washington</option>
                                                        <option <?php echo  ($s=='WI')?'selected="selected"':'' ?> value="WI">WI - Wisconsin</option>
                                                        <option <?php echo  ($s=='WV')?'selected="selected"':'' ?> value="WV">WV - West Virginia</option>
                                                        <option <?php echo  ($s=='WY')?'selected="selected"':'' ?> value="WY">WY - Wyoming</option>
                                                    </select>
                                                </div>
                                                <div class="sepH_b third">
                                                    <label class="lbl_a"><strong>10.</strong> Practice Zip: <span class="req">*</span></label><input class="inpt_a validate" type="text" id="zip" name="zip" value="<?php echo  $p['zip']; ?>" />
                                                </div>
												<div class="cf">
                                                    <a href="javascript:void(0)" class="fr next btn btn_dL">Proceed &raquo;</a>
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
                                            <h3 class="sepH_a">Mailing Information</h3>
                                            <p class="s_color">Please complete these fields as you would like them to appear on all correspondence generated by the software to patients and physicians. This information will be used on all correspondence and mailing materials not related to insurance filing or tax documentation. In most cases, this information is the same as your billing information.</p>
                                        </div>
                                        <div class="dp75">
                                            <div>
                                                <div class="form_errors" style="display:none"></div>
                                        		<div class="sepH_b">
                                        			<input type="checkbox" id="billing_mailing"> My mailing information is the same as my billing information.
                                    		</div>
                                            <div class="sepH_b ">
                                                <label class="lbl_a"><strong>1.</strong> Practice Email (for website and patients, NOT a personal email): <span class="req">*</span></label>
                                                <input class="inpt_a validate" type="text" id="mailing_email" name="mailing_email" value="<?php echo  $p['mailing_email']; ?>" />
                                            </div>
                                            <div class="sepH_b half clear">
                                                <label class="lbl_a"><strong>2.</strong> Physician's Mailing Name: <span class="req">*</span></label>
                                                <input class="inpt_a validate" type="text" id="mailing_name" name="mailing_name" value="<?php echo  $p['mailing_name']; ?>" />
                                            </div>
                                            <div class="sepH_b half">
                                                <label class="lbl_a"><strong>3.</strong> Mailing Practice Name: <span class="req">*</span></label>
                            		            <input class="inpt_a validate" type="text" id="mailing_practice" name="mailing_practice" value="<?php echo  $p['mailing_practice']; ?>" />
                            		        </div>
                                            <div class="sepH_b half clear">
                                                <label class="lbl_a"><strong>4.</strong> Mailing Phone: <span class="req">*</span></label>
                                                <input class="inpt_a phonemask validate" type="text" id="mailing_phone" name="mailing_phone" value="<?php echo  $p['mailing_phone']; ?>" />
                                            </div>
                                            <div class="sepH_b half">
                                                <label class="lbl_a"><strong>5.</strong> Mailing Address: <span class="req">*</span></label>
                                                <input class="inpt_a validate" type="text" id="mailing_address" name="mailing_address" value="<?php echo  $p['mailing_address']; ?>" />
                                            </div>
                                            <div class="sepH_b third clear">
                                                <label class="lbl_a"><strong>6.</strong> Mailing City: <span class="req">*</span></label>
                            		            <input class="inpt_a validate" type="text" id="mailing_city" name="mailing_city" value="<?php echo  $p['mailing_city']; ?>" />
                                            </div>
                                            <div class="sepH_b third">
                                                <?php $s = $p['mailing_state']; ?>
                                                <label class="lbl_a"><strong>7.</strong> Mailing State: <span class="req">*</span></label>
                                                <select  data-placeholder="Choose a state..." style="width:200px;" class="chzn-select validate" id="mailing_state" name="mailing_state">
                                                    <option value=""></option>
                                                    <option <?php echo  ($s=='AK')?'selected="selected"':'' ?> value="AK">AK - Alaska</option>
                                                    <option <?php echo  ($s=='AL')?'selected="selected"':'' ?> value="AL">AL - Alabama</option>
                                                    <option <?php echo  ($s=='AR')?'selected="selected"':'' ?> value="AR">AR - Arkansas</option>
                                                    <option <?php echo  ($s=='AZ')?'selected="selected"':'' ?> value="AZ">AZ - Arizona</option>
                                                    <option <?php echo  ($s=='CA')?'selected="selected"':'' ?> value="CA">CA - California</option>
                                                    <option <?php echo  ($s=='CO')?'selected="selected"':'' ?> value="CO">CO - Colorado</option>
                                                    <option <?php echo  ($s=='CT')?'selected="selected"':'' ?> value="CT">CT - Connecticut</option>
                                                    <option <?php echo  ($s=='DC')?'selected="selected"':'' ?> value="DC">DC - District of Columbia</option>
                                                    <option <?php echo  ($s=='DE')?'selected="selected"':'' ?> value="DE">DE - Delaware</option>
                                                    <option <?php echo  ($s=='FL')?'selected="selected"':'' ?> value="FL">FL - Florida</option>
                                                    <option <?php echo  ($s=='GA')?'selected="selected"':'' ?> value="GA">GA - Georgia</option>
                                                    <option <?php echo  ($s=='HI')?'selected="selected"':'' ?> value="HI">HI - Hawaii</option>
                                                    <option <?php echo  ($s=='IA')?'selected="selected"':'' ?> value="IA">IA - Iowa</option>
                                                    <option <?php echo  ($s=='ID')?'selected="selected"':'' ?> value="ID">ID - Idaho</option>
                                                    <option <?php echo  ($s=='IL')?'selected="selected"':'' ?> value="IL">IL - Illinois</option>
                                                    <option <?php echo  ($s=='IN')?'selected="selected"':'' ?> value="IN">IN - Indiana</option>
                                                    <option <?php echo  ($s=='KS')?'selected="selected"':'' ?> value="KS">KS - Kansas</option>
                                                    <option <?php echo  ($s=='KY')?'selected="selected"':'' ?> value="KY">KY - Kentucky</option>
                                                    <option <?php echo  ($s=='LA')?'selected="selected"':'' ?> value="LA">LA - Louisiana</option>
                                                    <option <?php echo  ($s=='MA')?'selected="selected"':'' ?> value="MA">MA - Massachusetts</option>
                                                    <option <?php echo  ($s=='MD')?'selected="selected"':'' ?> value="MD">MD - Maryland</option>
                                                    <option <?php echo  ($s=='ME')?'selected="selected"':'' ?> value="ME">ME - Maine</option>
                                                    <option <?php echo  ($s=='MI')?'selected="selected"':'' ?> value="MI">MI - Michigan</option>
                                                    <option <?php echo  ($s=='MN')?'selected="selected"':'' ?> value="MN">MN - Minnesota</option>
                                                    <option <?php echo  ($s=='MO')?'selected="selected"':'' ?> value="MO">MO - Missouri</option>
                                                    <option <?php echo  ($s=='MS')?'selected="selected"':'' ?> value="MS">MS - Mississippi</option>
                                                    <option <?php echo  ($s=='MT')?'selected="selected"':'' ?> value="MT">MT - Montana</option>
                                                    <option <?php echo  ($s=='NC')?'selected="selected"':'' ?> value="NC">NC - North Carolina</option>
                                                    <option <?php echo  ($s=='ND')?'selected="selected"':'' ?> value="ND">ND - North Dakota</option>
                                                    <option <?php echo  ($s=='NE')?'selected="selected"':'' ?> value="NE">NE - Nebraska</option>
                                                    <option <?php echo  ($s=='NH')?'selected="selected"':'' ?> value="NH">NH - New Hampshire</option>
                                                    <option <?php echo  ($s=='NJ')?'selected="selected"':'' ?> value="NJ">NJ - New Jersey</option>
                                                    <option <?php echo  ($s=='NM')?'selected="selected"':'' ?> value="NM">NM - New Mexico</option>
                                                    <option <?php echo  ($s=='NV')?'selected="selected"':'' ?> value="NV">NV - Nevada</option>
                                                    <option <?php echo  ($s=='NY')?'selected="selected"':'' ?> value="NY">NY - New York</option>
                                                    <option <?php echo  ($s=='OH')?'selected="selected"':'' ?> value="OH">OH - Ohio</option>
                                                    <option <?php echo  ($s=='OK')?'selected="selected"':'' ?> value="OK">OK - Oklahoma</option>
                                                    <option <?php echo  ($s=='OR')?'selected="selected"':'' ?> value="OR">OR - Oregon</option>
                                                    <option <?php echo  ($s=='PA')?'selected="selected"':'' ?> value="PA">PA - Pennsylvania</option>
                                                    <option <?php echo  ($s=='RI')?'selected="selected"':'' ?> value="RI">RI - Rhode Island</option>
                                                    <option <?php echo  ($s=='SC')?'selected="selected"':'' ?> value="SC">SC - South Carolina</option>
                                                    <option <?php echo  ($s=='SD')?'selected="selected"':'' ?> value="SD">SD - South Dakota</option>
                                                    <option <?php echo  ($s=='TN')?'selected="selected"':'' ?> value="TN">TN - Tennessee</option>
                                                    <option <?php echo  ($s=='TX')?'selected="selected"':'' ?> value="TX">TX - Texas</option>
                                                    <option <?php echo  ($s=='UT')?'selected="selected"':'' ?> value="UT">UT - Utah</option>
                                                    <option <?php echo  ($s=='VA')?'selected="selected"':'' ?> value="VA">VA - Virginia</option>
                                                    <option <?php echo  ($s=='VT')?'selected="selected"':'' ?> value="VT">VT - Vermont</option>
                                                    <option <?php echo  ($s=='WA')?'selected="selected"':'' ?> value="WA">WA - Washington</option>
                                                    <option <?php echo  ($s=='WI')?'selected="selected"':'' ?> value="WI">WI - Wisconsin</option>
                                                    <option <?php echo  ($s=='WV')?'selected="selected"':'' ?> value="WV">WV - West Virginia</option>
                                                    <option <?php echo  ($s=='WY')?'selected="selected"':'' ?> value="WY">WY - Wyoming</option>
                                                </select>
                                            </div>
                                            <div class="sepH_b third">
                                                <label class="lbl_a"><strong>8.</strong> Mailing Zip: <span class="req">*</span></label><input class="inpt_a validate" type="text" id="mailing_zip" name="mailing_zip" value="<?php echo  $p['mailing_zip']; ?>" />
                                            </div>
                                            <div class="cf">
												<a href="javascript:void(0)" class="fl prev btn btn_aL">&laquo; Back</a>
                                                <a href="javascript:void(0)" class="fr next btn btn_dL">Proceed &raquo;</a>
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
                                        <h3 class="sepH_a">Insurance Information</h3>
                                        <p class="s_color">This information is required for auto-filing of medical insurance claims and patient verification of benefits. If you do not provide this information many features of the software will be disabled. If you do not have this information you can contact us to provide it later. If you do not have a Medicare DME number please leave this field blank.</p>
                                    </div>
                                    <div class="dp75">
                                        <div>
                                            <div class="form_errors" style="display:none"></div>
                                            <div class="sepH_b half">
                                                <label class="lbl_a"><strong>1.</strong> NPI Number:</label><input class="inpt_a validate" id="npi" name="npi" type="text" value="<?php echo $p['npi']?>" maxlength="255" />
		                                    </div>
                                            <div class="sepH_b half">
                                                <label class="lbl_a"><strong>2.</strong> Medicare Provider (NPI/DME) Number:</label><input class="inpt_a validate" id="medicare_npi" name="medicare_npi" type="text" value="<?php echo $p['medicare_npi']?>" maxlength="255" />
		                                    </div>
                                            <div class="sepH_b half clear">
                                                <label class="lbl_a"><strong>3.</strong> Medicare PTAN Number:</label><input class="inpt_a" id="medicare_ptan" name="medicare_ptan" type="text" value="<?php echo $p['medicare_ptan']?>" maxlength="255" />
                                            </div>
                                            <div class="sepH_b half">
                                                <label class="lbl_a"><strong>4.</strong> Tax ID or SSN:</label><input class="inpt_a validate" id="tax_id_or_ssn" name="tax_id_or_ssn" type="text" value="<?php echo $p['tax_id_or_ssn']?>" maxlength="255" />
                                            </div>
                                            <div class="sepH_b half clear">
                                                <label class="lbl_a"><strong>5.</strong> Is box 4 your EIN or SSN?</label>
                                    			<input class="" name="ein" onclick="$('#register_form').validate().element('#tax_id_or_ssn');" id="ein" type="checkbox" value="1" <?php echo  ($p['ein']==1)?'checked="checked"':''; ?> /> EIN
                                    			<input class="" name="ssn" onclick="$('#register_form').validate().element('#tax_id_or_ssn');" id="ssn" type="checkbox" value="1" <?php echo  ($p['ssn']==1)?'checked="checked"':''; ?> /> SSN
                                            </div>
                                            <div class="sepH_b half">
                                                <label class="lbl_a"><strong>6.</strong> Do you use a separate NPI number for Service Facility (CMS1500 box 32) and Billing Provider (CMS1500 box 33) items when filing claims?</label>
                                    			<input class="" name="use_service_npi" onclick="show_service_info();" id="use_service_npi" type="radio" value="1" <?php echo  ($p['use_service_npi']=='1')?'checked="checked"':''; ?> /> Yes 
                                    			<input class="" name="use_service_npi" onclick="$('.service_info').hide();" id="use_service_npi" type="radio" value="0" <?php echo  ($p['use_service_npi']=='0')?'checked="checked"':''; ?> /> No
                                            </div>
                                            <div class="sepH_b half clear service_info">
                                                <label class="lbl_a"><strong>7.</strong> Service Facility Name: <span class="req">*</span></label><input class="inpt_a validate" type="text" id="service_name" name="service_name" value="<?php echo  $p['service_name']; ?>" />
                                            </div>
                                            <div class="sepH_b half service_info">
                                                <label class="lbl_a"><strong>8.</strong> Service Facility Address: <span class="req">*</span></label><input class="inpt_a validate" type="text" id="service_address" name="service_address" value="<?php echo  $p['service_address']; ?>" />
                                            </div>
                                            <div class="sepH_b third clear service_info">
                                                <label class="lbl_a"><strong>9.</strong> Service Facility City: <span class="req">*</span></label><input class="inpt_a validate" type="text" id="service_city" name="service_city" value="<?php echo  $p['service_city']; ?>" />
                                            </div>
                                            <div class="sepH_b third service_info">
                                                <?php $s = $p['service_state']; ?>
                                                <label class="lbl_a"><strong>10.</strong> Service Facility State: <span class="req">*</span></label>
                                                <select  data-placeholder="Choose a state..." style="width:200px;" class="chzn-select validate" id="service_state" name="service_state">
                                                    <option value=""></option>
                                                    <option <?php echo  ($s=='AK')?'selected="selected"':'' ?> value="AK">AK - Alaska</option>
                                                    <option <?php echo  ($s=='AL')?'selected="selected"':'' ?> value="AL">AL - Alabama</option>
                                                    <option <?php echo  ($s=='AR')?'selected="selected"':'' ?> value="AR">AR - Arkansas</option>
                                                    <option <?php echo  ($s=='AZ')?'selected="selected"':'' ?> value="AZ">AZ - Arizona</option>
                                                    <option <?php echo  ($s=='CA')?'selected="selected"':'' ?> value="CA">CA - California</option>
                                                    <option <?php echo  ($s=='CO')?'selected="selected"':'' ?> value="CO">CO - Colorado</option>
                                                    <option <?php echo  ($s=='CT')?'selected="selected"':'' ?> value="CT">CT - Connecticut</option>
                                                    <option <?php echo  ($s=='DC')?'selected="selected"':'' ?> value="DC">DC - District of Columbia</option>
                                                    <option <?php echo  ($s=='DE')?'selected="selected"':'' ?> value="DE">DE - Delaware</option>
                                                    <option <?php echo  ($s=='FL')?'selected="selected"':'' ?> value="FL">FL - Florida</option>
                                                    <option <?php echo  ($s=='GA')?'selected="selected"':'' ?> value="GA">GA - Georgia</option>
                                                    <option <?php echo  ($s=='HI')?'selected="selected"':'' ?> value="HI">HI - Hawaii</option>
                                                    <option <?php echo  ($s=='IA')?'selected="selected"':'' ?> value="IA">IA - Iowa</option>
                                                    <option <?php echo  ($s=='ID')?'selected="selected"':'' ?> value="ID">ID - Idaho</option>
                                                    <option <?php echo  ($s=='IL')?'selected="selected"':'' ?> value="IL">IL - Illinois</option>
                                                    <option <?php echo  ($s=='IN')?'selected="selected"':'' ?> value="IN">IN - Indiana</option>
                                                    <option <?php echo  ($s=='KS')?'selected="selected"':'' ?> value="KS">KS - Kansas</option>
                                                    <option <?php echo  ($s=='KY')?'selected="selected"':'' ?> value="KY">KY - Kentucky</option>
                                                    <option <?php echo  ($s=='LA')?'selected="selected"':'' ?> value="LA">LA - Louisiana</option>
                                                    <option <?php echo  ($s=='MA')?'selected="selected"':'' ?> value="MA">MA - Massachusetts</option>
                                                    <option <?php echo  ($s=='MD')?'selected="selected"':'' ?> value="MD">MD - Maryland</option>
                                                    <option <?php echo  ($s=='ME')?'selected="selected"':'' ?> value="ME">ME - Maine</option>
                                                    <option <?php echo  ($s=='MI')?'selected="selected"':'' ?> value="MI">MI - Michigan</option>
                                                    <option <?php echo  ($s=='MN')?'selected="selected"':'' ?> value="MN">MN - Minnesota</option>
                                                    <option <?php echo  ($s=='MO')?'selected="selected"':'' ?> value="MO">MO - Missouri</option>
                                                    <option <?php echo  ($s=='MS')?'selected="selected"':'' ?> value="MS">MS - Mississippi</option>
                                                    <option <?php echo  ($s=='MT')?'selected="selected"':'' ?> value="MT">MT - Montana</option>
                                                    <option <?php echo  ($s=='NC')?'selected="selected"':'' ?> value="NC">NC - North Carolina</option>
                                                    <option <?php echo  ($s=='ND')?'selected="selected"':'' ?> value="ND">ND - North Dakota</option>
                                                    <option <?php echo  ($s=='NE')?'selected="selected"':'' ?> value="NE">NE - Nebraska</option>
                                                    <option <?php echo  ($s=='NH')?'selected="selected"':'' ?> value="NH">NH - New Hampshire</option>
                                                    <option <?php echo  ($s=='NJ')?'selected="selected"':'' ?> value="NJ">NJ - New Jersey</option>
                                                    <option <?php echo  ($s=='NM')?'selected="selected"':'' ?> value="NM">NM - New Mexico</option>
                                                    <option <?php echo  ($s=='NV')?'selected="selected"':'' ?> value="NV">NV - Nevada</option>
                                                    <option <?php echo  ($s=='NY')?'selected="selected"':'' ?> value="NY">NY - New York</option>
                                                    <option <?php echo  ($s=='OH')?'selected="selected"':'' ?> value="OH">OH - Ohio</option>
                                                    <option <?php echo  ($s=='OK')?'selected="selected"':'' ?> value="OK">OK - Oklahoma</option>
                                                    <option <?php echo  ($s=='OR')?'selected="selected"':'' ?> value="OR">OR - Oregon</option>
                                                    <option <?php echo  ($s=='PA')?'selected="selected"':'' ?> value="PA">PA - Pennsylvania</option>
                                                    <option <?php echo  ($s=='RI')?'selected="selected"':'' ?> value="RI">RI - Rhode Island</option>
                                                    <option <?php echo  ($s=='SC')?'selected="selected"':'' ?> value="SC">SC - South Carolina</option>
                                                    <option <?php echo  ($s=='SD')?'selected="selected"':'' ?> value="SD">SD - South Dakota</option>
                                                    <option <?php echo  ($s=='TN')?'selected="selected"':'' ?> value="TN">TN - Tennessee</option>
                                                    <option <?php echo  ($s=='TX')?'selected="selected"':'' ?> value="TX">TX - Texas</option>
                                                    <option <?php echo  ($s=='UT')?'selected="selected"':'' ?> value="UT">UT - Utah</option>
                                                    <option <?php echo  ($s=='VA')?'selected="selected"':'' ?> value="VA">VA - Virginia</option>
                                                    <option <?php echo  ($s=='VT')?'selected="selected"':'' ?> value="VT">VT - Vermont</option>
                                                    <option <?php echo  ($s=='WA')?'selected="selected"':'' ?> value="WA">WA - Washington</option>
                                                    <option <?php echo  ($s=='WI')?'selected="selected"':'' ?> value="WI">WI - Wisconsin</option>
                                                    <option <?php echo  ($s=='WV')?'selected="selected"':'' ?> value="WV">WV - West Virginia</option>
                                                    <option <?php echo  ($s=='WY')?'selected="selected"':'' ?> value="WY">WY - Wyoming</option>
                                                </select>
                                            </div>
                                            <div class="sepH_b third service_info">
                                                <label class="lbl_a"><strong>11.</strong> Service Facility Zip: <span class="req">*</span></label><input class="inpt_a validate" type="text" id="service_zip" name="service_zip" value="<?php echo  $p['service_zip']; ?>" />
                                            </div>
                                            <div class="sepH_b half clear service_info">
                                                <label class="lbl_a"><strong>12.</strong> Service Facility Phone: <span class="req">*</span></label><input class="inpt_a validate phonemask" type="text" id="service_phone" name="service_phone" value="<?php echo  $p['service_phone']; ?>" />
                                            </div>
                                            <div class="sepH_b half service_info">
                                                <label class="lbl_a"><strong>13.</strong> Service Facility Fax: <span class="req">*</span></label><input class="inpt_a validate phonemask" type="text" id="service_fax" name="service_fax" value="<?php echo  $p['service_fax']; ?>" />
                                            </div>
                                            <div class="sepH_b half service_info">
                                                <label class="lbl_a"><strong>14.</strong> Service Facility NPI Number:</label><input class="inpt_a validate" id="service_npi" name="service_npi" type="text" value="<?php echo $p['service_npi']?>" maxlength="255" />
                                            </div>
                                            <div class="sepH_b half service_info">
                                                <label class="lbl_a"><strong>15.</strong> Service Facility Medicare Provider (NPI/DME) Number:</label><input class="inpt_a validate" id="service_medicare_npi" name="service_medicare_npi" type="text" value="<?php echo $p['service_medicare_npi']?>" maxlength="255" />
                                            </div>
                                            <div class="sepH_b half clear service_info">
                                                <label class="lbl_a"><strong>16.</strong> Service Facility Medicare PTAN Number:</label><input class="inpt_a" id="service_medicare_ptan" name="service_medicare_ptan" type="text" value="<?php echo $p['service_medicare_ptan']?>" maxlength="255" />
                                            </div>

                                            <div class="sepH_b half service_info">
                                                <label class="lbl_a"><strong>17.</strong> Service Facility Tax ID or SSN:</label><input class="inpt_a validate" id="service_tax_id_or_ssn" name="service_tax_id_or_ssn" type="text" value="<?php echo $p['service_tax_id_or_ssn']?>" maxlength="255" />
                                            </div>
                                            <div class="sepH_b half clear service_info">
                                                <label class="lbl_a"><strong>18.</strong> Is box 10 your service facility  EIN or SSN?</label>
                                                <input class="" name="service_ein" onclick="$('#register_form').validate().element('#service_tax_id_or_ssn');" id="service_ein" type="checkbox" value="1" <?php echo  ($p['service_ein']==1)?'checked="checked"':''; ?> /> EIN
                                                <input class="" name="service_ssn" onclick="$('#register_form').validate().element('#service_tax_id_or_ssn');" id="service_ssn" type="checkbox" value="1" <?php echo  ($p['service_ssn']==1)?'checked="checked"':''; ?> /> SSN
                                            </div>
                                            <div class="cf clear">
											    <a href="javascript:void(0)" class="fl prev btn btn_aL">&laquo; Back</a>
                                                <a href="javascript:void(0)" class="fr next btn btn_dL">Proceed &raquo;</a>
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
                                        <h3 class="sepH_a">Login Information</h3>
                                        <p class="s_color">Please create a username and password for your account. Please store your username and password in a secure place - you will use this information to access the software.</p>
                                    </div>
                                    <div class="dp75">
                                        <div>
                                            <div class="form_errors" style="display:none"></div>
                                            <div class="sepH_b">
                                                <label class="lbl_a"><strong>1.</strong> Username:</label><input class="inpt_a validate" id="username" name="username" type="text" value="<?php echo $p['username']?>" maxlength="255" />
                                            </div>
                                            <div class="sepH_b">
                                                <label class="lbl_a"><strong>2.</strong> Password:</label><input class="inpt_a validate" id="password" name="password" type="password" onkeyup="checkPass()" maxlength="255" />
                                            </div>
                                            <div class="sepH_b">
                                                <label class="lbl_a"><strong>3.</strong> Retype Password:</label><input class="inpt_a validate" id="password2" name="confirm_password" type="password" onkeyup="checkPass()" maxlength="255" />
                                            </div>
                                                <a href="javascript:void(0)" class="fl prev btn btn_aL">&laquo; Back</a>
                                                <a href="javascript:void(0)" class="fr next btn btn_dL">Proceed &raquo;</a>
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
                                        <h3 class="sepH_a">Payment Information</h3>
                                        <p class="s_color">Please enter the credit card billing information to be associated with this account. You must supply a valid card in order to create your account.</p>
                                    </div>
                                    <div class="dp75">
                                        <div>
                                            <div class="form_errors" style="display:none"></div>
			                                <input type="hidden" id="cc_id" value="<?php echo  ($p['cc_id']=='')?0:1; ?>" />
                                        <div class="sepH_b half">
                                            <label class="lbl_a"><strong>1.</strong> Card Number:</label><input type="text" size="20" autocomplete="off" class="inpt_a ccmask card-number"/>
                                        </div>
                                        <div class="sepH_b half">
                                            <label class="lbl_a"><strong>2.</strong> Card CVC (security code):</label><input class="inpt_a card-cvc cvcmask" id="card-cvc" name="card-cvc" type="text" />
                                        </div>
                                        <div class="sepH_b half clear">
                                            <label class="lbl_a"><strong>3.</strong> Expiration Month (MM):</label><input class="inpt_a small card-expiry-month mmmask" id="card-expiry-month" name="card-expiry-month" type="text" /> 
                                        </div>
                                        <div class="sepH_b half">
                                            <label class="lbl_a"><strong>4.</strong> Expiration Year (YYYY):</label><input class="inpt_a small card-expiry-year yyyymask" id="card-expiry-year" name="card-expiry-year" type="text" />
                                        </div>
                                        <div class="sepH_b half clear">
                                            <label class="lbl_a"><strong>5.</strong> Name on Card:</label><input class="inpt_a card-name" id="card-name" name="card-name" type="text" />
                                        </div>
                                        <div class="sepH_b half">
                                            <label class="lbl_a"><strong>6.</strong> Card Zipcode:</label><input class="inpt_a small card-zip zipmask" id="card-zip" name="card-zip" type="text" />
                                        </div>
                                        <div id="loader" style="display:none;">
                                            <img src="../images/DSS-ajax-animated_loading-gif.gif" />
                                        </div>
                                        <div class="cf">
                                            <a href="javascript:void(0)" class="fl prev btn btn_aL">&laquo; Back</a>
                                            <a href="#" onclick="add_cc(); return false;" id="payment_proceed" class="fr btn btn_dL">Proceed &raquo;</a>
                                            <div id="loader" style="display:none;">
                                                <img src="../images/DSS-ajax-animated_loading-gif.gif" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="page">
						<div class="pageInside">
							<div class="last sepH_c">
								<h3 class="sepH_b">Congratulations! Your new Dental Sleep Solutions&reg; software account has been created!</h3>
								<p  class="sepH_b">You have successfully registered your software account! Click the button below to begin exploring your new software account.</p>
							<div class="cf">
                                <a href="../index.php" class="fr btn btn_dL">Click to Log On</a>
							</div>
						</div>
					</div>
				</div>
			</div>
        </div>
	</form>
    <div style="clear:both;"></div>

    <script type="text/javascript" src="https://js.stripe.com/v1/"></script>
    <!-- jQuery is used only for this example; it isn't required to use Stripe -->
    <!--<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>-->
    <script type="text/javascript">
        // this identifies your website in the createToken call below
        Stripe.setPublishableKey('<?php echo  $c_r['stripe_publishable_key']; ?>');    
    </script>

<?php include '../../reg/includes/footer.php'; ?>