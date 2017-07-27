<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\Contact;
use DentalSleepSolutions\Eloquent\Repositories\AbstractRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\JoinClause;

class ContactRepository extends AbstractRepository
{
    public function model()
    {
        return Contact::class;
    }

    /**
     * @param int $docId
     * @param string $partial
     * @param array $names
     * @param int $referredPhysician
     * @param bool $searchForCompanies
     * @return mixed
     */
    public function getListContactsAndCompanies(
        $docId,
        $partial,
        array $names,
        $referredPhysician,
        $searchForCompanies = true
    ) {
        $query = $this->model->select(
            'c.contactid',
            'c.lastname',
            'c.firstname',
            'c.middlename',
            'c.company',
            \DB::raw($referredPhysician . ' as referral_type'),
            'ct.contacttype'
        )->from(\DB::raw('dental_contact c'))
            ->leftJoin(\DB::raw('dental_contacttype ct'), 'c.contacttypeid', '=', 'ct.contacttypeid')
            ->where(function(Builder $query) use ($names, $partial, $searchForCompanies) {
                $query->where(function(Builder $query) use ($names, $partial) {
                    $query->where(function(Builder $query) use ($names) {
                        $query->where('lastname', 'like', $names[0] . '%')
                            ->orWhere('firstname', 'like', $names[0] . '%');
                    })->where(function(Builder $query) use ($names) {
                        $query->where('lastname', 'like', (!empty($names[1]) ? $names[1] : '') . '%')
                            ->orWhere('firstname', 'like', (!empty($names[1]) ? $names[1] : '') . '%');
                    });
                })->orWhere(function(Builder $query) use ($names) {
                    $query->where('firstname', 'like', $names[0] . '%')
                        ->where('middlename', 'like', (!empty($names[1]) ? $names[1] : '') . '%')
                        ->where('lastname', 'like', (!empty($names[2]) ? $names[2] : '') . '%');
                });

                if ($searchForCompanies) {
                    $query = $query->orWhere('company', 'like', $partial . '%');
                }
            })->whereNull('merge_id')
            ->where('c.status', 1)
            ->where('docid', $docId)
        ;

        if (!$searchForCompanies) {
            $query = $query->where('ct.physician', 1);
        }

        return $query->orderBy('lastname')->get();
    }

    /**
     * @param int $contactId
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function getWithContactType($contactId)
    {
        return $this->model->select('c.*', 'ct.contacttype')
            ->from(\DB::raw('dental_contact c'))
            ->leftJoin(\DB::raw('dental_contacttype ct'), 'ct.contacttypeid', '=', 'c.contacttypeid')
            ->where('c.contactid', $contactId)
            ->first();
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
            ->get();
    }

    /**
     * @param int $docId
     * @param string $sort
     * @param string $sortDir
     * @return array|\Illuminate\Database\Eloquent\Collection
     */
    public function getReferredByContacts($docId, $sort, $sortDir = 'asc')
    {
        $physicianContacts = $this->model->select(
            'dc.contactid',
            'dc.salutation',
            'dc.firstname',
            'dc.middlename',
            'dc.lastname',
            'p.referred_source',
            'dc.referredby_notes',
            \DB::raw('COUNT(p.patientid) AS num_ref'),
            \DB::raw("GROUP_CONCAT(CONCAT(p.firstname, ' ', p.lastname)) AS patients_list"),
            \DB::raw(Contact::DSS_REFERRED_PHYSICIAN . ' as referral_type'),
            'ct.contacttype'
        )->from(\DB::raw('dental_contact dc'))
            ->join(\DB::raw('dental_contacttype ct'), 'ct.contacttypeid', '=', 'dc.contacttypeid')
            ->join(\DB::raw('dental_patients p'), 'dc.contactid', '=', 'p.referred_by')
            ->where('dc.docid', $docId)
            ->where('p.referred_source', Contact::DSS_REFERRED_PHYSICIAN)
            ->groupBy('dc.contactid');

        $patientContacts = $this->model->select(
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
        )->from(\DB::raw('dental_patients dp'))
            ->join(\DB::raw('dental_patients p'), 'dp.patientid', '=', 'p.referred_by')
            ->where('p.docid', $docId)
            ->where('p.referred_source', Contact::DSS_REFERRED_PATIENT)
            ->groupBy('dp.patientid');

        $resultSql = $physicianContacts->union($patientContacts);

        if (!empty($sort)) {
            switch ($sort) {
                case 'contacttype':
                    $resultSql = $resultSql->orderBy('contacttype', $sortDir);
                    break;

                case 'total':
                    $resultSql = $resultSql->orderBy('num_ref', $sortDir);
                    break;

                case 'name':
                    $resultSql = $resultSql->orderBy('lastname', $sortDir)
                        ->orderBy('firstname', $sortDir);
                    break;
            }
        }

        return $resultSql->get();
    }

    /**
     * @param int $page
     * @param int $rowsPerPage
     * @param string $sort
     * @param string $sortDir
     * @return array
     */
    public function getCorporate($page, $rowsPerPage, $sort, $sortDir = 'asc')
    {
        $query = $this->model->select('c.*', 'ct.contacttype')
            ->from(\DB::raw('dental_contact c'))
            ->leftJoin(\DB::raw('dental_contacttype ct'), 'ct.contacttypeid', '=', 'c.contacttypeid')
            ->where('c.corporate', 1);

        $totalNumber = $query->count();

        if (!empty($sort)) {
            switch ($sort) {
                case 'company':
                    $query = $query->orderBy('company');
                    break;

                case 'type':
                    $query = $query->orderBy('ct.contacttype', $sortDir);
                    break;

                default:
                    $query = $query->orderBy('lastname', $sortDir)
                        ->orderBy('firstname', $sortDir);
                    break;
            }
        }

        $resultQuery = $query->skip($page * $rowsPerPage)
            ->take($rowsPerPage);

        return [
            'total'  => $totalNumber,
            'result' => $resultQuery->get(),
        ];
    }

    /**
     * @param int $contactType
     * @param int $status
     * @param int $docId
     * @param string $letter
     * @param string $sortBy
     * @param string $sortDir
     * @param int $page
     * @param int $contactsPerPage
     * @return array
     */
    public function findContact(
        $contactType     = 0,
        $status          = 0,
        $docId           = 0,
        $letter          = '',
        $sortBy          = '',
        $sortDir         = '',
        $page            = 0,
        $contactsPerPage = 0
    ) {
        $contacts = $this->model->select(
            'dc.*',
            'dct.contacttype',
            \DB::raw('COUNT(distinct dp_ref.patientid) as referrers'),
            \DB::raw('COUNT(distinct dp_pat.patientid) as patients')
        )
            ->from(\DB::raw('dental_contact dc'))
            ->leftJoin(\DB::raw('dental_contacttype dct'), 'dct.contacttypeid', '=', 'dc.contacttypeid')
            ->leftJoin(\DB::raw('dental_patients dp_ref'), function(JoinClause $join) {
                $join->on('dp_ref.referred_by', '=', 'dc.contactid')
                    ->where(function(JoinClause $query) {
                        $query->whereNull('dp_ref.parent_patientid')
                            ->orWhere('dp_ref.parent_patientid', '=', '');
                    })
                    ->where('dp_ref.referred_source', '=', 2);
            })
            ->leftJoin(\DB::raw('dental_patients dp_pat'), function(JoinClause $join) {
                $join->on(function(JoinClause $query) {
                    $query->whereNull('dp_pat.parent_patientid')
                        ->orWhere('dp_pat.parent_patientid', '=', '');
                })->where(function(JoinClause $join) {
                    $join->on('dp_pat.docpcp', '=', 'dc.contactid')
                        ->orOn('dp_pat.docent', '=', 'dc.contactid')
                        ->orOn('dp_pat.docsleep', '=', 'dc.contactid')
                        ->orOn('dp_pat.docdentist', '=', 'dc.contactid')
                        ->orOn('dp_pat.docmdother', '=', 'dc.contactid')
                        ->orOn('dp_pat.docmdother2', '=', 'dc.contactid')
                        ->orOn('dp_pat.docmdother3', '=', 'dc.contactid');
                });
            })
            ->where('dc.docid', $docId)
            ->whereNull('merge_id');

        if ($contactType) {
            $contacts = $contacts->where('dct.contacttypeid', $contactType)
                ->where('dc.status', 1);
        } elseif ($status) {
            $contacts = $contacts->where('dc.status', $status);
        } else {
            $contacts = $contacts->where('dc.status', 1);
        }

        if ($letter) {
            $contacts = $contacts->where(function(Builder $query) use ($letter) {
                $query->where('dc.lastname', 'like', $letter . '%')
                    ->orWhere(function(Builder $query) use ($letter) {
                        $query->where('dc.lastname', '')
                            ->where('dc.company', 'like', $letter . '%');
                    });
            });
        }

        $contacts = $contacts->groupBy('dc.contactid');

        if ($sortBy) {
            switch ($sortBy) {
                case 'company':
                    $contacts = $contacts->orderBy(\DB::raw("IF (company = '' OR company IS NULL, 1, 0)"), $sortDir)
                        ->orderBy('company', $sortDir)
                        ->orderBy('dc.lastname', 'asc')
                        ->orderBy('firstname', 'asc')
                        ->orderBy('dct.contacttype', 'asc');
                    break;

                case 'type':
                    $contacts = $contacts->orderBy(DB::raw("IF (dct.contacttype = '' OR dct.contacttype IS NULL, 1, 0)"), $sortDir)
                        ->orderBy('dct.contacttype', $sortDir)
                        ->orderBy('dc.lastname', 'asc')
                        ->orderBy('firstname', 'asc')
                        ->orderBy('company', 'asc');
                    break;

                default:
                    $contacts = $contacts->orderBy(\DB::raw("IF (dc.lastname = '' OR dc.lastname IS NULL, 1, 0)"), $sortDir)
                        ->orderBy('dc.lastname', $sortDir)
                        ->orderBy('firstname', $sortDir)
                        ->orderBy('company', 'asc')
                        ->orderBy('dct.contacttype', 'asc');
                    break;
            }
        }

        $contacts = $contacts->get()->toArray();
        $totalCount = count($contacts);
        $contacts = array_splice($contacts, $page * $contactsPerPage, $contactsPerPage);

        return [
            'totalCount' => $totalCount,
            'result'     => $contacts,
        ];
    }

    /**
     * @param int $contactId
     * @return Contact|null
     */
    public function getDocShortInfo($contactId)
    {
        return $this->model->select('dc.lastname', 'dc.firstname', 'dc.middlename', 'dct.contacttype')
            ->from(\DB::raw('dental_contact dc'))
            ->leftJoin(\DB::raw('dental_contacttype dct'), 'dct.contacttypeid', '=', 'dc.contacttypeid')
            ->where('contactid', $contactId)
            ->first();
    }

    /**
     * @param int $letterId
     * @param string $mdList
     * @return array|\Illuminate\Database\Eloquent\Collection|Contact[]
     */
    public function getContactInfo($letterId, $mdList)
    {
        return $this->model->select(
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
            \DB::raw($letterId . ' AS letterid'),
            'dental_contact.status'
        )->leftJoin('dental_contacttype', 'dental_contact.contacttypeid', '=', 'dental_contacttype.contacttypeid')
            ->whereIn('dental_contact.contactid', $mdList)
            ->get();
    }

    /**
     * @param int $contactId
     * @return Contact|null
     */
    public function getActiveContact($contactId)
    {
        return $this->model->where('contactid', $contactId)
            ->where('status', 1)
            ->first();
    }
}
