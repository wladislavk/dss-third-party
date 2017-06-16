<?php

namespace DentalSleepSolutions\Http\Requests;

class Company extends Request
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
            'name'             => 'string',
            'city'             => 'string',
            'state'            => 'string',
            'zip'              => 'integer',
            'status'           => 'integer',
            'default_new'      => 'integer',
            'free_fax'         => 'integer',
            'company_type'     => 'integer',
            'plan_id'          => 'integer',
            'use_support'      => 'integer',
            'exclusive'        => 'integer',
            'vob_require_test' => 'integer'
        ];
    }

    public function updateRules()
    {
        return [
            'name'             => 'string',
            'city'             => 'string',
            'state'            => 'string',
            'zip'              => 'integer',
            'status'           => 'integer',
            'default_new'      => 'integer',
            'free_fax'         => 'integer',
            'company_type'     => 'integer',
            'plan_id'          => 'integer',
            'use_support'      => 'integer',
            'exclusive'        => 'integer',
            'vob_require_test' => 'integer'
        ];
    }
}
