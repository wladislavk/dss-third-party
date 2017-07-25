<?php

namespace DentalSleepSolutions\Http\Requests\Enrollments;

use DentalSleepSolutions\Http\Requests\AbstractNonRestRequest;

class OriginalSignature extends AbstractNonRestRequest
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
            'reference_id' => 'required|exists:dental_eligible_enrollment,reference_id',
            'original_signature' => 'required|mimes:pdf',
            'npi' => 'required',
        ];
    }

    /**
     * @todo: check how to implement authorization properly for API tests that do not use middleware
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
