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
        $contacts = $this->from(DB::raw('dental_contact dc'))
            ->leftJoin(DB::raw('dental_contacttype dct'), 'dct.contacttypeid', '=', 'dc.contacttypeid')
            ->where('docid', $docId)
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

        if ($sortBy) {
            switch ($sortBy) {
                case 'company':
                    $contacts = $contacts->orderBy(DB::raw("IF (company = '' OR company IS NULL, 1, 0)"), $sortDir)
                        ->orderBy('company', $sortDir)
                        ->orderBy('lastname', 'asc')
                        ->orderBy('firstname', 'asc')
                        ->orderBy('dct.contacttype', 'asc');
                    break;

                case 'type':
                    $contacts = $contacts->orderBy(DB::raw("IF (dct.contacttype = '' OR dct.contacttype IS NULL, 1, 0)"), $sortDir)
                        ->orderBy('dct.contacttype', $sortDir)
                        ->orderBy('lastname', 'asc')
                        ->orderBy('firstname', 'asc')
                        ->orderBy('company', 'asc');
                    break;

                default:
                    $contacts = $contacts->orderBy(DB::raw("IF (lastname = '' OR lastname IS NULL, 1, 0)"), $sortDir)
                        ->orderBy('dct.contacttype', 'asc')
                        ->orderBy('lastname', $sortDir)
                        ->orderBy('firstname', $sortDir)
                        ->orderBy('company', 'asc');
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
