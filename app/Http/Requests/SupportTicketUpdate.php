<?php

namespace DentalSleepSolutions\Http\Requests;

class SupportTicketUpdate extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
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
