<?php session_start();

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
  $sql = "SELECT * from dental_users WHERE userid='".mysql_real_escape_string($_GET['id'])."' AND recover_hash='".mysql_real_escape_string($_GET['hash'])."'";
  $q = mysql_query($sql);
if(mysql_num_rows($q) == 0){
  ?><h3>User not found</h3><?php
  die();
}
  $p = mysql_fetch_assoc($q);
?>
				<div id="content_wrapper">
					<div id="main_content" class="cf">

						<h2 class="sepH_c">Step-by-Step User Registration</h2>
	<form action="register.php" id="register_form" method="post">
		<input type="hidden" id="userid" name="userid" value="<?= $_GET['id']; ?>" />
                <input type="hidden" id="hash" name="hash" value="<?= $_GET['hash']; ?>" />
							<ul id="status" class="cf">
							<?php $pagenum = 1; ?>
								<li class="active"><span class="large"><?= $pagenum++; ?>. Welcome</span></li>
								<li><span class="large"><?= $pagenum++; ?>. Contact Info</span></li>
								<li><span class="large"><?= $pagenum++; ?>. Mailing Info</span></li>
								<li><span class="large"><?= $pagenum++; ?>. Additional Info</span></li>
								<li><span class="large"><?= $pagenum++; ?>. Login Info</span></li>
							</ul>
							<div id="register" class="wizard" style="height:1400px;">
								<div class="items formEl_a">
                                                                        <div class="page">
                                                                                <div class="pageInside">
                                                                                        <div class="cf">
                                                                                                <div class="dp100">
                                                                                                        <h3 class="sepH_a">Welcome!</h3>
                                                                                                        <p>Please accurately complete the information on the following pages. This will save you time at your next Dental Sleep Solutions appointment, and allow you to avoid completing additional forms later.  All information you input here is securely stored using the latest encryption technology that meets or exceeds HIPAA medical privacy standards, and you can access and update your information anytime.  We take your privacy seriously, and we never share your information without your consent.  We're excited to see you at your next visit!</p>
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
													<h3 class="sepH_a">Conact Information</h3>
													<p class="s_color small">Please accurately complete the information on the following pages. This will save you time at your next Dental Sleep Solutions appointment, and allow you to avoid completing additional forms later.  All information you input here is securely stored using the latest encryption technology that meets or exceeds HIPAA medical privacy standards, and you can access and update your information anytime.  We take your privacy seriously, and we never share your information without your consent.  We're excited to see you at your next visit!</p>
												</div>
												<div class="dp75">
													<div>
														<div id="welcome_errors" class="form_errors" style="display:none"></div>
		<div class="sepH_b half">
			<label class="lbl_a"><strong>1.</strong> Name <span class="req">*</span></label>
			<input class="inpt_a validate" type="text" name="name" id="name" value="<?= $p['name']; ?>" />
		</div>
                <div class="sepH_b half">
			<input class="inpt_a validate" type="hidden" id="oldemail" name="oldemail" value="<?= $p['email']; ?>" />
                        <label class="lbl_a"><strong>2.</strong> Email: <span class="req">*</span></label><input class="inpt_a validate" type="text" id="email" name="email" value="<?= $p['email']; ?>" />
                </div>
                <div class="sepH_b half clear">
                        <label class="lbl_a"><strong>3.</strong> Office Phone: <span class="req">*</span></label><input class="inpt_a validate phonemask" type="text" id="phone" name="phone" value="<?= $p['phone']; ?>" />
                </div>
                <div class="sepH_b half">
                        <label class="lbl_a"><strong>4.</strong> Office Fax:</label><input class="inpt_a phonemask" type="text" id="fax" name="fax" value="<?= $p['fax']; ?>" />
                </div>
                <div class="sepH_b half clear">
                        <label class="lbl_a"><strong>5.</strong> Practice Name: <span class="req">*</span></label><input class="inpt_a validate" type="text" id="practice" name="practice" value="<?= $p['practice']; ?>" />
                </div>
                <div class="sepH_b half">
                        <label class="lbl_a"><strong>6.</strong> Practice Address: <span class="req">*</span></label><input class="inpt_a validate" type="text" id="address" name="address" value="<?= $p['address']; ?>" />
                </div>
                <div class="sepH_b third clear">
                        <label class="lbl_a"><strong>7.</strong> Practice City: <span class="req">*</span></label><input class="inpt_a validate" type="text" id="city" name="city" value="<?= $p['city']; ?>" />
                </div>
                <div class="sepH_b third">
			<?php $s = $p['state']; ?>
                        <label class="lbl_a"><strong>8.</strong> Practice State: <span class="req">*</span></label>
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
                        <label class="lbl_a"><strong>9.</strong> Practice Zip: <span class="req">*</span></label><input class="inpt_a validate" type="text" id="zip" name="zip" value="<?= $p['zip']; ?>" />
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
                                                                                                        <p class="s_color small">This information helps us verify your insurance coverage and allows us to contact someone you designate in the event of an emergency.</p>
                                                                                                </div>
                                                                                                <div class="dp75">
                                                                                                        <div>
                                                                                                                <div class="form_errors" style="display:none"></div>
		<div class="sepH_b">
			<input type="checkbox" id="billing_mailing"> My billing information is the same as my mailing information.
		</div>
                <div class="sepH_b half">
                        <label class="lbl_a"><strong>1.</strong> Physician's Mailing Name:</label>
                        <input class="inpt_a" type="text" id="mailing_name" name="mailing_name" value="<?= $p['mailing_name']; ?>" />
                </div>
                <div class="sepH_b half">
                        <label class="lbl_a"><strong>2.</strong> Mailing Practice Name:</label>
			<input class="inpt_a" type="text" id="mailing_practice" name="mailing_practice" value="<?= $p['mailing_practice']; ?>" />
		</div>
                <div class="sepH_b half clear">
                        <label class="lbl_a"><strong>3.</strong> Mailing Phone:</label>
                        <input class="inpt_a phonemask" type="text" id="mailing_phone" name="mailing_phone" value="<?= $p['mailing_phone']; ?>" />
                </div>
                <div class="sepH_b half">
                        <label class="lbl_a"><strong>4.</strong> Mailing Address:</label>
                        <input class="inpt_a" type="text" id="mailing_address" name="mailing_address" value="<?= $p['mailing_address']; ?>" />
                </div>
                <div class="sepH_b third clear">
                        <label class="lbl_a"><strong>5.</strong> Mailing City:</label>
			<input class="inpt_a" type="text" id="mailing_city" name="mailing_city" value="<?= $p['mailing_city']; ?>" />
                </div>
                <div class="sepH_b third">
                        <?php $s = $p['mailing_state']; ?>
                        <label class="lbl_a"><strong>6.</strong> Mailing State: <span class="req">*</span></label>
        <select  data-placeholder="Choose a state..." style="width:200px;" class="chzn-select validate" id="mailing_state" name="mailing_state">
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
                        <label class="lbl_a"><strong>7.</strong> Mailing Zip:</label><input class="inpt_a" type="text" id="mailing_zip" name="mailing_zip" value="<?= $p['mailing_zip']; ?>" />
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
                                                                                                        <h3 class="sepH_a">Additional Information</h3>
                                                                                                        <p class="s_color small">Please complete all fields on this page to allow Dental Sleep Solutions to verify your medical insurance coverage.  Failure to accurately complete these fields may result in insurance delays and even denial of coverage.  Refer to your medical insurance card for this information.</p>
                                                                                                </div>
                                                                                                <div class="dp75">
                                                                                                        <div>
                                                                                                                <div class="form_errors" style="display:none"></div>
                <div class="sepH_b half">
                        <label class="lbl_a"><strong>1.</strong> NPI Number:</label><input class="inpt_a validate" id="npi" name="npi" type="text" value="<?=$p['npi']?>" maxlength="255" />
		</div>
                <div class="sepH_b half">
                        <label class="lbl_a"><strong>2.</strong> Medicare DME Number:</label><input class="inpt_a validate" id="medicare_npi" name="medicare_npi" type="text" value="<?=$p['medicare_npi']?>" maxlength="255" />
		</div>
                <div class="sepH_b half clear">
                        <label class="lbl_a"><strong>3.</strong> Tax ID or SSN:</label><input class="inpt_a validate" id="tax_id_or_ssn" name="tax_id_or_ssn" type="text" value="<?=$p['tax_id_or_ssn']?>" maxlength="255" />
                </div>
                <div class="sepH_b half">
                        <label class="lbl_a"><strong>4.</strong> EIN or SSN:</label>
			<input class="" name="ein" type="checkbox" value="1" <?= ($p['ein']==1)?'checked="checked"':''; ?> /> EIN
			<input class="" name="ssn" type="checkbox" value="1" <?= ($p['ssn']==1)?'checked="checked"':''; ?> /> SSN
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
                                                                                                        <p class="s_color small">Do you have additional insurance in addition to primary insurance coverage?  If so, please accurately complete all fields on this page to help Dental Sleep Solutions maximize your potential insurance coverage.  Refer to your medical insurance card for this information.</p>
                                                                                                </div>
                                                                                                <div class="dp75">
                                                                                                        <div>
                                                                                                                <div class="form_errors" style="display:none"></div>

                <div class="sepH_b">
                        <label class="lbl_a"><strong>1.</strong> Username:</label><input class="inpt_a validate" id="username" name="username" type="text" value="<?=$p['username']?>" maxlength="255" />
                </div>
                <div class="sepH_b">
                        <label class="lbl_a"><strong>2.</strong> Password:</label><input class="inpt_a validate" id="password" name="password" type="password" maxlength="255" />
                </div>
                <div class="sepH_b">
                        <label class="lbl_a"><strong>3.</strong> Retype Password:</label><input class="inpt_a validate" name="confirm_password" type="password" maxlength="255" />
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
											<div class="last sepH_c">
												<h3 class="sepH_b">Congratulations!</h3>
												<p  class="sepH_b">Thank you for completing your new patient information!  Your responses have been securely stored.</p>

											<div class="cf">
                                                                                                <a href="../index.php" class="fr btn btn_dL">Home</a>
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
