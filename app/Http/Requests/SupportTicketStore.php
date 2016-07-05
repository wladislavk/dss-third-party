<?php

namespace DentalSleepSolutions\Http\Requests;

class SupportTicketStore extends Request
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
}
