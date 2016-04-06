<?php

namespace DentalSleepSolutions\Http\Requests;

class EpworthHomeSleepTestUpdate extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'hst_id'     => 'sometimes|required|integer',
            'epworth_id' => 'sometimes|required|integer',
            'response'   => 'integer'
        ];
    }
}
