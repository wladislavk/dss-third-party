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
            $fields[] = ""; //status
            $fields[] = "gender"; //gender
            $fields[] = "marital_status"; 
            $fields[] = ""; //responsible party status
            $fields[] = "dob";


            while(($data = fgetcsv($handle, 1000, ',')) !== FALSE) {
                // number of fields in the csv
                $num = count($data);
                // get the values from the csv
		if($row != 0){
			$s = "INSERT INTO dental_patients SET ";
		foreach($fields AS $id => $field){
		  switch($field){
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
				$d = date('m/d/Y', strtotime($data[$id]));
				$s .= $field . " = '" .$d."', ";	
				break;
			default:
				if($field!=''){
		  			$s .= $field . " = '" .$data[$id]."', ";
				}
				break;
		   }
		}
			$s .= " status = '2', ";
			$s .= " docid = '".$_SESSION[docid]."'";
			//echo $s;
			mysql_query($s);
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

