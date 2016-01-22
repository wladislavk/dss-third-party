<?php

namespace DentalSleepSolutions\Http\Requests;

class AdminUpdate extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'         => 'max:250',
            'username'     => 'sometimes|required|max:250|unique:admin',
            'password'     => 'sometimes|required|max:250',
            'status'       => 'integer',
            'admin_access' => 'integer',
            'email'        => 'email|max:100',
            'first_name'   => 'string|max:50',
            'last_name'    => 'string|max:50'
        ];
    }
}
