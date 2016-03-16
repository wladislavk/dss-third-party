<?php

namespace DentalSleepSolutions\Http\Requests;

class ChairStore extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'  => 'required|string',
            'rank'  => 'integer',
            'docid' => 'required|integer'
        ];
    }
}
