<?php

namespace DentalSleepSolutions\Http\Requests;

class CustomLetterTemplateStore extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'   => 'required|string',
            'body'   => 'string',
            'docid'  => 'required|integer',
            'status' => 'integer'
        ];
    }
}
