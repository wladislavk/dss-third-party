<?php

namespace DentalSleepSolutions\Http\Requests;

class LoginDetailStore extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'loginid'  => 'required|integer',
            'userid'   => 'required|integer',
            'cur_page' => 'required|string'
        ];
    }
}
