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
}
