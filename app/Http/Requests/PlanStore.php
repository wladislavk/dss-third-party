<?php

namespace DentalSleepSolutions\Http\Requests;

class PlanStore extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'             => 'required|string',
            'monthly_fee'      => 'required|regex:/^[0-9]+\.[0-9]{1,2}$/',
            'trial_period'     => 'integer',
            'fax_fee'          => 'required|regex:/^[0-9]+\.[0-9]{1,2}$/',
            'free_fax'         => 'integer',
            'status'           => 'integer',
            'eligibility_fee'  => 'regex:/^[0-9]+\.[0-9]{1,2}$/',
            'free_eligibility' => 'integer',
            'enrollment_fee'   => 'regex:/^[0-9]+\.[0-9]{1,2}$/',
            'free_enrollment'  => 'integer',
            'claim_fee'        => 'regex:/^[0-9]+\.[0-9]{1,2}$/',
            'free_claim'       => 'integer',
            'vob_fee'          => 'regex:/^[0-9]+\.[0-9]{1,2}$/',
            'free_vob'         => 'integer',
            'office_type'      => 'integer',
            'efile_fee'        => 'regex:/^[0-9]+\.[0-9]{1,2}$/',
            'free_efile'       => 'integer',
            'duration'         => 'integer',
            'producer_fee'     => 'regex:/^[0-9]+\.[0-9]{1,2}$/',
            'user_fee'         => 'regex:/^[0-9]+\.[0-9]{1,2}$/',
            'patient_fee'      => 'regex:/^[0-9]+\.[0-9]{1,2}$/',
            'e0486_bill'       => 'integer',
            'e0486_fee'        => 'regex:/^[0-9]+\.[0-9]{1,2}$/'
        ];
    }
}
