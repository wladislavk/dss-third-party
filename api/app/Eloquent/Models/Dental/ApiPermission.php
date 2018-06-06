<?php

namespace DentalSleepSolutions\Eloquent\Models\Dental;

use DentalSleepSolutions\Eloquent\Models\AbstractModel;

class ApiPermission extends AbstractModel
{
    /** @var array */
    protected $fillable = [
        'group_id',
        'doc_id',
        'patient_id',
    ];

    /** @var string */
    protected $table = 'dental_api_permissions';
}
