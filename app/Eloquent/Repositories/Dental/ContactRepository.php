<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\Contact;
use DentalSleepSolutions\Eloquent\Repositories\AbstractRepository;
use DentalSleepSolutions\Http\Controllers\ContactsController;
use DentalSleepSolutions\Temporary\PatientFormDataUpdater;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Database\Query\JoinClause;

class ContactRepository extends AbstractRepository
{
    public function model()
    {
        return Contact::class;
    }

    /**
     * @param int $docId
     * @return Builder
     */
    public function getListContactsAndCompaniesBaseQuery($docId)
    {
        $query = $this->model
            ->select(
                'c.contactid',
                'c.lastname',
                'c.firstname',
                'c.middlename',
                'c.company',
                \DB::raw(ContactsController::DSS_REFERRED_PHYSICIAN . ' AS referral_type'),
                'ct.contacttype'
            )
            ->from(\DB::raw('dental_contact c'))
            ->leftJoin(\DB::raw('dental_contacttype ct'), 'c.contacttypeid', '=', 'ct.contacttypeid')
            ->whereNull('merge_id')
            ->where('c.status', 1)
            ->where('docid', $docId)
            ->orderBy('lastname')
        ;
        return $query;
    }

    /**
     * @param Builder $query
     * @param string $partial
     * @return Builder
     */
    public function getContactQueryWithConditionsForNamesOnly(
        Builder $query,
        $partial
    ) {
        $names = explode(' ', $partial);
        $query
            ->where(function (Builder $query) use ($names) {
                $query
                    ->where($this->getLambdaForFirstAndLastName($names))
                    ->orWhere($this->getLambdaForFullName($names))
                ;
            })
            ->where('ct.physician', 1);
        ;
        return $query;
    }

    /**
     * @param Builder $query
     * @param string $partial
     * @return Builder
     */
    public function getContactQueryWithConditionsForNamesAndCompanies(
        Builder $query,
        $partial
    ) {
        $names = explode(' ', $partial);
        $query
            ->where(function (Builder $query) use ($names, $partial) {
                $query
                    ->where($this->getLambdaForFirstAndLastName($names))
                    ->orWhere($this->getLambdaForFullName($names))
                    ->orWhere('company', 'LIKE', $partial . '%');
                ;
            })
        ;
        return $query;
    }

    /**
     * @param array $names
     * @return \Closure
     */
    public function getLambdaForFirstAndLastName(array $names)
    {
        return function (Builder $query) use ($names) {
            $query
                ->where(function (Builder $query) use ($names) {
                    $query
                        ->where('lastname', 'LIKE', $names[0] . '%')
                        ->orWhere('firstname', 'LIKE', $names[0] . '%')
                    ;
                })
                ->where(function (Builder $query) use ($names) {
                    $firstName = '';
                    if (isset($names[1])) {
                        $firstName = $names[1];
                    }
                    $query
                        ->where('lastname', 'LIKE', $firstName . '%')
                        ->orWhere('firstname', 'LIKE', $firstName . '%')
                    ;
                })
            ;
        };
    }

    /**
     * @param array $names
     * @return \Closure
     */
    public function getLambdaForFullName(array $names)
    {
        return function (Builder $query) use ($names) {
            $firstName = '';
            if (isset($names[1])) {
                $firstName = $names[1];
            }
            $secondName = '';
            if (isset($names[2])) {
                $secondName = $names[2];
            }
            $query
                ->where('firstname', 'LIKE', $names[0] . '%')
                ->where('middlename', 'LIKE', $firstName . '%')
                ->where('lastname', 'LIKE', $secondName . '%')
            ;
        };
    }

    /**
     * @param int $contactId
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function getWithContactType($contactId)
    {
        return $this->model
            ->select('c.*', 'ct.contacttype')
            ->from(\DB::raw('dental_contact c'))
            ->leftJoin(\DB::raw('dental_contacttype ct'), 'ct.contacttypeid', '=', 'c.contacttypeid')
            ->where('c.contactid', $contactId)
            ->first()
        ;
    }

    /**
     * @param int $docId
     * @return array|\Illuminate\Database\Eloquent\Collection
     */
    public function getInsuranceContacts($docId)
    {
        return $this->model
            ->where('status', 1)
            ->whereNull('merge_id')
            ->where('contacttypeid', 11)
            ->where('docid', $docId)
            ->orderBy('company')
            ->get()
        ;
    }

    /**
     * @param int $docId
     * @param array $orderByColumns
     * @param string $sortDir
     * @return Contact[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getReferredByContacts($docId, array $orderByColumns, $sortDir)
    {
        $physicianContacts = $this->model
            ->select(
                'dc.contactid',
                'dc.salutation',
                'dc.firstname',
                'dc.middlename',
                'dc.lastname',
                'p.referred_source',
                'dc.referredby_notes',
                \DB::raw('COUNT(p.patientid) AS num_ref'),
                \DB::raw("GROUP_CONCAT(CONCAT(p.firstname, ' ', p.lastname)) AS patients_list"),
                \DB::raw(Contact::DSS_REFERRED_PHYSICIAN . ' AS referral_type'),
                'ct.contacttype'
            )
            ->from(\DB::raw('dental_contact dc'))
            ->join(\DB::raw('dental_contacttype ct'), 'ct.contacttypeid', '=', 'dc.contacttypeid')
            ->join(\DB::raw('dental_patients p'), 'dc.contactid', '=', 'p.referred_by')
            ->where('dc.docid', $docId)
            ->where('p.referred_source', Contact::DSS_REFERRED_PHYSICIAN)
            ->groupBy('dc.contactid')
        ;

        $patientContacts = $this->model
            ->select(
                'dp.patientid',
                'dp.salutation',
                'dp.firstname',
                'dp.middlename',
                'dp.lastname',
                'p.referred_source',
                \DB::raw("''"),
                \DB::raw('COUNT(p.patientid)'),
                \DB::raw("GROUP_CONCAT(CONCAT(p.firstname, ' ', p.lastname)) AS patients_list"),
                \DB::raw(Contact::DSS_REFERRED_PATIENT),
                \DB::raw("'Patient'")
            )
            ->from(\DB::raw('dental_patients dp'))
            ->join(\DB::raw('dental_patients p'), 'dp.patientid', '=', 'p.referred_by')
            ->where('p.docid', $docId)
            ->where('p.referred_source', Contact::DSS_REFERRED_PATIENT)
            ->groupBy('dp.patientid')
        ;

        $resultSql = $physicianContacts->union($patientContacts);

        foreach ($orderByColumns as $column) {
            $resultSql = $resultSql->orderBy($column, $sortDir);
        }

        return $resultSql->get();
    }

    /**
     * @param int $page
     * @param int $rowsPerPage
     * @param array $orderByColumns
     * @param string $sortDir
     * @return array
     */
    public function getCorporate($page, $rowsPerPage, array $orderByColumns, $sortDir)
    {
        $query = $this->model
            ->select('c.*', 'ct.contacttype')
            ->from(\DB::raw('dental_contact c'))
            ->leftJoin(\DB::raw('dental_contacttype ct'), 'ct.contacttypeid', '=', 'c.contacttypeid')
            ->where('c.corporate', 1)
        ;

        $totalNumber = $query->count();
        foreach ($orderByColumns as $column) {
            $query = $query->orderBy($column, $sortDir);
        }
        $resultQuery = $query
            ->skip($page * $rowsPerPage)
            ->take($rowsPerPage)
        ;

        return [
            'total' => $totalNumber,
            'result' => $resultQuery->get(),
        ];
    }

    /**
     * @param int $docId
     * @param int $status
     * @return Builder|QueryBuilder
     */
    public function getFindContactBaseQuery($docId, $status)
    {
        $query = $this->model
            ->select(
                'dc.*',
                'dct.contacttype',
                \DB::raw('COUNT(DISTINCT dp_ref.patientid) AS referrers'),
                \DB::raw('COUNT(DISTINCT dp_pat.patientid) AS patients')
            )
            ->from(\DB::raw('dental_contact dc'))
            ->leftJoin(\DB::raw('dental_contacttype dct'), 'dct.contacttypeid', '=', 'dc.contacttypeid')
            ->leftJoin(\DB::raw('dental_patients dp_ref'), function (JoinClause $join) {
                $join
                    ->on('dp_ref.referred_by', '=', 'dc.contactid')
                    ->where(function (JoinClause $query) {
                        $query
                            ->whereNull('dp_ref.parent_patientid')
                            ->orWhere('dp_ref.parent_patientid', '=', '')
                        ;
                    })
                    ->where('dp_ref.referred_source', '=', 2)
                ;
            })
            ->leftJoin(\DB::raw('dental_patients dp_pat'), function (JoinClause $join) {
                $join
                    ->on(function (JoinClause $query) {
                        $query
                            ->whereNull('dp_pat.parent_patientid')
                            ->orWhere('dp_pat.parent_patientid', '=', '');
                    })
                    ->where(function (JoinClause $join) {
                        $docFields = PatientFormDataUpdater::DOC_FIELDS;
                        $firstId = array_shift($docFields);
                        $join = $join->on('dp_pat.' . $firstId, '=', 'dc.contactid');
                        foreach ($docFields as $docField) {
                            $join = $join->orOn('dp_pat.' . $docField, '=', 'dc.contactid');
                        }
                    })
                ;
            })
            ->where('dc.docid', $docId)
            ->whereNull('merge_id')
            ->where('dc.status', $status)
            ->groupBy('dc.contactid');
        return $query;
    }

    /**
     * @param Builder $query
     * @param string $letter
     * @return Builder|QueryBuilder
     */
    public function getContactQueryWhereLastNameOrCompanyLikeLetter(Builder $query, $letter)
    {
        return $query->where(function (Builder $query) use ($letter) {
            $query
                ->where('dc.lastname', 'LIKE', $letter . '%')
                ->orWhere(function (Builder $query) use ($letter) {
                    $query
                        ->where('dc.lastname', '')
                        ->where('dc.company', 'LIKE', $letter . '%')
                    ;
                })
            ;
        });
    }

    /**
     * @param Builder $query
     * @param int $contactTypeId
     * @return Builder
     */
    public function getContactQueryWhereContactTypeId(Builder $query, $contactTypeId)
    {
        return $query->where('dct.contacttypeid', $contactTypeId);
    }

    /**
     * @param Builder $query
     * @param string $column
     * @param string $direction
     * @return Builder
     */
    public function getContactQueryOrderByColumnAndDirection(Builder $query, $column, $direction)
    {
        return $query->orderBy($column, $direction);
    }

    /**
     * @param Builder $query
     * @param string $column
     * @param string $sortDir
     * @return Builder
     */
    public function getContactQueryOrderByColumnOrNull(Builder $query, $column, $sortDir)
    {
        return $query->orderBy(\DB::raw("IF ($column = '' OR $column IS NULL, 1, 0)"), $sortDir);
    }

    /**
     * @param int $contactId
     * @return Contact|null
     */
    public function getDocShortInfo($contactId)
    {
        return $this->model
            ->select('dc.lastname', 'dc.firstname', 'dc.middlename', 'dct.contacttype')
            ->from(\DB::raw('dental_contact dc'))
            ->leftJoin(\DB::raw('dental_contacttype dct'), 'dct.contacttypeid', '=', 'dc.contacttypeid')
            ->where('contactid', $contactId)
            ->first()
        ;
    }

    /**
     * @param int $letterId
     * @param string $mdList
     * @return array|\Illuminate\Database\Eloquent\Collection|Contact[]
     */
    public function getContactInfo($letterId, $mdList)
    {
        return $this->model
            ->select(
                'dental_contact.contactid AS id',
                'dental_contact.salutation',
                'dental_contact.firstname',
                'dental_contact.lastname',
                'dental_contact.middlename',
                'dental_contact.company',
                'dental_contact.add1',
                'dental_contact.add2',
                'dental_contact.city',
                'dental_contact.state',
                'dental_contact.zip',
                'dental_contact.email',
                'dental_contact.fax',
                'dental_contact.preferredcontact',
                'dental_contacttype.contacttype',
                'dental_contact.contacttypeid',
                'dental_contact.status',
                \DB::raw($letterId . ' AS letterid')
            )
            ->leftJoin('dental_contacttype', 'dental_contact.contacttypeid', '=', 'dental_contacttype.contacttypeid')
            ->whereIn('dental_contact.contactid', $mdList)
            ->get()
        ;
    }

    /**
     * @param int $contactId
     * @return Contact|null
     */
    public function getActiveContact($contactId)
    {
        return $this->model
            ->where('contactid', $contactId)
            ->where('status', 1)
            ->first()
        ;
    }

    public function getReferralIds($patientId)
    {
        $contactSql = $this->model
            ->from('dental_contact')
            ->join('dental_patients', 'dental_contact.contactid', '=', 'dental_patients.referred_by')
            ->join('dental_contacttype', 'dental_contacttype.contacttypeid', '=', 'dental_contact.contacttypeid')
            ->where('dental_patients.patientid', $patientId)
            ->where('dental_patients.referred_source', '2')
            ->where('dental_contacttype.physician', 1)
            ->groupBy('dental_contact.contactid')
            ->orderBy('dental_contact.contactid')
        ;
        return $contactSql->get();
    }
}
