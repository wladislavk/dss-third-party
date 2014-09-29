<?php
include "includes/top.htm";
require_once('includes/constants.inc');
require_once('includes/formatters.php');
require_once('includes/checkemail.php');
require_once('includes/general_functions.php');
?>
<div style="width:90%; margin-left:5%;">
<?php
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

                $error_count = 0;
                $error_array = array();
                while(($data = fgetcsv($handle, 1000, ',')) !== FALSE) {
                    // number of fields in the csv
                    $num = count($data);
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
                                case 'companyname':
                                    $fields[] = 'company';       
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
                                case 'active':
                                	if(!in_array('status', $fields)){
                                        $fields[] = 'status';       
                                	}else{
                                        $fields[] = '';
                                	}
                                    break;
                                case 'phone':
                                    $fields[] = 'phone1';       
                                    break;
                                case 'phone2':
                                    $fields[] = 'phone2';       
                                    break;
                                case 'fax':
                                    $fields[] = 'fax';       
                                    break;
                                case 'email':
                                    $fields[] = 'email';       
                                    break;
                                case 'npi':
                                    $fields[] = 'national_provider_id';       
                                    break;
                                case 'otherid':
                                    $fields[] = 'qualifierid';       
                                    break;
                                case 'otheridqual':
                                    $fields[] = 'qualifier';       
                                    break;
                                case 'notes':
                                    $fields[] = 'notes';       
                                    break;
                                case 'contacttype':
                                    $fields[] = 'contacttypeid';       
                                    break;
                                case 'specialty':
                                    $fields[] = 'specialty';       
                                    break;
                                default:
                                	$fields[] = '';
                                	break;
                            }
                        }
             			$row++;
            		}else{
            			$notes = '';
            			$s = "INSERT INTO dental_contact SET ";
                		foreach($fields AS $id => $field){
                            switch($field){
                                case 'qualifierid':
                                	if(trim($data[$id])!=''){
                                	  $notes .= "OtherID - ".$data[$id]." ";
                                	}
                                	break;
                                case 'qualifier':
                                    if(trim($data[$id])!=''){
                                      $notes .= "OtherIDQualifier - ".$data[$id]." ";
                                    }
                                    break;
                                case 'specialty':
                                    if(trim($data[$id])!=''){
                                      $notes .= "Specialty - ".$data[$id]." ";
                                    }
                                    break;
                                case 'notes':
                                      $notes .= $data[$id]." ";
                                    break;
                                case 'status':
                                	if(strtolower(trim($data[$id])) == 'true'){
                                        $s .= $field . " = '3', ";
                                	}else{
                                        $s .= $field . " = '4', ";
                                	}
                                	break;
                                case 'phone1':
                                case 'phone2':
                                case 'fax':
                                	if($field!=''){
                                        $s .= $field . " = '" .num($data[$id])."', ";
                                		if($field=='fax'){
                                            $s .= " preferredcontact = 'fax', ";
                                		}
                                    }
                                	break;
                                case 'contacttypeid':
                                	switch(strtolower($data[$id])){
                                		case 'insurance':
                                			$c = "Insurance";
                                			break;
                                        case 'ent':
                                            $c = "ENT Physician";
                                            break;
                                        case 'dental physician':
                                		case 'orthodontist':
                                            $c = "Dentist";
                                            break;
                                        case 'primary care physician':
                                            $c = "Primary Care Physician";
                                            break;
                                        case 'sleep disorder specialist':
                                            $c = "Sleep Physician";
                                            break;
                                		case 'pulmonologist':
                                			$c = "Pulmonologist";
                                			break;
                                		default:
                                			$c = "Other Physician";
                                			break;
                                	}
                                	$cts = "SELECT contacttypeid FROM dental_contacttype WHERE contacttype='".mysql_real_escape_string($c)."'";
                                	$ctr = $db->getRow($ctq);
                                	if($ctr['contacttypeid']!=''){
                                		$s .= $field . " = '" .$ctr['contacttypeid']."', ";
                                	}
                                	break;
                                default:
                                	if($field!=''){
                                			$s .= $field . " = '" .$data[$id]."', ";
                                	}
                                	break;
                            }
                		}
                		$s .= " notes='".mysql_real_escape_string($notes)."', ";
                		$s .= " docid='".mysql_real_escape_string($_SESSION['docid'])."'";
                		//echo $s."<br />";
                		$cid = $db->getInsertId($s);
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
        			window.location = "pending_contacts.php?msg=<?php echo $msg; ?>";
        		</script>
        		<?php
            }
        }else{ ?>
            <h3>Unrecognized file type. Please upload a CSV file only.</h3>
        <?php }
    }
}
?> 

<form action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data" method="post">

<input type="file" name="csv" />
<br />
<br />
<input type="submit" name="submitbut" value="Upload" />
</form>
</div>
<br /><br />
<?php include "includes/bottom.htm";?>

