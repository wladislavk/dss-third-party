<?php

namespace DentalSleepSolutions\Http\Requests;

class ThortonUpdate extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'formid'    => 'integer',
            'patientid' => 'sometimes|required|integer',
            'snore_1'   => 'integer',
            'snore_2'   => 'integer',
            'snore_3'   => 'integer',
            'snore_4'   => 'integer',
            'snore_5'   => 'integer',
            'tot_score' => 'integer',
            'userid'    => 'sometimes|required|integer',
            'docid'     => 'sometimes|required|integer',
            'status'    => 'integer'
        ];
    }
}
