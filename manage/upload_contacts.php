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
function getContactTypeList () {
    $db = new Db();
    $list = array();
    $types = $db->getResults('SELECT contacttypeid, contacttype FROM dental_contacttype');

    foreach ($types as $type) {
        $list[$type['contacttype']] = $type['contacttypeid'];
    }

    return $list;
}
/**
 * Encapsulate logic to read csv and insert contacts.
 * Each insertion is a batch, to reduce DB load.
 *
 * @param string $filename
 * @param int    $docId
 * @param bool   $ignoreExtension
 * @return array
 */
function insertContactList ($filename, $docId, $ignoreExtension=false) {
    $return = [
        'total' => 0,
        'inserted' => 0,
        'excluded' => 0,
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

    $db = new Db();
    $docId = intval($docId);

    $count = 0;
    $batchSize = 50;
    $fields = [];

    do {
        $batch = [];

        do {
            $row = fgetcsv($handle, 10000, ',');

            if (!$row) {
                break;
            }

            $count++;

            if ($count === 1) {
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
                ];

                foreach ($row as $index=>$column) {
                    $column = strtolower(trim($column));

                    /**
                     * If already stored, or if not a string, skip
                     */
                    if (in_array($column, $fields) || is_numeric($column) || !is_string($column)) {
                        continue;
                    }

                    /**
                     * Save the position of the column, to retrieve the proper data field
                     */
                    if (array_key_exists($column, $allowedFields)) {
                        $fields[$index] = $column;
                        continue;
                    }

                    if (in_array($column, $allowedFields)) {
                        $found = array_search($column, $allowedFields);
                        $fields[$index] = is_numeric($found) ? $column : $found;
                        continue;
                    }
                }

                /**
                 * No fields = no valid csv
                 */
                if (!count($fields)) {
                    $return['errors'][] = count($row) ? 'The header is invalid.' : 'The CSV file contains no header.';
                    return $return;
                }

                foreach (['notes', 'docid', 'ip_address'] as $each) {
                    if (!in_array($each, $fields)) {
                        $fields[] = $each;
                    }
                }

                continue;
            }

            $data = [];

            foreach ($fields as $index=>$column) {
                switch ($column) {
                    case 'notes':
                        $data[$column] = '';
                        break;
                    case 'docid':
                        $data[$column] = $docId;
                        break;
                    case 'ip_address':
                        $data[$column] = $_SERVER['REMOTE_ADDR'];
                        break;
                    default:
                        $data[$column] = trim($row[$index]);
                }
            }

            /**
             * Exclude rows that have no names
             */
            if (empty($data['firstname']) && empty($data['lastname'])) {
                $return['excluded']++;
                continue;
            }

            $batch[] = $data;

            if (count($batch) >= $batchSize) {
                break;
            }
        } while ($row);

        if (!$batch) {
            break;
        }

        array_walk($batch, function (&$each) use ($db) {
            $each = $db->escapeList($each);
        });

        $insert = [
            'columns' => '(' . join(', ', $fields) . ', adddate)',
            'values' => '(' . join($batch, ", NOW()), (") . ', NOW())',
        ];

        $return['inserted'] += $db->getAffectedRows("INSERT INTO dental_contact
            {$insert['columns']} VALUES {$insert['values']}");
    } while ($row);

    fclose($handle);
    $return['total'] = $count;

    return $return;
}

if (isset($_POST['submitbut'])) {
    // check there are no errors
    if ($_FILES['csv']['error'] == 0) {
        if (strtolower(substr($_FILES['csv']['name'], -4)) === '.csv') {
            $details = insertContactList($_FILES['csv']['tmp_name'], $_SESSION['docid'], true);
            $errors = $details['errors'];
        } else {
            $errors = ['The file extension is not CSV.'];
        }
    } else {
        $errors = ['There was a problem uploading the file.'];
    }

    $message = '';

    if (!empty($details)) {
        $message = ($details['inserted'] ?: 'No') . ' contacts saved.' .
            ($details['excluded'] ? " {$details['excluded']} rows (excluded) missing both first name and last name." : '');

        if (!$details['total']) {
            $errors[] = 'The file was empty.';
        }
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
