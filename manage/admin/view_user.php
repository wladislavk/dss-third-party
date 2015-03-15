<?php namespace Ds3\Libraries\Legacy; ?><?php
  include "includes/top.htm";

    $thesql = "select u.*, c.companyid, l.name mailing_name, l.address mailing_address, l.location mailing_practice, l.city mailing_city, l.state mailing_state, l.zip as mailing_zip, l.email as mailing_email, l.phone as mailing_phone, l.fax as mailing_fax from dental_users u 
		LEFT JOIN dental_user_company c ON u.userid = c.userid
		LEFT JOIN dental_locations l ON l.docid = u.userid AND l.default_location=1
		where u.userid='".(!empty($_REQUEST["ed"]) ? $_REQUEST["ed"] : '')."'";

	$themyarray = $db->getRow($thesql);
	
		$username = st($themyarray['username']);
		$npi = st($themyarray['npi']);
		$medicare_npi = st($themyarray['medicare_npi']);
                $medicare_ptan = st($themyarray['medicare_ptan']);
		$tax_id_or_ssn = st($themyarray['tax_id_or_ssn']);
		$ssn = st($themyarray['ssn']);
		$ein = st($themyarray['ein']);
		$practice = st($themyarray['practice']);
		$password = st($themyarray['password']);
		$first_name = st($themyarray['first_name']);
		$last_name = st($themyarray['last_name']);
		$email = st($themyarray['email']);
		$address = st($themyarray['address']);
		$city = st($themyarray['city']);
		$state = st($themyarray['state']);
		$zip = st($themyarray['zip']);
		$phone = st($themyarray['phone']);
		$fax = st($themyarray['fax']);

                $mailing_practice = st($themyarray['mailing_practice']);
                $mailing_name = st($themyarray['mailing_name']);
                $mailing_address = st($themyarray['mailing_address']);
                $mailing_city = st($themyarray['mailing_city']);
                $mailing_state = st($themyarray['mailing_state']);
                $mailing_zip = st($themyarray['mailing_zip']);
		$mailing_email = st($themyarray['mailing_email']);
                $mailing_phone = st($themyarray['mailing_phone']);
		$mailing_fax = st($themyarray['mailing_fax']);

		$status = st($themyarray['status']);
		$suspended_reason = st($themyarray['suspended_reason']);
		$use_patient_portal = st($themyarray['use_patient_portal']);
		$use_digital_fax = st($themyarray['use_digital_fax']);
		$use_letters = st($themyarray['use_letters']);
		$tracker_letters = st($themyarray['tracker_letters']);
		$intro_letters = st($themyarray['intro_letters']);
		$use_eligible_api = st($themyarray['use_eligible_api']);
		$eligible_test = st($themyarray['eligible_test']);
                $use_course = st($themyarray['use_course']);
                $use_course_staff = st($themyarray['use_course_staff']);
		$use_letter_header = st($themyarray['use_letter_header']);
		$homepage = st($themyarray['homepage']);
		$companyid = st($themyarray['companyid']);
                $user_type = st($themyarray['user_type']);
		$billing_company_id = $themyarray['billing_company_id'];
		$hst_company_id = (!empty($themyarray['hst_company_id']) ? $themyarray['hst_company_id'] : '');
		$plan_id = $themyarray['plan_id'];
		$billing_plan_id = $themyarray['billing_plan_id'];
		$access_code_id = $themyarray['access_code_id'];

                $use_service_npi = $themyarray['use_service_npi'];
                $service_name = $themyarray['service_name'];
                $service_address = $themyarray['service_address'];
                $service_city = $themyarray['service_city'];
                $service_state = $themyarray['service_state'];
                $service_zip = $themyarray['service_zip'];
                $service_phone = $themyarray['service_phone'];
                $service_fax = $themyarray['service_fax'];
                $service_npi = $themyarray['service_npi'];
                $service_medicare_npi = $themyarray['service_medicare_npi'];
                $service_medicare_ptan = $themyarray['service_medicare_ptan'];
                $service_tax_id_or_ssn = $themyarray['service_tax_id_or_ssn'];
                $service_ein = $themyarray['service_ein'];
                $service_ssn = $themyarray['service_ssn'];


	?>

    <script type="text/javascript" src="/manage/admin/js/view_user.js"></script>
	
    <div class="col-md-12">
        <?php if (isset($_GET['msg'])) { ?>
        <div class="alert alert-danger text-center">
            <strong><?php echo  $_GET['msg'] ?></strong>
        </div>
        <?php } ?>
        
        <?php if (!empty($msg)) { ?>
        <div class="alert alert-success text-center">
            <?php echo  $msg ?>
        </div>
        <?php } ?>
        
        <div class="page-header">
            <h1>
                <?php echo  (!empty($but_text) ? $but_text : '') ?>
                <?php echo  (!empty($_GET['heading']) ? $_GET['heading'] : '') ?>
                Contact
                <?php if (!empty($name) && trim($name) != "") { ?>
                    &quot;<?php echo $name;?>&quot;
                <?php } ?>
            </h1>
        </div>
    </div>
    <div class="col-md-6">
            <div class="page-header expanded">
                <strong>ID and Access Details</strong>
            </div>
            <div class="form-group expanded">
                <label for="username" class="col-md-3 control-label">Username</label>
                <div class="col-md-9">
                    <input type="text" class="form-control" name="username" id="username" placeholder="Username" value="<?php echo  $username ?>">
                </div>
            </div>
            <div class="form-group expanded">
                <label for="npi" class="col-md-3 control-label">NPI Number</label>
                <div class="col-md-9">
                    <input type="text" class="form-control" name="npi" id="npi" placeholder="NPI Number" value="<?php echo  $npi ?>">
                </div>
            </div>
            <div class="form-group expanded">
                <label for="medicare_npi" class="col-md-3 control-label">Medicare Provider (NPI/DME) Number</label>
                <div class="col-md-9">
                    <input type="text" class="form-control" name="medicare_npi" id="medicare_npi" placeholder="Medicare Provider (NPI/DME) Number" value="<?php echo  $medicare_npi ?>">
                </div>
		<div class="clearfix"></div>
            </div>
            <div class="form-group expanded">
                <label for="medicare_ptan" class="col-md-3 control-label">Medicare PTAN Number</label>
                <div class="col-md-9">
                    <input type="text" class="form-control" name="medicare_ptan" id="medicare_ptan" placeholder="Medicare PTAN Number" value="<?php echo  $medicare_ptan ?>">
                </div>
		<div class="clearfix"></div>
            </div>
            <div class="form-group expanded">
                <label for="tax_id_or_ssn" class="col-md-3 control-label">Tax ID or SSN</label>
                <div class="col-md-9">
                    <input type="text" class="form-control" name="tax_id_or_ssn" id="tax_id_or_ssn" placeholder="Tax ID/SSN" value="<?php echo  $tax_id_or_ssn ?>">
                </div>
		<div class="clearfix"></div>
            </div>
            <div class="form-group expanded">
                <label class="col-md-3 control-label">EIN or SSN required</label>
                <div class="col-md-2 col-md-push-3 checkbox">
                    <label>
                        EIN
                        <input id="ein" type="checkbox" name="ein" value="1" <?php echo  ($ein)?'checked="checked"':''; ?>>
                    </label>
                </div>
                <div class="col-md-2 col-md-push-3 checkbox">
                    <label>
                        SSN
                        <input id="ssn" type="checkbox" name="ssn" value="1" <?php echo  ($ssn)?'checked="checked"':''; ?>>
                    </label>
                </div>
		<div class="clearfix"></div>
            </div>
            <div class="form-group expanded">
                <label for="practice" class="col-md-3 control-label">Practice</label>
                <div class="col-md-9">
                    <input type="text" class="form-control" name="practice" id="practice" placeholder="Practice" value="<?php echo  $practice ?>">
                </div>
		<div class="clearfix"></div>
            </div>
           </div> 
    <div class="col-md-6">
            <div class="page-header">
                <strong>Personal Details</strong>
            </div>
            <div class="form-group">
                <label for="first_name" class="col-md-3 control-label">First Name</label>
                <div class="col-md-9">
                    <input type="text" class="form-control" name="first_name" id="first_name" placeholder="First name" value="<?php echo  $first_name ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="last_name" class="col-md-3 control-label">Last Name</label>
                <div class="col-md-9">
                    <input type="text" class="form-control" name="last_name" id="last_name" placeholder="Last name" value="<?php echo  $last_name ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="email" class="col-md-3 control-label">Email</label>
                <div class="col-md-9">
                    <input type="email" class="form-control" name="email" id="email" placeholder="Email" value="<?php echo  $email ?>">
                </div>
            </div>
            <div class="form-group expanded">
                <label for="address" class="col-md-3 control-label">Address</label>
                <div class="col-md-9">
                    <input type="text" class="form-control" name="address" id="address" placeholder="Address" value="<?php echo  $address ?>">
                </div>
            </div>
            <div class="form-group expanded">
                <label for="city" class="col-md-3 control-label">City</label>
                <div class="col-md-9">
                    <input type="text" class="form-control" name="city" id="city" placeholder="City" value="<?php echo  $city ?>">
                </div>
            </div>
            <div class="form-group expanded">
                <label for="state" class="col-md-3 control-label">State</label>
                <div class="col-md-9">
                    <input type="text" class="form-control" name="state" id="state" placeholder="State" value="<?php echo  $state ?>">
                </div>
            </div>
            <div class="form-group expanded">
                <label for="zip" class="col-md-3 control-label">Zip/Postal Code</label>
                <div class="col-md-9">
                    <input type="text" class="form-control" name="zip" id="zip" placeholder="Zip/Postal Code" value="<?php echo  $zip ?>">
                </div>
		<div class="clearfix"></div>
            </div>
            <div class="form-group">
                <label for="phone" class="col-md-3 control-label">Phone</label>
                <div class="col-md-9">
                    <input type="text" class="form-control extphonemask" name="phone" id="phone" placeholder="Phone number" value="<?php echo  $phone ?>">
                </div>
            </div>
            <div class="form-group expanded">
                <label for="fax" class="col-md-3 control-label">Fax</label>
                <div class="col-md-9">
                    <input type="text" class="form-control phonemask" name="fax" id="fax" placeholder="Fax number" value="<?php echo  $fax ?>">
                </div>
            </div>
	</div>
		<div class="clearfix"></div>
	<div class="col-md-6">
            <div class="page-header expanded">
                <strong>Mailing Details</strong>
            </div>
            <div class="form-group expanded">
                <label for="mailing_practice" class="col-md-3 control-label">Practice</label>
                <div class="col-md-9">
                    <input type="text" class="form-control" name="mailing_practice" id="mailing_practice" placeholder="Practice" value="<?php echo  $mailing_practice ?>">
                </div>
            </div>
            <div class="form-group expanded">
                <label for="mailing_name" class="col-md-3 control-label">Name</label>
                <div class="col-md-9">
                    <input type="text" class="form-control" name="mailing_name" id="mailing_name" placeholder="Name" value="<?php echo  $mailing_name ?>">
                </div>
            </div>
            <div class="form-group expanded">
                <label for="mailing_email" class="col-md-3 control-label">Email</label>
                <div class="col-md-9">
                    <input type="email" class="form-control" name="mailing_email" id="mailing_email" placeholder="Email" value="<?php echo  $mailing_email ?>">
                </div>
            </div>
            <div class="form-group expanded">
                <label for="mailing_address" class="col-md-3 control-label">Address</label>
                <div class="col-md-9">
                    <input type="text" class="form-control" name="mailing_address" id="mailing_address" placeholder="Address" value="<?php echo  $mailing_address ?>">
                </div>
            </div>
            <div class="form-group expanded">
                <label for="mailing_city" class="col-md-3 control-label">City</label>
                <div class="col-md-9">
                    <input type="text" class="form-control" name="mailing_city" id="mailing_city" placeholder="City" value="<?php echo  $mailing_city ?>">
                </div>
            </div>
            <div class="form-group expanded">
                <label for="mailing_state" class="col-md-3 control-label">State</label>
                <div class="col-md-9">
                    <input type="text" class="form-control" name="mailing_state" id="mailing_state" placeholder="State" value="<?php echo  $mailing_state ?>">
                </div>
            </div>
            <div class="form-group expanded">
                <label for="mailing_zip" class="col-md-3 control-label">Zip/Postal Code</label>
                <div class="col-md-9">
                    <input type="text" class="form-control" name="mailing_zip" id="mailing_zip" placeholder="Zip/Postal Code" value="<?php echo  $mailing_zip ?>">
                </div>
		<div class="clearfix"></div>
            </div>
            <div class="form-group expanded">
                <label for="mailing_phone" class="col-md-3 control-label">Phone</label>
                <div class="col-md-9">
                    <input type="text" class="form-control extphonemask" name="mailing_phone" id="mailing_phone" placeholder="Phone number" value="<?php echo  $mailing_phone ?>">
                </div>
            </div>
            <div class="form-group expanded">
                <label for="mailing_fax" class="col-md-3 control-label">Fax</label>
                <div class="col-md-9">
                    <input type="text" class="form-control phonemask" name="mailing_fax" id="mailing_fax" placeholder="Fax number" value="<?php echo  $mailing_fax ?>">
                </div>
            </div>
            <div class="form-group expanded">
                <label for="use_service_npi" class="col-md-3 control-label">Use Service NPI?</label>
           	<div class="col-md-9">
                     <input type="checkbox" name="use_service_npi" id="use_service_npi" value="1" <?php if($use_service_npi == 1) echo " checked='checked'";?> />
		</div>
	    </div>
            <div class="form-group expanded service_field">
                <label for="use_service_npi" class="col-md-3 control-label">Service Name</label>
                <div class="col-md-9">

                <input id="service_name" class="form-control" type="text" name="service_name" value="<?php echo $service_name;?>" class="tbox" />
                </div>
            </div>
            <div class="form-group expanded service_field">
                <label for="use_service_npi" class="col-md-3 control-label">Service Address</label>
                <div class="col-md-9">
                <input id="service_address" class="form-control" type="text" name="service_address" value="<?php echo $service_address;?>" class="tbox" />
                </div>
		<div class="clearfix"></div>
            </div>
            <div class="form-group expanded service_field">
                <label for="use_service_npi" class="col-md-3 control-label">Service City</label>
                <div class="col-md-9">
                <input id="service_city" class="form-control" type="text" name="service_city" value="<?php echo $service_city;?>" class="tbox" />
                </div>
            </div>
            <div class="form-group expanded service_field">
                <label for="use_service_npi" class="col-md-3 control-label">Service State</label>
                <div class="col-md-9">
                <input id="service_state" class="form-control" type="text" name="service_state" value="<?php echo $service_state;?>" class="tbox" />
                </div>
            </div>
            <div class="form-group expanded service_field">
                <label for="use_service_npi" class="col-md-3 control-label">Service Zip</label>
                <div class="col-md-9">
                <input id="service_zip" class="form-control" type="text" name="service_zip" value="<?php echo $service_zip;?>" class="tbox" />
                </div>
            </div>
            <div class="form-group expanded service_field">
                <label for="use_service_npi" class="col-md-3 control-label">Service Phone</label>
                <div class="col-md-9">
                <input id="service_phone" class="form-control extphonemask" type="text" name="service_phone" value="<?php echo $service_phone;?>" class="tbox" />
                </div>
            </div>
            <div class="form-group expanded service_field">
                <label for="use_service_npi" class="col-md-3 control-label">Service Fax</label>
                <div class="col-md-9">
                <input id="service_fax" class="form-control phonemask" type="text" name="service_fax" value="<?php echo $service_fax;?>" class="tbox" />
                </div>
            </div>
            <div class="form-group expanded service_field">
                <label for="use_service_npi" class="col-md-3 control-label">Service NPI</label>
                <div class="col-md-9">
                <input id="service_npi" class="form-control" type="text" name="service_npi" value="<?php echo $service_npi;?>" class="tbox" />
                </div>
            </div>
            <div class="form-group expanded service_field">
                <label for="use_service_npi" class="col-md-3 control-label">Service Medicare NPI</label>
                <div class="col-md-9">
                <input id="service_medicare_npi" class="form-control" type="text" name="service_medicare_npi" value="<?php echo $service_medicare_npi;?>" class="tbox" />
                </div>
		<div class="clearfix"></div>
            </div>
            <div class="form-group expanded service_field">
                <label for="use_service_npi" class="col-md-3 control-label">Service Medicare PTAN</label>
                <div class="col-md-9">
                <input id="service_medicare_ptan" class="form-control" type="text" name="service_medicare_ptan" value="<?php echo $service_medicare_ptan;?>" class="tbox" />
                </div>
		<div class="clearfix"></div>
            </div>
            <div class="form-group expanded service_field">
                <label for="use_service_npi" class="col-md-3 control-label">Service Tax ID or SSN</label>
                <div class="col-md-9">
                <input id="service_tax_id_or_ssn" class="form-control" type="text" name="service_tax_id_or_ssn" value="<?php echo $service_tax_id_or_ssn;?>" class="tbox" />
                </div>
		<div class="clearfix"></div>
            </div>
            <div class="form-group expanded service_field">
                <label for="use_service_npi" class="col-md-3 control-label">Service EIN or SSN</label>
                <div class="col-md-9">
                <input id="service_ein" type="checkbox" name="service_ein" value="1" <?php echo  ($service_ein)?'checked="checked"':''; ?> class="tbox" />
                EIN
                <input id="service_ssn" type="checkbox" name="service_ssn" value="1" <?php echo  ($service_ssn)?'checked="checked"':''; ?> class="tbox" />
                SSN
                </div>
		<div class="clearfix"></div>
            </div>
        </div>    
	<div class="col-md-6">
            <div class="page-header">
                <strong>Options</strong>
            </div>
            <div class="form-group">
                <label class="col-md-3 control-label">Active services</label>
                <div class="col-md-9">
                    <label class="col-md-4">
                        <input type="checkbox" name="use_patient_portal" value="1" <?php if($use_patient_portal == 1) echo " checked='checked'";?>>
                        Patient Portal
                    </label>
                    <label class="col-md-4">
                        <input type="checkbox" name="use_digital_fax" value="1" <?php if($use_digital_fax == 1) echo " checked='checked'";?>>
                        Digital Fax
                    </label>
                    <label class="col-md-4">
                        <input type="checkbox" name="use_letters" value="1" <?php if($use_letters == 1) echo " checked='checked'";?>>
                        Letters
                    </label>
                </div>
            </div>
		<div class="clearfix"></div>
            <div class="form-group">
                <div class="col-md-9 col-md-push-3">
                    <label class="col-md-4">
                        <input type="checkbox" name="use_eligible_api" value="1" <?php if($use_eligible_api == 1) echo " checked='checked'";?>>
                        Eligible API
                    </label>
                    <label class="col-md-4">
                        <input type="checkbox" name="use_course" value="1" <?php if($use_course == 1) echo " checked='checked'";?>>
                        Course
                    </label>
                    <label class="col-md-4">
                        <input type="checkbox" name="use_course_staff" value="1" <?php if($use_course_staff == 1) echo " checked='checked'";?>>
                        Staff Course
                    </label>
                </div>
            </div>
		<div class="clearfix"></div>
            <div class="form-group">
                <div class="col-md-9 col-md-push-3">
                    <label class="col-md-4">
                        <input type="checkbox" name="eligible_test" value="1" <?php if($eligible_test == 1) echo " checked='checked'";?>>
                        Eligible Test?
                    </label>
                </div>
            </div>
		<div class="clearfix"></div>

            <div class="form-group">
                <label class="col-md-3 control-label">Automated services</label>
                <div class="col-md-9">
                    <label class="col-md-4">
                        <input type="checkbox" name="tracker_letters" value="1" <?php if($tracker_letters == 1) echo " checked='checked'";?>>
                        Tracker Letters 
                    </label>
                    <label class="col-md-4">
                        <input type="checkbox" name="intro_letters" value="1" <?php if($intro_letters == 1) echo " checked='checked'";?>>
                        Intro Letters 
                    </label>
                </div>
            </div>
		<div class="clearfix"></div>
            <div class="form-group expanded">
                <label class="col-md-3 control-label">Visuals to use</label>
                <div class="col-md-9">
                    <label class="col-md-4">
                        <input type="checkbox" name="homepage" value="1" <?php if($homepage == 1) echo " checked='checked'";?>>
                        New Homepage
                    </label>
                    <label class="col-md-4">
                        <input type="checkbox" name="use_letter_header" value="1" <?php if($use_letter_header == 1) echo " checked='checked'";?>>
                        Letter Header 
                    </label>
                </div>
            </div>
		<div class="clearfix"></div>
            
            <?php if (is_super($_SESSION['admin_access'])) { ?>
            <div class="page-header">
                <strong>Administration Details</strong>
            </div>
            <div class="form-group">
                <label for="companyid" class="col-md-3 control-label">Admin Company</label>
                <div class="col-md-9">
                    <select name="companyid" id="companyid" class="form-control">
                       <?php
                       
                       $bu_sql = "SELECT * FROM companies WHERE company_type='".DSS_COMPANY_TYPE_SOFTWARE."' ORDER BY name ASC";
                       $bu_q = $db->getResults($bu_sql);
                       
                       if (!empty($bu_q)) foreach ($bu_q as $bu_r) { ?>
                       <option value="<?php echo  $bu_r['id']; ?>" <?php echo  ($bu_r['id'] == $companyid)?'selected="selected"':''; ?>><?php echo  $bu_r['name']; ?></option>
                       <?php } ?>
                    </select>
                </div>
            </div>
		<div class="clearfix"></div>
            <div class="form-group">
                <label for="user_type" class="col-md-3 control-label">User Type</label>
                <div class="col-md-9">
                    <select name="user_type" id="user_type" class="form-control">
                       <option value="<?php echo  DSS_USER_TYPE_FRANCHISEE; ?>" <?php echo  ($user_type == DSS_USER_TYPE_FRANCHISEE)?'selected="selected"':''; ?>><?php echo  $dss_user_type_labels[DSS_USER_TYPE_FRANCHISEE]; ?></option>
                       <option value="<?php echo  DSS_USER_TYPE_SOFTWARE; ?>" <?php echo  ($user_type == DSS_USER_TYPE_SOFTWARE)?'selected="selected"':''; ?>><?php echo  $dss_user_type_labels[DSS_USER_TYPE_SOFTWARE]; ?></option>
                    </select>
                </div>
            </div>
            <?php } ?>
            
		<div class="clearfix"></div>
            <div class="page-header">
                <strong>Companies Details</strong>
            </div>
            <div class="form-group">
                <label for="billing_company_id" class="col-md-3 control-label">Billing Company</label>
                <div class="col-md-9">
                    <select name="billing_company_id" id="billing_company_id" class="form-control">
                        <option value="">None</option>
                        <?php
                        
                        $bu_sql = "SELECT * FROM companies WHERE company_type='".DSS_COMPANY_TYPE_BILLING."' ORDER BY name ASC";
                        $bu_q = $db->getResults($bu_sql);
                        
                        if (!empty($bu_q)) foreach ($bu_q as $bu_r) { ?>
                        <option value="<?php echo  $bu_r['id']; ?>" <?php echo  ($bu_r['id'] == $billing_company_id)?'selected="selected"':''; ?>><?php echo  $bu_r['name']; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
		<div class="clearfix"></div>
            <div class="form-group">
                <label class="col-md-3 control-label">HST Company</label>
                <div class="col-md-9">
                    <?php
                    
                    $bu_sql = "SELECT h.*, uhc.id as uhc_id FROM companies h 
                    LEFT JOIN dental_user_hst_company uhc ON uhc.companyid=h.id AND uhc.userid='".mysqli_real_escape_string($con,$_GET['ed'])."'
                    WHERE h.company_type='".DSS_COMPANY_TYPE_HST."' ORDER BY name ASC";
                    $bu_q = $db->getResults($bu_sql);
                    
                    if (!empty($bu_q)) foreach ($bu_q as $bu_r) { ?>
                    <label class="checkbox">
                        <input type="checkbox" name="hst_company[]" value="<?php echo  $bu_r['id']; ?>"  <?php echo  ($bu_r['uhc_id'])?'checked="checked"':''; ?>>
                        <?php echo  $bu_r['name']; ?>
                    </label>
                    <?php } ?>
                </div>
            </div>
		<div class="clearfix"></div>
            <div class="form-group">
                <label for="access_code_id" class="col-md-3 control-label">Access Code</label>
                <div class="col-md-9">
                    <select name="access_code_id" id="access_code_id" class="form-control">
                        <?php
                        
                        $p_sql = "SELECT * FROM dental_access_codes ORDER BY access_code ASC";
                        $p_q = $db->getResults($p_sql);
                        
                        if (!empty($p_q)) foreach ($p_q as $p_r) { ?>
                        <option value="<?php echo  $p_r['id']; ?>" <?php echo  ($p_r['id'] == $access_code_id)?'selected="selected"':''; ?>><?php echo  $p_r['access_code']; ?><?php echo  ($p_r['status']=='2')?" - inactive":'';?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="plan_id" class="col-md-3 control-label">Software Plan</label>
                <div class="col-md-9">
                    <select name="plan_id" id="plan_id" class="form-control">
                        <?php
                        
                        $p_sql = "SELECT * FROM dental_plans WHERE office_type='1' ORDER BY name ASC";
                        $p_q = $db->getResults($p_sql);
                        
                        if (!empty($p_q)) foreach ($p_q as $p_r) { ?>
                        <option value="<?php echo  $p_r['id']; ?>" <?php echo  ($p_r['id'] == $plan_id)?'selected="selected"':''; ?>><?php echo  $p_r['name']; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="billing_plan_id" class="col-md-3 control-label">Billing Plan</label>
                <div class="col-md-9">
                    <select name="billing_plan_id" id="billing_plan_id" class="form-control">
                        <?php

                        $p_sql = "SELECT * FROM dental_plans WHERE office_type='3' ORDER BY name ASC";
                        $p_q = $db->getResults($p_sql);

                        if (!empty($p_q)) foreach ($p_q as $p_r) { ?>
                        <option value="<?php echo  $p_r['id']; ?>" <?php echo  ($p_r['id'] == $billing_plan_id)?'selected="selected"':''; ?>><?php echo  $p_r['name']; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="page-header">
                <strong>Status Details</strong>
            </div>
            <div class="form-group">
                <label for="status" class="col-md-3 control-label">Status</label>
                <div class="col-md-9">
                    <select id="status" name="status" class="form-control" onchange="showSuspended();">
                        <option value="1" <?php if($status == 1) echo " selected";?>>Active</option>
                        <option value="2" <?php if($status == 2) echo " selected";?>>In-Active</option>
                        <option value="3" <?php if($status == 3) echo " selected";?>>Suspended</option>
                    </select>
                </div>
            </div>
            <div id="suspended_reason" class="form-group" <?php echo  ($status!=3)?'style="display:none;"':''; ?>>
                <label for="suspended_reason" class="col-md-3 control-label">Suspended Reason</label>
                <div class="col-md-9">
                    <textarea name="suspended_reason" id="suspended_reason" class="form-control"><?php echo  $suspended_reason ?></textarea>
                </div>
            </div>

    </div>

<div style="clear:both;"></div>

<?php 
  include "includes/bottom.htm";
?>
