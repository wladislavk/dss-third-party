<?php
include "includes/top.htm";
require_once('includes/constants.inc');
require_once('includes/formatters.php');

if(isset($_POST['submitbut'])){
$csv = array();

// check there are no errors
if($_FILES['csv']['error'] == 0){
    $name = $_FILES['csv']['name'];
    $ext = strtolower(end(explode('.', $_FILES['csv']['name'])));
    $type = $_FILES['csv']['type'];
    $tmpName = $_FILES['csv']['tmp_name'];

    // check the file is a csv
    if($ext === 'csv'){
        if(($handle = fopen($tmpName, 'r')) !== FALSE) {
            // necessary if a large csv file
            set_time_limit(0);

            $row = 0;

	    $fields = array();
	    $fields[] = "lastname";
	    $fields[] = "firstname";
	    $fields[] = "add1";
            $fields[] = "city";
            $fields[] = "state";
            $fields[] = "home_phone";
            $fields[] = "work_phone";
            $fields[] = "zip";
            $fields[] = ""; //firstname
            $fields[] = ""; //lastname
            $fields[] = ""; //patientid
            $fields[] = ""; //responsible party
            $fields[] = "";
            $fields[] = "";
            $fields[] = "status";
            $fields[] = "gender"; //gender
            $fields[] = "marital_status"; 
            $fields[] = ""; //responsible party status
            $fields[] = "dob";
	    $fields[] = "";
            $fields[] = "";
            $fields[] = "";
            $fields[] = "copyreqdate";//first visit
            $fields[] = "";
            $fields[] = "";
            $fields[] = "";
            $fields[] = "";//next appointment
            $fields[] = "";
            $fields[] = "";
            $fields[] = "";
            $fields[] = "add2";
            $fields[] = "";
            $fields[] = "";
            $fields[] = "";
            $fields[] = "";
            $fields[] = "";
            $fields[] = "";
            $fields[] = "email";
            $fields[] = "";
            $fields[] = "";
            $fields[] = "middlename";

            while(($data = fgetcsv($handle, 1000, ',')) !== FALSE) {
                // number of fields in the csv
                $num = count($data);
                // get the values from the csv
		if($row != 0){
			$copyreqdate = '';
			$s = "INSERT INTO dental_patients SET ";
		foreach($fields AS $id => $field){
		  switch($field){
                        case 'status':
                                if($data[$id]=="A"){
                                        $s .= $field . " = '3', ";
                                }elseif($data[$id]=="I"){
                                        $s .= $field . " = '4', ";
                                }
                                break;
			case 'gender':
                                if($data[$id]=="F"){
                                        $s .= $field . " = 'Female', ";
                                }elseif($data[$id]=="M"){
                                        $s .= $field . " = 'Male', ";
                                }
				break;
			case 'marital_status':
				if(trim($data[$id])=="M"){
					$s .= $field . " = 'Married', ";
				}elseif(trim($data[$id])=="U"){
					$s .= $field . " = 'Single', ";
                                }
				break;
			case 'dob':
				if($data[$id]!=''){
				  $d = date('m/d/Y', strtotime($data[$id]));
				  $s .= $field . " = '" .$d."', ";	
				}
				break;
			case 'copyreqdate':
				if($field!=''){
				  $copyreqdate = $data[$id];
                                  $s .= $field . " = '" .$data[$id]."', ";
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
			mysql_query($s);
			$pid = mysql_insert_id();
			if($copyreqdate!=''){
			   mysql_query("INSERT INTO dental_flow_pg1 (`pid`,`copyreqdate`) VALUES ('".$pid."', '".$copyreqdate."')");
      				$stepid = '1';
      				$segmentid = '1';
      				$scheduled = date('Y-m-d', strtotime($copyreqdate));
      				$gen_date = date('Y-m-d H:i:s');
      				$steparray_query = "INSERT INTO dental_flow_pg2 (`patientid`, `steparray`) VALUES ('".$pid."', '".$segmentid."');";
      				$flow_pg2_info_query = "INSERT INTO dental_flow_pg2_info (`patientid`, `stepid`, `segmentid`, `date_scheduled`, `date_completed`) VALUES ('".$pid."', '".$stepid."', '".$segmentid."', '".$scheduled."', '".$scheduled."');";
      				$steparray_insert = mysql_query($steparray_query);
      				$flow_pg2_info_insert = mysql_query($flow_pg2_info_query);
				echo $steparray_query;
				echo $flow_pg2_info_query;
			}
		}
                //$csv[$row]['lastname'] = $data[0];
                //$csv[$row]['firstname'] = $data[1];

                // inc the row
                $row++;
            }
            fclose($handle);
		echo "Inserted ".($row-1)." rows.";
        }
    }
}

}
?> 

<form action="<?= $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data" method="post">

<input type="file" name="csv" />
<br />
<br />
<input type="submit" name="submitbut" value="Upload" />
</form>

<br /><br />
<? include "includes/bottom.htm";?>

