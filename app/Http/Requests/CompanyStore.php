<?php

namespace DentalSleepSolutions\Http\Requests;

class CompanyStore extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'                  => 'required|string',
            'add1'                  => 'required|string',
            'add2'                  => 'string',
            'city'                  => 'required|string',
            'state'                 => 'required|string',
            'zip'                   => 'required|string',
            'status'                => 'required|integer',
            'adddate'               => 'required|date',
            'ip_address'            => 'required|string',
            'eligible_api_key'      => 'string',
            'stripe_secret_key'     => 'string',
            'logo'                  => 'string',
            'monthly_fee'           => 'required|regex:/^\d*(\.\d{2})?$/',
            'default_new'           => 'integer',
            'sfax_security_context' => 'string',
            'sfax_app_id'           => 'string',
            'sfax_app_key'          => 'string',
            'sfax_init_vector'      => 'string',
            'fax_fee'               => 'required|regex:/^\d*(\.\d{2})?$/',
            'free_fax'              => 'integer',
            'company_type'          => 'required|integer',
            'phone'                 => 'string',
            'fax'                   => 'string',
            'email'                 => 'string',
            'plan_id'               => 'integer',
            'sfax_encryption_key'   => 'string',
            'use_support'           => 'required|integer',
            'exclusive'             => 'required|integer',
            'vob_require_test'      => 'required|integer'
        ];
    }
}