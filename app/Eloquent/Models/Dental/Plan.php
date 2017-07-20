<?php

namespace DentalSleepSolutions\Eloquent\Models\Dental;

use DentalSleepSolutions\Eloquent\Models\AbstractModel;
use DentalSleepSolutions\Eloquent\Traits\WithoutUpdatedTimestamp;
use DentalSleepSolutions\Contracts\Resources\Resource;

/**
 * @SWG\Definition(
 *     definition="Plan",
 *     type="object",
 *     required={"id"},
 *     @SWG\Property(property="id", type="integer"),
 *     @SWG\Property(property="name", type="string"),
 *     @SWG\Property(property="monthly_fee", type="float"),
 *     @SWG\Property(property="trial_period", type="integer"),
 *     @SWG\Property(property="fax_fee", type="float"),
 *     @SWG\Property(property="free_fax", type="integer"),
 *     @SWG\Property(property="status", type="integer"),
 *     @SWG\Property(property="adddate", type="string", format="dateTime"),
 *     @SWG\Property(property="ip_address", type="string"),
 *     @SWG\Property(property="eligibility_fee", type="float"),
 *     @SWG\Property(property="free_eligibility", type="integer"),
 *     @SWG\Property(property="enrollment_fee", type="float"),
 *     @SWG\Property(property="free_enrollment", type="integer"),
 *     @SWG\Property(property="claim_fee", type="float"),
 *     @SWG\Property(property="free_claim", type="integer"),
 *     @SWG\Property(property="vob_fee", type="float"),
 *     @SWG\Property(property="free_vob", type="integer"),
 *     @SWG\Property(property="office_type", type="integer"),
 *     @SWG\Property(property="efile_fee", type="float"),
 *     @SWG\Property(property="free_efile", type="integer"),
 *     @SWG\Property(property="duration", type="integer"),
 *     @SWG\Property(property="producer_fee", type="float"),
 *     @SWG\Property(property="user_fee", type="float"),
 *     @SWG\Property(property="patient_fee", type="float"),
 *     @SWG\Property(property="e0486_bill", type="integer"),
 *     @SWG\Property(property="e0486_fee", type="float")
 * )
 *
 * DentalSleepSolutions\Eloquent\Dental\Plan
 *
 * @property int $id
 * @property string|null $name
 * @property float|null $monthly_fee
 * @property int|null $trial_period
 * @property float|null $fax_fee
 * @property int|null $free_fax
 * @property int|null $status
 * @property \Carbon\Carbon|null $adddate
 * @property string|null $ip_address
 * @property float|null $eligibility_fee
 * @property int|null $free_eligibility
 * @property float|null $enrollment_fee
 * @property int|null $free_enrollment
 * @property float|null $claim_fee
 * @property int|null $free_claim
 * @property float|null $vob_fee
 * @property int|null $free_vob
 * @property int|null $office_type
 * @property float|null $efile_fee
 * @property int|null $free_efile
 * @property int|null $duration
 * @property float|null $producer_fee
 * @property float|null $user_fee
 * @property float|null $patient_fee
 * @property int|null $e0486_bill
 * @property float|null $e0486_fee
 * @mixin \Eloquent
 */
class Plan extends AbstractModel implements Resource
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
    protected $table = 'dental_plans';

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
}
