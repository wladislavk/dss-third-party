<?php

namespace DentalSleepSolutions\Eloquent\Models\Dental;

use DentalSleepSolutions\Eloquent\Models\AbstractModel;
use DentalSleepSolutions\Eloquent\Traits\WithoutUpdatedTimestamp;

/**
 * @SWG\Definition(
 *     definition="Task",
 *     type="object",
 *     required={"id"},
 *     @SWG\Property(property="id", type="integer"),
 *     @SWG\Property(property="task", type="string"),
 *     @SWG\Property(property="description", type="string"),
 *     @SWG\Property(property="userid", type="integer"),
 *     @SWG\Property(property="responsibleid", type="integer"),
 *     @SWG\Property(property="status", type="integer"),
 *     @SWG\Property(property="due_date", type="string"),
 *     @SWG\Property(property="recurring", type="integer"),
 *     @SWG\Property(property="recurring_unit", type="integer"),
 *     @SWG\Property(property="adddate", type="string", format="dateTime"),
 *     @SWG\Property(property="ip_address", type="string"),
 *     @SWG\Property(property="patientid", type="integer")
 * )
 *
 * DentalSleepSolutions\Eloquent\Dental\Task
 *
 * @property int $id
 * @property string|null $task
 * @property string|null $description
 * @property int|null $userid
 * @property int|null $responsibleid
 * @property int|null $status
 * @property string|null $due_date
 * @property int|null $recurring
 * @property int|null $recurring_unit
 * @property \Carbon\Carbon|null $adddate
 * @property string|null $ip_address
 * @property int|null $patientid
 * @mixin \Eloquent
 */
class Task extends AbstractModel
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
    protected $table = 'dental_task';

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
