<?php

namespace DentalSleepSolutions\Http\Requests;

class ScreenerEpworthStore extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'screener_id' => 'required|integer',
            'epworth_id'  => 'required|integer',
            'response'    => 'required|integer'
        ];
    }
}
