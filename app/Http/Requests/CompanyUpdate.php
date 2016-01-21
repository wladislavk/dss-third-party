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
            'name'                  => 'sometimes|required|string',
            'add1'                  => 'sometimes|required|string',
            'add2'                  => 'string',
            'city'                  => 'sometimes|required|string',
            'state'                 => 'sometimes|required|string',
            'zip'                   => 'sometimes|required|string',
            'status'                => 'sometimes|required|integer',
            'adddate'               => 'sometimes|required|date',
            'ip_address'            => 'sometimes|required|string',
            'eligible_api_key'      => 'string',
            'stripe_secret_key'     => 'string',
            'logo'                  => 'string',
            'monthly_fee'           => 'sometimes|required|regex:/^\d*(\.\d{2})?$/',
            'default_new'           => 'integer',
            'sfax_security_context' => 'string',
            'sfax_app_id'           => 'string',
            'sfax_app_key'          => 'string',
            'sfax_init_vector'      => 'string',
            'fax_fee'               => 'sometimes|required|regex:/^\d*(\.\d{2})?$/',
            'free_fax'              => 'integer',
            'company_type'          => 'sometimes|required|integer',
            'phone'                 => 'string',
            'fax'                   => 'string',
            'email'                 => 'string',
            'plan_id'               => 'integer',
            'sfax_encryption_key'   => 'string',
            'use_support'           => 'sometimes|required|integer',
            'exclusive'             => 'sometimes|required|integer',
            'vob_require_test'      => 'sometimes|required|integer'
        ];
    }
}