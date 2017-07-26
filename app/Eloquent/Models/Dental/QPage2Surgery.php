<?php

namespace DentalSleepSolutions\Eloquent\Models\Dental;

use DentalSleepSolutions\Eloquent\Models\AbstractModel;

/**
 * @SWG\Definition(
 *     definition="QPage2Surgery",
 *     type="object",
 *     required={"id"},
 *     @SWG\Property(property="id", type="integer"),
 *     @SWG\Property(property="patientid", type="integer"),
 *     @SWG\Property(property="surgery_date", type="string"),
 *     @SWG\Property(property="surgery", type="string"),
 *     @SWG\Property(property="surgeon", type="string")
 * )
 *
 * DentalSleepSolutions\Eloquent\Models\Dental\QPage2Surgery
 *
 * @property int $id
 * @property int|null $patientid
 * @property string|null $surgery_date
 * @property string|null $surgery
 * @property string|null $surgeon
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\QPage2Surgery whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\QPage2Surgery wherePatientid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\QPage2Surgery whereSurgeon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\QPage2Surgery whereSurgery($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\QPage2Surgery whereSurgeryDate($value)
 */
class QPage2Surgery extends AbstractModel
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
    protected $table = 'dental_q_page2_surgery';

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
