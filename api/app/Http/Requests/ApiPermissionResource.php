<?php

namespace DentalSleepSolutions\Http\Requests;

class ApiPermissionResource extends Request
{
    protected $rules = [
        'group_id' => 'required|integer',
        'slug' => 'required|string|unique:dental_api_permission_resources',
        'route' => 'required|string|unique:dental_api_permission_resources',
    ];
}
