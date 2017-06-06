<?php

namespace DentalSleepSolutions\Eloquent\Dental;

use DentalSleepSolutions\Exceptions\GeneralException;
use Illuminate\Database\Eloquent\Model;
use DentalSleepSolutions\Eloquent\WithoutUpdatedTimestamp;
use DentalSleepSolutions\Contracts\Resources\Patient as Resource;
use DentalSleepSolutions\Contracts\Repositories\Patients as Repository;
use DB;

class Patient extends Model implements Resource, Repository
{
    use WithoutUpdatedTimestamp;

    const DSS_REFERRED_PATIENT = 1;
    const DSS_REFERRED_PHYSICIAN = 2;

    /**
     * Guarded attributes
     *
     * @var array
     */
    protected $guarded = ['patientid', 'password', 'salt'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'dental_patients';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'patientid';


    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'recover_time', 'text_date', 'registration_senton',
        'access_code_date', 'new_fee_date'
    ];

    /**
     * The name of the "created at" column.
     *
     * @var string
     */
    const CREATED_AT = 'adddate';

    /**
     * RELATIONS
     */
    public function tongueClinicalExam()
    {
        return $this->hasOne(TongueClinicalExam::class, 'patientid', 'patientid');
    }

    public function tonsilsClinicalExam()
    {
        return $this->hasOne(TonsilsClinicalExam::class, 'patientid', 'patientid');
    }

    public function airwayEvaluation()
    {
        return $this->hasOne(AirwayEvaluation::class, 'patientid', 'patientid');
    }

    public function dentalClinicalExam()
    {
        return $this->hasOne(DentalClinicalExam::class, 'patientid', 'patientid');
    }

    public function tmjClinicalExam()
    {
        return $this->hasOne(TmjClinicalExam::class, 'patientid', 'patientid');
    }

    /**
     * @param array $fields
     * @param array $where
     * @return \Illuminate\Database\Eloquent\Collection|Patient[]
     */
    public function getWithFilter($fields = [], $where = [])
    {
        $object = $this;

        if (count($fields)) {
            $object = $object->select($fields);
        }

        if (count($where)) {
            foreach ($where as $key => $value) {
                $object = $object->where($key, $value);
            }
        }

        return $object->get();
    }

    public function getNumber($docId = 0)
    {
        return $this->select(DB::raw('COUNT(p2.patientid) AS total'))
            ->from(DB::raw('dental_patients p2'))
            ->join(DB::raw('dental_patients p'), 'p.patientid', '=', 'p2.parent_patientid')
            ->where('p.docid', $docId)
            ->first();
    }

    public function getDuplicates($docId = 0)
    {
        return $this->select(DB::raw('COUNT(p.patientid) AS total'))
            ->from(DB::raw('dental_patients p'))
            ->whereIn('p.status', [3, 4])
            ->where('p.docid', $docId)
            ->whereRaw("
                (SELECT COUNT(dp.patientid)
                FROM dental_patients dp
                WHERE dp.status = 1
                    AND dp.docid = ?
                    AND (
                        (
                            dp.firstname = p.firstname
                            AND dp.lastname = p.lastname
                        )
                        OR (
                            dp.add1 = p.add1
                            AND dp.city = p.city
                            AND dp.state = p.state
                            AND dp.zip = p.zip
                        )
                    )
                ) != 0", [$docId]
            )
            ->first();
    }

    public function getBounces($docId = 0)
    {
        return $this->select(DB::raw('COUNT(p.patientid) AS total'))
            ->from(DB::raw('dental_patients p'))
            ->where('p.email_bounce', 1)
            ->where('p.docid', $docId)
            ->first();
    }

    public function getListPatients($docId = 0, $names)
    {
        if (empty($names[0])) {
            $names[0] = '';
        }

        if (empty($names[1])) {
            $names[1] = '';
        }

        if (empty($names[2])) {
            $names[2] = '';
        }

        return $this->select(DB::raw('p.patientid, p.lastname, p.firstname, p.middlename, s.patient_info'))
            ->from(DB::raw('dental_patients p'))
            ->leftJoin(DB::raw('dental_patient_summary s'), 'p.patientid', '=', 's.pid')
            ->where(function($query) use ($names) {
                $query->where(function($query) use ($names) {
                    $query->whereRaw("(lastname LIKE ? OR firstname LIKE ?)", array($names[0] . '%', $names[0] . '%'))
                        ->whereRaw("(lastname LIKE ? OR firstname LIKE ?)", array($names[1] . '%', $names[1] . '%'));
                })
                ->orWhereRaw("(firstname LIKE ? AND middlename LIKE ? AND lastname LIKE ?)", array($names[0] . '%', $names[1] . '%', $names[2] . '%'));
            })
            ->where('p.status', '=', 1)
            ->where('docid', '=', $docId)
            ->orderBy('lastname')
            ->take(12)
            ->get();
    }

    public function deleteForDoctor($patientId = 0, $docId = 0)
    {
        return $this->where('patientid', $patientId)
            ->where('docid', $docId)
            ->delete();
    }

    public function scopeActive($query)
    {
        return $query->where('p.status', 1);
    }

    public function scopeAll($query)
    {
        return $query->where(function($query) {
            $query->where('p.status', 1)
                ->orWhere('p.status', 2);
        });
    }

    public function scopeInactive($query)
    {
        return $query->where('p.status', 2);
    }

    public function findBy(
            $docId           = 0,
            $userType        = 0,
            $patientId       = 0,
            $type            = 1,
            $pageNumber      = 0,
            $patientsPerPage = 30,
            $letter          = '',
            $sortColumn      = '',
            $sortDir         = ''
    ) {
        $sections = $this->getQuerySections(null, $userType);
        $joins    = $this->getJoinList();

        if (array_key_exists($sortColumn, $sections)) {
            $section = $sections[$sortColumn];
            unset($sections[$sortColumn]);
        } else {
            $section = ['order' => ''];
        }

        $selectList = [
            'p.patientid',
            'summary.vob',
            'summary.ledger AS ledger',
            'summary.patient_info AS patient_info',
        ];

        $tableList = [
            'dental_patients p'
        ];

        $joinList = [
            'summary'
        ];

        $orderBy = $section['order'];

        if ($sortColumn === 'name') {

        } else {
            $orderBy = "patient_info DESC, "
                . ($orderBy ? $orderBy . ", " : "")
                . "p.lastname ASC, p.firstname ASC";
        }

        $orderBy = str_replace('%DIR%', $sortDir, $orderBy);

        if (isset($section['select'])) {
            $selectList[] = $section['select'];
        }

        if (isset($section['join'])) {
            $joinList[] = $section['join'];
        }

        foreach ($joinList as $name) {
            $tableList[] = array_get($joins, $name);
            unset($joins[$name]);
        }

        $selections = join(', ', $selectList);
        $tables = join(' ', $tableList);
        $offset = $pageNumber * $patientsPerPage;

        $countQuery = $this->select(DB::raw('COUNT(p.patientid) AS total'))
            ->from(DB::raw($tables));

        $countQuery  = $this->getConditions($countQuery, $type, $docId, $patientId, $letter);
        $countResult = $countQuery->get();

        $orderQuery = $this->select(DB::raw($selections))
            ->from(DB::raw($tables));

        $orderQuery  = $this->getConditions($orderQuery, $type, $docId, $patientId, $letter);
        $orderResults = $orderQuery->orderByRaw($orderBy)
            ->skip($offset)
            ->take($patientsPerPage)
            ->get();

        $selectList = array_merge($selectList, array_filter(array_pluck($sections, 'select')), ['p.*']);
        $tableList = array_merge($tableList, $joins);

        $patientIds = [];

        if ($orderResults) {
            $patientIds = array_pluck($orderResults, 'patientid');
        }

        $selections = join(",\n", $selectList);
        $tables = join("\n", $tableList);

        $results = $this->select(DB::raw($selections))
            ->from(DB::raw($tables));

        $results = $this->getConditions($results, $type, $docId, $patientId, $letter, $patientIds);
        $results = $results->orderByRaw($orderBy)
            ->take($patientsPerPage)
            ->get();

        return [
            'count'   => $countResult,
            'order'   => $orderResults,
            'results' => $results
        ];
    }

    private function getConditions(
        $query,
        $type,
        $docId      = 0,
        $patientId  = 0,
        $letter     = '',
        $patientIds = []
    ) {
        $query = $query->where('p.docid', $docId);

        if (!empty($patientId)) {
            $query = $query->where('p.patientid', $patientId);
        }

        switch ($type) {
            case 1:
                $query = $query->active();
                break;
            case 2:
                $query = $query->all();
                break;
            case 3:
                $query = $query->inactive();
                break;
            default:
                break;
        }

        if (!empty($letter)) {
            $query = $query->where('p.lastname', 'like', $letter . '%');
        }

        if (!empty($patientIds)) {
            $query = $query->whereIn('p.patientid', $patientIds);
        }

        return $query;
    }

    private function getQuerySections($section = 'all', $userType)
    {
        $userTypeSoftware = 2;

        $querySections = [
            'name' => [
                'order' => "p.lastname %DIR%, p.firstname %DIR%",
            ],
            'tx' => [
                'select' => "(
                    (
                        '{$userType}' = '$userTypeSoftware'
                        AND COALESCE(p.p_m_dss_file, 0) != 0
                    )
                    OR COALESCE(p.p_m_dss_file, 0) = 1
                ) AS insurance_no_error,
                (
                    SELECT COUNT(id)
                    FROM dental_summ_sleeplab sleep_lab
                    WHERE sleep_lab.patiendid = p.patientid
                        AND COALESCE(sleep_lab.filename, '') != ''
                        AND COALESCE(sleep_lab.diagnosis, '') != ''
                        AND (
                            p.p_m_ins_type != '1'
                            OR (
                                COALESCE(sleep_lab.diagnosising_doc, '') != ''
                                AND COALESCE(sleep_lab.diagnosising_npi, '') != ''
                            )
                        )
                ) AS numsleepstudy",
                'order' => "(insurance_no_error AND numsleepstudy > 0) %DIR%",
            ],
            'next-visit' => [
                'select' => 'next_visit.date_scheduled AS date_scheduled',
                'join' => 'next-visit',
                'order' => "date_scheduled %DIR%",
            ],
            'last-visit' => [
                'select' => 'last_dates.date_completed AS date_completed',
                'join' => 'last-dates',
                'order' => "date_completed %DIR%",
            ],
            'last-treatment' => [
                'select' => 'last_dates.segmentid AS segmentid',
                'join' => 'last-dates',
                'order' => "segmentid %DIR%",
            ],
            'appliance' => [
                'select' => 'device.device AS device',
                'join' => 'device',
                'order' => "device %DIR%",
            ],
            'appliance-since' => [
                'select' => 'device_date.dentaldevice_date AS dentaldevice_date',
                'join' => 'device',
                'order' => "dentaldevice_date %DIR%",
            ],
            'vob' => [
                'select' => 'summary.vob AS vob',
                'join' => 'summary',
                'order' => "vob %DIR%",
            ],
            'rx-lomn' => [
                'select' => "CASE
                    WHEN LENGTH(COALESCE(rx_lomn.rxlomnrec, ''))
                        OR (
                            LENGTH(COALESCE(rx_lomn.lomnrec, '')) AND LENGTH(COALESCE(rx_lomn.rxrec, ''))
                        ) THEN 3
                    WHEN LENGTH(COALESCE(rx_lomn.rxrec, '')) THEN 2
                    WHEN LENGTH(COALESCE(rx_lomn.lomnrec, '')) THEN 1
                    ELSE 0
                END AS rx_lomn",
                'join' => 'rx-lomn',
                'order' => "rx_lomn %DIR%",
            ],
            'ledger' => [
                'select' => '(
                    COALESCE(
                        (
                            SELECT SUM(COALESCE(first.amount, 0)) AS total
                            FROM dental_ledger first
                            WHERE first.docid = p.docid
                                AND first.patientid = p.patientid
                                AND COALESCE(first.paid_amount, 0) = 0
                        ), 0
                    )
                    + COALESCE(
                        (
                            SELECT SUM(COALESCE(second.amount, 0)) - SUM(COALESCE(second.paid_amount, 0))
                            FROM dental_ledger second
                            WHERE second.docid = p.docid
                                AND second.patientid = p.patientid
                                AND second.paid_amount != 0
                        ), 0
                    )
                    - COALESCE(
                        (
                            SELECT SUM(COALESCE(third_payment.amount, 0))
                            FROM dental_ledger third
                                LEFT JOIN dental_ledger_payment third_payment ON third_payment.ledgerid = third.ledgerid
                            WHERE third.docid = p.docid
                                AND third.patientid = p.patientid
                                AND third_payment.amount != 0
                        ), 0
                    )
                ) AS total',
                'order' => "ledger IS NOT NULL %DIR%, total %DIR%",
            ],
        ];

        return $this->itemSelector($querySections, $section);
    }

    private function itemSelector ($array = [], $section = 'all')
    {
        if ($section === 'all') {
            return $array;
        }

        if ($section{0} === '^') {
            $section = substr($section, 1);
            unset($array[$section]);
            return $array;
        }

        return array_get($array, $section);
    }

    private function getJoinList($section = 'all')
    {
        $joinSections = [
            'allergens-check' => 'LEFT JOIN (
                SELECT patientid, MAX(q_page3id) AS max_id
                FROM dental_q_page3
                GROUP BY patientid
            ) allergens_check_pivot ON allergens_check_pivot.patientid = p.patientid
            LEFT JOIN dental_q_page3 allergens_check ON allergens_check.q_page3id = allergens_check_pivot.max_id',

            'summary' => 'LEFT JOIN dental_patient_summary summary ON summary.pid = p.patientid',

            'rx-lomn' => 'LEFT JOIN (
                SELECT pid AS patientid, MAX(id) AS max_id
                FROM dental_flow_pg1
                GROUP BY pid
            ) rx_lomn_pivot ON rx_lomn_pivot.patientid = p.patientid
            LEFT JOIN dental_flow_pg1 rx_lomn ON rx_lomn.id = rx_lomn_pivot.max_id',

            'next-visit' => 'LEFT JOIN (
                SELECT patientid, MAX(id) AS max_id
                FROM dental_flow_pg2_info
                WHERE appointment_type = 0
                GROUP BY patientid
            ) next_visit_pivot ON next_visit_pivot.patientid = p.patientid
            LEFT JOIN dental_flow_pg2_info next_visit ON next_visit.id = next_visit_pivot.max_id',

            'last-dates' => 'LEFT JOIN (
                SELECT base_last_dates.patientid, MAX(base_last_dates.id) AS max_id, base_last_dates.segmentid
                FROM dental_flow_pg2_info base_last_dates
                    INNER JOIN (
                        SELECT patientid, max(date_completed) AS max_date
                        FROM dental_flow_pg2_info
                        GROUP BY patientid
                    ) pivot_last_dates ON pivot_last_dates.patientid = base_last_dates.patientid
                        AND pivot_last_dates.max_date = base_last_dates.date_completed
                GROUP BY base_last_dates.patientid
            ) last_dates_pivot ON last_dates_pivot.patientid = p.patientid
            LEFT JOIN dental_flow_pg2_info last_dates ON last_dates.id = last_dates_pivot.max_id',

            'device' => 'LEFT JOIN (
                SELECT patientid, dentaldevice, MAX(ex_page5id) AS max_id
                FROM dental_ex_page5
                GROUP BY patientid
            ) device_pivot ON device_pivot.patientid = p.patientid
            LEFT JOIN dental_ex_page5 device_date ON device_date.ex_page5id = device_pivot.max_id
            LEFT JOIN dental_device device ON device.deviceid = device_pivot.dentaldevice',
        ];

        return $this->itemSelector($joinSections, $section);
    }

    public function getReferredByContact($contactId)
    {
        return $this->select('patientid', 'firstname', 'lastname')
            ->where(function($query) {
                $query->whereNull('parent_patientid')
                    ->orWhere('parent_patientid', '=', '');
            })
            ->where('referred_source', 2)
            ->where('referred_by', $contactId)
            ->get();
    }

    public function getByContact($contactId)
    {
        return $this->select('patientid', 'firstname', 'lastname')
            ->where(function($query) {
                $query->whereNull('parent_patientid')
                    ->orWhere('parent_patientid', '=', '');
            })->where(function($query) use ($contactId) {
                $query->where('docpcp', '=', $contactId)
                    ->orWhere('docent', '=', $contactId)
                    ->orWhere('docsleep', '=', $contactId)
                    ->orWhere('docdentist', '=', $contactId)
                    ->orWhere('docmdother', '=', $contactId)
                    ->orWhere('docmdother2', '=', $contactId)
                    ->orWhere('docmdother3', '=', $contactId);
            })->get();
    }

    /**
     * @param int $patientId
     * @param Patient|null $patientReferredSource
     * @return string
     */
    public function getPatientReferralIds($patientId = 0, Patient $patientReferredSource = null)
    {
        if (!empty($patientReferredSource) && $patientReferredSource->referred_source == 1) {
            $contactQuery = $this->select(DB::raw('GROUP_CONCAT(distinct pr.patientid) as ids'))
                ->from(DB::raw('dental_patients pr'))
                ->join(DB::raw('dental_patients p'), 'p.referred_by', '=', 'pr.patientid')
                ->where('p.patientid', $patientId)
                ->groupBy('p.referred_by')
                ->orderBy('pr.patientid');
        } elseif (!empty($patientReferredSource) && $patientReferredSource->referred_source == 2) {
            $contactQuery = $this->select(DB::raw('GROUP_CONCAT(distinct dental_contact.contactid) as ids'))
                ->join('dental_patients', 'dental_patients.referred_by', '=', 'dental_contact.contactid')
                ->join(DB::raw('dental_contacttype ct'), 'ct.contacttypeid', '=', 'dental_contact.contacttypeid')
                ->where('dental_patients.patientid', $patientId)
                ->where('ct.physician', '!=', 1)
                ->groupBy('dental_patients.referred_by')
                ->orderBy('dental_contact.contactid');
        }

        $contactidList = '';

        if (!empty($contactQuery)) {
            $contacts = $contactQuery->get();

            if (count($contacts)) {
                $contactidList = $contacts[0]->ids;
            }
        }

        return $contactidList;
    }

    public function updateChildrenPatients($parentPatientId = 0, $data = [])
    {
        $this->where('parent_patientid', $parentPatientId)
            ->update($data);
    }

    /**
     * Search for similar logins (it need for creation of an unique login)
     *
     * @param string $login
     * @return Patient|null
     */
    public function getSimilarPatientLogin($login = '')
    {
        return $this->select('login')
            ->where('login', 'like', $login . '%')
            ->orderBy('login', 'desc')
            ->first();
    }

    public function updatePatient($patientId = 0, $data = [])
    {
        return $this->where('patientid', $patientId)
            ->update($data);
    }

    public function getReferrers($docId, $names)
    {
        $contacts = DB::table(DB::raw('dental_contact c'))
            ->select(
                'c.contactid',
                'c.lastname',
                'c.firstname',
                'c.middlename',
                DB::raw(self::DSS_REFERRED_PHYSICIAN),
                'ct.contacttype'
            )->leftJoin(DB::raw('dental_contacttype ct'), 'c.contacttypeid', '=', 'ct.contacttypeid')
            ->where(function($query) use ($names) {
                $query->where(function($query) use ($names) {
                    $query->where('lastname', 'like', $names[0] . '%')
                        ->orWhere('firstname', 'like', $names[0] . '%');
                })->where(function($query) {
                    $query->where('lastname', 'like', (!empty($names[1]) ? $names[1] : '') . '%')
                        ->orWhere('firstname', 'like', (!empty($names[1]) ? $names[1] : '') . '%');
                });
            })->whereNull('merge_id')
            ->where('docid', $docId);

        return $this->select(
                'p.patientid',
                'p.lastname',
                'p.firstname',
                'p.middlename',
                DB::raw(self::DSS_REFERRED_PATIENT . ' AS referral_type'),
                DB::raw("'Patient' as label")
            )->from(DB::raw('dental_patients p'))
            ->leftJoin(DB::raw('dental_patient_summary s'), 'p.patientid', '=', 's.pid')
            ->leftJoin(DB::raw('dental_device d'), 's.appliance', '=', 'd.deviceid')
            ->where(function($query) use ($names) {
                $query->where(function($query) use ($names) {
                    $query->where('lastname', 'like', $names[0] . '%')
                        ->orWhere('firstname', 'like', $names[0] . '%');
                })->where(function($query) {
                    $query->where('lastname', 'like', (!empty($names[1]) ? $names[1] : '') . '%')
                        ->orWhere('firstname', 'like', (!empty($names[1]) ? $names[1] : '') . '%');
                });
            })->where('docid', $docId)
            ->union($contacts)
            ->orderBy('lastname')
            ->get();
    }

    /**
     * @param int $patientId
     * @return Patient|null
     */
    public function getDentalDeviceTransactionCode($patientId)
    {
        /** @var Patient|null $transactionCode */
        $transactionCode = $this->select('tc.*')
            ->from(DB::raw('dental_patients p'))
            ->join(DB::raw('dental_transaction_code tc'), function($query) {
                $query->on('p.docid', '=', 'tc.docid')
                    ->where('tc.transaction_code', '=', 'E0486');
            })->where('p.patientid', $patientId)
            ->first();
        return $transactionCode;
    }

    /**
     * @param int $patientId
     * @return User|null
     */
    public function getUserInfo($patientId)
    {
        /** @var User|null $user */
        $user = $this->select('u.*')
            ->from(DB::raw('dental_patients p'))
            ->join(DB::raw('dental_users u'), 'p.docid', '=', 'u.userid')
            ->where('p.patientid', $patientId)
            ->where('u.npi', '!=', '')
            ->whereNotNull('u.npi')
            ->where('u.tax_id_or_ssn', '!=', '')
            ->whereNotNull('u.tax_id_or_ssn')
            ->where(function($query) {
                $query->where('u.ssn', '=', 1)
                    ->orWhere('u.ein', '=', 1);
            })->first();
        return $user;
    }

    /**
     * @param int $patientId
     * @return Patient|null
     */
    public function getInsurancePreauthInfo($patientId)
    {
        /** @var Patient|null $preauthInfo */
        $preauthInfo = $this->select(
                'i.company as ins_co',
                "'primary' as ins_rank",
                'i.phone1 as ins_phone',
                'p.p_m_ins_grp as patient_ins_group_id',
                'p.p_m_ins_id as patient_ins_id',
                'p.firstname as patient_firstname',
                'p.lastname as patient_lastname',
                'p.add1 as patient_add1',
                'p.add2 as patient_add2',
                'p.city as patient_city',
                'p.state as patient_state',
                'p.zip as patient_zip',
                'p.dob as patient_dob',
                'p.p_m_partyfname as insured_first_name',
                'p.p_m_partylname as insured_last_name',
                'p.ins_dob as insured_dob',
                'd.npi as doc_npi',
                'r.national_provider_id as referring_doc_npi',
                'd.medicare_npi as doc_medicare_npi',
                'd.tax_id_or_ssn as doc_tax_id_or_ssn',
                "CONCAT(d.first_name, ' ', d.last_name) as doc_name",
                "CONCAT(d.address, ', ', d.city, ', ',d.state,' ',d.zip) as doc_address",
                'd.practice as doc_practice',
                'd.phone as doc_phone',
                'tc.amount as trxn_code_amount',
                'q2.confirmed_diagnosis as diagnosis_code',
                'd.userid as doc_id',
                'p.home_phone as patient_phone'
            )->from(DB::raw('dental_patients p'))
            ->leftJoin(DB::raw('dental_contact r'), 'p.referred_by', '=', 'r.contactid')
            ->join(DB::raw('dental_contact i'), 'p.p_m_ins_co', '=', 'i.contactid')
            ->join(DB::raw('dental_users d'), 'p.docid', '=', 'd.userid')
            ->join(DB::raw('dental_transaction_code tc'), function($query) {
                $query->on('p.docid', '=', 'tc.docid')
                    ->where('tc.transaction_code', '=', 'E0486');
            })->leftJoin(DB::raw('dental_q_page2 q2'), 'p.patientid', '=', 'q2.patientid')
            ->where('p.patientid', $patientId)
            ->first();
        return $preauthInfo;
    }

    /**
     * @param $letterId
     * @param $patient
     * @return \Illuminate\Database\Eloquent\Collection|Patient[]
     */
    public function getContactInfo($letterId, $patient)
    {
        return $this->select(
                'patientid AS id',
                'salutation',
                'firstname',
                'lastname',
                'add1',
                'add2',
                'city',
                'state',
                'zip',
                'email',
                'preferredcontact',
                DB::raw($letterId . ' AS letterid')
            )->whereIn('patientid', $patient)
            ->get();
    }

    /**
     * @param $letterId
     * @param $patReferralList
     * @return \Illuminate\Database\Eloquent\Collection|Patient[]
     */
    public function getReferralList($letterId, $patReferralList)
    {
        return $this->select(
                'p.patientid AS id',
                'p.salutation',
                'p.lastname',
                'p.middlename',
                'p.firstname',
                DB::raw("'' as company"),
                'p.add1',
                'p.add2',
                'p.city',
                'p.state',
                'p.zip',
                'p.email',
                DB::raw("'' as fax"),
                'p.preferredcontact',
                DB::raw("'' as contacttypeid"),
                DB::raw($letterId . ' AS letterid'),
                'p.status'
            )->from(DB::raw('dental_patients p'))
            ->whereIn('p.patientid', $patReferralList)
            ->get();
    }

    /**
     * @param string $email
     * @param int $patientId
     * @return int
     */
    public function getSameEmails($email, $patientId)
    {
        return $this->select('patientid')
            ->where('email', $email)
            ->where(function($query) use ($patientId) {
                $query->where(function($query) use ($patientId) {
                    $query->where('patientid', '!=', $patientId)
                        ->where('parent_patientid', '!=', $patientId);
                })->orWhere(function($query) use ($patientId) {
                    $query->where('patientid', '!=', $patientId)
                        ->whereNull('parent_patientid');
                });
            })->count();
    }

    /**
     * @param int $patientId
     * @return Patient|null
     */
    public function getPatientInfoWithDocInfo($patientId)
    {
        return $this->select('dp.*', 'du.use_patient_portal AS doc_use_patient_portal')
            ->from(DB::raw('dental_patients dp'))
            ->join(DB::raw('dental_users du'), 'du.userid', '=', 'dp.docid')
            ->where('dp.patientid', $patientId)
            ->first();
    }

    /**
     * @param int $docId
     * @param array $patientInfo
     * @return Patient[]
     */
    public function getSimilarPatients($docId, array $patientInfo)
    {
        $defaultPatientInfo = [
            'patient_id' => 0,
            'firstname'  => '',
            'lastname'   => '',
            'add1'       => '',
            'city'       => '',
            'state'      => '',
            'zip'        => ''
        ];

        $patientInfo = array_merge($defaultPatientInfo, $patientInfo);

        /** @var Patient[] $patients */
        $patients = $this->from(DB::raw('dental_patients p'))
            ->where('patientid', '!=', $patientInfo['patient_id'])
            ->where('docid', $docId)
            ->active()
            ->where(function($query) use ($patientInfo) {
                $query->where(function($query) use ($patientInfo) {
                    $query->where('firstname', '=', $patientInfo['firstname'])
                        ->where('lastname', '=', $patientInfo['lastname']);
                })->orWhere(function($query) use ($patientInfo) {
                    $query->where('add1', '=', $patientInfo['add1'])
                        ->where('add1', '!=', '')
                        ->where('city', '=', $patientInfo['city'])
                        ->where('city', '!=', '')
                        ->where('state', '=', $patientInfo['state'])
                        ->where('state', '!=', '')
                        ->where('zip', '=', $patientInfo['zip'])
                        ->where('zip', '!=', '');
                });
            })->get();
        return $patients;
    }

    public function getReferralCountersForContact($contactId, $contactType, $dateConditional, $isDetailed = false)
    {
        if ($isDetailed) {
            $query = $this->select('p.firstname', 'p.lastname', 'p.copyreqdate');
        } else {
            $query = $this->select('p.patientid');
        }

        $query = $query->from(DB::raw('dental_patients p'))
            ->where('p.referred_by', $contactId)
            ->where('p.referred_source', $contactType)
            ->whereRaw("STR_TO_DATE(p.copyreqdate, '%m/%d/%Y') $dateConditional");

        if ($isDetailed) {
            return $query->get();
        } else {
            return $query->count();
        }
    }

    public function getRelatedToSleeplab($sleeplabId)
    {
        return $this->select('p.patientid', 'p.firstname', 'p.lastname')
            ->from(DB::raw('dental_patients p'))
            ->join(DB::raw('dental_summ_sleeplab s'), 's.patiendid', '=', 'p.patientid')
            ->where('s.place', $sleeplabId)
            ->groupBy('p.patientid')
            ->get();
    }

    /**
     * @param int $patientId
     * @return Patient|null
     * @throws GeneralException
     */
    public function getUnchangedPatient($patientId)
    {
        if (!$patientId) {
            return null;
        }
        /** @var Patient|null $unchangedPatient */
        $unchangedPatient = $this->find($patientId);
        if (!$unchangedPatient) {
            throw new GeneralException("Patient with ID $patientId not found");
        }
        return $unchangedPatient;
    }
}
