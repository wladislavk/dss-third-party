<?php
namespace DentalSleepSolutions\Http\Requests;

use DentalSleepSolutions\Http\Requests\Request;

class StoreClaimNoteRequest extends Request
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
