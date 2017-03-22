<?php

namespace DentalSleepSolutions\Eloquent\Dental;

use Illuminate\Database\Eloquent\Model;
use DentalSleepSolutions\Eloquent\WithoutUpdatedTimestamp;
use DentalSleepSolutions\Contracts\Resources\ReferredByContact as Resource;
use DentalSleepSolutions\Contracts\Repositories\ReferredByContacts as Repository;

class ReferredByContact extends Model implements Resource, Repository
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
        'adddate', 'ip_address', 'referredby_info'
    ];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'dental_referredby';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'referredbyid';

    /**
     * The name of the "created at" column.
     *
     * @var string
     */
    const CREATED_AT = 'adddate';

    public function updateContact($contactId = 0, $data = [])
    {
        return $this->where('referredbyid', $contactId)
            ->update($data);
    }
}
