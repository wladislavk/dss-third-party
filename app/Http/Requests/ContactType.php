<?php

namespace DentalSleepSolutions\Http\Requests;

class ContactType extends Request
{
    public function destroyRules()
    {
        return [
            // @todo Provide validation rules
        ];
    }

    public function storeRules()
    {
        return [
            'contacttype' => 'required|string',
            'description' => 'string',
            'sortby'      => 'integer',
            'status'      => 'integer',
            'physician'   => 'integer',
            'corporate'   => 'integer'
        ];
    }

    public function updateRules()
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
