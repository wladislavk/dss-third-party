<?php

namespace DentalSleepSolutions\Eloquent\Models\Dental;

use DentalSleepSolutions\Eloquent\Models\AbstractModel;
use DentalSleepSolutions\Eloquent\Traits\WithoutUpdatedTimestamp;
use DentalSleepSolutions\Contracts\Resources\Resource;

class DentalClinicalExam extends AbstractModel implements Resource
{
    use WithoutUpdatedTimestamp;

    /**
     * Mass assignable attributes
     *
     * @var array
     */
    protected $fillable = [
        'formid', 'patientid', 'exam_teeth', 'other_exam_teeth', 'caries',
        'where_facets', 'cracked_fractured', 'old_worn_inadequate_restorations',
        'dental_class_right', 'dental_division_right', 'dental_class_left',
        'dental_division_left', 'additional_paragraph', 'initial_tooth',
        'open_proximal', 'deistema', 'userid', 'docid', 'status', 'adddate',
        'ip_address', 'missing', 'crossbite'
    ];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'dental_ex_page4';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'ex_page4id';

    /**
     * The name of the "created at" column.
     *
     * @var string
     */
    const CREATED_AT = 'adddate';
}
