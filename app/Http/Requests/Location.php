<?php

namespace DentalSleepSolutions\Http\Requests;

class Location extends Request
{
    public function destroyRules()
    {
        return [
            // @todo Provide validation rules
        ];
    }

    public function storeRules()
    {
        return [
            'location'         => 'string',
            'docid'            => 'required|integer',
            'name'             => 'string',
            'address'          => 'string',
            'city'             => 'string',
            'state'            => 'string',
            'zip'              => 'regex:/^[0-9]{5}$/',
            'phone'            => 'regex:/^[0-9]{10}$/',
            'fax'              => 'regex:/^[0-9]{10}$/',
            'default_location' => 'boolean',
            'email'            => 'email'
        ];
    }

    public function updateRules()
    {
        return [
            'location'         => 'string',
            'docid'            => 'sometimes|required|integer',
            'name'             => 'string',
            'address'          => 'string',
            'city'             => 'string',
            'state'            => 'string',
            'zip'              => 'regex:/^[0-9]{5}$/',
            'phone'            => 'regex:/^[0-9]{10}$/',
            'fax'              => 'regex:/^[0-9]{10}$/',
            'default_location' => 'boolean',
            'email'            => 'email'
        ];
    }
}
