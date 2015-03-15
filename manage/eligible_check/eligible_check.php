<?php namespace Ds3\Libraries\Legacy; ?><?php
include_once '../admin/includes/main_include.php';
include_once '../admin/includes/invoice_functions.php';
?>
<script type="text/javascript" src="/manage/admin/script/jquery-1.6.2.min.js"></script>
<?php
include_once '../includes/calendarinc.php';
?>
  <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
  <link href="css/cupertino/jquery-ui-1.10.3.custom.min.css" rel="stylesheet" media="screen">
  <link href="css/sample_1.css" rel="stylesheet" media="screen">

  <script src="js/lib/jquery-1.10.2.min.js"></script>
  <script src="js/lib/jquery-ui-1.10.3.custom.min.js"></script>
  <script src="../script/autocomplete_local.js"></script>

  <script src="js/eligible.js"></script>
  <script src="js/sample_1.js"></script>

<div class="container eligible_check">
  <form role="form" class="form-horizontal form-coverage">

<?php
  $s = "SELECT p.*, c.company, u.last_name as doc_lastname, u.first_name as doc_firstname, u.npi, u.practice, u.tax_id_or_ssn from dental_patients p
         LEFT JOIN dental_contact c ON c.contactid = p.p_m_ins_co
         LEFT JOIN dental_users u ON u.userid = p.docid
         WHERE p.patientid='".mysqli_real_escape_string($con, (!empty($_GET['pid']) ? $_GET['pid'] : ''))."'";
  $r = $db->getRow($s);
  $doc_name = (!empty($r['doc_name']) ? $r['doc_name'] : '');
  $doc_array = explode(' ',$doc_name);
  $doc_first_name = $doc_array[0];
  $doc_last_name = (!empty($doc_array[1]) ? $doc_array[1] : '');

  $getdocinfo = "SELECT * FROM `dental_users` WHERE `userid` = '".(!empty($_GET['docid']) ? $_GET['docid'] : '')."'";
  $docinfo = $db->getRow($getdocinfo);
  $phone = $docinfo['phone'];
  $practice = $docinfo['practice'];
  $address = $docinfo['address'];
  $city = $docinfo['city'];
  $state = $docinfo['state'];
  $zip = $docinfo['zip'];
  $npi = $docinfo['npi'];
  $medicare_npi = $docinfo['medicare_npi'];

  if($docinfo['use_service_npi']==1){
    $service_npi = $docinfo['service_npi'];
    $service_practice = $docinfo['service_name'];
    $service_address = $docinfo['service_address'];
    $service_city = $docinfo['service_city'];
    $service_state = $docinfo['service_state'];
    $service_zip = $docinfo['service_zip'];
    $service_medicare_npi = $docinfo['service_medicare_npi'];
  }else{
    $service_npi = $npi;
    $service_practice = $practice;
    $service_address = $address;
    $service_city = $city;
    $service_state = $state;
    $service_zip = $zip;
    $service_medicare_npi = $medicare_npi;
  }

  if($r['p_m_same_address']==1){
    $s_state = $r['state'];
    $s_city = $r['city'];
    $s_zip = $r['zip'];
  }else{
    $s_state = $r['p_m_state'];
    $s_city = $r['p_m_city'];
    $s_zip = $r['p_m_zip'];
  }

  if($r['p_m_relation'] != 'Self'){
    $d_last_name = $r['lastname'];
    $d_first_name = $r['firstname'];
    $d_dob = $r['dob'];
    $d_ssn = $r['ssn'];
    $d_gender = $r['gender'];
    $d_state = $r['state'];
    $d_city = $r['city'];
    $d_zip = $r['zip'];
  }else{
    $d_last_name = '';
    $d_first_name = '';
    $d_dob = '';
    $d_ssn = '';
    $d_gender = '';
    $d_state = '';
    $d_city = '';
    $d_zip = '';
  }

  $s = "SELECT eligible_test FROM dental_users where userid='".(!empty($_GET['docid']) ? $_GET['docid'] : '')."'";
  $row = $db->getRow($s);
  if($row['eligible_test']=="1"){?>

    <div class="form-group">
      <label for="member_dob" class="col-lg-2 control-label">Test?</label>

      <div class="col-lg-10">
        <input type="radio" name="test" id="test_yes" value="true" checked="checked"> Yes
        <input type="radio" name="test" id="test_no" value="false"> No
      </div>
    </div>

<?php 
  }else{ ?>

    <div class="form-group hidden">
      <label for="member_dob" class="col-lg-2 control-label">Test?</label>
		
      <div class="col-lg-10">
        <input type="radio" name="test" id="test_yes" value="true"> Yes
        <input type="radio" name="test" id="test_no" value="false" checked="checked"> No
      </div>
    </div>


<?php 
  } ?>

    <input type="hidden" class="form-control" id="api_key" value="33b2e3a5-8642-1285-d573-07a22f8a15b4">

    <div class="form-group test-param">
      <label for="test_member_id" class="col-lg-2 control-label">Test Member ID</label>

      <div class="col-lg-10">
        <select class="form-control" id="test_member_id">
          <option value="AETNA1234">AETNA - AETNA1234</option>
          <option value="BCBSTN81790">BCBS Tennessee - BCBSTN81790</option>
          <option value="GOLD00144">Golden Rule - GOLD00144</option>
          <option value="HUMAN123">HUMANA - HUMAN123</option>
          <option value="INDEP1234">Independence - INDEP1234</option>
          <option value="NEB8176176">BCBS Nebraska - NEB8176176</option>
          <option value="PREM010611">Premera Washington - PREM010611</option>
          <option value="TRIC98620">Tricare - TRIC98620</option>
          <option value="WELL56AD4089">BCIAC - WELL56AD4089</option>
          <option value="BCBSF203551">BCBSF - BCBSF203551</option>
          <option value="CIGNA6801">CIGNA - CIGNA6801</option>
          <option value="HARV68426">Harvard - HARV68426</option>
          <option value="ILLIN21331">BCBS Illinois - ILLIN21331</option>
          <option value="MASS84030341">BCBS Massachusetts - MASS84030341</option>
          <option value="PAMC11111">Pennsylvania Medicaid - PAMC11111</option>
          <option value="RHOD2006181">BCBS Rhode Island - RHOD2006181</option>
          <option value="UNITE36963">UNITED - UNITE36963</option>
        </select>
      </div>
    </div>

    <fieldset class="real-param" style="display: none;">
      <legend>&nbsp;</legend>

    <div class="form-group real-param" style="display: none;">
      <label for="date" class="col-lg-2 control-label">Patient Insurance</label>

      <div class="col-lg-10">
	<?php echo $r['company']; ?>
      </div>
    </div>

    <div class="form-group real-param" style="display: none;">
      <label for="payer_id" class="col-lg-2 control-label">Payer ID</label>

      <div class="col-lg-10">
        <input type="text" class="form-control" id="payer_name" autocomplete="off">
<br />
<div id="ins_payer_hints" class="search_hints" style="margin-top:20px; display:none;">
        <ul id="ins_payer_list" class="search_list">
                <li class="template" style="display:none"></li>
        </ul>
</div>

<input type="hidden" name="payer_id" id="payer_id" />
      </div>
    </div>

    <div class="form-group real-param" style="display: none;">
      <label for="date" class="col-lg-2 control-label">Date</label>

      <div class="col-lg-10">
        <input type="text" class="form-control calendar" id="date" value="<?php echo date('m/d/Y'); ?>">
      </div>
    </div>

    <div class="form-group real-param" style="display: none;">
      <label for="from_date" class="col-lg-2 control-label">From Date</label>

      <div class="col-lg-10">
        <input type="text" class="form-control calendar" id="from_date" value="<?php echo date('m/d/Y'); ?>">
      </div>
    </div>

    <div class="form-group real-param" style="display: none;">
      <label for="to_date" class="col-lg-2 control-label">To Date</label>

      <div class="col-lg-10">
        <input type="text" class="form-control calendar" id="to_date" value="<?php echo date('m/d/Y'); ?>">
      </div>
    </div>

    <div class="form-group real-param" style="display: none;">
      <label for="procedure_code" class="col-lg-2 control-label">Procedure Code (Medicare)</label>

      <div class="col-lg-10">
        <input type="text" class="form-control" id="procedure_code">
      </div>
    </div>
    </fieldset>

    <fieldset class="real-param" style="display: none;">
      <legend>Service Provider</legend>

      <div class="form-group real-param">
        <label for="provider_npi" class="col-lg-2 control-label">NPI</label>

        <div class="col-lg-10">
          <input type="text" class="form-control" id="provider_npi" value="<?php echo $r['npi']; ?>">
        </div>
      </div>

      <div class="form-group real-param">
        <label for="provider_last_name" class="col-lg-2 control-label">Last Name</label>

        <div class="col-lg-10">
          <input type="text" class="form-control" id="provider_last_name" value="<?php echo $r['doc_lastname']; ?>">
        </div>
      </div>

      <div class="form-group real-param">
        <label for="provider_first_name" class="col-lg-2 control-label">First Name</label>

        <div class="col-lg-10">
          <input type="text" class="form-control" id="provider_first_name" value="<?php echo $r['doc_firstname']; ?>" >
        </div>
      </div>

      <div class="form-group real-param">
        <label for="provider_organization_name" class="col-lg-2 control-label">Organization Name</label>

        <div class="col-lg-10">
          <input type="text" class="form-control" id="provider_organization_name" value="<?php echo $r['practice']; ?>">
        </div>
      </div>

      <div class="form-group real-param">
        <label for="provider_tax_id" class="col-lg-2 control-label">Tax ID</label>

        <div class="col-lg-10">
          <input type="text" class="form-control" id="provider_tax_id" value="<?php echo $r['tax_id_or_ssn']; ?>">
        </div>
      </div>

      <div class="form-group real-param">
        <label for="provider_taxonomy_code" class="col-lg-2 control-label">Taxonomy Code</label>

        <div class="col-lg-10">
          <input type="text" class="form-control" id="provider_taxonomy_code" value="332B00000X">
        </div>
      </div>

      <div class="form-group real-param">
        <label for="provider_submitter_id" class="col-lg-2 control-label">Submitter ID</label>

        <div class="col-lg-10">
          <input type="text" class="form-control" id="provider_submitter_id">
        </div>
      </div>
      <div class="form-group real-param">
        <label for="provider_street_line_1" class="col-lg-2 control-label">Street Line 1</label>

        <div class="col-lg-10">
          <input type="text" class="form-control" id="provider_street_line_1" value="<?php echo $service_address; ?>">
        </div>
      </div>

      <div class="form-group real-param">
        <label for="provider_street_line_2" class="col-lg-2 control-label">Street Line 2</label>

        <div class="col-lg-10">
          <input type="text" class="form-control" id="provider_street_line_2">
        </div>
      </div>

      <div class="form-group real-param">
        <label for="provider_city" class="col-lg-2 control-label">City</label>

        <div class="col-lg-10">
          <input type="text" class="form-control" id="provider_city" value="<?php echo $service_city; ?>">
        </div>
      </div>

      <div class="form-group real-param">
        <label for="provider_state" class="col-lg-2 control-label">State</label>

        <div class="col-lg-10">
          <input type="text" class="form-control" id="provider_state" value="<?php echo $service_state; ?>">
        </div>
      </div>

      <div class="form-group real-param">
        <label for="provider_zip" class="col-lg-2 control-label">ZIP</label>

        <div class="col-lg-10">
          <input type="text" class="form-control" id="provider_zip" value="<?php echo $service_zip; ?>">
        </div>
      </div>


    </fieldset>

    <fieldset class="real-param" style="display: none;">
      <legend>Subscriber</legend>

      <div class="form-group real-param">
        <label for="member_id" class="col-lg-2 control-label">ID</label>

        <div class="col-lg-10">
          <input type="text" class="form-control" id="member_id" value="<?php echo $r['p_m_ins_id']; ?>">
        </div>
      </div>

      <div class="form-group real-param">
        <label for="member_last_name" class="col-lg-2 control-label">Last Name</label>

        <div class="col-lg-10">
          <input type="text" class="form-control" id="member_last_name" value="<?php echo $r['p_m_partylname']; ?>">
        </div>
      </div>

      <div class="form-group real-param">
        <label for="member_first_name" class="col-lg-2 control-label">First Name</label>

        <div class="col-lg-10">
          <input type="text" class="form-control" id="member_first_name" value="<?php echo $r['p_m_partyfname']; ?>">
        </div>
      </div>

      <div class="form-group real-param">
        <label for="member_dob" class="col-lg-2 control-label">DOB</label>

        <div class="col-lg-10">
          <input type="text" class="form-control" id="member_dob" value="<?php echo $r['ins_dob']; ?>">
        </div>
      </div>

      <div class="form-group real-param">
        <label for="member_ssn" class="col-lg-2 control-label">SSN</label>

        <div class="col-lg-10">
          <input type="text" class="form-control" id="member_ssn" value="<?php echo $r['ssn']; ?>">
        </div>
      </div>

      <div class="form-group real-param">
        <label for="member_employee_id" class="col-lg-2 control-label">Employee ID</label>

        <div class="col-lg-10">
          <input type="text" class="form-control" id="member_employee_id">
        </div>
      </div>

      <div class="form-group real-param">
        <label for="member_gender" class="col-lg-2 control-label">Gender</label>

        <div class="col-lg-10">
          <input type="text" class="form-control" id="member_gender" value="<?php echo $r['p_m_gender']; ?>">
        </div>
      </div>

      <div class="form-group real-param">
        <label for="member_group_id" class="col-lg-2 control-label">Group ID</label>

        <div class="col-lg-10">
          <input type="text" class="form-control" id="member_group_id" value="<?php echo $r['p_m_ins_grp']; ?>">
        </div>
      </div>

      <div class="form-group real-param">
        <label for="member_state" class="col-lg-2 control-label">State</label>

        <div class="col-lg-10">
          <input type="text" class="form-control" id="member_state" value="<?php echo $s_state; ?>">
        </div>
      </div>

      <div class="form-group real-param">
        <label for="member_city" class="col-lg-2 control-label">City</label>

        <div class="col-lg-10">
          <input type="text" class="form-control" id="member_city" value="<?php echo $s_city; ?>">
        </div>
      </div>

      <div class="form-group real-param">
        <label for="member_zip" class="col-lg-2 control-label">ZIP</label>

        <div class="col-lg-10">
          <input type="text" class="form-control" id="member_zip" value="<?php echo $s_zip; ?>">
        </div>
      </div>

    </fieldset>

    <fieldset class="real-param" style="display: none;">
      <legend>Dependent</legend>

      <div class="form-group real-param">
        <label for="dependent_id" class="col-lg-2 control-label">ID</label>

        <div class="col-lg-10">
          <input type="text" class="form-control" id="dependent_id">
        </div>
      </div>

      <div class="form-group real-param">
        <label for="dependent_last_name" class="col-lg-2 control-label">Last Name</label>

        <div class="col-lg-10">
          <input type="text" class="form-control" id="dependent_last_name" value="<?php echo $d_last_name; ?>">
        </div>
      </div>

      <div class="form-group real-param">
        <label for="dependent_first_name" class="col-lg-2 control-label">First Name</label>

        <div class="col-lg-10">
          <input type="text" class="form-control" id="dependent_first_name" value="<?php echo $d_first_name; ?>">
        </div>
      </div>

      <div class="form-group real-param">
        <label for="dependent_dob" class="col-lg-2 control-label">DOB</label>

        <div class="col-lg-10">
          <input type="text" class="form-control" id="dependent_dob" value="<?php echo $d_dob; ?>">
        </div>
      </div>

      <div class="form-group real-param">
        <label for="dependent_ssn" class="col-lg-2 control-label">SSN</label>

        <div class="col-lg-10">
          <input type="text" class="form-control" id="dependent_ssn" value="<?php echo $d_ssn; ?>">
        </div>
      </div>

      <div class="form-group real-param">
        <label for="dependent_employee_id" class="col-lg-2 control-label">Employee ID</label>

        <div class="col-lg-10">
          <input type="text" class="form-control" id="dependent_employee_id">
        </div>
      </div>

      <div class="form-group real-param">
        <label for="dependent_gender" class="col-lg-2 control-label">Gender</label>

        <div class="col-lg-10">
          <input type="text" class="form-control" id="dependent_gender" value="<?php echo $d_gender; ?>">
        </div>
      </div>

      <div class="form-group real-param">
        <label for="dependent_group_id" class="col-lg-2 control-label">Group ID</label>

        <div class="col-lg-10">
          <input type="text" class="form-control" id="dependent_group_id">
        </div>
      </div>

      <div class="form-group real-param">
        <label for="dependent_state" class="col-lg-2 control-label">State</label>

        <div class="col-lg-10">
          <input type="text" class="form-control" id="dependent_state" value="<?php echo $d_state; ?>">
        </div>
      </div>

      <div class="form-group real-param">
        <label for="dependent_city" class="col-lg-2 control-label">City</label>

        <div class="col-lg-10">
          <input type="text" class="form-control" id="dependent_city" value="<?php echo $d_city; ?>">
        </div>
      </div>

      <div class="form-group real-param">
        <label for="dependent_zip" class="col-lg-2 control-label">ZIP</label>

        <div class="col-lg-10">
          <input type="text" class="form-control" id="dependent_zip" value="<?php echo $d_zip; ?>">
        </div>
      </div>

    </fieldset>

    <div style="clear:both;" class="form-group">
      <div class="col-lg-offset-2 col-lg-10">
	<input type="hidden" name="pid" id="pid" value="<?php echo (!empty($_GET['pid']) ? $_GET['pid'] : ''); ?>" />
        <input type="hidden" class="form-control" id="service_type" value="12">
        <button type="submit" class="btn btn-primary btn-lg">Submit</button>
      </div>
    </div>

  </form>

</div>
<div id="coverage_container"></div>
  <h2>Eligibility Check History</h2>
<table>
  <tr>
    <th width="200">Date</th>
    <th>View</th>
  </tr>

<?php 
  $s = "SELECT * FROM dental_eligibility WHERE patientid='".mysqli_real_escape_string($con, (!empty($_GET['pid']) ? $_GET['pid'] : ''))."'";
  $q = $db->getResults($s);
  if ($q) {
    foreach ($q as $r) {?>

	<tr>
	  <td><?php echo $r['adddate']; ?></td>
          <td><a href="#" onclick="parent.window.location = '../view_eligibility_response.php?id=<?php echo $r['id']; ?>';return false;">View</a></td>
        </tr>

<?php
     }
   }?>
</table>

<script src="js/eligible_check.js"></script>

<link rel="stylesheet" href="css/eligible_check.css" type="text/css" media="screen" />

<?php //include 'new.php'; ?> 
