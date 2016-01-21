<?php

namespace DentalSleepSolutions\Http\Requests\Enrollments;

use DentalSleepSolutions\Http\Requests\Request;

class Create extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'user_id' => 'required|exists:dental_users,userid',
            'payer_id' => 'required',
            'transaction_type_id' => 'required|exists:dental_enrollment_transaction_type,id',
            'facility_name' => 'required',
            'provider_name' => 'required',
            'provider_id' => 'required|exists:dental_users,userid',
            'npi' => 'required',
            'state' => 'size:2',
        ];
    }
}
