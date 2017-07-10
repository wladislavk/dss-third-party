<?php

namespace DentalSleepSolutions\Eloquent\Dental;

use DentalSleepSolutions\Eloquent\AbstractModel;
use DentalSleepSolutions\Contracts\Resources\AppointmentType as Resource;
use DentalSleepSolutions\Contracts\Repositories\AppointmentTypes as Repository;

/**
 * @SWG\Definition(
 *     definition="AppointmentType",
 *     type="object",
 *     required={"id"},
 *     @SWG\Property(property="id", type="integer"),
 *     @SWG\Property(property="name", type="string"),
 *     @SWG\Property(property="color", type="string"),
 *     @SWG\Property(property="classname", type="string"),
 *     @SWG\Property(property="docid", type="integer")
 * )
 *
 * DentalSleepSolutions\Eloquent\Dental\AppointmentType
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $color
 * @property string|null $classname
 * @property int|null $docid
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\AppointmentType whereClassname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\AppointmentType whereColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\AppointmentType whereDocid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\AppointmentType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\AppointmentType whereName($value)
 * @mixin \Eloquent
 */
class AppointmentType extends AbstractModel implements Resource, Repository
{
    /**
     * Mass assignable attributes
     *
     * @var array
     */
    protected $fillable = ['name', 'color', 'classname', 'docid'];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'dental_appt_types';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Primary key for the table
     *
     * @var string
     */
    protected $primaryKey = 'id';
}
