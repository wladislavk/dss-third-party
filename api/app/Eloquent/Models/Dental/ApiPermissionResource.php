<?php

namespace DentalSleepSolutions\Eloquent\Models\Dental;

use DentalSleepSolutions\Eloquent\Models\AbstractModel;

class ApiPermissionResource extends AbstractModel
{
    /** @var array */
    protected $fillable = [
        'group_id',
        'slug',
        'route',
        'created_by',
        'updated_by',
    ];

    /** @var string */
    protected $table = 'dental_api_permission_resources';
}
