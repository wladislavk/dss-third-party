<?php

namespace DentalSleepSolutions\Eloquent\Models\Dental;

use DentalSleepSolutions\Eloquent\Models\AbstractModel;
use DentalSleepSolutions\Eloquent\Traits\WithoutUpdatedTimestamp;
use DentalSleepSolutions\Contracts\Resources\Resource;
use DB;

/**
 * @SWG\Definition(
 *     definition="Contact",
 *     type="object",
 *     required={"contactid", "preferredcontact"},
 *     @SWG\Property(property="contactid", type="integer"),
 *     @SWG\Property(property="docid", type="integer"),
 *     @SWG\Property(property="salutation", type="string"),
 *     @SWG\Property(property="lastname", type="string"),
 *     @SWG\Property(property="firstname", type="string"),
 *     @SWG\Property(property="middlename", type="string"),
 *     @SWG\Property(property="company", type="string"),
 *     @SWG\Property(property="add1", type="string"),
 *     @SWG\Property(property="add2", type="string"),
 *     @SWG\Property(property="city", type="string"),
 *     @SWG\Property(property="state", type="string"),
 *     @SWG\Property(property="zip", type="string"),
 *     @SWG\Property(property="phone1", type="string"),
 *     @SWG\Property(property="phone2", type="string"),
 *     @SWG\Property(property="fax", type="string"),
 *     @SWG\Property(property="email", type="string"),
 *     @SWG\Property(property="national_provider_id", type="string"),
 *     @SWG\Property(property="qualifier", type="string"),
 *     @SWG\Property(property="qualifierid", type="string"),
 *     @SWG\Property(property="greeting", type="string"),
 *     @SWG\Property(property="sincerely", type="string"),
 *     @SWG\Property(property="contacttypeid", type="integer"),
 *     @SWG\Property(property="notes", type="string"),
 *     @SWG\Property(property="preferredcontact", type="string"),
 *     @SWG\Property(property="status", type="integer"),
 *     @SWG\Property(property="adddate", type="string", format="dateTime"),
 *     @SWG\Property(property="ip_address", type="string"),
 *     @SWG\Property(property="referredby_info", type="integer"),
 *     @SWG\Property(property="referredby_notes", type="string"),
 *     @SWG\Property(property="merge_id", type="integer"),
 *     @SWG\Property(property="merge_date", type="string"),
 *     @SWG\Property(property="corporate", type="integer")
 * )
 *
 * DentalSleepSolutions\Eloquent\Dental\Contact
 *
 * @property int $contactid
 * @property int|null $docid
 * @property string|null $salutation
 * @property string|null $lastname
 * @property string|null $firstname
 * @property string|null $middlename
 * @property string|null $company
 * @property string|null $add1
 * @property string|null $add2
 * @property string|null $city
 * @property string|null $state
 * @property string|null $zip
 * @property string|null $phone1
 * @property string|null $phone2
 * @property string|null $fax
 * @property string|null $email
 * @property string|null $national_provider_id
 * @property string|null $qualifier
 * @property string|null $qualifierid
 * @property string|null $greeting
 * @property string|null $sincerely
 * @property int|null $contacttypeid
 * @property string|null $notes
 * @property string $preferredcontact
 * @property int|null $status
 * @property \Carbon\Carbon|null $adddate
 * @property string|null $ip_address
 * @property int|null $referredby_info
 * @property string|null $referredby_notes
 * @property int|null $merge_id
 * @property string|null $merge_date
 * @property int|null $corporate
 * @mixin \Eloquent
 */
class Contact extends AbstractModel implements Resource
{
    use WithoutUpdatedTimestamp;

    const DSS_REFERRED_PATIENT = 1;
    const DSS_REFERRED_PHYSICIAN = 2;

    /**
     * Mass assignable attributes
     *
     * @var array
     */
    protected $fillable = [
        'docid', 'salutation', 'lastname', 'firstname',
        'middlename', 'company', 'add1', 'add2',
        'city', 'state', 'zip', 'phone1',
        'phone2', 'fax', 'email', 'national_provider_id',
        'qualifier', 'qualifierid', 'greeting', 'sincerely',
        'contacttypeid', 'notes', 'preferredcontact', 'status',
        'adddate', 'ip_address', 'referredby_info', 'referredby_notes',
        'merge_id', 'merge_date', 'corporate', 'dea_number'
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'dental_contact';

    /**
     * Primary key for the table
     *
     * @var string
     */
    protected $primaryKey = 'contactid';

    /**
     * The name of the "created at" column.
     *
     * @var string
     */
    const CREATED_AT = 'adddate';

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    public function find(
        $contactType     = 0,
        $status          = 0,
        $docId           = 0,
        $letter          = '',
        $sortBy          = '',
        $sortDir         = '',
        $page            = 0,
        $contactsPerPage = 0
    ) {
        $contacts = $this->select(
                'dc.*',
                'dct.contacttype',
                DB::raw('COUNT(distinct dp_ref.patientid) as referrers'),
                DB::raw('COUNT(distinct dp_pat.patientid) as patients')
            )
            ->from(DB::raw('dental_contact dc'))
            ->leftJoin(DB::raw('dental_contacttype dct'), 'dct.contacttypeid', '=', 'dc.contacttypeid')
            ->leftJoin(DB::raw('dental_patients dp_ref'), function($join) {
                $join->on('dp_ref.referred_by', '=', 'dc.contactid')
                    ->where(function($query) {
                        $query->whereNull('dp_ref.parent_patientid')
                            ->orWhere('dp_ref.parent_patientid', '=', '');
                    })
                    ->where('dp_ref.referred_source', '=', 2);
            })
            ->leftJoin(DB::raw('dental_patients dp_pat'), function($join) {
                $join->on(function($query) {
                        $query->whereNull('dp_pat.parent_patientid')
                            ->orWhere('dp_pat.parent_patientid', '=', '');
                    })->where(function($query) {
                        $query->on('dp_pat.docpcp', '=', 'dc.contactid')
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
            $contacts = $contacts->where(function($query) use ($letter) {
                $query->where('dc.lastname', 'like', $letter . '%')
                    ->orWhere(function($query) use ($letter) {
                        $query->where('dc.lastname', '')
                            ->where('dc.company', 'like', $letter . '%');
                    });
            });
        }

        $contacts = $contacts->groupBy('dc.contactid');

        if ($sortBy) {
            switch ($sortBy) {
                case 'company':
                    $contacts = $contacts->orderBy(DB::raw("IF (company = '' OR company IS NULL, 1, 0)"), $sortDir)
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
                    $contacts = $contacts->orderBy(DB::raw("IF (dc.lastname = '' OR dc.lastname IS NULL, 1, 0)"), $sortDir)
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
            'result'     => $contacts
        ];
    }

    public function getListContactsAndCompanies($docId, $partial, $names, $referredPhysician, $searchForCompanies = true)
    {
        $query = $this->select(
                'c.contactid',
                'c.lastname',
                'c.firstname',
                'c.middlename',
                'c.company',
                DB::raw($referredPhysician . ' as referral_type'),
                'ct.contacttype'
            )->from(DB::raw('dental_contact c'))
            ->leftJoin(DB::raw('dental_contacttype ct'), 'c.contacttypeid', '=', 'ct.contacttypeid')
            ->where(function($query) use ($names, $partial, $searchForCompanies) {
                $query->where(function($query) use ($names, $partial) {
                    $query->where(function($query) use ($names) {
                        $query->where('lastname', 'like', $names[0] . '%')
                            ->orWhere('firstname', 'like', $names[0] . '%');
                    })->where(function($query) use ($names) {
                        $query->where('lastname', 'like', (!empty($names[1]) ? $names[1] : '') . '%')
                            ->orWhere('firstname', 'like', (!empty($names[1]) ? $names[1] : '') . '%');
                    });
                })->orWhere(function($query) use ($names) {
                    $query->where('firstname', 'like', $names[0] . '%')
                        ->where('middlename', 'like', (!empty($names[1]) ? $names[1] : '') . '%')
                        ->where('lastname', 'like', (!empty($names[2]) ? $names[2] : '') . '%');
                });

                if ($searchForCompanies) {
                    $query = $query->orWhere('company', 'like', $partial . '%');
                }
            })->whereNull('merge_id')
            ->where('c.status', 1)
            ->where('docid', $docId);

        if (!$searchForCompanies) {
            $query = $query->where('ct.physician', 1);
        }

        return $query->orderBy('lastname')
            ->get();
    }

    public function getWithContactType($contactId = 0)
    {
        return $this->select('c.*', 'ct.contacttype')
            ->from(DB::raw('dental_contact c'))
            ->leftJoin(DB::raw('dental_contacttype ct'), 'ct.contacttypeid', '=', 'c.contacttypeid')
            ->where('c.contactid', $contactId)
            ->first();
    }

    public function getMdContactIds($patientId = 0, $currentPatient, $active = true)
    {
        $requiredFields = [
            'docsleep', 'docpcp', 'docdentist', 'docent',
            'docmdother', 'docmdother2', 'docmdother3'
        ];

        $currentPatient = $currentPatient->toArray();
        $contactIds = [];

        foreach ($requiredFields as $field) {
            if ($currentPatient[$field] != 'Not Set') {
                $contacts = explode(',', $currentPatient[$field]);

                foreach ($contacts as $contact) {
                    if (!in_array($contact, $contactIds)) {
                        if ($active) {
                            $contactStatus = $this->select('status')
                                ->where('contactid', $contact)
                                ->first();

                            if ($contactStatus && $contactStatus->status == 1) {
                                $contactIds[] = $contact;
                            }
                        } else {
                            $contactIds[] = $contact;
                        }
                    }
                }
            }
        }

        return implode(',', $contactIds);
    }

    /**
     * @param int $contactId
     * @return Contact|null
     */
    public function getActiveContact($contactId = 0)
    {
        return $this->where('contactid', $contactId)
            ->active()
            ->first();
    }

    public function getDocShortInfo($contactId)
    {
        return $this->select('dc.lastname', 'dc.firstname', 'dc.middlename', 'dct.contacttype')
            ->from(DB::raw('dental_contact dc'))
            ->leftJoin(DB::raw('dental_contacttype dct'), 'dct.contacttypeid', '=', 'dc.contacttypeid')
            ->where('contactid', $contactId)
            ->first();
    }

    public function getInsuranceContacts($docId)
    {
        return $this->active()
            ->whereNull('merge_id')
            ->where('contacttypeid', 11)
            ->where('docid', $docId)
            ->orderBy('company')
            ->get();
    }

    /**
     * @param $letterId
     * @param $mdList
     * @return array|\Illuminate\Database\Eloquent\Collection|Contact[]
     */
    public function getContactInfo($letterId, $mdList)
    {
        return $this->select(
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
                DB::raw($letterId . ' AS letterid'),
                'dental_contact.status'
            )->leftJoin('dental_contacttype', 'dental_contact.contacttypeid', '=', 'dental_contacttype.contacttypeid')
            ->whereIn('dental_contact.contactid', $mdList)
            ->get();
    }

    /**
     * @param $docId
     * @param $sort
     * @param string $sortDir
     * @return array|\Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getReferredByContacts($docId, $sort, $sortDir = 'asc')
    {
        $physicianContacts = $this->select(
                'dc.contactid',
                'dc.salutation',
                'dc.firstname',
                'dc.middlename',
                'dc.lastname',
                'p.referred_source',
                'dc.referredby_notes',
                DB::raw('COUNT(p.patientid) AS num_ref'),
                DB::raw("GROUP_CONCAT(CONCAT(p.firstname, ' ', p.lastname)) AS patients_list"),
                DB::raw(self::DSS_REFERRED_PHYSICIAN . ' as referral_type'),
                'ct.contacttype'
            )->from(DB::raw('dental_contact dc'))
            ->join(DB::raw('dental_contacttype ct'), 'ct.contacttypeid', '=', 'dc.contacttypeid')
            ->join(DB::raw('dental_patients p'), 'dc.contactid', '=', 'p.referred_by')
            ->where('dc.docid', $docId)
            ->where('p.referred_source', self::DSS_REFERRED_PHYSICIAN)
            ->groupBy('dc.contactid');

        $patientContacts = $this->select(
                'dp.patientid',
                'dp.salutation',
                'dp.firstname',
                'dp.middlename',
                'dp.lastname',
                'p.referred_source',
                DB::raw("''"),
                DB::raw('COUNT(p.patientid)'),
                DB::raw("GROUP_CONCAT(CONCAT(p.firstname, ' ', p.lastname)) AS patients_list"),
                DB::raw(self::DSS_REFERRED_PATIENT),
                DB::raw("'Patient'")
            )->from(DB::raw('dental_patients dp'))
            ->join(DB::raw('dental_patients p'), 'dp.patientid', '=', 'p.referred_by')
            ->where('p.docid', $docId)
            ->where('p.referred_source', self::DSS_REFERRED_PATIENT)
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

    public function getCorporate($page, $rowsPerPage, $sort, $sortDir = 'asc')
    {
        $query = $this->select('c.*', 'ct.contacttype')
            ->from(DB::raw('dental_contact c'))
            ->leftJoin(DB::raw('dental_contacttype ct'), 'ct.contacttypeid', '=', 'c.contacttypeid')
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
            'result' => $resultQuery->get()
        ];
    }
}
