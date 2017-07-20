<?php

namespace DentalSleepSolutions\Eloquent\Models\Dental;

use DentalSleepSolutions\Eloquent\Models\AbstractModel;
use DentalSleepSolutions\Contracts\Resources\Resource;

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
 * @mixin \Eloquent
 */
class AppointmentType extends AbstractModel implements Resource
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
