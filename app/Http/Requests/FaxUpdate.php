<?php

namespace DentalSleepSolutions\Http\Requests;

class FaxUpdate extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'patientid'            => 'sometimes|required|integer',
            'userid'               => 'sometimes|required|integer',
            'docid'                => 'sometimes|required|integer',
            'pages'                => 'integer',
            'contactid'            => 'sometimes|required|integer',
            'to_number'            => 'string',
            'to_name'              => 'string',
            'letterid'             => 'sometimes|required|integer',
            'filename'             => 'sometimes|required|string',
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
