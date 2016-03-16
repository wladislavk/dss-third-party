<?php

namespace DentalSleepSolutions\Http\Requests;

class ChairUpdate extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'  => 'sometimes|required|string',
            'rank'  => 'integer',
            'docid' => 'sometimes|required|integer'
        ];
    }
}
