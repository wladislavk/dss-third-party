<?php

namespace DentalSleepSolutions\Http\Requests;

class ApiPermissionResourceGroup extends Request
{
    protected $rules = [
        'slug' => 'required|string|unique:dental_api_permission_resource_groups',
        'name' => 'required|string',
        'authorize_per_user' => 'required|bool',
        'authorize_per_patient' => 'required|bool',
    ];
}
