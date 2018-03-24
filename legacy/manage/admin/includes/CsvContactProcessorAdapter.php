<?php
namespace Ds3\Libraries\Legacy;

require_once __DIR__ . '/CsvProcessorAdapterInterface.php';

class CsvContactProcessorAdapter implements CsvProcessorAdapterInterface
{
    const STATUS_PENDING_ACTIVE = 3;
    const STATUS_PENDING_INACTIVE = 4;

    /** @var Db */
    private $db;

    /** @var array */
    private $contactTypeList;

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
            'status',
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
        if ($this->contactTypeList) {
            return $this->contactTypeList;
        }

        $list = [];
        $types = $this->db->getResults('SELECT contacttypeid, contacttype FROM dental_contacttype');

        foreach ($types as $type) {
            $list[$type['contacttype']] = $type['contacttypeid'];
        }

        $this->contactTypeList = $list;
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
            'middlename' => 'middleinit',
            'salutation' => 'title',
            'company' => 'companyname',
            'add1' => 'address1',
            'add2' => 'address2',
            'city',
            'state',
            'zip' => 'postalcode',
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
            if (isset($destination[$column])) {
                return;
            }

            if (strtolower($value) === 'true' || $value === '3' ) {
                $destination[$column] = self::STATUS_PENDING_ACTIVE;
                return;
            }

            $destination[$column] = self::STATUS_PENDING_INACTIVE;
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
