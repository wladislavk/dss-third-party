<?php

namespace DentalSleepSolutions\Http\Requests;

class LoginStore extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'docid'       => 'required|integer',
            'userid'      => 'required|integer',
            'login_date'  => 'date',
            'logout_date' => 'date'
        ];
    }
}
