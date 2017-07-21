<?php

namespace DentalSleepSolutions\Eloquent\Models\Dental;

use DentalSleepSolutions\Eloquent\Models\AbstractModel;
use DB;

/**
 * @SWG\Definition(
 *     definition="PatientInsurance",
 *     type="object",
 *     required={"id"},
 *     @SWG\Property(property="id", type="integer"),
 *     @SWG\Property(property="patientid", type="integer"),
 *     @SWG\Property(property="insurancetype", type="integer"),
 *     @SWG\Property(property="company", type="string"),
 *     @SWG\Property(property="address1", type="string"),
 *     @SWG\Property(property="address2", type="string"),
 *     @SWG\Property(property="city", type="string"),
 *     @SWG\Property(property="state", type="string"),
 *     @SWG\Property(property="zip", type="string"),
 *     @SWG\Property(property="phone", type="string"),
 *     @SWG\Property(property="fax", type="string"),
 *     @SWG\Property(property="email", type="string")
 * )
 *
 * DentalSleepSolutions\Eloquent\Dental\PatientInsurance
 *
 * @property int $id
 * @property int|null $patientid
 * @property int|null $insurancetype
 * @property string|null $company
 * @property string|null $address1
 * @property string|null $address2
 * @property string|null $city
 * @property string|null $state
 * @property string|null $zip
 * @property string|null $phone
 * @property string|null $fax
 * @property string|null $email
 * @mixin \Eloquent
 */
class PatientInsurance extends AbstractModel
{
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
    protected $table = 'dental_patient_insurance';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}
