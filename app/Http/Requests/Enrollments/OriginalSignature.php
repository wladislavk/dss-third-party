<?php

namespace DentalSleepSolutions\Http\Requests\Enrollments;

use DentalSleepSolutions\Http\Requests\Request;

class OriginalSignature extends Request
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
            'npi' => 'required|integer',
        ];
    }
}
