<?php

namespace DentalSleepSolutions\Http\Requests;

class UserSignatureUpdate extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'user_id'        => 'sometimes|required|integer',
            'signature_json' => 'sometimes|required|json'
        ];
    }
}
