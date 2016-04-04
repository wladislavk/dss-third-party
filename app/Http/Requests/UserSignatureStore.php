<?php

namespace DentalSleepSolutions\Http\Requests;

class UserSignatureStore extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'user_id'        => 'required|integer',
            'signature_json' => 'required|json'
        ];
    }
}
