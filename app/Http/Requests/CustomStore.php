<?php

namespace DentalSleepSolutions\Http\Requests;

class CustomStore extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title'        => 'required|string',
            'description'  => 'required|string',
            'docid'        => 'required|integer',
            'status'       => 'required|integer',
            'default_text' => 'integer'
        ];
    }
}
