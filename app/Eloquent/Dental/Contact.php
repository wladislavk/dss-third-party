<?php

namespace DentalSleepSolutions\Eloquent\Dental;

use Illuminate\Database\Eloquent\Model;
use DentalSleepSolutions\Eloquent\WithoutUpdatedTimestamp;
use DentalSleepSolutions\Contracts\Resources\Contact as Resource;
use DentalSleepSolutions\Contracts\Repositories\Contacts as Repository;
use DB;

class Contact extends Model implements Resource, Repository
{
    use WithoutUpdatedTimestamp;

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

    public function getListContactsAndCompanies($docId, $partial, $names, $referredPhysician)
    {
        return $this->select(
                'c.contactid',
                'c.lastname',
                'c.firstname',
                'c.middlename',
                'c.company',
                DB::raw($referredPhysician . ' as referral_type'),
                'ct.contacttype'
            )->from(DB::raw('dental_contact c'))
            ->leftJoin(DB::raw('dental_contacttype ct'), 'c.contacttypeid', '=', 'ct.contacttypeid')
            ->where(function($query) use ($names, $partial) {
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
                })->orWhere('company', 'like', $partial . '%');
            })->whereNull('merge_id')
            ->where('c.status', 1)
            ->where('docid', $docId)
            ->orderBy('lastname')
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

    public function getActiveContact($contactId = 0)
    {
        return $this->where('contactid', $contactId)
            ->active()
            ->first();
    }

    public function getDocsleepShortInfo($contactId)
    {
        return $this->select('dc.lastname', 'dc.firstname', 'dct.contacttype')
            ->from(DB::raw('dental_contact dc'))
            ->leftJoin(DB::raw('dental_contacttype dct'), 'dct.contacttypeid', '=', 'dc.contacttypeid')
            ->where('contactid', $contactId)
            ->first();
    }

    public function getDocpcpShortInfo($contactId)
    {
        return $this->select('dc.lastname', 'dc.firstname', 'dc.middlename', 'dct.contacttype')
            ->from(DB::raw('dental_contact dc'))
            ->leftJoin(DB::raw('dental_contacttype dct'), 'dct.contacttypeid', '=', 'dc.contacttypeid')
            ->where('contactid', $contactId)
            ->first();
    }

    public function getDocdentistShortInfo($contactId)
    {
        return $this->select('dc.lastname', 'dc.firstname', 'dc.middlename', 'dct.contacttype')
            ->from(DB::raw('dental_contact dc'))
            ->leftJoin(DB::raw('dental_contacttype dct'), 'dct.contacttypeid', '=', 'dc.contacttypeid')
            ->where('contactid', $contactId)
            ->first();
    }

    public function getDocentShortInfo($contactId)
    {
        return $this->select('dc.lastname', 'dc.firstname', 'dc.middlename', 'dct.contacttype')
            ->from(DB::raw('dental_contact dc'))
            ->leftJoin(DB::raw('dental_contacttype dct'), 'dct.contacttypeid', '=', 'dc.contacttypeid')
            ->where('contactid', $contactId)
            ->first();
    }

    public function getDocmdotherShortInfo($contactId)
    {
        return $this->select('dc.lastname', 'dc.firstname', 'dc.middlename', 'dct.contacttype')
            ->from(DB::raw('dental_contact dc'))
            ->leftJoin(DB::raw('dental_contacttype dct'), 'dct.contacttypeid', '=', 'dc.contacttypeid')
            ->where('contactid', $contactId)
            ->first();
    }

    public function getDocmdother2ShortInfo($contactId)
    {
        return $this->select('dc.lastname', 'dc.firstname', 'dc.middlename', 'dct.contacttype')
            ->from(DB::raw('dental_contact dc'))
            ->leftJoin(DB::raw('dental_contacttype dct'), 'dct.contacttypeid', '=', 'dc.contacttypeid')
            ->where('contactid', $contactId)
            ->first();
    }

    public function getDocmdother3ShortInfo($contactId)
    {
        return $this->select('dc.lastname', 'dc.firstname', 'dc.middlename', 'dct.contacttype')
            ->from(DB::raw('dental_contact dc'))
            ->leftJoin(DB::raw('dental_contacttype dct'), 'dct.contacttypeid', '=', 'dc.contacttypeid')
            ->where('contactid', $contactId)
            ->first();
    }
}
