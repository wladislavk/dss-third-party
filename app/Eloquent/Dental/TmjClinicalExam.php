<?php

namespace DentalSleepSolutions\Eloquent\Dental;

use Illuminate\Database\Eloquent\Model;
use DentalSleepSolutions\Eloquent\WithoutUpdatedTimestamp;
use DentalSleepSolutions\Contracts\Resources\TmjClinicalExam as Resource;
use DentalSleepSolutions\Contracts\Repositories\TmjClinicalExams as Repository;

class TmjClinicalExam extends Model implements Resource, Repository
{
    use WithoutUpdatedTimestamp;

    /**
     * Mass assignable attributes
     *
     * @var array
     */
    protected $fillable = [
        'formid', 'patientid', 'palpationid', 'palpationRid',
        'additional_paragraph_pal', 'joint_exam', 'jointid',
        'i_opening_from', 'i_opening_to', 'i_opening_equal',
        'protrusion_from', 'protrusion_to', 'protrusion_equal',
        'l_lateral_from', 'l_lateral_to', 'l_lateral_equal',
        'r_lateral_from', 'r_lateral_to', 'r_lateral_equal',
        'deviation_from', 'deviation_to', 'deviation_equal',
        'deflection_from', 'deflection_to', 'deflection_equal',
        'range_normal', 'normal', 'other_range_motion',
        'additional_paragraph_rm', 'screening_aware',
        'screening_normal', 'userid', 'docid', 'status',
        'adddate', 'ip_address', 'deviation_r_l', 'deflection_r_l',
        'dentaldevice', 'dentaldevice_date'
    ];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'dental_ex_page5';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'ex_page5id';

    /**
     * The name of the "created at" column.
     *
     * @var string
     */
    const CREATED_AT = 'adddate';
}
