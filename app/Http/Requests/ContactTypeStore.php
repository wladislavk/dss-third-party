<?php

namespace DentalSleepSolutions\Http\Requests;

class ContactTypeStore extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'contacttype' => 'string|required',
            'description' => 'string',
            'sortby'      => 'integer|required',
            'status'      => 'integer|required',
            'physician'   => 'integer',
            'corporate'   => 'integer'
        ];
    }
}
