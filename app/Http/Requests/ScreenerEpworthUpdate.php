<?php

namespace DentalSleepSolutions\Http\Requests;

class ScreenerEpworthUpdate extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'screener_id' => 'sometimes|required|integer',
            'epworth_id'  => 'sometimes|required|integer',
            'response'    => 'sometimes|required|integer'
        ];
    }
}
