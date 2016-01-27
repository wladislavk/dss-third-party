<?php

namespace DentalSleepSolutions\Http\Requests;

class DocumentStore extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'categoryid' => 'required|integer',
            'name'       => 'required|string',
            'filename'   => 'required|string'
        ];
    }
}
