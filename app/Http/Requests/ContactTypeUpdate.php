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
            'contacttype' => 'sometimes|required|string',
            'description' => 'string',
            'sortby'      => 'integer',
            'status'      => 'integer',
            'physician'   => 'integer',
            'corporate'   => 'integer'
        ];
    }
}
