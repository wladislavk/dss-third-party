<?php

namespace DentalSleepSolutions\Http\Requests;

class ClaimNoteAttachment extends Request
{
    protected $rules = [
        'note_id'  => 'required|integer',
        'filename' => 'required|string',
    ];
}
