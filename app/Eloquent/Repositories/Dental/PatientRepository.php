<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\Patient;
use DentalSleepSolutions\Eloquent\Models\Dental\User;
use DentalSleepSolutions\Eloquent\Repositories\AbstractRepository;
use DentalSleepSolutions\Temporary\PatientFormDataUpdater;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Database\Query\JoinClause;

class PatientRepository extends AbstractRepository
{
    const DEFAULT_PATIENT_INFO = [
        'patient_id' => 0,
        'firstname'  => '',
        'lastname'   => '',
        'add1'       => '',
        'city'       => '',
        'state'      => '',
        'zip'        => '',
    ];

    const USER_TYPE_SOFTWARE = 2;

    const LIST_PATIENTS_LIMIT = 12;

    const DUPLICATE_STATUSES = [3, 4];

    const BASE_FIND_PATIENT_SELECT = [
        'p.patientid',
        'summary.vob',
        'summary.ledger AS ledger',
        'summary.patient_info AS patient_info',
    ];

    const ALL_FIELDS_SELECT = 'p.*';

    const BASE_FIND_PATIENT_TABLE = 'dental_patients p';

    public function model()
    {
        return Patient::class;
    }

    /**
     * @param int $docId
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function getNumber($docId)
    {
        return $this->model
            ->select(\DB::raw('COUNT(p2.patientid) AS total'))
            ->from(\DB::raw('dental_patients p2'))
            ->join(\DB::raw('dental_patients p'), 'p.patientid', '=', 'p2.parent_patientid')
            ->where('p.docid', $docId)
            ->first()
        ;
    }

    /**
     * @param int $docId
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function getDuplicates($docId)
    {
        return $this->model
            ->select(\DB::raw('COUNT(p.patientid) AS total'))
            ->from(\DB::raw('dental_patients p'))
            ->whereIn('p.status', self::DUPLICATE_STATUSES)
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
            ->first()
        ;
    }

    /**
     * @param int $docId
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function getBounces($docId)
    {
        return $this->model
            ->select(\DB::raw('COUNT(p.patientid) AS total'))
            ->from(\DB::raw('dental_patients p'))
            ->where('p.email_bounce', 1)
            ->where('p.docid', $docId)
            ->first()
        ;
    }

    /**
     * @param int $docId
     * @param array $names
     * @return array|\Illuminate\Database\Eloquent\Collection
     */
    public function getListPatients($docId, array $names)
    {
        $defaultNames = ['', '', ''];
        $names = array_merge($defaultNames, $names);

        return $this->model
            ->select(\DB::raw('p.patientid, p.lastname, p.firstname, p.middlename, s.patient_info'))
            ->from(\DB::raw('dental_patients p'))
            ->leftJoin(\DB::raw('dental_patient_summary s'), 'p.patientid', '=', 's.pid')
            ->where(function (Builder $query) use ($names) {
                /** @var Builder|QueryBuilder $queryBuilder */
                $queryBuilder = $query;
                $queryBuilder
                    ->where(function (Builder $query) use ($names) {
                        /** @var Builder|QueryBuilder $queryBuilder */
                        $queryBuilder = $query;
                        $queryBuilder
                            ->whereRaw("(lastname LIKE ? OR firstname LIKE ?)", [$names[0] . '%', $names[0] . '%'])
                            ->whereRaw("(lastname LIKE ? OR firstname LIKE ?)", [$names[1] . '%', $names[1] . '%'])
                        ;
                    })
                    ->orWhereRaw("(firstname LIKE ? AND middlename LIKE ? AND lastname LIKE ?)", [$names[0] . '%', $names[1] . '%', $names[2] . '%'])
                ;
            })
            ->where('p.status', '=', 1)
            ->where('docid', '=', $docId)
            ->orderBy('lastname')
            ->take(self::LIST_PATIENTS_LIMIT)
            ->get()
        ;
    }

    /**
     * @param int $patientId
     * @param int $docId
     * @return bool|null
     */
    public function deleteForDoctor($patientId, $docId)
    {
        return $this->model
            ->where('patientid', $patientId)
            ->where('docid', $docId)
            ->delete()
        ;
    }

    /**
     * @param int $docId
     * @param array $names
     * @return array|\Illuminate\Database\Eloquent\Collection
     */
    public function getReferrers($docId, array $names)
    {
        $contacts = \DB::table(\DB::raw('dental_contact c'))
            ->select(
                'c.contactid',
                'c.lastname',
                'c.firstname',
                'c.middlename',
                \DB::raw(Patient::DSS_REFERRED_PHYSICIAN),
                'ct.contacttype'
            )
            ->leftJoin(\DB::raw('dental_contacttype ct'), 'c.contacttypeid', '=', 'ct.contacttypeid')
            ->where(function (QueryBuilder $query) use ($names) {
                $query
                    ->where(function (QueryBuilder $query) use ($names) {
                        $query
                            ->where('lastname', 'like', $names[0] . '%')
                            ->orWhere('firstname', 'like', $names[0] . '%')
                        ;
                    })
                    ->where(function (QueryBuilder $query) {
                        $query
                            ->where('lastname', 'like', (!empty($names[1]) ? $names[1] : '') . '%')
                            ->orWhere('firstname', 'like', (!empty($names[1]) ? $names[1] : '') . '%')
                        ;
                    })
                ;
            })
            ->whereNull('merge_id')
            ->where('docid', $docId)
        ;

        return $this->model
            ->select(
                'p.patientid',
                'p.lastname',
                'p.firstname',
                'p.middlename',
                \DB::raw(Patient::DSS_REFERRED_PATIENT . ' AS referral_type'),
                \DB::raw("'Patient' as label")
            )
            ->from(\DB::raw('dental_patients p'))
            ->leftJoin(\DB::raw('dental_patient_summary s'), 'p.patientid', '=', 's.pid')
            ->leftJoin(\DB::raw('dental_device d'), 's.appliance', '=', 'd.deviceid')
            ->where(function (Builder $query) use ($names) {
                $query
                    ->where(function (Builder $query) use ($names) {
                        $query
                            ->where('lastname', 'like', $names[0] . '%')
                            ->orWhere('firstname', 'like', $names[0] . '%')
                        ;
                    })
                    ->where(function (Builder $query) {
                        $query
                            ->where('lastname', 'like', (!empty($names[1]) ? $names[1] : '') . '%')
                            ->orWhere('firstname', 'like', (!empty($names[1]) ? $names[1] : '') . '%')
                        ;
                    })
                ;
            })
            ->where('docid', $docId)
            ->union($contacts)
            ->orderBy('lastname')
            ->get()
        ;
    }

    /**
     * @param int $patientId
     * @return Model|null
     */
    public function getPatientInfoWithDocInfo($patientId)
    {
        return $this->model
            ->select('dp.*', 'du.use_patient_portal AS doc_use_patient_portal')
            ->from(\DB::raw('dental_patients dp'))
            ->join(\DB::raw('dental_users du'), 'du.userid', '=', 'dp.docid')
            ->where('dp.patientid', $patientId)
            ->first()
        ;
    }

    /**
     * @param string $email
     * @param int $patientId
     * @return int
     */
    public function getSameEmails($email, $patientId)
    {
        return $this->model
            ->select('patientid')
            ->where('email', $email)
            ->where(function (Builder $query) use ($patientId) {
                $query
                    ->where(function (Builder $query) use ($patientId) {
                        $query
                            ->where('patientid', '!=', $patientId)
                            ->where('parent_patientid', '!=', $patientId)
                        ;
                    })
                    ->orWhere(function (Builder $query) use ($patientId) {
                        /** @var Builder|QueryBuilder $query */
                        $query = $query->where('patientid', '!=', $patientId);
                        $query->whereNull('parent_patientid');
                    })
                ;
            })
            ->count()
        ;
    }

    /**
     * @param string $selections
     * @param string $tables
     * @return Builder|QueryBuilder
     */
    public function getFindPatientBaseQuery($selections, $tables)
    {
        $query = $this->model
            ->select(\DB::raw($selections))
            ->from(\DB::raw($tables))
        ;
        return $query;
    }

    /**
     * @param string $tables
     * @return Builder|QueryBuilder
     */
    public function getFindPatientCountBaseQuery($tables)
    {
        $countQuery = $this->model
            ->select(\DB::raw('COUNT(p.patientid) AS total'))
            ->from(\DB::raw($tables))
        ;
        return $countQuery;
    }

    /**
     * @param string $selections
     * @param string $tables
     * @return Builder|QueryBuilder
     */
    public function getFindPatientOrderBaseQuery($selections, $tables)
    {
        $orderQuery = $this->model
            ->select(\DB::raw($selections))
            ->from(\DB::raw($tables))
        ;
        return $orderQuery;
    }

    /**
     * @param Builder|QueryBuilder $orderQuery
     * @param string $orderBy
     * @param int $offset
     * @param int $perPage
     * @return Builder|QueryBuilder
     */
    public function paginateFindPatientOrderQuery($orderQuery, $orderBy, $offset, $perPage)
    {
        return $orderQuery
            ->orderByRaw($orderBy)
            ->skip($offset)
            ->take($perPage)
        ;
    }

    /**
     * @param Builder|QueryBuilder $query
     * @param string $orderBy
     * @param int $perPage
     * @return Builder|QueryBuilder
     */
    public function paginateFindPatientQuery($query, $orderBy, $perPage)
    {
        return $query
            ->orderByRaw($orderBy)
            ->take($perPage)
        ;
    }

    /**
     * @param Builder|QueryBuilder $query
     * @param int $docId
     * @return Builder|QueryBuilder
     */
    public function addDocIdToFindPatientQuery($query, $docId)
    {
        return $query->where('p.docid', $docId);
    }

    /**
     * @param Builder|QueryBuilder $query
     * @param int $patientId
     * @return Builder|QueryBuilder
     */
    public function addPatientIdToFindPatientQuery($query, $patientId)
    {
        return $query->where('p.patientid', $patientId);
    }

    /**
     * @param Builder|QueryBuilder $query
     * @param int[] $patientIds
     * @return Builder|QueryBuilder
     */
    public function addPatientIdsArrayToFindPatientQuery($query, array $patientIds)
    {
        return $query->whereIn('p.patientid', $patientIds);
    }

    /**
     * @param Builder|QueryBuilder $query
     * @param int $status
     * @return Builder|QueryBuilder
     */
    public function addStatusToFindPatientQuery($query, $status)
    {
        return $query->where('p.status', $status);
    }

    /**
     * @param Builder|QueryBuilder $query
     * @param int[] $statuses
     * @return Builder|QueryBuilder
     */
    public function addSeveralStatusesToFindPatientQuery($query, array $statuses)
    {
        if (!isset($statuses[0])) {
            return $query;
        }
        return $query->where(function (QueryBuilder $query) use ($statuses) {
            /** @var QueryBuilder $query */
            $query = $query->where('p.status', $statuses[0]);
            unset($statuses[0]);
            foreach ($statuses as $status) {
                $query = $query->orWhere('p.status', $status);
            }
            return $query;
        });
    }

    /**
     * @param Builder|QueryBuilder $query
     * @param string $lastName
     * @return Builder|QueryBuilder
     */
    public function addLastNameToFindPatientQuery($query, $lastName)
    {
        return $query->where('p.lastname', 'like', $lastName . '%');
    }

    /**
     * @param int $contactId
     * @return array
     */
    public function getReferredByContact($contactId)
    {
        return $this->model
            ->select('patientid', 'firstname', 'lastname')
            ->where(function ($query) {
                /** @var Builder|QueryBuilder $queryBuilder */
                $queryBuilder = $query;
                $queryBuilder
                    ->whereNull('parent_patientid')
                    ->orWhere('parent_patientid', '=', '')
                ;
            })
            ->where('referred_source', 2)
            ->where('referred_by', $contactId)
            ->get()
        ;
    }

    /**
     * @param int $contactId
     * @return array|Collection
     */
    public function getByContact($contactId)
    {
        return $this->model
            ->select('patientid', 'firstname', 'lastname')
            ->where(function ($query) {
                /** @var Builder|QueryBuilder $queryBuilder */
                $queryBuilder = $query;
                $queryBuilder
                    ->whereNull('parent_patientid')
                    ->orWhere('parent_patientid', '=', '')
                ;
            })
            ->where(function (Builder $query) use ($contactId) {
                foreach (PatientFormDataUpdater::DOC_FIELDS as $key => $field) {
                    $query = $this->addDocFieldToQuery($query, $field, $key, $contactId);
                }
            })
            ->get()
        ;
    }

    /**
     * @param Builder $query
     * @param string $field
     * @param int $key
     * @param int $id
     * @return Builder
     */
    private function addDocFieldToQuery(Builder $query, $field, $key, $id)
    {
        if ($key === 0) {
            return $query->where($field, '=', $id);
        }
        return $query->orWhere($field, '=', $id);
    }

    /**
     * @param int $patientId
     * @param array $data
     * @return bool|int
     */
    public function updatePatient($patientId, array $data)
    {
        return $this->model
            ->where('patientid', $patientId)
            ->update($data)
        ;
    }

    /**
     * @param int $parentPatientId
     * @param array $data
     */
    public function updateChildrenPatients($parentPatientId, array $data)
    {
        $this->model
            ->where('parent_patientid', $parentPatientId)
            ->update($data)
        ;
    }

    /**
     * @param string $login
     * @return Patient|null
     */
    public function getSimilarPatientLogin($login)
    {
        return $this->model
            ->select('login')
            ->where('login', 'like', $login . '%')
            ->orderBy('login', 'desc')
            ->first()
        ;
    }

    /**
     * @param int $patientId
     * @return array|Collection
     */
    public function getPatientReferralIdsForReferredSourceOfOne($patientId)
    {
        return $this->model
            ->select(\DB::raw('GROUP_CONCAT(distinct pr.patientid) AS ids'))
            ->from(\DB::raw('dental_patients pr'))
            ->join(\DB::raw('dental_patients p'), 'p.referred_by', '=', 'pr.patientid')
            ->where('p.patientid', $patientId)
            ->groupBy('p.referred_by')
            ->orderBy('pr.patientid')
            ->get()
        ;
    }

    /**
     * @param int $patientId
     * @return array|Collection
     */
    public function getPatientReferralIdsForReferredSourceOfTwo($patientId)
    {
        return $this->model
            ->select(\DB::raw('GROUP_CONCAT(distinct dental_contact.contactid) as ids'))
            ->join('dental_patients', 'dental_patients.referred_by', '=', 'dental_contact.contactid')
            ->join(\DB::raw('dental_contacttype ct'), 'ct.contacttypeid', '=', 'dental_contact.contacttypeid')
            ->where('dental_patients.patientid', $patientId)
            ->where('ct.physician', '!=', 1)
            ->groupBy('dental_patients.referred_by')
            ->orderBy('dental_contact.contactid')
            ->get()
        ;
    }

    /**
     * @param int $patientId
     * @return Model|null
     */
    public function getDentalDeviceTransactionCode($patientId)
    {
        /** @var Model|null $transactionCode */
        $transactionCode = $this->model
            ->select('tc.*')
            ->from(\DB::raw('dental_patients p'))
            ->join(\DB::raw('dental_transaction_code tc'), function(JoinClause $query) {
                $query
                    ->on('p.docid', '=', 'tc.docid')
                    ->where('tc.transaction_code', '=', 'E0486')
                ;
            })
            ->where('p.patientid', $patientId)
            ->first()
        ;
        return $transactionCode;
    }

    /**
     * @param int $patientId
     * @return Patient|null
     */
    public function getInsurancePreauthInfo($patientId)
    {
        /** @var Patient|null $preauthInfo */
        $preauthInfo = $this->model
            ->select(
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
            )
            ->from(\DB::raw('dental_patients p'))
            ->leftJoin(\DB::raw('dental_contact r'), 'p.referred_by', '=', 'r.contactid')
            ->join(\DB::raw('dental_contact i'), 'p.p_m_ins_co', '=', 'i.contactid')
            ->join(\DB::raw('dental_users d'), 'p.docid', '=', 'd.userid')
            ->join(\DB::raw('dental_transaction_code tc'), function(JoinClause $query) {
                $query
                    ->on('p.docid', '=', 'tc.docid')
                    ->where('tc.transaction_code', '=', 'E0486')
                ;
            })
            ->leftJoin(\DB::raw('dental_q_page2 q2'), 'p.patientid', '=', 'q2.patientid')
            ->where('p.patientid', $patientId)
            ->first()
        ;
        return $preauthInfo;
    }

    /**
     * @param int $patientId
     * @return User|null
     */
    public function getUserInfo($patientId)
    {
        /** @var User|null $user */
        $user = $this->model
            ->select('u.*')
            ->from(\DB::raw('dental_patients p'))
            ->join(\DB::raw('dental_users u'), 'p.docid', '=', 'u.userid')
            ->where('p.patientid', $patientId)
            ->where('u.npi', '!=', '')
            ->whereNotNull('u.npi')
            ->where('u.tax_id_or_ssn', '!=', '')
            ->whereNotNull('u.tax_id_or_ssn')
            ->where(function (Builder $query) {
                $query
                    ->where('u.ssn', '=', 1)
                    ->orWhere('u.ein', '=', 1)
                ;
            })
            ->first()
        ;
        return $user;
    }

    /**
     * @param int $letterId
     * @param int $patient
     * @return Collection|Patient[]
     */
    public function getContactInfo($letterId, $patient)
    {
        return $this->model
            ->select(
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
                // @todo: int cannot be aliased
                \DB::raw($letterId . ' AS letterid')
            )
            ->whereIn('patientid', $patient)
            ->get()
        ;
    }

    /**
     * @param int $letterId
     * @param string|null $patientReferralList
     * @return Collection|Patient[]
     */
    public function getReferralList($letterId, $patientReferralList)
    {
        return $this->model
            ->select(
                'p.patientid AS id',
                'p.salutation',
                'p.lastname',
                'p.middlename',
                'p.firstname',
                \DB::raw("'' as company"),
                'p.add1',
                'p.add2',
                'p.city',
                'p.state',
                'p.zip',
                'p.email',
                \DB::raw("'' AS fax"),
                'p.preferredcontact',
                \DB::raw("'' AS contacttypeid"),
                // @todo: int cannot be aliased
                \DB::raw($letterId . ' AS letterid'),
                'p.status'
            )
            ->from(\DB::raw('dental_patients p'))
            ->whereIn('p.patientid', $patientReferralList)
            ->get()
        ;
    }

    /**
     * @param int $docId
     * @param array $patientInfo
     * @return Patient[]|Collection
     */
    public function getSimilarPatients($docId, array $patientInfo)
    {
        $patientInfo = array_merge(self::DEFAULT_PATIENT_INFO, $patientInfo);

        /** @var Patient[]|Collection $patients */
        $patients = $this->model
            ->from(\DB::raw('dental_patients p'))
            ->where('patientid', '!=', $patientInfo['patient_id'])
            ->where('docid', $docId)
            ->where('p.status', 1)
            ->where(function (Builder $query) use ($patientInfo) {
                $query
                    ->where(function (Builder $query) use ($patientInfo) {
                        $query
                            ->where('firstname', '=', $patientInfo['firstname'])
                            ->where('lastname', '=', $patientInfo['lastname'])
                        ;
                    })
                    ->orWhere(function (Builder $query) use ($patientInfo) {
                        $fields = ['add1', 'city', 'state', 'zip'];
                        foreach ($fields as $field) {
                            $query = $query
                                ->where($field, '=', $patientInfo[$field])
                                ->where($field, '!=', '')
                            ;
                        }
                    })
                ;
            })
            ->get()
        ;
        return $patients;
    }

    /**
     * @param int $contactId
     * @param int $contactType
     * @param string $dateConditional
     * @param bool $isDetailed
     * @return Patient[]|Collection|int
     */
    public function getReferralCountersForContact($contactId, $contactType, $dateConditional, $isDetailed)
    {
        /** @var Builder|QueryBuilder $query */
        $query = $this->getReferralCountersForContactQueryByDetailed($isDetailed);

        $query = $query
            ->from(\DB::raw('dental_patients p'))
            ->where('p.referred_by', $contactId)
            ->where('p.referred_source', $contactType)
            ->whereRaw("STR_TO_DATE(p.copyreqdate, '%m/%d/%Y') $dateConditional")
        ;

        if ($isDetailed) {
            return $query->get();
        }
        return $query->count();
    }

    public function getDateConditionalBetweenDays($numberOfDaysBefore, $numberOfDaysAfter)
    {
        $dateConditional = "BETWEEN DATE_SUB(CURDATE(), INTERVAL $numberOfDaysAfter DAY) AND ";
        if ($numberOfDaysBefore) {
            $dateConditional .= "DATE_SUB(CURDATE(), INTERVAL $numberOfDaysBefore DAY)";
            return $dateConditional;
        }
        $dateConditional .= 'CURDATE()';
        return $dateConditional;
    }

    public function getDateConditionalForDay($numberOfDays)
    {
        return "< DATE_SUB(CURDATE(), INTERVAL $numberOfDays DAY)";
    }

    /**
     * @param bool $isDetailed
     * @return Builder|QueryBuilder
     */
    public function getReferralCountersForContactQueryByDetailed($isDetailed)
    {
        if ($isDetailed) {
            return $this->model->select('p.firstname', 'p.lastname', 'p.copyreqdate');
        }
        return $this->model->select('p.patientid');
    }

    /**
     * @param int $sleeplabId
     * @return Model[]|Collection
     */
    public function getRelatedToSleeplab($sleeplabId)
    {
        return $this->model
            ->select('p.patientid', 'p.firstname', 'p.lastname')
            ->from(\DB::raw('dental_patients p'))
            ->join(\DB::raw('dental_summ_sleeplab s'), 's.patiendid', '=', 'p.patientid')
            ->where('s.place', $sleeplabId)
            ->groupBy('p.patientid')
            ->get()
        ;
    }

    /**
     * @param int $contactId
     * @param int $contactType
     * @param bool $isDetailed
     * @return array
     */
    public function getReferralCountersForContactWithoutDate(
        $contactId,
        $contactType,
        $isDetailed
    ) {
        $counters = [];
        $ranges = [
            [0, 30],
            [30, 60],
            [60, 90],
            [90, 0],
        ];

        foreach ($ranges as $range) {
            if ($range[1]) {
                $key = "num_ref{$range[1]}";
                $curDate = 'CURDATE()';
                if ($range[0]) {
                    $curDate = "DATE_SUB(CURDATE(), INTERVAL {$range[0]} DAY)";
                }
                $dateConditional = "BETWEEN DATE_SUB(CURDATE(), INTERVAL {$range[1]} DAY) AND $curDate";
            } else {
                $key = "num_ref{$range[0]}plus";
                $dateConditional = "< DATE_SUB(CURDATE(), INTERVAL {$range[0]} DAY)";
            }

            $counters[$key] = $this->getReferralCountersForContact(
                $contactId, $contactType, $dateConditional, $isDetailed
            );
        }

        return $counters;
    }
}
