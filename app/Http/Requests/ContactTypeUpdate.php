<?php

namespace DentalSleepSolutions\Http\Requests;

class ContactTypeUpdate extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'contacttype' => 'sometimes|string|required',
            'description' => 'string',
            'sortby'      => 'sometimes|integer|required',
            'status'      => 'sometimes|integer|required',
            'physician'   => 'integer',
            'corporate'   => 'integer'
        ];
    }
}
