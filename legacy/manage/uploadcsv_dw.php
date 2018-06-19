<?php
namespace Ds3\Libraries\Legacy;

set_time_limit(0);

include "includes/top.htm";
require_once('includes/constants.inc');
require_once('includes/formatters.php');
require_once('includes/checkemail.php');
require_once('includes/general_functions.php');
include 'includes/dental_patient_summary.php';
?>
<div style="width:90%; margin-left:5%;">
<?php

$db = new Db();

if(isset($_POST['submitbut'])){
    // check there are no errors
    if($_FILES['csv']['error'] == 0){
        $ext = strtolower(preg_replace('/^.*[.]([^.]+)$/', '$1', ($_FILES['csv']['name'])));
        $tmpName = $_FILES['csv']['tmp_name'];

        // check the file is a csv
        if($ext === 'csv'){
            if(($handle = fopen($tmpName, 'r')) !== FALSE) {
                // necessary if a large csv file
                set_time_limit(0);

                $row = 0;
                $error_count = 0;
                $error_array = [];
                while(($data = fgetcsv($handle, 1000, ',')) !== FALSE) {
                    // get the values from the csv
                    if($row == 0){
                        for($i=0;$i<27;$i++){
                            switch(strtolower(trim($data[$i]))){
                                case 'lastname':
                                    $fields[] = 'lastname';
                                    break;
                                case 'firstname':
                                    $fields[] = 'firstname';
                                    break;
                                case 'middleinit':
                                    $fields[] = 'middlename';
                                    break;
                                case 'title':
                                    $fields[] = 'salutation';
                                    break;
                                case 'patientid':
                                    $fields[]='';
                                    break;
                                case 'active':
                                        $fields[] = 'status';
                                        break;
                                case 'address1':
                                        $fields[] = 'add1';
                                        break;
                                case 'address2':
                                    $fields[] = 'add2';
                                    break;
                                case 'city':
                                    $fields[] = 'city';
                                    break;
                                case 'state':
                                    $fields[] = 'state';
                                    break;
                                case 'postalcode':
                                    $fields[] = 'zip';
                                    break;
                                case 'gender':
                                    $fields[] = 'gender';
                                    break;
                                case 'birthday':
                                    $fields[] = 'dob';
                                    break;
                                case 'homephone':
                                    $fields[] = 'home_phone';
                                    break;
                                case 'workphone':
                                    $fields[] = 'work_phone';
                                    break;
                                case 'cellphone':
                                    $fields[] = 'cell_phone';
                                    break;
                                case 'email':
                                    $fields[] = 'email';
                                    break;
                                case 'marital':
                                    $fields[] = 'marital_status';
                                    break;
                                case 'ssn':
                                    $fields[] = 'ssn';
                                    break;
                                case 'heightfeet':
                                    $fields[] = 'feet';
                                    break;
                                case 'heightinches':
                                    $fields[] = 'inches';
                                    break;
                                case 'spousename':
                                    $fields[] = 'partner_name';
                                    break;
                                case 'spousebirthday':
                                    $fields[] = '';
                                    break;
                                case 'responsibleperson':
                                    $fields[] = '';
                                    break;
                                case 'physicianname':
                                    $fields[] = '';
                                    break;
                            }
                        }
                        $row++;
                    }else{
                        $patientphone = $patientemail = $patientdob = $patientadd = $patientcity = $patientstate = $patientzip = $patientgender = false;
                        $s = "INSERT INTO dental_patients SET ";
                        foreach($fields AS $id => $field){
                            switch($field){
                                case 'status':
                                    if(strtolower($data[$id])=="true"){
                                        $s .= $field . " = '3', ";
                                    }elseif(strtolower($data[$id])=="false"){
                                        $s .= $field . " = '4', ";
                                    }
                                    break;
                                case 'dob':
                                    if($data[$id]!=''){
                                        $patientdob = true;
                                        $timestamp = strtotime($data[$id]);

                                        if (!$timestamp) {
                                            $timestamp = str_replace('/', '-', $data[$id]);
                                            $timestamp = strtotime($timestamp);
                                        }

                                        $d = $timestamp ? date('m/d/Y', $timestamp) : $data[$id];
                                        $s .= $field . " = '" .$d."', ";
                                    }
                                    break;
                                case 'work_phone':
                                case 'home_phone':
                                case 'cell_phone':
                                    if($field!='' && $data[$id] !=''){
                                        $patientphone = true;
                                        $s .= $field . " = '" .num($data[$id])."', ";
                                    }
                                    break;
                                case 'add1':
                                    if($field!='' && $data[$id] !=''){
                                        $patientadd = true;
                                        $s .= $field . " = '" .$db->escape($data[$id])."', ";
                                    }
                                    break;
                                case 'city':
                                    if($field!='' && $data[$id] !=''){
                                        $patientcity = true;
                                        $s .= $field . " = '" .$db->escape($data[$id])."', ";
                                    }
                                    break;
                                case 'state':
                                    if($field!='' && $data[$id] !=''){
                                        $patientstate = true;
                                        $s .= $field . " = '" .$db->escape($data[$id])."', ";
                                    }
                                    break;
                                case 'zip':
                                    if($field!='' && $data[$id] !=''){
                                        $patientzip = true;
                                        $s .= $field . " = '" .$db->escape($data[$id])."', ";
                                    }
                                    break;
                                case 'gender':
                                    if($field!='' && $data[$id] !=''){
                                        $patientgender = true;
                                        $s .= $field . " = '" .$db->escape($data[$id])."', ";
                                    }
                                    break;
                                case 'email':
                                    if($field!=''){
                                        $email = $data[$id];
                                        if(checkEmail($email, 0)>0){
                                            array_push($error_array, $data[1]." ".$data[0]." - ".$email);
                                            $error_count++;
                                        }else{
                                            $patientemail = true;
                                            $s .= $field . " = '" .$db->escape($data[$id])."', ";
                                        }
                                    }
                                    break;
                                default:
                                    if($field!=''){
                                        $s .= $field . " = '" .$db->escape($data[$id])."', ";
                                    }
                                    break;
                            }
                        }
                        $s .= " docid = '".$_SESSION['docid']."', adddate = NOW(), ip_address = '".$db->escape($_SERVER['REMOTE_ADDR'])."'";
                        $pid = $db->getInsertId($s);

                        $complete_info = 0;
                        if (($patientemail || $patientphone) && $patientadd && $patientcity && $patientstate && $patientzip && $patientdob && $patientgender) {
                                $complete_info = 1;
                        }
                        // Determine Whether Patient Info has been set
                        update_patient_summary($pid, 'patient_info', $complete_info);

                        $copyreqdate = date('m/d/Y');

                        if($copyreqdate!=''){
                            $db->query("INSERT INTO dental_flow_pg1 (`pid`,`copyreqdate`) VALUES ('".$pid."', '".$copyreqdate."')");
                            $stepid = '1';
                            $segmentid = '1';
                            $scheduled = date('Y-m-d', strtotime($copyreqdate));
                            $steparray_query = "INSERT INTO dental_flow_pg2 (`patientid`, `steparray`) VALUES ('".$pid."', '".$segmentid."');";
                            $flow_pg2_info_query = "INSERT INTO dental_flow_pg2_info (`patientid`, `stepid`, `segmentid`, `date_scheduled`, `date_completed`) VALUES ('".$pid."', '".$stepid."', '".$segmentid."', '".$scheduled."', '".$scheduled."');";
                            $db->query($steparray_query);
                            $db->query($flow_pg2_info_query);

                            if(!empty($last_visit)){
                                $visit_date = date('Y-m-d', strtotime($last_visit));
                                $steparray_query = "UPDATE dental_flow_pg2 SET steparray = '1,2' WHERE patientid='".$pid."'";
                                $flow_pg2_info_query = "INSERT INTO dental_flow_pg2_info (`patientid`, `stepid`, `segmentid`, `date_scheduled`, `date_completed`) VALUES ('".$pid."', '2', '2', '".$visit_date."', '".$visit_date."');";
                                $db->query($steparray_query);
                                $db->query($flow_pg2_info_query);
                            }
                        }
                        $row++;
                    }
                }
                fclose($handle);
                $msg = "<h4>Inserted ".($row-1)." rows.</h4>";
                if($error_count){
                    $msg .= "<p>".$error_count." errors. Imported emails already assigned to existing patients. The following email addresses will not be imported:</p><ul>";
                        foreach($error_array as $e){
                            $msg .= "<li>".$e."</li>";
                        }
                    $msg .= "</ul>";
                }
            ?>
            <script type="text/javascript">
                window.location = "pending_patient.php?msg=<?php echo $msg; ?>";
            </script>
            <?php
            }
        }
    }
}
?> 
<span class="admin_head">
    Dental Writer Upload
</span>

<br /><br />
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data" method="post">
    <p>Dates must be in mm/dd/yyyy format.</p>
    <input type="file" name="csv" />
    <br />
    <br />
    <input type="submit" name="submitbut" value="Upload" />
</form>
</div>
<br /><br />
<?php include "includes/bottom.htm";?>
