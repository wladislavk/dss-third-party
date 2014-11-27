<link rel="stylesheet" href="css/eligible_api.css" />
<?php
  $s = "SELECT p.*, c.company, u.name as doc_name, u.npi from dental_patients p
        LEFT JOIN dental_contact c ON c.contactid = p.p_m_ins_co
        LEFT JOIN dental_users u ON u.userid = p.docid
   	    WHERE p.patientid='".mysqli_real_escape_string($con, (!empty($_GET['pid']) ? $_GET['pid'] : ''))."'";

  $r = $db->getRow($s);
  $doc_name = $r['doc_name'];
  $doc_array = explode(' ',$doc_name);
  $doc_first_name = $doc_array[0];
  $doc_last_name = (!empty($doc_array[1]) ? $doc_array[1] : '');
?>
<form method="post">
  <div id="eligible_api" >
    <h3>EligibleAPI Instant Eligibility</h3>
    <div>
      <label>Insurance from Pt Info:</label>
      <?php echo $r['company']; ?>
    </div>
    <div style="clear:both;">
      <label>Payer Name</label>
      <input type="input" id="payer_name" name="payer_name" value="Type Insurance Here" onclick="clear_payer_name(this);" />
      <span class="description">Insurance Company Name
  	    <br />
        <div id="payer_hints" class="search_hints" style="margin-top:20px; display:none; height: 200px; overflow-y:scroll;">
          <ul id="payer_list" class="search_list">
            <li class="template" style="display:none">Doe, John S</li>
          </ul>
        </div>
      </span>
    </div>

    <script type="text/javascript" src="js/eligible_api.js"></script>
 
    <div>
      <label>Payer ID</label>
      <input type="input" id="payer_id" name="payer_id" />
      <span class="description">Insurance Company ID</span>
    </div>

    <div>
      <label>Provider First Name</label>
      <input type="input" id="provider_first_name" name="provider_first_name" value="<?php echo  $doc_first_name; ?>" />
      <span class="description">Provider First Name</span>
    </div>

    <div>
      <label>Provider Last Name</label>
      <input type="input" id="provider_last_name" name="provider_last_name" value="<?php echo  $doc_last_name; ?>" />
      <span class="description">Provider Last Name</span>
    </div>

    <div>
      <label>Provider NPI</label>
      <input type="input" id="provider_npi" name="provider_npi" value="<?php echo  $r['npi']; ?>" />
      <span class="description">National Provider Identifier</span>
    </div>

    <div>
      <label>Patient Member ID</label>
      <input type="input" id="patient_member_id" name="patient_member_id" value="<?php echo  $r['p_m_ins_id']; ?>" />
      <span class="description">ID number found on patient insurance card</span>
    </div>

    <div>
      <label>Patient First Name</label>
      <input type="input" id="patient_first_name" name="patient_first_name" value="<?php echo  $r['firstname']; ?>" />
      <span class="description">First name of patient being searched</span>
    </div>

    <div>
      <label>Patient Last Name</label>
      <input type="input" id="patient_last_name" name="patient_last_name" value="<?php echo  $r['lastname']; ?>" />
      <span class="description">Last name of patient being searched</span>
    </div>

    <div>
      <label>Patient DOB</label>
      <input type="input" id="patient_dob" name="patient_dob" value="<?php echo  ($r['dob']!='')?date('Y-m-d', strtotime($r['dob'])):''; ?>" />
      <span class="description">Birthday of patient being searched please use YYYY-MM-DD</span>
    </div>

    <div>
      <label>Service Type Code</label>
      <input type="input" id="service_type_code" name="service_type_code" value="30" />
      <span class="description">Optional. Use specific service coverage (diagnostic, lab, etc)</span>
    </div>

    <input type="submit"  name="api_submit" id="api_submit_old" class="addButton" value="Submit Request" />
    <a href="#" onclick="return false;" class="addButton" id="api_submit">Submit AJAX</a>
</form>

<?php
  if(isset($_POST['api_submit'])){
    $payer_id = substr($_POST['payer_id'],0,strpos($_POST['payer_id'], '-'));
    $data = array();
    $data['test'] = "true";
    $data['api_key'] = "33b2e3a5-8642-1285-d573-07a22f8a15b4";
    $data['payer_id'] =  $payer_id;
    $data['service_provider_first_name'] =  $_POST['provider_first_name'];
    $data['service_provider_last_name'] =  $_POST['provider_last_name'];
    $data['provider_npi'] =  $_POST['provider_npi'];
    $data['member_id'] =  $_POST['patient_member_id'];
    $data['member_first_name'] =  $_POST['patient_first_name'];
    $data['member_last_name'] =  $_POST['patient_last_name'];
    $data['member_dob'] =  $_POST['patient_dob'];
    $data['service_type'] =  $_POST['service_type_code'];

    $data_string = json_encode($data);                                                                               

    echo $data_string."<br /><br />"; 
    //$ch = curl_init('https://v1.eligibleapi.net/claim/submit.json?api_key=33b2e3a5-8642-1285-d573-07a22f8a15b4');                                                                      
    $ch = curl_init('https://gds.eligibleapi.com/v1.1/coverage/all.json');
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                 
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                              
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                  
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                      
        'Content-Type: application/json',                                                                            
        'Content-Length: ' . strlen($data_string))                                                                   
    );                                                                                                               

    $result = curl_exec($ch);
    echo $result;
  }
?>

  <div id="api_output"></div>