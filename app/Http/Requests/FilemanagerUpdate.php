<?php

namespace DentalSleepSolutions\Http\Requests;

class FilemanagerUpdate extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'docid'   => 'sometimes|required|integer',
            'name'    => 'string',
            'type'    => 'string',
            'size'    => 'integer',
            'ext'     => 'string',
            'content' => 'string'
        ];
    }
}
