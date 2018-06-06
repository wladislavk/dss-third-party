<?php

namespace DentalSleepSolutions\Eloquent\Models\Dental;

use DentalSleepSolutions\Eloquent\Models\AbstractModel;

class ApiPermissionResourceGroup extends AbstractModel
{
    /** @var array */
    protected $fillable = [
        'slug',
        'name',
        'authorize_per_user',
        'authorize_per_patient',
        'created_by',
        'updated_by',
    ];

    /** @var string */
    protected $table = 'dental_api_permission_resource_groups';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function resources()
    {
        return $this->hasMany(ApiPermissionResource::class, 'group_id', 'id');
    }
}
