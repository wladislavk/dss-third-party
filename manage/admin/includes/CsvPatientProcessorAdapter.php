<?php
namespace Ds3\Libraries\Legacy;

require_once __DIR__ . '/CsvProcessorAdapterInterface.php';

class CsvPatientProcessorAdapter implements CsvProcessorAdapterInterface
{
    /** @var Db */
    private $db;
    
    public function __construct(Db $db)
    {
        $this->db = $db;
    }

    public function getHeaders()
    {
        return $this->getPatientListHeader();
    }

    public function getSpecialHeaders()
    {
        return [];
    }

    public function headerNeedsIndexing()
    {
        return false;
    }

    public function processRow(array $row, array $headerFields, $docId, $ipAddress)
    {
        return $this->processPatientFields($row, $headerFields, $docId, $ipAddress);
    }

    public function storeRows(array $headerFields, array $dataBatch)
    {
        return $this->storePatientFields($headerFields, $dataBatch);
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
    public function translatePatientFields(array &$destination, $column, $value, $docId, $ipAddress)
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
    public function getPatientListHeader()
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
    public function processPatientFields(array $row, array $headerFields, $docId, $ipAddress)
    {
        $data = [];

        foreach ($headerFields as $index => $column) {
            $this->translatePatientFields($data, $column, $row[$index], $docId, $ipAddress);
        }

        return $data;
    }

    /**
     * @param array $dataBatch
     * @return array
     */
    public function parseDentalFlowDates(array $dataBatch)
    {
        $merged = array_map(function ($each) {
            return array_only($each, ['copyreqdate', 'last_visit', 'referred_notes']);
        }, $dataBatch);

        $uniqueIds = array_pluck($dataBatch, 'referred_notes');
        $allDates = array_combine($uniqueIds, $merged);

        return $allDates;
    }

    /**
     * Filter function to determine if any of the two first elements of the array are set
     *
     * @param array $each
     * @return bool
     */
    public function filterAnyFlowDate(array $each)
    {
        return !empty($each['copyreqdate']) || !empty($each['last_visit']);
    }

    /**
     * Filter function to determine if the second array element is set
     *
     * @param array $each
     * @return bool
     */
    public function filterLastVisitDate(array $each)
    {
        return !empty($each['last_visit']);
    }

    /**
     * Modify the array to keep any of the two first elements, or empty string if both are empty
     *
     * @param array $each
     */
    public function setAnyFlowDate(array &$each)
    {
        if (!empty($each['copyreqdate'])) {
            $each = $each['copyreqdate'];
            return;
        }

        if (!empty($each['last_visit'])) {
            $each = $each['last_visit'];
            return;
        }

        $each = '';
    }

    /**
     * Modify the array to keep the second element of the array, or empty string if empty
     *
     * @param array $each
     */
    public function setLastVisitDate(array &$each)
    {
        if (empty($each['copyreqdate'])) {
            $each = '';
            return;
        }

        $each = $each['copyreqdate'];
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
    public function selectDentalFlowDates(array $allDates, callable $filterDates, callable $transformDates)
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
    public function generateCaseWhenConditional(array $dentalFlowDates)
    {
        $conditionals = array_map(function ($date, $id) {
            $date = $this->db->escape($date);
            $id = $this->db->escape($id);

            return "WHEN '$id' = referred_notes THEN '$date'";
        }, $dentalFlowDates, array_keys($dentalFlowDates));

        $caseConditional = 'CASE ' . join("\n", $conditionals) . " ELSE '' END";
        return $caseConditional;
    }

    /**
     * Set all the dependencies for all the new patients
     *
     * @param array $allDates
     */
    public function processDentalFlowDates(array $allDates)
    {
        /**
         * Copy Req, or Last Visit
         */
        $dentalFlowDates = $this->selectDentalFlowDates(
            $allDates,
            [$this, 'filterAnyFlowDate'],
            [$this, 'setAnyFlowDate']
        );
        $caseConditional = $this->generateCaseWhenConditional($dentalFlowDates);
        $dentalFlowIds = $this->db->escapeList(array_keys($dentalFlowDates));

        $this->db->query("INSERT INTO dental_flow_pg1 (pid, copyreqdate)
            SELECT
                patientid,
                $caseConditional
            FROM dental_patients
            WHERE referred_notes IN ($dentalFlowIds)");

        $this->db->query("INSERT INTO dental_flow_pg2 (patientid, steparray)
            SELECT patientid, 1
            FROM dental_patients
            WHERE referred_notes IN ($dentalFlowIds)");

        $this->db->query("INSERT INTO dental_flow_pg2_info (
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
        $dentalFlowDates = $this->selectDentalFlowDates(
            $allDates,
            [$this, 'filterLastVisitDate'],
            [$this, 'setLastVisitDate']
        );
        $caseConditional = $this->generateCaseWhenConditional($dentalFlowDates);
        $dentalFlowIds = $this->db->escapeList(array_keys($dentalFlowDates));

        $this->db->query("UPDATE dental_flow_pg2 page2
            JOIN dental_patients patient ON patient.patientid = page2.patientid
            SET page2.steparray = '1,2'
            WHERE patient.referred_notes IN ($dentalFlowIds)");

        $this->db->query("INSERT INTO dental_flow_pg2_info (
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
    public function storePatientFields(array $headerFields, array $dataBatch)
    {
        /**
         * Use a batch id to signal all data from this batch, and combine it with a unique id per row.
         */
        $headerFields[] = 'referred_notes';
        $batchId = $this->db->escape(uniqid(true) . uniqid(true) . uniqid(true));

        array_walk($dataBatch, function (&$each) use ($batchId) {
            $each['referred_notes'] = $batchId . '-' . uniqid(true);
        });

        $allDates = $this->parseDentalFlowDates($dataBatch);

        /**
         * Remove last_visit from insertion, as it does not appear in the DB
         */
        $found = array_search('last_visit', $headerFields);

        if ($found !== false) {
            unset($headerFields[$found]);

            $dataBatch = array_map(function ($each) {
                unset($each['last_visit']);
                return $each;
            }, $dataBatch);
        }

        $headerFields = $this->db->escapeList($headerFields, true);
        $dataBatch = array_map([$this->db, 'escapeList'], $dataBatch);

        $insert = [
            'columns' => "($headerFields, adddate)",
            'values' => '(' . join(", NOW()),\n(", $dataBatch) . ", NOW())",
        ];

        $insertSql = "INSERT INTO dental_patients
            {$insert['columns']}
            VALUES
            {$insert['values']}";

        $inserted = $this->db->getAffectedRows($insertSql);
        $this->processDentalFlowDates($allDates);

        $sql = "UPDATE dental_patients
            SET referred_notes = ''
            WHERE referred_notes LIKE '$batchId-%'";
        $this->db->query($sql);

        return $inserted;
    }
}
