<?php

namespace DentalSleepSolutions\Http\Requests;

class ClaimNoteStore extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'claim_id'    => 'required|integer',
            'create_type' => 'required|integer',
            'creator_id'  => 'required|integer',
            'note'        => 'required|string'
        ];
    }
}
