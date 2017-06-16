<?php

namespace DentalSleepSolutions\Http\Requests;

class LoginDetail extends Request
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
            'loginid'  => 'integer',
            'userid'   => 'integer',
            'cur_page' => 'required|string'
        ];
    }

    public function updateRules()
    {
        return [
            'loginid'  => 'sometimes|required|integer',
            'userid'   => 'sometimes|required|integer',
            'cur_page' => 'sometimes|required|string'
        ];
    }
}
