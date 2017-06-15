<?php

namespace DentalSleepSolutions\Http\Requests;

class InsuranceDocumentStore extends AbstractStoreRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title'       => 'required|string',
            'description' => 'required|string',
            'video_file'  => 'string',
            'doc_file'    => 'string',
            'sortby'      => 'integer',
            'status'      => 'integer',
            'docid'       => 'string'
        ];
    }
}
