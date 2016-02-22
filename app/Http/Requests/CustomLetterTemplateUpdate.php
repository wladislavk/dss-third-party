<?php

namespace DentalSleepSolutions\Http\Requests;

class CustomLetterTemplateUpdate extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'   => 'sometimes|required|string',
            'body'   => 'string',
            'docid'  => 'sometimes|required|integer',
            'status' => 'integer'
        ];
    }
}
