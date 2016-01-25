<?php

namespace DentalSleepSolutions\Http\Requests;

class ClaimNoteAttachmentStore extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'note_id'  => 'required|integer',
            'filename' => 'required|string'
        ];
    }
}
