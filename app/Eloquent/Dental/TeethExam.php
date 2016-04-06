<?php

namespace DentalSleepSolutions\Eloquent\Dental;

use Illuminate\Database\Eloquent\Model;
use DentalSleepSolutions\Eloquent\WithoutUpdatedTimestamp;
use DentalSleepSolutions\Contracts\Resources\TeethExam as Resource;
use DentalSleepSolutions\Contracts\Repositories\TeethExams as Repository;

class TeethExam extends Model implements Resource, Repository
{
    use WithoutUpdatedTimestamp;

    /**
     * Guarded attributes
     *
     * @var array
     */
    protected $guarded = ['exam_teethid'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'dental_exam_teeth';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'exam_teethid';

    /**
     * The name of the "created at" column.
     *
     * @var string
     */
    const CREATED_AT = 'adddate';
}
