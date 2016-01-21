<?php

namespace DentalSleepSolutions\Http\Requests;

class CustomTextUpdate extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title'        => 'sometimes|required|string',
            'description'  => 'sometimes|required|string',
            'docid'        => 'sometimes|required|integer',
            'status'       => 'sometimes|required|integer',
            'default_text' => 'integer'
        ];
    }
}
