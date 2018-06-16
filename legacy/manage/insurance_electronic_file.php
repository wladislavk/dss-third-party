<?php
namespace Ds3\Libraries\Legacy;

include_once 'includes/constants.inc';
include_once 'admin/includes/main_include.php';
include_once 'admin/includes/claim_functions.php';
include_once 'admin/includes/invoice_functions.php';

$db = new Db();

$pat_sql = "select * from dental_patients where patientid='".s_for((!empty($_GET['pid']) ? $_GET['pid'] : ''))."'";
$pat_myarray = $db->getRow($pat_sql);

$pat_lastname = $pat_myarray['lastname'];
$pat_firstname = $pat_myarray['firstname'];
$pat_gender = substr($pat_myarray['gender'], 0, 1);
$pat_dob = ($pat_myarray['dob'] != '') ? date('Y-m-d', strtotime($pat_myarray['dob'])) : '';

switch ($pat_myarray['p_m_relation']) {
    case 'Self':
        $relationship_id = '18';
        break;
    case 'Spouse':
        $relationship_id = '01';
        break;
    case 'Child':
        $relationship_id = '19';
        break;
    case 'Other':
        $relationship_id = 'G8';
        break;
    default:
        $relationship_id = '21';
        break;
}

$insurancetype = st($pat_myarray['p_m_ins_type']);
$insured_firstname = strtoupper(st($pat_myarray['p_m_partyfname']));
$insured_lastname = strtoupper(st($pat_myarray['p_m_partylname']));
$insured_id_number = preg_replace("/[^A-Za-z0-9 ]/", '', $pat_myarray['p_m_ins_id']);
$insured_dob = st($pat_myarray['ins_dob']);
$claim_ins_dob = ($insured_dob != '') ? date('Y-m-d', strtotime($insured_dob)) : '';
$p_m_ins_ass = st($pat_myarray['p_m_ins_ass']);
$claim_assignment = ($p_m_ins_ass == 'Yes') ? "A" : "C";

if ($pat_myarray['p_m_ins_type'] == 1) {
    $insured_policy_group_feca = "NONE";
    $insured_insurance_plan = '';
} else {
    $insured_policy_group_feca = $pat_myarray['p_m_ins_grp'];
    $insured_insurance_plan = $pat_myarray['p_m_ins_plan'];
}

$docid = st($pat_myarray['docid']);

$sql = "select * from dental_insurance where insuranceid='".(!empty($_GET['insid']) ? $_GET['insid'] : '')."' and patientid='".(!empty($_GET['pid']) ? $_GET['pid'] : '')."'";
$my = $db->getResults($sql);
$myarray = (!empty($my[0]) ? $my[0] : []);

if (!empty($myarray)) {
    $is_pending = ($status == DSS_CLAIM_PENDING || $myarray['status'] == DSS_CLAIM_SEC_PENDING) ? true : false;
    $insuranceid = st($myarray['insuranceid']);
    $eligible_id = $myarray['p_m_eligible_payer_id'];
    $eligible_ins = $myarray['p_m_eligible_payer_name'];

    if (!empty($_GET['type']) && $_GET['type'] == 'secondary') {
        $insurancetype = st($myarray['other_insurance_type']);
        $insured_id_number = preg_replace("/[^A-Za-z0-9 ]/", '', $myarray['other_insured_id_number']);
        $insured_firstname = st($myarray['other_insured_firstname']);
        $insured_lastname = st($myarray['other_insured_lastname']);
        $insured_insurance_plan = st($myarray['other_insured_insurance_plan']);
        $insured_policy_group_feca = st($myarray['other_insured_policy_group_feca']);
        $insured_address = st($myarray['other_insured_address']);
        $insured_city = st($myarray['other_insured_city']);
        $insured_state = st($myarray['other_insured_state']);
        $insured_zip = st($myarray['other_insured_zip']);
    } else {
        $insurancetype = st($myarray['insurance_type']);
        $insured_id_number = preg_replace("/[^A-Za-z0-9 ]/", '', $myarray['insured_id_number']);
        $insured_firstname = st($myarray['insured_firstname']);
        $insured_lastname = st($myarray['insured_lastname']);
        $insured_insurance_plan = st($myarray['insured_insurance_plan']);
        $insured_policy_group_feca = st($myarray['insured_policy_group_feca']);
        $insured_address = st($myarray['insured_address']);
        $insured_city = st($myarray['insured_city']);
        $insured_state = st($myarray['insured_state']);
        $insured_zip = st($myarray['insured_zip']);
    }
}

if (!empty($myarray)) {
    $diagnosis_1 = st($myarray['diagnosis_1']);
    $diagnosis_2 = st($myarray['diagnosis_2']);
    $diagnosis_3 = st($myarray['diagnosis_3']);
    $diagnosis_4 = st($myarray['diagnosis_4']);
    $total_charge = str_replace(",", '', st($myarray['total_charge']));
}

if (empty($insured_id_number)) {
    $insured_id_number = preg_replace("/[^A-Za-z0-9 ]/", '', $pat_myarray['p_m_ins_id']);
}

if (empty($insured_firstname)) {
    $insured_firstname = $pat_myarray['p_d_party'];
}

if (empty($insured_address)) {
    $insured_address = $pat_myarray['add1'];
}

if (empty($insured_city)) {
    $insured_city = $pat_myarray['city'];
}

if (empty($insured_state)) {
    $insured_state = $pat_myarray['state'];
}

if (empty($insured_zip)) {
    $insured_zip = $pat_myarray['zip'];
}

if (empty($insured_policy_group_feca)) {
    $insured_policy_group_feca = $pat_myarray['group_number'];
}

if (empty($insured_insurance_plan)) {
    $insured_insurance_plan = $pat_myarray['plan_name'];
}

if ($pat_myarray['p_m_ins_type'] == 1) {
    $insured_policy_group_feca = "NONE";
    $insured_insurance_plan = '';
}

if (!empty($is_pending)) {
    $insurancetype = st($pat_myarray['p_m_ins_type']);
    $insured_firstname = st($pat_myarray['p_m_partyfname']);
    $insured_lastname = st($pat_myarray['p_m_partylname']);
    $insured_id_number = preg_replace("/[^A-Za-z0-9 ]/", '', $pat_myarray['p_m_ins_id']);
    $insured_insurance_plan = st($pat_myarray['p_m_ins_plan']);
    $insured_policy_group_feca = st($pat_myarray['p_m_ins_grp']);
    $docid = $pat_myarray['docid'];
}

$prod_s = "SELECT producer FROM dental_insurance WHERE insuranceid='".mysqli_real_escape_string($con, (!empty($_GET['insid']) ? $_GET['insid'] : ''))."'";
$prod_r = $db->getRow($prod_s);
$claim_producer = $prod_r['producer'];

$getuserinfo = "SELECT * FROM `dental_users` WHERE producer_files=1 AND `userid` = '".$claim_producer."'";
if ($userinfo = $db->getRow($getuserinfo)) {
    $practice = $userinfo['practice'];
    $address = $userinfo['address'];
    $city = $userinfo['city'];
    $state = $userinfo['state'];
    $zip = $userinfo['zip'];
    $npi = $userinfo['npi'];
    $tax_id_or_ssn = $userinfo['tax_id_or_ssn'];
    $medicare_ptan = $userinfo['medicare_ptan'];
}

$getdocinfo = "SELECT * FROM `dental_users` WHERE `userid` = '".$docid."'";
$docinfo = $db->getRow($getdocinfo);

if (empty($practice)) {
    $practice = $docinfo['practice'];
}
if (empty($address)) {
    $address = $docinfo['address'];
}
if (empty($city)) {
    $city = $docinfo['city'];
}
if (empty($state)) {
    $state = $docinfo['state'];
}
if (empty($zip)) {
    $zip = $docinfo['zip'];
}
if (empty($npi)) {
    $npi = $docinfo['npi'];
}
if (empty($tax_id_or_ssn)) {
    $tax_id_or_ssn = $docinfo['tax_id_or_ssn'];
}
if (empty($medicare_ptan)) {
    $medicare_ptan = $docinfo['medicare_ptan'];
}

$ins_diag_sql = "select * from dental_ins_diagnosis where ins_diagnosisid=".(!empty($diagnosis_1) ? $diagnosis_1 : '');
$ins_diag_myarray = $db->getRow($ins_diag_sql);
$diagnosis_1 = (!empty($ins_diag_myarray['ins_diagnosis']) ? $ins_diag_myarray['ins_diagnosis'] : '');

$ins_diag_sql = "select * from dental_ins_diagnosis where ins_diagnosisid=".(!empty($diagnosis_2) ? $diagnosis_2 : '');
$ins_diag_myarray = $db->getRow($ins_diag_sql);
$diagnosis_2 = (!empty($ins_diag_myarray['ins_diagnosis']) ? $ins_diag_myarray['ins_diagnosis'] : '');

$ins_diag_sql = "select * from dental_ins_diagnosis where ins_diagnosisid=".(!empty($diagnosis_3) ? $diagnosis_3 : '');
$ins_diag_myarray = $db->getRow($ins_diag_sql);
$diagnosis_3 = (!empty($ins_diag_myarray['ins_diagnosis']) ? $ins_diag_myarray['ins_diagnosis'] : '');

$ins_diag_sql = "select * from dental_ins_diagnosis where ins_diagnosisid=".(!empty($diagnosis_4) ? $diagnosis_4 : '');
$ins_diag_myarray = $db->getRow($ins_diag_sql);
$diagnosis_4 = (!empty($ins_diag_myarray['ins_diagnosis']) ? $ins_diag_myarray['ins_diagnosis'] : '');

//FOR TESTING PURPOSES
if (isset($_GET['memid']) && $_GET['memid'] != '') {
    $insured_id_number = $_GET['memid'];
}

$data = [];
if (isset($_GET['test']) && $_GET['test'] == 1) {
    $data['test'] = 'true';
}
$api_key = DSS_DEFAULT_ELIGIBLE_API_KEY;
$api_key_sql = "SELECT eligible_api_key FROM dental_user_company LEFT JOIN companies ON dental_user_company.companyid = companies.id WHERE dental_user_company.userid = '".mysqli_real_escape_string($con, $docid)."'";
$api_key_query = mysqli_query($con, $api_key_sql);
$api_key_result = mysqli_fetch_assoc($api_key_query);
if ($api_key_result) {
    if (!empty(trim($api_key_result['eligible_api_key']))) {
        $api_key = $api_key_result['eligible_api_key'];
    }
}

$data['api_key'] = $api_key;

$data['receiver'] = [
    "organization_name" => (!empty($eligible_ins) ? $eligible_ins : ''),
    "id" => (!empty($eligible_id) ? $eligible_id : ''),
];

$data['billing_provider']= array(
    "taxonomy_code" => "332B00000X",
    "practice_name" => $practice,
    "npi" => $npi,
    "address" => array(
        "street_line_1" => str_replace(',', '', $address),
        "street_line_2" => "",
        "city" => $city,
        "state" => $state,
        "zip" => $zip),
    "tin" => $tax_id_or_ssn,
    "insurance_provider_id" => $medicare_ptan);

$data['subscriber'] = array(
    "last_name" => $insured_lastname,
    "first_name" => $insured_firstname,
    "member_id" => $insured_id_number,
    "group_id" => $insured_policy_group_feca,
    "group_name" => $insured_insurance_plan,
    "gender" => $pat_gender,
    "address" => array(
            "street_line_1" => $insured_address,
            "street_line_2" => "",
            "city" => $insured_city,
            "state" => $insured_state,
            "zip" => $insured_zip),
    "dob" => $claim_ins_dob);

$ins_contact_qry = "SELECT * FROM `dental_contact` WHERE contactid='".mysqli_real_escape_string($con,$pat_myarray['p_m_ins_co'])."' AND contacttypeid = '11' AND docid='".$pat_myarray['docid']."'";

$ins_contact_res = $db->getRow($ins_contact_qry);
$data['payer'] = array(
    "name" => (!empty($eligible_ins) ? $eligible_ins : ''),
    "id" => (!empty($eligible_id) ? $eligible_id : ''),
    "address" => array(
        "street_line_1" => $ins_contact_res['add1'],
        "street_line_2" =>  $ins_contact_res['add2'],
        "city" =>  $ins_contact_res['city'],
        "state" =>  $ins_contact_res['state'],
        "zip" =>  $ins_contact_res['zip']));

if ($relationship_id != 18) {
    $data['dependent'] = [
        "relationship" => $relationship_id,
        "last_name" => $pat_lastname,
        "first_name" => $pat_firstname,
        "dob" => $pat_dob,
        "gender" => $pat_gender,
        "address" => [
            "street_line_1" => $insured_address,
            "street_line_2" => "",
            "city" => $insured_city,
            "state" => $insured_state,
            "zip" => $insured_zip,
        ],
    ];
}

$diagnosis_pointer = [];
$diagnosis_pointer[1] = $diagnosis_1;
$diagnosis_pointer[2] = $diagnosis_2;
$diagnosis_pointer[3] = $diagnosis_3;
$diagnosis_pointer[4] = $diagnosis_4;

// Load pending medical trxns if new claim form. Otherwise, load associated trxns.
$sql = "SELECT "
     . "  ledger.*, ";
if ($insurancetype == '1') {
    $sql .= " user.medicare_npi ";
} else {
    $sql .= " user.npi ";
}

$sql .= " as 'provider_id', ps.place_service as 'place' "
    . "FROM "
    . "  dental_ledger ledger "
    . "  JOIN dental_users user ON user.userid = ledger.docid "
    . "  JOIN dental_transaction_code trxn_code ON trxn_code.transaction_code = ledger.transaction_code "
    . "  LEFT JOIN dental_place_service ps ON trxn_code.place = ps.place_serviceid "
    . "WHERE "
    . "  ledger.primary_claim_id = " . (!empty($insuranceid) ? $insuranceid : '') . " "
    . "  AND ledger.patientid = " . (!empty($_GET['pid']) ? $_GET['pid'] : '') . " "
    . "  AND ledger.docid = " . $docid . " "
    . "  AND trxn_code.docid = " . $docid . " "
    . "  AND trxn_code.type = " . DSS_TRXN_TYPE_MED . " "
    . "ORDER BY "
    . "  ledger.service_date ASC";
$query = $db->getResults($sql);
$c = 0;
$claim_lines = [];

if ($query) {
    foreach ($query as $array) {
        $c++;
        $diagnosis = '';
        if ($array['diagnosispointer'] != '') {
            if (isset($diagnosis_pointer[$array['diagnosispointer']])) {
                $diagnosis = $diagnosis_pointer[$array['diagnosispointer']];
            }
        }

        $a = [
            "line_number" => "$c",
            "qualifier" => "HC",
            "product_service" => $array['transaction_code'],
            "charge_amount" => $array['amount'],
            "place_of_service" => preg_replace("/[^0-9]/","",$array['placeofservice']),
            "modifier_1" => $array['modcode'],
            "modifier_2" => $array['modcode2'],
            "modifier_3" => $array['modcode3'],
            "modifier_4" => $array['modcode4'],
            "diagnosis_1" => $diagnosis,
            "service_start" => ($array['service_date'] != '')?date('Y-m-d', strtotime($array['service_date'])):'',
            "service_end" =>  ($array['service_date'] != '')?date('Y-m-d', strtotime($array['service_date'])):''
        ];
        array_push($claim_lines, $a);
    }
}

$data['claim'] = [
    "claim_number" => (!empty($_GET['insid']) ? $_GET['insid'] : ''),
    "total_charge_amount" => (!empty($total_charge) ? $total_charge : ''),
    "claim_frequency" => "1",
    "patient_signature_on_file" => "Y",
    "provider_plan_participation" => $claim_assignment,
    "direct_payment_authorized" => "Y",
    "release_of_information" => "I",
    "service_lines" => $claim_lines,
];

$data_string = json_encode($data);
error_log($data_string);

$ch = curl_init('https://gds.eligibleapi.com/v1.5/claims.json');
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Content-Length: ' . strlen($data_string)
]);

$result = curl_exec($ch);
$json_response = json_decode($result);

if (!empty($json_response)) {
    $ref_id = $json_response->{"reference_id"};
    $success = $json_response->{"success"};
}

$up_sql = "INSERT INTO dental_claim_electronic SET 
    claimid='".mysqli_real_escape_string($con, (!empty($_GET['insid']) ? $_GET['insid'] : ''))."',
    reference_id = '".mysqli_real_escape_string($con, (!empty($ref_id) ? $ref_id : ''))."',
    response='".mysqli_real_escape_string($con, $result)."',
    adddate=now(),
    ip_address='".mysqli_real_escape_string($con, $_SERVER['REMOTE_ADDR'])."'
";

$dce_id = $db->getInsertId($up_sql);
invoice_add_efile('1', $docid, $dce_id);
invoice_add_claim('1', $docid, (!empty($_GET['insid']) ? $_GET['insid'] : ''));

if (empty($success) || !$success) {
    $up_sql = "UPDATE dental_insurance SET status='".DSS_CLAIM_REJECTED."' WHERE insuranceid='".mysqli_real_escape_string($con, (!empty($_GET['insid']) ? $_GET['insid'] : ''))."'";
    $db->query($up_sql);
    claim_status_history_update((!empty($_GET['ins_id']) ? $_GET['ins_id'] : ''), '', DSS_CLAIM_REJECTED, $_SESSION['userid']);
    ?>
    <script type="text/javascript">
        c = confirm('RESPONSE: <?php echo $result; ?> Do you want to mark the claim sent?');
        if (c) {
            window.location = "manage_claims.php?status=0&insid=<?php echo $_GET['insid']; ?>";
        }
    </script>
    <?php
} else { ?>
    <script type="text/javascript">
        c = confirm('RESPONSE: <?php echo $result; ?> Do you want to mark the claim sent?');
        if (c) {
            window.location = "manage_claims.php?insid=<?php echo $_GET['insid']; ?>&upstatus=<?php echo DSS_CLAIM_SENT; ?>";
        }
    </script>
<?php
}

function fill_cents($v)
{
    if ($v < 10) {
        return '0'.$v;
    } else {
        return $v;
    }
}
