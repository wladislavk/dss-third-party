<?php

namespace DentalSleepSolutions\Http\Requests;

class FaxStore extends AbstractStoreRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'patientid'            => 'required|integer',
            'userid'               => 'required|integer',
            'docid'                => 'required|integer',
            'pages'                => 'integer',
            'contactid'            => 'required|integer',
            'to_number'            => 'string',
            'to_name'              => 'string',
            'letterid'             => 'required|integer',
            'filename'             => 'required|string',
            'status'               => 'integer',
            'fax_invoice_id'       => 'integer',
            'sfax_transmission_id' => 'string',
            'sfax_completed'       => 'boolean',
            'sfax_response'        => 'string',
            'sfax_status'          => 'integer',
            'sfax_error_code'      => 'string',
            'letter_body'          => 'string',
            'viewed'               => 'boolean'
        ];
    }
}
