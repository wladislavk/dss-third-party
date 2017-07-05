<?php

namespace DentalSleepSolutions\Eloquent\Dental;

use DentalSleepSolutions\Eloquent\AbstractModel;
use DentalSleepSolutions\EloquentTraits\WithoutUpdatedTimestamp;
use DentalSleepSolutions\Contracts\Resources\CorporateContact as Resource;
use DentalSleepSolutions\Contracts\Repositories\CorporateContacts as Repository;

/**
 * DentalSleepSolutions\Eloquent\Dental\CorporateContact
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
 * @property string|null $greeting
 * @property string|null $sincerely
 * @property int|null $contacttypeid
 * @property string|null $notes
 * @property \Carbon\Carbon|null $adddate
 * @property string|null $ip_address
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\CorporateContact whereAdd1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\CorporateContact whereAdd2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\CorporateContact whereAdddate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\CorporateContact whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\CorporateContact whereCompany($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\CorporateContact whereContactid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\CorporateContact whereContacttypeid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\CorporateContact whereDocid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\CorporateContact whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\CorporateContact whereFax($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\CorporateContact whereFirstname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\CorporateContact whereGreeting($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\CorporateContact whereIpAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\CorporateContact whereLastname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\CorporateContact whereMiddlename($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\CorporateContact whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\CorporateContact wherePhone1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\CorporateContact wherePhone2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\CorporateContact whereSalutation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\CorporateContact whereSincerely($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\CorporateContact whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\CorporateContact whereZip($value)
 * @mixin \Eloquent
 */
/**
 * @SWG\Definition(
 *     definition="CorporateContact",
 *     type="object",
 *     required={"contactid"},
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
 *     @SWG\Property(property="greeting", type="string"),
 *     @SWG\Property(property="sincerely", type="string"),
 *     @SWG\Property(property="contacttypeid", type="integer"),
 *     @SWG\Property(property="notes", type="string"),
 *     @SWG\Property(property="adddate", type="string", format="dateTime"),
 *     @SWG\Property(property="ip", type="string")
 * )
 */
/**
 * @SWG\Definition(
 *     definition="CorporateContact",
 *     type="object",
 * 
 * )
 */
class CorporateContact extends AbstractModel implements Resource, Repository
{
    use WithoutUpdatedTimestamp;

    /**
     * Guarded attributes
     *
     * @var array
     */
    protected $guarded = ['contactid'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'dental_fcontact';

    /**
     * The primary key for the model.
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
}
