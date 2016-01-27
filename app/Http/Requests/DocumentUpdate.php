<?php

namespace DentalSleepSolutions\Http\Requests;

class DocumentUpdate extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'categoryid' => 'sometimes|required|integer',
            'name'       => 'sometimes|required|string',
            'filename'   => 'sometimes|required|string'
        ];
    }
}
