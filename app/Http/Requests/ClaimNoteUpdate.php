<?php

namespace DentalSleepSolutions\Http\Requests;

class ClaimNoteUpdate extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'claim_id'    => 'sometimes|required|integer',
            'create_type' => 'sometimes|required|integer',
            'creator_id'  => 'sometimes|required|integer',
            'note'        => 'sometimes|required|string'
        ];
    }
}
