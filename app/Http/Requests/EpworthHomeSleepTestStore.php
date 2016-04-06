<?php

namespace DentalSleepSolutions\Http\Requests;

class EpworthHomeSleepTestStore extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'hst_id'     => 'required|integer',
            'epworth_id' => 'required|integer',
            'response'   => 'integer'
        ];
    }
}
