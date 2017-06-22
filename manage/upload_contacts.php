<?php
namespace Ds3\Libraries\Legacy;

require_once __DIR__ . '/includes/top.htm';
require_once __DIR__ . '/includes/constants.inc';
require_once __DIR__ . '/includes/formatters.php';
require_once __DIR__ . '/includes/checkemail.php';
require_once __DIR__ . '/includes/general_functions.php';

/**
 * @return array
 */
function getContactTypeList()
{
    $db = new Db();
    $list = array();
    $types = $db->getResults('SELECT contacttypeid, contacttype FROM dental_contacttype');

    foreach ($types as $type) {
        $list[$type['contacttype']] = $type['contacttypeid'];
    }

    return $list;
}

/**
 * Return a map of contact fields, from csv to DB.
 *
 * @param array $firstRow
 * @return array|bool
 */
function getContactListHeader(array $firstRow)
{
    $allowedFields = [
        'lastname',
        'firstname',
        'middlename' => 'middleinit',
        'salutation' => 'title',
        'company' => 'companyname',
        'add1' => 'address1',
        'add2' => 'address2',
        'city',
        'state',
        'zip' => 'postalcode',
        'status',
        'phone1' => 'phone',
        'phone2',
        'fax',
        'email',
        'national_provider_id' => 'npi',
        'qualifierid' => 'otherid',
        'qualifier' => 'otheridqual',
        'notes',
        'contacttypeid' => 'contacttype',
        'specialty',
        'status' => 'active',
    ];
    $specialFields = [
        'preferredcontact',
        'notes',
        'docid',
        'ip_address'
    ];

    return processCsvHeader($firstRow, $allowedFields, $specialFields);
}

/**
 * Map CSV fields into internal representation, remove/ignore not defined fields
 *
 * @param array  $destination
 * @param string $column
 * @param string $value
 * @param int    $docId
 * @param string $ipAddress
 */
function translateContactFields(array &$destination, $column, $value, $docId, $ipAddress)
{
    $value = trim($value);

    if ($column === 'status') {
        if ($value === 'true' || $value === '3' ) {
            $destination[$column] = 3;
            return;
        }

        $destination[$column] = 4;
        return;
    }

    if ($column === 'docid') {
        $destination[$column] = $docId;
        return;
    }

    if ($column === 'ip_address') {
        $destination[$column] = $ipAddress;
        return;
    }

    if ($column === 'contacttypeid') {
        $contactTypeList = getContactTypeList();
        $translationList = [
            'insurance' => 'Insurance',
            'ent' => 'ENT Physician',
            'dental physician' => 'Dentist',
            'orthodontist' => 'Dentist',
            'primary care physician' => 'Primary Care Physician',
            'sleep disorder specialist' => 'Sleep Physician',
            'pulmonologist' => 'Pulmonologist',
        ];

        $type = 'Other Physician';

        if (array_key_exists($value, $translationList)) {
            $type = $translationList[$value];
        }

        if (isset($contactTypeList[$type])) {
            $destination[$column] = (int)$contactTypeList[$type];
        }

        $destination[$column] = '';
        return;
    }

    $destination[$column] = $value;
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
function processContactFields(array $row, array $headerFields, $docId, $ipAddress)
{
    $data = [];

    foreach ($headerFields as $index => $column) {
        translateContactFields($data, $column, $row[$index], $docId, $ipAddress);
    }

    /**
     * Preferred method of contact
     */
    if (in_array('preferredcontact', $headerFields) && !empty($data['fax'])) {
        $data['preferredcontact'] = 'fax';
    }

    /**
     * Process notes
     */
    if (!in_array('notes', $headerFields)) {
        unset($data['specialty']);
        return $data;
    }

    $notes = [];
    $noteSections = [
        'qualifierid' => 'OtherID - $1',
        'qualifier' => 'OtherIDQualifier - $1',
        'specialty' => 'Specialty - $1',
        'notes' => '$1'
    ];

    array_walk($noteSections, function ($subject, $column) use (&$notes, $data) {
        if (!isset($data[$column]) || !strlen($data[$column])) {
            return;
        }

        $notes[] = str_replace('$1', $data[$column], $subject);
    });

    $data['notes'] = join(' ', $notes);
    unset($data['specialty']);
    return $data;
}

/**
 * Save contact data into the DB
 *
 * @param array $headerFields
 * @param array $dataBatch
 * @return bool|int
 */
function storeContactFields(array $headerFields, array $dataBatch)
{
    $db = new Db();

    $headerFields = $db->escapeList($headerFields, true);
    $dataBatch = array_map([$db, 'escapeList'], $dataBatch);

    $insert = [
        'columns' => "($headerFields, adddate)",
        'values' => '(' . join(", NOW()),\n(", $dataBatch) . ', NOW())',
    ];

    $insertSql = "INSERT INTO dental_contact
        {$insert['columns']}
        VALUES
        {$insert['values']}";

    $inserted = $db->getAffectedRows($insertSql);
    return $inserted;
}


if (isset($_POST['submitbut'])) {
    // check there are no errors
    if ($_FILES['csv']['error'] == 0) {
        if (strtolower(substr($_FILES['csv']['name'], -4)) === '.csv') {
            $details = saveCsvContents(
                $_FILES['csv']['tmp_name'],
                __NAMESPACE__ . '\\getContactListHeader',
                function () {
                    $arguments = func_get_args();
                    $arguments[] = (int)$_SESSION['docid'];
                    $arguments[] = $_SERVER['REMOTE_ADDR'];
                    return call_user_func_array(__NAMESPACE__ . '\\processContactFields', $arguments);
                },
                __NAMESPACE__ . '\\storeContactFields',
                true
            );
            $errors = $details['errors'];
        } else {
            $errors = ['The file extension is not CSV.'];
        }
    } else {
        $errors = ['There was a problem uploading the file.'];
    }

    $message = '';

    if (!empty($details)) {
        $message = ($details['inserted'] ?: 'No') . ' contacts saved.';
    }

    if ($errors) {
        $message .= ' Errors: ' . join(' ', $errors);
    }

    ?>
    <script type="text/javascript">
        window.location = "pending_contacts.php?msg=<?= urlencode($message) ?>";
    </script>
    <?php
}
?>
<div style="width:90%; margin-left:5%;">
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data" method="post">
        <input type="file" name="csv" />
        <br /><br />
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
