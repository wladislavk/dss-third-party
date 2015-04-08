<?php
include "includes/top.htm";
require_once('includes/constants.inc');
require_once('includes/formatters.php');
require_once('includes/checkemail.php');
require_once('includes/general_functions.php');
require_once('includes/dental_patient_summary.php');
?>
<div style="width:90%; margin-left:5%;">
<?php


if(isset($_POST['uploadbut'])){
$csv = array();

// check there are no errors
if($_FILES['csv']['error'] == 0){
    $name = $_FILES['csv']['name'];
    $ext = strtolower(end(explode('.', $_FILES['csv']['name'])));
    $type = $_FILES['csv']['type'];
    $tmpName = $_FILES['csv']['tmp_name'];
    $file_name = "patcsv_".$_SESSION['docid']."_".date('U');
    $file_path = "../../../shared/q_file/".$file_name;
    move_uploaded_file($tmpName, $file_path);
    $column = 0;

    // check the file is a csv
    if($ext === 'csv'){
        if(($handle = fopen($file_path, 'r')) !== FALSE) {
            // necessary if a large csv file
            set_time_limit(0);
?><form action="#" method="post">
	<input type="hidden" name="csv_file" value="<?= $file_name; ?>" />
	<?php		
	    $row = fgetcsv($handle, 1000, ',');
	    foreach($row as $data){
		?>
		<div>
		  <?= $data; ?>
		  <select name="row_<?= $column; ?>">
			<option value="">Import into...</option>
			<option value="firstname">First Name</option>
			<option value="lastname">Last Name</option>
                        <option value="middleinit">Middle Initial</option>
                        <option value="title">Title</option>
                        <option value="patientid">Patient ID</option>
                        <option value="active">Active</option>
                        <option value="address1">Address 1</option>
                        <option value="address2">Address 2</option>
                        <option value="city">City</option>
                        <option value="state">State</option>
                        <option value="postalcode">Zip</option>
                        <option value="gender">Gender</option>
                        <option value="birthday">Birthday</option>
                        <option value="homephone">Home Phone</option>
                        <option value="workphone">Work Phone</option>
                        <option value="cellphone">Cell Phone</option>
                        <option value="email">Email</option>
                        <option value="marital">Marital Status</option>
                        <option value="ssn">SSN</option>
                        <option value="heightfeet">Height (ft)</option>
                        <option value="heightinches">Height (in)</option>
                        <option value="spousename">Spouse Name</option>
                        <option value="spousebirthday">Spouse Birthday</option>
                        <option value="responsibleperson">Responsible Person</option>
                        <option value="physicianname">Physician Name</option>
		  </select>
		</div>
		<?php
		$column++;
	    }
	?>
		<input type="submit" name="submitbut" value="Upload" />
		</form>
	<?php
	
	}
    }
}










}elseif(isset($_POST['submitbut'])){
$csv = array();

    // check the file is a csv
        if(($handle = fopen("../../../shared/q_file/".$_POST['csv_file'], 'r')) !== FALSE) {
            // necessary if a large csv file
            set_time_limit(0);

            $row = 0;

		$error_count = 0;
		$error_array = array();
            while(($data = fgetcsv($handle, 1000, ',')) !== FALSE) {
                // number of fields in the csv
                $num = count($data);
                // get the values from the csv
                if($row == 0){
                  for($i=0;$i<27;$i++){
                    switch(strtolower(trim($_POST['row_'.$i]))){ 
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
			default:
				$fields[] = '';
				break;
		    }
		  }
 		  $row++;
		}else{
			$copyreqdate = '';
			$patientphone = $patientemail = $patientdob = $patientadd = $patientcity = $patientstate = $patientzip = $patientgender = false;
			$s = "INSERT INTO dental_patients SET ";
		foreach($fields AS $id => $field){
		  switch($field){
                        case 'status':
                                if($data[$id]=="True"){
                                        $s .= $field . " = '3', ";
                                }elseif($data[$id]=="False"){
                                        $s .= $field . " = '4', ";
                                }
                                break;
			/*case 'marital_status':
				if(trim($data[$id])=="M"){
					$s .= $field . " = 'Married', ";
				}elseif(trim($data[$id])=="U"){
					$s .= $field . " = 'Single', ";
                                }
				break;*/
			case 'dob':
				if($data[$id]!=''){
				  $patientdob = true;
				  $data[$id] = str_replace('/','-', $data[$id]);
				  $d = date('m/d/Y', strtotime($data[$id]));
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
                                        $s .= $field . " = '" .$data[$id]."', ";
                                }
                                break;
                        case 'city':
                                if($field!='' && $data[$id] !=''){
                                        $patientcity = true;
                                        $s .= $field . " = '" .$data[$id]."', ";
                                }
                                break;
                        case 'state':
                                if($field!='' && $data[$id] !=''){
                                        $patientstate = true;
                                        $s .= $field . " = '" .$data[$id]."', ";
                                }
                                break;
                        case 'zip':
                                if($field!='' && $data[$id] !=''){
                                        $patientzip = true;
                                        $s .= $field . " = '" .$data[$id]."', ";
                                }
                                break;
                        case 'gender':
                                if($field!='' && $data[$id] !=''){
                                        $patientgender = true;
                                        $s .= $field . " = '" .$data[$id]."', ";
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
                                        	$s .= $field . " = '" .$data[$id]."', ";
					}
                                }
                                break;

			default:
				if($field!=''){
		  			$s .= $field . " = '" .$data[$id]."', ";
				}
				break;
		   }
		}
			$s .= " docid = '".$_SESSION[docid]."'";
			//echo $s;
			mysqli_query($con, $s);
			$pid = mysqli_insert_id($con);

        $complete_info = 0;
        if (($patientemail || $patientphone) && $patientadd && $patientcity && $patientstate && $patientzip && $patientdob && $patientgender) {
                $complete_info = 1;
        }
        // Determine Whether Patient Info has been set
        update_patient_summary($pid, 'patient_info', $complete_info);

				$copyreqdate = date('m/d/Y');
			
			if($copyreqdate!=''){
			   mysqli_query($con, "INSERT INTO dental_flow_pg1 (`pid`,`copyreqdate`) VALUES ('".$pid."', '".$copyreqdate."')");
      				$stepid = '1';
      				$segmentid = '1';
      				$scheduled = date('Y-m-d', strtotime($copyreqdate));
      				$gen_date = date('Y-m-d H:i:s');
      				$steparray_query = "INSERT INTO dental_flow_pg2 (`patientid`, `steparray`) VALUES ('".$pid."', '".$segmentid."');";
      				$flow_pg2_info_query = "INSERT INTO dental_flow_pg2_info (`patientid`, `stepid`, `segmentid`, `date_scheduled`, `date_completed`) VALUES ('".$pid."', '".$stepid."', '".$segmentid."', '".$scheduled."', '".$scheduled."');";
      				$steparray_insert = mysqli_query($con, $steparray_query);
      				$flow_pg2_info_insert = mysqli_query($con, $flow_pg2_info_query);

				if($last_visit != ''){
					$visit_date = date('Y-m-d', strtotime($last_visit));
					$steparray_query = "UPDATE dental_flow_pg2 SET steparray = '1,2' WHERE patientid='".$pid."'";
					$flow_pg2_info_query = "INSERT INTO dental_flow_pg2_info (`patientid`, `stepid`, `segmentid`, `date_scheduled`, `date_completed`) VALUES ('".$pid."', '2', '2', '".$visit_date."', '".$visit_date."');";
                                	$steparray_insert = mysqli_query($con, $steparray_query);
                                	$flow_pg2_info_insert = mysqli_query($con, $flow_pg2_info_query);
				}
				//echo $steparray_query;
				//echo $flow_pg2_info_query;
			}
                //$csv[$row]['lastname'] = $data[0];
                //$csv[$row]['firstname'] = $data[1];

                // inc the row
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
			window.location = "pending_patient.php?msg=<?= $msg; ?>";
		</script>
		<?php
}
}else{
?> 
<span class="admin_head">
  Patient Upload
</span>

<br /><br />
<form action="<?= $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data" method="post">

<input type="file" name="csv" />
<br />
<br />
<input type="submit" name="uploadbut" value="Upload" />
</form>
</div>
<?php } ?>
<br /><br />
<? include "includes/bottom.htm";?>

