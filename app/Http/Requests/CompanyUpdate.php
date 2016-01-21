<?php

namespace DentalSleepSolutions\Http\Requests;

class CompanyUpdate extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
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
