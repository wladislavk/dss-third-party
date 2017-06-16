<?php

namespace DentalSleepSolutions\Http\Requests;

class SupportTicket extends Request
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
            'title'       => 'string',
            'userid'      => 'required|integer',
            'docid'       => 'required|integer',
            'body'        => 'string',
            'category_id' => 'required|integer',
            'status'      => 'integer',
            'attachment'  => 'string',
            'viewed'      => 'boolean',
            'creator_id'  => 'integer',
            'create_type' => 'integer',
            'company_id'  => 'integer'
        ];
    }

    public function updateRules()
    {
        return [
            'title'       => 'string',
            'userid'      => 'sometimes|required|integer',
            'docid'       => 'sometimes|required|integer',
            'body'        => 'string',
            'category_id' => 'sometimes|required|integer',
            'status'      => 'integer',
            'attachment'  => 'string',
            'viewed'      => 'boolean',
            'creator_id'  => 'integer',
            'create_type' => 'integer',
            'company_id'  => 'integer'
        ];
    }
}
