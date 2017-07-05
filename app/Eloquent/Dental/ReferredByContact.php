<?php

namespace DentalSleepSolutions\Eloquent\Dental;

use DentalSleepSolutions\Eloquent\AbstractModel;
use DentalSleepSolutions\EloquentTraits\WithoutUpdatedTimestamp;
use DentalSleepSolutions\Contracts\Resources\ReferredByContact as Resource;
use DentalSleepSolutions\Contracts\Repositories\ReferredByContacts as Repository;

/**
 * DentalSleepSolutions\Eloquent\Dental\ReferredByContact
 *
 * @property int $referredbyid
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
 * @property int|null $status
 * @property \Carbon\Carbon|null $adddate
 * @property string|null $ip_address
 * @property string|null $preferredcontact
 * @property int|null $referredby_info
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\ReferredByContact whereAdd1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\ReferredByContact whereAdd2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\ReferredByContact whereAdddate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\ReferredByContact whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\ReferredByContact whereCompany($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\ReferredByContact whereContacttypeid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\ReferredByContact whereDocid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\ReferredByContact whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\ReferredByContact whereFax($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\ReferredByContact whereFirstname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\ReferredByContact whereGreeting($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\ReferredByContact whereIpAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\ReferredByContact whereLastname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\ReferredByContact whereMiddlename($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\ReferredByContact whereNationalProviderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\ReferredByContact whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\ReferredByContact wherePhone1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\ReferredByContact wherePhone2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\ReferredByContact wherePreferredcontact($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\ReferredByContact whereQualifier($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\ReferredByContact whereQualifierid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\ReferredByContact whereReferredbyInfo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\ReferredByContact whereReferredbyid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\ReferredByContact whereSalutation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\ReferredByContact whereSincerely($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\ReferredByContact whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\ReferredByContact whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\ReferredByContact whereZip($value)
 * @mixin \Eloquent
 */
class ReferredByContact extends AbstractModel implements Resource, Repository
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
