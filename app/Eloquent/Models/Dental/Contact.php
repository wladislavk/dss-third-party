<?php

namespace DentalSleepSolutions\Eloquent\Models\Dental;

use DentalSleepSolutions\Eloquent\Models\AbstractModel;
use DentalSleepSolutions\Eloquent\Traits\WithoutUpdatedTimestamp;

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
class Contact extends AbstractModel
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
        'docid',
        'salutation',
        'lastname',
        'firstname',
        'middlename',
        'company',
        'add1',
        'add2',
        'city',
        'state',
        'zip',
        'phone1',
        'phone2',
        'fax',
        'email',
        'national_provider_id',
        'qualifier',
        'qualifierid',
        'greeting',
        'sincerely',
        'contacttypeid',
        'notes',
        'preferredcontact',
        'status',
        'adddate',
        'ip_address',
        'referredby_info',
        'referredby_notes',
        'merge_id',
        'merge_date',
        'corporate',
        'dea_number',
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

    const CREATED_AT = 'adddate';

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }
}
