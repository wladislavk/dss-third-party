<?php

namespace DentalSleepSolutions\Http\Requests;

class LoginUpdate extends AbstractUpdateRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'docid'       => 'sometimes|required|integer',
            'userid'      => 'sometimes|required|integer',
            'login_date'  => 'date',
            'logout_date' => 'date'

        ];
    }
}
