<?php

namespace DentalSleepSolutions\Eloquent\Dental;

use DentalSleepSolutions\Eloquent\AbstractModel;
use DentalSleepSolutions\EloquentTraits\WithoutUpdatedTimestamp;

/**
 * @SWG\Definition(
 *     definition="InsuranceStatusHistory",
 *     type="object",
 *     required={"id"},
 *     @SWG\Property(property="id", type="integer"),
 *     @SWG\Property(property="insuranceid", type="integer"),
 *     @SWG\Property(property="status", type="integer"),
 *     @SWG\Property(property="userid", type="integer"),
 *     @SWG\Property(property="adddate", type="string", format="dateTime"),
 *     @SWG\Property(property="ip_address", type="string"),
 *     @SWG\Property(property="adminid", type="integer")
 * )
 *
 * DentalSleepSolutions\Eloquent\Dental\InsuranceStatusHistory
 *
 * @property int $id
 * @property int|null $insuranceid
 * @property int|null $status
 * @property int|null $userid
 * @property \Carbon\Carbon|null $adddate
 * @property string|null $ip_address
 * @property int|null $adminid
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceStatusHistory whereAdddate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceStatusHistory whereAdminid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceStatusHistory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceStatusHistory whereInsuranceid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceStatusHistory whereIpAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceStatusHistory whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceStatusHistory whereUserid($value)
 * @mixin \Eloquent
 */
class InsuranceStatusHistory extends AbstractModel
{
    use WithoutUpdatedTimestamp;

    /**
     * Mass assignable attributes
     *
     * @var array
     */
    protected $fillable = [
        'insuranceid', 'status', 'userid', 'adddate', 'ip_address', 'adminid'
    ];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'dental_insurance_status_history';

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
