<?php
namespace Ds3\Libraries\Legacy;

set_time_limit(0);

require_once __DIR__ . '/includes/top.htm';
require_once __DIR__ . '/includes/constants.inc';
require_once __DIR__ . '/includes/formatters.php';
require_once __DIR__ . '/includes/checkemail.php';
require_once __DIR__ . '/includes/general_functions.php';

/**
 * Map CSV fields into internal representation, remove/ignore not defined fields
 *
 * @param array  $destination
 * @param string $column
 * @param string $value
 * @param int    $docId
 * @param string $ipAddress
 */
function translatePatientFields(array &$destination, $column, $value, $docId, $ipAddress)
{
    $value = trim($value);

    if ($column === 'status') {
        if ($value === 'A') {
            $destination[$column] = 3;
            return;
        }

        $destination[$column] = 4;
        return;
    }

    if ($column === 'gender') {
        if ($value === 'F') {
            $destination[$column] = 'Female';
            return;
        }

        if ($value === 'M') {
            $destination[$column] = 'Male';
            return;
        }

        $destination[$column] = '';
        return;
    }

    if ($column === 'marital_status') {
        if ($value === 'M') {
            $destination[$column] = 'Married';
            return;
        }

        if ($value === 'U') {
            $destination[$column] = 'Single';
            return;
        }

        $destination[$column] = '';
        return;
    }

    if (in_array($column, ['dob', 'copyreqdate', 'last_visit'])) {
        if (!strlen($value)) {
            $destination[$column] = '';
            return;
        }

        $timestamp = strtotime($value);

        if (!$timestamp) {
            $timestamp = str_replace('/', '-', $value);
            $timestamp = strtotime($timestamp);
        }

        if ($timestamp) {
            $destination[$column] = date('m/d/Y', $timestamp);
            return;
        }

        $destination[$column] = $value;
    }

    if (in_array($column, ['work_phone', 'home_phone'])) {
        $destination[$column] = num($value);
    }

    if ($column === 'email') {
        if (checkEmail($value, 0) > 0) {
            $destination[$column] = '';
            return;
        }
    }

    if ($column === 'docid') {
        $destination[$column] = $docId;
        return;
    }

    if ($column === 'ip_address') {
        $destination[$column] = $ipAddress;
        return;
    }

    $destination[$column] = $value;
}

/**
 * Return a map of patient fields, from csv to DB.
 *
 * @return array|bool
 */
function getPatientListHeader()
{
    $headerFields = [
        0 => 'lastname',
        1 => 'firstname',
        2 => 'add1',
        3 => 'city',
        4 => 'state',
        5 => 'home_phone',
        6 => 'work_phone',
        7 => 'zip',
        14 => 'status',
        15 => 'gender',
        16 => 'marital_status',
        18 => 'dob',
        22 => 'copyreqdate',
        23 => 'last_visit',
        30 => 'add2',
        37 => 'email',
        40 => 'middlename',
        -1 => 'docid',
        -2 => 'ip_address',
    ];
    
    return $headerFields;
}

/**
 * Translate CSV fields into internal representation, merge or remove special fields
 *
 * @param array  $row
 * @param array  $headerFields
 * @param int    $docId
 * @param string $ipAddress
 * @return array
 */
function processPatientFields(array $row, array $headerFields, $docId, $ipAddress)
{
    $data = [];

    foreach ($headerFields as $index => $column) {
        translatePatientFields($data, $column, $row[$index], $docId, $ipAddress);
    }

    return $data;
}

/**
 * @param array $dataBatch
 * @return array
 */
function parseDentalFlowDates(array &$dataBatch)
{
    /**
     * array_pull: REMOVE that index from the nested arrays, "last_visit" is not a column in patients table
     */
    $copyReqDates = array_pluck($dataBatch, 'copyreqdate');
    $lastVisitDates = array_pull($dataBatch, 'last_visit');
    $uniqueIds = array_pluck($dataBatch, 'referred_notes');

    $allDates = array_combine($uniqueIds, array_merge_recursive($copyReqDates, $lastVisitDates, $uniqueIds));
    return $allDates;
}

/**
 * Filter function to determine if any of the two first elements of the array are set
 *
 * @param array $each
 * @return bool
 */
function filterAnyFlowDate(array $each)
{
    return !empty($each[0]) || !empty($each[1]);
}

/**
 * Filter function to determine if the second array element is set
 *
 * @param array $each
 * @return bool
 */
function filterLastVisitDate(array $each)
{
    return !empty($each[1]);
}

/**
 * Modify the array to keep any of the two first elements, or empty string if both are empty
 *
 * @param array $each
 */
function setAnyFlowDate(array &$each)
{
    if (!empty($each[0])) {
        $each = $each[0];
        return;
    }

    if (!empty($each[1])) {
        $each = $each[1];
        return;
    }

    $each = '';
}

/**
 * Modify the array to keep the second element of the array, or empty string if empty
 *
 * @param array $each
 */
function setLastVisitDate(array &$each)
{
    if (empty($each[0])) {
        $each = '';
        return;
    }

    $each = $each[0];
    $timestamp = strtotime($each);

    if (!$timestamp) {
        return;
    }

    $each = date('Y-m-d', $timestamp);
}

/**
 * Filter and process $allDates by applying the callbacks
 *
 * @param array    $allDates
 * @param callable $filterDates
 * @param callable $transformDates
 * @return array
 */
function selectDentalFlowDates(array $allDates, callable $filterDates, callable $transformDates)
{
    $dentalFlowDates = array_filter($allDates, $filterDates);
    array_walk($dentalFlowDates, $transformDates);

    return $dentalFlowDates;
}

/**
 * Generate SQL CASE WHEN...ELSE string, with escaped values
 *
 * @param array $dentalFlowDates
 * @return string
 */
function generateCaseWhenConditional(array $dentalFlowDates)
{
    $db = new Db();

    $conditionals = array_map(function ($date, $id) use ($db) {
        $date = $db->escape($date);
        $id = $db->escape($id);

        return "WHEN '$id' = referred_notes THEN '$date'";
    }, $dentalFlowDates, array_keys($dentalFlowDates));

    $caseConditional = 'CASE ' . join("\n", $conditionals) . " ELSE ''";
    return $caseConditional;
}

/**
 * Set all the dependencies for all the new patients
 *
 * @param array $allDates
 */
function processDentalFlowDates(array $allDates)
{
    $db = new Db();

    /**
     * Copy Req, or Last Visit
     */
    $dentalFlowDates = selectDentalFlowDates(
        $allDates, __NAMESPACE__ . '\\filterAnyFlowDate', __NAMESPACE__ . '\\setAnyFlowDate'
    );
    $caseConditional = generateCaseWhenConditional($dentalFlowDates);
    $dentalFlowIds = $db->escapeList(array_keys($dentalFlowDates));

    $db->query("INSERT INTO dental_flow_pg1 (pid, copyreqdate)
        SELECT
            patientid,
            $caseConditional
        FROM dental_patients
        WHERE referred_notes IN ($dentalFlowIds)");

    $db->query("INSERT INTO dental_flow_pg2 (patientid, steparray)
        SELECT patientid, 1
        FROM dental_patients
        WHERE referred_notes IN ($dentalFlowIds)");

    $db->query("INSERT INTO dental_flow_pg2_info (
            patientid,
            stepid,
            segmentid,
            date_scheduled,
            date_completed
        )
        SELECT
            patientid,
            1,
            1,
            DATE_FORMAT(STR_TO_DATE(copyreqdate, '%d/%m/%Y'), '%Y-%m-%d'),
            DATE_FORMAT(STR_TO_DATE(copyreqdate, '%d/%m/%Y'), '%Y-%m-%d')
        FROM dental_patients
        WHERE referred_notes IN ($dentalFlowIds)");
    /**
     * Copy Req, or Last Visit
     */

    /**
     * Last Visit only
     */
    $dentalFlowDates = selectDentalFlowDates(
        $allDates, __NAMESPACE__ . '\\filterLastVisitDate', __NAMESPACE__ . '\\setLastVisitDate'
    );
    $caseConditional = generateCaseWhenConditional($dentalFlowDates);
    $dentalFlowIds = $db->escapeList(array_keys($dentalFlowDates));

    $db->query("UPDATE dental_flow_pg2 page2
        JOIN dental_patients patient ON patient.patientid = page2.patientid
        SET page2.steparray = '1,2'
        WHERE patient.referred_notes IN ($dentalFlowIds)");

    $db->query("INSERT INTO dental_flow_pg2_info (
            patientid,
            stepid,
            segmentid,
            date_scheduled,
            date_completed
        )
        SELECT
            patientid,
            2,
            2,
            $caseConditional,
            $caseConditional
        FROM dental_patients
        WHERE referred_notes IN ($dentalFlowIds)");
    /**
     * Last Visit only
     */
}

/**
 * Save contact data into the DB
 *
 * @param array $headerFields
 * @param array $dataBatch
 * @return bool|int
 */
function storePatientFields(array $headerFields, array $dataBatch)
{
    $db = new Db();

    /**
     * Use a batch id to signal all data from this batch, and combine it with a unique id per row.
     */
    $batchId = $db->escape(uniqid() . uniqid() . uniqid());

    $headerFields[] = 'referred_notes';
    $headerFields = $db->escapeList($headerFields, true);

    array_walk($dataBatch, function (&$each) use ($batchId) {
        $each[] = $batchId . '-' . uniqid();
    });

    $allDates = parseDentalFlowDates($dataBatch);
    $dataBatch = array_map([$db, 'escapeList'], $dataBatch);

    $insert = [
        'columns' => "($headerFields, adddate)",
        'values' => '(' . join(", NOW()),\n(", $dataBatch) . ", NOW())",
    ];

    $insertSql = "INSERT INTO dental_patients
        {$insert['columns']}
        VALUES
        {$insert['values']}";

    $inserted = $db->getAffectedRows($insertSql);
    processDentalFlowDates($allDates);

    /**
     * @todo Remove unique IDs
     */

    return $inserted;
}

?>
<div style="width:90%; margin-left:5%;">
<?php
if(isset($_POST['submitbut'])){
    $csv = array();

    // check there are no errors
    if($_FILES['csv']['error'] == 0){
        $name = $_FILES['csv']['name'];
        $ext = strtolower(preg_replace('/^.*[.]([^.]+)$/', '$1', ($_FILES['csv']['name'])));
        $type = $_FILES['csv']['type'];
        $tmpName = $_FILES['csv']['tmp_name'];

        // check the file is a csv
        if($ext === 'csv'){
            if(($handle = fopen($tmpName, 'r')) !== FALSE) {
                // necessary if a large csv file
                set_time_limit(0);

                $row = 0;

                if (1) {
                    $fields = [];
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
                    $fields[] = "last_visit";
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
                }
                $error_count = 0;
        		$error_array = array();
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
                                    }else{
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
                                        $timestamp = strtotime($data[$id]);

                                        if (!$timestamp) {
                                            $timestamp = str_replace('/', '-', $data[$id]);
                                            $timestamp = strtotime($timestamp);
                                        }

                                        $d = $timestamp ? date('m/d/Y', $timestamp) : $data[$id];
                                        $s .= $field . " = '" .$d."', ";
                                    }
                                    break;
                                case 'copyreqdate':
                                    if($field!=''){
                                        $copyreqdate = $data[$id];
                                        $s .= $field . " = '" .$data[$id]."', ";
                                    }
                                    break;
                                case 'last_visit':
                                    if($field!=''){
                                        $last_visit = $data[$id];
                                    }
                                    break;
                                case 'work_phone':
                                case 'home_phone':
                                    if($field!=''){
                                        $s .= $field . " = '" .num($data[$id])."', ";
                                    }
                                    break;
                                case 'email':
                                    if($field!=''){
                                        $email = $data[$id];
                                        if(checkEmail($email, 0)>0){
                                			array_push($error_array, $data[1]." ".$data[0]." - ".$email);
                                			$error_count++;
                                    	}else{
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
            			$s .= " docid = '".$_SESSION[docid]."', adddate = NOW(), ip_address = '".$db->escape($_SERVER['REMOTE_ADDR'])."'";
            			//echo $s;
            			$pid = $db->getInsertId($s);
            			if($copyreqdate=='' && $last_visit!=''){
            				$copyreqdate = $last_visit;
            			}elseif($copyreqdate==''){
            				$copyreqdate = date('m/d/Y');
            			}
            			if($copyreqdate!=''){
                            $db->query("INSERT INTO dental_flow_pg1 (`pid`,`copyreqdate`) VALUES ('".$pid."', '".$copyreqdate."')");
              				$stepid = '1';
              				$segmentid = '1';
              				$scheduled = date('Y-m-d', strtotime($copyreqdate));
              				$gen_date = date('Y-m-d H:i:s');
              				$steparray_query = "INSERT INTO dental_flow_pg2 (`patientid`, `steparray`) VALUES ('".$pid."', '".$segmentid."');";
              				$flow_pg2_info_query = "INSERT INTO dental_flow_pg2_info (`patientid`, `stepid`, `segmentid`, `date_scheduled`, `date_completed`) VALUES ('".$pid."', '".$stepid."', '".$segmentid."', '".$scheduled."', '".$scheduled."');";
              				$steparray_insert = $db->query($steparray_query);
              				$flow_pg2_info_insert = $db->query($flow_pg2_info_query);

            				if($last_visit != ''){
            					$visit_date = date('Y-m-d', strtotime($last_visit));
            					$steparray_query = "UPDATE dental_flow_pg2 SET steparray = '1,2' WHERE patientid='".$pid."'";
            					$flow_pg2_info_query = "INSERT INTO dental_flow_pg2_info (`patientid`, `stepid`, `segmentid`, `date_scheduled`, `date_completed`) VALUES ('".$pid."', '2', '2', '".$visit_date."', '".$visit_date."');";
                            	$steparray_insert = $db->query($steparray_query);
                            	$flow_pg2_info_insert = $db->query($flow_pg2_info_query);
            				}
            				//echo $steparray_query;
            				//echo $flow_pg2_info_query;
            			}
                    //$csv[$row]['lastname'] = $data[0];
                    //$csv[$row]['firstname'] = $data[1];

                    // inc the row
                   		$row++;
            		}else{
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

<form action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data" method="post">
    <input type="file" name="csv" />
    <br />
    <br />
    <input type="submit" name="submitbut" value="Upload" />
</form>
</div>
<br /><br />
<?php

require_once __DIR__ . '/includes/bottom.htm';

/**
 * Return an associative array with indexes, and labels, of valid CSV headers
 *
 * @param array $row
 * @param array $allowedFields
 * @param array $specialFields
 * @return array|bool
 */
function processCsvHeader(array $row, array $allowedFields, array $specialFields = [])
{
    $headerFields = [];

    array_walk($row, function ($column, $index) use (&$headerFields, $allowedFields) {
        $column = strtolower(trim($column));

        /**
         * If already stored, or if not a string, skip
         */
        if (in_array($column, $headerFields) || is_numeric($column) || !is_string($column)) {
            return;
        }

        /**
         * Save the position of the column, to retrieve the proper data field
         */
        if (array_key_exists($column, $allowedFields)) {
            $headerFields[$index] = $column;
            return;
        }

        if (!in_array($column, $allowedFields)) {
            return;
        }

        $found = array_search($column, $allowedFields);

        if (is_numeric($found)) {
            $headerFields[$index] = $column;
            return;
        }

        $headerFields[$index] = $found;
    });

    /**
     * No fields = no valid csv
     */
    if (!count($headerFields)) {
        return false;
    }

    /**
     * Signal special fields with negative indexes
     */
    foreach ($specialFields as $index=>$each) {
        if (!in_array($each, $headerFields)) {
            $headerFields[-1 - $index] = $each;
        }
    }

    return $headerFields;
}

/**
 * Return a row batch of max $batchSize
 *
 * @param resource $handle
 * @param int      $batchSize
 * @return array
 */
function getCsvRowBatch($handle, $batchSize = 20)
{
    $batch = [];

    for ($n = 0; $n < $batchSize; $n++) {
        $row = fgetcsv($handle, 10000, ',');

        if ($row === FALSE) {
            return $batch;
        }

        $batch[] = $row;
    }

    return $batch;
}

/**
 * Translate a batch of CSV rows, and insert them into the DB
 *
 * @param array    $rowBatch
 * @param array    $headerFields
 * @param callable $processFields
 * @param callable $storeFields
 * @return int
 */
function processCsvRowBatch(array $rowBatch, array $headerFields, callable $processFields, callable $storeFields)
{
    $dataBatch = array_map(function ($row) use ($headerFields, $processFields) {
        return $processFields($row, $headerFields);
    }, $rowBatch);

    if (!count($dataBatch)) {
        return 0;
    }

    $inserted = $storeFields($headerFields, $dataBatch);
    return $inserted;
}

/**
 * Encapsulate logic to read csv and insert data into the DB.
 *
 * @param string   $filename
 * @param callable $retrieveHeaderFields
 * @param callable $processField
 * @param callable $storeFields
 * @param bool     $ignoreExtension
 * @return array
 */
function saveCsvContents (
    $filename,
    callable $retrieveHeaderFields,
    callable $processField,
    callable $storeFields,
    $ignoreExtension=false
) {
    $return = [
        'inserted' => 0,
        'errors' => [],
    ];

    /**
     * Allow to ignore extension, in case the filename is a temporary file
     */
    if (!$ignoreExtension && strtolower(substr($filename, -4)) !== '.csv') {
        $return['errors'][] = 'The file extension is not CSV.';
        return $return;
    }

    $handle = fopen($filename, 'r');

    if ($handle === false) {
        $return['errors'][] = 'The file could not be read.';
        return $return;
    }

    set_time_limit(0);
    $batchSize = 20;

    $firstRow = fgetcsv($handle, 1000, ',');

    if ($firstRow === FALSE) {
        $return['errors'][] = 'The file is empty';
        return $return;
    }

    $headerFields = $retrieveHeaderFields($firstRow);

    do {
        $rowBatch = getCsvRowBatch($handle, $batchSize);

        if (count($rowBatch)) {
            $return['inserted'] += processCsvRowBatch($rowBatch, $headerFields, $processField, $storeFields);
        }
    } while (count($rowBatch));

    fclose($handle);
    return $return;
}
