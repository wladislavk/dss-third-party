<?php

namespace DentalSleepSolutions\Http\Requests;

class Login extends Request
{
    public function destroyRules()
    {
        return [
            // @todo Provide validation rules
        ];
    }

    public function storeRules()
    {
        return [
            'docid'       => 'required|integer',
            'userid'      => 'required|integer',
            'login_date'  => 'date',
            'logout_date' => 'date'
        ];
    }

    public function updateRules()
    {
        return [
            'docid'       => 'sometimes|required|integer',
            'userid'      => 'sometimes|required|integer',
            'login_date'  => 'date',
            'logout_date' => 'date'
        ];
    }
}
