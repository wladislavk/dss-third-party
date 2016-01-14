<?php

namespace DentalSleepSolutions\Http\Requests;

class ClaimNoteAttachmentUpdate extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'note_id'  => 'sometimes|required|integer',
            'filename' => 'sometimes|required|string'
        ];
    }
}
