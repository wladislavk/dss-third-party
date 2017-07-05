<?php

namespace DentalSleepSolutions\Eloquent\Dental;

use DentalSleepSolutions\Eloquent\AbstractModel;
use DentalSleepSolutions\EloquentTraits\WithoutUpdatedTimestamp;
use DentalSleepSolutions\Contracts\Resources\PatientContact as Resource;
use DentalSleepSolutions\Contracts\Repositories\PatientContacts as Repository;
use DB;

/**
 * @SWG\Definition(
 *     definition="PatientContact",
 *     type="object",
 *     required={"id"},
 *     @SWG\Property(property="id", type="integer"),
 *     @SWG\Property(property="contacttype", type="integer"),
 *     @SWG\Property(property="patientid", type="integer"),
 *     @SWG\Property(property="firstname", type="string"),
 *     @SWG\Property(property="lastname", type="string"),
 *     @SWG\Property(property="address1", type="string"),
 *     @SWG\Property(property="address2", type="string"),
 *     @SWG\Property(property="city", type="string"),
 *     @SWG\Property(property="state", type="string"),
 *     @SWG\Property(property="zip", type="string"),
 *     @SWG\Property(property="phone", type="string"),
 *     @SWG\Property(property="adddate", type="string", format="dateTime"),
 *     @SWG\Property(property="ip", type="string")
 * )
 *
 * DentalSleepSolutions\Eloquent\Dental\PatientContact
 *
 * @property int $id
 * @property int|null $contacttype
 * @property int|null $patientid
 * @property string|null $firstname
 * @property string|null $lastname
 * @property string|null $address1
 * @property string|null $address2
 * @property string|null $city
 * @property string|null $state
 * @property string|null $zip
 * @property string|null $phone
 * @property \Carbon\Carbon|null $adddate
 * @property string|null $ip_address
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\PatientContact whereAdddate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\PatientContact whereAddress1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\PatientContact whereAddress2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\PatientContact whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\PatientContact whereContacttype($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\PatientContact whereFirstname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\PatientContact whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\PatientContact whereIpAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\PatientContact whereLastname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\PatientContact wherePatientid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\PatientContact wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\PatientContact whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\PatientContact whereZip($value)
 * @mixin \Eloquent
 */
/**
 * @SWG\Definition(
 *     definition="PatientContact",
 *     type="object",
 *     required={"id"},
 *     @SWG\Property(property="id", type="integer"),
 *     @SWG\Property(property="contacttype", type="integer"),
 *     @SWG\Property(property="patientid", type="integer"),
 *     @SWG\Property(property="firstname", type="string"),
 *     @SWG\Property(property="lastname", type="string"),
 *     @SWG\Property(property="address1", type="string"),
 *     @SWG\Property(property="address2", type="string"),
 *     @SWG\Property(property="city", type="string"),
 *     @SWG\Property(property="state", type="string"),
 *     @SWG\Property(property="zip", type="string"),
 *     @SWG\Property(property="phone", type="string"),
 *     @SWG\Property(property="adddate", type="string", format="dateTime"),
 *     @SWG\Property(property="ip", type="string")
 * )
 */
class PatientContact extends AbstractModel implements Resource, Repository
{
    use WithoutUpdatedTimestamp;

    /**
     * Guarded attributes
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'dental_patient_contacts';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * The name of the "created at" column.
     *
     * @var string
     */
    const CREATED_AT = 'adddate';

    public function getCurrent($docId = 0, $patientId = 0)
    {
        return $this->from(DB::raw('dental_patient_contacts pc'))
            ->select(DB::raw('pc.id, pc.contacttype, pc.firstname, pc.lastname, pc.address1,'
                . 'pc.address2, pc.city, pc.state, pc.zip, pc.phone, p.firstname as patfirstname,'
                . 'p.lastname as patlastname'))
            ->join(DB::raw('dental_patients p'), 'pc.patientid', '=', 'p.patientid')
            ->where('p.docid', $docId)
            ->where('p.patientid', $patientId)
            ->get();
    }

    public function getNumber($docId = 0)
    {
        return $this->select(DB::raw('COUNT(id) AS total'))
            ->from(DB::raw('dental_patient_contacts pc'))
            ->join(DB::raw('dental_patients p'), 'p.patientid', '=', 'pc.patientid')
            ->where('p.docid', $docId)
            ->first();
    }
}
