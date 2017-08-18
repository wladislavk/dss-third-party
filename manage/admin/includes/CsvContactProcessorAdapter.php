<?php
namespace Ds3\Libraries\Legacy;

require_once __DIR__ . '/CsvProcessorAdapterInterface.php';

class CsvContactProcessorAdapter implements CsvProcessorAdapterInterface
{
    /** @var Db */
    private $db;

    public function __construct(Db $db)
    {
        $this->db = $db;
    }

    public function getHeaders()
    {
        return $this->getContactListHeader();
    }

    public function getSpecialHeaders()
    {
        return [
            'preferredcontact',
            'notes',
            'docid',
            'ip_address',
        ];
    }

    public function headerNeedsIndexing()
    {
        return true;
    }

    public function processRow(array $row, array $headerFields, $docId, $ipAddress)
    {
        return $this->processContactFields($row, $headerFields, $docId, $ipAddress);
    }

    public function storeRows(array $headerFields, array $dataBatch)
    {
        return $this->storeContactFields($headerFields, $dataBatch);
    }

    /**
     * @return array
     */
    public function getContactTypeList()
    {
        $list = array();
        $types = $this->db->getResults('SELECT contacttypeid, contacttype FROM dental_contacttype');

        foreach ($types as $type) {
            $list[$type['contacttype']] = $type['contacttypeid'];
        }

        return $list;
    }

    /**
     * Return a map of contact fields, from csv to DB.
     *
     * @return array|bool
     */
    public function getContactListHeader()
    {
        $headerFields = [
            'lastname',
            'firstname',
            'middlename' => 'MiddleInit',
            'salutation' => 'Title',
            'company' => 'CompanyName',
            'add1' => 'Address1',
            'add2' => 'Address2',
            'city',
            'state',
            'zip' => 'PostalCode',
            'phone1' => 'Phone',
            'phone2',
            'fax',
            'email',
            'national_provider_id' => 'NPI',
            'qualifierid' => 'OtherID',
            'qualifier' => 'OtherIDQual',
            'notes',
            'contacttypeid' => 'ContactType',
            'specialty',
            'status' => 'Active',
        ];

        return $headerFields;
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
    public function translateContactFields(array &$destination, $column, $value, $docId, $ipAddress)
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
            $contactTypeList = $this->getContactTypeList();
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
    public function processContactFields(array $row, array $headerFields, $docId, $ipAddress)
    {
        $data = [];

        foreach ($headerFields as $index => $column) {
            $this->translateContactFields($data, $column, $row[$index], $docId, $ipAddress);
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
    public function storeContactFields(array $headerFields, array $dataBatch)
    {
        $headerFields = $this->db->escapeList($headerFields, true);
        $dataBatch = array_map([$this->db, 'escapeList'], $dataBatch);

        $insert = [
            'columns' => "($headerFields, adddate)",
            'values' => '(' . join(", NOW()),\n(", $dataBatch) . ', NOW())',
        ];

        $insertSql = "INSERT INTO dental_contact
            {$insert['columns']}
            VALUES
            {$insert['values']}";

        $inserted = $this->db->getAffectedRows($insertSql);
        return $inserted;
    }
}
