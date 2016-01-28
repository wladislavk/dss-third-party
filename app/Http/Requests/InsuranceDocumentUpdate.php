<?php

namespace DentalSleepSolutions\Http\Requests;

class InsuranceDocumentUpdate extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title'       => 'sometimes|required|string',
            'description' => 'sometimes|required|string',
            'video_file'  => 'string',
            'doc_file'    => 'string',
            'sortby'      => 'integer',
            'status'      => 'integer',
            'docid'       => 'string'
        ];
    }
}
