<?php

namespace DentalSleepSolutions\Eloquent\Models\Dental;

use DentalSleepSolutions\Eloquent\Models\AbstractModel;
use DentalSleepSolutions\Eloquent\Traits\WithoutCreatedTimestamp;
use DentalSleepSolutions\Eloquent\Traits\WithoutUpdatedTimestamp;

/**
 * @SWG\Definition(
 *     definition="DoctorPalpation",
 *     type="object",
 *     required={"id"},
 *     @SWG\Property(property="id", type="integer"),
 *     @SWG\Property(property="doc_id", type="integer"),
 *     @SWG\Property(property="updated_by_user", type="integer"),
 *     @SWG\Property(property="updated_by_admin", type="integer"),
 *     @SWG\Property(property="ip_address", type="string"),
 *     @SWG\Property(property="palpationid", type="integer"),
 *     @SWG\Property(property="sortby", type="integer")
 * )
 *
 * DentalSleepSolutions\Eloquent\Dental\DoctorPalpation
 *
 * @property int $id
 * @property int|null $doc_id
 * @property int|null $updated_by_user
 * @property int|null $updated_by_admin
 * @property string|null $ip_address
 * @property int|null $palpationid
 * @property int|null $sortby
 * @mixin \Eloquent
 */
class DoctorPalpation extends AbstractModel
{
    use WithoutCreatedTimestamp;
    use WithoutUpdatedTimestamp;

    /**
     * Mass assignable attributes
     *
     * @var array
     */
    protected $fillable = [
        'palpationid',
        'doc_id',
        'sortby',
    ];

    /**
     * Guarded attributes
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'dental_doctor_palpations';
}
