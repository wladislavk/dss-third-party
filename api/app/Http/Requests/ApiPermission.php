<?php

namespace DentalSleepSolutions\Http\Requests;

class ApiPermission extends Request
{
    protected $rules = [
        'group_id' => 'required|integer',
        'doc_id' => 'required|integer',
        'patient_id' => 'sometimes|nullable|integer',
    ];
}
