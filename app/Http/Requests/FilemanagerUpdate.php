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
            'name'    => ['regex:/^[A-Za-z0-9_]+\.(gif|jpg|jpeg|bmp|png)$/'],
            'type'    => 'string',
            'size'    => 'integer',
            'ext'     => ['regex:/^(gif|jpg|jpeg|bmp|png)$/']
        ];
    }
}
