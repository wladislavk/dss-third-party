<?php
namespace DentalSleepSolutions\Http\Requests;

use DentalSleepSolutions\Http\Requests\Request;

class UpdateClaimNoteAttachmentRequest extends Request
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
